/**
 * Created by Paul on 08/02/2015.
 */
var editor;
var install_url = $("#install_url").val();
var module_name = $("#module_name").val();

loadFile("Index.html");

function loadFile(fileToLoad) {

    $('#current_file_name').val(fileToLoad);

    $.ajax({
        type: 'POST',
        url: install_url + "/web/front.php/visualbuilder/load_editor_file",
        data: "fileToLoad=" + fileToLoad + "&module_name=" + module_name,
        dataType: "html",
        success: function (response) {

            var obj = jQuery.parseJSON(response);

            $('#demoDiv').html(obj.fileContent);
            // For move, if this line is not include it's impossible to move lines
            /*$(".demoDiv .column").sortable({opacity: .35, connectWith: ".column"});
             $(".demo .column").sortable({opacity: .35, connectWith: ".column"});*/

            $('#file_name').html(fileToLoad);
            $(".demo, .demo .column").sortable({connectWith: ".column", opacity: .35, handle: ".drag"});
        }
    });
}

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 5; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function removeXmlComponent(elem) {
    var a = elem.parentNode;

    if (a.className.indexOf("databased") > -1) {
        var name = a.getAttribute("name");
        var className = a.className;

        var form_name = $('#current_file_name').val();

        $.ajax({
            type: 'POST',
            url: install_url + "/web/front.php/visualbuilder/remove_component_ajax",
            data: {module_name: module_name, form_name: form_name, component_name: name},
            dataType: "html",
            success: function (response) {
                //console.log("Response : " + response);
            }
        });
    }
}

/** Show entity list if LOV is select for a field */
function changeItemType(field_name, field_type) {
    if (field_type == 'List of values') {
        document.getElementById(field_name + '_entity').style.visibility = "visible";
    }
}

function createFormAction(module_name) {

    var div_formulaire = document.getElementById('div_formulaire').style.display;
    var component_type;

    if (div_formulaire == "none") {
        component_type = "table";
    } else {
        component_type = "form";
    }

    if (component_type == "table") {

        var fields = [];
        var i = 0;

        var current_module_name = $('#module_name').val();
        var form_name = $('#current_file_name').val();
        //var future_name = Math.floor((Math.random() * 1000) + 1);
        var future_name = makeid();


        $('#select-to option').each(function () {
            var f = {field: this.text, fieldType: this.value, entity: $("#entity").val()};
            fields[i] = f;
            i++;
        });

        var componentJson = {name: future_name, type: "datatable"};

        var current_query_name = $('#current_query_name').val();

        $.ajax({
            type: 'POST',
            url: install_url + "/web/front.php/visualbuilder/generate_table_ajax",
            data: {
                fields: fields,
                entity: $("#entity").val(),
                module_name: current_module_name,
                form_name: form_name,
                component: componentJson,
                current_query_name: current_query_name
            },
            dataType: "html",
            success: function (response) {

                var text = "div[name=" + $("#entity").val() + "]";
                $(text).html(response);
                var newtmp = "div[name=newtmp]";

                /** Generate a new random name **/
                $(text).attr("name", future_name);
                $(newtmp).attr("name", $("#entity").val());

                $("#modalComponentType").modal('hide');
            }
        });
    }

    else if (component_type == "form") {
        var fields = [];
        var i = 0;

        var current_module_name = $('#module_name').val();
        var form_name = $('#current_file_name').val();
        //var future_name = Math.floor((Math.random() * 1000) + 1);
        var future_name = makeid();
        var current_query_name = $('#current_query_name').val();

        $('#popupComponentContent label').each(function () {

            if ($(this).attr('class') == 'control-label entity_field') {

                var field = $(this).attr('for');
                var entity = document.getElementById(field + ' ' + module_name).options[document.getElementById(field + ' ' + module_name).selectedIndex].value;
                var fieldType = document.getElementById(field + "_select").options[document.getElementById(field + "_select").selectedIndex].value;

                var f = {field: field, entity: entity, fieldType: fieldType};
                fields[i] = f;
                i++;
            }
        });

        var componentJson = {name: future_name, type: "form"};

        $.ajax({
            type: 'POST',
            url: install_url + "/web/front.php/visualbuilder/generate_form_ajax",
            data: {
                fields: fields,
                module_name: current_module_name,
                form_name: form_name,
                component: componentJson,
                current_query_name: current_query_name
            },
            dataType: "html",
            success: function (response) {

                var text = "div[name=" + $("#entity").val() + "]";
                var newtmp = "div[name=newtmp]";

                $(text).html(response);
                $(text).attr("name", future_name);
                $(newtmp).attr("name", $("#entity").val());

                $("#modalComponentType").modal('hide');
            }
        });
    }

}

