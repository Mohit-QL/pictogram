<?php
session_start();

echo "<h3>Session Data Before:</h3>";
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

const DB_NAME = 'pictogram_2';
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

$id = $_GET['user_id'];

$query = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    $_SESSION['Auth'] = true;
    $_SESSION['userdata'] = [
        'id' => $user['id'],
        'email' => $user['email'],
        'password' => $user['password']
    ];

    $_SESSION['admin_logged_in'] = true;  

  
    echo "<h3>Session Data After:</h3>";
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';

   
    header('Location: ../../../index.php'); 
    exit();
} else {
    echo "User not found.";
}

session_destroy();  
exit();
