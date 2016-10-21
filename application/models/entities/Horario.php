<?php

class Horario implements Entity
{
    private $id;
    private $descripcion;
    private $frecuencia_semanas;
    private $dia;
    private $hora_inicio;
    private $duracion;
    private $Comision_id;
    private $Aula_id;

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

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function from_row($row)
    {
        // TODO: Implement from_row() method.
    }

    public function to_row()
    {
        // TODO: Implement to_row() method.
    }

}