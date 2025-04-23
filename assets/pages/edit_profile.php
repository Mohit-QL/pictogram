<?php
global $user;
$name = $user['first_name'] . ' ' . $user['last_name'];

?>
<div class="container col-9 rounded-0 d-flex justify-content-between">
    <div class="col-12 bg-white border rounded p-4 mt-4 shadow-sm">


        <form method="POST" action="assets/php/actions.php?update_profile" enctype="multipart/form-data">


         

            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-3 fw-normal">Edit Profile</h1>
                <?php
                if (isset($_SESSION['success'])) {
                    echo "
                            <div class='alert alert-success alert-dismissible fade show mb-3 w-50' role='alert' id='successAlert'>
                                " . $_SESSION['success'] . "
                            </div>";
                    unset($_SESSION['success']);
                }

                if (isset($_SESSION['error'])) {
                    echo "
                            <div class='alert alert-danger alert-dismissible fade show mb-3 w-50' role='alert' id='errorAlert'>
                                " . $_SESSION['error'] . "
                            </div>";
                    unset($_SESSION['error']);
                }
                ?>
            </div>

            <div class="form-floating mt-1 col-6">
                <img src="assets/images/Profile/<?php echo $user['profile_pic'] ?>" class="img-thumbnail my-3" style="height:150px;" alt="...">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Change Profile Picture</label>
                    <input class="form-control" type="file" id="formFile" name="profile_pic">
                    <?= showError('profile_pic'); ?>
                </div>
            </div>
            <div class="d-flex">
                <div class="form-floating mt-1 col-6 ">
                    <input type="text" class="form-control rounded-0" placeholder="username/email" name="first_name" value="<?php echo $user['first_name'] ?>">
                    <label for="floatingInput">first name</label>
                    <?= showError('first_name'); ?>
                </div>
                <div class="form-floating mt-1 col-6">
                    <input type="text" class="form-control rounded-0" placeholder="username/email" name="last_name" value="<?php echo $user['last_name'] ?>">
                    <label for="floatingInput">last name</label>
                    <?= showError('last_name'); ?>
                </div>
            </div>

            <div class="d-flex gap-3 my-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                        value="option1" <?php echo $user['gender'] == 0 ? 'checked' : '' ?> disabled>
                    <label class="form-check-label" for="exampleRadios1">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                        value="option2" <?php echo $user['gender'] == 1 ? 'checked' : '' ?> disabled>
                    <label class="form-check-label" for="exampleRadios3">
                        Female
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                        value="option2" <?php echo $user['gender'] == 2 ? 'checked' : '' ?> disabled>
                    <label class="form-check-label" for="exampleRadios2">
                        Other
                    </label>
                </div>
            </div>
            <div class="form-floating mt-1">
                <input type="email" class="form-control rounded-0" placeholder="username/email" name="email" value="<?php echo $user['email'] ?>" disabled>
                <label for="floatingInput">email</label>
            </div>
            <div class="form-floating mt-1">
                <input type="text" class="form-control rounded-0" placeholder="username/email" name="username" value="<?php echo $user['username'] ?>">
                <label for="floatingInput">username</label>
                <?= showError('username'); ?>
            </div>
            <div class="form-floating mt-1">
                <input type="text" class="form-control rounded-0" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">New Password</label>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit">Update Profile</button>



            </div>

        </form>
    </div>

</div>
<script>
    setTimeout(function() {
        var successAlert = document.getElementById('successAlert');
        var errorAlert = document.getElementById('errorAlert');

        if (successAlert) {
            successAlert.classList.remove('show');
            successAlert.classList.add('fade');
        }

        if (errorAlert) {
            errorAlert.classList.remove('show');
            errorAlert.classList.add('fade');
        }
    }, 2000); // 2000 milliseconds = 2 seconds
</script>