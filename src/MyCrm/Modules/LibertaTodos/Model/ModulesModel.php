<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 29/01/2015
 * Time: 05:07
 */

namespace MyCrm\Modules\LibertaTodos\Model;


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

    public function getAllModules()
    {
        $modulesRepository = $this->entityManager->getRepository('App\Entities\Module');
        return $modulesRepository->findAll();
    }
}