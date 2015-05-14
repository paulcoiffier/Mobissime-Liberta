/**
 * Created by Paul on 24/01/2015.
 */

var install_url = $("#install_url").val();

$('#formOpenCase').validator();

$('#case_account').change(function () {
    /**
     * Ajax request to get all contacts from selected account
     */
    var selectAccountId = $('#case_account').val();

    $.ajax({
        url: install_url + '/web/front.php/tickets/get_contacts_account_ajax',
        type: 'POST',
        data: 'id=' + selectAccountId,
        dataType: 'json',
        success: function (data) {

            $('#case_contact').empty();
            $.each(data, function (index, value) { // pour chaque noeud JSON
                // on ajoute l option dans la liste
                $('#case_contact').append('<option value="' + index + '">' + value.person_last_name + ' ' + value.person_first_name + '</option>');

            });
            //if (data.error == "no") {
            //} else {
            //    alert("Error while getting account's contacts");
            //  }
        },
        error: function (data) {
            alert("Error while getting account's contacts : " + data);
        }
    });
});

$("#insertCase").click(function () {

    var case_account = $('#case_account').val();
    var case_contact = $('#case_contact').val();
    var case_priority = $('#case_priority').val();
    var case_status = $('#case_status').val();
    var case_type = $('#case_type').val();
    var assignedTo = $('#assignedTo').val();
    var case_subject = $('#case_subject').val();
    var case_description = $('#case_description').val();

    $.ajax({
        url: install_url + '/web/front.php/tickets/insert_case_ajax',
        type: 'POST',
        data: 'case_account=' + case_account + "&case_contact=" + case_contact + "&case_priority=" + case_priority +
        "&case_status=" + case_status + "&case_type=" + case_type + "&assignedTo=" + assignedTo + "&case_subject=" + case_subject
        + "&case_description=" + case_description,
        dataType: 'json',
        success: function (data) {
            if (data.error == "no") {
                window.location.href = install_url + 'web/front.php/tickets';
            } else {
                alert("Error while open case");
            }
        },
        error: function (data) {
            alert("Error while open case : " + data);
        }
    });

});