/**
 * Created by Paul on 24/01/2015.
 */

var install_url = $("#install_url").val();

$('#insertModule').validator();

$("#insertModule").submit(function (event) {

    event.preventDefault();

    if (!this.checkValidity()) {
        return false;
    } else {

        var mod_name = $("#mod_name").val();
        var mod_description = $("#mod_description").val();
        var mod_author = $("#mod_author").val();
        var mod_route = $("#mod_route").val();
        var mod_icon = $("#iconHidden").val();

        if ($('#menu_admin_integration').is(':checked')) {
            var menu_admin_integration = true;
        } else {
            var menu_admin_integration = false;
        }

        if ($('#menu_site_integration').is(':checked')) {
            var menu_site_integration = true;
        } else {
            var menu_site_integration = false;
        }

        if ($('#module_require_login').is(':checked')) {
            var module_require_login = true;
        } else {
            var module_require_login = false;
        }

        var DATA = 'mod_name=' + mod_name;
        $.ajax({
            type: "POST",
            url: install_url + "/web/front.php/modules/testIfModuleExistModule",
            data: DATA,
            cache: false,
            success: function (data) {

                var obj = jQuery.parseJSON( data );
                if (obj.error == "no") {
                    var DATA = 'mod_name=' + mod_name + '&mod_description=' + mod_description + '&mod_author=' + mod_author +
                        '&mod_route=' + mod_route + '&mod_icon=' + mod_icon + '&menu_admin_integration=' + menu_admin_integration
                        + '&menu_site_integration=' + menu_site_integration + '&module_require_login=' + module_require_login;
                    $.ajax({
                        type: "POST",
                        url: install_url + "/web/front.php/modules/insert",
                        data: DATA,
                        cache: false,
                        success: function (data) {
                            showLongToaster("success", "Module inserted");
                            $("#mod_name").val("");
                            $("#mod_description").val("");
                            $("#mod_author").val("");
                            $('#menu_admin_integration').attr('checked', false);
                            $('#menu_site_integration').attr('checked', false);
                            $('#module_require_login').attr('checked', false);
                            $("#mod_route").val("");
                            $("#iconHidden").val("");
                        }
                    });
                } else {
                    $("#myModal6").modal('show');
                }
            }
        });

    }
});

$("#wizard").steps();
$("#form").steps({
    bodyTag: "fieldset",
    onStepChanging: function (event, currentIndex, newIndex) {
        // Always allow going backward even if the current step contains invalid fields!
        if (currentIndex > newIndex) {
            return true;
        }

        // Forbid suppressing "Warning" step if the user is to young
        if (newIndex === 3 && Number($("#age").val()) < 18) {
            return false;
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

        // Start validation; Prevent going forward if false
        return form.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex) {
        // Suppress (skip) "Warning" step if the user is old enough.
        if (currentIndex === 2 && Number($("#age").val()) >= 18) {
            $(this).steps("next");
        }

        // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
        if (currentIndex === 2 && priorIndex === 3) {
            $(this).steps("previous");
        }
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

