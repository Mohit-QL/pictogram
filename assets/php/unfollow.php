<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']['id'])) {
    die("User is not logged in.");
}

$db = mysqli_connect(hostname, username, password, database);
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $follower_id = $_SESSION['user']['id'];
    $user_id = $_POST['user_id'];

    $query = "DELETE FROM follow_list WHERE follower_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $follower_id, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Successfully unfollowed the user.";
        } else {
            die("Error while unfollowing: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    } else {
        die("Failed to prepare SQL statement: " . mysqli_error($db));
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    die("Invalid request.");
}
