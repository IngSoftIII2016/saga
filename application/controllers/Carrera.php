<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Carrera extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('grocery_CRUD');
    }

    public function index() {
        $this->load->model('Carrera_Model');
        $crud = new grocery_CRUD();
        $crud->set_model('Carrera_Model');
        $crud->set_table('carrera');
        $crud->required_fields('nombre');
        $crud->callback_before_delete(array($this,'cek_before_delete'));
        $crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/")));
        $output = $crud->render();
        $this->load->view('vacia.php', $output);
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