$('#newpage').click(function () {
    $("#modalNewFile").modal('show');
});

$('#code_editor').click(function () {
    $("#modalNewFile").modal('show');
});

$('#devpreview').click(function () {
    $("#codepreview").parent().removeClass('active');
    $("#edit").parent().removeClass('active');
    $("#sourcepreview").parent().removeClass('active');
    $("#devpreview").parent().addClass('active');

    document.getElementById('divCodeEditor').style.display = "none";
    document.getElementById('demoDiv').style.display = "";
});

$('#edit').click(function () {
    $("#codepreview").parent().removeClass('active');
    $("#devpreview").parent().removeClass('active');
    $("#sourcepreview").parent().removeClass('active');
    $("#edit").parent().addClass('active');

    document.getElementById('divCodeEditor').style.display = "none";
    document.getElementById('demoDiv').style.display = "";
});

$('#sourcepreview').click(function () {
    $("#codepreview").parent().removeClass('active');
    $("#edit").parent().removeClass('active');
    $("#devpreview").parent().removeClass('active');
    $("#sourcepreview").parent().addClass('active');

    document.getElementById('divCodeEditor').style.display = "none";
    document.getElementById('demoDiv').style.display = "";
});

$('#codepreview').click(function () {

    $("#sourcepreview").parent().removeClass('active');
    $("#edit").parent().removeClass('active');
    $("#devpreview").parent().removeClass('active');
    $("#codepreview").parent().addClass('active');

    document.getElementById('demoDiv').style.display = "none";
    document.getElementById('divCodeEditor').style.display = "";
    showCodeToEditor();

    $("body").removeClass("devpreview sourcepreview");
    $("body").addClass("edit");
    $(this).addClass("active");

    $("#sideBarComponents").hide(500);
    $("#sideBarEditor").hide(500);

    setTimeout(function () {
        $("#divCodeEditor").parent().removeClass("col-lg-8");
        $("#divCodeEditor").parent().addClass("col-lg-12");
    }, 550);

});

function remove(id) {
    var element = document.getElementById(id);
    element.outerHTML = "";
    delete element;
}

function closeCreateFormAction() {
    var text = "div[name=" + $("#entity").val() + "]";
    $(text).remove();
    var test = $("#entity").val();
    $("#" + test).attr("name", $("#entity").val());
    $("#modalComponentType").modal('hide')
};

$('#save').click(function () {
    /** Page Name */
    saveFunction();
});

