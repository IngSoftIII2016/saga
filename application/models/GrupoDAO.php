<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class GrupoDAO extends BaseDAO {


    public function __construct() {
        parent::__construct('Grupo');
    }

    /**
     * @param $entity
     * @return array|bool
     */

    protected function is_invalid_insert($entity){
            return FALSE;    
		}
		
    protected function is_invalid_update($grupo){
		//grupo de la bd
		$grupoBd=$this->get_by_id($grupo->get_id());
		if ( $grupoBd[0]->nombre=="administrador" || $grupoBd[0]->nombre=="bedel" ){
			
			if(  $grupoBd[0]->nombre!==$grupo->nombre ){}
            return [
                'message' => 'Esta prohibido modificar el nombre del grupo '.$grupoBd[0]->nombre.'.',
            ];

        }else
            return FALSE;   
		}

    protected function is_invalid_delete($grupo){
        var_dump($grupo->to_row());
        if ( $grupo->nombre=="administrador" || $grupo->nombre=="bedel" ){
            return [
                'message' => 'Esta prohibido eliminar el grupo '.$grupo->nombre.'.',
            ];

        }else
            return FALSE;

    }


}