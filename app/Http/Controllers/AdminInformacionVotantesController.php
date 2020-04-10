<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminInformacionVotantesController extends \crocodicstudio\crudbooster\controllers\CBController {
		
		
		private $total_censo;
		private $censo_hombres;
		private $mujeres_hombres;

		public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "info_votantes";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Tipo Documento","name"=>"tipo_documento"];
			$this->col[] = ["label"=>"Numero","name"=>"numero"];
			$this->col[] = ["label"=>"Nombres","name"=>"nombres"];
			$this->col[] = ["label"=>"Apellidos","name"=>"apellidos"];
			$this->col[] = ["label"=>"Telefono","name"=>"telefono"];
			$this->col[] = ["label"=>"Puesto Votación","name"=>"puesto_votacion_id","join"=>"puestos_votacion,nombre_puesto"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Tipo Documento','name'=>'tipo_documento','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>'true','value'=>'CC'];
			$this->form[] = ['label'=>'Numero','name'=>'numero','type'=>'number','validation'=>'required|integer','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nombres','name'=>'nombres','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Apellidos','name'=>'apellidos','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Sexo','name'=>'sexo','type'=>'select','validation'=>'min:1|max:255','width'=>'col-sm-10','dataenum'=>'F;M;I'];
			$this->form[] = ['label'=>'Fecha Nacimiento','name'=>'fecha_nacimiento','type'=>'date','validation'=>'required|min:1|max:255|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Teléfono','name'=>'telefono','type'=>'text','validation'=>'integer','width'=>'col-sm-10','placeholder'=>'Celular'];
			$this->form[] = ['label'=>'Referido','name'=>'referido_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'cms_users,name','datatable_ajax'=>'true'];
			$this->form[] = ['label'=>'Correo Electrónico','name'=>'correo_electronico','type'=>'email','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Dirección Residencia','name'=>'direccion_residencia','type'=>'text','validation'=>'string','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Barrio','name'=>'barrio_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'barrios,descripcion','datatable_where'=>'ciudad_id = 76834','datatable_ajax'=>'true'];
			$this->form[] = ['label'=>'Puesto votación','name'=>'puesto_votacion_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'puestos_votacion,nombre_puesto','datatable_where'=>'ciudad_id = 76834'];
			$this->form[] = ['label'=>'Mesa','name'=>'mesa_votacion','type'=>'text','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Tipo Documento','name'=>'tipo_documento','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>'true','value'=>'CC'];
			//$this->form[] = ['label'=>'Numero','name'=>'numero','type'=>'number','validation'=>'required|integer','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nombres','name'=>'nombres','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Apellidos','name'=>'apellidos','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Sexo','name'=>'sexo','type'=>'select','validation'=>'min:1|max:255','width'=>'col-sm-10','dataenum'=>'F;M;I'];
			//$this->form[] = ['label'=>'Fecha Nacimiento','name'=>'fecha_nacimiento','type'=>'date','validation'=>'required|min:1|max:255|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Teléfono','name'=>'telefono','type'=>'text','validation'=>'integer','width'=>'col-sm-10','placeholder'=>'Celular'];
			//$this->form[] = ['label'=>'Referido','name'=>'referido_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'info_votantes,nombres,apellidos;cms_users,name','datatable_ajax'=>'true'];
			//$this->form[] = ['label'=>'Correo Electrónico','name'=>'correo_electronico','type'=>'email','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Dirección Residencia','name'=>'direccion_residencia','type'=>'text','validation'=>'string','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Barrio','name'=>'barrio_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'barrios,descripcion','datatable_where'=>'ciudad_id = 76834','datatable_ajax'=>'true'];
			//$this->form[] = ['label'=>'Puesto votación','name'=>'puesto_votacion_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'puestos_votacion,nombre_puesto','datatable_where'=>'ciudad_id = 76834'];
			//$this->form[] = ['label'=>'Mesa','name'=>'mesa_votacion','type'=>'text','width'=>'col-sm-10'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
			*/
			$this->setCensoVotantes();
	        $this->index_statistic[] = ['label'=>'Cantidad de votantes en la camapaña','count'=>DB::table("info_votantes")->count(),'icon'=>'ion ion-person-add','color'=>'red','width'=>'col-sm-3'];;
			$this->index_statistic[] = ['label'=>'Porcentaje del censo electoral','count'=>round((DB::table("info_votantes")->count()/$this->total_censo)*100).'%','icon'=>'fa fa-pie-chart','color'=>'green','width'=>'col-sm-3'];; 	


	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
			//Your code here
			
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {  
			
			//Your code here
			if(empty($postdata['fecha_nacimiento'])){
				unset($postdata['fecha_nacimiento']);
			}
			if(empty($postdata['referido_id'])){
				unset($postdata['referido_id']);
			}

			$votante = CRUDBooster::first($this->table,['tipo_documento'=>$postdata['tipo_documento'],'numero'=>$postdata['numero']]);	
			if(!empty($votante)){
				CRUDBooster::redirect(CRUDBooster::mainpath("/"),'Este votante ya se encuentra registrado','warning');
			}
			$postdata['usuario_id'] = CRUDBooster::myId();
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
			//Your code here
			if(empty($postdata['fecha_nacimiento'])){
				unset($postdata['fecha_nacimiento']);
			}
			if(empty($postdata['referido_id'])){
				unset($postdata['referido_id']);
			}
			$votante = CRUDBooster::first($this->table, $id);	
			if($votante->numero != $postdata['numero']){
				$votante = CRUDBooster::first($this->table,['tipo_documento'=>$postdata['tipo_documento'],'numero'=>$postdata['numero']]);	
				if(!empty($votante)){
					CRUDBooster::redirect(CRUDBooster::mainpath("/"),'Este votante ya se encuentra registrado','warning');
				}
			}
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }

		/* 
	    | ---------------------------------------------------------------------- 
	    | Funcion que consulta la cantidad del censo de votantes de la ciudad
	    | ----------------------------------------------------------------------     
	    | 
	    */
		public function setCensoVotantes(){

			$this->censo_hombres = DB::table("puestos_votacion")
			->where('ciudad_id', Session::get('ciudad_campana'))		
			->sum('censo_hombres');
			$this->censo_mujeres = DB::table("puestos_votacion")
			->where('ciudad_id', Session::get('ciudad_campana'))		
			->sum('censo_mujeres');
			$this->total_censo = $this->censo_hombres + $this->censo_mujeres;
		}


	    //By the way, you can still create your own method in here... :) 


	}