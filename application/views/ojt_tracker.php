<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'OJT Hours Tracker'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- FontAwesome Icons for Sidebar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap" rel="stylesheet">
<style>
    :root { 
        --sdca-red: #800000; 
        --sdca-gold: #FFD700; 
    }

    /* GLOBAL & ANIMATED BACKGROUND */
    body {
        background-color: #f4f6f9;
        background-image: 
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1000' height='1000' viewBox='0 0 1000 1000'%3E%3Cg stroke='%23800000' stroke-width='1.2' fill='none' opacity='0.12'%3E%3Cpolygon points='100,200 400,100 700,300 900,150'/%3E%3Cpolygon points='300,800 600,950 900,700'/%3E%3Cline x1='100' y1='200' x2='600' y2='950'/%3E%3Cline x1='400' y1='100' x2='900' y2='700'/%3E%3Cline x1='700' y1='300' x2='300' y2='800'/%3E%3Ccircle cx='400' cy='100' r='4' fill='%23800000'/%3E%3Ccircle cx='700' cy='300' r='4' fill='%23800000'/%3E%3Ccircle cx='300' cy='800' r='4' fill='%23800000'/%3E%3C/g%3E%3C/svg%3E");
        background-repeat: repeat;
        background-size: 800px 800px;
        animation: floatBackground 35s linear infinite;
        margin: 0;
        padding: 0;
        padding-top: 60px !important; /* Offset for fixed top navbar */
    }

    @keyframes floatBackground {
        0% { background-position: 0px 0px; }
        50% { background-position: 100px -150px; }
        100% { background-position: 0px 0px; }
    }

    /* APP LAYOUT STRUCTURE */
    .app-container { 
        display: flex; 
        min-height: 100vh; 
    }

    .main-content { 
        flex-grow: 1; 
        margin-left: 240px !important;
        background-color: transparent; 
    }

    .main-content .container-fluid {
        padding-top: 10px !important;
    }

    /* TOP NAVBAR */
/* Reduce Top Navbar Height to 48px */
.bg-sdca { 
    background-color: var(--sdca-red);
    position: fixed !important;
    top: 0 !important;
    left: 240px !important;
    width: calc(100vw - 240px) !important;
    height: 48px !important; /* Reduced from 60px */
    min-height: 48px !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    z-index: 1000 !important;
    border-radius: 0 !important;
    margin: 0 !important;
    display: flex !important;
    align-items: center !important; /* Centers navbar items vertically */
}

/* Adjust Body Padding to match the thinner height */
body {
    padding-top: 48px !important; /* Reduced from 60px */
}

