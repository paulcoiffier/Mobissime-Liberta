/**
 * Created by Paul on 01/02/2015.
 */

$('#addEntityForm').validator();
$('#addFieldFormRelation').validator();

var install_url = $("#install_url").val();

function updateEntity() {

    console.log("updateEntity");
    var entity_name = $("#entityLabel").html();
    var table_name = $("#table_name").val();

    var database_updated_message = $("#database_updated_message").val();
    var options = {entity: entity_name, tableName: table_name};

    var fields = [];
    var i = 0;

    $('#tableModules tr').each(function () {
        $this = $(this);
        var td = $this.find("td").html();
        var field_name = $this.find("input").attr('value');

        /** To exclude hidden fields */
        if (field_name != undefined) {

            var _field_type = field_name + "_select";
            var field_type = $("#" + _field_type).val();

            var _field_size = field_name + "_size";
            var field_size = $("#" + _field_size).val();

            var _nullable = field_name + "_nullable";
            var field_nullable = $("#" + _nullable).prop('checked');

            var _field_target_entity = field_name + "_targetEntity";
            var field_target_entity = $("#" + _field_target_entity).val();


            if (field_nullable == true) {
                field_nullable = "true";
            } else {
                field_nullable = "false";
            }

            var f = {
                field_name: field_name,
                field_type: field_type,
                field_size: field_size,
                field_nullable: field_nullable,
                field_target_entity: field_target_entity
            };

            fields[i] = f;
            i++;
        }
    });

    $.ajax({
        type: 'POST',
        url: install_url + "/web/front.php/datastore/write_entity",
        data: {fields: fields, options: options},
        dataType: "html",
        success: function (response) {
            showLongToaster("success", database_updated_message);
        }
    });
}

function changeEntity(entity) {

    // Load database fields
    $.ajax({
        type: "POST",
        url: install_url + "/web/front.php/datastore/edit_entity",
        cache: false,
        data: "entity=" + entity,
        success: function (data) {
            var entityTitle = entity.replace(".php", "");
            $("#entityLabel").html(entityTitle);
            $("#entityDiv").html(data);

            // Load or create formulaire
            $.ajax({
                type: "POST",
                url: install_url + "/web/front.php/datastore/entity_formulaire",
                cache: false,
                data: "entity=" + entity,
                success: function (data) {
                    $("#divFormulaire").html(data);
                }
            });

            // Load or create queries
            $.ajax({
                type: "POST",
                url: install_url + "/web/front.php/datastore/entity_queries",
                cache: false,
                data: "entity=" + entity,
                success: function (data) {
                    $("#divQueries").html(data);
                }
            });

        }
    });


}

function loadEntities() {

    $.ajax({
        type: "POST",
        url: install_url + "/web/front.php/datastore/get_entities",
        cache: false,
        success: function (data) {
            $("#entitiesDiv").html(data);
        }
    });

}

$("#addEntityForm").submit(function (event) {

    event.preventDefault();
    var entity_name = $("#entity_name").val();
    var table_name = $("#table_name").val();

    var message = $("#entity_added_message").val();

    if (!this.checkValidity()) {
        return false;
    } else {
        $.ajax({
                type: "POST",
                url: install_url + "/web/front.php/datastore/create_entity",
                data: "entity_name=" + entity_name + "&table_name=" + table_name,
                cache: false,
                success: function (data) {
                    showLongToaster("success", message);
                    $("#modalAddEntity").modal('hide');
                    /** Reload file system */
                    changeEntity(entity_name);
                    loadEntities();
                }
            }
        );
    }
});

function removeEntity() {

    var entity_name = $("#entityLabel").html();
    var table_name = $("#table_name").val();

    var message = $("#entity_removed_message").val();

    $.ajax({
            type: "POST",
            url: install_url + "/web/front.php/datastore/remove_entity",
            data: "entity_name=" + entity_name + "&table_name=" + table_name,
            cache: false,
            success: function (data) {
                showLongToaster("success", message);
                $("#modalRemoveEntity").modal('hide');
                $("#entityDiv").html("");
                /** Reload file system */
                loadEntities();
            }
        }
    )
    ;
}


loadEntities();