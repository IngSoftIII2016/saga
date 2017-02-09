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
    	if($entity->capacidad < 1){
    		return format_error('Campo Faltante', 'el campo capacidad debe ser mayor que cero');
    	}
    	if( $entity->ubicacion < 1){
    		return format_error('Campo Faltante', 'el campo ubicacion debe ser mayor que cero');
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