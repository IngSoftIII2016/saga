<?php

class DocenteController extends CI_Controller
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
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
}