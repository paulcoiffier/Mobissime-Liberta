<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\LibertaTodos\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

use App\Lib\TwigController;
use MyCrm\Modules\LibertaTodos\Model\ModulesModel;

class MainController extends TwigController
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

    public function showAction($slug)
    {
        //echo $slug;
        return new Response('');
    }

}