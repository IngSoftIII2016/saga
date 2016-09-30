<?php

require_once('Grocery_crud_model.php');
class Periodo_Model extends Grocery_crud_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_periodos() {
        return $this->db->get('periodo')->result();
    }

    public function get_periodo_actual() {
        $now = new DateTime();
        $this->db->from('periodo');
        $this->db->where('fecha_inicio <=', $now->format("Y-m-d"));
        $this->db->where('fecha_fin >=', $now->format("Y-m-d"));
        return $this->db->get()->row();
    }

}