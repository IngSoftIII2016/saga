<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class UsuarioDAO extends RelationDAO {


    public function __construct() {
        parent::__construct('Usuario');
    }

    /**
     * @param $entity
     * @return array|bool
     */
  
   	protected function is_invalid_insert($entity){
            return FALSE;
    }
    protected function is_invalid_update($entity){
		//No puedo desactivarme a mi mismo, ni cambiarme del grupo administrador-(ver libreria de autentificacion)
    	return FALSE;
    }
    protected function is_invalid_delete($entity){
		//No puedo eliminarme a mi mismo-(ver libreria de autentificacion)
	
    	return FALSE;
    }


}