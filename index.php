<?php
require_once 'assets/php/functions.php';

// echo "<pre>";
// print_r(getPost());

if (isset($_GET['newfp'])) {
    unset($_SESSION['auth_temp']);
    unset($_SESSION['forgot_email']);
    unset($_SESSION['forgot_password']);
}
if (isset($_SESSION['auth'])) {
    $user = getUser($_SESSION['user']['id']);
    $posts = getPost();
    $follow_suggestion = filterFollowSuggestion();
}


$pagecount = count($_GET);

if (isset($_SESSION['auth']) && $user['ac_status'] == 1 && !$pagecount) {
    showPage('header', ['page_title' => 'Pictogram - Home']);
    showPage('nav');
    showPage('wall');
} else if (isset($_SESSION['auth']) && $user['ac_status'] == 0 && !$pagecount) {
    showPage('header', ['page_title' => 'Pictogram - Verify Email']);
    showPage('verify_email');
} else if (isset($_SESSION['auth']) && $user['ac_status'] == 2 && !$pagecount) {
    showPage('header', ['page_title' => 'Pictogram - Blocked']);
    showPage('blocked');
} elseif (isset($_SESSION['auth']) && isset($_GET['edit_profile']) && $user['ac_status'] == 1) {
    showPage('header', ['page_title' => 'Pictogram - Edit Profile']);
    showPage('nav');
    showPage('edit_profile');
} elseif (isset($_SESSION['auth']) && isset($_GET['u']) && $user['ac_status'] == 1) {
    $profile = getUserByUsername($_GET['u']);

    if (!$profile) {
        showPage('header', ['page_title' => 'Pictogram - User Not Found!!']);
        showPage('user_not_found');
    } else {
        $profile_post = getPostByUserId($profile['id']);

        showPage('header', ['page_title' => "Pictogram - {$profile['first_name']} {$profile['last_name']}"]);
        showPage('nav');
        showPage('profile');
    }
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
    if (isset($_SESSION['auth'])  && $user['ac_status'] == 1) {
        showPage('header', ['page_title' => 'Pictogram - Home']);
        showPage('nav');
        showPage('wall');
    } else if (isset($_SESSION['auth']) && $user['ac_status'] == 0) {
        showPage('header', ['page_title' => 'Pictogram - Verify Email']);
        showPage('verify_email');
    } else if (isset($_SESSION['auth']) && $user['ac_status'] == 2) {
        showPage('header', ['page_title' => 'Pictogram - Blocked']);
        showPage('blocked');
    } else {
        showPage('header', ['page_title' => 'Pictogram - Login']);
        showPage('login');
    }
}

showPage('footer');
unset($_SESSION['error']);
unset($_SESSION['formdata']);
