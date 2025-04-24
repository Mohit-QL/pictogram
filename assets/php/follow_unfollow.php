<?php
require_once 'config.php';
require_once 'functions.php';
$db = mysqli_connect(hostname, username, password, database) or die("Error While Connectiong Database");

if (!isset($_SESSION['user']['id'])) {
    die("User is not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['action'])) {
    $currentUser = $_SESSION['user']['id'];
    $profileId = $_POST['user_id'];
    $action = $_POST['action'];

    if ($action == 'follow') {
        if (!isFollowed($profileId)) {
            $query = "INSERT INTO follow_list (follower_id, user_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "ii", $currentUser, $profileId);
            if (mysqli_stmt_execute($stmt)) {
                echo "success";
            } else {
                echo "Error following user.";
            }
            mysqli_stmt_close($stmt);
        }
    } elseif ($action == 'unfollow') {
-        $query = "DELETE FROM follow_list WHERE follower_id = ? AND user_id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "ii", $currentUser, $profileId);
        if (mysqli_stmt_execute($stmt)) {
            echo "success";
        } else {
            echo "Error unfollowing user.";
        }
        mysqli_stmt_close($stmt);
    }
}
