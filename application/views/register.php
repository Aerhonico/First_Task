<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Registration - SDCA OJT Tracker</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/sdcalogoorig.png'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body, html { height: 100%; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }

        .login-wrapper { display: flex; min-height: 100vh; width: 100vw; }

        .left-panel {
            flex: 1.4;
            position: relative;
            background-color: #8b0000;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('<?= base_url("assets/images/sdcabuilding.jpg"); ?>');
            background-size: cover;
            background-position: center;
            opacity: 0.5;
            z-index: 1;
        }

        .left-panel-content { position: relative; z-index: 2; color: #ffffff; text-align: center; padding: 2rem; }

        .right-panel {
            flex: 0.8;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 2.5rem;
            overflow-y: auto;
        }

        .login-card { width: 100%; max-width: 420px; }
        .sdca-logo { max-width: 150px; height: auto; margin-bottom: 0.5rem; }

        .btn-sdca { background-color: #8b0000; color: #ffffff; border: none; }
        .btn-sdca:hover { background-color: #6a0000; color: #ffffff; }

        .password-reqs {
            font-size: 0.78rem;
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 8px 12px;
            border: 1px solid #e9ecef;
        }

        @media (max-width: 991px) {
            .left-panel { display: none; }
            .right-panel { flex: 1; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- LEFT SIDE: SDCA Building Image -->
    <div class="left-panel">
        <div class="left-panel-content">
        </div>
    </div>

    <!-- RIGHT SIDE: Registration Form -->
    <div class="right-panel">
        <div class="login-card text-center">

            <img src="<?= base_url('assets/images/sdcalogo.png'); ?>" alt="SDCA Logo" class="sdca-logo img-fluid">

            <h4 class="fw-bold text-dark mb-1">Create Intern Account</h4>
            <p class="text-muted small mb-3">Fill in your details to get started</p>

            <!-- ALERT MESSAGES -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger p-2 small text-center mb-3" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/register_process'); ?>" method="POST" class="text-start">
                
                <!-- Name Row (First, Middle, Last) -->
                <div class="row g-2 mb-2">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold small text-secondary">First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" required autofocus>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small text-secondary">M.I.</label>
                        <input type="text" name="middle_name" class="form-control" placeholder="M.I." maxlength="2">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold small text-secondary">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                    </div>
                </div>

                <!-- Email Input -->
                <div class="mb-2">
                    <label class="form-label fw-semibold small text-secondary">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-2">
                    <label class="form-label fw-semibold small text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" id="regPassword" class="form-control" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleRegPassword">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Password Requirements List with Real-time Feedback -->
                <div class="password-reqs text-secondary mb-3">
                    <div class="fw-semibold mb-2 text-dark" style="font-size: 0.8rem;">Password must contain:</div>
                    <div class="ps-2">
                        <div class="mb-1 d-flex align-items-center" id="req-length">
                            <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; color: #dc3545;"></i>
                            <span style="font-size: 0.75rem;">At least 8 characters long</span>
                        </div>
                        <div class="mb-1 d-flex align-items-center" id="req-uppercase">
                            <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; color: #dc3545;"></i>
                            <span style="font-size: 0.75rem;">At least one uppercase letter (A-Z)</span>
                        </div>
                        <div class="mb-1 d-flex align-items-center" id="req-lowercase">
                            <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; color: #dc3545;"></i>
                            <span style="font-size: 0.75rem;">At least one lowercase letter (a-z)</span>
                        </div>
                        <div class="mb-1 d-flex align-items-center" id="req-number">
                            <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; color: #dc3545;"></i>
                            <span style="font-size: 0.75rem;">At least one number (0-9)</span>
                        </div>
                        <div class="d-flex align-items-center" id="req-special">
                            <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; color: #dc3545;"></i>
                            <span style="font-size: 0.75rem;">At least one special character (@, $, !, %, *, ?, &)</span>
                        </div>
                    </div>
                </div>

                <!-- Register Submit Button -->
                <button type="submit" class="btn btn-sdca w-100 fw-bold py-2 mb-3" id="submitBtn" disabled>
                    Complete Registration
                </button>

                <div class="text-center d-flex flex-column gap-2">
                    <a href="<?= base_url('auth/login'); ?>" class="text-muted text-decoration-underline small">
                        Already have an account? Sign In
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
    const toggleBtn = document.getElementById('toggleRegPassword');
    const passwordInput = document.getElementById('regPassword');
    const toggleIcon = document.getElementById('toggleIcon');
    const submitBtn = document.getElementById('submitBtn');

    // Password validation requirements
    const requirements = {
        length: { regex: /.{8,}/, element: document.getElementById('req-length') },
        uppercase: { regex: /[A-Z]/, element: document.getElementById('req-uppercase') },
        lowercase: { regex: /[a-z]/, element: document.getElementById('req-lowercase') },
        number: { regex: /[0-9]/, element: document.getElementById('req-number') },
        special: { regex: /[@$!%*?&]/, element: document.getElementById('req-special') }
    };

    // Function to validate a single requirement
    function validateRequirement(regex, value) {
        return regex.test(value);
    }

    // Function to update requirement indicator
    function updateRequirementIndicator(requirement, isMet) {
        const icon = requirement.element.querySelector('i');
        const span = requirement.element.querySelector('span');
        
        if (isMet) {
            icon.classList.remove('bi-circle-fill');
            icon.classList.add('bi-check-circle-fill');
            icon.style.color = '#28a745';
            span.classList.add('text-success', 'fw-semibold');
            span.classList.remove('text-secondary');
        } else {
            icon.classList.remove('bi-check-circle-fill');
            icon.classList.add('bi-circle-fill');
            icon.style.color = '#dc3545';
            span.classList.remove('text-success', 'fw-semibold');
            span.classList.add('text-secondary');
        }
    }

    // Function to check all requirements
    function checkAllRequirements(password) {
        let allMet = true;
        
        for (const [key, requirement] of Object.entries(requirements)) {
            const isMet = validateRequirement(requirement.regex, password);
            updateRequirementIndicator(requirement, isMet);
            
            if (!isMet) {
                allMet = false;
            }
        }
        
        return allMet;
    }

    // Add event listener to password input
    passwordInput.addEventListener('input', function () {
        const allRequirementsMet = checkAllRequirements(this.value);
        submitBtn.disabled = !allRequirementsMet;
    });

    // Toggle password visibility
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