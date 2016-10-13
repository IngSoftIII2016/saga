<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Evento extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('grocery_CRUD');
		$this->load->model('Evento_Model');
    }

    public function index()
    {
		//$this->load->model('Edificio_model');
        $crud = new grocery_CRUD();
		$crud->fields('Aula_id', 'fecha', 'hora_inicio', 'hora_fin', 'motivo');
        $crud->set_table('evento');
		$crud->set_relation('Aula_id', 'aula', 'nombre');
		$crud->display_as('Aula_id','Aula');
		$crud->field_type('fecha','date');
		$crud->field_type('hora_inicio', 'time');
		$crud->field_type('hora_fin', 'time');
		$crud->field_type('motivo', 'string');

		
		//var_dump($fields);
		//$crud->callback_insert(array($this,'agregar_evento_callback'));
		
        $output = $crud->render();
		//$data['edificios'] = $this->Edificio_model->get_edificios();
		//
		
		
		//
        $this->load->view('vacia.php', $output);

		
		
    }
	
	public function agregar_evento_callback($post_array) {
		$aula = $post_array['Aula_id'];
		//$post_array['fecha'] = date('Y-m-d');
		$fecha = $post_array['fecha'];
		
		$hora_inicio = $post_array['hora_inicio'];
		$hora_fin = $post_array['hora_fin'];
		$motivo = $post_array['motivo'];
		
		
		return $this->Evento_Model->agregar_evento($aula, $fecha, $hora_inicio, $hora_fin, $motivo);
	}
	 
	public function agregar_evento() {
		date_default_timezone_set ( "America/Argentina/Buenos_Aires" );		
		$fecha = $this->input->post ( "calendarioevento" );
		$date = DateTime::createFromFormat('d/m/Y', $fecha);
		$dateFormat=$date->format('Y-m-d');		
		$aula = $this->input->post ( 'aulaevento' );
		$hora_inicio = $this->input->post ( 'horainicioevento' );
		$hora_fin = $this->input->post ( 'horafinevento' );
		$motivo = $this->input->post ( 'motivoevento' );		
		if($this->Evento_Model->agregar_evento($aula, $dateFormat, $hora_inicio, $hora_fin, $motivo)){
			echo "1";
			die ();
		}
		else {
			echo "Acceso denegado";
			die ();
		}
	
	
	}
	public function borrar(){
		$this->Evento_Model->borrar( $this->input->post ( "id" ));
			
	}
	 

  
}
