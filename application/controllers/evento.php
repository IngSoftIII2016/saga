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
        $output = $crud->render();
		$data['edificios'] = $this->Edificio_model->get_edificios();
		 $this->load->view('header.php', $data);
        $this->load->view('vacia.php', $output);
    }

  
}
