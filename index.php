<?php
require_once 'assets/php/functions.php';

if (isset($_GET['newfp'])) {
    unset($_SESSION['auth_temp']);
    unset($_SESSION['forgot_email']);
    unset($_SESSION['forgot_password']);
}
if (isset($_SESSION['auth'])) {
    $user = getUser($_SESSION['user']['id']);
}
if (isset($_SESSION['auth']) && $user['ac_status'] == 1) {
    showPage('header', ['page_title' => 'Pictogram - Home']);
    showPage('nav');
    showPage('wall');
} else if (isset($_SESSION['auth']) && $user['ac_status'] == 0) {
    showPage('header', ['page_title' => 'Pictogram - Verify Email']);
    showPage('verify_email');
} else if (isset($_SESSION['auth']) && $user['ac_status'] == 2) {
    showPage('header', ['page_title' => 'Pictogram - Blocked']);
    showPage('blocked');
} elseif (isset($_GET['signup'])) {
    showPage('header', ['page_title' => 'Pictogram - Signup']);
    showPage('signup');
} else if (isset($_GET['login'])) {
    showPage('header', ['page_title' => 'Pictogram - Login']);
    showPage('login');
} else if (isset($_GET['forgot_password'])) {
    showPage('header', ['page_title' => 'Pictogram - Forgot Password']);
    showPage('forgot_password');
} else {
    showPage('header', ['page_title' => 'Pictogram - Login']);
    showPage('login');
}

showPage('footer');
unset($_SESSION['error']);
unset($_SESSION['formdata']);
