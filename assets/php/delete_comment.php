<?php
// delete_comment.php
if (isset($_POST['comment_id']) && isset($_POST['post_id'])) {
    $comment_id = $_POST['comment_id'];
    $post_id = $_POST['post_id'];

    error_log("Received comment_id: $comment_id, post_id: $post_id");

    require_once 'config.php';
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$db) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $query = "DELETE FROM comments WHERE id = ? AND post_id = ?";
    $stmt = mysqli_prepare($db, $query);

    if (!$stmt) {
        die("Failed to prepare statement: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, 'ii', $comment_id, $post_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Comment deleted successfully";
    } else {
        echo "Error deleting comment: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db);
} else {
    echo "Missing comment_id or post_id.";
}
