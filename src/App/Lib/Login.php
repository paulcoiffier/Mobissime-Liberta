<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 29/01/2015
 * Time: 21:59
 */

namespace App\Lib;

/**
 * Login utility class
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class Login
{

    /**
     * @var bool if user is logged in
     */
    private $user_is_logged_in = false;

    /**
     * @var user connected
     */
    private $user;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_GET["logout"])) {
            $this->doLogout();
        }

    }

    private function loginWithSessionData()
    {
        $this->user_name = $_SESSION['user_name'];
        $this->user_email = $_SESSION['user_email'];

        // set logged in status to true, because we just checked for this:
        // !empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)
        // when we called this method (in the constructor)
        $this->user_is_logged_in = true;
    }

    private function loginWithPostData($user_name, $user_password, $user_rememberme)
    {

        // write user data into PHP SESSION [a file on your server]
        /*$_SESSION['user_id'] = $result_row->user_id;
        $_SESSION['user_name'] = $result_row->user_name;
        $_SESSION['user_email'] = $result_row->user_email;
        $_SESSION['user_logged_in'] = 1;*/

        // declare user id, set the login status to true
        /*$this->user_id = $result_row->user_id;
        $this->user_name = $result_row->user_name;
        $this->user_email = $result_row->user_email;
        $this->user_is_logged_in = true;*/
    }

    public function doLogout()
    {
        $this->deleteRememberMeCookie();

        $_SESSION = array();
        session_destroy();

        $this->user_is_logged_in = false;
        $this->messages[] = MESSAGE_LOGGED_OUT;
    }

    /**
     * @return boolean
     */
    public function isUserIsLoggedIn()
    {
        if(isset($_SESSION['islogin'])){
            $this->user_is_logged_in = $_SESSION['islogin'];
        }
        return $this->user_is_logged_in;
    }

    /**
     * @param boolean $user_is_logged_in
     */
    public function setUserIsLoggedIn($user_is_logged_in)
    {
        $_SESSION['islogin'] = $user_is_logged_in;
        $this->user_is_logged_in = $_SESSION['islogin'];
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(\App\Entities\User $user)
    {
        $this->user = $user;
    }

}