/* Optional: Slim down inner navbar elements if Bootstrap adds extra padding */
.bg-sdca .container-fluid,
.bg-sdca .navbar-collapse,
.bg-sdca .nav-link,
.bg-sdca .btn {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    line-height: 48px !important;
}

    /* SIDEBAR (Starts at absolute top and covers left side of navbar) */
    .sidebar {
        width: 240px;
        height: 100vh !important; /* Stretch to absolute full height */
        position: fixed !important;
        top: 0 !important; /* Push all the way to the top */
        left: 0 !important;
        background-color: #ffffff !important;
        z-index: 99999 !important; /* HIGHEST LAYER: Sits above the red navbar */
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden;
    }

    /* Reset Body Padding since sidebar is now handling top 0 */
    body {
        padding-top: 60px !important;
    }

    /* Ensure Logo and Time Card inside Sidebar look clean at top 0 */
    .sidebar-brand-card {
        position: relative;
        transform: none !important; /* Removed negative transform */
        background-color: #ffffff;
        padding-top: 15px;
        z-index: 2;
    }

    .sidebar-menu { 
        list-style: none; 
        padding: 0; 
        margin: 10px 0 0 0 !important; 
        position: relative;
        z-index: 2;
    }

    /* Watermark Logo Background */
    .sidebar::before {
        content: "";
        position: absolute;
        top: 65%;
        left: 40%;
        transform: translate(-50%, -50%);
        width: 110%;
        height: 110%;
        background-image: url('<?= base_url("assets/images/sdcalogoorig.png"); ?>');
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        opacity: 0.30;
        pointer-events: none;
        z-index: 0;
    }

    /* SIDEBAR BRAND & CLOCK CARD */
    .sidebar-brand {
        border-bottom: 1px solid #f0f0f0 !important;
    }

    .sidebar-brand-card {
        position: relative;
        transform: translateY(-30px);
        background-color: #ffffff;
        border-radius: 6px;
        z-index: 1050;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18) !important;
    }

    .clock-box { 
        background: #1a1a1a; 
        color: #00ffcc; 
        border-radius: 8px; 
        font-family: monospace; 
        margin-top: -45px !important;
    }

    /* SIDEBAR NAVIGATION MENU */
    .sidebar-menu { 
        list-style: none; 
        padding: 0; 
        margin: -20px 0 0 0; 
        position: relative;
        z-index: 1;
    }

    .sidebar-menu li a {
        color: #495057 !important;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.92rem;
        border-left: 4px solid transparent;
        transition: all 0.2s ease-in-out;
    }

    .sidebar-menu li a i {
        width: 20px;
        text-align: center;
        color: #6c757d;
    }

    /* Menu Hover State */
    .sidebar-menu li a:hover {
        background-color: #f8f9fa;
        color: var(--sdca-red) !important;
    }

    .sidebar-menu li a:hover i {
        color: var(--sdca-red) !important;
    }

    /* Menu Active State */
    .sidebar-menu li.active a {
        background-color: #fff5f5 !important;
        color: var(--sdca-red) !important;
        border-left-color: var(--sdca-red);
        font-weight: 700;
    }

    .sidebar-menu li.active a i {
        color: var(--sdca-red) !important;
    }

    /* DROPDOWN MENU HOVER EFFECTS */
    .dropdown-menu .list-group-item-action:hover,
    .dropdown-menu .list-group-item-action:focus {
        background-color: #e2e8f0 !important;
        color: #1a202c !important;
    }

    .dropdown-menu .list-group-item-action.text-danger:hover {
        background-color: #fee2e2 !important;
        color: #dc3545 !important;
    }

        .nav-boxed-group {

        height: 100%;

        align-self: stretch;

    }

    .nav-boxed-btn {

        background-color: transparent !important;

        color: #ffffff !important;

        height: 100% !important;

        padding-top: 0 !important;

        padding-bottom: 0 !important;

        margin: 0 !important;

        border-radius: 0 !important;

        box-shadow: none !important;

        display: flex !important;

        align-items: center !important;

        transition: background-color 0.2s ease-in-out;

    }



    /* Dark background on hover */

    .nav-boxed-btn:hover,

    .nav-boxed-btn:focus,

    .nav-boxed-btn:active,

    .nav-boxed-btn.show {

        background-color: rgba(0, 0, 0, 0.35) !important;

        color: #ffffff !important;
    
    }

    /* Welcome Banner Styling */
    .welcome-banner {
        border: 1px solid #f0f0f0;
    }

    .quote-accent-line {
        width: 3px;
        height: 38px;
        background-color: #0f3d3e; /* Dark teal/forest green line from reference */
        border-radius: 2px;
    }

    .extra-small {
        font-size: 0.78rem;
    }

    .wave-emoji {
        display: inline-block;
        animation: wave 2s infinite transform-origin(70% 70%);
    }

    /* Optional subtle wave animation */
    @keyframes wave {
        0% { transform: rotate(0deg); }
        10% { transform: rotate(14deg); }
        20% { transform: rotate(-8deg); }
        30% { transform: rotate(14deg); }
        40% { transform: rotate(-4deg); }
        50% { transform: rotate(10deg); }
        60% { transform: rotate(0deg); }
        100% { transform: rotate(0deg); }
    }

    /* User Profile Navbar Formatting */
    .user-info-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Remove default Bootstrap dropdown arrow styling if you want a clean look */
    .dropdown-toggle::after {
        vertical-align: middle !important;
        margin-left: 0.4em !important;
    }

    /* Subtle background hover on the profile item */
    .dropdown-toggle:hover {
        background-color: rgba(255, 255, 255, 0.15) !important;
    }

    /* Darken profile toggle button on hover, focus, and open state without rounded corners */
    .bg-sdca .dropdown .dropdown-toggle:hover,
    .bg-sdca .dropdown .dropdown-toggle:focus,
    .bg-sdca .dropdown .dropdown-toggle.show {
        background-color: rgba(0, 0, 0, 0.25) !important; /* Dark overlay */
        color: #ffffff !important;
        border-radius: 0 !important; /* Removes the rounded corners */
        transition: background-color 0.2s ease-in-out;
    }

    .bg-sdca .dropdown .dropdown-toggle:focus {
        box-shadow: none !important;
    }

    /* Remove rounded corners from default, hover, focus, and open states */
    .bg-sdca .dropdown .dropdown-toggle,
    .bg-sdca .dropdown .dropdown-toggle:hover,
    .bg-sdca .dropdown .dropdown-toggle:focus,
    .bg-sdca .dropdown .dropdown-toggle.show {
        border-radius: 0 !important;
    }

    /* Maintain dark hover overlay */
    .bg-sdca .dropdown .dropdown-toggle:hover,
    .bg-sdca .dropdown .dropdown-toggle:focus,
    .bg-sdca .dropdown .dropdown-toggle.show {
        background-color: rgba(0, 0, 0, 0.25) !important;
        color: #ffffff !important;
        transition: background-color 0.2s ease-in-out;
    }

    .bg-sdca .dropdown .dropdown-toggle:focus {
        box-shadow: none !important;
    }

