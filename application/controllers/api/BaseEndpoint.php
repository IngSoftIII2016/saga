<?php
require APPPATH . '/libraries/REST_Controller.php';

require_once APPPATH . '/models/entities/Aula.php';
require_once APPPATH . '/models/entities/Asignatura.php';
require_once APPPATH . '/models/entities/Carrera.php';
require_once APPPATH . '/models/entities/Clase.php';
require_once APPPATH . '/models/entities/Comision.php';
require_once APPPATH . '/models/entities/Docente.php';
require_once APPPATH . '/models/entities/Edificio.php';
require_once APPPATH . '/models/entities/Evento.php';
require_once APPPATH . '/models/entities/Horario.php';
require_once APPPATH . '/models/entities/Localidad.php';
require_once APPPATH . '/models/entities/Periodo.php';
require_once APPPATH . '/models/entities/Recurso.php';
require_once APPPATH . '/models/entities/Sede.php';
require_once APPPATH . '/models/entities/TipoRecurso.php';

class BaseEndpoint extends REST_Controller
{
    private $entity_class;

    public function __construct($entity_class)
    {
        parent::__construct();
        $this->entity_class = $entity_class;
    }

    protected function json_to_entity($json) {
        $entity = new $this->entity_class;

        $columns = $entity->get_property_column_names();
        array_unshift($columns, $entity->get_primary_key_column_name());
        $data = [];
        foreach ($columns as $column) {
            $data[$column] = $json[$column];
        }
        foreach ($entity->get_relations_many_to_one() as $relation) {
            $related_entity = new $relation['entity_class_name'];
            $related_entity->from_row($json[$relation['property_name']]);
            $data[$relation['property_name']] = $related_entity;
        }
        $entity->from_row($data);
        return $entity;
    }
}