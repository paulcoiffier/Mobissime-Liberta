/**
 * Created by Paul on 29/01/2015.
 */

function showLongToaster(type, message) {
    toastr.options = {
        "closeButton": true,
        "timeOut": "3000"
    };
    if (type == "success") {
        toastr['success'](message, 'MyCRM');
    } else if (type == "error") {
        toastr['error'](message, 'MyCRM');
    }
}

function showShortToaster(type, message) {
    toastr.options = {
        "closeButton": true,
        "timeOut": "1000"
    };
    if (type == "success") {
        toastr['success'](message, 'MyCRM');
    } else if (type == "error") {
        toastr['error'](message, 'MyCRM');
    }
}
function reloadPage() {
    window.location.reload();
}
