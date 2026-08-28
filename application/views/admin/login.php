<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal Login</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/sdcalogoorig.png'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .login-wrapper { display: flex; min-height: 100vh; width: 100vw; }
        .left-panel { flex: 1.4; position: relative; background: #8b0000; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .left-panel::before { content: ''; position: absolute; inset: 0; background-image: url('<?= base_url("assets/images/sdcabuilding.jpg"); ?>'); background-size: cover; background-position: center; opacity: 0.5; }
        .right-panel { flex: 0.8; background: #fff; display: flex; align-items: center; justify-content: center; padding: 2.5rem; }
        .admin-login { width: 100%; max-width: 420px; }
        .sdca-logo { max-width: 150px; height: auto; margin-bottom: 0.5rem; }
        .btn-sdca { background: #800000; color: #fff; }
        .btn-sdca:hover { background: #600000; color: #fff; }
        @media (max-width: 991px) { .left-panel { display: none; } .right-panel { flex: 1; } }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="left-panel"></div>
    <div class="right-panel">
        <main class="admin-login text-center">
            <img src="<?= base_url('assets/images/sdcalogo.png'); ?>" alt="SDCA Logo" class="sdca-logo img-fluid">
            <h4 class="fw-bold text-dark mb-1">Admin Portal Login</h4>
            <p class="text-muted small mb-4">Sign in to manage interns and portfolio content</p>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger p-2 small text-center mb-3"><?= html_escape($this->session->flashdata('error')); ?></div>
                <?php endif; ?>
                <form action="<?= base_url('auth/login_process'); ?>" method="POST" class="text-start">
                    <input type="hidden" name="portal" value="admin">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-secondary">Admin Username or Email</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter admin username or email" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-secondary">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="adminPasswordInput" class="form-control" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleAdminPassword" aria-label="Show or hide admin password">
                                <i class="bi bi-eye" id="toggleAdminPasswordIcon"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sdca w-100 fw-bold py-2">Sign In to Admin Portal</button>
                </form>
                <a href="<?= base_url('login'); ?>" class="d-block text-center mt-3 small text-muted">Back to Intern Login</a>
        </main>
    </div>
</div>
<script>
    const adminPasswordInput = document.getElementById('adminPasswordInput');
    const toggleAdminPassword = document.getElementById('toggleAdminPassword');
    const toggleAdminPasswordIcon = document.getElementById('toggleAdminPasswordIcon');

    toggleAdminPassword.addEventListener('click', function () {
        const isPassword = adminPasswordInput.type === 'password';
        adminPasswordInput.type = isPassword ? 'text' : 'password';
        toggleAdminPasswordIcon.classList.toggle('bi-eye', !isPassword);
        toggleAdminPasswordIcon.classList.toggle('bi-eye-slash', isPassword);
    });
</script>
</body>
</html>
