<?php
require_once 'config.php';
$db = mysqli_connect(hostname, username, password, database) or die("Error While Connectiong Database");

if (isset($_POST['submit_comment'])) {
    $user_id = $_SESSION['user']['id']; 
    $post_id = $_POST['post_id'];
    $comment = trim($_POST['comment']);

    if (!empty($comment)) {
        $stmt = $db->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $post_id, $user_id, $comment);
        $stmt->execute();
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
exit;
