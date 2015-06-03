/**
 * Created by Paul on 29/01/2015.
 */

/**
 * Show Long toaster
 *
 * @param {type} Error, info, etc.
 * @param {message} Message to show
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

/**
 * Show Short toaster
 *
 * @param {type} Error, info, etc.
 * @param {message} Message to show
 */
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

/**
 * Reload page
 */
function reloadPage() {
    window.location.reload();
}
