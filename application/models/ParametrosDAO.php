<?php

require_once APPPATH . '/models/orm/BaseDAO.php';

class ParametrosDAO extends BaseDAO
{
    public function __construct() {
        parent::__construct ( 'Parametro' );
    }

    protected function is_invalid($entity)
    {
    	$entity->clave = validate_not_empty($entity->clave);
    	if ($entity->clave == NULL) {
    		return format_error('Campo Faltante', 'el campo clave es obligatorio');
    	}
    	$entity->valor = validate_not_empty($entity->valor);
    	if ($entity->valor == NULL) {
    		return format_error('Campo Faltante', 'el campo valor es obligatorio');
    	}
    	$entity->descripcion = validate_not_empty($entity->descripcion);
    	if ($entity->descripcion == NULL) {
    		return format_error('Campo Faltante', 'el campo descripción es obligatorio');
    	}   
		return FALSE;
    }

    /**
     *
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