<?php
require_once 'config.php';
$db = mysqli_connect(hostname, username, password, database) or die("Error While Connectiong Database");

if (!isset($_SESSION['user'])) {
    echo "unauthorized";
    exit;
}

if (isset($_POST['user_id'])) {
    $currentUser = $_SESSION['user']['id'];
    $followUserId = $_POST['user_id'];

    if ($currentUser == $followUserId) {
        echo "cannot_follow_self";
        exit;
    }

    $checkQuery = "SELECT * FROM follow_list WHERE follower_id='$currentUser' AND user_id='$followUserId'";
    $checkResult = mysqli_query($db, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "already_following";
        exit;
    }

    $query = "INSERT INTO follow_list (follower_id, user_id) VALUES ('$currentUser', '$followUserId')";
    $run = mysqli_query($db, $query);

    if ($run) {
        echo "success";
    } else {
        echo "db_error";
    }
} else {
    echo "no_user_id";
}
