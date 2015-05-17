/**
 * Created by Paul on 02/03/2015.
 */

var entities = [];

function updateQueryDiv() {

    /** Clear currents divs */
    $("#select_div").html("");
    $("#from_div").html("");

    var alpha_array = ["a", "b", "c", "d", "e", "f", "g", "h"];
    var entities_array = [];
    var entities_array_index = 0;

    for (var i = 1; i <= 8; i++) {
        var tmp = $("#col" + i).html();

        if (tmp != "&nbsp;") {
            var entityLoopName = $("#col" + i).find("input").val();
            entities_array[entities_array_index] = entityLoopName;
            if (entityLoopName) {
                console.log("Add " + entityLoopName);
                entities_array_index++;
            }
        }
    }

    /** Get SELECT clauses **/
    var select_array = [];
    var select_array_index = 0;

    for (var i = 1; i <= 8; i++) {
        var tmp = $("#col" + i).html();
        if (tmp != "&nbsp;") {
            var entityLoopName = $("#col" + i).find("input").val();
            var letter = alpha_array[i - 1];

            $("#col" + i).find("input").each(function () {
                if ($(this).is(":checked")) {
                    console.log("Add : " + $(this).val() + " - " + $(this).is(":checked"));
                    select_array[select_array_index] = letter + "." + $(this).val();
                    select_array_index++;
                }
            });
        }
    }

    /** Write SELECT clause **/
    for (key in select_array) {
        var current = $("#select_div").html();
        $("#select_div").html(current + select_array[key] + ", <br />");
    }

    /** Write FROM clause **/
    var cpt = 0;
    for (key in entities_array) {
        var current = $("#from_div").html();
        $("#from_div").html(current + entities_array[key] + " " + alpha_array[cpt] + "<br />");
        cpt++;
    }

}

function addToGrid(id_var, status) {

    var entity = id_var.replace("chk_", "");
    var install_url = $('#install_url').val();

    if (status == true) {
        $.ajax({
            type: 'POST',
            url: install_url + "/web/front.php/querybuilder/entity_table",
            data: {entity: entity},
            dataType: "html",
            success: function (response) {

                var freeslot = 0;
                for (var i = 1; i <= 8; i++) {
                    var tmp = $("#col" + i).html();
                    if (tmp == "&nbsp;") {
                        $("#col" + i).html(response);
                        entities.push(entity)
                        /*$("#col" + i).find(".rowTable").toggleClass('test');
                         $("#col" + i).find(".rowTable").removeClass("rowTable")*/
                        freeslot = 1;
                        break;
                    }
                }

                if (freeslot == 0) {
                    showLongToaster("error", "Max number of entities exceed");
                } else {
                    showShortToaster("success", "Entity added");
                }
            }
        });
    } else {
        for (var i = 1; i <= 8; i++) {
            var tmp = $("#col" + i).html();
            if (tmp != "&nbsp;") {
                var entityLoopName = $("#col" + i).find("input").val();
                if (entityLoopName == entity) {
                    $("#col" + i).html("");
                }
            }
        }
    }

}