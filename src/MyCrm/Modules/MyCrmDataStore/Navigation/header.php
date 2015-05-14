<?php
$arrayModulesWords = $app->getArrayModulesWords();
$arrayWords = $app->getArrayWords();
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?php echo $arrayModulesWords['mycrm_modules']['title']; ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.php"><?php echo $arrayWords['home']; ?></a>
            </li>
            <li class="active">
                <a href="index.php?module=mycrm_modules"><strong><?php echo $arrayModulesWords['mycrm_modules']['title']; ?></strong></a>
            </li>
        </ol>
    </div>
</div>