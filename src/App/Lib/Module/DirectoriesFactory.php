<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 31/01/2015
 * Time: 01:04
 */

namespace App\Lib\Module;


class DirectoriesFactory
{

    public function createModuleDirectories($module_name, $errors)
    {
        $directories = array("Conf", "Controllers", "Css", "Entities", "I18n", "Js", "Model", "Navigation", "Views", "Data", "Data/Views");
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;

        $result = $this->makeDir($serverRoot . "/src/MyCrm/Modules/" . $module_name);
        if (intval($result) <> 0) {
            $errors = true;
        }

        foreach ($directories as $directory) {
            $result = $this->makeDir($serverRoot . "/src/MyCrm/Modules/" . $module_name . '/' . $directory);
            if (intval($result) <> 0) {
                $errors = true;
            }
        }
        return $errors;
    }

    function makeDir($path)
    {
        if (!file_exists($path)) {
            $ret = mkdir($path);
            return 0;
        } else {
            return 1;
        }
    }
}