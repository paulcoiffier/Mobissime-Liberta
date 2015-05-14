/**
 * Created by Paul on 25/01/2015.
 */

var install_url = $("#install_url").val();

$('#updatePassword').validator();

$('#updatePassword').submit(function (event) {

    event.preventDefault();

    var actual_password = $('#actual_password').val();
    var new_password = $('#new_password').val();
    var repeat_new_password = $('#repeat_new_password').val();
    var user_id = $('#user_id').val();

    if (!this.checkValidity()) {
        return false;
    } else {

        if (new_password != repeat_new_password) {
            toastr.options = {
                "closeButton": true,
                "showDuration": 3
            }
            toastr['error']('New passwords does not match', "Error");

        } else {
            /** Check if actual password is good */
            $.ajax({
                url: install_url + '/web/front.php/profile/check_password_ajax',
                type: 'POST',
                data: "id=" + user_id + "&actual_password=" + actual_password,
                dataType: 'json',
                success: function (data) {
                    if (data.error == "no") {
                        // Update password
                        updatePassword(user_id, new_password);

                    } else {
                        toastr.options = {
                            "closeButton": true,
                            "showDuration": 3
                        };
                        toastr['error']("Actual password is bad", 'Error');
                    }
                },
                error: function (data) {
                    toastr.options = {
                        "closeButton": true,
                        "showDuration": 3
                    };
                    toastr['error']("Internal error : " + data, 'MyCRM');
                }
            });
        }
    }
});

function updatePassword(user_id, new_password) {
    $.ajax({
        url: install_url + '/web/front.php/profile/update_password_ajax',
        type: 'POST',
        data: "id=" + user_id + "&new_password=" + new_password,
        dataType: 'json',
        success: function (data) {
            if (data.error == "no") {
                toastr.options = {
                    "closeButton": true,
                    "showDuration": 3
                };
                toastr['success']("Password updated", 'MyCRM');

            } else {
                toastr.options = {
                    "closeButton": true,
                    "showDuration": 3
                };
                toastr['error']("Error while updating password", 'MyCRM');
            }
        },
        error: function (data) {
            toastr.options = {
                "closeButton": true,
                "showDuration": 3
            };
            toastr['error']("Error while updating password : " + data, 'MyCRM');
        }
    });
}