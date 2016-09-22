<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 09/09/16
 * Time: 03:30
 */
class Aula_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_aulas() {
		$this->db->from('aula');
		$this->db->order_by("ubicacion", "asc");
		return $this->db->get()->result();
    }

    public function get_aulas_edificio($edificio_id) {
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