<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 24/11/16
 * Time: 17:17
 */

require_once APPPATH . 'controllers/api/BaseEndpoint.php';

abstract class RelationEndpoint extends BaseEndpoint
{

    public function __construct($entity_class)
    {
        parent::__construct($entity_class);
    }
    protected function json_to_entity($json) {
        $entity = new $this->entity_class;

        $columns = $entity->get_property_column_names();
        //array_unshift($columns, $entity->get_primary_key_column_name());
        $data = [];
        foreach ($columns as $column) {
            $data[$column] = $json[$column];
        }
        foreach ($entity->get_relations_many_to_one() as $relation) {
            $related_entity = new $relation['entity_class_name'];
            $related_entity->from_row($json[$relation['property_name']]);
            $data[$relation['property_name']] = $related_entity;
        }
        $entity->from_row($data);
        return $entity;
    }


    protected function base_delete($id) {
        $json = $this->delete('data');
        $entity = $this->json_to_entity($json);
        if($entity == null)
            $this->response(['error' => "$entity->get_table_name() inexistente"], 404);
        $result = $this->getDAO()->delete($entity);
        if (is_array($result)) {
            $this->response($result, 500);
        }else {
            $this->response(['data' => $result]);
        }
    }
}