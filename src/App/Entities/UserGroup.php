<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 21/01/2015
 * Time: 00:45
 */

namespace App\Entities;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinColumn;
/**
 * @Entity @Table(name="users_groups")
 **/
class UserGroup
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User", cascade={"persist", "merge"})
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    public $user;

    /**
     * @ManyToOne(targetEntity="Groups", cascade={"persist", "merge"})
     * @JoinColumn(name="group_id", referencedColumnName="id")
     */
    public $group;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \User $user
     * @return UserGroup
     */
    public function setUser(\App\Entities\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set group
     *
     * @param \Groups $group
     * @return UserGroup
     */
    public function setGroup(\App\Entities\Groups $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Groups 
     */
    public function getGroup()
    {
        return $this->group;
    }
}
