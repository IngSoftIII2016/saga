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
    	$entity->anio = validate_not_empty($entity->anio);
    	if ($entity->anio == NULL) {
    		return format_error('Campo Faltante', 'el campo año es obligatorio');
    	}  
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