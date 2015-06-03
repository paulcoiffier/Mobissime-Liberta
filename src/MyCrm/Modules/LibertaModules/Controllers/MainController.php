<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\LibertaModules\Controllers;


use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use App\Lib\TwigController;
use MyCrm\Modules\LibertaModules\Model\ModulesModel;
use Symfony\Component\HttpFoundation\Response;

class MainController extends TwigController
{

    public function indexAction(Request $request, $appParams)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $moduleModel = new ModulesModel($appParams['entityManager']);

        $this->setPageTemplate('Index.html');
        $this->setModuleRendererOptions(array(
            'modules' => $moduleModel->getAllModules()
        ));

        /** Response */
        return $this->getResponse();
    }



    public function doc($appParams, $moduleToSee)
    {
        $path = $_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/';

        /** Internal controller mixture */
        $moduleModel = new ModulesModel($appParams['entityManager']);
        $moduleToView = $moduleModel->getModuleById($moduleToSee);
        $this->setValues(__DIR__ . '/../Views/', $appParams, $moduleToView, $appParams['container']);

        /** Special case */
        $this->setModule($moduleToView);

        /** Read module ini file */
        $config = parse_ini_file($path . $moduleToView->getModName() . '/module.ini');

        $this->setPageTemplate('ViewPhpDoc.html');
        $this->setModuleRendererOptions(array(
            'module' => $moduleToView->getModName()));

        /** Response */
        return $this->getResponse();
    }

    public function viewModuleAction($appParams, $moduleToSee)
    {
        $path = $_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/';

        /** Internal controller mixture */
        $moduleModel = new ModulesModel($appParams['entityManager']);
        $moduleToView = $moduleModel->getModuleById($moduleToSee);
        $this->setValues(__DIR__ . '/../Views/', $appParams, $moduleToView, $appParams['container']);

        /** Special case */
        $this->setModule($moduleToView);

        /** Read module ini file */
        $config = parse_ini_file($path . $moduleToView->getModName() . '/module.ini');

        $this->setPageTemplate('ViewModule.html');
        $this->setModuleRendererOptions(array(
            'module' => $moduleToView, 'config' => $config));

        /** Response */
        return $this->getResponse();
    }

    public function createModuleAction($appParams)
    {
        /** Internal controller mixture */
        $moduleModel = new ModulesModel($appParams['entityManager']);
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        /** End internal controller mixture */


        $this->setPageTemplate('CreateModule.html');
        $this->setModuleRendererOptions(array());

        /** Response */
        return $this->getResponse();
    }

    public function createModuleCrudAction($appParams)
    {
        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        /** End internal controller mixture */

        $this->setPageTemplate('CreateModuleCrud.html');
        $this->setModuleRendererOptions(array());

        /** Response */
        return $this->getResponse();
    }

    public function codeEditorAction($appParams, $id)
    {
        /** Internal controller mixture */
        $moduleModel = new ModulesModel($appParams['entityManager']);
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        /** End internal controller mixture */
        $module = $moduleModel->getModuleById($id);


        $root = $_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module->getModName().'/';
        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root),
            \RecursiveIteratorIterator::SELF_FIRST | \FilesystemIterator::SKIP_DOTS);

        $directories = array();
        $rootFiles = array();
        $i = 0;
        $iFile = 0;

        foreach ($objects as $name => $object) {
            $tmp = str_replace($root, '', $name);
            $localPath = str_replace('/', '', $tmp);

            $localPath = rtrim($localPath, '/\\');

            if ($object->isDir()) {
                $localPath = stripslashes($localPath);
                $localPath = str_replace('/','',$localPath);

                if (($localPath != ".") && ($localPath != "..")) {
                    $directories[$i] = $localPath;
                    $i++;
                }
            } else {
                $localPath = stripslashes($localPath);
                $localPath = str_replace("/","",$localPath);
                $rootFiles[$iFile] = $localPath;
                $iFile++;
            }
        }

        $this->setPageTemplate('CodeEditor.html');
        $this->setModuleRendererOptions(array('directories' => $directories, 'rootFiles' => $rootFiles, 'id' => $id, 'module_name' => $module->getModName()));

        /** Response */
        return $this->getResponse();
    }

    public function loadFileSystemAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $module_id = $_POST['id'];
            $modulesRepository = $appParams['entityManager']->getRepository('\App\Entities\Module');
            $module = $modulesRepository->findOneBy(array('id' => $module_id));

            $root = $_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module->getModName();
            $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root),
                \RecursiveIteratorIterator::SELF_FIRST | \FilesystemIterator::SKIP_DOTS);

            $directories = array();
            $rootFiles = array();
            $i = 0;
            $iFile = 0;

            foreach ($objects as $name => $object) {
                $localPath = str_replace($root, '', $name);

                if ($object->isDir()) {
                    $localPath = stripslashes($localPath);
                    $localPath = str_replace('/','',$localPath);
                    if (($localPath != ".") && ($localPath != "..")) {
                        $directories[$i] = $localPath;
                        $i++;
                    }
                } else {
                    $localPath = stripslashes($localPath);
                    $localPath = str_replace('/','',$localPath);
                    $rootFiles[$iFile] = $localPath;
                    $iFile++;
                }
            }

            /** Internal controller mixture */
            $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
            /** End internal controller mixture */

            $this->setPageTemplate('FileSystem.html');
            $this->setModuleRendererOptions(array('directories' => $directories, 'rootFiles' => $rootFiles));
            return $this->getResponse();
        }
    }


}