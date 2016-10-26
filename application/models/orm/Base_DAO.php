<?php
require_once APPPATH . '/models/entities/Aula.php';
require_once APPPATH . '/models/entities/Comision.php';
require_once APPPATH . '/models/entities/Horario.php';

/**
 * Class Base_DAO
 */
abstract class Base_DAO extends CI_Model
{
    protected $entity_class = NULL;

    protected $entity;

    public function __construct($entity_class)
    {
        parent::__construct();
        if(empty($entity_class)) throw new Exception("Empty Entity class name!");
        $this->entity_class = $entity_class;
        $this->entity = new $entity_class;
        $this->load->database();
    }

    /**
     * Realiza una consulta con filtros, ordenes y paginación. El resultado es una entity y sus relaciones también
     * @param array $filters
     * @param array $sorts
     * @param int $page
     * @param int $size
     * @return array arreglo de entity
     */
    public function query($filters = [], $sorts = [], $page = 1, $size = 20)
    {
        $this->do_base_query();
        $this->do_filter($filters);
        $this->do_sort($sorts);
        $this->do_paging($page, $size);
        return $this->get_result_entities();
    }

        /**
         * @param $id
         * @return Entity
         */
    public function get_by_id($id)
    {
        $this->do_base_query();
        $this->do_filter([$this->entity->get_table_name().".".$this->entity->get_primary_key_column_name() => $id]);
        return $this->get_result_entities();
    }

    /**
     * @param $entity
     * @return Entity
     */
    public function insert($entity)
    {
        $this->before_insert($entity);
        if($error = $this->is_invalid($entity))
            return ['error' => $error];
        if(!$this->db->insert($entity->get_table_name(), $entity->to_row()))
            return ['error' => 'Fails on insert to db.'];
        $this->after_insert($entity);
    }

    /**
     * @param $entity
     * @return Entity
     */
    public function update($entity)
    {
        $this->before_update($entity);
        if($error = $this->is_invalid($entity))
            return ['error' => $error];
        $this->db->where($entity->get_primary_key_column_name(), $entity->get_id());
        if(!$this->db->update($entity->get_table_name(), $entity->to_row()))
            return ['error' => 'Fails on update to db'];
        $this->after_update($entity);
    }

    /**
     * @param $entity
     * @return array
     */
    public function delete($entity)
    {
        $this->before_delete($entity);
        if($error = $this->is_invalid($entity))
            return ['error' => $error];
        $this->db->where($entity->get_primary_key_column_name(), $entity->get_id());
        if(!$this->db->delete($entity->get_table_name()))
        return ['error' => 'Fails on delete to db'];
        $this->after_delete($entity);
    }

    /**
     * @param $entity
     * @return Entity
     */
    protected abstract function is_invalid($entity);

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
                $alias = implode('_', $exp_path) . '_';
                $field = $alias . '.' . $column;
                $this->db->where($field, $value);
            }
        }
    }

    public function do_sort($sorts) {
        foreach ($sorts as $key => $value) {
            $exp_path = explode('.', $key);
            $column = array_pop($exp_path);
            $alias = implode('_', $exp_path) . '_';
            $field = $alias . '.' . $column;
            if($value == 'ASC' || $value == '+' || $value == '') {
                $this->db->order_by($field, 'ASC');
            }elseif($value == 'DESC' || $value == '-' || $value == '') {
                $this->db->order_by($field, 'DESC');
            }
        }
    }

    public function do_paging($page, $size) {
        $this->db->limit($size * $page, $size);
    }

    public function get_result_entities() {
        $rows = $this->db->get()->result_array();
        $results = [];
        foreach ($rows as $row) {
            $object = new $this->entity_class;
            self::row_to_entity($object, $row);
            $results[] = $object;
        }
        return $results;
    }


    private static function build_base_query_arrays($entity, &$columns, &$joins, $alias_prefix = '', $foreing_key='') {
        $table = $entity->get_table_name();
        $primary_key = $entity->get_primary_key_column_name();
        $alias = $alias_prefix . $table . "_";

        if(!is_array($columns)) $columns = [];

        $columns[] = "$alias.$primary_key AS $alias$primary_key";
        foreach ($entity->get_property_column_names() as $column)
            $columns[] = "$alias.$column AS $alias$column";

        if(!is_array($joins)) $joins = [];
        if(count($joins) == 0)
            $joins["$table AS $alias"] = '';
        else {
            $joins["$table AS $alias"] = "$alias_prefix.$foreing_key = $alias.$primary_key";
        }

        foreach ($entity->get_relations_many_to_one() as $relation) {
            $related_entity = new $relation['entity_class_name'];
            $related_foreing_key = $relation['foreing_key_column_name'];
            self::build_base_query_arrays($related_entity, $columns, $joins, $alias, $related_foreing_key);
        }
    }

    public static function row_to_entity(&$entity, $row, $alias_prefix = '') {
        $table = $entity->get_table_name();
        $primary_key = $entity->get_primary_key_column_name();
        $alias = $alias_prefix . $table . "_";
        $columns = $entity->get_property_column_names();
        array_unshift($columns, $primary_key);
        $data = [];
        foreach ($columns as $column) {
            $data[$column] = $row[$alias.$column];
        }

        foreach ($entity->get_relations_many_to_one() as $relation) {
            $related_entity = new $relation['entity_class_name'];
            $related_property = $relation['property_name'];
            self::row_to_entity($related_entity, $row, $alias);
            $data[$related_property] = $related_entity;
        }
        $entity->from_row($data);
    }
}