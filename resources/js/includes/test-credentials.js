document.addEventListener('DOMContentLoaded',function () {
    const $email = document.getElementById('email');
    const $password = document.getElementById('password');
    const button1 = document.querySelector('.btn-credentials-1');
    const button2 = document.querySelector('.btn-credentials-2');

    button1.addEventListener('click', function () {
        $email.value = process.env.MIX_TEST_CRED_ADMIN_USER;
        $password.value = process.env.MIX_TEST_CRED_ADMIN_PASSWORD;
    })
    button2.addEventListener('click', function () {
        $email.value = process.env.MIX_TEST_CRED_REGULAR_USER;
        $password.value = process.env.MIX_TEST_CRED_REGULAR_PASSWORD;
    })
})
