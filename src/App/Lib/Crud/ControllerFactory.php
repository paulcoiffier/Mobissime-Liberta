<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 31/01/2015
 * Time: 00:34
 */

namespace App\Lib\Crud;


class ControllerFactory
{

    private $namespace;
    private $controller;
    private $module;
    private $model;
    private $entity;

    public function createEmptyController()
    {
        $tpl_content = file_get_contents('../src/App/Lib/Templates/Code/Controllers/BaseControllerEmpty.php.txt');

        $tpl_content = str_replace("[[CONTROLLER_NAME]]", $this->controller, $tpl_content);
        $tpl_content = str_replace("[[NAMESPACE]]", $this->namespace . "\\" . $this->module, $tpl_content);

        $fp = fopen('../src/MyCrm/Modules/' . $this->module . '/Controllers/' . $this->controller . '.php', 'w');
        fwrite($fp, $tpl_content);

        return '../src/MyCrm/Modules/' . $this->module . '/Controllers/' . $this->controller . '.php';
    }

    public function createController()
    {
        $tpl_content = file_get_contents('../src/App/Lib/Templates/Code/Controllers/BaseController.php.txt');

        $tpl_content = str_replace("[[CONTROLLER_NAME]]", $this->controller, $tpl_content);
        $tpl_content = str_replace("[[ENTITY_NAME]]", $this->entity, $tpl_content);
        $tpl_content = str_replace("[[MODEL_NAME]]", $this->model, $tpl_content);
        $tpl_content = str_replace("[[NAMESPACE]]", $this->namespace . "\\" . $this->module, $tpl_content);

        $fp = fopen('../src/MyCrm/Modules/' . $this->module . '/Controllers/' . $this->controller . '.php', 'w');
        fwrite($fp, $tpl_content);

        return '../src/MyCrm/Modules/' . $this->module . '/Controllers/' . $this->controller . '.php';
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }


}