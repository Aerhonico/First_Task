<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container" style="max-width: 400px;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-3">Reset Password</h4>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger p-2 text-center small"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <form action="<?php echo base_url('auth/reset_password_process'); ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required placeholder="Enter your username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required placeholder="Enter new password">
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Update Password</button>
                    <div class="text-center mt-3">
                        <a href="<?php echo base_url('login'); ?>" class="text-decoration-none small">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>