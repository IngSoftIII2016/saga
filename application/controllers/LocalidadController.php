<?php

class LocalidadController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Localidad_Model');
        $crud = new grocery_CRUD();
        $crud->set_model('Localidad_Model');
        $crud->set_table('localidad');
        $crud->set_relation('Sede_id', 'sede', 'nombre');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
}