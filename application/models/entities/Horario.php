<?php
require_once APPPATH . '/models/orm/Entity.php';

class Horario extends Entity
{
    private $id;
    private $descripcion;
    private $frecuencia_semanas;
    private $dia;
    private $hora_inicio;
    private $duracion;
    private $aula;
    private $comision;

    /**
     * Retorna el nombre de la tabla correspondiente a ésta Entity
     * @return string Nombre de la tabla
     */
    public function get_table_name()
    {
        return 'horario';
    }

    /**
     * Retorna un arreglo de string con los nombres de las columnas que no son claves primarias ni foráneas.
     * @return array columnas
     */
    public function get_property_column_names()
    {
        return ['descripcion', 'dia', 'duracion', 'frecuencia_semanas', 'hora_inicio'];
    }

    /**
     * Retorna un arreglo de las relaciones uno-a-uno o uno-a-muchos que posee ésta Entity.
     * Cada relación se representa con un arreglo asociativo que contiene las siguientes claves:
     *  - entity_class : string Fully qualifiqued Name de la clase entity correspondiente a la entidad destino
     *  - foreing_key_column_name : string El nombre de la columna correspondiente a la clave foránea de esta relación
     *  - property_name : string Nombre de la propiedad en donde colocar el objeto Entity
     * @return array Relaciones a uno-a-uno o muchos-a-uno
     */
    public function get_relations_many_to_one()
    {
        return [
            [
                'entity_class_name' => 'Aula',
                'foreing_key_column_name' => 'Aula_id',
                'property_name' => 'aula'
            ],
            [
                'entity_class_name' => 'Comision',
                'foreing_key_column_name' => 'Comision_id',
                'property_name' => 'comision'
            ]
        ];
    }

    public function get_relations_one_to_many()
    {
        // TODO: Implement get_relations_to_many() method.
    }

    public function get_id()
    {
        return $this->id;
    }

    /**
     * Establece las propiedades de la Entity en base al arreglo asociativo recibido.
     * @param array $data
     * @return none
     */
    public function from_row($data)
    {
        if(isset($data['id'])) $this->id = $data['id'];
        if(isset($data['descripcion'])) $this->descripcion = $data['descripcion'];
        if(isset($data['frecuencia_semanas'])) $this->frecuencia_semanas = $data['frecuencia_semanas'];
        if(isset($data['dia'])) $this->dia = $data['dia'];
        if(isset($data['hora_inicio'])) $this->hora_inicio = $data['hora_inicio'];
        if(isset($data['duracion'])) $this->duracion = $data['duracion'];
        if(isset($data['aula'])) $this->aula = $data['aula'];
        if(isset($data['comision'])) $this->comision = $data['comision'];

    }

    /**
     * Devuelve un arreglo asociativo con una representación de ésta instancia de la Entity, cuyas claves coinciden
     * con los nombres de las columnas de la tabla a la que corresponde
     * @return array
     */
    public function to_row()
    {
        $data['id'] = $this->id;
        $data['descripcion'] = $this->descripcion;
        $data['frecuencia_semanas'] = $this->frecuencia_semanas;
        $data['dia'] = $this->dia;
        $data['hora_inicio'] = $this->hora_inicio;
        $data['duracion'] = $this->duracion;
        $data['Aula_id'] = $this->aula->get_id();
        $data['Comision_id'] = $this->comision->get_id();
        return $data;
    }
}