</style>
</head>
<body>

<div id="bg-canvas-container">
<div class="app-container">
 <!-- LEFT SIDEBAR PANEL -->
<aside class="sidebar shadow-sm">
    <!-- Brand Header with School Logo -->
<!-- Sidebar Brand with RareJob-style Live Clock -->
<div class="sidebar-brand p-3 text-center border-bottom">
    <a href="<?= base_url('ojt/' . $current_username); ?>">
        <img src="<?= base_url('assets/images/sdcalogo.png'); ?>" alt="SDCA Logo" class="img-fluid mb-2" style="max-height: 52px; width: auto;">
    </a>
    
    <!-- Divider Line -->
    <hr class="my-2 text-secondary opacity-25">
    
    <!-- Real-time Clock Widget -->
    <div class="sidebar-clock py-1">
        <div id="sidebarTime" class="text-dark fs-3 lh-1 mb-1" 
     style="font-family: 'Oswald', sans-serif; letter-spacing: 0.5px;">
    --:--:-- --
</div>
        <div id="sidebarDate" class="small text-muted fw-semibold" style="font-size: 0.78rem;">
            ----------------
        </div>
    </div>
</div>
    
    <ul class="sidebar-menu list-unstyled my-2">
        <li class="active">
            <a href="javascript:void(0);" onclick="loadMainView('dashboard', this)">
                <i class="fas fa-home"></i> 
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="loadMainView('analytics', this)">
                <i class="fas fa-chart-line"></i> 
                <span>Analytics & Goals</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="loadMainView('dtr', this)">
                <i class="fas fa-calendar-alt"></i> 
                <span>DTR Records & Filters</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="loadMainView('export', this)">
                <i class="fas fa-file-pdf"></i> 
                <span>Export DTR (PDF)</span>
            </a>
        </li>
    </ul>
</aside>

    <!-- RIGHT MAIN CONTENT AREA -->
    <main class="main-content">
        <!-- TOP NAVBAR -->
<!-- Reduced navbar height to 42px -->
<nav class="navbar navbar-dark bg-sdca p-0 mb-4 shadow-sm" style="min-height: 42px; height: 42px;">
    <div class="container-fluid px-4 pe-5 d-flex align-items-stretch justify-content-between h-100 p-0">
        
        <!-- Brand Logo/Title (compact text size) -->
        <a class="navbar-brand fw-bold d-flex align-items-center ms-2 m-0 p-0 h-100 fs-6" href="<?= base_url(); ?>">
            <i class="bi bi-clock-history me-2"></i>OJT Hours Tracker
        </a>

        <!-- COMPACT BUTTON GROUP WITH DARK BORDERS -->
        <div class="d-flex align-items-stretch h-100">
            <div class="d-flex align-items-stretch border-start border-end border-dark border-opacity-50 h-100">

                <!-- Notifications / Inbox Button -->
                <div class="dropdown d-flex align-items-stretch h-100">
                    <button class="nav-boxed-btn btn gap-2 px-3 border-0 border-end border-dark border-opacity-50 small" type="button" data-bs-toggle="dropdown">
                        <span class="badge bg-danger font-monospace">0</span>
                        <i class="bi bi-inbox-fill text-white opacity-75"></i>
                        <span class="fw-semibold">Inbox</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2" style="min-width: 240px;">
                        <li class="dropdown-header fw-bold text-uppercase">Notifications</li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="text-center text-muted small py-2">No new notifications</li>
                    </ul>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown d-flex align-items-center h-100">
                    <button class="btn dropdown-toggle d-flex align-items-center gap-2 px-3 border-0 bg-transparent text-white h-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- Icon / Avatar -->
                        <i class="bi bi-person-circle fs-4 text-white opacity-90"></i>
                        
                        <!-- Name & Subtitle Stack with better vertical line-height -->
                        <div class="text-start lh-sm">
                            <span class="d-block fw-bold text-white" style="font-size: 0.85rem; line-height: 1.1;">
                                <?php 
                                    $first = $this->session->userdata('first_name');
                                    $last = $this->session->userdata('last_name');
                                    echo ($first || $last) ? trim("$first $last") : 'Juan Dela Cruz'; 
                                ?>
                            </span>
                            <span class="d-block text-white-50" style="font-size: 0.70rem; line-height: 1; font-weight: 500; margin-top: 2px;">
                                OJT Student
                            </span>
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="dropdown-menu dropdown-menu-end shadow border-0 p-0 overflow-hidden" style="width: 280px;">
                        <div class="text-center p-3 bg-light border-bottom position-relative">
                            <i class="bi bi-person-circle display-5 text-dark d-block mb-1"></i>
                            <h6 class="fw-bold text-dark mb-0">
                                <?= $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?>
                            </h6>
                            <small class="text-muted d-block mb-1">INTERN ACCOUNT</small>
                            <div class="badge bg-white text-dark border"><i class="bi bi-envelope me-1"></i><?= $this->session->userdata('email'); ?></div>
                        </div>

                        <div class="list-group list-group-flush small">
                        <a href="<?= base_url('profile/email'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2 text-dark">
                            <i class="bi bi-envelope-fill text-dark fs-6"></i> Update Email
                        </a>
                        <a href="<?= base_url('profile/password'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2 text-dark">
                            <i class="bi bi-key-fill text-dark fs-6"></i> Update Password
                        </a>
                        <a href="<?= base_url('profile/settings'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2 text-dark">
                            <i class="bi bi-gear-fill text-dark fs-6"></i> Update My Personal Information
                        </a>
                        <a href="<?= base_url('auth/logout'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2 text-danger fw-bold bg-light">
                            <i class="bi bi-box-arrow-right fs-6"></i> Logout
                        </a>
                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</nav>