function saveFunction() {
    var fileName = $('#file_name').html();
    var module_name = $('#module_name').val();
    var content = $('#demoDiv').html();

    var e = "";

    $("#download-layout").children().html($(".demo").html());
    var t = $("#download-layout").children();
    t.find(".preview, .configuration, .drag, .remove").remove();
    t.find(".lyrow").addClass("removeClean");
    t.find(".box-element").addClass("removeClean");
    t.find(".lyrow .lyrow .lyrow .lyrow .lyrow .removeClean").each(function () {
        cleanHtml(this)
    });
    /** TODO / To fix later. These lines causes doublons in row generation (probably because widget draggable css class/structure is strong) */
    /*t.find(".lyrow .lyrow .lyrow .lyrow .removeClean").each(function () {
     cleanHtml(this)
     });*/
    /*t.find(".lyrow .lyrow .lyrow .removeClean").each(function () {
     cleanHtml(this)
     });
     t.find(".lyrow .lyrow .removeClean").each(function () {
     cleanHtml(this)
     });
     t.find(".lyrow .removeClean").each(function () {
     cleanHtml(this)
     });
     t.find(".removeClean").each(function () {
     cleanHtml(this)
     });
     t.find(".removeClean").remove();*/

    $("#download-layout .column").removeClass("ui-sortable");
    $("#download-layout .row-fluid").removeClass("clearfix").children().removeClass("column");
    if ($("#download-layout .container").length > 0) {
        changeStructure("row-fluid", "row")
    }

    formatSrc = $.htmlClean($("#download-layout").html(), {
        format: true,
        allowComments: true,
        allowedAttributes: [["id"], ["class"], ["data-toggle"], ["data-target"], ["data-parent"], ["role"], ["data-dismiss"], ["aria-labelledby"], ["aria-hidden"], ["data-slide-to"], ["data-slide"]]
    });

    $.ajax({
        type: 'POST',
        url: install_url + "/web/front.php/visualbuilder/update_form_file_ajax",
        data: "fileName=" + fileName + "&module_name=" + module_name + "&content=" + content,
        dataType: "html",
        success: function (response) {
            /** Save the movable file */

            $.ajax({
                type: 'POST',
                url: install_url + "/web/front.php/visualbuilder/save_clean_file_ajax",
                data: "fileName=" + fileName + "&module_name=" + module_name + "&content=" + formatSrc,
                dataType: "html",
                success: function (response) {

                    $('#file_name').html(fileName);

                    console.log(module_name);
                    /** XML Binding conversion process */
                    $.ajax({
                        type: 'POST',
                        url: install_url + "/web/front.php/visualbuilder/create_xml_bindings_ajax",
                        data: "form_name=" + fileName + "&module_name=" + module_name,
                        dataType: "html",
                        success: function (response) {
                            toastr.options = {
                                "closeButton": true,
                                "timeOut": "2000"
                            };
                            toastr['success']("File saved", 'MyCRM');
                        }
                    });

                }
            });
        }
    });
}

$('#createFileBtn').click(function () {

    var fileName = $('#filename').val();
    var module_name = $('#module_name').val();

    $.ajax({
        type: 'POST',
        url: install_url + "/web/front.php/visualbuilder/create_new_form_file_ajax",
        data: "fileName=" + fileName + "&module_name=" + module_name,
        dataType: "html",
        success: function (response) {
            $("#modalNewFile").modal('hide');
            toastr.options = {
                "closeButton": true,
                "timeOut": "2000"
            };
            toastr['success']("File created", 'MyCRM');
            $('#file_name').html(fileName);
        }
    });
});

$("#nav_tabs a").click(function (e) {
    //if(window.codeMirrorInstances != null) { // window.codeMirrorInstances must be initialized and tracked manually
    $.each(window.codeMirrorInstances, function (index, cm) {
        setTimeout(function () {
            editor.setValue($("#demoDiv").html());

            cm.refresh();
            indentAll(editor);
        }, 100);
    });
    //}

    return false;
});

function showCodeToEditor() {

    $("#divCodeEditor").html("");
    $("#divCodeEditor").append('<textarea id="code1" name="code1"></textarea>');

    editor = CodeMirror.fromTextArea(document.getElementById("code1"), {
        lineNumbers: true,
        mode: 'htmlmixed',
        matchBrackets: true,
        tabMode: "indent",
        styleActiveLine: true,
        theme: "monokai",
        mode: "text/x-php"
    });

    var codeToShow = $("#demoDiv").html();
    codeToShow = $.htmlClean(codeToShow, {format: true, allowComments: true});
    editor.setValue(codeToShow);

    /** Important !!! Refresh editor content to resize it */
    setTimeout(function () {
        indentAll(editor);
        editor.refresh();
    }, 100);

}

function indentAll(cm) {
    var last = cm.lineCount();
    cm.operation(function () {
        for (var i = 0; i < last; ++i) cm.indentLine(i);
    });
}