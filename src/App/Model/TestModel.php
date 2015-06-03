<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 17:33
 */

/**
 * No model are implemented. This call is not used and never call in the application
 */
namespace App\Model;

class TestModel
{
    public function TestModel($year = null)
    {
        if (null === $year) {
            $year = date('Y');
        }

        return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
    }
}