<h2><?php echo $lang_strings['title_phpconfig']; ?></h2>
<br />
<?php
$error = array();

?>
<div class="row">
    <div class="col-lg-12">

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

        <div class="form-group">
            <label>Directories rights : </label>&nbsp;<span id="directoryError" name="directoryError">
            <?php

            $filename = 'test.txt';
            if (is_writable($filename)) {
                echo 'Le fichier est accessible en écriture.';
            } else {
                echo 'Le fichier n\'est pas accessible en écriture !';
            }

            ?>
                </span>
        </div>

    </div>
</div>


<input type="hidden" name="directory_test_write_path" id="directory_test_write_path" value="">