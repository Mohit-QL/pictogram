<?php
require_once '../php/config.php';
$db = mysqli_connect(hostname, username, password, database) or die("Error While Connectiong Database");

$email = $_POST['email'];
$query = $db->prepare("SELECT * FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    echo "Email not found!";
    exit;
} else {
    $otp = rand(100000, 999999);

    echo $_SESSION['otp'] = $otp;
    echo $_SESSION['email'] = $email;

    mail($email, "Your OTP Code", "Your OTP is $otp");
    // header("Location: verify-otp.php");
}
