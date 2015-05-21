<?php
/**
 * Created by IntelliJ IDEA.
 * User: Paul
 * Date: 21/05/2015
 * Time: 15:19
 */

class GlobalTools {

    public function getServerOs() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return "win";
        }
        else {
            return "unix";
        }
    }
}