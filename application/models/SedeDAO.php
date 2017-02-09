<?php
require_once APPPATH . '/models/orm/BaseDAO.php';
class SedeDAO extends BaseDAO {
	
	public function __construct() {
		parent::__construct ( 'Sede' );
	}

    protected function is_invalid($entity)
    {
    	$entity->nombre = validate_not_empty($entity->nombre);
    	if ($entity->nombre == NULL) {
    		return format_error('Campo Faltante', 'el campo nombre es obligatorio');
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