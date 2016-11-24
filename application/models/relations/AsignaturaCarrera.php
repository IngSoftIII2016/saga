<?php

require_once APPPATH . '/models/orm/Relation.php';
/**
 * Created by PhpStorm.
 * User: sandr
 * Date: 22/11/2016
 * Time: 4:45 PM
 */
class AsignaturaCarrera extends Relation
{
    public $anio;
    public $regimen;
    public $asignatura;
    public $carrera;

    /**
     * Retorna el nombre de la tabla correspondiente a ésta Entity
     * @return string Nombre de la tabla
     */
    public function get_table_name()
    {
        return 'asignatura_carrera';
    }

    /**
     * Retorna un arreglo de string con los nombres de las columnas que no son claves primarias ni foráneas.
     * @return array columnas
     */
    public function get_property_column_names()
    {
        return ['anio', 'regimen'];
    }


    /**
     * Retorna un arreglo de las relaciones uno-a-uno o uno-a-muchos que posee ésta Entity.
     * Cada relación se representa con un arreglo asociativo que contiene las siguientes claves:
     *  - entity_class_name : string Fully qualifiqued Name de la clase entity correspondiente a la entidad destino
     *  - foreign_key_column_name : string El nombre de la columna correspondiente a la clave foránea de esta relación
     *  - property_name : string Nombre de la propiedad en donde colocar el objeto Entity
     * @return array Relaciones muchos a uno
     */
    public function get_relations_many_to_one()
    {
        return [
            [
                'entity_class_name' => 'Asignatura',
                'foreign_key_column_name' => 'Asignatura_id',
                'property_name' => 'asignatura'
            ],
            [
                'entity_class_name' => 'Carrera',
                'foreign_key_column_name' => 'Carrera_id',
                'property_name' => 'carrera'
            ]
        ];
    }

    /**
     * Establece las propiedades de la Entity en base al arreglo asociativo recibido.
     * @param array $data
     * @return none
     */
    public function from_row($data)
    {
        if(isset($data['anio'])) $this->anio = $data['anio'];
        if(isset($data['regimen'])) $this->regimen = $data['regimen'];
        if(isset($data['asignatura'])) $this->asignatura = $data['asignatura'];
        if(isset($data['carrera'])) $this->carrera = $data['carrera'];
    }

    /**
     * Devuelve un arreglo asociativo con una representación de ésta instancia de la Entity, cuyas claves coinciden
     * con los nombres de las columnas de la tabla a la que corresponde
     * @return array
     */
    public function to_row()
    {
        $data['anio'] = $this->anio;
        $data['regimen'] = $this->regimen;
        $data['Asignatura_id'] = $this->asignatura->get_id();
        $data['Carrera_id'] = $this->carrera->get_id();
        return $data;
    }

}