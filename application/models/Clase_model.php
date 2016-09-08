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
	
	
	public function get_clase_dia($dia) {
		//tener en cuenta las comiciones, el nombre de la materia pasaria a estar formado por
		//su nombre + el nombre de la comision.
		
		/*
		select a.nombre as 'aula', c.hora_inicio, c.hora_fin, concat(p.nombre, ' ',p.apellido) as 'profesor', m.nombre as 'materia'
		from clase as c
		left join cursada as cur on (c.Cursada_id=cur.id)
		left join docente as p on (cur.Docente_id=p.id)
		left join materia m on (cur.Materia_id=m.id)
		left join aula as a on (c.Aula_id = a.id)
		where (c.fecha= '2016-9-1')
		 */
		
		$this->db->select('select a.id AS aula_id , a.nombre AS aula, clase.hora_inicio AS hora_inicio, clase.hora_fin AS hora_fin, CONCAT(p.nombre, " ",p.apellido) AS profesor, m.nombre AS materia, e.nombre AS eficio');
		$this->db->from('clase');
		$this->db->join('cursada AS cur', 'clase.Cursada_id=cur.id', 'left');
		$this->db->join('docente  AS p', 'cur.Docente_id=p.id', 'left');
		$this->db->join('asignatura AS m', 'cur.Asignatura_id=m.id', 'left');
		$this->db->join('aula AS a', 'c.Aula_id = a.id', 'left');
		$this->db->join('edificio AS e ', 'a.Edificio_id=e.id', 'left');
		$this->db->order_by("clase.hora_inicio", "asc");
		$this->db->order_by("aula.nombre", "asc");
		$this->db->where('clase.fecha',$dia);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_clase_aula($id) {
		//tener en cuenta las comiciones, el nombre de la materia pasaria a estar formado por
		//su nombre + el nombre de la comision.
	
		/*
			select a.nombre as 'aula', c.hora_inicio, c.hora_fin, concat(p.nombre, ' ',p.apellido) as 'profesor', m.nombre as 'materia'
			from clase as c
			left join cursada as cur on (c.Cursada_id=cur.id)
			left join docente as p on (cur.Docente_id=p.id)
			left join materia m on (cur.Materia_id=m.id)
			left join aula as a on (c.Aula_id = a.id)
			where (c.fecha= '2016-9-1')
			*/
	
		$this->db->select('select a.id AS aula_id, a.nombre AS aula, clase.hora_inicio, clase.hora_fin, CONCAT(p.nombre, " ",p.apellido) AS profesor, m.nombre AS materia');
		$this->db->from('clase');
		$this->db->join('cursada AS cur', 'clase.Cursada_id=cur.id', 'left');
		$this->db->join('docente  AS p', 'cur.Docente_id=p.id', 'left');
		$this->db->join('materia   AS m', 'cur.Materia_id=m.id', 'left');
		$this->db->join('aula   AS a', 'c.Aula_id = a.id', 'left');
		$this->db->join('edificio AS e ', 'a.Edificio_id=e.id', 'left');
		$this->db->order_by("clase.hora_inicio", "asc");
		$this->db->order_by("aula.nombre", "asc");
		$this->db->where('aula.id',$id);
		$query = $this->db->get();
		$query = $this->db->query("select * from clase ");
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