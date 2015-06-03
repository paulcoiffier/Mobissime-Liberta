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

/**
 * Application utility class
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class GlobalUtils
{

    /**
     * @var EntityManager
     */
    public $entityManager;


    /**
     * @param EntityManager $entityManager
     */
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