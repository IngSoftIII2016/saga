<?php
require_once APPPATH . '/models/orm/BaseDAO.php';
class PeriodoDAO extends BaseDAO {
	
	public function __construct() {
		parent::__construct ( 'Periodo' );
	}
	
	/**
	 *
	 * @param $entity
	 * @return array|bool
	 */
	protected function is_invalid($entity)
	{
		$entity->descripcion = validate_not_empty($entity->descripcion);
		if ($entity->descripcion  == NULL) {
			return format_error('Campo Faltante', 'el campo descripcion es obligatorio');
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