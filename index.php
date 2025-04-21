<?php
require_once 'assets/php/functions.php';



if (isset($_SESSION['auth'])) {
    echo "User Is Logged In";
    $userData = $_SESSION['user'];
    echo "<pre>";
    print_r($userData);
} elseif (isset($_GET['signup'])) {
    showPage('header', ['page_title' => 'Pictogram - Signup']);
    showPage('signup');
} else if (isset($_GET['login'])) {
    showPage('header', ['page_title' => 'Pictogram - Login']);
    showPage('login');
}
else{
    showPage('header', ['page_title' => 'Pictogram - Login']);
    showPage('login');
}

showPage('footer');
unset($_SESSION['error']);
unset($_SESSION['formdata']);
