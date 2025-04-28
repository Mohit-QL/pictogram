<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
file_put_contents('session_debug.log', print_r($_SESSION, true), FILE_APPEND);


if (session_status() === PHP_SESSION_NONE) {
    session_name('admin_session');
    session_start();
}

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ./admin_login.php');
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'pictogram_2');

$count_query = "SELECT COUNT(*) AS total_users FROM users";
$count_result = mysqli_query($conn, $count_query);

if (!$count_result) {
    die('Error executing count query: ' . mysqli_error($conn));
}

$count_row = mysqli_fetch_assoc($count_result);
$total_users = $count_row['total_users'];

$sql = "SELECT id, first_name, last_name, email, profile_pic, username, ac_status FROM users";
$result = mysqli_query($conn, $sql);

if (isset($_GET['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
}

if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}

echo '<h2>User List</h2>';
echo '<table class="table table-bordered">';
echo '<thead><tr>';
echo '  <th class="p-3">ID</th>';
echo '  <th class="p-3">Name</th>';
echo '  <th class="p-3">Email</th>';
echo '  <th class="p-3 text-center">Profile Pic</th>';
echo '  <th class="p-3">Username</th>';
echo '  <th class="p-3 text-center">Actions</th>';
echo '</tr></thead><tbody>';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['id'];
        $fname = $row['first_name'];
        $lname = $row['last_name'];
        $email = $row['email'];
        $profile_pic = $row['profile_pic'];
        $username = $row['username'];
        $account_status = $row['ac_status'];

        echo '<tr>';
        echo '<td class="p-3">' . $user_id . '</td>';
        echo '<td class="p-3">' . $fname . ' ' . $lname . '</td>';
        echo '<td class="p-3">' . $email . '</td>';
        echo '<td class="p-3 text-center"><img src="/pictogram/assets/images/Profile/' . $profile_pic . '" alt="Profile Picture" width="50" height="50" class="rounded-circle" style="object-fit:cover"></td>';
        echo '<td class="p-3">' . $username . '</td>';
        echo '<td class="p-3 text-center">';
        echo '<a href="./loginAsAdmin.php?user_id=' . $user_id . '" class="btn btn-primary me-3">Login User</a>';

        if ($account_status != 2) {
            echo '<button class="btn btn-danger block-btn px-4" data-user-id="' . $user_id . '">Block</button>';
        } else {
            echo '<button class="btn btn-success unblock-btn px-4" data-user-id="' . $user_id . '">Unblock</button>';
        }

        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">No users found.</td></tr>';
}

echo '</tbody></table>';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.block-btn, .unblock-btn', function() {
        var user_id = $(this).data('user-id');
        var action = $(this).hasClass('block-btn') ? 'block' : 'unblock';
        var button = $(this);

        $.ajax({
            url: 'block_user.php',
            type: 'POST',
            data: {
                action: action,
                blocked_user_id: user_id
            },
            success: function(response) {
                if (response === 'success') {
                    if (action === 'block') {
                        button.text('Unblock').removeClass('btn-danger').addClass('btn-success');
                    } else {
                        button.text('Block').removeClass('btn-success').addClass('btn-danger');
                    }
                } else {
                    alert('Error: ' + response);
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX Error: ' + error);
            }
        });
    });
</script>