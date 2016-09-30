<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Docente extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Docente_Model');
        $crud = new grocery_CRUD();
        $crud->set_model('Docente_Model');
        $crud->set_table('docente');
        $crud->required_fields('nombre', 'apellido');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
}