<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class abm extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function docente()
    {
        $crud = new grocery_CRUD();
		$crud->set_language("spanish");
        $crud->set_table('docente');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }

    public function asignatura()
    {
        $crud = new grocery_CRUD();
		$crud->set_language("spanish");
        $crud->set_table('asignatura');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }

    public function carrera()
    {
        $crud = new grocery_CRUD();
		$crud->set_language("spanish");
        $crud->set_table('carrera');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }


    public function aula()
    {
        $crud = new grocery_CRUD();
		$crud->set_language("spanish");
        $crud->set_table('aula');
        $crud->set_relation('Edificio_id', 'edificio', 'nombre');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }

    public function edificio()
    {
        $crud = new grocery_CRUD();
		$crud->set_language("spanish");
        $crud->set_table('edificio');
        $crud->set_relation('Localidad_id', 'localidad', 'nombre');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }

    public function localidad()
    {
        $crud = new grocery_CRUD();
		$crud->set_language("spanish");
        $crud->set_table('localidad');
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
}
