<?php

class Horario_model extends CI_Model
{
    public $id;
    public $descripcion;
    public $frecuencia_semanas;
    public $dia;
    public $hora_inicio;
    public $duracion;
    public $Comision_id;
    public $Aula_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        return $this->db->get('horario')->result();
    }

    public function from_array($data)
    {
        if(isset($data['id'])) $this->id = $data['id'];
        if(isset($data['descripcion'])) $this->descripcion = $data['descripcion'];
        if(isset($data['frecuencia_semanas'])) $this->frecuencia_semanas = $data['frecuencia_semanas'];
        if(isset($data['dia'])) $this->dia = $data['dia'];
        if(isset($data['hora_inicio'])) $this->hora_inicio = $data['hora_inicio'];
        if(isset($data['duracion'])) $this->duracion = $data['duracion'];
        if(isset($data['Comision_id'])) $this->Comision_id = $data['Comision_id'];
        if(isset($data['Aula_id'])) $this->Aula_id = $data['Aula_id'];
    }

    public function to_array()
    {
        $data['id'] = $this->id;
        $data['descripcion'] = $this->descripcion;
        $data['frecuencia_semanas'] = $this->frecuencia_semanas;
        $data['dia'] = $this->dia;
        $data['hora_inicio'] = $this->hora_inicio;
        $data['duracion'] = $this->duracion;
        $data['Comision_id'] = $this->Comision_id;
        $data['Aula_id'] = $this->Aula_id;
        return $data;
    }

    public function get_horarios($filtros)
    {
        $this->db->select("ho.*, au.nombre AS aula, ed.id AS Edificio_id, ed.nombre AS edificio, co.nombre AS comision, a.id AS Asignatura_id, a.nombre AS asignatura, do.id AS Docente_id, CONCAT(do.nombre, ' ', do.apellido) AS docente, pe.id AS Periodo_id");
        $this->db->from('horario AS ho');
        $this->db->join('aula AS au', 'ho.Aula_id = au.id');
        $this->db->join('edificio AS ed', 'au.Edificio_id = ed.id');
        $this->db->join('comision AS co', 'ho.Comision_id = co.id');
        $this->db->join('asignatura AS a', 'co.Asignatura_id = a.id');
        $this->db->join('asignatura_carrera ac', 'a.id = ac.Asignatura_id');
        $this->db->join('docente AS do', 'co.Docente_id = do.id', 'left');
        $this->db->join('periodo AS pe', 'co.Periodo_id = pe.id');
        $this->db->group_by('ho.id');
        if (isset($filtros['Comision_id']) && trim($filtros['Comision_id']) != "")
            $this->db->where('co.id', $filtros['Comision_id']);
        elseif (isset($filtros['Asignatura_id']) && trim($filtros['Asignatura_id']) != "")
            $this->db->where('a.id', $filtros['Asignatura_id']);
        elseif (isset($filtros['Carrera_id']) && trim($filtros['Carrera_id']) != "")
            $this->db->where('ac.Carrera_id', $filtros['Carrera_id']);
        if(isset($filtros['Aula_id']) && trim($filtros['Aula_id']) != "")
            $this->db->where('ho.Aula_id', $filtros['Aula_id']);
        elseif(isset($filtros['Edificio_id']) && trim($filtros['Edificio_id'] != ""))
            $this->db->where('ed.id', $filtros['Edificio_id']);
        if (isset($filtros['dia']) && trim($filtros['dia']) != "")
            $this->db->where('ho.dia', $filtros['dia']);
        if (isset($filtros['anio']) && trim($filtros['anio']) != "")
            $this->db->where('ac.anio', $filtros['anio']);
        if (isset($filtros['regimen']) && trim($filtros['regimen']) != "")
            $this->db->where('ac.regimen', $filtros['regimen']);
        if (isset($filtros['Periodo_id']) && trim($filtros['Periodo_id']) != "")
            $this->db->where('pe.id', $filtros['Periodo_id']);
        if (isset($filtros['Docente_id']) && trim($filtros['Docente_id']) != "")
            $this->db->where('do.id', $filtros['Docente_id']);

        $result = $this->db->get()->result_array();
        foreach($result as $i=>$value)
            $result[$i]['carrera'] = $this->get_carrera($value['Asignatura_id']);

        return $result;
    }

    public function load($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('horario')->row_array();
        $this->from_array($result);
    }

    public function get_periodo()
    {
        $this->db->select('p.*');
        $this->db->from('comision c');
        $this->db->join('periodo AS p', 'c.Periodo_id = p.id');
        $this->db->where('c.id', $this->Comision_id);
        return $this->db->get()->row();
    }

    public function get_comision(){
        $this->db->select("co.*, a.nombre asignatura");
        $this->db->from('comision AS co');
        $this->db->join('asignatura AS a', 'co.Asignatura_id = a.id');
        $this->db->where('co.id', $this->Comision_id);
        return $this->db->get()->row();
    }

    public function get_colisiones()
    {

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

            $id = $this->db->insert('horario', $this);
            if($id) $this->id = $id;
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
        if ($start == null) $start = new DateTime();
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


}