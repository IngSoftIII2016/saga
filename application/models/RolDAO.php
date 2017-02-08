<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class RolDAO extends BaseDAO
{

    public function __construct()
    {
        parent::__construct('Rol');
    }

    /**
     * @param $entity
     * @return array|bool
     */

    private function is_invalid($entity)
    {
        if (validate_not_empty($entity->nombre) == NULL) {
            return format_error('Campo Faltante', 'el campo nombre es obligatorio');
        }
        return FALSE;
    }

    protected function is_invalid_insert($entity)
    {
        return $this->is_invalid($entity);
    }

    protected function is_invalid_update($entity)
    {
        return  $this->is_invalid($entity);
    }

    protected function is_invalid_delete($entity)
    {
        return FALSE;
    }
}