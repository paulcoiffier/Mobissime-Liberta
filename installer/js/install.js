var path_url = "";
var path_system = "";

function changeLang() {
    var lang = $('#language').val();
    window.location.href = "index.php?lang=" + lang;
}

$("#form").submit(function (event) {

    event.preventDefault();

    if (!this.checkValidity()) {
        return false;
    } else {

        var lang = $('#language').val();

        var database_server = $("#database_server").val();
        var database_user = $("#database_user").val();
        var database_password = $("#database_password").val();
        var database_database = $("#database_database").val();
        var database_sgbd = $("#database_sgbd").val();

        var admin_user = $('#admin_user').val();
        var admin_password = $('#admin_password').val();

        var usr_first_name = $('#usr_first_name').val();
        var usr_last_name = $('#usr_last_name').val();
        var usr_email = $('#usr_email').val();


        $.ajax({
            type: 'POST',
            url: "ajax/install_files.php",
            data: "usr_language=" + lang + "&database_server=" + database_server + "&database_user=" + database_user + "&database_password=" + database_password + "&database_database=" + database_database
            + "&admin_user=" + admin_user + "&admin_password=" + admin_password + "&path_url=" + path_url + "&path_system=" + path_system + "&usr_first_name=" + usr_first_name + "&usr_last_name=" + usr_last_name + "&usr_email=" + usr_email,
            dataType: "html",
            success: function (response) {

                if (response == "ok") {
                    $.ajax({
                        type: 'POST',
                        url: "ajax/install_database.php",
                        data: "usr_language=" + lang + "&database_server=" + database_server + "&database_user=" + database_user + "&database_password=" + database_password + "&database_database=" + database_database
                        + "&admin_user=" + admin_user + "&admin_password=" + admin_password + "&path_url=" + path_url + "&path_system=" + path_system + "&usr_first_name=" + usr_first_name + "&usr_last_name=" + usr_last_name + "&usr_email=" + usr_email,
                        dataType: "html",
                        success: function (response) {
                            if (response == "ok") {
                                window.location.href = path_url + "/web/front.php/app";
                            } else {
                                $("#databaseError").html("Error : " + response);
                            }
                        }
                    });
                } else {
                    $("#databaseError").html("Error : " + response);
                }
            }
        });
    }
});
function showRecap() {

    var lang = $('#language').val();

    var database_server = $("#database_server").val();
    var database_user = $("#database_user").val();
    var database_password = $("#database_password").val();
    var database_database = $("#database_database").val();
    var database_sgbd = $("#database_sgbd").val();

    var admin_user = $('#admin_user').val();
    var admin_password = $('#admin_password').val();

    $('#recap_lang').html(lang);

    $('#recap_database_sgbd').html(database_sgbd);
    $('#recap_database_server').html(database_server);
    $('#recap_database_user').html(database_user);
    $('#recap_database_password').html(database_password);
    $('#recap_database_database').html(database_database);

    $('#recap_admin_user').html(admin_user);
    $('#recap_admin_password').html("*************");

    $('#recap_path_url').text(path_url);
    $('#recap_path_system').text(path_system);
}

$(document).ready(function () {

    var database_validation = false;
    var pdo_validation = false;
    var errorDir = false;

    $("#wizard").steps();
    $("#form").steps({
        bodyTag: "fieldset",
        onStepChanging: function (event, currentIndex, newIndex) {
            // Always allow going backward even if the current step contains invalid fields!
            if (currentIndex > newIndex) {
                return true;
            }

            var form = $(this);

            // Clean up if user went backward before
            if (currentIndex < newIndex) {
                // To remove error styles
                $(".body:eq(" + newIndex + ") label.error", form).remove();
                $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
            }

            // Disable validation on fields that are disabled or hidden.
            form.validate().settings.ignore = ":disabled,:hidden";

            if ((currentIndex == 4)) {
                showRecap();
            }

            if (currentIndex == 2) {

                path_url = $("#path_url").val();
                path_system = $("#path_system").val();

                //var path_system = $("#path_system").val();
                $('#directory_test_write_path').text(path_system);

                $.ajax({
                    type: 'POST',
                    url: "ajax/CheckDirectories.php",
                    data: "path_system=" + path_system,
                    dataType: "html",
                    success: function (response) {
                        if (response == "true") {
                            $("#directoryError").html("ok");
                            errorDir = true;
                        } else {
                            $("#directoryError").html('<font color="red">Error : Directory "' + path_system + 'src/App/Conf/" has to be writable</font>');
                            errorDir = false;
                        }
                    }
                });
            }

            if ((currentIndex == 1) && (form.validate()) && (database_validation == false)) {
                /** Check database connectivity */
                var database_server = $("#database_server").val();
                var database_user = $("#database_user").val();
                var database_password = $("#database_password").val();
                var database_database = $("#database_database").val();

                $.ajax({
                    type: 'POST',
                    url: "ajax/checkDatabase.php",
                    data: "database_server=" + database_server + "&database_user=" + database_user + "&database_password=" + database_password + "&database_database=" + database_database,
                    dataType: "html",
                    success: function (response) {
                        if (response == "ok") {
                            database_validation = true;
                            $("#form").steps("next");
                            database_validation = false;
                        } else {
                            $("#databaseError").html("Error : " + response);
                        }
                    }
                });
            } else if ((currentIndex == 3) && (pdo_validation == false) && (errorDir == false)) {
                /** Check php.ini validation */
                var pdo_error = $('#pdo_error').html();
                var directoryError = $('#directoryError').html();
                console.log("directoryError : " + directoryError);

                if ((pdo_error == "ok") && (directoryError == "ok")) {
                    errorDir = true;
                    pdo_validation = true;
                    $("#form").steps("next");
                    pdo_validation = false;
                    errorDir = false;
                }

            }
            else {
                return form.valid();
            }
            // Start validation; Prevent going forward if false

        },
        onStepChanged: function (event, currentIndex, priorIndex) {
            // Suppress (skip) "Warning" step if the user is old enough.
            /*if (currentIndex === 2 && Number($("#age").val()) >= 18) {
             $(this).steps("next");
             }*/

            // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
            /*if (currentIndex === 2 && priorIndex === 3) {
             $(this).steps("previous");
             }*/
        },
        onFinishing: function (event, currentIndex) {
            var form = $(this);

            // Disable validation on fields that are disabled.
            // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
            form.validate().settings.ignore = ":disabled";

            // Start validation; Prevent form submission if false
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            var form = $(this);

            // Submit form input
            form.submit();
        }
    }).validate({
        errorPlacement: function (error, element) {
            element.before(error);
        },
        rules: {
            confirm: {
                equalTo: "#password"
            }
        }
    });
});