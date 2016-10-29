<?php
require_once APPPATH . '/models/orm/Entity.php';
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 24/10/16
 * Time: 01:42
 */
class Comision extends Entity
{

    public $id;
    public $nombre;
    public  $asignatura;
    public  $periodo;


    /**
     * Retorna el nombre de la tabla correspondiente a ésta Entity
     * @return string Nombre de la tabla
     */
    public function get_table_name()
    {
        return 'comision';
    }

    /**
     * Retorna un arreglo de string con los nombres de las columnas que no son claves primarias ni foráneas.
     * @return array columnas
     */
    public function get_property_column_names()
    {
        return ['nombre'];
    }

    /**
     * @return mixed
     */
    public function get_relations_one_to_one()
    {
        return [];
    }


    /**
     * Retorna un arreglo de las relaciones uno-a-uno o uno-a-muchos que posee ésta Entity.
     * Cada relación se representa con un arreglo asociativo que contiene las siguientes claves:
     *  - entity_class_name : string Fully qualifiqued Name de la clase entity correspondiente a la entidad destino
     *  - foreign_key_column_name : string El nombre de la columna correspondiente a la clave foránea de esta relación
     *  - property_name : string Nombre de la propiedad en donde colocar el objeto Entity
     * @return array Relaciones a uno-a-uno o muchos-a-uno
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
        		'entity_class_name' => 'Periodo',
        		'foreign_key_column_name' => 'Periodo_id',
        		'property_name' => 'periodo'
                ]
        ];
    }

    /**
     * @return mixed
     */
    public function get_relations_one_to_many()
    {
        return [
            [
                'entity_class_name' => 'Horario',
                'foreign_key_column_name' => 'Horario_id',
                'property_name' => 'horarios'
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function get_relations_many_to_many()
    {
        return [
        /*    [
                'entity_class_name' => 'Docente',
                'junction_table' => 'comision_docente',
                'this_foreign_key' => 'Comision_id',
                'other_foreign_key' => 'Docente_id'
            ] */
        ];
    }

    /**
     * @return mixed
     */
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
        if(isset($data['nombre'])) $this->nombre = $data['nombre'];
        if(isset($data['asignatura'])) $this->asignatura = $data['asignatura'];
        if(isset($data['periodo'])) $this->periodo= $data['periodo'];
    }

    /**
     * Devuelve un arreglo asociativo con una representación de ésta instancia de la Entity, cuyas claves coinciden
     * con los nombres de las columnas de la tabla a la que corresponde
     * @return array
     */
    public function to_row()
    {
        $data['id'] = $this->id;
        $data['nombre'] = $this->nombre;
        $data['Asignatura_id'] = $this->asignatura->get_id();
        $data['Periodo_id'] = $this->periodo->get_id();
        return $data;
    }


}