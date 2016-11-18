<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class ClaseDAO extends BaseDAO
{

    /**
     * Realiza una validación contra la base de datos previa a la inserción o modificación.
     * Si el resultado de la validación es correcto devuelve FALSE. En caso contrario
     * devuelve un arreglo asociativo con un mensaje de error en la clave 'error' y
     * opcionalmente un conjunto de datos asociados al error en la clave 'data'.
     * @param $entity entidad a validar
     * @return mixed FALSE o array asociativo con información del error
     */

    public function __construct() {
        parent::__construct('Clase');
    }

    protected function is_invalid_insert($entity)
    {
        // TODO: Implement is_invalid() method.
        $col_clases = $this->clase_disponible($entity);
        $this->load->model('EventoDAO');
        $col_eventos = $this->EventoDAO->evento_disponible($entity);
        $colisiones = array_merge($col_clases,$col_eventos);



        if (count($colisiones) > 0) {
            return [
                'error' => 'Aula ocupada.',
                'data' => $colisiones
            ];
        }else
            return FALSE;
    }

    protected function is_invalid_update($entity)
    {
        // TODO: Implement is_invalid() method.
        $col_clases = $this->clase_disponible($entity);
        $this->load->model('EventoDAO');
        $col_eventos = $this->EventoDAO->evento_disponible($entity);
        $colisiones = array_merge($col_clases,$col_eventos);



        if (count($colisiones) > 0) {
            return [
                'error' => 'Aula ocupada.',
                'data' => $colisiones
            ];
        }else
            return FALSE;
    }

    protected function is_invalid_delete($entity) {
        return true;
    }

    function clase_disponible($clase)
    {
       return $this->query(
            [
                'id !=' => $clase->id,
                'fecha' => $clase->fecha,
                'aula.id' => $clase->aula->id,
                'hora_inicio <' => $clase->hora_fin,
                'hora_fin >' => $clase->hora_inicio
            ],
            [],
            ['comision.asignatura']
        );
    }




}