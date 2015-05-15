<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\LibertaModules\Controllers;


use App\Services\CrudGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;

use App\Lib\Crud\HeaderFactory;
use App\Lib\Crud\ControllerFactory;
use App\Lib\Module\DirectoriesFactory;
use App\Lib\Module\IniFactory;
use App\Lib\Module\I18NFactory;
use App\Lib\Module\RoutesFactory;
use App\Lib\Crud\IndexFactory;
use MyCrm\Modules\LibertaModules\Lib\ModUtils;
use MyCrm\Modules\LibertaModules\Model\ModulesModel;
use App\Lib\Entities\EntityFactory;

class AjaxController
{

    public function insertAjaxModule($appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $namespace = "MyCrm\\Modules";
            $controller = "MainController";

            /** Test if a module with this name already exist*/

            $errors = array();
            /** Create directories */
            $directories_factory = new DirectoriesFactory();
            $directories_factory->createModuleDirectories($_POST['mod_name'], $errors);

            /** Create INI file */
            $ini_factory = new IniFactory();
            $ini_factory->createIniFileWithParams($_POST['mod_name'], $_POST['mod_author'], $_POST['mod_description'], $_POST['mod_icon'], $_POST['menu_admin_integration'], $_POST['menu_site_integration'], $_POST['module_require_login']);

            /** Create languages files */
            $i18n_factory = new I18NFactory();
            $i18n_factory->createI18nFile($_POST['mod_name'], 'french');
            $i18n_factory->createI18nFile($_POST['mod_name'], 'english');

            /** Create defaut app route */
            $routes_factory = new RoutesFactory();
            $routes_factory->setModule($_POST['mod_name']);
            $routes_factory->addRoute($_POST['mod_route'], '/' . $_POST['mod_route'], $namespace . "\\" . $_POST['mod_name'] . '\\Controllers\\' . $controller . '::indexAction');
            $routes_factory->writeRoutesYamlFile();

            /** Create Controller */
            $factory = new ControllerFactory();
            $factory->setModule($_POST['mod_name']);
            $factory->setController($controller);
            $factory->setNamespace($namespace);
            $factory->createEmptyController();

            /** Create Index View */
            $index_factory = new IndexFactory();
            $index_factory->setModule($_POST['mod_name']);
            $index_factory->createEmptyindex();
            $index_factory->createEmptyXmlIndex();

            /** Create Header file */
            $header_factory = new HeaderFactory();
            $header_factory->createHeader($_POST['mod_name']);

            /** Create module object in database */
            $modUtils = new ModUtils($appParams['entityManager']);

            /** Create module object in database */
            $new_module = new \App\Entities\Module();
            $new_module->setModName($_POST['mod_name']);
            $new_module->setModAuthor($_POST['mod_author']);
            $new_module->setModDescription($_POST['mod_description']);
            $new_module->setModDateInstall(new \DateTime());
            $new_module->setModDirectoryName($_POST['mod_name']);
            $new_module->setModIfConnexionRequire(true);
            $new_module->setModIsInstalled(false);
            $new_module->setModRoute($_POST['mod_route']);
            $appParams['entityManager']->persist($new_module);
            $appParams['entityManager']->flush();

            /** Create empty entities.xml file */

            /** Register / install module */
            $modUtils->createDefaultEntitiesXml($_POST['mod_name']);
            $modUtils->register_module($new_module);

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

    public function testIfModuleExistModule($appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $module_name = $_POST['mod_name'];
            $moduleModel = new ModulesModel($appParams['entityManager']);
            $module = $moduleModel->getModuleByName($module_name);
            if ($module != null) {
                $arr = array(
                    'error' => 'yes'
                );
                return new Response(json_encode($arr));
            } else {
                $arr = array(
                    'error' => 'no'
                );
                return new Response(json_encode($arr));
            }
        }
    }

