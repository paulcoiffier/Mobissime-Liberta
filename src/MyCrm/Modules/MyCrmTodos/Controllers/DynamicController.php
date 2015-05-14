<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 24/02/2015
 * Time: 23:45
 */

namespace MyCrm\Modules\MyCrmTodos\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

use MyCrm\Modules\MyCrmVisualBuilder\Lib\FormsXmlTools;

use App\Lib\TwigController;

class DynamicController extends TwigController
{

    public function indexAction(Request $request, $appParams)
    {
        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $this->setPageTemplate('Index.html');
        $this->setModuleRendererOptions(array());

        /** Response */
        return $this->getResponse();
    }

    public function showAction(Request $request, $appParams, $slug)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        // Set page name
        $this->setPageTemplate($slug . '.html');

        $forms_tools = new FormsXmlTools();
        $array = $forms_tools->getFormXmlControllers("MyCrmTodos", $slug);

        $arrayOfArrays = array();
        foreach ($array as $val) {

            $repo_entity = $val['entity'];
            $query = $val['QueryBinding'];
            $repo_entity = 'App\Entities\\'.$repo_entity;

            /** Execute database query */
            $a = $appParams['entityManager']->getRepository($repo_entity)->$query();

            $a = array($val['name'] => $a);
            $b = $arrayOfArrays;
            $arrayOfArrays = ($a + $b);
        }

        $this->setModuleRendererOptions($arrayOfArrays);
        return $this->getResponse();
    }
}