<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Evento extends REST_Controller {

    function __construct()
    {
		$this->load->model('Evento_Model');
        // Construct the parent class
        parent::__construct();

    }

    public function index($id){
        var_dump($id);
    }


    /**
     * @param $id
     */
    public function evento_get ($id=null)
    {
        //$id = $this->get('id');

        if($id!=null){
            
            $clase = $this->Evento_Model->get_evento($id);
            $this->response(['data' => $clase]);
        }else {
            $clases = $this->Evento_Model->get_eventos();
            $this->response(['data' => $clases]);
        }
    }
	
	public evento_post () {
		
		$json = json_decode($this->post('data'), true);
		foreach($json['data']as $item) {
			$aula = $item['Aula_id'];
			$fecha = $item['fecha'];
			$hora_inicio = $item['hora_inicio']; 
			$hora_fin = $item['hora_fin']; 
			$motivo = $item['motivo']; 
			if ($this->Evento_Model->agregar_evento($aula, $fecha, $hora_inicio, $hora_fin, $motivo)) {
				$this->response($json['data'],201);
			} else {
				$this->response(['error' => 'no se puede insertar el evento, el aula se encuentra ocupada'],500);
			}
			
		}
		
	}
	
	public evento_put() {
				$json = json_decode($this->put('data'), true);
		foreach($json['data']as $item) {
			$aula = $item['Aula_id'];
			$fecha = $item['fecha'];
			$hora_inicio = $item['hora_inicio']; 
			$hora_fin = $item['hora_fin']; 
			$motivo = $item['motivo']; 
			if ($this->Evento_Model->modificar($aula, $fecha, $hora_inicio, $hora_fin, $motivo)) {
				$this->response($json['data'],202);
			} else {
				$this->response(['error' => 'no se puede modificar el evento, el aula se encuentra ocupada'],500);
			}
			
		}
	}
	
	public evento_delete($id=null) {
		if($id!=null) {
		$this->Evento_Model->borrar($id);
		$this->response(202);
		} else {
			$this->response(['error' => 'no se pudo borrar el evento'],500);
			
		}
		
	}


    


}