<?php
require_once APPPATH . '/models/orm/Entity.php';

class Aula extends Entity
{
    private $id;
    private $nombre;
    private $ubicacion;
    private $capacidad;

    /**
     * Retorna el nombre de la tabla correspondiente a ésta Entity
     * @return string Nombre de la tabla
     */
    public function get_table_name()
    {
        return 'aula';
    }

    /**
     * Retorna un arreglo de string con los nombres de las columnas que no son claves primarias ni foráneas.
     * @return array columnas
     */
    public function get_property_column_names()
    {
        return ['capacidad', 'nombre', 'ubicacion'];
    }

    /**
     * Retorna un arreglo de las relaciones uno-a-uno o uno-a-muchos que posee ésta Entity.
     * Cada relación se representa con un arreglo asociativo que contiene las siguientes claves:
     *  - entity_class_name : string Fully qualifiqued Name de la clase entity correspondiente a la entidad destino
     *  - foreing_key_column_name : string El nombre de la columna correspondiente a la clave foránea de esta relación
     *  - property_name : string Nombre de la propiedad en donde colocar el objeto Entity
     * @return array Relaciones a uno-a-uno o muchos-a-uno
     */
    public function get_relations_to_one()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function get_relations_to_many()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        $this->id;
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
        if(isset($data['ubicacion'])) $this->ubicacion = $data['ubicacion'];
        if(isset($data['capacidad'])) $this->capacidad = $data['capacidad'];
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
        $data['ubicacion'] = $this->ubicacion;
        $data['capacidad'] = $this->capacidad;
    }
}