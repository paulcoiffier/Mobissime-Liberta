<h2><?php echo $lang_strings['title_paths']; ?></h2>

<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label><?php echo $lang_strings['path_url']; ?> *</label>
            <input id="path_url" name="path_url" type="text" value="http://37.187.120.63/Mobissime-Liberta/"
                   class="form-control required">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label><?php echo $lang_strings['path_system']; ?> *</label>
            <input id="path_system" name="path_system" type="text" value="/var/www/Mobissime-Liberta/"
                   class="form-control required">
        </div>
    </div>
</div>

<?php

function getSystemPath()
{
    $path = getcwd();
    $tokens = explode("\\", $path);
    $i = 0;
    $max = count($tokens);
    $result = "";

    foreach ($tokens as $token) {
        if ($i < $max - 1) {
            $result .= "$token\\";
            $i++;
        } else {
            break;
        }
    }

    return $result;
}

function getUrlPath()
{
    $pageURL = 'http';
    /*if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }*/
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }

    $pageURL = str_replace("installer/index.php?language=french", "", $pageURL);
    return $pageURL;
}

?>

<script>

    /*$(document).ready(function () {
        var path_system = $("#path_system").val();
        $('#directory_test_write_path').text(path_system);

        $("#path_system").change(function () {
            var path_system = $("#path_system").val();
            $('#directory_test_write_path').text(path_system);
        });
    });*/

</script>
