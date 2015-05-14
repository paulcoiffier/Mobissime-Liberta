/**
 * Created by Paul on 24/01/2015.
 */

var install_url = $("#install_url").val();

$("#closeDeleteModal").click(function () {

    var id = $("#id").val();

    $.ajax({
        url: install_url + '/web/front.php/tickets/delete_case_ajax',
        type: 'POST',
        data: 'id=' + id,
        dataType: 'json',
        success: function (data) {
            if (data.error == "no") {
                window.location.href = install_url + "web/front.php/tickets";
            } else {
                alert("Error during deleting ticket entry");
            }
        },
        error: function (data) {
            alert("Error during deleting ticket entry : " + data);
        }
    });

    $('#deleteModal').modal('hide');

});