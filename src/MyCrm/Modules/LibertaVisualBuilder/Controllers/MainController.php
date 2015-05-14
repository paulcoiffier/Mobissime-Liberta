<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\LibertaVisualBuilder\Controllers;

use App\Lib\TwigController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MyCrm\Modules\LibertaModules\Model\ModulesModel;
use App\Lib\EntitiesUtils;
use MyCrm\Modules\LibertaModules\Lib\FormsGenerator;
use MyCrm\Modules\LibertaDataStore\Lib\RepositoryUtils;
use MyCrm\Modules\LibertaVisualBuilder\Lib\FormsXmlTools;

class MainController extends TwigController
{

    public function testAction(Request $request, $appParams)
    {
        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        $this->setPageTemplate('Test.html');
        $this->setModuleRendererOptions(array());
        /** End internal controller mixture */

        /** Response */
        return $this->getResponse();
    }

    public function indexAction(Request $request, $appParams, $moduleId)
    {
        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $this->setPageTemplate('Index.html');
        $this->setModuleRendererOptions(array());

        $moduleModel = new ModulesModel($appParams['entityManager']);
        $moduleToView = $moduleModel->getModuleById($moduleId);

        /** Parse module XML File */
        $entities = simplexml_load_file(install_sys_dir . 'src/MyCrm/Modules/' . $moduleToView->getModName() . '/Conf/entities.xml');

        $entityUtils = new EntitiesUtils();
        $options = array("entities" => "");

        /** Add each entity in module array for twig usages */
        foreach ($entities as $entity) {
            $array = $entityUtils->getEntityFields($entity->name, $appParams['entityManager']);
            $options['entities']["$entity->name"] = $array;

            /** For each entity get the queries list */
            $repo_utils = new RepositoryUtils();
            $entity_queries = $repo_utils->getRepositoryQueries($entity->name);
            $options['entities']["$entity->name"]["queries"] = $entity_queries;

        }

        /** Parse view files */
        $root = $_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $moduleToView->getModName() . '/Views//';
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
                if (($localPath != ".") && ($localPath != "..")) {
                    $directories[$i] = $localPath;
                    $i++;
                }
            } else {
                $localPath = stripslashes($localPath);
                $localPath = str_replace($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $moduleToView->getModName() . '/Views/', "", $localPath);

                $rootFiles[$iFile] = $localPath;
                $iFile++;
            }
        }

        $newArray = array("files" => $rootFiles);
        $options = array_merge($options, $newArray);

        /** Array with fields types */
        $types = array("Text", "Long text", "Select", "Checkbox", "Radio");
        $fields_types = array("fields_types" => $types);

        $moduleArray = array("module_edit_name" => $moduleToView->getModName());
        $options = array_merge($options, $moduleArray);
        $options = array_merge($options, $fields_types);

        $this->setModuleRendererOptions($options);

        /** Response */
        return $this->getResponse();
    }

    public function loadEditorFileAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $fileToLoad = $_POST['fileToLoad'];
            $module_name = $_POST['module_name'];

            $file = file_get_contents($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Data/Views/' . $fileToLoad, true);

            /** Remove template enveloppe */
            $file = str_replace("{% extends MainTpl %}", "", $file);
            $file = str_replace("{% block header %}{{module_title}}{% endblock %}", "", $file);
            $file = str_replace("{% block header_block %}", "", $file);
            $file = str_replace("{% include 'Header.html' %}", "", $file);
            $file = str_replace("{% endblock %}", "", $file);
            $file = str_replace("{% block main_content %}", "", $file);
            $file = str_replace("{% endblock %}", "", $file);

            $arr = array(
                'error' => 'no',
                'fileContent' => $file
            );

            return new Response(json_encode($arr));
        }
    }

    public function updateFormAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $fileName = $_POST['fileName'];
            $module_name = $_POST['module_name'];
            $content = $_POST['content'];

            $file = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Data/Views/' . $fileName, "w");

            fwrite($file, "{% extends MainTpl %}");
            fwrite($file, "{% block header %}{{module_title}}{% endblock %}");
            fwrite($file, "{% block header_block %}");
            fwrite($file, "{% include 'Header.html' %}");
            fwrite($file, "{% endblock %}");
            fwrite($file, "{% block main_content %}");
            fwrite($file, $content);
            fwrite($file, "{% endblock %}");

            fclose($file);

            return new Response("ok");
        }
    }

    public function saveCleanAjaxAction(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $fileName = $_POST['fileName'];
            $module_name = $_POST['module_name'];
            $content = $_POST['content'];

            $file = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Views/' . $fileName, "w");

            fwrite($file, "{% extends MainTpl %}");
            fwrite($file, "{% block header %}{{module_title}}{% endblock %}");
            fwrite($file, "{% block header_block %}");
            fwrite($file, "{% include 'Header.html' %}");
            fwrite($file, "{% endblock %}");
            fwrite($file, "{% block main_content %}");

            $content = str_replace('<div class="container">','<div class="container" style="width:100%;">',$content);

            fwrite($file, $content);
            fwrite($file, "{% endblock %}");

            fclose($file);

            return new Response("ok");
        }
    }

    public function loadDatatableComponentAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            /** Internal controller mixture */
            $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
            $this->setRequest($request);
            /** End internal controller mixture */

            $entity = $_POST['entity'];
            $module_name = $_POST['module_name'];

            /** Select entity */
            $entityUtils = new EntitiesUtils();
            $array = $entityUtils->getEntityFields($entity, $appParams['entityManager']);

            $this->setPageTemplate('DatatableCreator.html');

            $options = array(
                'entity' => $array
            );

            $this->setModuleRendererOptions($options);

            return $this->getResponse();

        }
    }

    public function loadSelectComponentAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            /** Internal controller mixture */
            $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
            $this->setRequest($request);
            /** End internal controller mixture */

            $entity = $_POST['entity'];
            $module_name = $_POST['module_name'];

            /** Select entity */
            $entityUtils = new EntitiesUtils();
            $array = $entityUtils->getEntityFields($entity, $appParams['entityManager']);

            $this->setPageTemplate('FormCreator.html');
            $types = array("Checkbox", "Date", "DateTime", "Select", "List of values", "Long text", "Number", "Object entity", "Radio", "Text");

            $entities = simplexml_load_file(install_sys_dir . 'src/MyCrm/Modules/' . $module_name . '/Conf/entities.xml');

            $options = array(
                'entity' => $array,
                'entities' => $entities,
                "fields_types" => $types
            );

            $this->setModuleRendererOptions($options);

            return $this->getResponse();
        }
    }

    public function generateFormAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        $html = '<a href="#close" onclick="javascript:removeXmlComponent(this);" class="remove label label-danger"><i class="glyphicon-remove glyphicon"></i> remove</a>';
        $html .= '<span class="drag label label-default"><i class="glyphicon glyphicon-move"></i> drag</span>';

        $html .= ' <span class="configuration">';
        $html .= ' <a class="btn btn-xs btn-default editButton" rel="table-hover">Edit</a>';
        $html .= '</span>';

        $html .= '<div class="preview">Polo</div>';
        $html .= '<div class="view">';
        $html .= '<div class="row clearfix">';
        $html .= "<div class='col-md-12 column ui-sortable'>";
        $f_generator = new FormsGenerator();

        if ($request->isXmlHttpRequest()) {

            $fields = $_REQUEST['fields'];
            $component = $_REQUEST['component'];

            foreach ($fields as $field) {

                $field_name = $field['field'];
                $field_type = $field['fieldType'];
                $field_entity = $field['entity'];

                /** Create field for this field */
                $html .= $f_generator->getTextFieldDraggable($field_name, 10);

            }

            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";

            /** XML process */
            $forms_tools = new FormsXmlTools();
            $forms_tools->testAndCreateXmlDef($_REQUEST['module_name'], $_REQUEST['form_name']);
            $forms_tools->addXmlComponentDef($_REQUEST['module_name'], $_REQUEST['form_name'], $_REQUEST['entity'], $_REQUEST['current_query_name'], $component, $fields);

            return new Response($html);

        }
    }

    public function removeComponentAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            /** XML process */
            $forms_tools = new FormsXmlTools();
            $forms_tools->removeXmlComponent($_REQUEST['module_name'], $_REQUEST['form_name'], $_REQUEST['component_name']);
            return new Response("ok");
        }
    }

    public function generateTableAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $fields = $_REQUEST['fields'];
            $component = $_REQUEST['component'];

            $html = '<a href="#close" onclick="javascript:removeXmlComponent(this);" class="remove label label-danger"><i class="glyphicon glyphicon-remove"></i> remove</a>';
            $html .= '<span class="drag label label-default"><i class="glyphicon glyphicon-move"></i> drag</span>';
            $html .= '<span class="configuration">';
            $html .= '<span class="btn-group btn-group-xs">';
            $html .= '<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">Style';
            $html .= '<span class="caret"></span></a>';
            $html .= '<ul class="dropdown-menu">';
            $html .= ' <li class="active"><a href="#" rel="">Default</a></li>';
            $html .= '<li class=""><a href="#" rel="table-striped">Striped</a></li>';
            $html .= '<li class=""><a href="#" rel="table-bordered">Bordered</a></li>';
            $html .= '</ul>';
            $html .= '</span>';
            $html .= '<a class="btn btn-xs btn-default" href="#" rel="table-hover">Hover</a>';
            $html .= '<a class="btn btn-xs btn-default" href="#" rel="table-condensed">Condensed</a>';
            $html .= '</span>';
            $html .= '<div class="preview">Table</div>';
            $html .= '<div class="view">';
            $html .= '<table class="table" contenteditable="true">';

            $html .= '<thead>';
            $html .= '<tr>';

            /** Columns generation */
            foreach ($fields as $field) {
                $field_name = $field['field'];
                $html .= '<th>' . $field_name . '</th>';
            }
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';

            $component_name = $component['name'];

            /** TODO / Fix : Table sample content generation */

            //$html .= '{% for fields in ' . $entity . ' %}';
            $html .= '<!-- ' . $component_name . ' -->';
            $html .= '<tr>';
            foreach ($fields as $field) {
                $field_name = $field['field'];
                $html .= '<td>fields.' . $field_name . '</td>';
            }
            $html .= '</tr>';
            //$html .= '{% endfor %}';

            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';

            /** XML process */
            $forms_tools = new FormsXmlTools();
            $forms_tools->testAndCreateXmlDef($_REQUEST['module_name'], $_REQUEST['form_name']);
            $forms_tools->addXmlComponentDef($_REQUEST['module_name'], $_REQUEST['form_name'], $_REQUEST['entity'], $_REQUEST['current_query_name'], $component, $fields);

            return new Response($html);
        }

    }


    public function createNewFormAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $fileName = $_POST['fileName'];
            $module_name = $_POST['module_name'];

            $file = fopen($_SERVER["DOCUMENT_ROOT"] . install_path . 'src/MyCrm/Modules/' . $module_name . '/Views/' . $fileName, "w");
            fwrite($file, "{% extends MainTpl %}\n");
            fwrite($file, "{% block header %}Todos{% endblock %}\n");
            fwrite($file, "{% block header_block %}\n");
            fwrite($file, "{% include 'Header.html' %}\n");
            fwrite($file, "{% endblock %}\n");
            fwrite($file, "{% block main_content %}\n");
            fwrite($file, "Place your content here\n");
            fwrite($file, "{% endblock %}\n");
            fclose($file);
            return new Response("ok");
        }
    }

    public function createFormXmlBindingsAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $module_name = $_POST['module_name'];
            $form_name = $_POST['form_name'];

            $forms_tools = new FormsXmlTools();
            $forms_tools->createFormXmlBindings($module_name, $form_name);

            return new Response("ok");
        }
    }

}
