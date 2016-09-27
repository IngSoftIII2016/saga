<?php

class EdificioController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Edificio_Model');
        $crud = new grocery_CRUD();
        $crud->set_model('Edificio_Model');
        $crud->set_table('edificio');
        $crud->set_relation('Localidad_id', 'localidad', 'nombre');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
}