require('jquery');

$(document).ready(function () {
    const $email = $('#email');
    const $password = $('#password');
    const $button1 = $('.btn-credentials-1');
    const $button2 = $('.btn-credentials-2');

    $button1.click(function () {
        $email.val(process.env.MIX_TEST_CRED_ADMIN_USER);
        $password.val(process.env.MIX_TEST_CRED_ADMIN_PASSWORD);
    })
    $button2.click(function () {
        $email.val(process.env.MIX_TEST_CRED_REGULAR_USER);
        $password.val(process.env.MIX_TEST_CRED_REGULAR_PASSWORD);
    })
})
