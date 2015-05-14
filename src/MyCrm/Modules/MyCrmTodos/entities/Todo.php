<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 27/01/2015
 * Time: 20:39
 */

/**
 * @Entity @ORM\Table(name="todos")
 **/

include '../../include/entities/User.php';

use Doctrine\ORM\Mapping as ORM;
use User as User;

class Todo
{

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", nullable=true) * */
    public $todo_content;

    /**
     * @var User
     * @ManyToOne(targetEntity="User", cascade={"persist", "merge"})
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    public $todo_user;

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
     * Set todo_content
     *
     * @param string $todoContent
     * @return Todo
     */
    public function setTodoContent($todoContent)
    {
        $this->todo_content = $todoContent;

        return $this;
    }

    /**
     * Get todo_content
     *
     * @return string
     */
    public function getTodoContent()
    {
        return $this->todo_content;
    }

    /**
     * Set user
     *
     * @param \User $user
     * @return Todo
     */
    public function setUser(\User $user = null)
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
     * Set todo_user
     *
     * @param \User $todoUser
     * @return Todo
     */
    public function setTodoUser(\User $todoUser)
    {
        $this->todo_user = $todoUser;

        return $this;
    }

    /**
     * Get todo_user
     *
     * @return \User 
     */
    public function getTodoUser()
    {
        return $this->todo_user;
    }
}
