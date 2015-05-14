<h2><?php echo $lang_strings['title_phpconfig']; ?></h2>
<?php
$error = array();
?>
<div class="row">
    <div class="col-lg-2">

        <div class="form-group">
            <label>PDO extension : </label>&nbsp;<span id="pdo_error" name="pdo_error">
            <?php
            if (!defined('PDO::ATTR_DRIVER_NAME')) {
                echo 'unavailable';
                $error['pdo'] = "yes";
            } else {
                echo 'ok';
                $error['pdo'] = "no";
            } ?>
                </span>
        </div>
    </div>
</div>

