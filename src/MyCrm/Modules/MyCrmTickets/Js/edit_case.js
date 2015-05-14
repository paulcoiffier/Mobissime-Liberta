/**
 * Created by Paul on 24/01/2015.
 */

var install_url = $("#install_url").val();

$("#updateCase").click(function () {

    var case_id = $('#case_id').val();
    var case_priority = $('#case_priority').val();
    var case_status = $('#case_status').val();
    var case_type = $('#case_type').val();
    var assignedTo = $('#assignedTo').val();
    var case_subject = $('#case_subject').val();
    var case_description = $('#case_description').val();
    var case_resolution = $('#case_resolution').val();

    $.ajax({
        url: install_url + '/web/front.php/tickets/update_case_ajax',
        type: 'POST',
        data: "id=" + case_id + "&case_priority=" + case_priority +
        "&case_status=" + case_status + "&case_type=" + case_type + "&assignedTo=" + assignedTo + "&case_subject=" + case_subject
        + "&case_description=" + case_description + "&case_resolution=" + case_resolution,
        dataType: 'json',
        success: function (data) {
            if (data.error == "no") {
                toastr.options = {
                    "closeButton": true,
                    "showDuration": 3
                };
                toastr['success']('MyCRM', "Case updated");

            } else {
                toastr.options = {
                    "closeButton": true,
                    "showDuration": 3
                };
                toastr['error']('MyCRM', "Error while updating case");
            }
        },
        error: function (data) {
            toastr.options = {
                "closeButton": true,
                "showDuration": 3
            };
            toastr['error']('MyCRM', "Error while updating case : " + data);
        }
    });

});