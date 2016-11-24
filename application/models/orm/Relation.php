<?php

/**
 * Created by PhpStorm.
 * User: sandr
 * Date: 22/11/2016
 * Time: 4:34 PM
 */
abstract class Relation
{
    /**
     * Retorna el nombre de la tabla correspondiente a ésta Relacion
     * @return string Nombre de la tabla de relacion
     */
    public abstract function get_table_name();

    /**
     * Retorna un arreglo de las entidades muchos a uno que posee ésta Relacion.
     * Cada relación se representa con un arreglo asociativo que contiene las siguientes claves:
     *  - entity_class_name : string Fully qualifiqued Name de la clase entity correspondiente a la entidad destino
     *  - foreign_key_column_name : string El nombre de la columna correspondiente a la clave foránea de esta relación
     *  - property_name : string Nombre de la propiedad en donde colocar el objeto Entity
     * @return array Relaciones a uno-a-uno o muchos-a-uno
     */
    public abstract function get_relations_many_to_one();

    /**
     * Establece las propiedades de la Entity en base al arreglo asociativo recibido.
     * @param array $data
     * @return none
     */
    public abstract function from_row($data);

    /**
     * Devuelve un arreglo asociativo con una representación de ésta instancia de la Entity, cuyas claves coinciden
     * con los nombres de las columnas de la tabla a la que corresponde
     * @return array
     */
    public abstract function to_row();

}