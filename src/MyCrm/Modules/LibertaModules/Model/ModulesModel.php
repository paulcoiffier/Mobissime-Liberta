<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 29/01/2015
 * Time: 02:53
 */

namespace MyCrm\Modules\LibertaModules\Model;


class ModulesModel
{

    private $entityManager;

    function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getModuleById($module_id)
    {
        return $this->entityManager->getRepository('App\Entities\Module')->findOneBy(array('id' => $module_id));
    }

    public function getModuleByName($module_name)
    {
        return $this->entityManager->getRepository('App\Entities\Module')->findOneBy(array('mod_name' => $module_name));
    }

    public function getAllModules()
    {
        $modulesRepository = $this->entityManager->getRepository('App\Entities\Module');
        return $modulesRepository->findBy(array(), array('mod_name' => 'ASC'));
    }
}