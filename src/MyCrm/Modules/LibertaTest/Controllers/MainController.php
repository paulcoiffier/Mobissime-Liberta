<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\LibertaTest\Controllers;

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use App\Lib\TwigController;

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

}