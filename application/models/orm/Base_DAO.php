<?php

/**
 * Class Base_DAO
 */
abstract class Base_DAO extends CI_Model
{

    protected $entity;

    public function __construct($entity_class)
    {
        parent::__construct();
        if(empty($entity_class)) throw new Exception("Empty Entity class name!");
        $this->load->database();
        $this->entity = new $entity_class;
    }



    /**
     * @param array $filters
     * @param array $sorts
     * @param int $page
     * @param int $size
     * @return array arreglo de entity
     */
    public function query($filters = [], $sorts = [], $page = 1, $size = 20)
    {
        $this->do_base_query();
        
    }

        /**
         * @param $id
         * @return Entity
         */
    public function get_by_id($id)
    {

    }

    /**
     * @param $entity
     * @return Entity
     */
    public function insert($entity)
    {

    }

    /**
     * @param $entity
     * @return Entity
     */
    public function update($entity)
    {

    }

    /**
     * @param $entity
     */
    public function delete($entity)
    {

    }

    /**
     * @param $entity
     * @return Entity
     */
    protected abstract function validate($entity);

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
            else $this->db->join($join_table, $join_condition);
        }
    }


    public static function build_base_query_arrays($entity, &$columns, &$joins, $alias_prefix = '', $foreing_key='') {
        $table = $entity->get_table_name();
        $primary_key = $entity->get_primary_key_column_name();
        $alias = $alias_prefix . $table . "_";

        if(!is_array($columns)) $columns = [];

        $columns[] = "$alias.$primary_key AS $alias$primary_key";
        foreach ($entity->get_propety_column_names() as $column)
            $columns[] = "$alias.$column AS $alias$column";

        if(!is_array($joins)) $joins = [];
        if(count($joins) == 0)
            $joins[] = ["$table AS $alias" => ''];
        else {
            $joins[] = ["$table AS $alias" => "$alias_prefix.$foreing_key = $alias.$primary_key"];
        }

        foreach ($entity->get_relations_to_one() as $relation) {
            $related_entity = new $relation['entity_class_name'];
            $related_foreing_key = $relation['foreing_key_column_name'];
            self::build_base_query_arrays($related_entity, $columns, $joins, $alias, $related_foreing_key);
        }
    }


}