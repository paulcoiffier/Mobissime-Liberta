/**
 * Created by Paul on 26/01/2015.
 */

var editor;

var install_url = $("#install_url").val();

function refreshFileSystem() {

    var id = $("#id").val();

    $.ajax({
        type: 'POST',
        url: install_url + "/web/front.php/modules/load_filesystem",
        data: "id=" + id,
        dataType: "html",
        success: function (response) {
            $('#fileSystemDiv').html(response);
        }
    });
}

function changeFolder(dir) {

    var install_path = $("#install_path").val();
    var module_name = $("#module_name").val();

    var dirTmp = dir.replace("/", "");
    var dirHtml = $("#" + dirTmp).html();


    if (dirHtml.length > 0) {
        /** Clear current items for closing effect */
        $("#" + dir).html('');
    } else {
        /** Get files in directory */
        $.ajax({
            url: install_url + "/web/front.php/modules/get_files_for_directory",
            type: 'POST',
            data: 'dir=' + dir + "&install_path=" + install_path + "&module_name=" + module_name,
            dataType: 'json',
            success: function (data) {

                $.each(data, function (index, value) {
                    console.log(value);
                    $("#" + dir).append('<li><a href="javascript:changeFile(\'' + value + '\',\'' + dir + '\');">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-code-o"></i>' + value + '</a>');
                });

            },
            error: function (data) {
                alert("Error iterating files : " + data);
                console.log(data);
            }
        });
    }
}

function changeFile(fileName, dir) {

    var install_path = $("#install_path").val();
    var module_name = $("#module_name").val();

    if (dir.length > 0) {
        fileName = dir + "/" + fileName;
    }

    /** Get file content */
    console.log("Load file : " + fileName);

    var mode;

    if (fileName.split('.').pop() == "css") {
        mode = "text/css";
    } else if (fileName.split('.').pop() == "pl") {
        mode = "text/perl";
    } else if (fileName.split('.').pop() == "py") {
        mode = "text/python";
    } else if (fileName.split('.').pop() == "js") {
        mode = "text/javascript";
    } else if (fileName.split('.').pop() == "sql") {
        mode = "text/sql";
    } else if (fileName.split('.').pop() == "sass") {
        mode = "text/sass";
    } else if (fileName.split('.').pop() == "php") {
        mode = "text/x-php";
    } else {
        mode = "text/x-php";
    }

    /** Show file in codeEditor */
    $.ajax({
        url: install_url + "/web/front.php/modules/get_file_content",
        type: 'POST',
        data: 'dir=' + dir + "&install_path=" + install_path + "&module_name=" + module_name + "&fileName=" + fileName,
        dataType: 'json',
        success: function (data) {
            $("#divCodeEditor").html("");
            $("#divCodeEditor").append('<textarea id="code1" name="code1" ></textarea>');

            editor = CodeMirror.fromTextArea(document.getElementById("code1"), {
                lineNumbers: true,
                matchBrackets: true,
                lineWrapping: false,
                tabMode: "indent",
                styleActiveLine: true,
                theme: "monokai",
                mode: "text/x-php"
            });

            //var codeToShow = $.htmlClean(data.fileContent, {format: true, allowComments: true});

            editor.setValue(data.fileContent);

            /** Important !!! Refresh editor content to resize it */
            setTimeout(function () {
                indentAll(editor);
                editor.refresh();
            }, 1000);

            $("#fileNameLabel").html("<input type='button' id='test' name='test' onclick='javascript:saveFile(\"" + fileName + "\")' class='btn btn-primary' value='Save'>&nbsp;" + fileName);

        },
        error: function (data) {
            alert("Error iterating files : " + data);
        }
    });
}

function indentAll(cm) {
    var last = cm.lineCount();
    cm.operation(function () {
        for (var i = 0; i < last; ++i) cm.indentLine(i);
    });
}

function saveFile(fileName) {

    var new_content = editor.getValue();
    var install_path = $("#install_path").val();
    var module_name = $("#module_name").val();

    /** Save new file content */
    $.ajax({
        url: install_url + "/web/front.php/modules/save_file",
        type: 'POST',
        data: {
            "fileName": fileName,
            "new_content": new_content,
            "module_name": module_name,
            "install_path": install_path
        },
        dataType: 'json',
        cache: false,
        success: function (data) {
            if (data.error == "no") {
                toastr.options = {
                    "closeButton": true,
                    "timeOut": "1000"
                };
                toastr['success']("File updated", 'MyCRM');

            } else {
                toastr.options = {
                    "closeButton": true,
                    "timeOut": "1000"
                };
                toastr['error']("Error while updating file", 'MyCRM');
            }
        },
        error: function (data) {
            toastr.options = {
                "closeButton": true,
                "timeOut": "1000"
            };
            toastr['error']("Error while updating file : " + data, 'MyCRM');
        }
    });
}

$("#createFileForm").submit(function (event) {

    event.preventDefault();

    if (!this.checkValidity()) {
        return false;
    } else {
        var file_name = $("#file_name").val();
        var module_name = $("#module_name").val();
        var install_path = $("#install_path").val();

        $.ajax({
            url: install_url + "/web/front.php/modules/create_file",
            type: 'POST',
            data: {
                "file_name": file_name,
                "module_name": module_name,
                "install_path": install_path
            },
            dataType: 'json',
            cache: false,
            success: function (data) {
                if (data.error == "no") {
                    $('#newFileModal').modal('hide');

                    refreshFileSystem();

                } else if (data.error == "exist") {
                    toastr.options = {
                        "closeButton": true,
                        "timeOut": "1000"
                    };
                    toastr['error']("A file with this name already exist", 'MyCRM');
                }

                else {
                    toastr.options = {
                        "closeButton": true,
                        "timeOut": "1000"
                    };
                    toastr['error']("Error while creating file", 'MyCRM');
                }
            },
            error: function (data) {
                toastr.options = {
                    "closeButton": true,
                    "timeOut": "1000"
                };
                toastr['error']("Error while creating file : " + data, 'MyCRM');
            }
        });
    }
});

$("#createDirForm").submit(function (event) {

    event.preventDefault();

    if (!this.checkValidity()) {
        return false;
    } else {
        var dir_name = $("#dir_name").val();
        var module_name = $("#module_name").val();
        var install_path = $("#install_path").val();

        $.ajax({
            url: install_url + "/web/front.php/modules/create_directory",
            type: 'POST',
            data: {
                "dir_name": dir_name,
                "module_name": module_name,
                "install_path": install_path
            },
            dataType: 'json',
            cache: false,
            success: function (data) {
                if (data.error == "no") {
                    $('#newDirModal').modal('hide');

                    refreshFileSystem();

                } else if (data.error == "exist") {
                    toastr.options = {
                        "closeButton": true,
                        "timeOut": "1000"
                    };
                    toastr['error']("A directory with this name already exist", 'MyCRM');
                }

                else {
                    toastr.options = {
                        "closeButton": true,
                        "timeOut": "1000"
                    };
                    toastr['error']("Error while creating directory", 'MyCRM');
                }
            },
            error: function (data) {
                toastr.options = {
                    "closeButton": true,
                    "timeOut": "1000"
                };
                toastr['error']("Error while creating directory : " + data, 'MyCRM');
            }
        });
    }
});

refreshFileSystem();