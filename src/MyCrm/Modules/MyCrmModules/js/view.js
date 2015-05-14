/**
 * Created by Paul on 24/01/2015.
 */


$('#closeDeleteModal').click(function () {

    var module_id = $("#module_id").val();
    var install_url = $("#install_url").val();

    $.ajax({
        url: 'modules/mycrm_modules/ajax/deleteModule.php',
        type: 'POST',
        data: 'id=' + module_id,
        dataType: 'json',
        success: function (data) {
            if (data.error == "no") {
                //document.location.replace('index.php?module=mycrm_modules&action=view_module&id=' + module_id);
                $('#deleteModal').modal('hide');
                window.location.href = 'index.php?module=mycrm_modules';
            } else {
                toastr.options = {
                    "closeButton": true,
                    "showDuration": 3
                };
                toastr['error']('MyCRM', label_error_create_module);
            }
        },
        error: function (data) {
            toastr.options = {
                "closeButton": true,
                "showDuration": 3
            };
            toastr['error']('MyCRM', label_error_create_module + " : " + data);
        }
    });

});

function register_module(module_id, label_yes, label_module_installed, label_error_create_module) {

    var install_url = $("#install_url").val();

    $.ajax({
        url: install_url + 'web/front.php/modules/register_module',
        type: 'POST',
        data: 'id=' + module_id,
        dataType: 'json',
        success: function (data) {
            if (data.error == "no") {
                showLongToaster("success", label_module_installed)
                $("#mod_is_installed").html(label_yes);
            } else {
                showLongToaster("error", label_error_create_module)
            }
        },
        error: function (data) {
            showLongToaster("error", label_error_create_module + " : " + data)
        }
    });

}