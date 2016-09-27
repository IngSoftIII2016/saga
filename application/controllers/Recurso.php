<?php

class Recurso extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Recurso_Model');
        $crud = new grocery_CRUD();
        $crud->set_model('Recurso_Model');
        $crud->set_table('recurso');
        $crud->set_relation('Tipo_recurso_id', 'tipo_recurso', 'nombre');
        $crud->set_relation('Aula_id', 'aula', 'id');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }

}