    public function registerAjaxModule($appParams)
    {

        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $id = $_POST['id'];
            $moduleRepository = $appParams['entityManager']->getRepository('App\Entities\Module');
            $module = $moduleRepository->findOneBy(array('id' => $id));

            /** Register module in database */
            $modUtils = new ModUtils($appParams['entityManager']);
            $modUtils->register_module($module);

            $arr = array(
                "error" => "no"
            );

            return new Response(json_encode($arr, JSON_PRETTY_PRINT));
        }
    }

    public function createCrudModule(Request $request, $appParams)
    {
        $container = $request->get('container');
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $parser = $container->get('annotationsParser');

            /** Class properties parsing */
            $class = new \App\Entities\User;
            $classFields = $parser->getClassPropertiesList($class);

            $crudGenerator = new CrudGenerator();
            $crudGenerator->setEntityFields($classFields);
            $crudGenerator->setEntityManager($appParams['entityManager']);
            $crudGenerator->generateCrud();
            return new Response('');
        }
    }

    public function createEntityAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $entity_name = $_POST['entity_name'];
            $field_name = $_POST['field_name'];
            $field_type = $_POST['field_type'];
            $field_size = $_POST['field_size'];
            $field_is_mandatory = $_POST['field_is_mandatory'];

            /** Write Php Entity */
            $entity_factory = new EntityFactory();
            $entity_factory->setFieldIsMandatory($field_is_mandatory);
            $entity_factory->setFieldName($field_name);
            $entity_factory->setFieldSize($field_size);
            $entity_factory->setFieldType($field_type);
            $entity_factory->setEntityName($entity_name);
            $entity_factory->writeEntity();

            return new Response('');
        }
    }

    public function getFilesForDirAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $dir = $_POST['dir'];
            $module_name = $_POST['module_name'];

            $root = $_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . "/" . $dir;

            $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root),
                \RecursiveIteratorIterator::SELF_FIRST | \FilesystemIterator::SKIP_DOTS);

            $directories = array();
            $i = 0;
            foreach ($objects as $name => $object) {
                $localPath = str_replace($root, '', $name);

                if (!$object->isDir()) {
                    $fileName = str_replace($root, '', $name);
                    $directories[$i] = stripslashes($fileName);
                }

                $i++;
            }

            return new Response(json_encode($directories));
        }
    }

    public function getFileContentAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $fileName = $_POST['fileName'];
            $module_name = $_POST['module_name'];

            //$file = file_get_contents($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/' . $fileName, true);

            $line = "";
            $file = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/' . $fileName, "r");
            while(!feof($file)){
                $line .= fgets($file);
                # do same stuff with the $line
            }
            fclose($file);

            $arr = array(
                'error' => 'no',
                'fileContent' => $line
            );

            return new Response(json_encode($arr));
        }
    }

    public function saveFileAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $fileName = $_POST['fileName'];
            $new_content = $_POST['new_content'];
            $module_name = $_POST['module_name'];

            $file = $_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/' . $fileName;
            file_put_contents($file, $new_content);

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

    public function createFileAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $file_name = $_POST['file_name'];
            $module_name = $_POST['module_name'];

            $file = $_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/' . $file_name;

            $error = "no";

            if (file_exists($file)) {
                $error = "exist";
            } else {
                touch($file);
            }

            $arr = array(
                'error' => $error
            );

            return new Response(json_encode($arr));
        }
    }

    public function createDirectoryAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $dir_name = $_POST['dir_name'];
            $install_path = $_POST['install_path'];
            $module_name = $_POST['module_name'];

            $dir = $_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/' . $dir_name;

            $error = "no";

            if (file_exists($dir)) {
                $error = "exist";
            } else {
                mkdir($dir);
            }

            $arr = array(
                'error' => $error
            );

            return new Response(json_encode($arr));
        }
    }

    public function updateModuleAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            /** Create module object in database */
            $modUtils = new ModUtils($appParams['entityManager']);

            /** Create module object in database */
            $moduleModel = new ModulesModel($appParams['entityManager']);
            $new_module = $moduleModel->getModuleByName($_POST['mod_name']);
            $new_module->setModAuthor($_POST['mod_author']);
            $new_module->setModDescription($_POST['mod_description']);
            $new_module->setModDateInstall(new \DateTime());
            $new_module->setModDirectoryName($_POST['mod_name']);
            $new_module->setModIfConnexionRequire($_POST['module_require_login']);
            $new_module->setModRoute($_POST['mod_route']);
            $mod_icon = str_replace("fa-","",$_POST['mod_icon']);
            $new_module->setModIcon($mod_icon);
            $appParams['entityManager']->merge($new_module);
            $appParams['entityManager']->flush();

            /** Update ini module file */
            $ini_factory = new IniFactory();
            if ($_POST['menu_admin_integration'] == "true") {
                $menu_admin_integration = "yes";
            } else {
                $menu_admin_integration = "no";
            }

            if ($_POST['menu_site_integration'] == "true") {
                $menu_site_integration = "yes";
            } else {
                $menu_site_integration = "no";
            }
            echo $_POST['module_require_login'];
            if ($_POST['module_require_login'] == "true") {
                $module_require_login = "yes";
            } else {
                $module_require_login = "no";
            }

            $ini_factory->createIniFileWithParams($_POST['mod_name'], $_POST['mod_author'], $_POST['mod_description'], $_POST['mod_icon'], $menu_admin_integration, $menu_site_integration, $module_require_login);

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }


}