<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 29/01/2015
 * Time: 01:45
 */

namespace App\Engine;

use Symfony\Component\Yaml\Yaml;

/**
 * YAML parser
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class YamlParser
{

    /**
     * Parse YAML application configuration file
     *
     * @param array $appConfig Global app configuration
     */
    public function parseAppConfig(&$appConfig)
    {
        $appConfig = Yaml::parse(file_get_contents("../src/App/Conf/config.yml"));
    }

    /**
     * Parse YAML application routes
     *
     * @param array $route_array Array to store routes
     */
    public function parseAppRoutes(&$route_array)
    {
        if (is_file("../src/App/Conf/routes.yml")) {
            $route_array = Yaml::parse(file_get_contents("../src/App/Conf/routes.yml"));
        }
    }

    /**
     * Parse YAML modules routes
     *
     * @param string $module_name Module name for file parsing
     * @param array $route_array Array to store routes
     */
    public function parseModuleRoutes($module_name, &$route_array)
    {
        if (is_file("../src/MyCrm/Modules/$module_name/Conf/routes.yml")) {
            $route_array = Yaml::parse(file_get_contents("../src/MyCrm/Modules/$module_name/Conf/routes.yml"));
        }
    }

    /**
     * Parse YAML entity
     *
     * @param $entity
     * @param $entity_array
     */
    public function parseEntity($entity, &$entity_array)
    {
        if (is_file("../src/App/Yaml/" . $entity . ".yml")) {
            $entity_array = Yaml::parse(file_get_contents("../src/App/Yaml/" . $entity . ".yml"));
        }
    }

}