/**
 * Created by Paul on 17/01/2015.
 */
$(document).ready(function () {
    $("#commit").click(function () {

        var login = $("#login").val();
        var password = $("#password").val();
        var install_url = $("#install_url").val();

        /** Ajax password verification */
        $.ajax({
            url: install_url + '/web/front.php/app/login',
            type: 'POST',
            data: 'login=' + login + '&password=' + password,
            dataType: 'json',
            success: function (data) {
                if (data.error == "no" && data.result == "yes") {
                    /** Redirection / démarrage de la session */
                    window.location.href = (install_url+'/web/front.php/app');
                } else {
                    //alert("Error : Bad username and/or wrong password");
                    $('#loginError').text("Error : Bad username and/or wrong password");
                }
            },
            error: function (data) {
                alert('Erreur du serveur : ' + data.error + " " + data.result);
            }
        });
    });
})
