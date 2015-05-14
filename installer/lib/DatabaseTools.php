<?php
/**
 * Created by IntelliJ IDEA.
 * User: Paul
 * Date: 14/05/2015
 * Time: 22:47
 */

require_once '../../bootstrap.php';

class DatabaseTools {

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

            $stmt = $dbh->prepare("DROP DATABASE mycrm;");
            $stmt->execute();

            $stmt = $dbh->prepare("CREATE DATABASE mycrm;");
            $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        /** Generate entities */
        exec('cd ../.. && vendor\\bin\\doctrine orm:schema-tool:create');

        /** Generate proxies entity classes */
        exec('cd ../.. && vendor\\bin\\doctrine orm:generate-proxies');

        try {
            $stmt = $dbh->prepare("INSERT INTO mycrm.menu(menu_name,menu_description,menu_order,menu_font_awesome_icon) values (:menu_name,:menu_description,:menu_order,:menu_font_awesome_icon)");

            $menu_name = "Administration";
            $menu_description = "MyCRM administration menu";
            $menu_order = 5;
            $menu_font_awesome_icon = "fa-edit";

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
}