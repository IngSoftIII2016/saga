<?php
require_once APPPATH . '/models/orm/BaseDAO.php';

class EventoDAO extends BaseDAO
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
        parent::__construct('Evento');
    }

    protected function is_invalid($entity)
    {
        // TODO: Implement is_invalid() method.
        $colisiones = $this->evento_disponible($entity);
        if (count($colisiones) > 0) {
            return [
                'error' => 'Aula ocupada.',
                'data' => $colisiones
            ];
        }else
            return FALSE;
    }

    function evento_disponible($evento)
    {
        $this->query(
            [
                'id !=' => $evento->id,
                'fecha' => $evento->fecha,
                'aula.id' => $evento->aula->id,
                'hora_inicio <' => $evento->hora_fin,
                'hora_fin >' => $evento->hora_inicio
                            ],
            [],
            ['']
        );
    }




}