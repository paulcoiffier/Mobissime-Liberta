<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 31/01/2015
 * Time: 01:42
 */

namespace App\Lib\Module;


class I18NFactory
{

    public function createI18nFile($module_name, $language)
    {
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        $indexFile = fopen($serverRoot . "/src/MyCrm/Modules/" . $module_name . "/i18n/" . $language . ".ini", "w") or die("Unable to create i18n file for module " . $module_name);
        fwrite($indexFile, "[module] \n");
        fwrite($indexFile, "module_name = " . $module_name . " \n");
        fwrite($indexFile, "module_menu_title = " . $module_name . " \n");

        fclose($indexFile);
    }

    public function addI18NEntry($name, $value, $module_name, $language)
    {
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        $toAdd = $name . '=' . $value . ';';
        file_put_contents($serverRoot . "/src/MyCrm/Modules/" . $module_name . "/i18n/" . $language . ".ini", PHP_EOL . $toAdd, FILE_APPEND | LOCK_EX);

    }

}