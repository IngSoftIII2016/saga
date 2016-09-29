<?php

class Carrera extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Carrera_Model');
        $crud = new grocery_CRUD();
        $crud->set_model('Carrera_Model');
        $crud->set_table('carrera');
        $crud->required_fields('nombre');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
}