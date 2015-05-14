<!DOCTYPE html>
<html>

<?php
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
} else {
    $lang = "english";
}
/** Load language file */
$lang_strings = parse_ini_file("i18n/$lang.ini");


?>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mobissime Liberta | Installer</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="../css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body>

<div id="wrapper">
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Mobissime Liberta installation</h5>
                    </div>
                    <div class="ibox-content">
                        <h2>
                            <?php echo $lang_strings['title_installation_steps']; ?>
                        </h2>

                        <p>
                            ...
                        </p>

                        <form id="form" action="#" class="wizard-big-big">

                            <!-- Step language -->
                            <h1><?php echo $lang_strings['title_language']; ?></h1>
                            <fieldset>
                                <?php include 'steps/stepLanguage.php'; ?>
                            </fieldset>

                            <!-- Step database -->
                            <h1><?php echo $lang_strings['title_database']; ?></h1>
                            <fieldset>
                                <?php include 'steps/stepDatabase.php'; ?>
                            </fieldset>

                            <!-- Step php.ini -->
                            <h1><?php echo $lang_strings['title_phpconfig']; ?></h1>
                            <fieldset>
                                <?php include 'steps/stepPhpIni.php'; ?>
                            </fieldset>

                            <!-- Step paths -->
                            <h1><?php echo $lang_strings['title_paths']; ?></h1>
                            <fieldset>
                                <?php include 'steps/stepPaths.php'; ?>
                            </fieldset>

                            <!-- Step admin user -->
                            <h1><?php echo $lang_strings['title_admin_user']; ?></h1>
                            <fieldset>
                                <?php include 'steps/stepAdminUser.php'; ?>
                            </fieldset>

                            <!-- Final step -->
                            <h1><?php echo $lang_strings['title_recap']; ?></h1>
                            <fieldset>
                                <?php include 'steps/stepRecap.php'; ?>
                            </fieldset>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="footer">
        <div class="pull-right">
            MyCRM
        </div>
        <div>
            <strong>Copyright</strong> Mobissime | Paul Coiffier &copy; 2014-2015
        </div>
    </div>

</div>
</div>


<!-- Mainly scripts -->
<script src="../js/jquery-2.1.1.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Steps -->
<script src="../js/plugins/staps/jquery.steps.min.js"></script>

<!-- Jquery Validate -->
<script src="../js/plugins/validate/jquery.validate.min.js"></script>

<!-- MyCRM Installation javascript file -->
<script src="js/install.js"></script>

</body>

</html>
