<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SDCA OJT Tracker</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/sdcalogoorig.png'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* Left Panel - Expand to take up more space */
        .left-panel {
            flex: 1.4;
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

        /* Right Panel - Narrower width & sharp vertical divider */
        .right-panel {
            flex: 0.8;
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
            background-color: #800000;
            color: #ffffff;
            border: none;
            transition: background 0.2s ease-in-out;
        }

        .btn-sdca:hover {
            background-color: #600000;
            color: #ffffff;
        }

        .bg-sdca {
            background-color: #800000 !important;
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

        /* Smooth entrance fade for the page */
        body {
            animation: pageFadeIn 0.5s ease-in-out forwards;
        }

        @keyframes pageFadeIn {
            from {
                opacity: 0;
                transform: translateY(8px); /* Subtle slide-up effect */
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- LEFT SIDE: SDCA Building Image (50% Opacity) -->
    <div class="left-panel">
        <div class="left-panel-content">
            <p class="lead text-white fw-bold"></p>
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
                <div id="loginAlert" class="alert alert-success p-2 small text-center mb-3" role="alert">
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php else: ?>
                <div id="loginAlert" class="alert alert-success p-2 small text-center mb-3 d-none" role="alert"></div>
            <?php endif; ?>

            <form id="mainLoginForm" action="<?= base_url('auth/login_process'); ?>" method="POST" class="text-start">
                <input type="hidden" name="portal" value="intern">
                
                <!-- Username Input -->
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Enter your email" required autofocus>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Forgot Password Link -->
                <div class="text-end mb-3">
                    <a href="#forgotPasswordModal" data-bs-toggle="modal" class="text-danger text-decoration-none small">Forgot Password?</a>
                </div>

                <!-- Sign In Button -->
                <button type="submit" class="btn btn-sdca w-100 fw-bold py-2 mb-3">
                    Sign In
                </button>

                <div class="text-center d-flex flex-column gap-2">
                    <hr class="my-2 text-muted">
                    
                    <!-- INTERN REGISTRATION BUTTON -->
                    <a href="<?= base_url('auth/register'); ?>" class="btn btn-outline-sdca btn-sm fw-bold py-2">
                        <i class="bi bi-person-plus me-1"></i> Register as Intern
                    </a>

                    <!-- ADMIN PORTAL ACCESS -->
                    <a href="<?= base_url('admin/dev_login'); ?>" class="btn btn-outline-dark btn-sm fw-bold py-2">
                        <i class="bi bi-shield-lock me-1"></i> Admin Portal Login
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

<!-- FORGOT PASSWORD MODAL -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-sdca text-white">
                <h5 class="modal-title" id="forgotPasswordModalLabel"><i class="bi bi-shield-lock me-2"></i>Reset Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="resetAlert" class="alert d-none p-2 small" role="alert"></div>
                <p class="text-muted small">Enter your registered email and we will send you a verification code.</p>

                <form id="requestCodeForm">
                    <div class="mb-3">
                        <label for="resetEmail" class="form-label fw-semibold">Account Email</label>
                        <input type="email" id="resetEmail" name="email" class="form-control" required placeholder="Enter your registered email">
                    </div>
                    <button type="submit" id="sendCodeButton" class="btn btn-sdca w-100">Send Verification Code</button>
                </form>

                <form id="resetPasswordForm" class="d-none mt-3">
                    <hr>
                    <div class="mb-3">
                        <label for="verificationCode" class="form-label fw-semibold">Verification Code</label>
                        <input type="text" id="verificationCode" name="verification_code" class="form-control" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required placeholder="Enter the 6-digit code">
                        <div class="form-text">The code expires after 10 minutes.</div>
                    </div>
                    <div class="mb-3">
                        <label for="resetNewPassword" class="form-label fw-semibold">New Password</label>
                        <div class="input-group">
                            <input type="password" id="resetNewPassword" name="new_password" class="form-control" required placeholder="Enter a strong password">
                            <button class="btn btn-outline-secondary" type="button" onclick="toggleResetPassword('resetNewPassword', 'resetNewPasswordIcon')" aria-label="Show or hide new password">
                                <i class="bi bi-eye" id="resetNewPasswordIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="resetConfirmPassword" class="form-label fw-semibold">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" id="resetConfirmPassword" name="confirm_password" class="form-control" required placeholder="Repeat your new password">
                            <button class="btn btn-outline-secondary" type="button" onclick="toggleResetPassword('resetConfirmPassword', 'resetConfirmPasswordIcon')" aria-label="Show or hide confirmed password">
                                <i class="bi bi-eye" id="resetConfirmPasswordIcon"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" id="resetPasswordButton" class="btn btn-success w-100">Update Password</button>
                </form>
            </div>
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

    // POST-LOGIN TRANSITION ANIMATION
    const mainLoginForm = document.getElementById('mainLoginForm');
    if (mainLoginForm) {
        mainLoginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Authenticating...',
                text: 'Loading your workspace',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                customClass: {
                    popup: 'rounded-0'
                }
            });

            setTimeout(() => {
                mainLoginForm.submit();
            }, 800);
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const resetModal = document.getElementById('forgotPasswordModal');
    const resetAlert = document.getElementById('resetAlert');
    const requestCodeForm = document.getElementById('requestCodeForm');
    const resetPasswordForm = document.getElementById('resetPasswordForm');

    function showResetAlert(message, type) {
        resetAlert.textContent = message;
        resetAlert.className = `alert alert-${type} p-2 small`;
    }

    function toggleResetPassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye', !isPassword);
        icon.classList.toggle('bi-eye-slash', isPassword);
    }

    requestCodeForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const button = document.getElementById('sendCodeButton');
        button.disabled = true;
        button.textContent = 'Sending...';

        fetch('<?= base_url('auth/send_reset_code'); ?>', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new FormData(requestCodeForm)
        })
        .then(response => response.json())
        .then(data => {
            showResetAlert(data.message, data.status === 'success' ? 'success' : 'danger');
            if (data.status === 'success') {
                resetPasswordForm.classList.remove('d-none');
            }
        })
        .catch(() => showResetAlert('Unable to send the verification code. Please try again.', 'danger'))
        .finally(() => {
            button.disabled = false;
            button.textContent = 'Send Verification Code';
        });
    });

    resetPasswordForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const button = document.getElementById('resetPasswordButton');
        button.disabled = true;
        button.textContent = 'Updating...';

        fetch('<?= base_url('auth/reset_password_process'); ?>', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new FormData(resetPasswordForm)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                bootstrap.Modal.getInstance(resetModal).hide();
                const loginAlert = document.getElementById('loginAlert');
                loginAlert.textContent = data.message;
                loginAlert.className = 'alert alert-success p-2 small text-center mb-3';
                requestCodeForm.reset();
                resetPasswordForm.reset();
                resetPasswordForm.classList.add('d-none');
            } else {
                showResetAlert(data.message, 'danger');
            }
        })
        .catch(() => showResetAlert('Unable to update the password. Please try again.', 'danger'))
        .finally(() => {
            button.disabled = false;
            button.textContent = 'Update Password';
        });
    });

    resetModal.addEventListener('hidden.bs.modal', function () {
        requestCodeForm.reset();
        resetPasswordForm.reset();
        resetPasswordForm.classList.add('d-none');
        resetAlert.className = 'alert d-none p-2 small';
        resetAlert.textContent = '';
    });
</script>
</body>
</html>