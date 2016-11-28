<?php
/**
 * Created by PhpStorm.
 * User: Juan Pablo Aveggio
 * Date: 20/10/16
 * Time: 18:33
 */

require_once APPPATH . '/models/entities/Asignatura.php';
require_once APPPATH . '/models/entities/Aula.php';
require_once APPPATH . '/models/entities/Carrera.php';
require_once APPPATH . '/models/entities/Clase.php';
require_once APPPATH . '/models/entities/Comision.php';
require_once APPPATH . '/models/entities/Docente.php';
require_once APPPATH . '/models/entities/Edificio.php';
require_once APPPATH . '/models/entities/Evento.php';
require_once APPPATH . '/models/entities/Grupo.php';
require_once APPPATH . '/models/entities/Horario.php';
require_once APPPATH . '/models/entities/Localidad.php';
require_once APPPATH . '/models/entities/Periodo.php';
require_once APPPATH . '/models/entities/Recurso.php';
require_once APPPATH . '/models/entities/Sede.php';
require_once APPPATH . '/models/entities/TipoRecurso.php';
require_once APPPATH . '/models/entities/Usuario.php';

/**
 * Class Base_DAO
 */
abstract class BaseDAO extends CI_Model
{
    protected $entity_class = NULL;

    protected $entity;

    protected $debug = FALSE;

    public function __construct($entity_class)
    {
        parent::__construct();
        if(empty($entity_class)) throw new Exception("Empty Entity class name!");
        $this->entity_class = $entity_class;
        $this->entity = new $entity_class;
        $this->load->database();
    }

    /**
     * Realiza una consulta con filtros, ordenamiento, paginación e inclusion
     * relaciones. 
     * @param array $filters arreglo asociativo de flitros. Cada filtro se 
     * representa por un par clave valor. La clave es una ruta hacia un 
     * atributo junto a un operador de comparación. La ruta se representa por 0
     * o mas propiedades de Entity relacionados separados por puntos y un 
     * nombre de columna al final. El operador de comparación puede ser =, <, 
     * <=, >, >= o !=. Si se omite éste se sobreentiende =. El valor 
     * correspondiente a cada clave el valor con el que comparar el atributo.
     * Si se omite el valor (es decir se coloca '') se interpretará la clave 
     * como una condicion literal de la clausula WHERE de sql (usar el modo de 
     * depuración para ver las alias asignadas).
     * @param array $sorts arreglo asociativo de ordenamientos. Las claves son
     * rutas a atributos iguales a las de filters aunque sin operador de
     * comparación. Los valores indican si el ordenamiento debe ser ascendente
     * o descendente, siendo 'ASC', '+' o '' ascendente y 'DESC' o '-' descendente.
     * @param array $includes Un arreglo de rutas a subentidades que serán
     * incluidas en los objetos Entity de resultado. 
     * @param int $page página actual resultados. Si se se devuelve la primera.
     * @param int $size tamaño de página, en cantidad de resultados. Si se 
     * omite se utiliza un tamaño de 20.
     * @return array arreglo de Entity
     */
    public function query($filters = [], $sorts = [], $includes = [], $likes = [] ,$page = 1, $size = 20)
    {
        $this->do_base_query();
        $this->do_filter($filters);
        $this->do_like($likes);
        $this->do_sort($sorts);
        $this->do_paging($page, $size);
        return $this->get_result_entities($includes);
    }

        /**
         * @param $id
         * @return Entity
         */
    public function get_by_id($id)
    {
        $this->do_base_query();
       // $this->do_filter([$this->entity->get_table_name().".".$this->entity->get_primary_key_column_name() => $id]);
        $this->do_filter([$this->entity->get_primary_key_column_name() => $id]);

        return $this->get_result_entities();
    }

    /**
     * @param $entity
     * @return array
     */
    public function insert($entity)
    {
        $this->db->trans_start();

        $this->before_insert($entity);

        $error = $this->is_invalid_insert($entity);
        if ($error) {
            $this->db->trans_rollback();
            return ['error' => $error];
        }

        if (!$this->db->insert($entity->get_table_name(), $entity->to_row())) {
            $this->db->trans_rollback();
            return ['error' => 'Fails on insert to db.'];
        }

        $id = $this->db->insert_id();
        $entity->from_row([$entity->get_primary_key_column_name() => $id]);

        $this->after_insert($entity);

        $this->db->trans_complete();

        return $entity;
    }

