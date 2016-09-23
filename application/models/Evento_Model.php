<?php

class Evento_Model extends CI_Model {
    
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function get_eventos() {
        return $this->db->get('evento')->result();
    }

	public function get_evento($id) {
		$this->db->where('evento.id', $id);
        return $this->db->get('evento')->result();
    }

		public function get_eventos_dia($fecha, $edificio_id = null) {
		
			$this->db->select('au.ubicacion AS aula_id, ed.nombre AS edificio, au.nombre AS aula, evento.hora_inicio AS hora_inicio, evento.hora_fin AS hora_fin, ed.nombre AS edificio, motivo');
			$this->db->from('evento');
			$this->db->join('aula AS au', 'evento.Aula_id = au.id', 'left');
			$this->db->join('edificio AS ed ', 'au.Edificio_id=ed.id', 'left');
			$this->db->order_by("evento.hora_inicio", "asc");
			$this->db->order_by("au.nombre", "asc");
			$this->db->where('evento.fecha',$fecha);
			if(!is_null($edificio_id))
				$this->db->where('ed.id', $edificio_id);
			$query = $this->db->get();
			return $query->result();
		}
	
		function evento_disponible($aula, $fecha, $hora_inicio, $hora_fin) {
			$this->db->select('evento.id');
			$this->db->from('evento');
			$this->db->where('evento.fecha', $fecha);
			$this->db->where("evento.hora_inicio BETWEEN $hora_inicio AND $hora_fin");
			$this->db->where("evento.hora_fin BETWEEN $hora_inicio AND $hora_fin");
			$query = $this->db->get();
			return $query->num_rows() == 0;
		}
	
		public function agregar_evento($aula, $fecha, $hora_inicio, $hora_fin, $motivo) {
		if(evento_disponible($aula, $fecha, $hora_inicio, $hora_fin)) {
			$evento_datos = array(
			'Aula_id' => $aula,
			'fecha' => $fecha,
			'hora_inicio' => $hora_inicio,
			'hora_fin' => $hora_fin,
			'motivo' => $motivo
			);
 
			$this->db->insert('evento',$evento_datos);
			return TRUE;
		} else {
			return FALSE;
		}
		
		
		} 
}