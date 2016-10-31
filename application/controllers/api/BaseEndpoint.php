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

    protected function parse_params() {
        $params = [
            'filters' => [],
            'sorts' => [],
            'includes' => [],
            'page' => 1,
            'size' => 20
        ];
        $get = $this->get();
        if(!empty($get['sort'])) {
            $sorts_fields = explode(',', $get['sort']);
            foreach ($sorts_fields as $sort_field) {
                $first_char = substr($sort_field, 0, 1);
                if($first_char == '-' || $first_char == '+')
                    $params['sorts'][substr($sort_field, 1)] = $first_char;
                else
                    $params['sorts'][$sort_field] = '+';
            }
            unset($get['sort']);
        }
        if(!empty($get['include'])) {
            $params['includes'] = explode(',', $get['include']);
            unset($get['include']);
        }
        if(!empty($get['page'])) {
            $params['page'] = $get['page'];
            unset($get['page']);
        }if(!empty($get['size'])) {
            $params['size'] = $get['size'];
            unset($get['size']);
        }
        foreach($get as $field => $value){
            $dot_path = str_replace('_', '.', $field);
            $params['filters'][$dot_path] = $value;
        }
        return $params;
    }


}