<?php
/**
 * Created by IntelliJ IDEA.
 * User: Paul
 * Date: 14/05/2015
 * Time: 22:47
 */
set_time_limit(200);
require_once '../../bootstrap.php';

class DatabaseTools
{

    public function createDatabase($parameters, $entityManager)
    {

        $database_server = $parameters['var_database_server'];
        $database_database = $parameters['var_database_schema'];
        $database_user = $parameters['var_database_user'];
        $database_password = $parameters['var_database_password'];

        /** Drop database if exist */
        try {
            $dbh = new PDO('mysql:host=' . $database_server . ';dbname=' . $database_database, $database_user, $database_password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $dbh->prepare("DROP DATABASE ".$database_database.";");
            $stmt->execute();

            $stmt = $dbh->prepare("CREATE DATABASE ".$database_database.";");
            $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $sys = strtoupper(PHP_OS);

        if (substr($sys, 0, 3) == "WIN") {
            /** Generate entities */
            exec('cd ../.. && vendor\\bin\\doctrine orm:schema-tool:create');

            /** Generate proxies entity classes */
            exec('cd ../.. && vendor\\bin\\doctrine orm:generate-proxies');
        } // Win
        else {
            /** Generate entities */
            exec('cd ../.. && vendor/bin/doctrine orm:schema-tool:create');

            /** Generate proxies entity classes */
            exec('cd ../.. && vendor/bin/doctrine orm:generate-proxies');
        }

        try {
            $stmt = $dbh->prepare("INSERT INTO mycrm.menu(menu_name,menu_description,menu_order,menu_font_awesome_icon) values (:menu_name,:menu_description,:menu_order,:menu_font_awesome_icon)");

            $menu_name = "Administration";
            $menu_description = "MyCRM administration menu";
            $menu_order = 5;
            $menu_font_awesome_icon = "fa-edit";

            $stmt->bindParam(':menu_name', $menu_name);
            $stmt->bindParam(':menu_name', $menu_name);
            $stmt->bindParam(':menu_description', $menu_description);
            $stmt->bindParam(':menu_order', $menu_order);
            $stmt->bindParam(':menu_font_awesome_icon', $menu_font_awesome_icon);

            $stmt->execute();
            $dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createAdminUser($parameters)
    {
        $database_server = $parameters['var_database_server'];
        $database_database = $parameters['var_database_schema'];
        $database_user = $parameters['var_database_user'];
        $database_password = $parameters['var_database_password'];

        try {
            $dbh = new PDO('mysql:host=' . $database_server . ';dbname=' . $database_database, $database_user, $database_password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $dbh->prepare("INSERT INTO users (usr_first_name, usr_last_name, usr_password, usr_email, usr_language, usr_function) VALUES (:usr_first_name, :usr_last_name, :usr_password, :usr_email, :usr_language, :usr_function)");

            $administrator = "administrator";
            $password = md5($parameters['var_admin_password']);
            $stmt->bindParam(':usr_first_name', $parameters['var_usr_first_name']);
            $stmt->bindParam(':usr_last_name', $parameters['var_usr_last_name']);
            $stmt->bindParam(':usr_password', $password);
            $stmt->bindParam(':usr_email', $parameters['var_usr_email']);
            $stmt->bindParam(':usr_language', $parameters['var_usr_language']);
            $stmt->bindParam(':usr_function', $administrator);

            $stmt->execute();

            $dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}