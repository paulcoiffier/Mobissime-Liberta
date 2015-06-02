/**
 * Created by Paul on 02/03/2015.
 */

var install_url = $("#install_url").val();

function saveQuery(id) {

    var name = $("#" + id + "_name").val();
    var description = $("#" + id + "_description").val();
    var value = $("#" + id + "_value").val();
    var moduleToView = $("#moduleToView").val();

    /** Ajax update */
    $.ajax({
        type: 'POST',
        url: install_url + "/web/front.php/querybuilder/update_query",
        data: {name: name, id: id, description: description, valeur: value, module_name: moduleToView},
        dataType: "html",
        success: function (response) {
            showLongToaster("success", "Saved successfully");
        }
    });
}

function setQueryToDelete(id){
    $("#queryidToDelete").val(id);
}


function deleteQuery() {

    var id = $("#queryidToDelete").val();

    var moduleToView = $("#moduleToView").val();

    $.ajax({
        type: 'POST',
        url: install_url + "/web/front.php/querybuilder/delete_query",
        data: {id: id, module_name: moduleToView},
        dataType: "html",
        success: function (response) {
            showLongToaster("success", "Query deleted");
            $("#modalDeleteQuery").modal('hide');
            $("#" + id).remove();
        }
    });
}


$("#queryForm").submit(function (event) {

    event.preventDefault();

    if (!this.checkValidity()) {
        return false;
    } else {

        var query_name = $("#query_name").val();
        var query_description = $("#query_description").val();
        var query_value = $("#query_value").val();
        var module_name = $("#moduleToView").val();

        /** Ajax request to delete menu entry */
        $.ajax({
            url: install_url + '/web/front.php/querybuilder/add_query',
            type: 'POST',
            data: 'query_name=' + query_name + "&query_description=" + query_description + "&query_value=" + query_value + "&module_name=" + module_name,
            dataType: 'html',
            success: function (response) {
                showLongToaster("success", "Query added");
                location.reload();
            }
        });
    }
});