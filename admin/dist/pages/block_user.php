<?php
// Include database connection
include('db_connection.php');

// Start the session with 'admin_session' as session name
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
        echo "<p>Profile updated successfully.</p>";
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

<!-- Edit Profile Form -->
<div class="container">
    <h2>Edit Profile</h2>
    <form action="edit-profile.php" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password (Leave empty to keep current password):</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
