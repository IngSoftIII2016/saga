<?php


abstract class Entity
{

    /**
     * Retorna el nombre de la tabla correspondiente a ésta Entity
     * @return string Nombre de la tabla
     */
    public abstract function get_table_name();

    /**
     * @return string
     */
    public function get_primary_key_column_name() {
        return 'id';
    }

    /**
     * Retorna un arreglo de string con los nombres de las columnas que no son claves primarias ni foráneas.
     * @return array columnas
     */
    public abstract function get_property_column_names();

    /**
     * Retorna un arreglo de las relaciones uno-a-uno o uno-a-muchos que posee ésta Entity.
     * Cada relación se representa con un arreglo asociativo que contiene las siguientes claves:
     *  - entity_class_name : string Fully qualifiqued Name de la clase entity correspondiente a la entidad destino
     *  - foreing_key_column_name : string El nombre de la columna correspondiente a la clave foránea de esta relación
     *  - property_name : string Nombre de la propiedad en donde colocar el objeto Entity
     * @return array Relaciones a uno-a-uno o muchos-a-uno
     */
    public abstract function get_relations_to_one();

    /**
     * @return mixed
     */
    public abstract function get_relations_to_many();

    /**
     * @return mixed
     */
    public abstract function getId();
    /**
     * Establece las propiedades de la Entity en base al arreglo asociativo recibido.
     * @param array $array
     * @return none
     */
    public abstract function from_row($array);

    /**
     * Devuelve un arreglo asociativo con una representación de ésta instancia de la Entity, cuyas claves coinciden
     * con los nombres de las columnas de la tabla a la que corresponde
     * @return array
     */
    public abstract function to_row();

}