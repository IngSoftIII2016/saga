<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class HorarioDAO extends BaseDAO {


    public function __construct() {
        parent::__construct('Horario');
    }


    public function get_colisiones() {
        $periodo_id = $this->get_periodo()->id;
        $hora_fin = date("H:i:s", strtotime($this->hora_inicio) +
            strtotime($this->duracion) - strtotime("00:00:00"));
        $this->db->select('ho.* , co.nombre AS comision, a.nombre AS asignatura');
        $this->db->from('horario AS ho');
        $this->db->join('comision AS co', 'ho.Comision_id = co.id');
        $this->db->join('asignatura AS a', 'co.Asignatura_id = a.id');
        $this->db->where('ho.id !=', $this->id);
        $this->db->where('co.Periodo_id', $periodo_id);
        $this->db->where('ho.dia', $this->dia);
        $this->db->where('ho.Aula_id', $this->Aula_id);
        $this->db->where("ho.hora_inicio < '$hora_fin' AND (SELECT ADDTIME(ho.hora_inicio, ho.duracion)) > '$this->hora_inicio'");
        $query = $this->db->get();
        return $query->result();
    }

    public function insert()
    {
        $this->db->trans_start();

        $colisiones = $this->get_colisiones();

        if (count($colisiones) > 0) {
            $this->db->trans_rollback();

            $msg = "Horario ocupado!";
            foreach ($colisiones as $c) $msg = $msg . "\n" . $c->asignatura;
            return array('error' => $msg, 'colisiones' => $colisiones);
        } else {

            $this->db->insert('horario', $this);
            $this->id = $this->db->insert_id();
            $this->insertar_clases();

            $this->db->trans_complete();

            return array( 'success' => 'Horario agregado con exito');
        }
    }

    public function update($desde_date = null)
    {
        if ($desde_date == null) $desde_date = new DateTime();

        $this->db->trans_start();

        $colisiones = $this->get_colisiones();

        if (count($colisiones) > 0) {
            $this->db->trans_rollback();
            $msg = "Horario ocupado!";
            foreach ($colisiones as $c) $msg = $msg . "\n" . $c->asignatura;
            return array( 'error' => $msg, 'colisiones' => $colisiones);
        }else {
            $this->db->update('horario', $this->to_array(), array('id' => $this->id));

            // actualizar todas las clases correspondientes a este horario a partir de la fecha establecida
            $this->eliminar_clases($desde_date);

            $this->insertar_clases($desde_date);

            $this->db->trans_complete();

            return array( 'success' => 'Horario actualizado con exito');
        }
    }

    public function delete($desde_date = null)
    {
        $this->db->trans_start();

        $this->eliminar_clases($desde_date);

        $this->db->delete('horario', array('id' => $this->id));

        $this->db->trans_complete();
    }


    private function insertar_clases($start = null)
    {
        $periodo = $this->get_periodo();
        if($start == null)
            $start = new DateTime($periodo->fecha_inicio);
        $end = new DateTime($periodo->fecha_fin);

        $interval = DateInterval::createFromDateString('1 day');
        while ($start->format("w") != $this->dia)
            $start->add($interval);

        $dias = $this->frecuencia_semanas * 7;
        $interval = DateInterval::createFromDateString($dias . ' days');
        $period = new DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
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

    public function eliminar_clases($start = null) {
        $periodo = $this->get_periodo();
        if($start == null)
            $start = new DateTime($periodo->fecha_inicio);
        elseif($start->diff($periodo->fecha_fin)->invert==0 )
            throw new Exception("Fuera del periodo");
        $this->db->where('Horario_id', $this->id);
        $this->db->where('fecha >=', $start->format("Y-m-d"));
        $this->db->delete('clase');
    }

    public function get_dias()
    {
        return array(
            "Domingo",
            "Lunes",
            "Martes",
            "Mi&eacute;rcoles",
            "Jueves",
            "Viernes",
            "S&aacute;bado"
        );
    }

    public function get_carrera($Asignatura_id) {
        $this->db->select('IF(COUNT(DISTINCT c.id) > 1, \'VARIAS\', c.nombre) AS carrera');
        $this->db->from('asignatura_carrera AS ac');
        $this->db->join('carrera AS c', 'ac.Carrera_id = c.id');
        $this->db->group_by('ac.Asignatura_id');
        $this->db->where('ac.Asignatura_id', $Asignatura_id);
        return $this->db->get()->row()->carrera;
    }


    /**
     * @param $entity
     * @return Entity
     */
    protected function is_invalid($entity)
    {
        // TODO: Implement is_invalid() method.
    }
}