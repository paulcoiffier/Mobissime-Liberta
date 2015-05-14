<?php

require 'include/engine/globalUtils.php';
// Get all menu and menu subitems entries
$globalUtils = new GlobalUtils($entityManager);
$menuEntries = $globalUtils->getAllMenuEntries();

if (isset($_GET['module'])) {
    $moduleUrl = $_GET['module'];
} else {
    $moduleUrl = "";
}

$userRepository = $entityManager->getRepository('User');
$user = $userRepository->findOneBy(
    array('usr_email' => $_SESSION['mycrmlogin'])
);

?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle"
                                 src="data/users_profiles/<?php echo $user->getId(); ?>_small.png"/>
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong
                                        class="font-bold"><?php echo $user->getUsrFirstName() . ' ' . $user->getUsrLastName(); ?></strong>
                             </span> <span class="text-muted text-xs block"><?php echo $user->getUsrFunction(); ?> <b
                                        class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="index.php?module=mycrm_user_profil">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="index.php?link=logout">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    MyCRM
                </div>
            </li>

            <?php

            /** Home menu **/
            if (!$moduleUrl) {
                echo '<li class="active"><a href="index.php"><i class="fa fa-home"></i> <span class="nav-label">Home</span> </a></li>';
            } else {
                echo '<li><a href="index.php"><i class="fa fa-home"></i> <span class="nav-label">Home</span> </a></li>';
            }

            ?>

            <!-- Mailbox menu -->
            <li>
                <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">Mailbox </span><span
                        class="label label-warning pull-right">16/24</span></a>
                <ul class="nav nav-second-level">
                    <li><a href="mailbox.html">Inbox</a></li>
                    <li><a href="mail_detail.html">Email view</a></li>
                    <li><a href="mail_compose.html">Compose email</a></li>
                    <li><a href="email_template.html">Email templates</a></li>
                </ul>
            </li>

            <?php

            $arrayWords = $app->getArrayModulesWords();

            foreach ($menuEntries as $menu) {
                $menu_name = $menu->getMenuName();
                $menu_description = $menu->getMenuDescription();
                $menu_static_link = $menu->getMenuStaticLink();

                if (sizeof($menu->getMenuItems()) > 0) {
                    /** Show a dropdown */

                    $ifMenu = true;
                    foreach ($menu->getMenuItems() as $menuSubitem) {
                        if ($menuSubitem->getModule() != null) {
                            if ($moduleUrl == $menuSubitem->getModule()->getModName()) {
                                echo '<li class="active">';
                                $ifMenu = false;
                            }
                        }
                    }

                    if ($ifMenu) {
                        echo '<li>';
                    }

                    if ($menu->getModule() != null) {
                        $menu_name = $arrayWords[$menu->getModule()->getModName()]['module_menu_title'];
                    } else {
                        $menu_name = $menu->getMenuName();
                    }

                    echo '<a href="' . $menu->getMenuStaticLink() . '"><i class="fa ' . $menu->getMenuFontAwesomeIcon() . '"></i><span class="nav-label">' . $menu_name . ' </span></a>';
                    echo '<ul class="nav nav-second-level">';

                    foreach ($menu->getMenuItems() as $menuSubitem) {
                        if ($menuSubitem->getModule() != null) {
                            if ($moduleUrl == $menuSubitem->getModule()->getModName()) {
                                echo '<li class="active"><a href="' . $menuSubitem->getMenuStaticLink() . '"><i class="fa fa-' . $menuSubitem->getMenuFontAwesomeIcon() . '"></i>' . $menuSubitem->getMenuItemName() . '</a></li>';
                            } else {
                                echo '<li><a href="' . $menuSubitem->getMenuStaticLink() . '"><i class="fa fa-' . $menuSubitem->getMenuFontAwesomeIcon() . '"></i>' . $menuSubitem->getMenuItemName() . '</a></li>';
                            }
                        } else {
                        echo '<li><a href="' . $menuSubitem->getMenuStaticLink() . '"><i class="fa fa-' . $menuSubitem->getMenuFontAwesomeIcon() . '"></i>' . $menuSubitem->getMenuItemName() . '</a></li>';
                        }
                    }

                    echo '</ul>';
                    echo '</li>';
                } else {
                    /** Show simple menu */
                    //getModule
                    if ($menu->getModule() != null) {
                        $menu_name = $arrayWords[$menu->getModule()->getModName()]['module_menu_title'];
                    } else {
                        $menu_name = $menu->getMenuName();
                    }

                    if ($menu->getModule() != null) {
                        if ($moduleUrl == $menu->getModule()->getModName()) {
                            echo '<li class="active"><a href="' . $menu->getMenuStaticLink() . '"><i class="fa ' . $menu->getMenuFontAwesomeIcon() . '"></i> <span class="nav-label">' . $menu_name . '</span> </a></li>';
                        } else {
                            echo '<li><a href="' . $menu->getMenuStaticLink() . '"><i class="fa ' . $menu->getMenuFontAwesomeIcon() . '"></i> <span class="nav-label">' . $menu_name . '</span> </a></li>';
                        }
                    } else {
                        echo '<li><a href="' . $menu->getMenuStaticLink() . '"><i class="fa ' . $menu->getMenuFontAwesomeIcon() . '"></i> <span class="nav-label">' . $menu_name . '</span> </a></li>';
                    }

                }

            }

            ?>

        </ul>
    </div>
</nav>