<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class UsuarioDAO extends BaseDAO {


    public function __construct() {
        parent::__construct('Usuario');
    }

    /**
     * @param $entity
     * @return array|bool
     */
    protected function is_invalid($entity)
    {
    	$entity->nombre = validate_not_empty($entity->nombre);
    	$entity->apellido = validate_not_empty($entity->apellido);
    	$entity->email = validate_not_empty($entity->email);
    	if ($entity->nombre == NULL) {
    		return format_error('Campo Faltante', 'el campo nombre es obligatorio');
    	}
    	if ($entity->apellido == NULL) {
    		return format_error('Campo Faltante', 'el campo apellido es obligatorio');
    	}
    	if ($entity->email == NULL) {
    		return format_error('Campo Faltante', 'el campo email es obligatorio');
    	}
    	return FALSE;
    }
    
   	protected function is_invalid_insert($entity){
            return $this->is_invalid($entity);
    }
    protected function is_invalid_update($entity){
		//No puedo desactivarme a mi mismo, ni cambiarme del grupo administrador-(ver libreria de autentificacion)
    	return $this->is_invalid($entity);
    }
    protected function is_invalid_delete($entity){
		//No puedo eliminarme a mi mismo-(ver libreria de autentificacion)
	
    	return FALSE;
    }
}