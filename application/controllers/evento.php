<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class evento extends CI_Controller
{	   

function __construct()
{
parent::__construct();
 
$this->load->database();
$this->load->helper('url');
$this->load->library('grocery_CRUD');

}
 
 
	   public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('evento');
		$crud->set_subject('Evento');
		$crud->display_as('Aula_id','Aula');
		$crud->set_relation('Aula_id','aula','nombre');
		$crud->field_type('hora_inicio','time');
		$crud->field_type('hora_fin','time');
		$crud->field_type('motivo', 'text');
        $output = $crud->render();
		
        $this->load->view('vacia.php', $output);
    }
	
}