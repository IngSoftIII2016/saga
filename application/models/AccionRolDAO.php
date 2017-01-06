<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 24/11/16
 * Time: 05:09
 */
require_once APPPATH . '/models/orm/RelationDAO.php';


class AccionRolDAO extends RelationDAO
{

    public function __construct() {
        parent::__construct('AccionRol');
    }

    /**
     * Realiza una validación contra la base de datos previa a la inserción.
     * Si el resultado de la validación es correcto devuelve FALSE. En caso contrario
     * devuelve un arreglo asociativo con un mensaje de error en la clave 'error' y
     * opcionalmente un conjunto de datos asociados al error en la clave 'data'.
     * @param $entity entidad a validar
     * @return mixed FALSE o array asociativo con información del error
     */
    protected function is_invalid_insert($entity)
    {
        return false;
    }

    /**
     * Realiza una validación contra la base de datos previa a la modificación.
     * Si el resultado de la validación es correcto devuelve FALSE. En caso contrario
     * devuelve un arreglo asociativo con un mensaje de error en la clave 'error' y
     * opcionalmente un conjunto de datos asociados al error en la clave 'data'.
     * @param $entity entidad a validar
     * @return mixed FALSE o array asociativo con información del error
     */
    protected function is_invalid_update($entity)
    {
        return false;
    }

    /**
     * Realiza una validación contra la base de datos previa a la eliminición.
     * Si el resultado de la validación es correcto devuelve FALSE. En caso contrario
     * devuelve un arreglo asociativo con un mensaje de error en la clave 'error' y
     * opcionalmente un conjunto de datos asociados al error en la clave 'data'.
     * @param $entity entidad a validar
     * @return mixed FALSE o array asociativo con información del error
     */
    protected function is_invalid_delete($entity)
    {
        return false;
    }
}