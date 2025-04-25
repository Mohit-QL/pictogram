<?php
include('config.php'); // Include the database connection file
$db = mysqli_connect(hostname, username, password, database);

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}
// Function to fetch post details by post ID
function getPostDetails($post_id)
{
    global $db;

    // SQL query to get the post details
    $sql = "SELECT posts.id, posts.post_img, users.first_name, users.last_name, users.username, users.profile_pic
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.id = ?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $post_id); // "i" means the parameter is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // If post exists, return the details as an associative array
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        return $post;
    } else {
        return null;
    }
}

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $query = "SELECT p.id, p.post_img, u.profile_pic, u.first_name, u.last_name, u.username
              FROM posts p
              INNER JOIN users u ON p.user_id = u.id
              WHERE p.id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        echo json_encode($post); 
    } else {
        echo json_encode(['error' => 'Post not found']);
    }
} else {
    echo json_encode(['error' => 'Post ID is missing']);
}

$db->close();
