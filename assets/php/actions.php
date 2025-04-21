<?php

require_once 'functions.php';

// SIGN UP
if (isset($_GET['signup'])) {
    $data = validateSignupForm($_POST);
    if ($data['status']) {
        if (addUser($_POST)) {
            header("location: ../../?login");
        } else {
            echo "<script>alert('Error While User Registration');</script>";
        }
    } else {
        $_SESSION['error'] = $data;
        $_SESSION['formdata'] = $_POST;
        header("location: ../../?signup");
    }
}

// LOGIN
if (isset($_GET['login'])) {
    $data = validateLoginForm($_POST);

    if ($data['status']) {
        $user = $data['user'];
        $_SESSION['auth'] = true;
        $_SESSION['user'] = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'username' => $user['username'],
            'gender' => $user['gender']
        ];

        header("Location: ../../");
        exit;
    } else {
        $_SESSION['error'] = $data;
        $_SESSION['formdata'] = $_POST;
        header("Location: ../../?login");
        exit;
    }
}
