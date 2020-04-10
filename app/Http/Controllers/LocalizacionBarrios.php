<?php

namespace App\Http\Controllers;
use Session;
use Request;
use DB;
use CRUDBooster;
use Mapper;


class LocalizacionBarrios extends \crocodicstudio\crudbooster\controllers\CBController
{
		public function cbInit() {
			
		}
    public function getIndex(){
		
				if(!CRUDBooster::myId()) CRUDBooster::redirect("./admin","No se encuentra logueado");
				
				$data = [];
				$data['page_title'] = "Localización";
				$data['icon'] = "fa fa-map-o";
				
				
				$query = DB::table("ciudades");
				$query->select('longitud', 'latitud');
				$query->where('id', Session::get('ciudad_campana'));
				$ciudad = $query->get()[0];
				
				
				/*$query = DB::table("puestos_votacion");
				$query->select('id', 'direccion', 'longitud', 'latitud', 'nombre_puesto');
				$datos = $query->get();*/
				
				$datos = [];
				$sql = "SELECT count(*) as cantidad_votos, b.latitud, b.longitud
								FROM info_votantes as a JOIN puestos_votacion as b ON (a.puesto_votacion_id = b.id)
								WHERE a.puesto_votacion_id IS NOT NULL
								group by latitud, longitud";
				$datos = DB::select($sql);
				
				//$datos[] = ['cantidad'=>$column[0]->cantidad_votos,'latitud'=>$column[0]->latitud,'longitud'=>$column[0]->longitud];


								
				Mapper::map($ciudad->latitud,$ciudad->longitud, ['zoom' => 14,'marker' => false, 'cluster' => true, 'clusters' => ['center' => false, 'zoom' => 15, 'size'=> 4], 'language' => 'es']);
				

				$icons = [
					'/images/puesto_votacion.png'
				];
				
				foreach($datos as $key ){
					try {
						//$barrio = str_replace('Esc', 'Escuela', $value->direccion).", tulua, valle del cauca";
						//DB::table("puestos_votacion")->where('id', $value->id)->update(['longitud'=>$longitud, 'latitud'=>$latitud]);	                        
						Mapper::marker($key->latitud, $key->longitud, ['title' => $key->cantidad_votos, 'scale' => 1000, 'animation' => 'DROP', 'icon' => $icons[0]]);
						
					} catch (\Throwable $th) {
						//throw $th;
					}
				}
							
				$this->cbView('localizacion_barrios',$data);
		
		
	}
}
