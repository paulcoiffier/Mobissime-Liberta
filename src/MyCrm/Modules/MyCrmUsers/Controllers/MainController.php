<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\MyCrmUsers\Controllers;

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Lib\TwigController;

class MainController extends TwigController
{

    public function indexAction(Request $request, $appParams)
    {

        /** Get all groups entries */
        $groupsRepository = $appParams['entityManager']->getRepository('\App\Entities\Groups');
        $groups = $groupsRepository->findAll();

        /** Get all users entries */
        $usersRepository = $appParams['entityManager']->getRepository('\App\Entities\User');
        $users = $usersRepository->findAll();

        /** Get all UserGroup entries */
        $usersRepository = $appParams['entityManager']->getRepository('\App\Entities\UserGroup');
        $usersGroups = $usersRepository->findAll();

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $this->setPageTemplate('Index.html');
        $this->setModuleRendererOptions(array('groups' => $groups,
            'users' => $users,
            'usersGroups' => $usersGroups
        ));

        /** Response */
        return $this->getResponse();
    }

    public function createGroupAction(Request $request, $appParams)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $this->setPageTemplate('CreateGroup.html');
        $this->setModuleRendererOptions(array());

        /** Response */
        return $this->getResponse();
    }

    public function createUserAction(Request $request, $appParams)
    {
        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $groupsRepository = $appParams['entityManager']->getRepository('\App\Entities\Groups');
        $groups = $groupsRepository->findAll();

        $this->setPageTemplate('CreateUser.html');
        $this->setModuleRendererOptions(array('groups' => $groups));

        /** Response */
        return $this->getResponse();
    }

    public function editUserAction(Request $request, $appParams, $userId)
    {
        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $usersRepository = $appParams['entityManager']->getRepository('\App\Entities\User');
        $user = $usersRepository->findOneBy(array('id' => $userId));

        /** Get all users in the group */
        $groupsRepository = $appParams['entityManager']->getRepository('\App\Entities\UserGroup');
        $userGroups = $groupsRepository->findBy(array('user' => $user));

        /** List all groups */
        $groupsRepository = $appParams['entityManager']->getRepository('\App\Entities\Groups');
        $groups = $groupsRepository->findAll();

        $this->setPageTemplate('EditUser.html');
        $this->setModuleRendererOptions(array(
            'userGroups' => $userGroups,
            'groups' => $groups,
            'user' => $user
        ));

        /** Response */
        return $this->getResponse();
    }

    public function editGroupAction(Request $request, $appParams, $groupId)
    {
        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        /** Get all groups entries */
        $groupsRepository = $appParams['entityManager']->getRepository('\App\Entities\Groups');
        $group = $groupsRepository->findOneBy(array('id' => $groupId));

        /** Get all users in the group */
        $usersRepository = $appParams['entityManager']->getRepository('\App\Entities\UserGroup');
        $users = $usersRepository->findBy(array('group' => $group));

        $this->setPageTemplate('EditGroup.html');
        $this->setModuleRendererOptions(array(
            'group' => $group,
            'users' => $users
        ));

        /** Response */
        return $this->getResponse();
    }


    public function deleteUserAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $id = $_POST['id'];

            $user = $appParams['entityManager']->getRepository('\App\Entities\User')->findOneBy(array('id' => $id));
            $userGroups = $appParams['entityManager']->getRepository('\App\Entities\UserGroup')->findBy(array('user' => $user));

            foreach ($userGroups as $userGroup) {
                $appParams['entityManager']->remove($userGroup);
                $appParams['entityManager']->flush();
            }

            $appParams['entityManager']->remove($user);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

    public function insertGroupAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            $group = new \App\Entities\Groups();
            $group->setGrpName($_POST['grp_name']);
            $group->setGrpDescription($_POST['grp_description']);

            $appParams['entityManager']->persist($group);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

    public function insertUserAjax(Request $request, $appParams)
    {


        /** User creation */
        $user = new \App\Entities\User();
        $user->setUsrFirstName($_POST['usr_first_name']);
        $user->setUsrLastName($_POST['usr_last_name']);
        $user->setUsrEmail($_POST['usr_email']);
        $user->setUsrPassword($_POST['usr_password']);
        $user->setUsrPhone($_POST['usr_phone']);
        $user->setUsrMobilePhone($_POST['usr_mobile_phone']);

        $appParams['entityManager']->persist($user);
        $appParams['entityManager']->flush();

        foreach ($_POST as $k => $v) {
            $$k = htmlspecialchars($v);

            /** For UserGroup objects creation */
            if (strpos($k, 'group_') !== false) {
                $val = str_replace('group_', '', $k);

                /** Find group */
                $groupRepository = $appParams['entityManager']->getRepository('\App\Entities\Groups');
                $group = $groupRepository->findOneBy(array('id' => $val));

                $userGroup = new \App\Entities\UserGroup();
                $userGroup->setGroup($group);
                $userGroup->setUser($user);

                $appParams['entityManager']->persist($userGroup);
                $appParams['entityManager']->flush();

            }
        }

        //echo "<script>window.location.href = 'index.php?module=" . $module_name . "';</script>";

        $url = $appParams['install_url'] . 'web/front.php/users';
        return new Response("<script>window.location.href='$url'</script>");

    }

    public function updateUserAjax(Request $request, $appParams)
    {

        $user = $appParams['entityManager']->getRepository('\App\Entities\User')->findOneBy(array('id' => $_POST['id']));

        /** Delete all exiting UserGroup objects */
        $userGroups = $appParams['entityManager']->getRepository('\App\Entities\UserGroup')->findBy(array('user' => $user));

        foreach ($userGroups as $userGroup) {
            $appParams['entityManager']->remove($userGroup);
            $appParams['entityManager']->flush();
        }

        /** Create all UserGroup objects */
        foreach ($_POST as $k => $v) {
            $$k = htmlspecialchars($v);

            /** For UserGroup objects creation */
            if (strpos($k, 'group_') !== false) {
                $val = str_replace('group_', '', $k);

                /** Find group */
                $groupRepository = $appParams['entityManager']->getRepository('\App\Entities\Groups');
                $group = $groupRepository->findOneBy(array('id' => $val));

                $userGroup = new \App\Entities\UserGroup();
                $userGroup->setGroup($group);
                $userGroup->setUser($user);

                $appParams['entityManager']->persist($userGroup);
                $appParams['entityManager']->flush();

            }
        }

        /** Update user fields */
        $user->setUsrFirstName($_POST['usr_first_name']);
        $user->setUsrLastName($_POST['usr_last_name']);
        $user->setUsrEmail($_POST['usr_email']);
        // TODO : Fix password update (md5 encryption problem)
        //$user->setUsrPassword($_POST['usr_password']);
        $user->setUsrPhone($_POST['usr_phone']);
        $user->setUsrMobilePhone($_POST['usr_mobile_phone']);

        $appParams['entityManager']->merge($user);
        $appParams['entityManager']->flush();

        $url = $appParams['install_url'] . 'web/front.php/users';
        return new Response("<script>window.location.href='$url'</script>");

    }
}