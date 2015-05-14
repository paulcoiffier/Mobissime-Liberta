/**
 * Created by Paul on 17/01/2015.
 */

var install_url = $("#install_url").val();

$(document).ready(function () {

    var language = $("#language").val();

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

});