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
require_once APPPATH . '/models/entities/Usuario.php';
require_once APPPATH . '/models/entities/Grupo.php';
require_once APPPATH . '/models/entities/Parametros.php';
require_once APPPATH . '/models/relations/AsignaturaCarrera.php';
require_once APPPATH . '/models/relations/UsuarioGrupo.php';


abstract class BaseEndpoint extends REST_Controller
{
    protected $entity_class;

    public function __construct($entity_class)
    {
        parent::__construct();
        $this->entity_class = $entity_class;
    }

    protected abstract function getDAO();

    protected function base_get($id = null) {

        if ($id != null)
            if($id == 0) // para obtener solo la cantidad de elementos
                $this->response( ['data' => $this->getDAO()->get_total_rows()] );
            else {
                $result = $this->getDAO()->query(['id' => $id], [], []);
                if(count($result) != 1) $this->response(['error' => 'not found' ], 404);
                else $this->response(['data' => $result[0]]);
            }
        else {
            $params = $this->parse_params();
            $rows = 0;
            $entities = $this->getDAO()->query($params['filters'], $params['sorts'], $params['includes'],$params['likes'] ,$params['page'], $params['size'], $rows);
            $this->response( ['data' => $entities, 'rowCount' => $rows] );
        }
    }

    protected function base_post() {
        $json = $this->post('data');
        $entity = $this->json_to_entity($json);
        $result = $this->getDAO()->insert($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }


    protected function base_put() {
        $json = $this->put('data');
        $entity = $this->json_to_entity($json);
        $result = $this->getDAO()->update($entity);
        if (array_key_exists('error', $result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    protected function base_delete($id) {
        $entity = new $this->entity_class;
        $rel_prop = [];
        foreach ($entity->get_relations_many_to_one() as $rel)
            $rel_prop[] = $rel['property_name'];
        $entity = $this->getDAO()->query(['id' => $id], [], $rel_prop)[0];
        if($entity == null)
            $this->response(['error' => "$entity->get_table_name() inexistente"], 404);
        $result = $this->getDAO()->delete($entity);
        if (is_array($result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }

    protected function json_to_entity($json) {
        return self::array_to_entity_rec($json, $this->entity_class);
        /*
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
        */
    }

    protected static function array_to_entity_rec($array, $entity_class) {
        $entity = new $entity_class;

        $columns = $entity->get_property_column_names();
        array_unshift($columns, $entity->get_primary_key_column_name());

        $data = [];
        foreach ($columns as $column)
            $data[$column] = $array[$column];

        foreach($entity->get_relations_many_to_one() as $relation) {
            if(isset($array[$relation['property_name']]))
                $data[$relation['property_name']] =
                    self::array_to_entity_rec($array[$relation['property_name']], $relation['entity_class_name']);
        }
        $entity->from_row($data);
        return $entity;
    }

    protected function parse_params() {
        $params = [
            'filters' => [],
            'sorts' => [],
            'includes' => [],
            'likes' => [],
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
        if(!empty($get['like'])) {
            $likes = explode(',', $get['like']);
            foreach($likes as $like) {

                $arr = explode(':' , $like);
                $arr[1] = str_replace('*','%',$arr[1]);
                $params['likes'] [$arr[0]] = $arr[1];
            }

            //$params['likes'
            unset($get['like']);
        }
        if(!empty($get['page'])) {
            $params['page'] = $get['page'];
            unset($get['page']);

        }if(!empty($get['size'])) {
            $params['size'] = $get['size'];
            unset($get['size']);
        }
				foreach($get as $field => $value){
					  if(!empty($get[$field])){
                $dot_path = str_replace('_', '.', $field);
						    $params['filters'][$dot_path] = $value;
						}
        }
        return $params;
    }

}
