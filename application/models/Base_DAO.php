<?php

/**
 * Class Base_DAO
 */
abstract class Base_DAO extends CI_Model {


    protected $table_name = null;

    protected $primary_key;

    protected $columns;

    /**
     * Base_DAO constructor.
     * @param $table_name nombre de la tabla
     */
    public function __construct($table_name)
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = $table_name;
        $columns = $this->db->list_fields('table');
    }

    /**
     * @param array $joins
     * @param array $filters
     * @param array $sorts
     * @param int $page
     * @param int $size
     * @return array arreglo de entity
     */
    public function get_list($joins = [], $filters = [], $sorts = [], $page = 1, $size = 20) {

    }

    /**
     * @param $id
     * @return Entity
     */
    public function get_by_id($id) {

    }

    /**
     * @param $entity
     * @return Entity
     */
    public function insert($entity) {

    }

    /**
     * @param $entity
     * @return Entity
     */
    public function update($entity) {

    }

    /**
     * @param $entity
     */
    public function delete($entity) {

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
    protected function before_insert($entity) {}

    /**
     * @param $entity
     * @return Entity
     */
    protected function after_insert($entity) {}

    /**
     * @param $entity
     * @return Entity
     */
    protected function before_update($entity) {}

    /**
     * @param $entity
     * @return Entity
     */
    protected function after_update($entity) {}

    /**
     * @param $entity
     * @return Entity
     */
    protected function before_delete($entity) {}

    /**
     * @param $entity
     * @return Entity
     */
    protected function after_delete($entity) {}

    private function get_primary_key($table_name) {}

}