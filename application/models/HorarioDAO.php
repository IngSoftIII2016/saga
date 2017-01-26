<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class HorarioDAO extends BaseDAO {


    public function __construct() {
        parent::__construct('Horario');
    }

    public function get_colisiones($horario) {
        $hora_fin = date("H:i:s", strtotime($horario->hora_inicio) +
            strtotime($horario->duracion) - strtotime("00:00:00"));

        $filtros = [
            'comision.periodo.id' => $horario->comision->periodo->id,
            'dia' => $horario->dia,
            'aula.id' => $horario->aula->id,
            'hora_inicio <' => $hora_fin,
            // al dejar el valor vacio, la clave es evaluada como una condicion WHERE en SQL unida al resto con AND.
            // Hay que tener en cuenta los alias que genera BaseDAO. horario_ horario_comision_asignatura_
            "(SELECT ADDTIME(horario_.hora_inicio, horario_.duracion)) > '$horario->hora_inicio'" => ''
        ];
        if(isset($horario->id))
            $filtros['id !='] = $horario->id;

        return $this->query(
            $filtros,
            [],
            ['comision.asignatura']
        );
    }


    protected function after_insert($entity)
    {
        $this->insertar_clases($entity);
    }

    public function after_update($horario)
    {
        $this->eliminar_clases($horario);
        $this->insertar_clases($horario);
    }

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

        if($start->diff($end)->invert == 1)
            throw new Exception("Fuera del periodo");

        $interval = DateInterval::createFromDateString('1 day');
        while ($start->format("w") != $horario->dia)
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
        $horario = $this->query(['id' => $horario->id], [], ['comision.periodo'])[0];
        if($fecha_desde != null)
            $start = DateTime::createFromFormat("Y-m-d", $fecha_desde);
        else
            $start = DateTime::createFromFormat("Y-m-d", $horario->comision->periodo->fecha_inicio);
        $end = DateTime::createFromFormat("Y-m-d", $horario->comision->periodo->fecha_fin);

        if($start->diff($end)->invert == 1 )
            throw new Exception("Fuera del periodo");

        $this->db->where('Horario_id', $horario->id);
        $this->db->where('fecha >=', $start->format("Y-m-d"));
        $this->db->delete('clase');
    }

    /**
     * Realiza una validación contra la base de datos previa a la inserción.
     * Si el resultado de la validación es correcto devuelve FALSE. En caso contrario
     * devuelve un arreglo asociativo con un mensaje de error en la clave 'error' y
     * opcionalmente un conjunto de datos asociados al error en la clave 'data'.
     * @param $entity entidad a validar
     * @return mixed FALSE o array asociativo con información del error
     */
    protected function is_invalid_insert($entity)
    {
        return $this->is_invalid($entity);
    }

    /**
     * Realiza una validación contra la base de datos previa a la modificación.
     * Si el resultado de la validación es correcto devuelve FALSE. En caso contrario
     * devuelve un arreglo asociativo con un mensaje de error en la clave 'error' y
     * opcionalmente un conjunto de datos asociados al error en la clave 'data'.
     * @param $entity entidad a validar
     * @return mixed FALSE o array asociativo con información del error
     */
    protected function is_invalid_update($entity)
    {
        return $this->is_invalid($entity);
    }

    /**
     * Realiza una validación contra la base de datos previa a la eliminición.
     * Si el resultado de la validación es correcto devuelve FALSE. En caso contrario
     * devuelve un arreglo asociativo con un mensaje de error en la clave 'error' y
     * opcionalmente un conjunto de datos asociados al error en la clave 'data'.
     * @param $entity entidad a validar
     * @return mixed FALSE o array asociativo con información del error
     */
    protected function is_invalid_delete($entity)
    {
        return FALSE;
    }

    /**
     * @param $entity
     * @return array|bool
     */
    private function is_invalid($entity)
    {
        $colisiones = $this->get_colisiones($entity);
        if (count($colisiones) > 0) {
            return [
                'error' => self::generar_error('Horario ocupado','Ya existe un horario asignado a esa aula en el rango horario ingresado'),
                'data' => $colisiones
            ];
        }else
            return FALSE;
    }


}