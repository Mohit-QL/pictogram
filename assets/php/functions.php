<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once 'config.php';
$db = mysqli_connect(hostname, username, password, database) or die("Error While Connectiong Database");

// Function For Show Pages
function showPage($page, $data = "")
{

    include "assets/pages/$page.php";
}

// Function For Show Error
function showError($field)
{
    if (isset($_SESSION['error'])) {
        $error =  $_SESSION['error'];
        if (isset($error['field']) && $field == $error['field']) {
?>
            <div class="alert alert-danger my-1" role="alert">
                <?php echo $error['msg']; ?>
            </div>

<?php
        }
    }
}

//Function For Show Previous FormData
function showFormData($field)
{
    if (isset($_SESSION['formdata'])) {
        $formdata =  $_SESSION['formdata'];
        return $formdata[$field];
    }
}

// Function For Validating Signup Form
function validateSignupForm($form_data)
{
    $response = array();
    $response['status'] = true;
    if (!$form_data['password']) {
        $response['msg'] = "Password is Empty!!";
        $response['status'] = false;
        $response['field'] = "password";
    }
    if (!$form_data['username']) {
        $response['msg'] = "Username is Empty!!";
        $response['status'] = false;
        $response['field'] = "username";
    }
    if (!$form_data['email']) {
        $response['msg'] = "Email is Empty!!";
        $response['status'] = false;
        $response['field'] = "email";
    }
    if (!$form_data['last_name']) {
        $response['msg'] = "LastName is Empty!!";
        $response['status'] = false;
        $response['field'] = "last_name";
    }
    if (!$form_data['first_name']) {
        $response['msg'] = "FirstName is Empty!!";
        $response['status'] = false;
        $response['field'] = "first_name";
    }
    if (emailExixt($form_data['email'])) {
        $response['msg'] = "Email Is Already Exixst!!";
        $response['status'] = false;
        $response['field'] = "email";
    }
    if (usernameExist($form_data['username'])) {
        $response['msg'] = "Username Is Already Exixst!!";
        $response['status'] = false;
        $response['field'] = "username";
    }

    return $response;
}

// Function For Checking Duplicate Email
function emailExixt($email)
{
    global $db;

    $query = "SELECT count(*) as row FROM `users` WHERE email = '$email'";
    $run = mysqli_query($db, $query);
    $result = mysqli_fetch_assoc($run);
    return $result['row'];
}

// Function For Checking Duplicate Email
function usernameExist($username)
{
    global $db;

    $query = "SELECT count(*) as row FROM `users` WHERE username = '$username'";
    $run = mysqli_query($db, $query);
    $result = mysqli_fetch_assoc($run);
    return $result['row'];
}

// Function For Add New User
function addUser($data)
{
    global $db;
    $firstName = mysqli_real_escape_string($db, $data['first_name']);
    $lastName = mysqli_real_escape_string($db, $data['last_name']);
    $gender = $data['gender'];
    $email = mysqli_real_escape_string($db, $data['email']);
    $userName = mysqli_real_escape_string($db, $data['username']);
    $password = mysqli_real_escape_string($db, $data['password']);
    $password = md5($password);

    $query = "INSERT INTO `users`(`first_name`, `last_name`, `gender`, `email`, `username`, `password`) VALUES ('$firstName','$lastName','$gender','$email','$userName','$password')";
    return mysqli_query($db, $query);
}


// Function For Validating Login Form
function validateLoginForm($form_data)
{
    $response = array();
    $response['status'] = true;
    $response['msg'] = '';
    $response['field'] = '';
    $response['user'] = [];

    if (empty($form_data['username_email'])) {
        $response['msg'] = "Username/Email is empty!";
        $response['status'] = false;
        $response['field'] = "username_email";
        return $response;
    }

    if (empty($form_data['password'])) {
        $response['msg'] = "Password is empty!";
        $response['status'] = false;
        $response['field'] = "password";
        return $response;
    }

    $userCheck = checkUser($form_data);
    if ($userCheck['status']) {
        $response['user'] = $userCheck['user'];
    } else {
        $response['msg'] = "Invalid login credentials!";
        $response['status'] = false;
    }

    return $response;
}


// Function For Check User
function checkUser($login_data)
{
    global $db;
    $username_email = mysqli_real_escape_string($db, $login_data['username_email']);
    $password = md5($login_data['password']);

    $query = "SELECT * FROM `users` WHERE (email='$username_email' OR username='$username_email') AND password='$password'";
    $run = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($run);

    $result['user'] = $user ?? [];
    $result['status'] = !empty($user);

    return $result;
}


//Funtion For Fetch User Data
function getUser($user_id)
{
    global $db;
    $query = "SELECT * FROM `users` WHERE id='$user_id'";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
    return $result;
}

// Function For Verify Email
function verifyEmail($email)
{
    global $db;

    $query = "UPDATE `users` SET ac_status=1 WHERE email='$email'";
    return mysqli_query($db, $query);
}




