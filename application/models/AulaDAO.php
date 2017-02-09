<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class AulaDAO extends BaseDAO {

    public function __construct() {
        parent::__construct('Aula');
    }

 protected function is_invalid($entity)
    {
    	$entity->nombre = validate_not_empty($entity->nombre);
    	if ($entity->nombre == NULL) {
    		return format_error('Campo Faltante', 'el campo nombre es obligatorio');
    	}      
    	if ($entity->ubicacion <= 0) {
    		return format_error('Campo Faltante', 'el campo ubicación es obligatorio');
    	}
    	if ($entity->capacidad <= 0) {
    		return format_error('Campo Faltante', 'el campo capacidad es obligatorio');
    	}
		return FALSE;
    }

    /**
     * @param $entity
     * @return array|bool
     */
    protected function is_invalid_insert($entity){
        return $this->is_invalid($entity);
    }
    protected function is_invalid_update($entity){
        return $this->is_invalid($entity);
    }
    protected function is_invalid_delete($entity){
        return FALSE;
    }
}