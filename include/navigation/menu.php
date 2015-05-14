<?php

require 'include/engine/globalUtils.php';
// Get all menu and menu subitems entries
$globalUtils = new GlobalUtils($entityManager);
$menuEntries = $globalUtils->getAllMenuEntries();

if(isset($_GET['module'])){
    $moduleUrl = $_GET['module'];
} else {
    $moduleUrl ="";
}

?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">MyCRM</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                <?php

                if(!$moduleUrl){
                    echo '<li class="active"><a href="index.php">Home</a></li>';
                } else {
                    echo '<li><a href="index.php">Home</a></li>';
                }

                foreach ($menuEntries as $menu) {
                    $menu_name = $menu->getMenuName();
                    $menu_description = $menu->getMenuDescription();
                    $menu_static_link = $menu->getMenuStaticLink();


                    if (sizeof($menu->getMenuItems()) > 0) {
                        echo '<li class="dropdown">';
                        echo '<a href="' . $menu->getMenuStaticLink() . '" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $menu->getMenuName();
                        echo '<span class="caret"></span></a>';
                        echo '<ul class="dropdown-menu" role="menu">';
                        foreach ($menu->getMenuItems() as $menuSubitem) {
                            echo '<li><a href="' . $menuSubitem->getMenuStaticLink() . '">' . $menuSubitem->getMenuItemName() . '</a></li>';
                        }
                        echo '</ul>';
                        echo '</li>';
                    } else {

                        if($menu->getModule() != null){
                            if ($moduleUrl == $menu->getModule()->getModName()) {
                                echo '<li class="active"><a href="' . $menu->getMenuStaticLink() . '">' . $menu_name . '</a></li>';
                            } else {
                                echo '<li><a href="' . $menu->getMenuStaticLink() . '">' . $menu_name . '</a></li>';
                            }
                        } else {
                            echo '<li><a href="' . $menu->getMenuStaticLink() . '">' . $menu_name . '</a></li>';
                        }


                    }
                }

                ?>

            </ul>
            <ul class="nav navbar-nav navbar-right">

                <?php
                if (is_user_logged_in()) {
                    echo '<li><a href="../navbar/">Profil</a></li>';
                    echo '<li><a href="index.php?module=mycrm_login&action=logout">Log out</a></li>';
                } else {
                    echo '<li><a href="index.php?module=mycrm_login">Log in</a></li>';
                }
                ?>

            </ul>
        </div>
    </div>
</nav>