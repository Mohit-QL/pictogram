<?php
global $user;
$name = $user['first_name'] . ' ' . $user['last_name'];

?>
<div class="login">
    <div class="col-4 bg-white border rounded p-4 shadow-sm">
        <form>
            <div class="d-flex justify-content-center">

                <img class="mb-4" src="assets/images/pictogram.png" alt="" height="45">
            </div>
            <h1 class="h5 mb-3 fw-normal">Hello, <?php echo $name ?> Your Account Is Blocked By Admin</h1>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <a href="assets/php/actions.php?logout" class="btn btn-danger" type="submit">Logout</a href="assets/php/actions.php?logout">



            </div>

        </form>
    </div>
</div>