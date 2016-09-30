<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Asignatura extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Asignatura_Model');
        $crud = new grocery_CRUD();
        $crud->set_model('Asignatura_Model');
        $crud->set_table('asignatura');
        $crud->required_fields('nombre');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
}