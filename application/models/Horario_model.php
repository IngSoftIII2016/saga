<?php

class Horario_model extends CI_Model {

    public $descripcion;
    public $frecuencia_semanas;
    public $dia;
    public $hora_inicio;
    public $duracion;
    public $comision_id;
    public $aula_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {

    }

    public function get_periodo_rango()
    {
        $this->db->select('p.fecha_inicio AS inicio, p.fecha_fin AS fin');
        $this->db->form('horario AS h');
        $this->db->join('comision AS c', 'h.Comision_id = c.id', 'left');
        $this->db->join('periodo AS p', 'c.Periodo_id = p.id');
        return $this->db->get()->result();
    }

    public function dispoible()
    {
        $hora_fin = strtotime($this->hora_inicio) + strtotime($this->duracion);
        $this->db->select('id');
        $this->db->where('dia', $this->dia);
        $this->db->where('Aula_id', $this->aula_id);
        $this->db->where("hora_inicio BETWEEN $this->hora_inicio AND $hora_fin");
        $this->db->where("ADDTIME(hora_inicio, duracion) BETWEEN $this->hora_inicio AND $hora_fin");
        $query = $this->db->get('horario');
        return $query->num_rows() == 0;
    }

    public function insert()
    {
        if(!$this->dispoible())
            throw new Exception('Horario ocupado!');

        $this->db->trans_start();

        $this->db->insert('horario', $this);
        $id = $this->db->insert_id();

        $rango = $this->get_periodo_rango();
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($rango['inicio'], $interval, $rango['fin']);

        foreach( $period as $dt )
            if($this->dia == date('w', $dt)) {
                $clase = array(
                    'fecha' => $dt->format("Y-m-d"),
                    'hora_inicio' => $this->hora_inicio,
                    'hora_fin' => strtotime($this->hora_inicio) + strtotime($this->duracion),
                    'Aula_id' => $this->aula_id,
                    'Horario_id' => $id
                );
                $this->db->insert('clase', $clase);
            }
        $this->db->trans_complete();
    }

    public function delete($id) {
        // borrar todas las clases con este id en Horario_id hasta la fecha actual
        $this->db->delete('horario', array('id' => $id));
    }

    public function update($id) {
        $this->db->update('horario', $this, array('id' => $id));
        // cambiar todas las clases con este id en Horario_id a partir de la fecha actual
    }



}