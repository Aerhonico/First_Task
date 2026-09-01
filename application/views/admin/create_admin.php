<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin Account - SDCA OJT Tracker</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/sdcalogoorig.png'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body, html { height: 100%; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; background-color: #f8f9fa; }

        .wrapper { display: flex; min-height: 100vh; }

        .sidebar {
            width: 250px;
            background-color: #8b0000;
            color: white;
            padding: 2rem 1rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar h5 { margin-bottom: 2rem; font-weight: bold; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 0.5rem; }
        .sidebar a:hover { background-color: rgba(255, 255, 255, 0.1); }

        .main-content { margin-left: 250px; flex: 1; padding: 2rem; }

        .card { box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); border: none; }

        .btn-sdca { background-color: #8b0000; color: white; border: none; }
        .btn-sdca:hover { background-color: #6a0000; color: white; }

        .password-reqs {
            font-size: 0.78rem;
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 8px 12px;
            border: 1px solid #e9ecef;
        }

        .req-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .req-item i {
            font-size: 0.5rem;
            margin-right: 0.5rem;
        }

        .req-item span {
            font-size: 0.75rem;
        }

        @media (max-width: 991px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            .sidebar a { display: inline-block; width: 48%; margin-right: 2%; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <!-- SIDEBAR NAVIGATION -->
    <div class="sidebar">
        <h5><i class="bi bi-shield-lock"></i> Admin Panel</h5>
        <a href="<?= base_url('admin'); ?>"><i class="bi bi-house"></i> Dashboard</a>
        <a href="<?= base_url('admin/create_admin'); ?>" class="active" style="background-color: rgba(255, 255, 255, 0.2);"><i class="bi bi-person-plus"></i> Create Admin</a>
        <a href="<?= base_url('auth/logout'); ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h2 class="fw-bold text-dark">Create New Admin Account</h2>
                <p class="text-muted">Add a new administrator to the system</p>
            </div>

            <!-- ALERT MESSAGES -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle"></i> <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- CREATE ADMIN FORM -->
            <div class="card">
                <div class="card-body p-4">
                    <form action="<?= base_url('admin/create_admin_process'); ?>" method="POST">

                        <!-- Name Row -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">First Name *</label>
                                <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Last Name *</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                            </div>
                        </div>

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Email Address *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                            </div>
                        </div>

                        <!-- Username Input -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Username *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Password *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" name="password" id="adminPassword" class="form-control" placeholder="••••••••" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleAdminPassword">
                                    <i class="bi bi-eye" id="toggleAdminIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Password Requirements List with Real-time Feedback -->
                        <div class="password-reqs text-secondary mb-4">
                            <div class="fw-semibold mb-2 text-dark" style="font-size: 0.8rem;">Password must contain:</div>
                            <div>
                                <div class="req-item" id="req-length">
                                    <i class="bi bi-circle-fill" style="color: #dc3545;"></i>
                                    <span>At least 8 characters long</span>
                                </div>
                                <div class="req-item" id="req-uppercase">
                                    <i class="bi bi-circle-fill" style="color: #dc3545;"></i>
                                    <span>At least one uppercase letter (A-Z)</span>
                                </div>
                                <div class="req-item" id="req-lowercase">
                                    <i class="bi bi-circle-fill" style="color: #dc3545;"></i>
                                    <span>At least one lowercase letter (a-z)</span>
                                </div>
                                <div class="req-item" id="req-number">
                                    <i class="bi bi-circle-fill" style="color: #dc3545;"></i>
                                    <span>At least one number (0-9)</span>
                                </div>
                                <div class="req-item" id="req-special">
                                    <i class="bi bi-circle-fill" style="color: #dc3545;"></i>
                                    <span>At least one special character (@, $, !, %, *, ?, &)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-sdca fw-bold py-2 px-4" id="submitBtn" disabled>
                                Create Admin Account
                            </button>
                            <a href="<?= base_url('admin'); ?>" class="btn btn-outline-secondary fw-bold py-2 px-4">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const toggleBtn = document.getElementById('toggleAdminPassword');
    const passwordInput = document.getElementById('adminPassword');
    const toggleIcon = document.getElementById('toggleAdminIcon');
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
