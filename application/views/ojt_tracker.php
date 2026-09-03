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
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/sdcalogoorig1.png?v=2'); ?>">
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
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1000' height='1000' viewBox='0 0 1000 1000'%3E%3Cg stroke='%23800000' stroke-width='1.2' fill='none' opacity='0.3'%3E%3Cpolygon points='100,200 400,100 700,300 900,150'/%3E%3Cpolygon points='300,800 600,950 900,700'/%3E%3Cline x1='100' y1='200' x2='600' y2='950'/%3E%3Cline x1='400' y1='100' x2='900' y2='700'/%3E%3Cline x1='700' y1='300' x2='300' y2='800'/%3E%3Ccircle cx='400' cy='100' r='4' fill='%23800000'/%3E%3Ccircle cx='700' cy='300' r='4' fill='%23800000'/%3E%3Ccircle cx='300' cy='800' r='4' fill='%23800000'/%3E%3C/g%3E%3C/svg%3E");
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

    .main-content .btn:not(:disabled):hover,
    .main-content .btn:not(:disabled):focus {
        background-color: #25292d !important;
        border-color: #25292d !important;
        color: #ffffff !important;
    }

    /* TOP NAVBAR */
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

    .sidebar-contact {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 2;
        padding: 10px 16px 12px;
        background: rgba(255, 255, 255, 0.92);
        color: #6c757d;
        font-size: 0.63rem;
    }

    .sidebar-contact hr { margin: 0 0 8px; }
    .sidebar-contact-heading { color: var(--sdca-red); font-size: 0.67rem; font-weight: 700; }
    .sidebar-contact p { margin: 0 0 6px; line-height: 1.3; }
    .sidebar-contact strong { color: #343a40; font-size: 0.65rem; }
    .sidebar-contact a { color: var(--sdca-red); text-decoration: none; }

    /* COMPACT PROFILE DROPDOWN MENU */
    .dropdown-menu {
        min-width: 250px !important;
        max-width: 270px !important;
        padding: 6px 0 !important;
        border-radius: 10px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        border: 1px solid rgba(0, 0, 0, 0.08) !important;
    }

    /* Header Profile Section inside Dropdown */
    .dropdown-menu .px-4,
    .dropdown-menu .p-3,
    .dropdown-menu .text-center {
        padding: 12px 15px 10px 15px !important;
    }

    /* Avatar Icon Size */
    .dropdown-menu i.fa-user-circle,
    .dropdown-menu i.fa-circle-user,
    .dropdown-menu svg.bi-person-circle {
        font-size: 2.5rem !important;
        margin-bottom: 4px !important;
    }

    /* Compact Typography inside Header */
    .dropdown-menu h6, 
    .dropdown-menu .fw-bold {
        font-size: 0.95rem !important;
        margin-bottom: 2px !important;
    }

    .dropdown-menu small,
    .dropdown-menu .text-muted {
        font-size: 0.72rem !important;
    }

    /* Email Pill Tag Slimming */
    .dropdown-menu .badge,
    .dropdown-menu .btn-outline-secondary,
    .dropdown-menu .border {
        font-size: 0.72rem !important;
        padding: 3px 8px !important;
        margin-top: 4px !important;
        margin-bottom: 4px !important;
    }

    /* Slim Dropdown List Items */
    .dropdown-menu .dropdown-item,
    .dropdown-menu .list-group-item {
        padding: 7px 16px !important;
        font-size: 0.85rem !important;
        line-height: 1.3 !important;
        display: flex !important;
        align-items: center !important;
    }

    .dropdown-menu .dropdown-item i,
    .dropdown-menu .list-group-item i {
        font-size: 0.88rem !important;
        width: 18px !important;
        margin-right: 10px !important;
        text-align: center;
    }

    /* DROPDOWN MENU HOVER EFFECTS */
    .dropdown-menu .list-group-item-action:hover,
    .dropdown-menu .list-group-item-action:focus,
    .dropdown-menu .dropdown-item:hover,
    .dropdown-menu .dropdown-item:focus {
        background-color: #f1f5f9 !important;
        color: #1a202c !important;
    }

    .dropdown-menu .list-group-item-action.text-danger:hover,
    .dropdown-menu .dropdown-item.text-danger:hover {
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

    .quote-accent-line {
        width: 3px;
        height: 38px;
        background-color: #0f3d3e; /* Dark teal/forest green line from reference */
        border-radius: 2px;
    }

    .log-action-btn {
        width: 34px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    /* Smooth entrance fade on dashboard load */
    body {
        animation: fadeInPage 0.6s cubic-bezier(0.39, 0.575, 0.565, 1) both;
    }

    @keyframes fadeInPage {
        0% {
            opacity: 0;
            transform: translateY(10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* 1. Hide scrollbar for Chrome, Safari, Edge, and Opera */
    html::-webkit-scrollbar,
    body::-webkit-scrollbar,
    .wrapper::-webkit-scrollbar,
    .content-wrapper::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    /* 2. Hide scrollbar for Firefox and IE/Edge */
    html, 
    body, 
    .wrapper, 
    .content-wrapper {
        -ms-overflow-style: none !important;  /* IE and Edge */
        scrollbar-width: none !important;  /* Firefox */
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
        <li>
            <a href="javascript:void(0);" onclick="loadMainView('documents', this)">
                <i class="bi bi-file-earmark-text"></i>
                <span>Documents</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" onclick="loadMainView('inquiries', this)">
                <i class="bi bi-question-circle"></i>
                <span>Inquiries / Support</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-contact">
        <hr>
        <p class="sidebar-contact-heading"><i class="bi bi-geo-alt-fill me-2"></i>ST. DOMINIC COLLEGE OF ASIA</p>
        <p>EMILIO AGUINALDO HIGHWAY<br>TALABA III, CITY OF BACOOR, PHILIPPINES 4102</p>
        <p class="sidebar-contact-heading"><i class="bi bi-telephone-fill me-2"></i>CONTACT US</p>
        <p><strong>Basic Education</strong><br><i class="bi bi-telephone-fill me-1"></i>+63 998.551.7972<br><i class="bi bi-envelope-fill me-1"></i><a href="mailto:bedadmission@sdca.edu.ph">bedadmission@sdca.edu.ph</a></p>
        <p class="mb-0"><strong>Higher Education</strong><br><i class="bi bi-telephone-fill me-1"></i>+63 998.551.8001<br><i class="bi bi-envelope-fill me-1"></i><a href="mailto:headmission@sdca.edu.ph">headmission@sdca.edu.ph</a></p>
    </div>
</aside>

    <!-- RIGHT MAIN CONTENT AREA -->
    <main class="main-content px-4 py-3">
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
                    <button id="inboxDropdown" class="nav-boxed-btn btn gap-2 px-3 border-0 border-end border-dark border-opacity-50 small" type="button" data-bs-toggle="dropdown">
                        <span id="announcementBadge" class="badge bg-danger font-monospace"><?= isset($unread_announcement_count) ? (int)$unread_announcement_count : 0; ?></span>
                        <i class="bi bi-inbox-fill text-white opacity-75"></i>
                        <span class="fw-semibold">Inbox</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2" style="min-width: 300px; max-height: 400px; overflow-y: auto;">
                        <li class="dropdown-header fw-bold text-uppercase">Announcements</li>
                        <li><hr class="dropdown-divider"></li>
                        <?php if (isset($announcements) && !empty($announcements)): ?>
                            <?php foreach ($announcements as $announcement): ?>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item p-2 border-bottom small" data-bs-toggle="modal" data-bs-target="#announcementModal<?= (int)$announcement['id']; ?>" style="cursor: pointer; white-space: normal;">
                                        <div class="d-flex gap-2">
                                            <div style="flex: 1;">
                                                <strong class="d-block text-dark"><?= html_escape($announcement['title']); ?></strong>
                                                <small class="text-muted d-block"><?= html_escape(substr($announcement['message'], 0, 60) . (strlen($announcement['message']) > 60 ? '...' : '')); ?></small>
                                                <small class="text-muted d-block"><?= date('M d, Y', strtotime($announcement['created_at'])); ?> · <?= html_escape($announcement['first_name'] . ' ' . $announcement['last_name']); ?></small>
                                            </div>
                                            <?php if (!empty($announcement['category'])): ?>
                                                <span class="badge bg-secondary text-white align-self-start" style="font-size: 0.7rem;"><?= html_escape($announcement['category']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="text-center text-muted small py-2">No new announcements</li>
                        <?php endif; ?>
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
                        <a href="javascript:void(0);" onclick="loadProfileView('update_email')" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2 text-dark">
                            <i class="bi bi-envelope-fill text-dark fs-6"></i> Update Email
                        </a>
                        <a href="javascript:void(0);" onclick="loadProfileView('update_password')" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2 text-dark">
                            <i class="bi bi-key-fill text-dark fs-6"></i> Update Password
                        </a>
                        <a href="javascript:void(0);" onclick="loadProfileView('update_info')" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2 text-dark">
                            <i class="bi bi-gear-fill text-dark fs-6"></i> Update My Personal Information
                        </a>
                        <a href="<?= base_url('auth/logout'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2 text-danger fw-bold bg-light btn-logout">
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

<div class="welcome-banner d-flex justify-content-between align-items-center mb-4">
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
             <div id="main-content-area" class="p-4">
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
                        
                        <?php
                            $has_active_log = isset($active_log) && !empty($active_log);
                            $attendance_complete = isset($has_completed_shift) && $has_completed_shift;
                        ?>

                        <div class="d-grid gap-3 mb-3">
                            <!-- Time In Form -->
                            <form action="<?= site_url('ojt/time_in'); ?>" method="POST">
                                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold py-3" <?= ($has_active_log || $attendance_complete) ? 'disabled' : ''; ?>>
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

                        <div class="alert <?= $has_active_log ? 'alert-success' : ($attendance_complete ? 'alert-info' : 'alert-secondary'); ?> mb-0 small fw-bold">
                            Status: <?= $has_active_log ? 'Currently Timed In since ' . date('h:i A', strtotime($active_log['time_in'])) : ($attendance_complete ? 'Attendance session completed' : 'Currently Timed Out'); ?>
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
                                                    <button type="button" class="btn btn-outline-warning log-action-btn" data-bs-toggle="modal" data-bs-target="#editModal<?= $log['id']; ?>" title="Edit Log & Tasks">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="<?= site_url('ojt/request_deletion'); ?>" method="POST" class="d-inline">
                                                        <input type="hidden" name="log_id" value="<?= (int)$log['id']; ?>">
                                                        <button type="submit" class="btn btn-outline-danger log-action-btn" onclick="return confirm('Send a deletion request to the administrator for this time log?');" title="Request Deletion">
                                                            <i class="bi bi-envelope-exclamation"></i>
                                                        </button>
                                                    </form>
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

<!-- ANNOUNCEMENT DETAIL MODALS -->
<?php if (isset($announcements) && !empty($announcements)): ?>
    <?php foreach ($announcements as $announcement): ?>
        <div class="modal fade" id="announcementModal<?= (int)$announcement['id']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow border-0">
                    <div class="modal-header bg-sdca text-white">
                        <div>
                            <h5 class="modal-title fw-bold mb-0"><?= html_escape($announcement['title']); ?></h5>
                            <?php if (!empty($announcement['category'])): ?>
                                <small class="text-white-50">
                                    <i class="bi bi-tag me-1"></i><?= html_escape($announcement['category']); ?>
                                </small>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="mb-3">
                            <p class="text-muted small mb-1">
                                <strong>From:</strong> <?= html_escape($announcement['first_name'] . ' ' . $announcement['last_name']); ?>
                            </p>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-calendar-event me-1"></i><?= date('F j, Y \a\t g:i A', strtotime($announcement['created_at'])); ?>
                                <?php if (!empty($announcement['expires_at'])): ?>
                                    <br><i class="bi bi-calendar-x me-1"></i>Expires: <?= date('F j, Y', strtotime($announcement['expires_at'])); ?>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="border-top pt-3">
                            <p class="text-dark"><?= nl2br(html_escape($announcement['message'])); ?></p>
                        </div>
                    </div>
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($this->session->userdata('role') === 'intern' && !$this->session->userdata('profile_completed')): ?>
<div class="modal fade" id="initialInformationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="initialInformationModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header bg-sdca text-white"><h5 class="modal-title" id="initialInformationModalLabel"><i class="bi bi-person-vcard me-2"></i>Complete Your Information Sheet</h5></div><form id="initialInformationForm"><div class="modal-body"><p class="text-muted small">Please complete your profile before using the OJT tracker.</p><input type="hidden" name="first_name" value="<?= html_escape($this->session->userdata('first_name')); ?>"><input type="hidden" name="middle_name" value="<?= html_escape($this->session->userdata('middle_name')); ?>"><input type="hidden" name="last_name" value="<?= html_escape($this->session->userdata('last_name')); ?>"><div class="row g-3"><div class="col-md-6"><label class="form-label">School / University</label><input class="form-control" name="school" required></div><div class="col-md-6"><label class="form-label">Birthday</label><input class="form-control" type="date" name="birthday" required></div><div class="col-md-6"><label class="form-label">Gender</label><select class="form-select" name="gender" required><option value="">Select gender</option><option>Male</option><option>Female</option><option>Prefer not to say</option></select></div><div class="col-md-6"><label class="form-label">Year &amp; Section</label><input class="form-control" name="year_section" placeholder="e.g. BSIT 4-1" required></div><div class="col-md-6"><label class="form-label">Academic Year</label><input class="form-control" name="academic_year" placeholder="e.g. 2026-2027" required></div><div class="col-md-6"><label class="form-label">Semester</label><select class="form-select" name="semester" required><option value="">Select semester</option><option>1st Semester</option><option>2nd Semester</option><option>Summer</option></select></div></div></div><div class="modal-footer"><button id="saveInitialInformation" class="btn btn-danger" type="submit">Save Information</button></div></form></div></div></div>
<?php endif; ?>

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
<script>
const initialInformationModalElement = document.getElementById('initialInformationModal');
if (initialInformationModalElement) {
    const initialInformationModal = new bootstrap.Modal(initialInformationModalElement);
    const initialInformationForm = document.getElementById('initialInformationForm');
    initialInformationModal.show();

    initialInformationForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const saveButton = document.getElementById('saveInitialInformation');
        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';

        fetch('<?= site_url('ojt/update_info'); ?>', {
            method: 'POST',
            body: new FormData(initialInformationForm),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function(response) {
            return response.json();
        }).then(function(result) {
            if (result.status !== 'success') {
                throw new Error(result.message || 'Unable to save your information.');
            }
            initialInformationModal.hide();
            const toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '1100';
            toastContainer.innerHTML = '<div class="toast align-items-center text-bg-success border-0"><div class="d-flex"><div class="toast-body">Welcome! Your information sheet has been saved.</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>';
            document.body.appendChild(toastContainer);
            new bootstrap.Toast(toastContainer.querySelector('.toast'), { delay: 4000 }).show();
        }).catch(function(error) {
            saveButton.disabled = false;
            saveButton.textContent = 'Save Information';
            alert(error.message);
        });
    });
}
</script>
<script>
    // Pass PHP values to global JS state once during initial page render
    const OJT_DATA = {
        targetHours: <?= json_encode((float)$required_hours); ?>,
        renderedHours: <?= json_encode((float)$rendered_hours); ?>,
        documents: <?= json_encode($documents); ?>,
        inquiries: <?= json_encode($inquiries); ?>,
        lastWeekLabels: <?= json_encode($last_week_labels); ?>,
        lastWeekHours: <?= json_encode($last_week_hours); ?>,
        lastWeekStart: <?= json_encode($last_week_start); ?>,
        lastWeekEnd: <?= json_encode($last_week_end); ?>
    };
</script>
<script>
const inboxDropdown = document.getElementById('inboxDropdown');
if (inboxDropdown) {
    inboxDropdown.addEventListener('shown.bs.dropdown', function() {
        fetch('<?= site_url('ojt/mark_announcements_read'); ?>', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function(response) {
            return response.json();
        }).then(function(result) {
            if (result.status === 'success') {
                document.getElementById('announcementBadge').textContent = '0';
            }
        }).catch(function() {});
    });
}
</script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-logout').forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            const targetUrl = this.getAttribute('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of your current session.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#800000', /* Brand Maroon */
                cancelButtonColor: '#4a5568',  /* Dark Neutral Gray */
                confirmButtonText: 'Yes, Log Out',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-0',
                    confirmButton: 'rounded-0',
                    cancelButton: 'rounded-0'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = targetUrl;
                }
            });
        });
    });
});
</script>
<!-- REAL-TIME PST CLOCK SCRIPT -->
<script>
    function tickPHClock() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-US', { timeZone: 'Asia/Manila', hour: '2-digit', minute: '2-digit', second: '2-digit' });
        const dateStr = now.toLocaleDateString('en-US', { timeZone: 'Asia/Manila', weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

        const clockElem = document.getElementById('phClock');
        const dateElem = document.getElementById('phDate');

        if (clockElem) clockElem.innerText = timeStr;
        if (dateElem) dateElem.innerText = dateStr;
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
    school: "<?= $this->session->userdata('school') ?? 'St. Dominic College of Asia'; ?>",
    yearSection: "<?= $this->session->userdata('year_section') ?? ''; ?>",
    academicYear: "<?= $this->session->userdata('academic_year') ?? ''; ?>",
    semester: "<?= $this->session->userdata('semester') ?? ''; ?>"
};

function loadProfileView(viewType) {
    console.log("Loading view:", viewType);
    let viewContent = '';

    if (viewType === 'update_email') {
        viewContent = `
            <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-envelope-fill me-2 text-danger"></i>Update Email Address</h5>
                    <p class="text-muted small mb-0">Change the primary email address associated with your intern account.</p>
                </div>
                
                <div id="emailAlertContainer"></div>

                <div class="col-lg-8 col-xl-6">
                    <!-- Moved OUTSIDE the form so form.reset() won't clear it -->
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CURRENT EMAIL</label>
                        <input type="email" id="currentEmailDisplay" class="form-control bg-light" value="${USER_DATA.email}" readonly disabled>
                    </div>

                    <form id="formUpdateEmail" onsubmit="submitEmailForm(event)">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Email Address</label>
                            <input type="email" id="new_email" name="new_email" class="form-control" placeholder="e.g. user@sdca.edu.ph" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Current Password</label>
                            <div class="input-group">
                                <input type="password" id="current_email_password" name="current_password" class="form-control" placeholder="Enter password to confirm" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('current_email_password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" id="btnSubmitEmail" class="btn btn-danger text-white px-4 fw-semibold">Save Changes</button>
                            <button type="button" onclick="location.reload()" class="btn btn-outline-secondary px-4">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>`;
    } else if (viewType === 'update_password') {
        viewContent = `
            <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-key-fill me-2 text-danger"></i>Update Password</h5>
                    <p class="text-muted small mb-0">Ensure your account is using a long, secure password.</p>
                </div>

                <div id="passwordAlertContainer"></div>

                <div class="row g-4">
                    <!-- Left Column: Form -->
                    <div class="col-lg-7">
                        <form id="formUpdatePassword" onsubmit="submitPasswordForm(event)">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Current Password</label>
                                <div class="input-group">
                                    <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter current password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('current_password', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">New Password</label>
                                <div class="input-group">
                                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password" oninput="checkPasswordRequirements(this.value)" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirm_password', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <button type="submit" id="btnSubmitPassword" class="btn btn-danger text-white px-4 fw-semibold">Save Changes</button>
                                <button type="button" onclick="location.reload()" class="btn btn-outline-secondary px-4">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Column: Password Requirements -->
                    <div class="col-lg-5">
                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold text-dark mb-2">Password Requirements:</h6>
                            <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                                <li id="req-length" class="d-flex align-items-center text-muted">
                                    <i class="bi bi-check-circle me-2"></i>At least 8 characters long
                                </li>
                                <li id="req-upper" class="d-flex align-items-center text-muted">
                                    <i class="bi bi-check-circle me-2"></i>At least one uppercase letter (A-Z)
                                </li>
                                <li id="req-lower" class="d-flex align-items-center text-muted">
                                    <i class="bi bi-check-circle me-2"></i>At least one lowercase letter (a-z)
                                </li>
                                <li id="req-number" class="d-flex align-items-center text-muted">
                                    <i class="bi bi-check-circle me-2"></i>At least one number (0-9)
                                </li>
                                <li id="req-special" class="d-flex align-items-center text-muted">
                                    <i class="bi bi-check-circle me-2"></i>At least one special character (@, $, !, %, *, ?, &)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>`;
    } else if (viewType === 'update_info') {
        viewContent = `
            <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-person-lines-fill me-2 text-danger"></i>Update Personal Information</h5>
                    <p class="text-muted small mb-0">Update your basic profile, demographics, and academic details.</p>
                </div>
                
                <div id="alertContainer"></div>

                <form id="formUpdateInfo" onsubmit="submitInfoForm(event)" class="col-lg-10 col-xl-9">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="${USER_DATA.firstName || ''}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" value="${USER_DATA.middleName || ''}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="${USER_DATA.lastName || ''}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="Male" ${USER_DATA.gender === 'Male' ? 'selected' : ''}>Male</option>
                                <option value="Female" ${USER_DATA.gender === 'Female' ? 'selected' : ''}>Female</option>
                                <option value="Prefer not to say" ${USER_DATA.gender === 'Prefer not to say' ? 'selected' : ''}>Prefer not to say</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Birthday</label>
                            <input type="date" name="birthday" class="form-control" value="${USER_DATA.birthday || ''}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">School / University</label>
                            <input type="text" name="school" class="form-control" value="${USER_DATA.school || 'St. Dominic College of Asia'}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Year & Section</label>
                            <input type="text" name="year_section" class="form-control" value="${USER_DATA.yearSection || ''}" placeholder="e.g. BSIT 4-1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Academic Year</label>
                            <input type="text" name="academic_year" class="form-control" value="${USER_DATA.academicYear || ''}" placeholder="e.g. 2025-2026" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Semester</label>
                            <select name="semester" class="form-select" required>
                                <option value="">Select Semester</option>
                                <option value="1st Semester" ${USER_DATA.semester === '1st Semester' ? 'selected' : ''}>1st Semester</option>
                                <option value="2nd Semester" ${USER_DATA.semester === '2nd Semester' ? 'selected' : ''}>2nd Semester</option>
                                <option value="Summer" ${USER_DATA.semester === 'Summer' ? 'selected' : ''}>Summer</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" id="btnSubmitInfo" class="btn btn-danger text-white px-4 fw-semibold">Save Changes</button>
                        <button type="button" onclick="location.reload()" class="btn btn-outline-secondary px-4">Cancel</button>
                    </div>
                </form>
            </div>`;
    }

    const contentArea = document.getElementById('main-content-area') || document.getElementById('dashboardContent') || document.querySelector('.content-body');
    if (contentArea) {
        contentArea.innerHTML = viewContent;
    }
}

function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

function submitEmailForm(event) {
    event.preventDefault();

    const form = document.getElementById('formUpdateEmail');
    const alertContainer = document.getElementById('emailAlertContainer');
    const submitBtn = document.getElementById('btnSubmitEmail');
    const newEmailValue = document.getElementById('new_email').value;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

    const formData = new FormData(form);

    fetch(`${BASE_URL}ojt/update_email`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Save Changes';

        if (data.status === 'success') {
            // Update local memory state
            USER_DATA.email = newEmailValue;

            // Update the display field outside the form
            document.getElementById('currentEmailDisplay').value = newEmailValue;

            // Clear input fields (New Email & Current Password)
            form.reset();

            // Display success message
            alertContainer.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>${data.message || 'Email address updated successfully!'}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
        } else {
            alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>${data.message || 'Failed to update email address.'}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Save Changes';
        alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>An unexpected error occurred. Please try again.</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
    });
}

    function submitInfoForm(event) {
    event.preventDefault();

    const form = document.getElementById('formUpdateInfo');
    const formData = new FormData(form);
    const alertContainer = document.getElementById('alertContainer');
    const submitBtn = document.getElementById('btnSubmitInfo');

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

    fetch(`${BASE_URL}ojt/update_info`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Save Changes';

        if (data.status === 'success') {
            alertContainer.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>${data.message}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
        } else {
            alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>${data.message || 'Failed to update personal information.'}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Save Changes';
        console.error('Error:', error);
    });
}

function checkPasswordRequirements(password) {
    const rules = [
        { id: 'req-length', valid: password.length >= 8 },
        { id: 'req-upper', valid: /[A-Z]/.test(password) },
        { id: 'req-lower', valid: /[a-z]/.test(password) },
        { id: 'req-number', valid: /[0-9]/.test(password) },
        { id: 'req-special', valid: /[@$!%*?&]/.test(password) }
    ];

    rules.forEach(rule => {
        const el = document.getElementById(rule.id);
        if (!el) return;

        const icon = el.querySelector('i');

        if (rule.valid) {
            el.classList.remove('text-muted');
            el.classList.add('text-success', 'fw-semibold');
            icon.classList.remove('bi-check-circle');
            icon.classList.add('bi-check-circle-fill');
        } else {
            el.classList.remove('text-success', 'fw-semibold');
            el.classList.add('text-muted');
            icon.classList.remove('bi-check-circle-fill');
            icon.classList.add('bi-check-circle');
        }
    });
}

function submitPasswordForm(event) {
    event.preventDefault();

    const currentPass = document.getElementById('current_password').value;
    const newPass = document.getElementById('new_password').value;
    const confirmPass = document.getElementById('confirm_password').value;
    const alertContainer = document.getElementById('passwordAlertContainer');
    const submitBtn = document.getElementById('btnSubmitPassword');

    // 1. Check if same as current password
    if (currentPass === newPass) {
        alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>New password cannot be the same as your current password.</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
        return;
    }

    // 2. Check if confirm password matches
    if (newPass !== confirmPass) {
        alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>New password and confirmation do not match.</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
        return;
    }

    // 3. Check password complexity requirements
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!passwordPattern.test(newPass)) {
        alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>Password does not meet all complexity requirements listed on the right.</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
        return;
    }

    // Disable button to prevent double clicks
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

    // 4. Send request via FormData
    const formData = new FormData(document.getElementById('formUpdatePassword'));

    fetch('update_password', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Save Changes';

        if (data.status === 'success') {
            alertContainer.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>${data.message || 'Password updated successfully!'}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`;
            document.getElementById('formUpdatePassword').reset();
        } else {
            alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>${data.message || 'Failed to update password.'}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Save Changes';
        alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>An unexpected error occurred. Please try again.</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
    });
}

</script>

<script>
// 1. Save default dashboard layout on initial page load
let defaultDashboardHTML = '';

document.addEventListener("DOMContentLoaded", function() {
    const targetArea = document.getElementById('main-content-area');
    if (targetArea) {
        defaultDashboardHTML = targetArea.innerHTML;
        const activeModule = <?= json_encode(!empty($active_module) ? $active_module : ''); ?>;
        if (activeModule) {
            const moduleLink = Array.from(document.querySelectorAll('.sidebar-menu a')).find(function(link) {
                return link.getAttribute('onclick') && link.getAttribute('onclick').indexOf("'" + activeModule + "'") !== -1;
            });
            loadMainView(activeModule, moduleLink || null);
        }
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

    const escapeHtml = function(value) {
        const element = document.createElement('div');
        element.textContent = value == null ? '' : String(value);
        return element.innerHTML;
    };

    const showPortalToast = function(message, type) {
        const toastId = 'portalToast';
        document.getElementById(toastId)?.remove();
        const toastContainer = document.createElement('div');
        toastContainer.id = toastId;
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '1100';
        toastContainer.innerHTML = `<div class="toast align-items-center text-bg-${type} border-0" role="status" aria-live="polite"><div class="d-flex"><div class="toast-body">${escapeHtml(message)}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>`;
        document.body.appendChild(toastContainer);
        new bootstrap.Toast(toastContainer.querySelector('.toast'), { delay: 4000 }).show();
    };

    // View Routing
    if (viewType === 'dashboard') {
        targetArea.innerHTML = defaultDashboardHTML;
        
    } else if (viewType === 'analytics') {
        // 1. Retrieve dynamic backend variables directly from PHP session
    <?php
        $target_hours = (float)$required_hours;
        $rendered_hours = (float)$rendered_hours;
        $remaining = (float)$remaining_hours;
        $percentage = (float)$progress_pct;
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

            <!-- Last week's chart -->
            <div class="p-4 border rounded-3 bg-light">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Weekly Rendered Hours Trend</h6>
                        <p class="text-muted small mb-0">${OJT_DATA.lastWeekStart} to ${OJT_DATA.lastWeekEnd}</p>
                    </div>
                    <i class="fas fa-chart-bar fs-3 text-secondary"></i>
                </div>
                <div style="height: 260px;">
                    <canvas id="lastWeekHoursChart"></canvas>
                </div>
            </div>
        </div>`;

        const chartElement = document.getElementById('lastWeekHoursChart');
        new Chart(chartElement, {
            type: 'bar',
            data: {
                labels: OJT_DATA.lastWeekLabels,
                datasets: [{
                    label: 'Hours rendered',
                    data: OJT_DATA.lastWeekHours,
                    backgroundColor: '#800000',
                    borderRadius: 4,
                    maxBarThickness: 48
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        title: { display: true, text: 'Hours' }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });

    } else if (viewType === 'dtr') {
        targetArea.innerHTML = `
            <div class="card shadow-sm border-0 rounded-3 p-4 mb-4">
                <!-- Header -->
                <div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-4">
                    <i class="fas fa-list-alt fs-4 text-danger"></i>
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
                        <button type="submit" class="btn btn-danger w-100 fw-semibold">
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
                            <?php if (!empty($all_logs)): ?>
                                <?php foreach ($all_logs as $log): ?>
                                    <?php
                                        $dtr_badge_class = ((float)$log['hours_rendered'] >= 8) ? 'bg-success' : (((float)$log['hours_rendered'] > 0) ? 'bg-primary' : 'bg-danger');
                                    ?>
                                    <tr>
                                        <td class="fw-bold text-dark"><?= date('M d, Y', strtotime($log['log_date'])); ?></td>
                                        <td><?= date('h:i A', strtotime($log['time_in'])); ?></td>
                                        <td>
                                            <?php if (!empty($log['time_out'])): ?>
                                                <?= date('h:i A', strtotime($log['time_out'])); ?>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark px-2 py-1">Running</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge <?= $dtr_badge_class; ?> px-2 py-1"><?= number_format((float)$log['hours_rendered'], 2); ?> hrs</span></td>
                                        <td class="<?= empty($log['task_summary']) ? 'text-muted fst-italic' : ''; ?>"><?= !empty($log['task_summary']) ? html_escape($log['task_summary']) : 'No description recorded'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No time logs submitted yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>`;

    } else if (viewType === 'documents') {
        const documentTypes = ['Resume / CV', 'Registration Form / COE', 'Endorsement Letter', 'Internship Agreement / Waiver'];
        const documentCards = documentTypes.map(function(documentType) {
            const document = OJT_DATA.documents.find(function(item) { return item.document_type === documentType; });
            const status = document ? document.status : 'Missing';
            const statusClass = status === 'Verified' ? 'bg-success' : (status === 'Rejected' ? 'bg-danger' : (status === 'Pending' ? 'bg-warning text-dark' : 'bg-secondary'));
            const fileDetails = document ? `<small class="text-muted d-block text-break">${escapeHtml(document.original_name)}</small><a class="btn btn-sm btn-outline-secondary mt-3" href="<?= base_url(); ?>${encodeURI(document.file_path)}" target="_blank" rel="noopener"><i class="bi bi-eye me-1"></i>View File</a>` : '<small class="text-muted">Not uploaded yet</small>';
            return `<div class="col-md-6"><div class="card border-0 shadow-sm h-100 border-start border-4 border-danger"><div class="card-body"><div class="d-flex justify-content-between gap-3"><h6 class="fw-bold mb-2">${documentType}</h6><span class="badge ${statusClass} align-self-start">${status}</span></div>${fileDetails}</div></div></div>`;
        }).join('');
        targetArea.innerHTML = `<div class="card shadow-sm border-0 rounded-3 p-4 mb-4"><div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-4"><i class="bi bi-file-earmark-text fs-4 text-danger"></i><div><h5 class="fw-bold text-dark mb-0">Documents</h5><p class="text-muted small mb-0">Upload and track required internship documents.</p></div></div><form id="documentUploadForm" action="<?= site_url('ojt/upload_document'); ?>" method="post" enctype="multipart/form-data" class="row g-3 align-items-start mb-4"><div class="col-md-4"><label class="form-label fw-semibold small">Document Type</label><select name="document_type" class="form-select" required><option value="">Select a document</option>${documentTypes.map(function(type) { return `<option value="${type}">${type}</option>`; }).join('')}</select></div><div class="col-md-5"><label class="form-label fw-semibold small">File</label><input class="form-control" type="file" name="document_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required><small class="text-muted">PDF, DOC, DOCX, JPG, or PNG, up to 5 MB.</small></div><div class="col-md-3"><label class="form-label fw-semibold small invisible">Upload</label><button class="btn btn-danger w-100 fw-semibold" type="submit"><i class="bi bi-upload me-1"></i>Upload</button></div></form><div class="row g-3">${documentCards}</div></div>`;

        document.getElementById('documentUploadForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = event.currentTarget;
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                if (result.status !== 'success') {
                    throw new Error(result.message || 'Unable to upload your document.');
                }
                OJT_DATA.documents = OJT_DATA.documents.filter(function(item) {
                    return item.document_type !== result.document.document_type;
                });
                OJT_DATA.documents.push(result.document);
                loadMainView('documents', element);
                showPortalToast(result.message, 'success');
            }).catch(function(error) {
                submitButton.disabled = false;
                showPortalToast(error.message, 'danger');
            });
        });

    } else if (viewType === 'inquiries') {
        const inquiryHistory = OJT_DATA.inquiries.length ? OJT_DATA.inquiries.map(function(inquiry) {
            const statusClass = inquiry.status === 'Answered' ? 'bg-success' : (inquiry.status === 'Closed' ? 'bg-secondary' : 'bg-warning text-dark');
            const reply = inquiry.admin_reply ? `<div class="alert alert-success mt-3 mb-0"><strong><i class="bi bi-reply-fill me-1"></i>Administrator Reply</strong><br>${escapeHtml(inquiry.admin_reply)}</div>` : '';
            return `<div class="card border-0 shadow-sm mb-3 border-start border-4 border-danger"><div class="card-body"><div class="d-flex justify-content-between gap-3"><div><span class="badge bg-secondary mb-2">${escapeHtml(inquiry.category)}</span><p class="mb-0">${escapeHtml(inquiry.message)}</p></div><span class="badge ${statusClass} align-self-start">${escapeHtml(inquiry.status)}</span></div>${reply}</div></div>`;
        }).join('') : '<p class="text-center text-muted py-4 mb-0">No inquiries submitted yet.</p>';
        targetArea.innerHTML = `<div class="card shadow-sm border-0 rounded-3 p-4 mb-4"><div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-4"><i class="bi bi-question-circle fs-4 text-danger"></i><div><h5 class="fw-bold text-dark mb-0">Inquiries / Support</h5><p class="text-muted small mb-0">Send a concern to the OJT administrator and view replies.</p></div></div><form id="inquiryForm" action="<?= site_url('ojt/submit_inquiry'); ?>" method="post" class="row g-3 mb-4"><div class="col-md-4"><label class="form-label fw-semibold small">Category</label><select name="category" class="form-select" required><option value="">Select category</option><option>DTR Discrepancy</option><option>Requirement Query</option><option>General Concern</option></select></div><div class="col-md-8"><label class="form-label fw-semibold small">Message</label><textarea name="message" class="form-control" rows="3" maxlength="2000" required></textarea></div><div class="col-12"><button class="btn btn-danger fw-semibold" type="submit"><i class="bi bi-send me-1"></i>Submit Inquiry</button></div></form><h6 class="fw-bold border-top pt-4">My Inquiry History</h6>${inquiryHistory}</div>`;

        document.getElementById('inquiryForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = event.currentTarget;
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                if (result.status !== 'success') {
                    throw new Error(result.message || 'Unable to submit your inquiry.');
                }
                OJT_DATA.inquiries.unshift(result.inquiry);
                loadMainView('inquiries', element);
                showPortalToast(result.message, 'success');
            }).catch(function(error) {
                submitButton.disabled = false;
                showPortalToast(error.message, 'danger');
            });
        });

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

<script>
    // Disable browser automatic scroll restoration
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }

    // Force scroll to top on DOM load and page unload/refresh
    window.addEventListener('beforeunload', function() {
        window.scrollTo(0, 0);
    });

    document.addEventListener('DOMContentLoaded', function() {
        window.scrollTo(0, 0);
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
</script>

</body>
</html>