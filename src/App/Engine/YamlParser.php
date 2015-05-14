<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 29/01/2015
 * Time: 01:45
 */

namespace App\Engine;

use Symfony\Component\Yaml\Yaml;

class YamlParser
{

    public function parseAppConfig(&$appConfig)
    {
        $appConfig = Yaml::parse(file_get_contents("../src/App/Conf/config.yml"));
    }

    public function parseAppRoutes(&$route_array)
    {
        if (is_file("../src/App/Conf/routes.yml")) {
            $route_array = Yaml::parse(file_get_contents("../src/App/Conf/routes.yml"));
        }
    }

    public function parseModuleRoutes($module_name, &$route_array)
    {
        if (is_file("../src/MyCrm/Modules/$module_name/Conf/routes.yml")) {
            $route_array = Yaml::parse(file_get_contents("../src/MyCrm/Modules/$module_name/Conf/routes.yml"));
        }
    }

    public function parseEntity($entity, &$entity_array)
    {
        if (is_file("../src/App/Yaml/" . $entity . ".yml")) {
            $entity_array = Yaml::parse(file_get_contents("../src/App/Yaml/" . $entity . ".yml"));
        }
    }

}