<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class evento extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_CRUD');
    }

    public function index()
    {
		$this->load->model('Edificio_model');
        $crud = new grocery_CRUD();

        $crud->set_table('evento');
		$crud->set_relation('Aula_id', 'aula', 'nombre');
		$crud->display_as('Aula_id','Aula');
		$crud->field_type('hora_inicio', 'time');
		$crud->field_type('hora_fin', 'time');
		$crud->field_type('motivo', 'text');

		
		//var_dump($fields);
		$crud->callback_insert(array($this,'agregar_evento_callback'));
		
        $output = $crud->render();
		$data['edificios'] = $this->Edificio_model->get_edificios();
		//
		
		
		//
		$this->load->view('header.php', $data);
        $this->load->view('vacia.php', $output);

		
		
    }
	
	public function agregar_evento_callback($post_array) {
		$aula = $post_array['aula'];
		$fecha = $post_array['fecha'];
		$hora_inicio = $post_array['hora_inicio'];
		$hora_fin = $post_array['hora_fin'];
		$motivo = $post_array['motivo'];
		
		$this->load->model('Evento_Model');
		//return $this->Evento_Model->agregar_evento($aula, $fecha, $hora_inicio, $hora_fin, $motivo);
		if(($this->Evento_Model->evento_disponible($aula, $fecha, $hora_inicio, $hora_fin))) {
			// $evento_datos = array(
			// 'Aula_id' => $aula,
			// 'fecha' => $fecha,
			// 'hora_inicio' => $hora_inicio,
			// 'hora_fin' => $hora_fin,
			// 'motivo' => $motivo
			// );
 
			$this->db->insert('evento',$post_array);
			return $post_array;
		}
		//} else {
		//	return false;
		//}
	}
	 
	 
	 
  
}