    /**
     * @param $entity
     * @return array|Entity
     */
    public function update($entity)
    {
        $this->db->trans_start();

        $this->before_update($entity);

        $error = $this->is_invalid_update($entity);
        if($error) {
            $this->db->trans_rollback();
            return ['error' => $error];
        }

        $this->db->where($entity->get_primary_key_column_name(), $entity->get_id());
        if(!$this->db->update($entity->get_table_name(), $entity->to_row())) {
            $this->db->trans_rollback();
            return ['error' => 'Fails on update to db'];
        }

        $this->after_update($entity);

        $this->db->trans_complete();

        return $entity;
    }

    /**
     * @param $entity
     * @return array|Entity
     */
    public function delete($entity)
    {
        $this->db->trans_start();

        $this->before_delete($entity);

        $error =  $this->is_invalid_delete($entity);
        if ($error) {
            $this->db->trans_rollback();
            return ['error' => $error];
        }
        $this->db->where($entity->get_primary_key_column_name(), $entity->get_id());
        if(!$this->db->delete($entity->get_table_name())) {
            $this->db->trans_rollback();
            return ['error' => 'Fails on delete to db'];
        }

        $this->after_delete($entity);

        $this->db->trans_complete();

        return $entity;
    }

    public function get_total_rows() {
        $this->db->from($this->entity->get_table_name());
        return $this->db->count_all_results();
    }

    /**
     * Realiza una validación contra la base de datos previa a la inserción.
     * Si el resultado de la validación es correcto devuelve FALSE. En caso contrario
     * devuelve un arreglo asociativo con un mensaje de error en la clave 'error' y
     * opcionalmente un conjunto de datos asociados al error en la clave 'data'.
     * @param $entity entidad a validar
     * @return mixed FALSE o array asociativo con información del error
     */
    protected abstract function is_invalid_insert($entity);

    /**
     * Realiza una validación contra la base de datos previa a la modificación.
     * Si el resultado de la validación es correcto devuelve FALSE. En caso contrario
     * devuelve un arreglo asociativo con un mensaje de error en la clave 'error' y
     * opcionalmente un conjunto de datos asociados al error en la clave 'data'.
     * @param $entity entidad a validar
     * @return mixed FALSE o array asociativo con información del error
     */
    protected abstract function is_invalid_update($entity);

    /**
     * Realiza una validación contra la base de datos previa a la eliminición.
     * Si el resultado de la validación es correcto devuelve FALSE. En caso contrario
     * devuelve un arreglo asociativo con un mensaje de error en la clave 'error' y
     * opcionalmente un conjunto de datos asociados al error en la clave 'data'.
     * @param $entity entidad a validar
     * @return mixed FALSE o array asociativo con información del error
     */
    protected abstract function is_invalid_delete($entity);

    /**
     * @param $entity
     * @return Entity
     */
    protected function before_insert($entity)
    {
    }

    /**
     * @param $entity
     * @return Entity
     */
    protected function after_insert($entity)
    {
    }

    /**
     * @param $entity
     * @return Entity
     */
    protected function before_update($entity)
    {
    }

    /**
     * @param $entity
     * @return Entity
     */
    protected function after_update($entity)
    {
    }

    /**
     * @param $entity
     * @return Entity
     */
    protected function before_delete($entity)
    {
    }

    /**
     * @param $entity
     * @return Entity
     */
    protected function after_delete($entity)
    {
    }
  
    public function set_debug_enabled($enabled) {
        $this->debug = $enabled;
    }

    public function do_base_query()
    {
        $columns = []; $joins = [];
        self::build_base_query_arrays($this->entity, $columns, $joins);

        $this->db->select(implode(', ', $columns));

        foreach($joins as $join_table => $join_condition) {
            if (empty($join_condition)) $this->db->from($join_table);
            else $this->db->join($join_table, $join_condition, 'left');
        }
    }

    public function do_filter($filters)
    {
        foreach ($filters as $key => $value){
            if(empty($value)) $this->db->where($key);
            else {
                $exp_path = explode('.', $key);
                $column = array_pop($exp_path);
                array_unshift($exp_path, $this->entity->get_table_name());
                $alias = implode('_', $exp_path) . '_';
                $field = $alias . '.' . $column;
                $this->db->where($field, $value);
            }
        }
    }

