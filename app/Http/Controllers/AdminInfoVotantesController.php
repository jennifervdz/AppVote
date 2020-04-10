<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminInfoVotantesController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->button_delete = false;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "info_votantes";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Tipo Documento","name"=>"tipo_documento"];
			$this->col[] = ["label"=>"Numero","name"=>"numero"];
			$this->col[] = ["label"=>"Nombres","name"=>"nombres"];
			$this->col[] = ["label"=>"Apellidos","name"=>"apellidos"];
			$this->col[] = ["label"=>"Puesto Votación","name"=>"puesto_votacion_id","join"=>"puestos_votacion,nombre_puesto"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Tipo Documento','name'=>'tipo_documento','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>'true','value'=>'CC'];
			$this->form[] = ['label'=>'Número','name'=>'numero','type'=>'text','validation'=>'required|integer','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nombres','name'=>'nombres','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Apellidos','name'=>'apellidos','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Teléfono','name'=>'telefono','type'=>'text','validation'=>'integer','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Referido','name'=>'referido_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'info_votantes,nombres','datatable_where'=>'usuario_id = 1','datatable_format'=>'nombres,\' \',apellidos','datatable_ajax'=>'true'];
			$this->form[] = ['label'=>'Barrio','name'=>'barrio_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'barrios,descripcion','datatable_where'=>'ciudad_id = 76834','datatable_ajax'=>'true'];
			$this->form[] = ['label'=>'Puesto votación','name'=>'puesto_votacion_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'puestos_votacion,nombre_puesto','datatable_where'=>'ciudad_id = 76834'];
			$this->form[] = ['label'=>'Mesa','name'=>'mesa_votacion','type'=>'text','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Tipo Documento','name'=>'tipo_documento','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>'true','value'=>'CC'];
			//$this->form[] = ['label'=>'Número','name'=>'numero','type'=>'text','validation'=>'required|integer','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nombres','name'=>'nombres','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Apellidos','name'=>'apellidos','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Teléfono','name'=>'telefono','type'=>'text','validation'=>'integer','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Referido','name'=>'referido_id','type'=>'select2','width'=>'col-sm-10', 'datatable'=>'info_votantes,nombres,apellidos', 'datatable_where'=>'usuario_id = '.CRUDBooster::myId().'', 'datatable_ajax'=>'true'];
			//$this->form[] = ['label'=>'Barrio','name'=>'barrio_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'barrios,descripcion', 'datatable_where'=>'ciudad_id = '.Session::get('ciudad_campana').'', 'datatable_ajax'=>'true'];
			//$this->form[] = ['label'=>'Puesto votación','name'=>'puesto_votacion_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'puestos_votacion,nombre_puesto', 'datatable_where'=>'ciudad_id = '.Session::get('ciudad_campana').''];
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
	        $this->index_statistic[] = ['label'=>'Mis votantes','count'=>DB::table("info_votantes")->where('usuario_id', CRUDBooster::myId())->count(),'icon'=>'ion ion-person-add','color'=>'red','width'=>'col-sm-3'];;
			//$this->index_statistic[] = ['label'=>'Votantes','count'=>DB::table("info_votantes")->count(),'icon'=>'ion ion-person-add','color'=>'red','width'=>'col-sm-3'];;


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
	        
			$this->pre_add_upd_html = ' <div id="myModal" class="modal fade" data-keyboard="false" data-backdrop="false">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header bg-primary">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Consulta cédula</h4>

														</div>
														<div class="modal-body">
															<iframe style="border: 0px; " src="https://wsp.registraduria.gov.co/censo/consultar/#form" width="100%" height="100%" id="panelRegistraduria" name="panelRegistraduria"></iframe>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
														</div>
													</div>
												</div>
										</div>			
										<div class="row">
											<div class="col-sm-3"">
												<button class="btn btn-danger" onclick="javascript:modalRegistraduria()"><i class="fa fa-calendar-check-o"></i> Enlace Registraduria</button>
											</div>
										</div>
										<br/>
									   ';
	        
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
	        /*$this->load_js[] = asset("js/votantes.js");
			$this->load_js[] = asset('vendor/crudbooster/assets/select2/dist/js/select2.full.js');*/
			//$this->load_js = array();
			$this->load_js[] = asset("js/jquery-ui.js");
			$this->load_js[] = asset("js/votantes.js");
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = ".modal
								{
									overflow: hidden;
									background:rgba(0,0,0,0);
								}
								.modal-dialog{
									margin-right: 50;
									margin-left: 0;
								}";
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        //$this->load_css[] = asset('vendor/crudbooster/assets/select2/dist/css/select2.min.css');
			
	    }
		
		
		/*public function getAdd(){
			$data = [];
			$data['page_title'] = "Añadir votantes";
			$data['page_icon'] = "fa fa-user-plus";
			$data['icon'] = "fa fa-user-plus";
			$data['barrios'] = DB::table("barrios")
			->where('ciudad_id', Session::get('ciudad_campana'))
			->select('id', 'descripcion')->get();
			$this->cbView('votante_add',$data);
		}*/
				

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
	        $query->where('usuario_id', CRUDBooster::myId());    
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
		


	    //By the way, you can still create your own method in here... :) 


	}