<?php

class Edificio_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_edificios() {
        return $this->db->get('edificio')->result();
    }

   
}