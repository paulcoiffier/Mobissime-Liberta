<?php

namespace MyCrm\Modules\LibertaModules\Lib;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Engine\AppInstance;
use App\Lib\Crud\HeaderFactory;
use App\Lib\Crud\ControllerFactory;
use App\Lib\Module\DirectoriesFactory;
use App\Lib\Module\IniFactory;
use App\Lib\Module\I18NFactory;
use App\Lib\Module\RoutesFactory;
use App\Lib\Crud\IndexFactory;

Class ModUtils
{
    private $entityManager;
    //private $logger;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        /** Logger init */
        //$this->logger = new \Liberta\MLogger\Logger(log_dir);
        //$this->logger->setLogLevelThreshold(log_threshold);
        //$this->logger->setDateFormat("d/m/Y H:i:s.u");
        //$this->logger->logWithClass(LEVEL_INFO, "Init logger", get_class());

    }

    /**
     * Register / re-install a module
     * USED from console and UI
     * @param $module
     * @param null $serverRoot
     */
    public function register_module($module, $serverRoot = null)
    {

        if ($serverRoot == null) {
            $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        }

        $config = parse_ini_file($serverRoot . 'src/MyCrm/Modules/' . $module->getModName() . '/module.ini');

        $moduleFind = true;

        /** Check if connection is required for module usage */
        if ($config['module_require_login'] == 1) {
            $module->setModIfConnexionRequire(true);
        } else {
            $module->setModIfConnexionRequire(false);
        }

        $module->setModDescription($config['module_description']);

        $module->setModIcon($config['module_icon']);

        /**
         * Register module actions
         */
        /** Clean module actions */
        $modulesActionRepostitory = $this->entityManager->getRepository('App\Entities\ModuleAction');
        $modules_actions = $modulesActionRepostitory->findBy(array('module' => $module->getId()),
            array('moa_action_name' => 'asc'));

        foreach ($modules_actions as $modAction) {
            $this->entityManager->remove($modAction);
        }

        // Insert module actions
        foreach ($config['action'] as $action) {
            $moduleAction = new \App\Entities\ModuleAction();
            $moduleAction->setModule($module);
            $moduleAction->setMoaActionName($action);

            /** Group required for this action */
            $groupsRepository = $this->entityManager->getRepository('App\Entities\Groups');
            $groupe = $groupsRepository->findOneBy(array('grp_name' => $config['group.' . $action]));

            $moduleAction->setGroupe($groupe);

            $this->entityManager->persist($moduleAction);
            $this->entityManager->flush();
        }

        /**
         * Delete SubMenu entries
         */
        $modulesActionRepostitory = $this->entityManager->getRepository('App\Entities\MenuItem');
        $menu_entries = $modulesActionRepostitory->findBy(array('module' => $module->getId()));

        foreach ($menu_entries as $menuEntry) {
            $this->entityManager->remove($menuEntry);
        }


        /**
         * Delete Menu entries
         */
        $modulesActionRepostitory = $this->entityManager->getRepository('App\Entities\Menu');
        $menu_entries = $modulesActionRepostitory->findBy(array('module' => $module->getId()));


        foreach ($menu_entries as $menuEntry) {
            $this->entityManager->remove($menuEntry);
        }

        if (isset($_SESSION['mycrmlogin'])) {
            $username = $_SESSION['mycrmlogin'];
        } else {
            $username = "admin";
        }

        $user = $this->entityManager->getRepository('App\Entities\User')->findOneBy(array('usr_email' => $username));
        $app = AppInstance::getInstance($user->getUsrLanguage(), $this->entityManager);

        $moduleRepository = $this->entityManager->getRepository('App\Entities\Module');
        $modules = $moduleRepository->findAll();
        foreach ($modules as $mod) {
            $words[$mod->getModName()] = parse_ini_file($serverRoot . 'src/MyCrm/Modules/' . $mod->getModName() . '/i18n/' . $app->getAppLanguage() . '.ini');
        }

        $arrayWords = $words;
        //$arrayWords = $app->getArrayModulesWords();

        if ($config['menu_admin_integration'] == 1) {
            $admin_page = $config['menu_admin_page'];
            /** Create Admin menu entry */
            $menuItem = new \App\Entities\MenuItem();
            $menuItem->setMenuDescriptiop($module->getModDescription());
            $menuItem->setMenuFontAwesomeIcon($config['module_icon']);
            $menuItem->setMenuItemName($arrayWords[$module->getModName()]['module_menu_title']);
            $menuItem->setMenuItemPosition(0);
            $menuItem->setMenuStaticLink($config['menu_route']);
            $menuItem->setModule($module);

            $menuRepository = $this->entityManager->getRepository('App\Entities\Menu');
            $menu = $menuRepository->findOneBy(array('menu_name' => 'Administration'));

            $menuItem->setMenu($menu);

            $this->entityManager->persist($menuItem);
            $this->entityManager->flush();
        }

        if ($config['menu_site_integration'] == 1) {
            $site_page = $config['menu_site_page'];

            $menu = new \App\Entities\Menu();
            $menu->setMenuDescription($module->getModDescription());
            $menu->setMenuFontAwesomeIcon($config['module_icon']);
            $menu->setMenuName($arrayWords[$module->getModName()]['module_menu_title']);
            $menu->setMenuOrder(0);
            $menu->setMenuStaticLink(strtolower($module->getModName()));
            // $menu->setMenuStaticLink($config['menu_route']);
            $menu->setModule($module);

            $this->entityManager->persist($menu);
            $this->entityManager->flush();
        }

        /**
         * Module is installed
         */
        $module->setModIsInstalled(true);

        $this->entityManager->merge($module);
        $this->entityManager->flush();
    }

    public function createDefaultEntitiesXml($module_name)
    {
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        $indexFile = fopen($serverRoot . "/src/MyCrm/Modules/" . $module_name . "/Conf/entities.xml", "w") or die("Unable to create entities xml file for module " . $module_name);
        fwrite($indexFile, "<entities> \n");
        fwrite($indexFile, "</entities>\n");
        fclose($indexFile);
    }

    /**
     * Create a new module
     * @param $module_name
     * @param $author_name
     * @param $module_description
     * @param $mod_icon
     * @param $menu_admin_integration
     * @param $menu_site_integration
     * @param $module_require_login
     * @param $mod_route
     */
    public function create_module($appParams, $module_name, $author_name, $module_description, $mod_icon, $menu_admin_integration, $menu_site_integration, $module_require_login, $mod_route)
    {

        $namespace = "MyCrm\\Modules";
        $controller = "MainController";

        /** Test if a module with this name already exist*/

        $errors = array();
        /** Create directories */
        $directories_factory = new DirectoriesFactory();
        $directories_factory->createModuleDirectories($module_name, $errors);

        /** Create INI file */
        $ini_factory = new IniFactory();
        $ini_factory->createIniFileWithParams($module_name, $author_name, $module_description, $mod_icon, $menu_admin_integration, $menu_admin_integration, $module_require_login);

        /** Create languages files */
        $i18n_factory = new I18NFactory();
        $i18n_factory->createI18nFile($module_name, 'french');
        $i18n_factory->createI18nFile($module_name, 'english');

        /** Create defaut app route */
        $routes_factory = new RoutesFactory();
        $routes_factory->setModule($module_name);
        $routes_factory->addRoute($_POST['mod_route'], '/' . $mod_route, $namespace . "\\" . $module_name . '\\Controllers\\' . $controller . '::indexAction');
        $routes_factory->writeRoutesYamlFile();

        /** Create Controller */
        $factory = new ControllerFactory();
        $factory->setModule($module_name);
        $factory->setController($controller);
        $factory->setNamespace($namespace);
        $factory->createEmptyController();

        /** Create Index View */
        $index_factory = new IndexFactory();
        $index_factory->setModule($module_name);
        $index_factory->createEmptyindex();
        $index_factory->createEmptyXmlIndex();

        /** Create Header file */
        $header_factory = new HeaderFactory();
        $header_factory->createHeader($module_name);

        /** Create module object in database */
        $modUtils = new ModUtils($appParams['entityManager']);

        /** Create module object in database */
        $new_module = new \App\Entities\Module();
        $new_module->setModName($module_name);
        $new_module->setModAuthor($author_name);
        $new_module->setModDescription($module_description);
        $new_module->setModDateInstall(new \DateTime());
        $new_module->setModDirectoryName($module_name);
        $new_module->setModIfConnexionRequire(true);
        $new_module->setModIsInstalled(false);
        $new_module->setModRoute($mod_route);
        $appParams['entityManager']->persist($new_module);
        $appParams['entityManager']->flush();

        /** Create empty entities.xml file */

        /** Register / install module */
        $modUtils->createDefaultEntitiesXml($module_name);
        $modUtils->register_module($new_module);
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

    function createModuleDirectories($module_name, $errors)
    {
        /**
         * Directories creation
         */
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        //echo "Creating directory". $serverRoot."/modules/" . $module_name . "' directory...\n";
        $result = $this->makeDir($serverRoot . "/src/MyCrm/Modules/" . $module_name);
        if (intval($result) == 0) {
            //echo "Creating directory 'modules/" . $module_name . "' directory...\n";
        } else {
            //echo "Error : a directory with module name already exist in 'modules/" . $module_name . "' directory\n";
            $errors = true;
        }

        /**
         * Navigation directory
         */
        $result = $this->makeDir($serverRoot . "/src/MyCrm/Modules/" . $module_name . '/Navigation');
        if (intval($result) == 0) {
            //echo "Creating directory 'navigation'...\n";
        } else {
            // echo "Error : creating directory 'navigation'\n";
            $errors = true;
        }

        /**
         * i18n directory
         */
        $result = $this->makeDir($serverRoot . "/src/MyCrm/Modules/" . $module_name . '/I18n');
        if (intval($result) == 0) {
            //echo "Creating directory 'i18n'...\n";
        } else {
            //echo "Error : creating directory 'i18n'\n";
            $errors = true;
        }

        /**
         * Controllers directory
         */
        $result = $this->makeDir($serverRoot . "/src/MyCrm/Modules/" . $module_name . '/Controllers');
        if (intval($result) == 0) {
            //echo "Creating directory 'controllers'...\n";
        } else {
            //echo "Error : creating directory 'controllers'\n";
            $errors = true;
        }

        /**
         * Entities directory
         */
        $result = $this->makeDir($serverRoot . "/src/MyCrm/Modules/" . $module_name . '/Entities');
        if (intval($result) == 0) {
            //echo "Creating directory 'entities'...\n";
        } else {
            // echo "Error : creating directory 'entities'\n";
            $errors = true;
        }

        /**
         * JS directory
         */
        $result = $this->makeDir($serverRoot . "/src/MyCrm/Modules/" . $module_name . '/Js');
        if (intval($result) == 0) {
            // echo "Creating directory 'js'...\n";
        } else {
            //echo "Error : creating directory 'js'\n";
            $errors = true;
        }

        /**
         * CSS directory
         */
        $result = $this->makeDir($serverRoot . "/src/MyCrm/Modules/" . $module_name . '/Css');
        if (intval($result) == 0) {
            // echo "Creating directory 'css'...\n";
        } else {
            // echo "Error : creating directory 'css'\n";
            $errors = true;
        }

        /**
         * Views directory
         */
        $result = $this->makeDir($serverRoot . "/src/MyCrm/Modules/" . $module_name . '/Views');
        if (intval($result) == 0) {
            // echo "Creating directory 'views'...\n";
        } else {
            // echo "Error : creating directory 'views'\n";
            $errors = true;
        }

        return $errors;
    }

    function createIniFile($module_name, $author_name, $module_description, $mod_icon, $menu_admin_integration, $menu_site_integration, $module_require_login)
    {
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        $iniFile = fopen($serverRoot . "/modules/" . $module_name . "/module.ini", "w") or die("Unable to create ini file for module");
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

    function createDefaultModuleHeader($module_name)
    {
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        $headerFile = fopen($serverRoot . "/modules/" . $module_name . "/navigation/header.php", "w") or die("Unable to create ini file for module");

        fwrite($headerFile, "<div class=\"row wrapper border-bottom white-bg page-heading\">\n");
        fwrite($headerFile, "    <div class=\"col-sm-4\">\n");
        fwrite($headerFile, "        <h2>" . $module_name . "</h2>\n");
        fwrite($headerFile, "        <ol class=\"breadcrumb\">\n");
        fwrite($headerFile, "            <li>\n");
        fwrite($headerFile, "                <a href=\"index.php\">Home</a>\n");
        fwrite($headerFile, "            </li>\n");
        fwrite($headerFile, "            <li class=\"active\">\n");
        fwrite($headerFile, "                <strong>" . $module_name . "</strong>\n");
        fwrite($headerFile, "            </li>\n");
        fwrite($headerFile, "        </ol>\n");
        fwrite($headerFile, "    </div>\n");
        fwrite($headerFile, "</div>\n");

        fclose($headerFile);
    }

    function createI18nFile($module_name, $language)
    {
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        $indexFile = fopen($serverRoot . "/modules/" . $module_name . "/i18n/" . $language . ".ini", "w") or die("Unable to create i18n file for module " . $module_name);
        fwrite($indexFile, "[module] \n");
        fwrite($indexFile, "module_name = " . $module_name . " \n");
        fwrite($indexFile, "module_menu_title = " . $module_name . " \n");

        fclose($indexFile);
    }

    function createIndexFile($module_name)
    {
        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        $indexFile = fopen($serverRoot . "/modules/" . $module_name . "/index.php", "w") or die("Unable to create index file for module");
        fwrite($indexFile, "<?php\n");
        fwrite($indexFile, "/**\n");
        fwrite($indexFile, " * Created by MyCRM Console\n");
        $currentDate = date("D M j G:i:s T Y");
        fwrite($indexFile, " * Date: " . $currentDate . "\n");
        fwrite($indexFile, " */\n");

        fwrite($indexFile, "include 'controllers/nav_controller.php';");
        fwrite($indexFile, "?>");

        fclose($indexFile);
    }


}