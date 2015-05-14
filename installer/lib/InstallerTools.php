<?php

/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 25/02/2015
 * Time: 12:58
 */

use MyCrm\Modules\MyCrmModules\Lib\ModUtils;

require_once '../../bootstrap.php';
require '../../include/engine/globalUtils.php';

class InstallerTools
{

    public function createDatabase($parameters, $entityManager)
    {
        $database_server = $parameters['var_database_server'];
        $database_database = $parameters['var_database_schema'];
        $database_user = $parameters['var_database_user'];
        $database_password = $parameters['var_database_password'];

        /** Drop database if exist */
        try {
            $dbh = new PDO('mysql:host=' . $database_server . ';dbname=' . $database_database, $database_user, $database_password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $dbh->prepare("DROP DATABASE mycrm;");
            $stmt->execute();

            $stmt = $dbh->prepare("CREATE DATABASE mycrm;");
            $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        /** Generate entities */
        exec('cd ../.. && vendor\\bin\\doctrine orm:schema-tool:create');

        /** Generate proxies entity classes */
        exec('cd ../.. && vendor\\bin\\doctrine orm:generate-proxies');

        try {
            $stmt = $dbh->prepare("INSERT INTO mycrm.menu(menu_name,menu_description,menu_order,menu_font_awesome_icon) values (:menu_name,:menu_description,:menu_order,:menu_font_awesome_icon)");

            $menu_name = "Administration";
            $menu_description = "MyCRM administration menu";
            $menu_order = 5;
            $menu_font_awesome_icon = "fa-edit";

            $stmt->bindParam(':menu_name', $menu_name);
            $stmt->bindParam(':menu_description', $menu_description);
            $stmt->bindParam(':menu_order', $menu_order);
            $stmt->bindParam(':menu_font_awesome_icon', $menu_font_awesome_icon);

            $stmt->execute();
            $dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createAndRegisterModules($entityManager)
    {

        $mod_utils = new ModUtils($entityManager);

        /** Modules installation */
        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("MyCRM modules managment");
        $module->setModDirectoryName("MyCrmModules");
        $module->setModIcon("cube");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("MyCrmModules");
        $module->setModRoute("modules");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("MyCRM user profile managment");
        $module->setModDirectoryName("MyCrmUserProfile");
        $module->setModIcon("user");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("MyCrmUserProfile");
        $module->setModRoute("profile");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("MyCrm menus managment");
        $module->setModDirectoryName("MyCrmMenus");
        $module->setModIcon("sitemap");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("MyCrmMenus");
        $module->setModRoute("menus");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("MyCRM visual builder wysiwyg editor");
        $module->setModDirectoryName("MyCrmVisualBuilder");
        $module->setModIcon("desktop");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("MyCrmVisualBuilder");
        $module->setModRoute("visualbuilder");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("MyCRM Users and groups managment");
        $module->setModDirectoryName("MyCrmUsers");
        $module->setModIcon("users");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("MyCrmUsers");
        $module->setModRoute("users");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("MyCRM Datastore managment");
        $module->setModDirectoryName("MyCrmDataStore");
        $module->setModIcon("database");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("MyCrmDataStore");
        $module->setModRoute("datastore");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        /** Register modules */
        /*
        $modules = $entityManager->getRepository('App\Entities\Module')->findAll();

        foreach ($modules as $mod) {
            $mod_utils->register_module($mod);
        }*/
    }

    public function createParametersFile($parameters)
    {
        $tpl_content = file_get_contents('../templates/Parameters.inc.php');

        $tpl_content = str_replace("var_install_url", $parameters['var_install_path'], $tpl_content);
        $tpl_content = str_replace("var_install_path", "/MyCRM/", $tpl_content);
        $tpl_content = str_replace("var_install_sys_dir", $parameters['var_install_sys_dir'], $tpl_content);
        $tpl_content = str_replace("var_database_server", $parameters['var_database_server'], $tpl_content);
        $tpl_content = str_replace("var_database_port", $parameters['var_database_port'], $tpl_content);
        $tpl_content = str_replace("var_database_user", $parameters['var_database_user'], $tpl_content);
        $tpl_content = str_replace("var_database_password", $parameters['var_database_password'], $tpl_content);
        $tpl_content = str_replace("var_database_schema", $parameters['var_database_schema'], $tpl_content);

        $fp = fopen('../../src/App/Conf/Parameters.php', 'w');
        fwrite($fp, $tpl_content);

        return '../../src/App/Conf/Parameters.php';

    }

    public function createAdminUser($parameters)
    {
        $database_server = $parameters['var_database_server'];
        $database_database = $parameters['var_database_schema'];
        $database_user = $parameters['var_database_user'];
        $database_password = $parameters['var_database_password'];

        try {
            $dbh = new PDO('mysql:host=' . $database_server . ';dbname=' . $database_database, $database_user, $database_password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $dbh->prepare("INSERT INTO users (usr_first_name, usr_last_name, usr_password, usr_email, usr_language, usr_function) VALUES (:usr_first_name, :usr_last_name, :usr_password, :usr_email, :usr_language, :usr_function)");

            $administrator = "administrator";
            $password = md5($parameters['var_admin_password']);
            $stmt->bindParam(':usr_first_name', $parameters['var_usr_first_name']);
            $stmt->bindParam(':usr_last_name', $parameters['var_usr_last_name']);
            $stmt->bindParam(':usr_password', $password);
            $stmt->bindParam(':usr_email', $parameters['var_usr_email']);
            $stmt->bindParam(':usr_language', $parameters['var_usr_language']);
            $stmt->bindParam(':usr_function', $administrator);

            $stmt->execute();

            $dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function createDirectories()
    {

        if (!file_exists('data')) {
            mkdir('data', 0777, true);
        }

        if (!file_exists('data/users_profiles')) {
            mkdir('data/users_profiles', 0777, true);
        }

    }

}