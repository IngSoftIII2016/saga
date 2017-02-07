<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class ComisionDAO extends BaseDAO{

    public function __construct() {
        parent::__construct('Comision');
    }

    /**
     * @param $entity
     * @return array|bool
     */

    protected function is_invalid($entity)
    {
        $colisiones = $this->comision_valida($entity);
        if (count($colisiones) > 0) {
            return format_error('Comision Duplicada','Ya existe una Comision en ese Periodo para la Asignatura con ese Nombre',$colisiones);
        }else
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


    function comision_valida($comision)
    {


        $filtros = [
            'asignatura.id' => $comision->asignatura->id,
            'periodo.id' => $comision->periodo->id
        ];
        if($comision->nombre != '') {
            $filtros = ['nombre' => $comision->nombre];
        }

        if(isset($comision->id))
            $filtros['id !='] = $comision->id;

        return $this->query(
            $filtros,
            [],
            ['']
        );
    }


}