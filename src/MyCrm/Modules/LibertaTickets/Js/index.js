/**
 * Created by Paul on 24/01/2015.
 */
var install_url = $("#install_url").val();
var language = $("#language").val();

$('#tableCases').DataTable({
    "aLengthMenu": [[15, 25, 50, 100], [15, 25, 50, 100]],
    "iDisplayLength": 15,
    "language": {
        "url": install_url + "i18n/datatables/" + language + ".json"
    },
    responsive: true,
    "dom": 'T<"clear">lfrtip',
    "tableTools": {
        "sSwfPath": install_url + "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
    }
});

$('#tableCasesClosed').DataTable({
    "aLengthMenu": [[15, 25, 50, 100], [15, 25, 50, 100]],
    "iDisplayLength": 15,
    "language": {
        "url": install_url + "i18n/datatables/" + language + ".json"
    },
    responsive: true,
    "dom": 'T<"clear">lfrtip',
    "tableTools": {
        "sSwfPath": install_url + "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
    }
});
