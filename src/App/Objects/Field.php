<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 13/02/2015
 * Time: 22:46
 */

namespace App\Objects;


class Field
{

    public $field_name;
    public $field_type;
    public $field_size;
    public $field_is_nullable;

    /**
     * Construct new XmlEncoder and allow to change the root node element name.
     *
     * @param string $rootNodeName
     */
    public function __construct($rootNodeName = 'Field')
    {
        //$this->rootNodeName = $rootNodeName;
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
    public function getFieldIsNullable()
    {
        return $this->field_is_nullable;
    }

    /**
     * @param mixed $field_is_nullable
     */
    public function setFieldIsNullable($field_is_nullable)
    {
        $this->field_is_nullable = $field_is_nullable;
    }

}