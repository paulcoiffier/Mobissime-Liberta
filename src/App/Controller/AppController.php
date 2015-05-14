<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace App\Controller;

use App\Lib\TwigController;
use Symfony\Component\HttpFoundation\Request;

class AppController extends TwigController
{

    public function indexAction(Request $request, $appParams, $container)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        /** Module rendering */
        $this->setPageTemplate('Index.html');
        $this->setModuleRendererOptions(array());

        return $this->getResponse();
    }

    public function LoginAction($appParams)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        /** End internal controller mixture */

        $this->setTemplatesFolder(__DIR__ . '/../Views/');
        $this->setPageTemplate('Login.html');


        return $this->getResponse();
    }

    public function notFoundPage()
    {
        $this->setTemplatesFolder(__DIR__ . '/../Views/');
        $this->setPageTemplate('404.html');

        return $this->getResponse();
    }

    public function internalErrorPage()
    {
        $this->setTemplatesFolder(__DIR__ . '/../Views/');
        $this->setPageTemplate('500.html');

        return $this->getResponse();
    }

}