/**
 * Created by Paul on 02/03/2015.
 */

var install_url = $("#install_url").val();

function saveQuery(id) {

    var name = $("#"+id + "_name").val();
    var description = $("#"+id + "_description").val();
    var value = $("#"+id + "_value").val();
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