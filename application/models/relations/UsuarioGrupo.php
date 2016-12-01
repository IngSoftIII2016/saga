<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 24/11/16
 * Time: 03:53
 */
require_once APPPATH . '/models/orm/Relation.php';

class UsuarioGrupo extends Relation
{
    public $usuario;
    public $grupo;

    /**
     * Retorna el nombre de la tabla correspondiente a ésta Entity
     * @return string Nombre de la tabla
     */
    public function get_table_name()
    {
        return 'usuario_grupo';
    }

    /**
     * Retorna un arreglo de string con los nombres de las columnas que no son claves primarias ni foráneas.
     * @return array columnas
     */
    public function get_property_column_names()
    {
        return [];
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
                'entity_class_name' => 'Usuario',
                'foreign_key_column_name' => 'usuario_id',
                'property_name' => 'usuario'
            ],
            [
                'entity_class_name' => 'Grupo',
                'foreign_key_column_name' => 'grupo_id',
                'property_name' => 'grupo'
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
        if(isset($data['usuario'])) $this->usuario = $data['usuario'];
        if(isset($data['grupo'])) $this->grupo = $data['grupo'];
    }

    /**
     * Devuelve un arreglo asociativo con una representación de ésta instancia de la Entity, cuyas claves coinciden
     * con los nombres de las columnas de la tabla a la que corresponde
     * @return array
     */
    public function to_row()
    {
        $data['usuario_id'] = $this->usuario->get_id();
        $data['grupo_id'] = $this->grupo->get_id();
        return $data;
    }

}