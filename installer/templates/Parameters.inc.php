<?php
/**
 * MyCRM
 * Created by Paul Coiffier.
 * Date: 15/01/2015
 * Time: 16:05
 * Configuration file of MyCRM
 */

namespace App\Conf;

    /**
     * General Settings
     */
// Web root / installed path
define("install_path", "var_install_path");

define("install_url", "var_install_url");

// Installed dir
define("install_sys_dir", "var_install_sys_dir");

/*
 * Database Settings
 */
// Type of database (MySQL, Oracle, etc)
define("database_type", "pdo_mysql");

// Database Server
define("database_server", "var_database_server");

// Database Port
define("database_port", "var_database_port");

// Database User
define("database_user", "var_database_user");

// Database Password
define("database_password", "var_database_password");

// Database name
define("database_schema", "var_database_schema");

?>