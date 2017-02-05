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
            'asignatura' => $comision->asignatura->id,
            'perdiodo' => $comision->periodo->id,
            'nombre' => $comision->nombre
        ];

        return $this->query(
            $filtros,
            [],
            ['']
        );
    }

    protected function is_invalid($entity)
    {
        $colisiones = $this->comision_valida($entity);
        if (count($colisiones) > 0) {
            return format_error('Comision Duplicada','Ya existe una comision en este para esa Asignatura con ese Docente y Nombre',$colisiones);
        }else
            return FALSE;
    }

}