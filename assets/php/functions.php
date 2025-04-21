<?php


require_once 'config.php';
$db = mysqli_connect(hostname, username, password, database) or die("Error While Connectiong Database");

// Function For Show Pages
function showPage($page, $data = "")
{
    include "assets/pages/$page.php";
}

// Function For Show Error
function showError($field)
{
    if (isset($_SESSION['error'])) {
        $error =  $_SESSION['error'];
        if (isset($error['field']) && $field == $error['field']) {
?>
            <div class="alert alert-danger my-1" role="alert">
                <?php echo $error['msg']; ?>
            </div>

<?php
        }
    }
}

//Function For Show Previous FormData
function showFormData($field)
{
    if (isset($_SESSION['formdata'])) {
        $formdata =  $_SESSION['formdata'];
        return $formdata[$field];
    }
}

// Function For Validating Signup Form
function validateSignupForm($form_data)
{
    $response = array();
    $response['status'] = true;
    if (!$form_data['password']) {
        $response['msg'] = "Password is Empty!!";
        $response['status'] = false;
        $response['field'] = "password";
    }
    if (!$form_data['username']) {
        $response['msg'] = "Username is Empty!!";
        $response['status'] = false;
        $response['field'] = "username";
    }
    if (!$form_data['email']) {
        $response['msg'] = "Email is Empty!!";
        $response['status'] = false;
        $response['field'] = "email";
    }
    if (!$form_data['last_name']) {
        $response['msg'] = "LastName is Empty!!";
        $response['status'] = false;
        $response['field'] = "last_name";
    }
    if (!$form_data['first_name']) {
        $response['msg'] = "FirstName is Empty!!";
        $response['status'] = false;
        $response['field'] = "first_name";
    }
    if (emailExixt($form_data['email'])) {
        $response['msg'] = "Email Is Already Exixst!!";
        $response['status'] = false;
        $response['field'] = "email";
    }
    if (usernameExist($form_data['username'])) {
        $response['msg'] = "Username Is Already Exixst!!";
        $response['status'] = false;
        $response['field'] = "username";
    }

    return $response;
}

// Function For Checking Duplicate Email
function emailExixt($email)
{
    global $db;

    $query = "SELECT count(*) as row FROM `users` WHERE email = '$email'";
    $run = mysqli_query($db, $query);
    $result = mysqli_fetch_assoc($run);
    return $result['row'];
}

// Function For Checking Duplicate Email
function usernameExist($username)
{
    global $db;

    $query = "SELECT count(*) as row FROM `users` WHERE username = '$username'";
    $run = mysqli_query($db, $query);
    $result = mysqli_fetch_assoc($run);
    return $result['row'];
}

// Function For Add New User
function addUser($data)
{
    global $db;
    $firstName = mysqli_real_escape_string($db, $data['first_name']);
    $lastName = mysqli_real_escape_string($db, $data['last_name']);
    $gender = $data['gender'];
    $email = mysqli_real_escape_string($db, $data['email']);
    $userName = mysqli_real_escape_string($db, $data['username']);
    $password = mysqli_real_escape_string($db, $data['password']);
    $password = md5($password);

    $query = "INSERT INTO `users`(`first_name`, `last_name`, `gender`, `email`, `username`, `password`) VALUES ('$firstName','$lastName','$gender','$email','$userName','$password')";
    return mysqli_query($db, $query);
}





// Function For Validating Login Form
function validateLoginForm($form_data)
{
    $response = array();
    $response['status'] = true;
    $response['msg'] = '';
    $response['field'] = '';
    $response['user'] = [];

    if (empty($form_data['username_email'])) {
        $response['msg'] = "Username/Email is empty!";
        $response['status'] = false;
        $response['field'] = "username_email";
        return $response;
    }

    if (empty($form_data['password'])) {
        $response['msg'] = "Password is empty!";
        $response['status'] = false;
        $response['field'] = "password";
        return $response;
    }

    $userCheck = checkUser($form_data);
    if ($userCheck['status']) {
        $response['user'] = $userCheck['user'];
    } else {
        $response['msg'] = "Invalid login credentials!";
        $response['status'] = false;
    }

    return $response;
}


// Function For Check User
function checkUser($login_data)
{
    global $db;
    $username_email = mysqli_real_escape_string($db, $login_data['username_email']);
    $password = md5($login_data['password']);

    $query = "SELECT * FROM `users` WHERE (email='$username_email' OR username='$username_email') AND password='$password'";
    $run = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($run);

    $result['user'] = $user ?? [];
    $result['status'] = !empty($user);

    return $result;
}
