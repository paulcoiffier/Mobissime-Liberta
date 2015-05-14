<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\LibertaUserProfile\Controllers;

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Lib\TwigController;
use MyCrm\Modules\LibertaUserProfile\Lib\PictureUtils;

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

    public function updatePasswordAction(Request $request, $appParams)
    {
        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $this->setPageTemplate('UpdatePassword.html');
        $this->setModuleRendererOptions(array('usr_email' => $_SESSION['mycrmlogin']));

        /** Response */
        return $this->getResponse();
    }

    public function checkPasswordAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $this->setRequest($request);
            $id = $_POST['id'];

            /** Get connected user */
            $userRepository = $appParams['entityManager']->getRepository('\App\Entities\User');
            $user = $userRepository->findOneBy(
                array('id' => $id)
            );

            $password = md5($_POST['actual_password']);

            if ($user->getUsrPassword() == $password) {
                $arr = array(
                    'error' => 'no'
                );
            } else {
                $arr = array(
                    'error' => 'yes'
                );
            }

            return new Response(json_encode($arr));
        }
    }

    public function updatePasswordAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $this->setRequest($request);
            $id = $_POST['id'];

            /** Get connected user */
            $userRepository = $appParams['entityManager']->getRepository('\App\Entities\User');
            $user = $userRepository->findOneBy(
                array('id' => $id)
            );

            $password = md5($_POST['new_password']);

            $user->setUsrPassword($password);

            $appParams['entityManager']->merge($user);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

    public function saveProfileAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $this->setRequest($request);
            $userId = $_POST['userid'];

            /** Get connected user */
            $userRepository = $appParams['entityManager']->getRepository('\App\Entities\User');
            $user = $userRepository->findOneBy(
                array('id' => $userId)
            );

            $user->setUsrFirstName($_POST['usr_first_name']);
            $user->setUsrLastName($_POST['usr_last_name']);

            $date = \DateTime::createFromFormat('d-m-Y', $_POST['usr_date_naissance']);
            $user->setUsrDateNaissance(new \DateTime($date));
            $user->setUsrPhone($_POST['usr_phone']);
            $user->setUsrMobilePhone($_POST['usr_mobile_phone']);
            $user->setUsrEmail($_POST['usr_email']);
            $user->setUsrLanguage($_POST['usr_language']);

            $appParams['entityManager']->merge($user);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }
    public function saveProfilePictureAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $this->setRequest($request);
            $image = $_POST['image'];
            $userId = $_POST['userid'];

            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            file_put_contents('../data/users_profiles/' . $userId . '.png', $image);

            /** Resize picture to 48x48 */
            $newImage = new PictureUtils();
            $newImage->load('../data/users_profiles/' . $userId . '.png');
            $newImage->resize(48, 48);
            $newImage->save('../data/users_profiles/' . $userId . '_small.png');

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

}