<?php
class Clase_model extends CI_Model {

	public function __construct()	{
	    parent::__construct();
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
	
	public function get_clases() {
		$query = $this->db->get('clase');
		return $query->result();
	}

	public function get_docentes($Comision_id) {
	    $this->db-from('docente');
        $this->db->join('comision_docente AS cd', 'cd.Docente_id = docente.id');
        $this->db->where('cd.Comision_id', $Comision_id);
        return $this->db->get()->result();
    }
	
	
	public function get_clases_dia($fecha, $edificio_id = null) {
		
		$this->db->select('au.id AS aula_id, ed.nombre AS edificio, au.nombre AS aula, clase.hora_inicio AS hora_inicio, clase.hora_fin AS hora_fin, as.nombre AS materia, ed.nombre AS edificio, concat(do.nombre, do.apellido) as docente');
		$this->db->from('clase');
		$this->db->join('horario AS ho', 'clase.Horario_id=ho.id', 'left');
		$this->db->join('comision AS co', 'ho.Comision_id=co.id', 'left');
		$this->db->join('docente AS do', 'co.Docente_id=do.id', 'left');
		$this->db->join('asignatura AS as', 'co.Asignatura_id=as.id', 'left');
		$this->db->join('aula AS au', 'ho.Aula_id = au.id', 'left');
		$this->db->join('edificio AS ed ', 'au.Edificio_id=ed.id', 'left');
		$this->db->order_by("clase.hora_inicio", "asc");
		$this->db->order_by("au.nombre", "asc");
		$this->db->where('clase.fecha',$fecha);
		if(!is_null($edificio_id))
		    $this->db->where('ed.id', $edificio_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_clase_aula($id) {

        $this->db->select('au.id AS aula_id, ed.nombre AS edificio, au.nombre AS aula, clase.hora_inicio AS hora_inicio, clase.hora_fin AS hora_fin, as.nombre AS materia, ed.nombre AS edificio');
        $this->db->from('clase');
        $this->db->join('horario AS ho', 'clase.Horario_id=ho.id', 'left');
        $this->db->join('comision AS co', 'ho.Comision_id=co.id', 'left');
        $this->db->join('asignatura AS as', 'co.Asignatura_id=as.id', 'left');
        $this->db->join('edificio AS ed ', 'au.Edificio_id=ed.id', 'left');
        $this->db->order_by("clase.hora_inicio", "asc");
		$this->db->where('ho.Aula_id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	//util para cambiar un horario y fechas disponible para asignar eventos 
	function aula_disponible($aula, $fecha, $hora_inicio, $hora_fin) {
		$this->db->select('clase.id');
		$this->db->from('clase');
		$this->db->where('clase.fecha', $fecha);
		$this->db->where('clase.hora_inicio');
		$this->db->where("clase.hora_inicio BETWEEN $hora_inicio AND $hora_fin");
		$this->db->where("clase.hora_fin BETWEEN $hora_inicio AND $hora_fin");
		$query = $this->db->get();
		return $query->num_rows() == 0;
	}
}