    public function do_like($likes)
    {
        foreach ($likes as $key => $value){
            if(!empty($value)) {
                $exp_path = explode('.', $key);
                $column = array_pop($exp_path);
                array_unshift($exp_path, $this->entity->get_table_name());
                $alias = implode('_', $exp_path) . '_';
                $field = $alias . '.' . $column;
                $this->db->or_where("LOWER($field) LIKE LOWER('$value')");
            }
        }
    }
    
    public function do_sort($sorts) {
        foreach ($sorts as $key => $value) {
            $exp_path = explode('.', $key);
            $column = array_pop($exp_path);
            array_unshift($exp_path, $this->entity->get_table_name());
            $alias = implode('_', $exp_path) . '_';
            $field = $alias . '.' . $column;
            if($value == 'ASC' || $value == '+' || $value == '') {
                $this->db->order_by($field, 'ASC');
            }elseif($value == 'DESC' || $value == '-') {
                $this->db->order_by($field, 'DESC');
            }
        }
    }

    public function do_paging($page, $size) {
        if( $page > 0 && $size > 0)
            $this->db->limit($size, ($page-1) * $size);
    }
    public function get_result_entities($includes = []) {
        if($this->debug) return $this->db->get_compiled_select();
        $rows = $this->db->get()->result_array();
        $results = [];
        foreach ($rows as $row) {
            $object = new $this->entity_class;
            self::row_to_entity($object, $row, $includes);
            $results[] = $object;
        }
        return $results;
    }


    private static function build_base_query_arrays($entity, &$columns, &$joins, $alias_prefix = '', $foreign_key='') {
        if(!is_array($joins)) $joins = [];
        if(!is_array($columns)) $columns = [];

        $table = $entity->get_table_name();
        $primary_key = $entity->get_primary_key_column_name();
        $alias = $alias_prefix . $table . "_";

        if(count($joins) == 0)
            $joins["$table AS $alias"] = '';
        else {
            $joins["$table AS $alias"] = "$alias_prefix.$foreign_key = $alias.$primary_key";
        }

        $columns[] = "$alias.$primary_key AS $alias$primary_key";
        foreach ($entity->get_property_column_names() as $column)
            $columns[] = "$alias.$column AS $alias$column";



        foreach ($entity->get_relations_many_to_one() as $relation) {
            $related_entity = new $relation['entity_class_name'];
            $related_foreign_key = $relation['foreign_key_column_name'];
            self::build_base_query_arrays($related_entity, $columns, $joins, $alias, $related_foreign_key);
        }
    }

    public static function row_to_entity(&$entity, $row, $includes = [], $alias_prefix = '') {
        $table = $entity->get_table_name();
        $primary_key = $entity->get_primary_key_column_name();
        $alias = $alias_prefix . $table . "_";
        $columns = $entity->get_property_column_names();
        array_unshift($columns, $primary_key);
        $data = [];
        foreach ($columns as $column) {
            $data[$column] = $row[$alias.$column];
        }

        $this_includes = [];
        $next_includes = [];
        foreach($includes as $include) {
            $include_path = explode('.', $include);
            $next = array_shift($include_path);
            if(!in_array($next, $this_includes)) $this_includes[] = $next;
            $next_includes[] = implode('.', $include_path);
        }

        foreach ($entity->get_relations_many_to_one() as $relation) {
            $related_entity = new $relation['entity_class_name'];
            $relationship_property = $relation['property_name'];
            if(in_array($relationship_property, $this_includes)) {
                self::row_to_entity($related_entity, $row, $next_includes, $alias);
                $data[$relationship_property] = $related_entity;
            }
        }
/*
        foreach ($entity->get_relations_one_to_many() as $relation) {
            $relationship_property = $relation['property_name'];
            if(in_array($relationship_property, $this_includes)) {
                $entity->do_one_to_many_query($relation['entity_class_name'], $relationship_property);
            }
        }
*/

        $entity->from_row($data);
    }


    public static function do_one_to_many_query($entity, $relationship_entity, $relationship_property) {

    }
}