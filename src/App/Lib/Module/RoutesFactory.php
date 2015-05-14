<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 31/01/2015
 * Time: 15:17
 */

namespace App\Lib\Module;


class RoutesFactory
{

    private $routes;
    private $module;

    function __construct()
    {
        $routes = array();
    }

    public function addRoute($routeName, $route_path, $route_controller)
    {
        $newRoute = $routeName . ":\n";
        $newRoute .= "    name: " . $routeName . "\n";
        $newRoute .= "    path: " . $route_path . "\n";
        $newRoute .= "    controller: " . $route_controller . "\n";
        $this->routes[] = $newRoute;
    }

    public function writeRoutesYamlFile()
    {
        $fp = fopen('../src/MyCrm/Modules/' . $this->module . '/Conf/routes.yml', 'w');
        $yamlContent = "";

        foreach ($this->routes as $route) {
            $yamlContent .= $route;
        }

        fwrite($fp, $yamlContent);
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }


}