<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Edificio extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Edificio_model');
        $crud = new grocery_CRUD();
        $crud->set_model('Edificio_Model');
        $crud->set_table('edificio');
        $crud->set_relation('Localidad_id', 'localidad', 'nombre');
        $crud->required_fields('nombre', 'Localidad_id');
        $crud->callback_before_delete(array($this,'cek_before_delete'));
        $crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/")));
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
    }
    
    public function get_edificios_ajax() {
    	$this->load->model('Edificio_model');
    	$data ['edificios'] = $this->Edificio_model->get_edificios();
    	$this->load->view('edificio.php', $data);
    }

    function cek_before_delete($primary_key) {
        $this->db->db_debug = false; // IMPORTANT! (to make temporary disable debug)
        $this->db->trans_begin();
        $this->db->where('id', $primary_key);
        $this->db->delete('carrera');
        $num_rows = $this->db->affected_rows();
        $this->db->trans_rollback();
        if ($num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}