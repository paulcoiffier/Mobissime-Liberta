<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 19/01/2015
 * Time: 23:54
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Entities\Menu;

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
        return $this->entityManager->getRepository('App\Entities\Menu')->findBy(array(),
            array('menu_order' => 'ASC'));
    }

}