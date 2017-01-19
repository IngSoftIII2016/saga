<?php
require_once APPPATH . '/models/orm/Entity.php';
class Usuario extends Entity
{
    public $id;
    public $nombre;
    public $apellido;
    public $password;
    public $email;
    public $estado;
    public $rol;

    /**
     * Retorna el nombre de la tabla correspondiente a ésta Entity
     * @return string Nombre de la tabla
     */
    public function get_table_name()
    {
        return 'usuario';
    }
    /**
     * Retorna un arreglo de string con los nombres de las columnas que no son claves primarias ni foráneas.
     * @return array columnas
     */

    public function get_property_column_names()
    {
        return ['nombre', 'apellido', 'password', 'email','estado'];
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
                'entity_class_name' => 'Rol',
                'foreign_key_column_name' => 'Rol_id',
                'property_name' => 'rol'
            ]
        ];

    }
    /**
     * @return mixed
     */
    public function get_relations_one_to_many()
    {
        return [];
    }


    /**
     * @return mixed
     */
    public function get_relations_many_to_many()
    {
        return [];
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
        if(isset($data['nombre'])) $this->nombre = $data['nombre'];
        if(isset($data['apellido'])) $this->apellido = $data['apellido'];
        if(isset($data['password'])) $this->password = $data['password'];
        if(isset($data['email'])) $this->email = $data['email'];
        if(isset($data['estado'])) $this->estado = $data['estado'];
        if(isset($data['rol'])) $this->rol = $data['rol'];
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
        $data['apellido'] = $this->apellido;
        $data['password'] = $this->password;
        $data['email'] = $this->email;
        $data['estado'] = $this->estado;
        $data['Rol_id'] = $this->rol->id;
        return $data;

    }
}