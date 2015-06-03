<?php

namespace App\Controller;

use App\Lib\TwigController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Global Application Controller
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class AppController extends TwigController
{

    /**
     * Authentication / Login method
     *
     * @param Request $request Http Request (Symfony)
     * @param Array $appParams Array that contains application global parameters
     * @return Response
     */
    public function indexAction(Request $request, $appParams)
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

    /**
     * Show Login Page
     *
     * @param Array $appParams Array that contains application global parameters
     * @return Response
     */
    public function LoginAction($appParams)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        /** End internal controller mixture */

        $this->setTemplatesFolder(__DIR__ . '/../Views/');
        $this->setPageTemplate('Login.html');


        return $this->getResponse();
    }

    /**
     * Show html 404 Error
     *
     * @return Response
     */
    public function notFoundPage()
    {
        $this->setTemplatesFolder(__DIR__ . '/../Views/');
        $this->setPageTemplate('404.html');

        return $this->getResponse();
    }

    /**
     * Show internal error page
     *
     * @param Array $appParams Array that contains application global parameters
     * @return Response
     */
    public function internalErrorPage()
    {
        $this->setTemplatesFolder(__DIR__ . '/../Views/');
        $this->setPageTemplate('500.html');

        return $this->getResponse();
    }

}