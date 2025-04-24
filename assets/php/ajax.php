<?php
include 'functions.php';

$response = [];

if (isset($_GET['like']) && isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);
    $check = checkLike($post_id);

    if ($check['user']['ROW'] == 0) {
        if (like($post_id)) {
            $response['status'] = true;
            $response['liked'] = true;
        } else {
            $response['status'] = false;
        }
    } else {
        $response['status'] = true;
        $response['liked'] = false;
    }

    echo json_encode($response);
} else {
    echo json_encode(['status' => false, 'error' => 'Invalid request']);
}
