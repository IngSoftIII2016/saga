<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class HorarioDAO extends BaseDAO {


    public function __construct() {
        parent::__construct('Horario');
    }

/*
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
*/

    public function get_colisiones($horario) {
        $hora_fin = date("H:i:s", strtotime($this->hora_inicio) +
            strtotime($this->duracion) - strtotime("00:00:00"));

        $this->query(
            [
                'id !=' => $horario->id,
                'comision.periodo.id' => $horario->comision->periodo->id,
                'dia' => $horario->dia,
                'aula.id' => $horario->aula->id,
                'hora_inicio <' => $hora_fin,
                // al dejar el valor vacio, la clave es evaluada como una condicion WHERE en SQL unida al resto con AND.
                // Hay que tener en cuenta los alias que genera BaseDAO. horario_ horario_comision_asignatura_
                "(SELECT ADDTIME(horario_.hora_inicio, horario_.duracion)) > '$this->hora_inicio'" => ''
            ],
            [],
            ['comision.asignatura']
        );
    }




    /**
     * @param $entity
     * @return array|bool
     */
    protected function is_invalid($entity)
    {
        $colisiones = $this->get_colisiones($entity);
        if (count($colisiones) > 0) {
            return [
                'error' => 'Horario ocupado.',
                'data' => $colisiones
            ];
        }else
            return FALSE;
    }

/*
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
*/

    protected function after_insert($entity)
    {
        $this->insertar_clases($entity);
    }

/*
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
*/
    public function after_update($horario)
    {
        $this->eliminar_clases($horario);
        $this->insertar_clases($horario);
    }
/*
    public function delete($desde_date = null)
    {
        $this->db->trans_start();

        $this->eliminar_clases($desde_date);

        $this->db->delete('horario', array('id' => $this->id));

        $this->db->trans_complete();
    }
*/
    public function before_delete($horario)
    {
        $this->eliminar_clases($horario);
    }


    private function insertar_clases($horario)
    {
        $fecha_desde = $horario->get_fecha_desde();
        if($fecha_desde != null)
            $start = DateTime::createFromFormat("Y-m-d", $fecha_desde);
        else
            $start = DateTime::createFromFormat("Y-m-d", $horario->comision->periodo->fecha_inicio);

        $end = DateTime::createFromFormat("Y-m-d", $horario->comision->periodo->fecha_fin);

        if($start->diff($end)->invert==0 )
            throw new Exception("Fuera del periodo");

        $interval = DateInterval::createFromDateString('1 day');
        while ($start->format("w") != $this->dia)
            $start->add($interval);

        $dias = $horario->frecuencia_semanas * 7;
        $interval = DateInterval::createFromDateString($dias . ' days');
        $period = new DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $hora_fin = strtotime($horario->hora_inicio) + strtotime($horario->duracion) - strtotime("00:00:00");
            // TODO: Utilizar Entity Clase
            $clase = array(
                'fecha' => $dt->format("Y-m-d"),
                'hora_inicio' => $horario->hora_inicio,
                'hora_fin' => date("H:i:s", $hora_fin),
                'Aula_id' => $horario->aula->id,
                'Horario_id' => $horario->id
            );
            $this->db->insert('clase', $clase);
        }
    }

    private function eliminar_clases($horario) {
        $fecha_desde = $horario->get_fecha_desde();
        if($fecha_desde != null)
            $start = DateTime::createFromFormat("Y-m-d", $fecha_desde);
        else
            $start = DateTime::createFromFormat("Y-m-d", $horario->comision->periodo->fecha_inicio);
        $end = DateTime::createFromFormat("Y-m-d", $horario->comision->periodo->fecha_fin);

        if($start->diff($end)->invert==0 )
            throw new Exception("Fuera del periodo");

        $this->db->where('Horario_id', $this->id);
        $this->db->where('fecha >=', $start->format("Y-m-d"));
        $this->db->delete('clase');
    }

}