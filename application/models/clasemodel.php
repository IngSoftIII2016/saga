<?php
class Clase_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	

	public function get_clase($id) {
		
		if($id != FALSE) {
			$query = $this->db->get_where('clase', array('id' => $id));
			return $query->row_array();
		}
		else {
			return FALSE;
		}
	}
	
	public function get_clase_dia($dia) {
		$query = $this->db->query("select ");
		return $query->row_array();
	}
	
	
	
	
	
	
	
}