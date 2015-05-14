<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 15:56
 */

namespace MyCrm\Modules\MyCrmTickets\Controllers;

use Symfony\Component\HttpFoundation\Response;
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

        $query = $appParams['entityManager']->createQuery('SELECT c FROM \App\Entities\Cases c where c.case_status <> 3');
        $cases = $query->getResult();

        $query = $appParams['entityManager']->createQuery('SELECT c FROM \App\Entities\Cases c where c.case_status = 3');
        $casesClosed = $query->getResult();

        $this->setPageTemplate('Index.html');
        $this->setModuleRendererOptions(array(
            'cases' => $cases,
            'casesClosed' => $casesClosed
        ));

        /** Response */
        return $this->getResponse();
    }

    public function openCaseAction(Request $request, $appParams)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $accountRepository = $appParams['entityManager']->getRepository('\App\Entities\Account');
        $accounts = $accountRepository->findAll();

        $usersRepository = $appParams['entityManager']->getRepository('\App\Entities\User');
        $users = $usersRepository->findAll();

        $this->setPageTemplate('OpenCase.html');
        $this->setModuleRendererOptions(array(
            'accounts' => $accounts,
            'users' => $users
        ));

        /** Response */
        return $this->getResponse();
    }

    public function viewCaseAction(Request $request, $appParams, $id)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $casesRepository = $appParams['entityManager']->getRepository('\App\Entities\Cases');
        $case = $casesRepository->findOneBy(array('id' => $id));

        $accountsRepository = $appParams['entityManager']->getRepository('\App\Entities\Account');
        $account = $accountsRepository->findOneBy(array('id' => $case->case_account));

        $this->setPageTemplate('ViewCase.html');
        $this->setModuleRendererOptions(array(
            'account' => $account,
            'case' => $case
        ));

        /** Response */
        return $this->getResponse();
    }

    public function editCaseAction(Request $request, $appParams, $id)
    {

        /** Internal controller mixture */
        $this->setValues(__DIR__ . '/../Views/', $appParams, $appParams['container']);
        $this->setRequest($request);
        /** End internal controller mixture */

        $casesRepository = $appParams['entityManager']->getRepository('\App\Entities\Cases');
        $case = $casesRepository->findOneBy(array('id' => $id));

        $casesRepository = $appParams['entityManager']->getRepository('\App\Entities\Cases');
        $cases = $casesRepository->findAll();

        $usersRepository = $appParams['entityManager']->getRepository('\App\Entities\User');
        $users = $usersRepository->findAll();


        $accountsRepository = $appParams['entityManager']->getRepository('\App\Entities\Account');
        $account = $accountsRepository->findOneBy(array('id' => $case->case_account));

        $this->setPageTemplate('EditCase.html');
        $this->setModuleRendererOptions(array(
            'case' => $case,
            'account' => $account,
            'users' => $users
        ));

        /** Response */
        return $this->getResponse();
    }

    public function deleteCaseAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $id = $_POST['id'];
            $case = $appParams['entityManager']->getRepository('\App\Entities\Cases')->findOneBy(array('id' => $id));

            $appParams['entityManager']->remove($case);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

    public function getContactForAccountAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $id = $_POST['id'];
            $query = $appParams['entityManager']->createQuery('SELECT c, p FROM \App\Entities\Contact c JOIN c.person p where c.account_id=:id order by p.person_last_name');
            $query->setParameter('id', $id);
            $contacts = $query->getResult();

            $i = 0;
            foreach ($contacts as $contact) {
                $json[$i]['person_first_name'] = utf8_encode($contact->person->person_first_name);
                $json[$i]['person_last_name'] = utf8_encode($contact->person->person_last_name);
                $i++;
            }

            return new Response(json_encode($json));
        }
    }

    public function insertCaseAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            /** Default encoding */
            mb_internal_encoding('UTF-8');

            $case = new \App\Entities\Cases();
            $case->setCaseType($_POST['case_type']);
            $case->setCaseSubject($_POST['case_subject']);
            $case->setCaseStatus($_POST['case_status']);
            $case->setCaseDateOpen(new \DateTime("now"));
            $case->setCaseDescription($_POST['case_description']);

            $account = $appParams['entityManager']->getRepository('\App\Entities\Account')->findOneBy(array('id' => $_POST['case_account']));
            $case->setCaseAccount($account);

            $contact = $appParams['entityManager']->getRepository('\App\Entities\Contact')->findOneBy(array('id' => $_POST['case_contact']));
            $case->setCaseContact($contact);

            $case->setCasePriority($_POST['case_priority']);

            $user = $appParams['entityManager']->getRepository('\App\Entities\User')->findOneBy(array('id' => $_POST['assignedTo']));
            $case->setAssignedTo($user);

            $appParams['entityManager']->persist($case);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

    public function updateCaseAjax(Request $request, $appParams)
    {
        $request = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {

            /** Default encoding */
            mb_internal_encoding('UTF-8');

            $id = $_POST['id'];
            $casesRepository = $appParams['entityManager']->getRepository('\App\Entities\Cases');
            $case = $casesRepository->findOneBy(array('id' => $id));

            $case->setCaseType($_POST['case_type']);
            $case->setCaseSubject(($_POST['case_subject']));
//$case->setCaseDateOpen(new \DateTime("now"));
            $case->setCaseDescription(($_POST['case_description']));
            $case->setCaseResolution($_POST['case_resolution']);
            $case->setCasePriority($_POST['case_priority']);

            /** If status is resolved we have to set the resolved date */
            $case->setCaseStatus($_POST['case_status']);
            if ($_POST['case_status'] == '3') {
                $case->setCaseDateSolve(new \DateTime("now"));
            } else {
                $case->setCaseDateSolve(null);
            }

            $user = $appParams['entityManager']->getRepository('\App\Entities\User')->findOneBy(array('id' => $_POST['assignedTo']));
            $case->setAssignedTo($user);

            $appParams['entityManager']->merge($case);
            $appParams['entityManager']->flush();

            $arr = array(
                'error' => 'no'
            );

            return new Response(json_encode($arr));
        }
    }

}