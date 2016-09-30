<?php

require_once('Grocery_crud_model.php');
class Aula_model extends Grocery_crud_model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_aulas() {
		$this->db->from('aula');
		$this->db->order_by("ubicacion", "asc");
		return $this->db->get()->result();
    }

    public function get_aulas_join_edificio() {
        $this->db->select('au.id AS id, au.nombre AS nombre, ed.id AS edificio_id, ed.nombre AS edificio');
        $this->db->from('aula AS au');
        $this->db->join('edificio AS ed', 'au.Edificio_id = ed.id', 'left');
        $this->order_by('edificio_id', 'asc');
        return $this->db->get()->result();
    }

    public function get_aulas_by_edificio($edificio_id) {
        return $this->db->select("aula.id as id, aula.nombre as nombre,aula.ubicacion as ubicacion, aula.capacidad as capacidad, ed.nombre as edificio")->from('aula')
            ->join('edificio AS ed', 'aula.Edificio_id=ed.id')
            ->where("ed.id", $edificio_id)
			->order_by("aula.ubicacion", "asc")
            ->get()->result();
    }

    public function get_by_id($id) {
        $this->db->select("aula.id as id, aula.nombre as nombre, aula.capacidad as capacidad, ed.nombre as edificio");
        $this->db->join('edificio AS ed', 'aula.Edificio_id=ed.id');
        $this->db->where('aula.id', $id);
        return $this->db->get('aula')->result()[0];
    }



}