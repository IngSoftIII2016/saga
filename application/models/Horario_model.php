<?php

class Horario_model extends CI_Model {

    public $id;
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
        $this->load->database();
    }

    public function get_all()
    {
        return $this->db->get('horario')->result();
    }

    public function get_by_periodo_id($periodo_id) {
        //$this->db->select('*');
        //$this->db->from('horario');
        $this->db->join('comision', 'Comision_id = comision.id', 'left');
        $this->db->where('comision.Periodo_id', $periodo_id);
        return $this->db->get('horario')->result();
    }

    public function load($id) {
        //$this->db->select('id, descripcion, frecuencia_semanas, dia, hora_inicio, duracion, Comision_id, Aula_id');
        $this->db->where('id', $id);
        $result = $this->db->get('horario')->row();
        $this->id = $result->id;
        $this->descripcion = $result->descripcion;
        $this->frecuencia_semanas = $result->frecuencia_semanas;
        $this->dia = $result->dia;
        $this->hora_inicio = $result->hora_inicio;
        $this->duracion = $result->duracion;
        $this->comision_id = $result->Comision_id;
        $this->aula_id = $result->Aula_id;
    }

    public function get_periodo_rango($horario)
    {
        $this->db->select('p.fecha_inicio AS inicio, p.fecha_fin AS fin');
        $this->db->from('horario AS h');
        $this->db->join('comision AS c', 'h.Comision_id = c.id', 'left');
        $this->db->join('periodo AS p', 'c.Periodo_id = p.id');
        $this->db->where('h.id', $horario->id);
        return $this->db->get()->row();
    }

    public function get_rango_periodo() {
        $this->db->select('p.fecha_inicio AS inicio, p.fecha_fin AS fin');
        $this->db->from('horario AS h');
        $this->db->join('comision AS c', 'h.Comision_id = c.id', 'left');
        $this->db->join('periodo AS p', 'c.Periodo_id = p.id');
        $this->db->where('h.id', $this->id);
        return $this->db->get()->row();
    }

    public function get_colisiones($periodo_id)
    {
        $hora_fin = date("H:i:s", strtotime($this->hora_inicio) + strtotime($this->duracion) - strtotime("00:00:00"));
        $this->db->select('ho.id AS Horario_id, co.id AS Comision_id, as.nombre AS asignatura, co.nombre AS comision');
        $this->db->from('horario AS ho');
        $this->db->join('comision AS co', 'ho.Comision_id = co.id', 'left');
        $this->db->join('asignatura AS as', 'co.Asignatura_id = as.id', 'left');
        $this->db->where('co.Periodo_id', $periodo_id);
        $this->db->where('ho.dia', $this->dia);
        $this->db->where('ho.Aula_id', $this->aula_id);
        $this->db->where("ho.hora_inicio BETWEEN '$this->hora_inicio' AND '$hora_fin' ");
        $this->db->where("(SELECT ADDTIME(ho.hora_inicio, ho.duracion)) BETWEEN '$this->hora_inicio' AND '$hora_fin' ");
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_clases($horario)
    {
        $rango = $this->get_periodo_rango($horario);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod(new DateTime($rango->inicio), $interval, new DateTime($rango->fin));
        foreach( $period as $dt ) {
            if ($horario->dia == $dt->format("w")) {

                $hora_fin = strtotime($horario->hora_inicio) + strtotime($horario->duracion) - strtotime("00:00:00");
                $clase = array(
                    'fecha' => $dt->format("Y-m-d"),
                    'hora_inicio' => $horario->hora_inicio,
                    'hora_fin' => date("H:i:s", $hora_fin),
                    'Aula_id' => $horario->Aula_id,
                    'Horario_id' => $horario->id
                );

                $this->db->insert('clase', $clase);
            }
        }
    }
    public function insertar_clases()
    {
        $rango = $this->get_rango_periodo();
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod(new DateTime($rango->inicio), $interval, new DateTime($rango->fin));
        foreach( $period as $dt ) {
            if ($this->dia == $dt->format("w")) {

                $hora_fin = strtotime($this->hora_inicio) + strtotime($this->duracion) - strtotime("00:00:00");
                $clase = array(
                    'fecha' => $dt->format("Y-m-d"),
                    'hora_inicio' => $this->hora_inicio,
                    'hora_fin' => date("H:i:s", $hora_fin),
                    'Aula_id' => $this->Aula_id,
                    'Horario_id' => $this->id
                );

                $this->db->insert('clase', $clase);
            }
        }
    }

    public function insert()
    {
        $this->db->trans_start();
        $colisiones = $this->get_colisiones();
        if(count($colisiones) > 0) {
            $msg = "Horario ocupado!";
            foreach ($colisiones as $c) $msg = $msg . "\n" . $c;
            throw new Exception($msg);
        }

        $this->db->insert('horario', $this);
        //var_dump($this->db->set($this)->get_compiled_insert('horario'));

        $this->insertar_clases();

        $this->db->trans_complete();
    }

    public function delete($id) {
        // Acá borrar todas las clases con este id en Horario_id hasta la fecha actual
        $this->db->delete('horario', array('id' => $id));
    }

    public function update($id) {
        $this->db->update('horario', $this, array('id' => $id));
        // Acá cambiar todas las clases con este id en Horario_id a partir de la fecha actual
    }



}