function resetPassword($email, $password)
{
    global $db;
    $check_query = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($db, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        return "Email not found in database";
    }

    $update_query = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = mysqli_prepare($db, $update_query);

    if (!$stmt) {
        return "Prepare failed: " . mysqli_error($db);
    }

    $hashed_password = md5($password);

    mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);
    $success = mysqli_stmt_execute($stmt);

    if (!$success) {
        return "Database error: " . mysqli_error($db);
    }

    if (mysqli_stmt_affected_rows($stmt) == 0) {
        return "No rows updated - password may be the same as current";
    }

    return true;
}


function view_profile($username)
{
    include 'assets/pages/profile.php';
}


// FUNTION FOR VALIDATING UPDATE PROFILE

function validateUpdateProfile($form_data, $image_data)
{
    $response = array();
    $response['status'] = true;

    if (!$form_data['username']) {
        $response['msg'] = "Username is Empty!!";
        $response['status'] = false;
        $response['field'] = "username";
    }
    if (!$form_data['last_name']) {
        $response['msg'] = "LastName is Empty!!";
        $response['status'] = false;
        $response['field'] = "last_name";
    }
    if (!$form_data['first_name']) {
        $response['msg'] = "FirstName is Empty!!";
        $response['status'] = false;
        $response['field'] = "first_name";
    }
    if (usernameExistByOther($form_data['username'])) {
        $response['msg'] = $form_data['username'] . " Is Already Exixst!!";
        $response['status'] = false;
        $response['field'] = "username";
    }
    if ($image_data['name']) {
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        // $size = $image_data['size']/1024;
        $size_mb = $image_data['size'] / 1024 / 1024;

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
        if (!in_array($type, $allowed_types)) {
            $response['msg'] = "Only image files are allowed!";
            $response['status'] = false;
            $response['field'] = "profile_pic";
        }

        $max_size_mb = 50;
        if ($size_mb > $max_size_mb) {
            $uploaded_size = round($size_mb, 2);
            $response['msg'] = "Uploaded image size is {$uploaded_size} MB. Maximum allowed size is {$max_size_mb} MB!";
            $response['status'] = false;
            $response['field'] = "profile_pic";
        }
    }

    return $response;
}


// Function For Checking Duplicate Username By Other
function usernameExistByOther($username)
{
    global $db;
    $userid = $_SESSION['user']['id'];
    $query = "SELECT count(*) as row FROM `users` WHERE username = '$username' AND id!='$userid'";
    $run = mysqli_query($db, $query);
    $result = mysqli_fetch_assoc($run);
    return $result['row'];
}


function updateUser($form_data, $file_data)
{
    global $db;

    $user_id = $_SESSION['user']['id'];
    $first_name = mysqli_real_escape_string($db, $form_data['first_name']);
    $last_name = mysqli_real_escape_string($db, $form_data['last_name']);
    $username = mysqli_real_escape_string($db, $form_data['username']);
    $password = !empty($form_data['password']) ? md5($form_data['password']) : null;

    // Handle profile picture upload
    $profile_pic_name = null;
    if (!empty($file_data['name'])) {
        $target_dir = "../../assets/images/Profile/";
        $original_name = basename($file_data["name"]);
        $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        $profile_pic_name = uniqid("profile_") . "." . $ext;
        $target_file = $target_dir . $profile_pic_name;

        if (!move_uploaded_file($file_data["tmp_name"], $target_file)) {
            return false;
        }
    }

    $sql = "UPDATE users SET 
                first_name = '$first_name', 
                last_name = '$last_name', 
                username = '$username', 
                updated_at = CURRENT_TIMESTAMP()";

    if ($password) {
        $sql .= ", password = '$password'";
    }

    if ($profile_pic_name) {
        $sql .= ", profile_pic = '$profile_pic_name'";
    }

    $sql .= " WHERE id = $user_id";

    if (mysqli_query($db, $sql)) {
        return true;
    } else {
        return false;
    }
}


//FUNCTIONs FOR POSTS

function validatePostImage($image_data)
{
    $response = array();
    $response['status'] = true;

    if (!$image_data['name']) {
        $response['msg'] = "Please select an image.";
        $response['status'] = false;
        $response['field'] = "post_image";
    }

    if ($image_data['name']) {
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $size_mb = $image_data['size'] / 1024 / 1024;

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
        if (!in_array($type, $allowed_types)) {
            $response['msg'] = "Only image files are allowed!";
            $response['status'] = false;
            $response['field'] = "post_image";
        }

        $max_size_mb = 50;
        if ($size_mb > $max_size_mb) {
            $uploaded_size = round($size_mb, 2);
            $response['msg'] = "Uploaded image size is {$uploaded_size} MB. Maximum allowed size is {$max_size_mb} MB!";
            $response['status'] = false;
            $response['field'] = "post_image";
        }
    }

    return $response;
}

function addPost($text, $image)
{
    global $db;
    $user_id = $_SESSION['user']['id'];
    $post_text = mysqli_real_escape_string($db, $text['post_text']);
    $post_pic_name = '';

    if (!empty($image['name'])) {
        $target_dir = "../../assets/images/Post/";
        $ext = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
        $post_pic_name = uniqid("post_") . "." . $ext;
        $target_file = $target_dir . $post_pic_name;

        if (!move_uploaded_file($image["tmp_name"], $target_file)) {
            return false;
        }
    }

    $query = "INSERT INTO posts (user_id, post_img, post_text) 
          VALUES ('$user_id', '$post_pic_name', '$post_text')";

    $result = mysqli_query($db, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($db));
    }
    return $result;
}