<?php 
    // Determine dynamic time greeting
    $hour = date('H');
    if ($hour < 12) {
        $time_greeting = "Good morning";
    } elseif ($hour < 18) {
        $time_greeting = "Good afternoon";
    } else {
        $time_greeting = "Good evening";
    }

    // Get session/view user name (Fallback to 'Student' if empty)
    $user_display_name = !empty($current_username) ? ucfirst($current_username) : ($this->session->userdata('username') ? ucfirst($this->session->userdata('username')) : 'Student');
?>

<div class="welcome-banner d-flex justify-content-between align-items-center p-4 mb-4 bg-white rounded-3 shadow-sm">
    <!-- Left Section: Dynamic Greeting -->
    <div class="greeting-section">
        <h3 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
            <?= $time_greeting . ', ' . htmlspecialchars($user_display_name); ?>! <span class="wave-emoji">👋</span>
        </h3>
        <p class="text-muted small m-0 mt-1">
            Keep going! You're building your future.
        </p>
    </div>

    <!-- Right Section: Quote -->
    <div class="quote-section d-flex align-items-center">
        <div class="quote-accent-line me-3"></div>
        <div class="quote-text text-end">
            <p class="fst-italic text-secondary mb-0 small fw-medium">
                "The truth you seek is in you."
            </p>
            <span class="text-muted extra-small d-block mt-1">
                — St. Dominic de Guzman
            </span>
        </div>
    </div>
