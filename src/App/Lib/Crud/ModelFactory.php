<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 31/01/2015
 * Time: 00:55
 */

namespace App\Lib\Crud;


class ModelFactory
{

    public function createModel($namespace, $entityName, $moduleName)
    {
        $tpl_content = file_get_contents('../src/App/Lib/Templates/Code/Models/Model.php.txt');

        $tpl_content = str_replace("[[NAMESPACE]]", $namespace."\\".$moduleName."\\Model", $tpl_content);
        $tpl_content = str_replace("[[ENTITY_NAME]]", $entityName, $tpl_content);

        $fp = fopen('../src/MyCrm/Modules/' . $moduleName . '/Model/' . $entityName . 'Model.php', 'w');
        fwrite($fp, $tpl_content);

        return $entityName . 'Model';
    }
}