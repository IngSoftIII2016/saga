<?php

require_once APPPATH . '/models/orm/Relation.php';
/**
 * Created by PhpStorm.
 * User: sandro
 * Date: 5/1/2017
 * Time: 1:49 PM
 */
class AccionRol extends Relation
{

    /**
     * Retorna el nombre de la tabla correspondiente a ésta Relacion
     * @return string Nombre de la tabla de relacion
     */
    public function get_table_name()
    {
        return "accion_rol";
    }

    /**
     * Retorna un arreglo de las entidades muchos a uno que posee ésta Relacion.
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
                'entity_class_name' => 'Accion',
                'foreign_key_column_name' => 'Accion',
                'property_name' => 'accion'
            ],
            [
                'entity_class_name' => 'Rol',
                'foreign_key_column_name' => 'Rol_id',
                'property_name' => 'rol'
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
        // TODO: Implement from_row() method.
    }

    /**
     * Devuelve un arreglo asociativo con una representación de ésta instancia de la Entity, cuyas claves coinciden
     * con los nombres de las columnas de la tabla a la que corresponde
     * @return array
     */
    public function to_row()
    {
        // TODO: Implement to_row() method.
    }
}