</div>

            <!-- PROGRESS DASHBOARD -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 text-center border-start border-4 border-danger">
                        <small class="text-secondary uppercase">Hours Rendered</small>
                        <h2 class="fw-bold text-danger mb-0"><?= number_format($rendered_hours, 1); ?> hrs</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 text-center border-start border-4 border-warning">
                        <small class="text-secondary">Hours Remaining</small>
                        <h2 class="fw-bold text-warning mb-0"><?= number_format($remaining_hours, 1); ?> hrs</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 text-center border-start border-4 border-dark">
                        <small class="text-secondary">Target Hours</small>
                        <h2 class="fw-bold text-dark mb-0"><?= $required_hours; ?> hrs</h2>
                    </div>
                </div>
            </div>

            <!-- PROGRESS BAR -->
            <div class="card border-0 shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-bold">Overall Progress</span>
                    <span class="fw-bold text-danger"><?= $progress_pct; ?>% Completed</span>
                </div>
                <div class="progress" style="height: 22px;">
                    <div class="progress-bar progress-bar-sdca progress-bar-striped progress-bar-animated" 
                         role="progressbar" style="width: <?= $progress_pct; ?>%;">
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- TIME IN / TIME OUT ACTION CARD -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 text-center">
                        <h5 class="fw-bold mb-3 text-start"><i class="bi bi-person-badge me-2"></i>Attendance Log</h5>
                        
                        <?php $has_active_log = isset($active_log) && !empty($active_log); ?>

                        <div class="d-grid gap-3 mb-3">
                            <!-- Time In Form -->
                            <form action="<?= site_url('ojt/time_in'); ?>" method="POST">
                                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold py-3" <?= $has_active_log ? 'disabled' : ''; ?>>
                                    <i class="bi bi-box-arrow-in-right me-2"></i> TIME IN
                                </button>
                            </form>

                            <!-- Time Out Form -->
                            <form action="<?= site_url('ojt/time_out'); ?>" method="POST">
                                <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold py-3" <?= !$has_active_log ? 'disabled' : ''; ?>>
                                    <i class="bi bi-box-arrow-left me-2"></i> TIME OUT
                                </button>
                            </form>
                        </div>

                        <div class="alert <?= $has_active_log ? 'alert-success' : 'alert-secondary'; ?> mb-0 small fw-bold">
                            Status: <?= $has_active_log ? 'Currently Timed In since ' . date('h:i A', strtotime($active_log['time_in'])) : 'Currently Timed Out'; ?>
                        </div>
                    </div>
                </div>

                <!-- LOGS TABLE (DTR) -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-table me-2"></i>Daily Time Record (DTR)</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Schedule</th>
                                        <th>Hours</th>
                                        <th>Task Description</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($logs)): ?>
                                    <?php foreach($logs as $log): ?>
                                        <tr>
                                            <td class="fw-bold"><?= date('M d, Y', strtotime($log['log_date'])); ?></td>
                                            <td class="small">
                                                <?= date('h:i A', strtotime($log['time_in'])); ?> - 
                                                <?= !empty($log['time_out']) ? date('h:i A', strtotime($log['time_out'])) : '<span class="badge bg-warning text-dark">Running...</span>'; ?>
                                            </td>
                                            <?php $badge_class = ($log['hours_rendered'] >= 8) ? 'bg-success' : (($log['hours_rendered'] > 0) ? 'bg-primary' : 'bg-secondary'); ?>
                                            <td><span class="badge <?= $badge_class; ?>"><?= number_format($log['hours_rendered'], 2); ?> hrs</span></td>
                                            <td class="small"><?= !empty($log['task_summary']) ? html_escape($log['task_summary']) : '<em class="text-muted">No task added yet</em>'; ?></td>
                                            
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $log['id']; ?>" title="Edit Log & Tasks">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <a href="<?= site_url('ojt/delete_log/' . $log['id']); ?>" 
                                                       class="btn btn-outline-danger" 
                                                       onclick="return confirm('Are you sure you want to delete this time log?');" title="Delete Log">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>

                                                <!-- EDIT ACCOMPLISHMENTS MODAL -->
                                                <div class="modal fade text-start" id="editModal<?= $log['id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content shadow border-0">
                                                            <div class="modal-header bg-sdca text-white">
                                                                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Update Entry & Tasks</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form action="<?= site_url('ojt/update_log/' . $log['id']); ?>" method="POST">
                                                                <div class="modal-body bg-light">
                                                                    <div class="mb-3">
                                                                        <label class="form-label small fw-bold">Tasks / Accomplishments</label>
                                                                        <textarea name="task_summary" class="form-control" rows="4" placeholder="Type your accomplishments for this shift..." required><?= html_escape($log['task_summary']); ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer bg-white">
                                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-warning btn-sm fw-bold">Save Tasks</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center text-muted py-4">No time logs submitted yet.</td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- SET TARGET HOURS MODAL -->
<div class="modal fade" id="targetHoursModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-sdca text-white">
                <h6 class="modal-title fw-bold"><i class="bi bi-gear me-2"></i>Set Target Hours</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('ojt/update_target_hours'); ?>" method="POST">
                <div class="modal-body bg-light">
                    <label class="form-label small fw-bold">Required OJT Hours</label>
                    <input type="number" step="0.5" min="1" name="required_hours" class="form-control" value="<?= $required_hours; ?>" required>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm fw-bold bg-sdca">Save Target</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- CALCULATOR MODAL -->
