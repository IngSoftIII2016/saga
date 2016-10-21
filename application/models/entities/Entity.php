<?php


interface Entity
{

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $array
     * @return mixed
     */
    public function from_array($array);

    /**
     * @return mixed
     */
    public function to_array();

    /**
     * @param $row
     * @return mixed
     */
    public function from_row($row);

    /**
     * @return mixed
     */
    public function to_row();
}