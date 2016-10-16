<?php

class Horario
{
    public $id;
    public $descripcion;
    public $frecuencia_semanas;
    public $dia;
    public $hora_inicio;
    public $duracion;
    public $Comision_id;
    public $Aula_id;

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

}