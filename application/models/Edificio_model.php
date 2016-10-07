<?php
require_once('Grocery_crud_model.php');

class Edificio_model extends Grocery_crud_model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_edificios() {
        return $this->db->get('edificio')->result();
    }

   
}