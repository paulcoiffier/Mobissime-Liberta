/**
 * Created by Paul on 03/02/2015.
 */


var install_url = $("#install_url").val();
var mod_icon;

$('#mod_icon').on('change', function(e) {
    mod_icon = e.icon;
});

$("#updateModule").submit(function (event) {

    var mod_name = $("#mod_name").val();
    var mod_description = $("#mod_description").val();
    var mod_author = $("#mod_author").val();
    var mod_route = $("#mod_route").val();
    var iconHidden = $("#iconHidden").val();

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

    console.log("mod_icon : " + mod_icon);

    event.preventDefault();

    if (!this.checkValidity()) {
        return false;
    } else {
        var DATA = 'mod_name=' + mod_name + '&mod_description=' + mod_description + '&mod_author=' + mod_author +
            '&mod_route=' + mod_route + '&mod_icon=' + mod_icon + '&menu_admin_integration=' + menu_admin_integration
            + '&menu_site_integration=' + menu_site_integration + '&module_require_login=' + module_require_login;
        $.ajax({
            type: "POST",
            url: install_url + "/web/front.php/modules/update_module",
            data: DATA,
            cache: false,
            success: function (data) {

                showLongToaster("success", "Module updated");

            }
        });
    }
});