function getPost()
{
    global $db;
    $query = "SELECT posts.id, posts.user_id, posts.post_img, posts.post_text, posts.created_at, users.first_name, users.last_name, users.username, users.profile_pic FROM posts JOIN users ON users.id=posts.user_id ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
    return $result;
}

function getWallPost()
{
    global $db;
    $query = "SELECT posts.id, posts.user_id, posts.post_img, posts.post_text, posts.created_at, users.first_name, users.last_name, users.username, users.profile_pic FROM posts JOIN users ON users.id=posts.user_id ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
    return $result;
}

function filterPost()
{
    $list = getPost();
    $filterList = [];
    foreach ($list as $post) {
        if (isFollowed($post['user_id']) || $post['user_id'] == $_SESSION['user']['id']) {
            $filterList[] = $post;
        }
    }

    return $filterList;
}



// FUNTIONS FOR PROFILE

function getUserByUsername($username)
{
    global $db;
    $query = "SELECT * FROM `users` WHERE username='$username'";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
    return $result;
}

function getPostByUserId($userid)
{
    global $db;
    $query = "SELECT * FROM `posts` WHERE user_id='$userid' ORDER BY id DESC";
    $run = mysqli_query($db, $query);

    $result = [];
    if ($run && mysqli_num_rows($run) > 0) {
        while ($row = mysqli_fetch_assoc($run)) {
            $result[] = $row;
        }
    }

    return $result;
}



// FUNCTIONS FOR FOLLOW

function getFollowSuggestion()
{
    global $db;
    $currentUser = $_SESSION['user']['id'];

    $query = "SELECT * FROM `users` WHERE id != '$currentUser' LIMIT 10";
    $run = mysqli_query($db, $query);

    $suggestions = [];
    if ($run && mysqli_num_rows($run) > 0) {
        while ($row = mysqli_fetch_assoc($run)) {
            $suggestions[] = $row;
        }
    }

    return $suggestions;
}


function filterFollowSuggestion()
{
    $list = getFollowSuggestion();
    $filterList = [];

    foreach ($list as $user) {
        if (!isFollowed($user['id'])) {
            $filterList[] = $user;
        }
    }

    return $filterList;
}


// function isFollowed($user_id)
// {
//     global $db;
//     $currentUser = $_SESSION['user']['id'];
//     $query = "SELECT 1 FROM `follow_list` WHERE follower_id = '$currentUser' AND user_id = '$user_id' LIMIT 1";
//     $run = mysqli_query($db, $query);

//     return mysqli_num_rows($run) > 0;
// }

function isFollowed($user_id)
{
    global $db;
    $currentUser = $_SESSION['user']['id'];

    // Use prepared statement to avoid SQL injection
    $query = "SELECT 1 FROM `follow_list` WHERE follower_id = ? AND user_id = ? LIMIT 1";
    $stmt = mysqli_prepare($db, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ii", $currentUser, $user_id);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_num_rows($result) > 0;
}



function getFollowersCount($user_id)
{
    global $db;

    $query = "SELECT COUNT(*) as count FROM follow_list WHERE user_id = '$user_id'";
    $result = mysqli_query($db, $query);
    $data = mysqli_fetch_assoc($result);

    return $data['count'];
}

function getFollowingCount($user_id)
{
    global $db;

    $query = "SELECT COUNT(*) as count FROM follow_list WHERE follower_id = '$user_id'";
    $result = mysqli_query($db, $query);
    $data = mysqli_fetch_assoc($result);

    return $data['count'];
}

function getFollowersList($user_id)
{
    global $db;

    $query = "SELECT users.* FROM follow_list 
              JOIN users ON follow_list.follower_id = users.id 
              WHERE follow_list.user_id = '$user_id'";
    $result = mysqli_query($db, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getFollowingList($user_id)
{
    global $db;

    $query = "SELECT users.* FROM follow_list 
              JOIN users ON follow_list.user_id = users.id 
              WHERE follow_list.follower_id = '$user_id'";
    $result = mysqli_query($db, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function checkLike($post_id, $user_id = null)
{
    global $db;

    if (!$user_id && isset($_SESSION['user']['id'])) {
        $user_id = $_SESSION['user']['id'];
    }

    $stmt = $db->prepare("SELECT COUNT(*) AS ROW FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return ['user' => $row];
}


function like($post_id)
{
    global $db;
    $user_id = $_SESSION['user']['id'];
    $query = "INSERT INTO `likes`(`post_id`, `user_id`) VALUES ('$post_id','$user_id')";
    return mysqli_query($db, $query);
}

function unlike($post_id)
{
    global $db;
    $user_id = $_SESSION['user']['id'];
    $query = "DELETE FROM `likes` WHERE user_id = '$user_id' AND post_id = '$post_id'";
    return mysqli_query($db, $query);
}
