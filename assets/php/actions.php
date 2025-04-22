<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
$db = mysqli_connect(hostname, username, password, database) or die("Error While Connectiong Database");
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}
require_once 'functions.php';
require_once 'send_code.php';

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
            'gender' => $user['gender'],
            'ac_status' => 0
        ];

        if ($data['user']['ac_status'] == 0) {
            $_SESSION['code'] = $code = rand(111111, 999999);
            sendCode($data['user']['email'], 'Verify Your Email', $code);
        }
        header("Location: ../../");
        exit;
    } else {
        $_SESSION['error'] = $data;
        $_SESSION['formdata'] = $_POST;
        header("Location: ../../?login");
        exit;
    }
}

if (isset($_GET['resend_code'])) {
    $_SESSION['code'] = $code = rand(111111, 999999);
    sendCode($_SESSION['user']['email'], 'Verify Your Email', $code);
    header('location: ../../?resended');
}

if (isset($_GET['verify_email'])) {
    $usercode = $_POST['code'];
    $code = $_SESSION['code'];
    if ($code == $usercode) {
        if (verifyEmail($_SESSION['user']['email'])) {
            header("location: ../../");
        } else {
            echo "verifyEmail() Funtion Not Working";
        }
    } else {
        $data['msg'] = "Incorrect Verification Code!!";
        if (!$_POST['code']) {
            $data['msg'] = "Please Enter 6 Digit Code!!";
        }
        $data['field'] = 'email_verify';
        $_SESSION['error'] = $data;
        $_SESSION['formdata'] = $_POST;
        header("location: ../../");
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('location: ../../');
}

if (isset($_GET['forgot_password'])) {
    if (empty($_POST['email'])) {
        $response['msg'] = "Enter Your Email!!";
        $response['field'] = "email";
        $_SESSION['error'] = $response;
        header('location: ../../?forgot_password');
    } elseif (!emailExixt($_POST['email'])) {
        $response['msg'] = "Email Is Not Registered!!";
        $response['field'] = "email";
        $_SESSION['error'] = $response;
        header('location: ../../?forgot_password');
    } else {
        $_SESSION['forgot_email'] = $_POST['email'];
        $code = rand(111111, 999999);
        $_SESSION['forgot_code'] = $code;
        echo $_SESSION['forgot_code'];
        sendCode($_POST['email'], 'OTP For Forgot Your Password', $code);
        header('location: ../../?forgot_password&resened');
    }
}


// Verify Forgot Code
if (isset($_GET['verify_code'])) {
    $usercode = $_POST['code'];
    $code = $_SESSION['forgot_code'];
    if ($code == $usercode) {
        $_SESSION['auth_temp'] = true;
        unset($_SESSION['forgot_code']);
        header('location: ../../?forgot_password&verified=1');
        exit();
    } else {
        $data['msg'] = "Incorrect Verification Code!!";
        if (!$_POST['code']) {
            $data['msg'] = "Please Enter 6 Digit Code!!";
        }
        $data['field'] = 'email_verify';
        $_SESSION['error'] = $data;
        $_SESSION['formdata'] = $_POST;
        header("location: ../../?forgot_password");
        exit();
    }
}


if (isset($_GET['change_password'])) {
    if (empty($_POST['password'])) {
        $_SESSION['error'] = [
            'msg' => "Enter Your New Password",
            'field' => "password"
        ];
        header('Location: ../../?forgot_password');
        exit();
    }

    $email = $_SESSION['forgot_email'] ?? null;
    if (!$email) {
        $_SESSION['error'] = [
            'msg' => "Session expired. Please start over.",
            'field' => "email"
        ];
        header('Location: ../../?forgot_password');
        exit();
    }

    $result = resetPassword($email, $_POST['password']);

    if ($result === true) {
        unset($_SESSION['forgot_email']);
        unset($_SESSION['auth_temp']);
        unset($_SESSION['forgot_code']);
        header('Location: ../../?reseted');
        exit();
    } else {
        $_SESSION['error'] = [
            'msg' => "Password update failed: " . $result,
            'field' => "password",
            'debug' => [
                'email' => $email,
                'password_length' => strlen($_POST['password'])
            ]
        ];
        header('Location: ../../?forgot_password');
        exit();
    }
}
