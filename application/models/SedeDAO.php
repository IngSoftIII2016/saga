<?php
require_once APPPATH . '/models/orm/BaseDAO.php';
class SedeDAO extends BaseDAO {
	
	public function __construct() {
		parent::__construct ( 'Sede' );
	}

    protected function is_invalid($entity)
    {

        if ((strlen($entity->nombre)) <= 0) {
            return format_error('Faltan Campos Requeridos','faltan campos requeridos', 500);
        }else
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