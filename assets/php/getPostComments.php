<?php
include('config.php'); 
$db = mysqli_connect(hostname, username, password, database);

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

function getPostComments($post_id)
{
    global $db;

    $sql = "SELECT comments.comment, comments.created_at, users.first_name, users.last_name, users.profile_pic, comments.user_id
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id = ?
            ORDER BY comments.created_at DESC";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($comment = $result->fetch_assoc()) {
        $comments[] = $comment;
    }

    return $comments;
}

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $query = "SELECT c.comment, c.created_at, u.first_name, u.last_name, u.profile_pic, c.user_id
              FROM comments c
              INNER JOIN users u ON c.user_id = u.id
              WHERE c.post_id = ?
              ORDER BY c.created_at ASC";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($comment = $result->fetch_assoc()) {
        $comments[] = $comment;
    }

    echo json_encode($comments); 
} else {
    echo json_encode(['error' => 'Post ID is missing']);
}

$db->close();
