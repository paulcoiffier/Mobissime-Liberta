<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 03/02/2015
 * Time: 14:33
 */

namespace App\Lib\Entities;


class EntityFactory
{

    private $field_name;
    private $field_type;
    private $field_size;
    private $field_is_mandatory;
    private $entity_name;
    private $tableName;

    public function writeEntity()
    {
        $tpl_content = file_get_contents('../src/App/Lib/Templates/Code/Classes/Entity.php.txt');


        $namespace = "\App\Entities";
        $tpl_content = str_replace("[[NAMESPACE]]", $namespace, $tpl_content);
        $tpl_content = str_replace("[[TABLE_NAME]]", $this->tableName, $tpl_content);
        $tpl_content = str_replace("[[ENTITY_NAME]]", $this->entity_name, $tpl_content);

        /** Write fields loop */
        $fields = "";


        $tpl_content = str_replace("[[FIELDS]]", $moduleName, $tpl_content);
        $tpl_content = str_replace("[[GETTERS_SETTERS]]", $moduleName, $tpl_content);

        $fp = fopen('../src/MyCrm/Modules/' . $this->module . '/Views/Index.html', 'w');
        fwrite($fp, $tpl_content);

    }

    /**
     * @return mixed
     */
    public function getFieldName()
    {
        return $this->field_name;
    }

    /**
     * @param mixed $field_name
     */
    public function setFieldName($field_name)
    {
        $this->field_name = $field_name;
    }

    /**
     * @return mixed
     */
    public function getFieldType()
    {
        return $this->field_type;
    }

    /**
     * @param mixed $field_type
     */
    public function setFieldType($field_type)
    {
        $this->field_type = $field_type;
    }

    /**
     * @return mixed
     */
    public function getFieldSize()
    {
        return $this->field_size;
    }

    /**
     * @param mixed $field_size
     */
    public function setFieldSize($field_size)
    {
        $this->field_size = $field_size;
    }

    /**
     * @return mixed
     */
    public function getFieldIsMandatory()
    {
        return $this->field_is_mandatory;
    }

    /**
     * @param mixed $field_is_mandatory
     */
    public function setFieldIsMandatory($field_is_mandatory)
    {
        $this->field_is_mandatory = $field_is_mandatory;
    }

    /**
     * @return mixed
     */
    public function getEntityName()
    {
        return $this->entity_name;
    }

    /**
     * @param mixed $entity_name
     */
    public function setEntityName($entity_name)
    {
        $this->entity_name = $entity_name;
    }

    /**
     * @return mixed
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param mixed $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

}