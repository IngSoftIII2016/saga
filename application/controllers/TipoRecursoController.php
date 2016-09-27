<?php

class TipoRecursoController extends CI_Controller{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('TipoRecurso_Model');
        $crud = new grocery_CRUD();
        $crud->set_model('TipoRecurso_Model');
        $crud->set_table('tipo_recurso');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
}