<div class="modal fade" id="calcModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-sdca text-white">
                <h6 class="modal-title fw-bold"><i class="bi bi-calculator me-2"></i>Calculator</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light">
                <input type="text" id="calcDisplay" class="form-control form-control-lg text-end bg-white fs-4 mb-3 border-secondary fw-bold" readonly value="0">
                <div class="row g-2">
                    <div class="col-3"><button class="btn btn-danger w-100 fw-bold" onclick="calcClear()">C</button></div>
                    <div class="col-3"><button class="btn btn-secondary w-100 fw-bold" onclick="calcInput('/')">÷</button></div>
                    <div class="col-3"><button class="btn btn-secondary w-100 fw-bold" onclick="calcInput('*')">×</button></div>
                    <div class="col-3"><button class="btn btn-secondary w-100 fw-bold" onclick="calcBackspace()"><i class="bi bi-backspace"></i></button></div>

                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('7')">7</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('8')">8</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('9')">9</button></div>
                    <div class="col-3"><button class="btn btn-secondary w-100 fw-bold" onclick="calcInput('-')">-</button></div>

                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('4')">4</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('5')">5</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('6')">6</button></div>
                    <div class="col-3"><button class="btn btn-secondary w-100 fw-bold" onclick="calcInput('+')">+</button></div>

                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('1')">1</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('2')">2</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('3')">3</button></div>
                    <div class="col-3"><button class="btn btn-warning w-100 fw-bold" onclick="calcEqual()">=</button></div>

                    <div class="col-6"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('0')">0</button></div>
                    <div class="col-6"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('.')">.</button></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- REAL-TIME PST CLOCK SCRIPT -->
