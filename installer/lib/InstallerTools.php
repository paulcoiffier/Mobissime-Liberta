<?php

/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 25/02/2015
 * Time: 12:58
 */

use MyCrm\Modules\LibertaModules\Lib\ModUtils;


require '../../src/App/Lib/globalUtils.php';

class InstallerTools
{

    public function createAndRegisterModules($entityManager)
    {

        $mod_utils = new ModUtils($entityManager);

        /** Modules installation */
        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("Liberta modules managment");
        $module->setModDirectoryName("LibertaModules");
        $module->setModIcon("cube");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("LibertaModules");
        $module->setModRoute("modules");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("Liberta user profile managment");
        $module->setModDirectoryName("LibertaUserProfile");
        $module->setModIcon("user");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("LibertaUserProfile");
        $module->setModRoute("profile");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("Liberta menus managment");
        $module->setModDirectoryName("LibertaMenus");
        $module->setModIcon("sitemap");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("LibertaMenus");
        $module->setModRoute("menus");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("Liberta visual builder wysiwyg editor");
        $module->setModDirectoryName("LibertaVisualBuilder");
        $module->setModIcon("desktop");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("LibertaVisualBuilder");
        $module->setModRoute("visualbuilder");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("Liberta Users and groups managment");
        $module->setModDirectoryName("LibertaUsers");
        $module->setModIcon("users");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("LibertaUsers");
        $module->setModRoute("users");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("Liberta Datastore managment");
        $module->setModDirectoryName("LibertaDataStore");
        $module->setModIcon("database");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("LibertaDataStore");
        $module->setModRoute("datastore");
        $module->setModDateInstall(new \DateTime);
        $entityManager->persist($module);
        $entityManager->flush();
        $mod_utils->register_module($module);

        $module = new App\Entities\Module;
        $module->setModAuthor("Paul Coiffier");
        $module->setModDescription("Liberta Query Builder");
        $module->setModDirectoryName("LibertaQueryBuilder");
        $module->setModIcon("binoculars");
        $module->setModIfConnexionRequire(true);
        $module->setModIsInstalled(false);
        $module->setModName("LibertaQueryBuilder");
        $module->setModRoute("querybuilder");
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
        $tpl_content = str_replace("var_install_path", "/Mobissime-Liberta/", $tpl_content);
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
    
    public function createDirectories($parameters)
    {

        $path = $parameters['var_install_sys_dir'];

        if (!file_exists($path . '/data')) {
            mkdir($path . '/data', 0777, true);
        }

        if (!file_exists($path . '/data/users_profiles')) {
            mkdir($path . '/data/users_profiles', 0777, true);
        }

    }

    public function copyDefaultAvatar($parameters)
    {
        $path = $parameters['var_install_sys_dir'];
        copy($path . '/img/1.png', '/data/users_profiles/1.png');
        copy($path . '/img/1_small.png', '/data/users_profiles/1_small.png');
    }

}