/**
 * Created by Paul on 17/01/2015.
 */

var install_url = $("#install_url").val();

$(document).ready(function () {

    $('#createUser').validator();
    $('#editUser').validator();
    $('#createGroup').validator();

    var language = $("#language").val();

    $("#closeDeleteModal").click(function () {
        var id = $("#id").val();
        /** Ajax request to delete menu entry */
        $.ajax({
            url: install_url + '/web/front.php/users/delete_user_ajax',
            type: 'POST',
            data: 'id=' + id,
            dataType: 'json',
            success: function (data) {
                if (data.error == "no") {
                    document.location.replace(install_url+'web/front.php/users');
                } else {
                    alert("Error during deleting user entry");
                }
            },
            error: function (data) {
                alert("Error during deleting user entry : " + data);
            }
        });
        $('#deleteModal').modal('hide');
    });

    $('#tableUsers').DataTable({
        "aLengthMenu": [[15, 25, 50, 100], [15, 25, 50, 100]],
        "iDisplayLength": 15,
        "language": {
            "url": install_url + "/i18n/datatables/" + language + ".json"
        },
        responsive: true,
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": install_url + "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
        }
    });

    $('#table').DataTable({
        "aLengthMenu": [[15, 25, 50, 100], [15, 25, 50, 100]],
        "iDisplayLength": 15,
        "language": {
            "url": install_url + "/i18n/datatables/" + language + ".json"
        },
        responsive: true,
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": install_url + "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
        }
    });

    $("#createGroupForm").submit(function (event) {

        event.preventDefault();

        if (!this.checkValidity()) {
            return false;
        } else {

            var grp_name = $("#grp_name").val();
            var grp_description = $("#grp_description").val();

            /** Ajax request to delete menu entry */
            $.ajax({
                url: install_url + '/web/front.php/users/insert_group_ajax',
                type: 'POST',
                data: 'grp_name=' + grp_name + "&grp_description=" + grp_description,
                dataType: 'json',
                success: function (data) {
                    if (data.error == "no") {
                        window.location.href = install_url + "/web/front.php/users";
                    } else {
                        alert("Error during adding group");
                    }
                },
                error: function (data) {
                    alert("Error during adding group : " + data);
                }
            });
        }
    });
});