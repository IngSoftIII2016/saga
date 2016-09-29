<?php

class Asignatura extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Asignatura_Model');
        $crud = new grocery_CRUD();
        $crud->set_model('Asignatura_Model');
        $crud->set_table('asignatura');
        $crud->required_fields('nombre');
        $crud->field_type('fruits','set',array('banana','orange','apple','lemon'));
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
}