<?php
require_once 'config.php';

$db = mysqli_connect(hostname, username, password, database) or die("Error while connecting to the database");

session_start();

if (isset($_POST['submit_comment'])) {
    $user_id = $_SESSION['user']['id'];
    $post_id = $_POST['post_id'];
    $comment = trim($_POST['comment']);

    if (!empty($comment)) {
        $stmt = $db->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");

        if ($stmt === false) {
            die('Error preparing the statement: ' . $db->error);
        }

        $stmt->bind_param("iis", $post_id, $user_id, $comment);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Comment added successfully!";
        } else {
            $_SESSION['error'] = "Failed to add the comment. Please try again.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Comment cannot be empty.";
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

exit;
