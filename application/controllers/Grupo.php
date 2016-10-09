<?php

/**
 * Created by PhpStorm.
 * User: Elias
 */
class Grupo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library(array('ion_auth','form_validation'));
        $this->load->helper(array('url','language'));
        $this->load->library('grocery_CRUD');
    }

    public function index(){
        $this->load->model('Grupo_model');
        $crud = new grocery_CRUD();
        $crud->set_model('Grupo_model');
        $crud->set_table('grupo');
        $crud->set_subject('grupo');

        //las columnas de la vista principal
        $crud->columns('name','description');
        // campos obligatorios
        $crud->required_fields ('name' );
        //reasignacion de nombres
        $crud->display_as('name','Nombre');
        $crud->display_as('description','Descripción');
        //validacion: verifica que no se modifique los nombres de bedel y adminsitrador
        //callback
        $crud->callback_before_delete(array($this,'cek_before_delete'));
        $crud->callback_before_update(array($this, 'grupo_before_update'));

        $crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/")));
        $output = $crud->render();
        $this->load->view('vacia.php',$output);

    }

    function cek_before_delete($primary_key) {
        $this->load->model('Grupo_model');
        $grupo= $this->Grupo_model->get_grupo($primary_key);
        if ($grupo[0]->name=='administrador'|| $grupo[0]->name=='bedel')
            return false;
    }
    function grupo_before_update($post_array, $primary_key = null){
        $this->load->model('Grupo_model');
        $grupo= $this->Grupo_model->get_grupo($primary_key);
        if ($grupo[0]->name=='administrador'){
            if ($post_array['name'] !== 'administrador'){
                return false;
            }
        }
        if ($grupo[0]->name=='bedel'){
            if ($post_array['name'] !== 'bedel'){
                return false;
            }
        }

    }


}