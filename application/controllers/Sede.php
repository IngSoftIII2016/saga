<?php

class Sede extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Sede_Model');
        $crud = new grocery_CRUD();
        $crud->set_model('Sede_Model');
        $crud->set_table('sede');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
}