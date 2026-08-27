<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SDCA OJT Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body, html {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Split Screen Container */
        .login-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100vw;
        }

        /* Left Panel - Building Image & Overlay */
        .left-panel {
            flex: 1;
            position: relative;
            background-color: #8b0000; /* SDCA Red background */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?= base_url("assets/images/sdcabuilding.jpg"); ?>');
            background-size: cover;
            background-position: center;
            opacity: 0.5; /* 50% Opacity */
            z-index: 1;
        }

        /* Left Panel - Expand to take up more space */
        .left-panel {
            flex: 1.4; /* Expanded from 1 to give the image more room */
            position: relative;
            background-color: #8b0000;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Right Panel - Narrower width & sharp vertical divider */
        .right-panel {
            flex: 0.8; /* Reduced from 1 to narrow the login side */
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            position: relative;
        }

        /* Remove curved edges and negative margin completely */
        @media (min-width: 992px) {
            .right-panel {
                border-top-left-radius: 0 !important;
                border-bottom-left-radius: 0 !important;
                margin-left: 0 !important;
                z-index: 3;
            }
        }

        /* Login Box Styling */
        .login-card {
            width: 100%;
            max-width: 400px;
        }

        .sdca-logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 1rem;
        }

        /* SDCA Red Buttons */
        .btn-sdca {
            background-color: #8b0000;
            color: #ffffff;
            border: none;
            transition: background 0.2s ease-in-out;
        }

        .btn-sdca:hover {
            background-color: #6a0000;
            color: #ffffff;
        }

        .btn-outline-sdca {
            color: #8b0000;
            border-color: #8b0000;
        }

        .btn-outline-sdca:hover {
            background-color: #8b0000;
            color: #ffffff;
        }

        /* Mobile View Adjustments */
        @media (max-width: 991px) {
            .left-panel {
                display: none; /* Hides image side on small phones for readability */
            }
            .right-panel {
                flex: 1;
                border-radius: 0;
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- LEFT SIDE: SDCA Building Image (50% Opacity) -->
    <div class="left-panel">
        <div class="left-panel-content">
            <p class="lead">St. Dominic College of Asia</p>
        </div>
    </div>

    <!-- RIGHT SIDE: Login Form -->
    <div class="right-panel">
        <div class="login-card text-center">

            <!-- SDCA LOGO ON TOP OF BOX -->
            <img src="<?= base_url('assets/images/sdcalogo.png'); ?>" alt="SDCA Logo" class="sdca-logo img-fluid">

            <h4 class="fw-bold text-dark mb-1">Welcome Intern!</h4>
            <p class="text-muted small mb-4">Please enter your credentials to log in</p>

            <!-- ALERT MESSAGES -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger p-2 small text-center mb-3" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success p-2 small text-center mb-3" role="alert">
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login_process'); ?>" method="POST" class="text-start">
                
                <!-- Username Input -->
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Enter your Email" required autofocus>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Forgot Password Link -->
                <div class="text-end mb-3">
                    <a href="#" class="text-danger text-decoration-none small">Forgot Password?</a>
                </div>

                <!-- Sign In Button -->
                <button type="submit" class="btn btn-sdca w-100 fw-bold py-2 mb-3">
                    Sign In
                </button>

                <div class="text-center d-flex flex-column gap-2">
                    <a href="<?= base_url(); ?>" class="text-muted text-decoration-none small">Back to Website</a>
                    
                    <hr class="my-2 text-muted">
                    
                    <!-- INTERN REGISTRATION BUTTON -->
                    <a href="<?= base_url('auth/register'); ?>" class="btn btn-outline-sdca btn-sm fw-bold py-2">
                        <i class="bi bi-person-plus me-1"></i> Register as Intern
                    </a>

                    <!-- ADMIN PORTAL ACCESS -->
                    <a href="<?= base_url('auth/admin_login'); ?>" class="btn btn-outline-dark btn-sm fw-bold py-2">
                        <i class="bi bi-shield-lock me-1"></i> Admin Portal Login
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
    // Toggle Password Visibility
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('passwordInput');
    const toggleIcon = document.getElementById('toggleIcon');

    toggleBtn.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>