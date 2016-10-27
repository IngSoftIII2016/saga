<?php
require_once APPPATH . '/models/orm/BaseDAO.php';
class CarreraDAO extends BaseDAO {
	
	public function __construct() {
		parent::__construct ( 'Carrera' );
	}	

    /**
     * @param $entity
     * @return array|bool
     */
    protected function is_invalid($entity){
            return FALSE;
    }
    
	
	
}