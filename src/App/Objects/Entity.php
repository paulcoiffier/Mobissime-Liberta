<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 13/02/2015
 * Time: 22:45
 */

namespace App\Objects;
use \App\Objects\Field;
use Doctrine\Common\Collections\ArrayCollection;

class Entity {

    public $entity_name;
    public $entity_table_name;
    public $entity_fields;

    public function __construct($rootNodeName = 'Entity')
    {
        $this->entity_fields = new ArrayCollection();
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
    public function getEntityTableName()
    {
        return $this->entity_table_name;
    }

    /**
     * @param mixed $entity_table_name
     */
    public function setEntityTableName($entity_table_name)
    {
        $this->entity_table_name = $entity_table_name;
    }

    /**
     * @return mixed
     */
    public function getEntityFields()
    {
        return $this->entity_fields;
    }

    /**
     * @param mixed $entity_fields
     */
    public function setEntityFields($entity_fields)
    {
        $this->entity_fields = $entity_fields;
    }




}