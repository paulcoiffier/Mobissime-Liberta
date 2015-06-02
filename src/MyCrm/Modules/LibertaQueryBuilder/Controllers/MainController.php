<?php

namespace MyCrm\Modules\LibertaQueryBuilder\Controllers;

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Lib\TwigController;
use MyCrm\Modules\LibertaModules\Model\ModulesModel;


class MainController extends TwigController
{

    public function indexAction(Request $request, $appParams, $moduleId)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        /** Read XML Module queries file "queries.xml" */
        $moduleModel = new ModulesModel($appParams['entityManager']);
        $moduleToView = $moduleModel->getModuleById($moduleId);

        $moduleModel = new ModulesModel($appParams['entityManager']);
        $moduleToView = $moduleModel->getModuleById($moduleId);

        $q = new \MyCrm\Modules\LibertaQueryBuilder\Model\QueriesModel;
        $queries = $q->getQueries($moduleToView->getModName());

        /** Apply page template and parameters */
        $this->setPageTemplate('Index.html');
        $this->setModuleRendererOptions(array('queries' => $queries, 'moduleToView' => $moduleToView->getModName()));

        /** Response */
        return $this->getResponse();
    }


    public function updateQueryAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $name = $_REQUEST['name'];
            $description = $_REQUEST['description'];

            $id = $_REQUEST['id'];
            $value = $_REQUEST['valeur'];
            $module_name = $_REQUEST['module_name'];

            /** Update query in xml file */
            $q = new \MyCrm\Modules\LibertaQueryBuilder\Model\QueriesModel;
            $q->updateQuery($module_name, $id, $name, $description, $value);

            return new Response('ok');
        }
    }

    public function addQueryAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $query_name = $_REQUEST['query_name'];
            $query_description = $_REQUEST['query_description'];
            $query_value = $_REQUEST['query_value'];
            $module_name = $_REQUEST['module_name'];

            $q = new \MyCrm\Modules\LibertaQueryBuilder\Model\QueriesModel;
            $id = $q->getNewQueryId();

            $q->addQuery($module_name, $id, $query_name, $query_description, $query_value);

            return new Response('ok');
        }
    }

    public function deleteQueryAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $id = $_REQUEST['id'];
            $module_name = $_REQUEST['module_name'];

            $q = new \MyCrm\Modules\LibertaQueryBuilder\Model\QueriesModel;

            $q->deleteQuery($module_name, $id);

            return new Response('ok');
        }
    }



}