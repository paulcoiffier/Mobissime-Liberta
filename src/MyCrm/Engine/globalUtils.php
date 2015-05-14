<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 19/01/2015
 * Time: 23:54
 */

namespace MyCrm\Engine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class GlobalUtils
{

    public $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get All menu entries for menu dynamic construction
     */
    function getAllMenuEntries()
    {
        return $this->entityManager->getRepository('Menu')->findBy(array(),
            array('menu_order' => 'ASC'));
    }

}