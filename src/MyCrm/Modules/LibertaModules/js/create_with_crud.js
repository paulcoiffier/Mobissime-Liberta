/**
 * Created by Paul on 25/01/2015.
 */

$("#wizard").steps();
$("#form").steps({
    bodyTag: "fieldset",
    onStepChanging: function (event, currentIndex, newIndex) {
        // Always allow going backward even if the current step contains invalid fields!
        if (currentIndex > newIndex) {
            return true;
        }

        // Forbid suppressing "Warning" step if the user is to young
        if (newIndex === 2) {

            var install_url = $("#install_url").val();
            var entity_name = $("#entity_name").val();

            var DATA = 'entity_name=' + entity_name;
            $.ajax({
                type: "POST",
                url: install_url + "/web/front.php/modules/getEntityFields",
                data: DATA,
                cache: false,
                success: function (data) {
                    $.each(JSON.parse(data), function (idx, obj) {
                        $('#fields_disp').append("<option data-value='" + obj + "'>" + obj + "</option>");
                    });
                }
            });
        }

        var form = $(this);

        // Clean up if user went backward before
        if (currentIndex < newIndex) {
            // To remove error styles
            $(".body:eq(" + newIndex + ") label.error", form).remove();
            $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
        }

        // Disable validation on fields that are disabled or hidden.
        form.validate().settings.ignore = ":disabled,:hidden";

        // Start validation; Prevent going forward if false
        return form.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex) {
        // Suppress (skip) "Warning" step if the user is old enough.
        if (currentIndex === 2 && Number($("#age").val()) >= 18) {
            $(this).steps("next");
        }

        // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
        if (currentIndex === 2 && priorIndex === 3) {
            $(this).steps("previous");
        }
    },
    onFinishing: function (event, currentIndex) {
        var form = $(this);

        // Disable validation on fields that are disabled.
        // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
        form.validate().settings.ignore = ":disabled";

        // Start validation; Prevent form submission if false
        return form.valid();
    },
    onFinished: function (event, currentIndex) {
        var form = $(this);

        // Submit form input
        form.submit();
    }
}).validate({
    errorPlacement: function (error, element) {
        element.before(error);
    },
    rules: {
        confirm: {
            equalTo: "#password"
        }
    }
});

$('#btnAdd').click(function () {
    var newValue = $("#fields_disp").val();
    if (newValue != null) {
        $('#fields_to_create').append("<option data-value='" + newValue + "'>" + newValue + "</option>");
        $('#fields_disp').find('option:selected').remove().end();
    }
});

$('#btnRemove').click(function () {
    var newValue = $("#fields_to_create").val();
    if (newValue != null) {
        $('#fields_disp').append("<option data-value='" + newValue + "'>" + newValue + "</option>");
        $('#fields_to_create').find('option:selected').remove().end();
    }
});

$('#select-to').change(function () {
    var option = $('#select-to').find('option:selected').data('value');
    console.log(option);

    var json = jQuery.parseJSON(JSON.stringify(option));
    $.each(json, function () {
        $("#newValue_type").val(this['Type']);
        $("#newValue").val(this['newValue']);

        if (this['Mandatory'] == 'checked') {
            $('#is_mandatory').prop('checked', true);
        } else {
            $('#is_mandatory').prop('checked', false);
        }

    });
});

$('#addNewValue').click(function () {
    var newValue_type = $("#newValue_type").val();
    var newValue = $("#newValue").val();

    if ($("#is_mandatory").is(":checked")) {
        var is_mandatory = "checked";
    } else {
        var is_mandatory = "unchecked";
    }

    /** Store JSON object in "data-value" select attribute */
    var obj = '[{"newValue":"' + newValue + '","Type":"' + newValue_type + '","Mandatory":"' + is_mandatory + '"}]';

    $('#select-to').append("<option data-value='" + obj + "'>" + newValue + "</option>");

    $("#newValue_type").val('');
    $("#newValue").val('');
    $('#is_mandatory').prop('checked', false);
});

$('#removeSelectedValue').click(function () {
    $("#newValue_type").val('');
    $("#newValue").val('');
    $('#select-to').find('option:selected').remove().end();
});

$("#form").submit(function (event) {

    event.preventDefault();

    var install_url = $("#install_url").val();

    /** CRUD Creation **/
    var DATA = 'entity_name=' + entity_name;
    $.ajax({
        type: "POST",
        url: install_url + "/web/front.php/modules/create_crud",
        data: DATA,
        cache: false,
        success: function (data) {
            alert(data);
        }
    });
});