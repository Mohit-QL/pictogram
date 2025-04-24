<?php
include 'functions.php';


if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user']['id'];

    if (isset($_GET['like'])) {
        $stmt = $db->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $post_id, $user_id);
        $stmt->execute();

        echo json_encode(['status' => true, 'liked' => true]);
    } elseif (isset($_GET['unlike'])) {
        $stmt = $db->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $post_id, $user_id);
        $stmt->execute();

        echo json_encode(['status' => true, 'liked' => false]);
    }
}
?>
