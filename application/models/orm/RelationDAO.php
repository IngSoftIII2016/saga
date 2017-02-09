<?php
/**
 * Created by PhpStorm.
 * User: Juan Pablo Aveggio
 * Date: 20/10/16
 * Time: 18:33
 */

require_once APPPATH . '/models/orm/BaseDAO.php';
require_once APPPATH . '/models/relations/AccionRol.php';
require_once APPPATH . '/models/relations/AsignaturaCarrera.php';
require_once APPPATH . '/models/relations/UsuarioGrupo.php';


/**
 * Class Base_DAO
 */
abstract class RelationDAO extends BaseDAO
{

    public function __construct($entity_class)
    {
        parent::__construct($entity_class);
    }

    public function get_by_id($ids) {
        return null;
    }

    /**
     * @param $entity
     * @return array
     */
    public function insert($entity)
    {
        $this->db->trans_start();

        $this->before_insert($entity);

        $error = $this->is_invalid_insert($entity);
        if ($error) {
            $this->db->trans_rollback();
            return $error;
        }

        if (!$this->db->insert($entity->get_table_name(), $entity->to_row())) {
            $codigo = $this->db->error()['code'];
            $this->db->trans_rollback();

            //duplicate entry
            if ($codigo == 1062) return format_error('Duplicado', 'el elemento ya existe');
            //foreing key
            if ($codigo == 1451) return format_error('Error al insetar','No se pudo agregar el elemento');
            if ($codigo == 1169) return format_error('Error al insetar','No se pudo agregar el elemento');

            return format_error("Error $codigo al agregar $entity->get_table_name()", 'No se pudo agregar el elemento');
        }

        $this->after_insert($entity);

        $this->db->trans_complete();

        return $entity;
    }

    /**
     * @param $entity
     * @return array|Entity
     */
    public function update($entity)
    {
        $this->db->trans_start();

        $this->before_update($entity);

        $error = $this->is_invalid_update($entity);
        if($error) {
            $this->db->trans_rollback();
            return $error;
        }

        foreach ($entity->get_relations_many_to_one() as $relation) {
            $this->db->where($relation['foreign_key_column_name'], $entity->{$relation['property_name']}->get_id());
        }
        if(!$this->db->update($entity->get_table_name(), $entity->to_row())) {
            $codigo = $this->db->error()['code'];
            $this->db->trans_rollback();

            if ($codigo == 1062) return format_error('Duplicado', 'el elemento ya existe');
            return format_error("Error $codigo al modificar  $entity->get_table_name()", 'No se pudo modificar el elemento' );
        }

        $this->after_update($entity);

        $this->db->trans_complete();

        return $entity;
    }

    /**
     * @param $entity
     * @return array|Entity
     */
    public function delete($entity)
    {
        $this->db->trans_start();

        $this->before_delete($entity);

        $error =  $this->is_invalid_delete($entity);
        if ($error) {
            $this->db->trans_rollback();
            return $error;
        }
        foreach ($entity->get_relations_many_to_one() as $relation) {
            $this->db->where($relation['foreign_key_column_name'], $entity->{$relation['property_name']}->get_id());
        }
        if(!$this->db->delete($entity->get_table_name())) {
            $codigo = $this->db->error()['code'];
            $this->db->trans_rollback();
            if ($codigo == 1451)
                return['error' => self::generar_error('Error al eliminar  '+$entity->get_table_name(),'No se pudo eliminar ya que '+$entity->get_table_name()+' tiene elementos asociados')];
            return ['error' => self::generar_error('Error al eliminar  '+$entity->get_table_name(), 'No se pudo eliminar el elemento' )];
        }

        $this->after_delete($entity);

        $this->db->trans_complete();

        return $entity;
    }

    protected function build_base_query_arrays($entity, &$columns, &$joins, $alias_prefix = '', $foreign_key='') {
        if(!is_array($joins)) $joins = [];
        if(!is_array($columns)) $columns = [];

        $table = $entity->get_table_name();
        $alias = $alias_prefix . $table . "_";

        if(count($joins) == 0)
            $joins["$table AS $alias"] = '';
        else{
            $primary_key = $entity->get_primary_key_column_name();
            $columns[] = "$alias.$primary_key AS $alias$primary_key";
            $joins["$table AS $alias"] = "$alias_prefix.$foreign_key = $alias.$primary_key";
        }

        foreach ($entity->get_property_column_names() as $column)
            $columns[] = "$alias.$column AS $alias$column";

        foreach ($entity->get_relations_many_to_one() as $relation) {
            $related_entity = new $relation['entity_class_name'];
            $related_foreign_key = $relation['foreign_key_column_name'];
            self::build_base_query_arrays($related_entity, $columns, $joins, $alias, $related_foreign_key);
        }
    }

    protected function row_to_entity(&$entity, $row, $includes = [], $alias_prefix = '') {
        $table = $entity->get_table_name();
        $alias = $alias_prefix . $table . "_";
        $columns = $entity->get_property_column_names();
        if($alias_prefix != ''){
            $primary_key = $entity->get_primary_key_column_name();
            array_unshift($columns, $primary_key);
        }
        $data = [];
        foreach ($columns as $column) {
            $data[$column] = $row[$alias.$column];
        }

        $this_includes = [];
        $next_includes = [];
        foreach($includes as $include) {
            $include_path = explode('.', $include);
            $next = array_shift($include_path);
            if(!in_array($next, $this_includes)) $this_includes[] = $next;
            $next_includes[] = implode('.', $include_path);
        }

        foreach ($entity->get_relations_many_to_one() as $relation) {
            $related_entity = new $relation['entity_class_name'];
            $relationship_property = $relation['property_name'];
            if(in_array($relationship_property, $this_includes)) {
                self::row_to_entity($related_entity, $row, $next_includes, $alias);
                $data[$relationship_property] = $related_entity;
            }
        }

        $entity->from_row($data);
    }

}