/**
 * Created by Paul on 23/01/2015.
 */

var install_url = $("#install_url").val();

$('#formUserProfil').validator();


$("#submitProfilePicture").click(function () {

    var userid = $("#userid").val();
    var img = $image.cropper("getDataURL");

    $.ajax({
        url: install_url + '/web/front.php/profile/save_picture_ajax',
        type: 'POST',
        data: 'image=' + img + "&userid=" + userid,
        dataType: 'json',
        success: function (data) {
            if (data.error == "no") {
                showLongToaster("success", "Profile updated");
            } else {
                alert("Error during updating profile");
            }
        },
        error: function (data) {
            alert("Error during updating profile : " + data);
        }
    });
});

$("#submitProfile").click(function () {

    var userid = $("#userid").val();
    var usr_first_name = $("#usr_first_name").val();
    var usr_last_name = $("#usr_last_name").val();
    var usr_date_naissance = $("#usr_date_naissance").val();
    var usr_phone = $("#usr_phone").val();
    var usr_mobile_phone = $("#usr_mobile_phone").val();
    var usr_email = $("#usr_email").val();
    var usr_language = $("#usr_language").val();

    $.ajax({
        url: install_url + '/web/front.php/profile/save_profile_ajax',
        type: 'POST',
        data: "userid=" + userid + "&usr_first_name=" + usr_first_name + "&usr_last_name=" + usr_last_name + "&usr_date_naissance=" + usr_date_naissance + "&usr_phone=" + usr_phone + "&usr_mobile_phone=" + usr_mobile_phone + "&usr_email=" + usr_email + "&usr_language=" + usr_language,
        dataType: 'json',
        success: function (data) {
            if (data.error == "no") {
                showLongToaster("success", "Profile updated");
            } else {
                alert("Error during updating profile");
            }
        },
        error: function (data) {
            alert("Error during updating profile : " + data);
        }
    });

});


var $image = $(".image-crop > img")
$($image).cropper({
    aspectRatio: 1,
    preview: ".img-preview",
    done: function (data) {
        // Output the result data for cropping image.
    }
});

var $inputImage = $("#inputImage");
if (window.FileReader) {
    $inputImage.change(function () {
        var fileReader = new FileReader(),
            files = this.files,
            file;

        if (!files.length) {
            return;
        }

        file = files[0];

        if (/^image\/\w+$/.test(file.type)) {
            fileReader.readAsDataURL(file);
            fileReader.onload = function () {
                $inputImage.val("");
                $image.cropper("reset", true).cropper("replace", this.result);
            };
        } else {
            showMessage("Please choose an image file.");
        }
    });
} else {
    $inputImage.addClass("hide");
}

$("#download").click(function () {
    window.open($image.cropper("getDataURL"));
});

$("#zoomIn").click(function () {
    $image.cropper("zoom", 0.1);
});

$("#zoomOut").click(function () {
    $image.cropper("zoom", -0.1);
});

$("#rotateLeft").click(function () {
    $image.cropper("rotate", 45);
});

$("#rotateRight").click(function () {
    $image.cropper("rotate", -45);
});

$("#setDrag").click(function () {
    $image.cropper("setDragMode", "crop");
});