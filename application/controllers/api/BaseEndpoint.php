<?php


class BaseEndpoint extends REST_Controller
{
    private $entity_class;

    public function __construct($entity_class)
    {
        parent::__construct();
        $this->entity_class = $entity_class;
    }

    protected function json_to_entity($json) {
        $entity = new $this->entity_class;
        $columns = $entity->get_property_column_names();
        array_unshift($columns, $primary_key);
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
}