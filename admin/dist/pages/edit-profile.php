<?php
const DB_NAME = 'pictogram_2';
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

session_name('admin_session');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the admin ID from the session
$admin_id = $_SESSION['admin_id'];

// If the form is submitted, update the profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['admin_name']= $name;

    // Hash the password if it was provided
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE admins SET name = '$name', email = '$email', password = '$hashed_password' WHERE admin_id = $admin_id";
    } else {
        // If no new password, update only name and email
        $query = "UPDATE admins SET name = '$name', email = '$email' WHERE admin_id = $admin_id";
    }

    // Execute the update query
    if (mysqli_query($conn, $query)) {
        // Redirect to index.php after successful update
        header("Location: index.php");
        exit();
    } else {
        echo "<p>Error updating profile: " . mysqli_error($conn) . "</p>";
    }
}

// Query to get the admin details
$query = "SELECT * FROM admins WHERE admin_id = $admin_id";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/pictogram/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/pictogram/assets/bootstrap/icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/pictogram/assets/css/custom.css" rel="stylesheet">
    <link rel="icon" href="assets/images/icon.png">
    <title>Edit Profile</title>
</head>

<body>

    <!-- Edit Profile Form -->
    <div class="container d-flex justify-content-center" style="margin-top: 200px;">
        <div class="col-sm-12 col-md-6 bg-white border rounded p-4 shadow-sm">
            <h2>Edit Profile</h2>
            <form action="edit-profile.php" method="POST">
                <div class="form-group">
                    <label for="name" class="pb-2">Name:</label>
                    <input type="text" class="form-control mb-3" id="name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email" class="pb-2">Email:</label>
                    <input type="email" class="form-control mb-3" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                </div>
                <div class="form-group" class="pb-2">
                    <label for="password">Password (Leave empty to keep current password):</label>
                    <input type="password" class="form-control mb-3" id="password" name="password">
                </div>
                <div class="d-flex align-items-center mt-3">
                    <button type="submit" class="btn btn-primary me-3">Update Profile</button> 
                    <a href="index.php" class="btn btn-link-secondary">Back to Home</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>