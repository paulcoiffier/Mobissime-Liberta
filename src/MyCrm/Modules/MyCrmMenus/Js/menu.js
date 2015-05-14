/**
 * Created by Paul on 18/01/2015.
 */

var install_url = $("#install_url").val();

$('#formMenu').validator();

function updateMenuItem(menuItemId, menu_item_name, menu_item_position, menu_descriptiop, menu_static_link, menu_font_awesome_icon) {

    $("#update_menu_item_name").val(menu_item_name);
    $("#update_menu_item_position").val(menu_item_position);
    $("#update_menu_descriptiop").val(menu_descriptiop);
    $("#update_menu_static_link").val(menu_static_link);
    $("#u_menu_font_awesome_icon").val(menu_font_awesome_icon);


    $("#update_menu_id").val(menuItemId);

    $('#updateSubitemModal').modal('show');
};

function deleteSubItem() {
    if (confirm('Are you sure to delete ?')) {

        var id = $("#update_menu_id").val();
        var idMenu = $("#id").val();

        $.ajax({
            url: install_url + "web/front.php/menus/delete_sub_item",
            type: 'POST',
            data: 'id=' + id,
            dataType: 'json',
            success: function (data) {
                if (data.error == "no") {
                    document.location.replace('index.php?module=mycrm_menu&action=edit_menu&id=' + idMenu);
                } else {
                    alert("Error during deleting menu item entry");
                }
            },
            error: function (data) {
                alert("Error during deleting menu item entry : " + data);
            }
        });
    }
};

$(document).ready(function () {

    $("#updateMenuItemModal").click(function () {

        var id = $("#update_menu_id").val();
        var idMenu = $("#id").val();

        var update_menu_item_name = $("#update_menu_item_name").val();
        var update_menu_item_position = $("#update_menu_item_position").val();
        var update_menu_descriptiop = $("#update_menu_descriptiop").val();
        var update_menu_static_link = $("#update_menu_static_link").val();
        var a_menu_font_awesome_icon = $("#u_menu_font_awesome_icon").val();

        /** Ajax request to delete menu entry */
        $.ajax({
            url: install_url + "web/front.php/menus/update_menu_item",
            type: 'POST',
            data: 'id=' + id + "&u_menu_font_awesome_icon=" + a_menu_font_awesome_icon + "&update_menu_item_position=" + update_menu_item_position + "&menu_item_name=" + update_menu_item_name + "&menu_static_link=" + update_menu_static_link + "&menu_descriptiop=" + update_menu_descriptiop,
            dataType: 'json',
            success: function (data) {
                if (data.error == "no") {
                    document.location.replace('index.php?module=mycrm_menu&action=edit_menu&id=' + idMenu);
                } else {
                    alert("Error during updating menu entry");
                }
            },
            error: function (data) {
                alert("Error during updating menu item entry : " + data);
            }
        });
        $('#basicModal').modal('hide');
    });


    $("#closeDeleteModal").click(function () {
        var id = $("#id").val();
        /** Ajax request to delete menu entry */
        $.ajax({
            url: install_url + "web/front.php/menus/delete_menu",
            type: 'POST',
            data: 'id=' + id,
            dataType: 'json',
            success: function (data) {
                if (data.error == "no") {
                    document.location.replace('index.php?module=mycrm_menu');
                } else {
                    alert("Error during deleting menu entry");
                }
            },
            error: function (data) {
                alert("Error during deleting menu entry : " + data);
            }
        });
        $('#basicModal').modal('hide');
    });

    $("#closeMenuItemModal").click(function () {
        var id = $("#id").val();
        var menu_item_name = $("#menu_item_name").val();
        var menu_static_link = $("#menu_static_link").val();
        var menu_descriptiop = $("#menu_descriptiop").val();
        var menu_position = $("#menu_position").val();
        var a_menu_font_awesome_icon = $("#a_menu_font_awesome_icon").val();

        /** Ajax request to delete menu entry */
        $.ajax({
            url: install_url + "web/front.php/menus/add_menu_item",
            type: 'POST',
            data: 'id=' + id + "&a_menu_font_awesome_icon=" + u_menu_font_awesome_icon + "&menu_position=" + menu_position + "&menu_item_name=" + menu_item_name + "&menu_static_link=" + menu_static_link + "&menu_descriptiop=" + menu_descriptiop,
            dataType: 'json',
            success: function (data) {
                if (data.error == "no") {
                    document.location.replace('index.php?module=mycrm_menu&action=edit_menu&id=' + id);
                } else {
                    alert("Error during add subitem");
                }
            },
            error: function (data) {
                alert("Error during add subitem : " + data);
            }
        });
        $('#addSubitemModal').modal('hide');
    });

    $('#table').DataTable({
        "aLengthMenu": [[15, 25, 50, 100], [15, 25, 50, 100]],
        "iDisplayLength": 15,
        "language": {
            "lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },
        "order": [[2, "asc"]]
    });

});