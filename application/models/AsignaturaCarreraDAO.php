<?php
require_once APPPATH . '/models/orm/RelationDAO.php';

class AsignaturaCarreraDAO extends RelationDAO {

    public function __construct() {
        parent::__construct('AsignaturaCarrera');
    }

    /**
     * @param $entity
     * @return array|bool
     */
 protected function is_invalid($entity)
    {
    	if ($entity->anio == NULL) {
    		return format_error('Año Faltante', 'el campo año es obligatorio');
    	}else if($entity->anio < 1 || $entity->anio > 6)
            return format_error('Año Invalido', 'el campo año debe estar entre 1 y 6');
		return FALSE;
    }
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