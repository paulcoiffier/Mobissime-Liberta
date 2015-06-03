<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Lib\Login;

define("version","Test");

/**
 * Global Ajax Controller
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class AjaxAppController
{
    /**
     * Authentication / Login method
     *
     * @param Array $appParams Array that contains application global parameters
     * @return Response|JSON
     */
    public function ajaxLogin($appParams)
    {

        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $password = md5($_POST['password']);
            $login = $_POST['login'];
            $user = $appParams['entityManager']->getRepository('App\Entities\User')->findOneBy(array('usr_email' => $login, 'usr_password' => $password));

            if ($user != null) {
                $_SESSION['mycrmlogin'] = $login;
                $_SESSION['mycrmlanguage'] = $user->getUsrLanguage();
                $arr = array(
                    'error' => 'no',
                    'result' => 'yes'
                );
                $login = new Login();
                $login->setUserIsLoggedIn(true);
            } else {
                $arr = array(
                    'error' => 'no',
                    'result' => 'no'
                );
            }
        }

        return new Response(json_encode($arr));
    }
}

