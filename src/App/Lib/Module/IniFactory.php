<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 31/01/2015
 * Time: 01:35
 */

namespace App\Lib\Module;


class IniFactory
{

    public function createIniFile($module_name, $author_name, $module_description)
    {
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        $iniFile = fopen($serverRoot . "/src/MyCrm/Modules/" . $module_name . "/module.ini", "w");
        fwrite($iniFile, "; Module infos\n");
        fwrite($iniFile, "module_name=" . $module_name . "\n");
        fwrite($iniFile, "module_author=" . $author_name . "\n");
        fwrite($iniFile, "module_description=" . $module_description . "\n");
        fwrite($iniFile, "module_icon = globe\n");


        fwrite($iniFile, "; Menu integration\n");
        fwrite($iniFile, "module_has_menu_entry=yes;\n");
        fwrite($iniFile, "; Admin menu integration\n");
        fwrite($iniFile, "menu_admin_integration = no;\n");
        fwrite($iniFile, "menu_admin_page = null;\n\n");

        fwrite($iniFile, "; Site menu integration\n");
        fwrite($iniFile, "menu_site_integration = yes;\n");
        fwrite($iniFile, "menu_site_page =index.twig.html;\n\n");

        fwrite($iniFile, "; If user must be connected to access to this module \n");
        fwrite($iniFile, "module_require_login=yes; \n");
        fwrite($iniFile, " \n");
        fwrite($iniFile, "; Module actions (for rights and security) \n");
        fwrite($iniFile, "[actions] \n");
        fwrite($iniFile, "action[] = Read; \n");
        fwrite($iniFile, "action[] = Create; \n");
        fwrite($iniFile, "action[] = Update; \n");
        fwrite($iniFile, "action[] = Delete; \n");
        fwrite($iniFile, " \n");
        fwrite($iniFile, "; Groups required for module actions \n");
        fwrite($iniFile, "; Define the groups order by actions (example : group[1] if for action[1]) \n");
        fwrite($iniFile, "[groups] \n");
        fwrite($iniFile, "group.Read = admin; \n");
        fwrite($iniFile, "group.Create = admin; \n");
        fwrite($iniFile, "group.Update = admin; \n");
        fwrite($iniFile, "group.Delete = admin; \n");

        fclose($iniFile);
    }

    function createIniFileWithParams($module_name, $author_name, $module_description, $mod_icon, $menu_admin_integration, $menu_site_integration, $module_require_login)
    {
        $mod_icon = str_replace("fa-", "", $mod_icon);

        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        $iniFile = fopen($serverRoot . "/src/MyCrm/Modules/" . $module_name . "/module.ini", "w");
        fwrite($iniFile, "; Module infos\n");
        fwrite($iniFile, "module_name=" . $module_name . "\n");
        fwrite($iniFile, "module_author=" . $author_name . "\n");
        fwrite($iniFile, "module_description=" . $module_description . "\n");
        fwrite($iniFile, "module_icon = " . $mod_icon . "\n");


        fwrite($iniFile, "; Menu integration\n");
        fwrite($iniFile, "module_has_menu_entry=yes;\n");
        fwrite($iniFile, "; Admin menu integration\n");
        fwrite($iniFile, "menu_admin_integration = " . $menu_admin_integration . ";\n");
        fwrite($iniFile, "menu_admin_page = null;\n\n");

        fwrite($iniFile, "; Site menu integration\n");
        fwrite($iniFile, "menu_site_integration = " . $menu_site_integration . ";\n");
        fwrite($iniFile, "menu_site_page =index.twig.html;\n\n");

        fwrite($iniFile, "; If user must be connected to access to this module \n");
        fwrite($iniFile, "module_require_login=" . $module_require_login . "; \n");
        fwrite($iniFile, " \n");
        fwrite($iniFile, "; Module actions (for rights and security) \n");
        fwrite($iniFile, "[actions] \n");
        fwrite($iniFile, "action[] = Read; \n");
        fwrite($iniFile, "action[] = Create; \n");
        fwrite($iniFile, "action[] = Update; \n");
        fwrite($iniFile, "action[] = Delete; \n");
        fwrite($iniFile, " \n");
        fwrite($iniFile, "; Groups required for module actions \n");
        fwrite($iniFile, "; Define the groups order by actions (example : group[1] if for action[1]) \n");
        fwrite($iniFile, "[groups] \n");
        fwrite($iniFile, "group.Read = admin; \n");
        fwrite($iniFile, "group.Create = admin; \n");
        fwrite($iniFile, "group.Update = admin; \n");
        fwrite($iniFile, "group.Delete = admin; \n");

        fclose($iniFile);
    }

}