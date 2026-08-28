<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - SDCA OJT Tracker</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/sdcalogoorig.png'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container" style="max-width: 400px;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-2">Reset Password</h4>
                <p class="text-muted small text-center mb-4">Verify your email before creating a new password.</p>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger p-2 text-center small"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success p-2 text-center small"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <form action="<?php echo base_url('auth/send_reset_code'); ?>" method="POST" class="mb-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Account Email</label>
                        <input type="email" name="email" class="form-control" required placeholder="Enter your registered email">
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Send Verification Code</button>
                </form>

                <?php if (!empty($reset_requested)): ?>
                    <hr>
                    <form action="<?php echo base_url('auth/reset_password_process'); ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Verification Code</label>
                            <input type="text" name="verification_code" class="form-control" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required placeholder="Enter the 6-digit code">
                            <div class="form-text">The code expires after 10 minutes.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="new_password" class="form-control" required placeholder="Enter a strong password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" required placeholder="Repeat your new password">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Update Password</button>
                    </form>
                <?php endif; ?>

                    <div class="text-center mt-3">
                        <a href="<?php echo base_url('login'); ?>" class="text-decoration-none small">Back to Login</a>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>