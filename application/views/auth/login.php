<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - SDCA Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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
                        <div class="mb-3 text-start">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 fw-bold">Sign In</button>
                        <a href="<?= base_url(); ?>" class="btn btn-link text-decoration-none text-muted small mt-2">Back to Website</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>