<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comision extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Comision_Model');
        $crud = new grocery_CRUD();
        $crud->set_table('comision');
        $crud->set_relation('Periodo_id', 'periodo', 'descripcion');
        $crud->display_as('Periodo_id', 'periodo');
        $crud->set_relation('Docente_id', 'docente', 'apellido');
        $crud->display_as('Docente_id', 'docente');
        $crud->set_relation('Asignatura_id', 'asignatura', 'nombre');
        $crud->display_as('Asinatura_id', 'asignatura');
        $crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/")));
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }

}