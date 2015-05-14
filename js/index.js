/*$(document).ready(function () {
    setTimeout(function () {
        $.gritter.add({
            title: 'You have two new messages',
            text: 'Go to <a href="mailbox.html" class="text-warning">Mailbox</a> to see who wrote to you.<br/> Check the date and today\'s tasks.',
            time: 2000
        });
    }, 2000);
});*/

<!-- Fixed footer -->
$('#boxedlayout').prop('checked', false);
$("body").removeClass('boxed-layout');
$(".footer").addClass('fixed');
