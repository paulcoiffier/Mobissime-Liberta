<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 01/02/2015
 * Time: 01:04
 */

namespace App\Lib\Crud;


class HeaderFactory
{

    public function createHeader($module_name)
    {
        $tpl_content = file_get_contents('../src/App/Lib/Templates/Code/Views/Header.html.txt');

        $tpl_content = str_replace("[[MODULE_NAME]]", $module_name, $tpl_content);

        $fp = fopen('../src/MyCrm/Modules/' . $module_name . '/Views/Header.html', 'w');
        fwrite($fp, $tpl_content);
    }

}