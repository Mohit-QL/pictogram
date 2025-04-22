<div class="login">
    <div class="col-4 bg-white border rounded p-4 shadow-sm">
        <?php
        $action = "forgot_password";

        if (isset($_SESSION['forgot_code']) && !isset($_SESSION['auth_temp'])) {
            $action = "verify_code";
        } elseif (isset($_SESSION['auth_temp'])) {
            $action = "change_password";
        }
        ?>
        <form method="POST" action="assets/php/actions.php?<?= $action ?>">
           
            <h1 class="h5 mb-3 fw-normal">Forgot Your Password ?</h1>

            <?php if ($action == 'forgot_password') { ?>
                <div class="form-floating">
                    <input type="email" class="form-control rounded-0" placeholder="Enter Your Email" name="email">
                    <label for="floatingInput">Email</label>
                    <?= showError('email'); ?>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary" type="submit">Send Verification Code</button>
                    </div>
                </div>
            <?php } ?>

            <?php if ($action == 'verify_code') { ?>
                <p>Enter 6 Digit Code Sent to <?= htmlspecialchars($_SESSION['forgot_email']) ?></p>
                <div class="form-floating">
                    <input type="text" class="form-control rounded-0" id="floatingPassword" placeholder="Password" name="code">
                    <label for="floatingPassword">######</label>
                    <?= showError('email_verify'); ?>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary" type="submit">Verify Code</button>
                    </div>
                </div>
            <?php } ?>

            <?php if ($action == 'change_password') { ?>
                <div class="form-floating">
                    <input type="password" class="form-control rounded-0" id="floatingPassword" placeholder="New Password" name="password">
                    <label for="floatingPassword">New Password</label>
                    <?= showError('password'); ?>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary" type="submit">Change Password</button>
                    </div>
                </div>
            <?php } ?>



            <br>
            <a href="?login" class="text-decoration-none mt-5"><i class="bi bi-arrow-left-circle-fill"></i> Go Back To Login</a>
        </form>
    </div>
</div>