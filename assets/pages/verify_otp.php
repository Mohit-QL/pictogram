<div class="login">
    <div class="col-4 bg-white border rounded p-4 shadow-sm">
        <form method="POST" action="assets/php/actions.php?verify_otp">
            <h1 class="h5 mb-3 fw-normal">Enter 6-Digit Verification Code</h1>
            <div class="form-floating">
                <input type="text" class="form-control rounded-0" name="otp" placeholder="######" required>
                <label for="floatingInput">6-digit Code</label>
            </div>

            <div class="form-floating mt-1">
                <input type="password" class="form-control rounded-0" name="new_password" placeholder="New Password" required>
                <label for="floatingPassword">New Password</label>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit">Reset Password</button>
                <a href="?login" class="text-decoration-none">Back to Login</a>
            </div>

            <?php if (isset($_SESSION['error']['msg'])): ?>
                <div class="alert alert-danger mt-2">
                    <?php echo $_SESSION['error']['msg']; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>