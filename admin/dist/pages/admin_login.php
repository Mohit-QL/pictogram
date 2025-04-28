<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_name('admin_session');
session_start();

file_put_contents('session_debug.log', print_r($_SESSION, true), FILE_APPEND);

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    header('Location: index.php');
    exit();
}

const DB_NAME = 'pictogram_2';
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $email = $_POST['username_email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    } else {
        $query = "SELECT * FROM admins WHERE email = ? LIMIT 1";
        $stmt = $db->prepare($query);

        if (!$stmt) {
            $error_message = "Error preparing the query.";
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $admin = $result->fetch_assoc();

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];
                header('Location: index.php');
                exit;
            } else {
                $error_message = "Invalid email or password!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/pictogram/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/pictogram/assets/bootstrap/icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/pictogram/assets/css/custom.css" rel="stylesheet">
    <link rel="icon" href="assets/images/icon.png">
    <title>Admin Sign In</title>
</head>
<body>
    <div class="login">
        <div class="col-sm-12 col-md-4 bg-white border rounded p-4 shadow-sm">
            <form method="POST" action="admin_login.php">
                <div class="d-flex justify-content-center">
                    <img class="mb-4" src="/pictogram/assets/images/pictogram.png" alt="" height="45">
                </div>
                <h1 class="h5 mb-3 fw-normal">Please sign in</h1>

                <?php if (isset($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                } ?>

                <div class="form-floating">
                    <input type="email" name="username_email" class="form-control rounded-0" placeholder="username/email" required>
                    <label for="floatingInput">Enter Your Email</label>
                </div>

                <div class="form-floating mt-1">
                    <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Enter Your Password</label>
                </div>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit" name="login">Sign in</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
