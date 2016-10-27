<?php
require_once APPPATH . '/models/orm/Entity.php';

class Clase extends Entity
{
	public $id;
	public $fecha;
	public $hora_inicio;
	public $hora_fin;
	public $comentario;
	public $aula;
	public $horario;

	/**
	 * Retorna el nombre de la tabla correspondiente a ésta Entity
	 * @return string Nombre de la tabla
	 */
	public function get_table_name()
	{
		return 'clase';
	}

	/**
	 * Retorna un arreglo de string con los nombres de las columnas que no son claves primarias ni foráneas.
	 * @return array columnas
	 */
	public function get_property_column_names()
	{
		return ['fecha', 'hora_inicio', 'hora_fin', 'comentario'];
	}

	/**
	 * @return mixed
	 */
	public function get_relations_one_to_one()
	{
		return [];
	}


	/**
	 * Retorna un arreglo de las relaciones uno-a-uno o uno-a-muchos que posee ésta Entity.
	 * Cada relación se representa con un arreglo asociativo que contiene las siguientes claves:
	 *  - entity_class_name : string Fully qualifiqued Name de la clase entity correspondiente a la entidad destino
	 *  - foreign_key_column_name : string El nombre de la columna correspondiente a la clave foránea de esta relación
	 *  - property_name : string Nombre de la propiedad en donde colocar el objeto Entity
	 * @return array Relaciones a uno-a-uno o muchos-a-uno
	 */
	public function get_relations_many_to_one()
	{
		return [
				[
				'entity_class_name' => 'Aula',
				'foreign_key_column_name' => 'Aula_id',
				'property_name' => 'aula'
				],
				[
				'entity_class_name' => 'Horario',
				'foreign_key_column_name' => 'Horario_id',
				'property_name' => 'horario'
				]
		];
	}

	/**
	 * @return mixed
	 */
	public function get_relations_one_to_many()
	{
		return [];
	}


	/**
	 * @return mixed
	 */
	public function get_relations_many_to_many()
	{
		return [];
	}

	/**
	 * @return mixed
	 */
	public function get_id()
	{
		$this->id;
	}

	/**
	 * Establece las propiedades de la Entity en base al arreglo asociativo recibido.
	 * @param array $data
	 * @return none
	 */
	public function from_row($data)
	{
		if(isset($data['id'])) $this->id = $data['id'];
		if(isset($data['fecha'])) $this->fecha = $data['fecha'];
		if(isset($data['hora_inicio'])) $this->hora_inicio = $data['hora_inicio'];
		if(isset($data['hora_fin'])) $this->hora_fin = $data['hora_fin'];
		if(isset($data['comentario'])) $this->comentario = $data['comentario'];
		if(isset($data['aula'])) $this->aula = $data['aula'];
		if(isset($data['horario'])) $this->horario = $data['horario'];
	}

	/**
	 * Devuelve un arreglo asociativo con una representación de ésta instancia de la Entity, cuyas claves coinciden
	 * con los nombres de las columnas de la tabla a la que corresponde
	 * @return array
	 */
	public function to_row()
	{
		$data['id'] = $this->id;
		$data['fecha'] = $this->fecha;
		$data['hora_inicio'] = $this->hora_inicio;
		$data['hora_fin'] = $this->hora_fin;
		$data['comentario'] = $this->comentario;
		$data['Aula_id'] = $this->aula->get_id();
		$data['Horario_id'] = $this->horario->get_id();
		return $data;
	}


}