<script>
    function tickPHClock() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-US', { timeZone: 'Asia/Manila', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
        const dateStr = now.toLocaleDateString('en-US', { timeZone: 'Asia/Manila', weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

        document.getElementById('phClock').innerText = timeStr;
        document.getElementById('phDate').innerText = dateStr;
    }
    setInterval(tickPHClock, 1000);
    tickPHClock();

    // Calculator Functions
    let display = document.getElementById('calcDisplay');
    function calcInput(val) { display.value = (display.value === '0' || display.value === 'Error') ? val : display.value + val; }
    function calcClear() { display.value = '0'; }
    function calcBackspace() { display.value = display.value.slice(0, -1) || '0'; }
    function calcEqual() { try { display.value = eval(display.value); } catch(e) { display.value = 'Error'; } }
</script>

<script>
// Pass CodeIgniter session values and base URL into JavaScript variables
const BASE_URL = "<?= base_url(); ?>";
const USER_DATA = {
    email: "<?= $this->session->userdata('email') ?? ''; ?>",
    firstName: "<?= $this->session->userdata('first_name') ?? ''; ?>",
    middleName: "<?= $this->session->userdata('middle_name') ?? ''; ?>",
    lastName: "<?= $this->session->userdata('last_name') ?? ''; ?>",
    gender: "<?= $this->session->userdata('gender') ?? ''; ?>",
    birthday: "<?= $this->session->userdata('birthday') ?? ''; ?>",
    school: "<?= $this->session->userdata('school') ? $this->session->userdata('school') : 'St. Dominic College of Asia'; ?>",
    yearSection: "<?= $this->session->userdata('year_section') ?? ''; ?>",
    academicYear: "<?= $this->session->userdata('academic_year') ?? ''; ?>",
    semester: "<?= $this->session->userdata('semester') ?? ''; ?>"
};

function loadProfileView(viewType) {
    // 1. Remove active highlight from sidebar items
    document.querySelectorAll('.sidebar .nav-link, .sidebar a').forEach(el => {
        el.classList.remove('active', 'bg-primary', 'text-white');
    });

    // 2. Build template using JavaScript string literals
    let viewContent = '';

    if (viewType === 'update_email') {
        viewContent = `
            <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="bi bi-envelope-fill me-2 text-danger"></i>Update Email Address
                    </h5>
                    <p class="text-muted small mb-0">Change the primary email address associated with your intern account.</p>
                </div>

                <form id="formUpdateEmail" action="${BASE_URL}profile/update_email" method="POST" class="col-lg-8 col-xl-6">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CURRENT EMAIL</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock-fill"></i></span>
                            <input type="email" class="form-control bg-light border-start-0" value="${USER_DATA.email}" readonly disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">New Email Address</label>
                        <input type="email" name="new_email" class="form-control" placeholder="e.g. user@sdca.edu.ph" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Current Password <span class="text-muted fw-normal">(To confirm identity)</span></label>
                        <input type="password" name="current_password" class="form-control" placeholder="Enter password" required>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-danger text-white px-4 fw-semibold">Save Changes</button>
                        <button type="button" onclick="location.reload()" class="btn btn-outline-secondary px-4">Cancel</button>
                    </div>
                </form>
            </div>`;
    } else if (viewType === 'update_password') {
        viewContent = `
            <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="bi bi-key-fill me-2 text-danger"></i>Update Password
                    </h5>
                    <p class="text-muted small mb-0">Ensure your account is using a long, random password to stay secure.</p>
                </div>

                <form id="formUpdatePassword" action="${BASE_URL}profile/update_password" method="POST" class="col-lg-8 col-xl-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Current Password</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter new password" required>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-danger text-white px-4 fw-semibold">Update Password</button>
                        <button type="button" onclick="location.reload()" class="btn btn-outline-secondary px-4">Cancel</button>
                    </div>
                </form>
            </div>`;
    } else if (viewType === 'update_profile') {
        viewContent = `
            <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="bi bi-gear-fill me-2 text-danger"></i>Update Personal Information
                    </h5>
                    <p class="text-muted small mb-0">Manage your personal, academic, and enrolment details for official DTR records.</p>
                </div>

                <form id="formUpdateProfile" action="${BASE_URL}profile/update_info" method="POST">
                    <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-person-fill me-1"></i> Basic Profile</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="${USER_DATA.firstName}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" value="${USER_DATA.middleName}" placeholder="Optional">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="${USER_DATA.lastName}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="" disabled>Select gender</option>
                                <option value="Male" ${USER_DATA.gender === 'Male' ? 'selected' : ''}>Male</option>
                                <option value="Female" ${USER_DATA.gender === 'Female' ? 'selected' : ''}>Female</option>
                                <option value="Prefer not to say" ${USER_DATA.gender === 'Prefer not to say' ? 'selected' : ''}>Prefer not to say</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Birthday</label>
                            <input type="date" name="birthday" class="form-control" value="${USER_DATA.birthday}" required>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-mortarboard-fill me-1"></i> Academic Details</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">School / Institution</label>
                            <input type="text" name="school" class="form-control" value="${USER_DATA.school}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Year Level & Section</label>
                            <input type="text" name="year_section" class="form-control" placeholder="e.g. 4th Year - BSIT 4A" value="${USER_DATA.yearSection}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Academic Year</label>
                            <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2026-2027" value="${USER_DATA.academicYear}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Semester</label>
                            <select name="semester" class="form-select" required>
                                <option value="1st Semester" ${USER_DATA.semester === '1st Semester' ? 'selected' : ''}>1st Semester</option>
                                <option value="2nd Semester" ${USER_DATA.semester === '2nd Semester' ? 'selected' : ''}>2nd Semester</option>
                                <option value="Summer / Midyear" ${USER_DATA.semester === 'Summer / Midyear' ? 'selected' : ''}>Summer / Midyear</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 pt-2">
                        <button type="submit" class="btn btn-danger text-white px-4 fw-semibold">Save Information</button>
                        <button type="button" onclick="location.reload()" class="btn btn-outline-secondary px-4">Cancel</button>
                    </div>
                </form>
            </div>`;
    }

    // 3. Output to the target container
    const targetArea = document.getElementById('main-content-area');
    if (targetArea) {
        targetArea.innerHTML = viewContent;
    }
}
</script>

<script>
// 1. Save default dashboard layout on initial page load
let defaultDashboardHTML = '';

document.addEventListener("DOMContentLoaded", function() {
    const targetArea = document.getElementById('main-content-area');
    if (targetArea) {
        defaultDashboardHTML = targetArea.innerHTML;
    }
});

// 2. Dynamic View Switcher
function loadMainView(viewType, element = null) {
    // Manage active state on sidebar menu items
    document.querySelectorAll('.sidebar-menu li').forEach(li => {
        li.classList.remove('active');
    });

    if (element) {
        element.closest('li').classList.add('active');
    }

    const targetArea = document.getElementById('main-content-area');
    if (!targetArea) return;

    // View Routing
    if (viewType === 'dashboard') {
        targetArea.innerHTML = defaultDashboardHTML;
        
    } else if (viewType === 'analytics') {
        // 1. Retrieve dynamic backend variables directly from PHP session
    <?php 
        $target_hours   = !empty($this->session->userdata('target_hours')) ? $this->session->userdata('target_hours') : 500.0;
        $rendered_hours = !empty($this->session->userdata('hours_rendered')) ? $this->session->userdata('hours_rendered') : 0.0;
        $remaining      = max(0, $target_hours - $rendered_hours);
        $percentage     = ($target_hours > 0) ? round(($rendered_hours / $target_hours) * 100, 1) : 0;
    ?>

    // 2. Render dynamic HTML layout
    targetArea.innerHTML = `
        <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
            <!-- Header -->
            <div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-4">
                <i class="fas fa-chart-line fs-4 text-danger"></i>
                <div>
                    <h5 class="fw-bold text-dark mb-0">Analytics & Goals</h5>
                    <p class="text-muted small mb-0">Track your rendering progress, target milestones, and completion projection.</p>
                </div>
            </div>

            <!-- Dynamic Metric Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <span class="text-muted small fw-semibold">TOTAL TARGET HOURS</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0"><?= number_format($target_hours, 1); ?> <span class="fs-6 text-muted fw-normal">hrs</span></h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <span class="text-muted small fw-semibold">HOURS RENDERED</span>
                        <h3 class="fw-bold text-success mt-1 mb-0"><?= number_format($rendered_hours, 1); ?> <span class="fs-6 text-muted fw-normal">hrs</span></h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <span class="text-muted small fw-semibold">REMAINING HOURS</span>
                        <h3 class="fw-bold text-danger mt-1 mb-0"><?= number_format($remaining, 1); ?> <span class="fs-6 text-muted fw-normal">hrs</span></h3>
                    </div>
                </div>
            </div>

            <!-- Dynamic Completion Progress Bar -->
            <div class="mb-4 p-3 border rounded-3 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-dark small">Overall Internship Completion Progress</span>
                    <span class="fw-bold text-danger"><?= $percentage; ?>%</span>
                </div>
                <div class="progress" style="height: 12px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $percentage; ?>%;" aria-valuenow="<?= $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <!-- Chart Container -->
            <div class="p-4 text-center border rounded-3 bg-light">
                <i class="fas fa-chart-area fa-3x text-secondary mb-3"></i>
                <h6 class="fw-bold text-dark mb-1">Weekly Rendered Hours Trend</h6>
                <p class="text-muted small mb-0">Interactive weekly hours graph and estimated completion date will render here.</p>
            </div>
        </div>`;

    } else if (viewType === 'dtr') {
        targetArea.innerHTML = `
            <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
                <!-- Header -->
                <div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-4">
                    <i class="fas fa-list-alt fs-4 text-primary"></i>
                    <h5 class="fw-bold text-dark mb-0">DTR Records & Search Filter</h5>
                </div>

                <!-- Filter Controls -->
                <form id="dtrFilterForm" class="row g-3 mb-4 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">Search Tasks / Keywords</label>
                        <input type="text" id="filterKeyword" name="keyword" class="form-control" placeholder="Search accomplishment...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-muted">Start Date</label>
                        <input type="date" id="filterStartDate" name="start_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-muted">End Date</label>
                        <input type="date" id="filterEndDate" name="end_date" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </form>

                <!-- Data Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-top">
                        <thead class="table-light">
                            <tr class="text-secondary small fw-bold">
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Rendered</th>
                                <th>Tasks / Accomplishments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-dark">Aug 27, 2026</td>
                                <td>10:54 AM</td>
                                <td><span class="badge bg-warning text-dark px-2 py-1">Running</span></td>
                                <td><span class="badge bg-danger px-2 py-1">0.00 hrs</span></td>
                                <td class="text-muted fst-italic">No description recorded</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>`;

    } else if (viewType === 'export') {
        targetArea.innerHTML = `
            <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
                <div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-4">
                    <i class="fas fa-file-pdf fs-4 text-danger"></i>
                    <h5 class="fw-bold text-dark mb-0">Export DTR Records</h5>
                </div>
                <p class="text-muted">Generate official Daily Time Record PDF for supervisor evaluation and signatures.</p>
                <div class="p-5 text-center border rounded-3 bg-light">
                    <i class="fas fa-file-download fa-3x text-secondary mb-3"></i>
                    <p class="text-muted mb-3">Select date range to download your formal PDF report.</p>
                    <a href="<?= base_url('ojt/export_pdf'); ?>" target="_blank" class="btn btn-danger px-4 fw-semibold">
                        <i class="fas fa-download me-1"></i> Generate & Download PDF
                    </a>
                </div>
            </div>`;
    }
}
</script>

<script>
function updateSidebarClock() {
    const now = new Date();
    
    // Format Time (e.g., 2:19:13 PM)
    const timeOptions = { hour: 'numeric', minute: '2-digit', second: '2-digit', hour12: true };
    const timeString = now.toLocaleTimeString('en-US', timeOptions);
    
    // Format Date (e.g., August 27, 2026)
    const dateOptions = { month: 'long', day: 'numeric', year: 'numeric' };
    const dateString = now.toLocaleDateString('en-US', dateOptions);
    
    const timeEl = document.getElementById('sidebarTime');
    const dateEl = document.getElementById('sidebarDate');
    
    if (timeEl) timeEl.textContent = timeString;
    if (dateEl) dateEl.textContent = dateString;
}

// Initialize and start 1-second interval ticker
updateSidebarClock();
setInterval(updateSidebarClock, 1000);
</script>

</body>
</html>