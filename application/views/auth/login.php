<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - SDCA Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/favicon.png'); ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    /* Custom Navbar Color (#8b0000 or #800000) */
    .btn-navbar-theme {
        background-color: #8b0000 !important;
        border-color: #8b0000 !important;
        color: #ffffff !important;
        transition: all 0.2s ease;
    }

/* Hover effect */
    .btn-navbar-theme:hover {
        background-color: #6b0000 !important;
        border-color: #6b0000 !important;
    }
</style>
<body class="bg-light d-flex align-items-center vh-100">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <h4 class="fw-bold mb-3">Admin Login</h4>
                    
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger py-2 small"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/login_process'); ?>" method="POST">
                        <div class="mb-3 text-start">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" id="passwordInput" name="password" class="form-control" required placeholder="Enter your password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn">
                                    <i class="fa-solid fa-eye" id="toggleEyeIcon"></i>
                                </button>
                            </div>
                        </div>
                        <a href="<?php echo base_url('auth/forgot_password'); ?>" class="text-decoration-none small text-danger">
                        Forgot Password?
                        </a>
                        <button type="submit" class="btn btn-navbar-theme w-100 py-2 text-white fw-bold">Sign In</button>
                        <a href="<?= base_url(); ?>" class="btn btn-link text-decoration-none text-muted small mt-2">Back to Website</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePasswordBtn').addEventListener('click', function () {
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('toggleEyeIcon');

        // Toggle the input type between password and text
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>

</body>
</html>