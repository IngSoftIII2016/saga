<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class AulaDAO extends BaseDAO {

    public function __construct() {
        parent::__construct('Aula');
    }

    /**
     * @param $entity
     * @return array|bool
     */
    protected function is_invalid_insert($entity){
        return FALSE;
    }
    protected function is_invalid_update($entity){
        return FALSE;
    }
    protected function is_invalid_delete($entity){
        return FALSE;
    }
}