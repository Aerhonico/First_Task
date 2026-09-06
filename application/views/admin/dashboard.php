<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SDCA OJT Tracker</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/sdcalogoorig1.png?v=2'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root { --sdca-red: #a12124; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; background-color: #f4f6f9; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1000' height='1000' viewBox='0 0 1000 1000'%3E%3Cg stroke='%23800000' stroke-width='1.2' fill='none' opacity='0.3'%3E%3Cpolygon points='100,200 400,100 700,300 900,150'/%3E%3Cpolygon points='300,800 600,950 900,700'/%3E%3Cline x1='100' y1='200' x2='600' y2='950'/%3E%3Cline x1='400' y1='100' x2='900' y2='700'/%3E%3Cline x1='700' y1='300' x2='300' y2='800'/%3E%3Ccircle cx='400' cy='100' r='4' fill='%23800000'/%3E%3Ccircle cx='700' cy='300' r='4' fill='%23800000'/%3E%3Ccircle cx='300' cy='800' r='4' fill='%23800000'/%3E%3C/g%3E%3C/svg%3E"); background-repeat: repeat; background-size: 800px 800px; animation: floatBackground 35s linear infinite; color: #212529; }
        @keyframes floatBackground { 0% { background-position: 0 0; } 50% { background-position: 100px -150px; } 100% { background-position: 0 0; } }
        .app-container { display: flex; min-height: 100vh; }
        .sidebar { width: 240px; height: 100vh; position: fixed; inset: 0 auto 0 0; display: flex; flex-direction: column; background: #fff; z-index: 1030; box-shadow: 4px 0 15px rgba(0,0,0,.1); overflow-y: auto; }
        .sidebar-brand { border-bottom: 1px solid #eee; }
        .sidebar-logo { max-height: 52px; width: auto; }
        .sidebar-menu { list-style: none; padding: 0; margin: 8px 0 0; }
        .sidebar-menu a { color: #343434; padding: 9px 16px; display: flex; align-items: center; gap: 10px; text-decoration: none; font-size: .82rem; font-weight: 500; border-left: 4px solid transparent; }
        .sidebar-menu a i { width: 20px; text-align: center; color: #6c757d; }
        .sidebar-menu a:hover, .sidebar-menu li.active a { background: #fff5f5; color: var(--sdca-red); border-left-color: var(--sdca-red); font-weight: 700; }
        .sidebar-menu li.active a i, .sidebar-menu a:hover i { color: var(--sdca-red); }
        .sidebar-time { font-family: 'Courier New', monospace; font-size: 1.55rem; font-weight: 700; color: #25292d; line-height: 1.1; }
        .sidebar-date { font-size: .78rem; color: #6c757d; font-weight: 600; }
        .sidebar-contact { margin-top: auto; padding: 10px 16px 12px; font-size: .63rem; color: #6c757d; }
        .sidebar-contact hr { margin: 0 0 8px; }
        .sidebar-contact-heading { color: var(--sdca-red); font-size: .67rem; font-weight: 700; }
        .sidebar-contact p { margin: 0 0 6px; line-height: 1.3; }
        .sidebar-contact strong { color: #343a40; font-size: .65rem; }
        .sidebar-contact a { color: var(--sdca-red); text-decoration: none; }
        .admin-nav-divider { border-left: 1px solid rgba(0, 0, 0, .35); }
        .top-navbar .container-fluid > .d-flex.align-items-stretch.h-100 > .d-flex.align-items-stretch.h-100 { border-left: 1px solid rgba(0, 0, 0, .35); border-right: 1px solid rgba(0, 0, 0, .35); }
        .main-content { flex: 1; margin-left: 240px; min-width: 0; }
        .top-navbar { height: 48px; background: var(--sdca-red); position: fixed; top: 0; left: 240px; width: calc(100% - 240px); z-index: 1020; }
        .main-content-area { padding: 76px 32px 28px; }
        .section-anchor { scroll-margin-top: 70px; }
/* Update button hover/focus to use dark maroon instead of dark grey */
.main-content .btn:not(:disabled):hover, 
.main-content .btn:not(:disabled):focus { 
    background-color: #5a0000 !important; /* Dark maroon hover block */
    border-color: #5a0000 !important; 
    color: #ffffff !important;
}        .stat-card { border: 0; border-left: 4px solid var(--sdca-red); }
        .section-card { border: 0; }
        .table td, .table th { vertical-align: middle; }
        .progress { height: 8px; min-width: 130px; }
        @media (max-width: 768px) { .sidebar { width: 76px; } .sidebar-brand span, .sidebar-menu span, .sidebar-clock { display: none; } .sidebar-menu a { justify-content: center; padding: 15px 8px; } .main-content { margin-left: 76px; } .main-content-area { padding: 76px 14px 20px; } .top-navbar { left: 76px; width: calc(100% - 76px); } .top-navbar .navbar-brand span { display: none; } }
        /* Container adjustments */
        .navbar-top, .top-header {
            background-color: #a12124 !important; /* Base maroon header background */
            padding: 0 !important;
    
}

/* Individual navbar block items (Inbox, Profile dropdown) */
.navbar-top .nav-item, 
.navbar-top .dropdown,
.navbar-top .inbox-btn {
    border-radius: 0 !important;
    border-left: 1px solid rgba(0, 0, 0, 0.2) !important; /* Dark vertical divider */
    border-right: 1px solid rgba(255, 255, 255, 0.1) !important; /* Light vertical highlight */
    padding: 8px 16px !important;
    margin: 0 !important;
}

/* Darker background state for the active profile tab */
.navbar-top .user-profile-tab {
    background-color: #5a0000 !important; /* Darker maroon block */
    border-radius: 0 !important;
}

/* Inbox notification pill styling */
.navbar-top .badge-danger, 
.navbar-top .inbox-count {
    background-color: #dc2626 !important;
    border-radius: 4px !important; /* Slightly rounded square pill */
    padding: 2px 6px !important;
    font-weight: bold;
    font-size: 11px;
}

/* Remove rounded corners from navbar buttons and their hover states */
.top-navbar .btn,
.top-navbar .nav-link,
.top-navbar .dropdown-toggle,
.nav-boxed-btn {
    border-radius: 0 !important;
}

/* Ensure hover state fills edge-to-edge without rounded corners */
.top-navbar .btn:hover,
.top-navbar .nav-link:hover,
.top-navbar .dropdown-toggle:hover,
.nav-boxed-btn:hover {
    border-radius: 0 !important;
    background-color: rgba(0, 0, 0, 0.25) !important;
}

.border-sdca {
    border-color: #a12124 !important;
}

.text-sdca {
    color: #a12124 !important;
}

/* Custom Quick Action Cards */
.quick-card {
    background-color: #ffffff;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.quick-card:hover {
    background-color: #f8f9fa !important; /* Soft gray hover instead of red */
    transform: translateY(-3px);
    box-shadow: 0 0.25rem 0.75rem rgba(0,0,0,0.1) !important;
}

.icon-circle {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-bottom: 6px;
}

.card-title-text {
    font-size: 0.75rem;
    font-weight: 700;
    color: #212529 !important;
}

.extra-small {
    font-size: 0.75rem; /* Reduces text height */
}

/* Circular Profile Avatar */
.avatar-circle {
    width: 36px;
    height: 36px;
    background-color: #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

/* Online/Offline Status Indicator Dot */
.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    flex-shrink: 0;
}

/* Top Navbar Text Font */
.navbar, 
.navbar * {
    font-family: 'Century Gothic', 'CenturyGothic', AppleGothic, sans-serif !important;
    font-weight: bold !important;
}

/* Sidebar Menu Base Items - ICT Guidelines */
.sidebar-menu a {
    font-family: 'Century Gothic', 'CenturyGothic', AppleGothic, sans-serif !important;
    font-weight: 400 !important; /* Century Gothic Regular */
    color: #343434;
    display: flex;
    align-items: center;
    padding: 10px 16px;
    text-decoration: none;
    border-radius: 0 !important;
    transition: background-color 0.2s ease, color 0.2s ease;
}

/* ICT Dropdown / Sidebar Active & Hover Selection State */
.sidebar-menu a:hover,
.sidebar-menu a.active,
.sidebar-menu li.active > a {
    border-radius: 0 !important;
    background-color: #a12124 !important; /* ICT Selection Box Color */
    color: #ffffff !important;            /* White text on active/hover */
}

/* Ensure icons turn white on hover/active */
.sidebar-menu a:hover i,
.sidebar-menu a.active i,
.sidebar-menu li.active > a i {
    color: #ffffff !important;
}

/* --- Base Dashboard Font Setup --- */
.main-content, 
.card, 
.card-body {
    font-family: 'Century Gothic', 'CenturyGothic', AppleGothic, sans-serif !important;
}

/* --- Bold Elements (Headings, Stat Counters, Section Titles) --- */
h1, h2, h3, h4, h5, h6,
.card-title,
.stat-number, 
.stat-card .number,
.stat-card h2,
.stat-card h3,
.quick-action-card span,
.quick-action-card p,
.table-title,
.section-header,
strong, 
b {
    font-family: 'Century Gothic', 'CenturyGothic', AppleGothic, sans-serif !important;
    font-weight: 700 !important; /* Century Gothic Bold */
}

/* --- Regular Elements (Subtitles, Descriptions, Dates, Captions) --- */
p, 
small, 
span, 
.text-muted, 
.stat-card .label,
.stat-card p,
.subtitle,
.timestamp,
.user-email,
td, 
th {
    font-family: 'Century Gothic', 'CenturyGothic', AppleGothic, sans-serif !important;
    font-weight: 400 !important; /* Century Gothic Regular */
}

#dtrSearchInput {
    width: 350px !important;
    max-width: 100%; /* Keeps it responsive on smaller screens */
}

/* SDCA Brand Spec: square corners on all interactive/container elements */
.btn,
.form-control,
.form-select,
.card,
.modal-content,
.modal-header,
.modal-footer,
.modal-body,
.badge,
.table,
.input-group {
    border-radius: 0 !important;
}

/* Custom tooltip styling for better readability */
.chartjs-tooltip {
    max-width: 300px;
    font-size: 0.75rem;
}

.chartjs-tooltip .tooltip-body {
    max-height: 200px;
    overflow-y: auto;
}
button[type="submit"]:disabled {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
    color: #fff !important;
    opacity: 0.5;
    cursor: not-allowed;
}

button[type="submit"]:not(:disabled) {
    background-color: #a12124 !important;
    border-color: #a12124 !important;
    color: #fff !important;
    opacity: 1;
    cursor: pointer;
    transition: all 0.2s ease;
}

button[type="submit"]:not(:disabled):hover {
    background-color: #801a1c !important;
    border-color: #801a1c !important;
}

/* Disabled button styling for Save Verification */
button[type="submit"].btn-disabled-look,
button[type="submit"]:disabled {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
    color: #fff !important;
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

button[type="submit"]:not(:disabled):not(.btn-disabled-look) {
    background-color: #a12124 !important;
    border-color: #a12124 !important;
    color: #fff !important;
    opacity: 1;
    cursor: pointer;
    transition: all 0.2s ease;
}

button[type="submit"]:not(:disabled):not(.btn-disabled-look):hover {
    background-color: #801a1c !important;
    border-color: #801a1c !important;
}
/* Inbox Dropdown Styling */
.dropdown-menu {
    border-radius: 0 !important;
    border: none !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
}

.dropdown-item {
    border-radius: 0 !important;
    transition: background-color 0.2s ease;
}

.dropdown-item:hover {
    background-color: #fff5f5 !important;
}

.dropdown-header {
    font-family: 'Century Gothic', sans-serif !important;
    font-size: 0.8rem !important;
}
    </style>
</head>
<body>
<div class="app-container">
    <aside class="sidebar">
        <div class="sidebar-brand p-3 text-center">
            <a href="<?= base_url('admin'); ?>"><img src="<?= base_url('assets/images/sdcalogo.png'); ?>" alt="SDCA Logo" class="sidebar-logo img-fluid"></a>
            <hr class="my-2">
                <div class="sidebar-clock">
                    <div class="small text-muted mb-2"><i class="bi bi-shield-lock me-1"></i>ADMIN PORTAL</div>
                    <div id="adminSidebarTime" class="text-dark fs-3 lh-1 mb-1" style="font-family: 'Oswald', sans-serif; letter-spacing: 0.5px;">--:--:-- --</div>
                    <div id="adminSidebarDate" class="sidebar-date mt-1">----------------</div>
                </div>        
            </div>
        <ul class="sidebar-menu">
            <li class="active"><a href="#dashboard"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
            <li><a href="#intern-management"><i class="fas fa-users"></i><span>Intern Management</span></a></li>
            <li><a href="#ojt-management"><i class="fas fa-user-clock"></i><span>OJT Management</span></a></li>
            <li><a href="#dtr-records"><i class="fas fa-calendar-alt"></i><span>DTR and Time Records</span></a></li>
            <li><a href="#analytics"><i class="fas fa-chart-line"></i><span>Analytics and Reports</span></a></li>
            <li><a href="#announcements"><i class="bi bi-megaphone"></i><span>Announcements</span></a></li>
            <li><a href="#inquiries"><i class="bi bi-question-circle"></i><span>Inquiries &amp; Concerns</span></a></li>
            <li><a href="#admin-tools"><i class="fas fa-cogs"></i><span>Administrative Tools</span></a></li>
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
    <div class="main-content">
        <nav class="top-navbar navbar navbar-dark p-0 shadow-sm">
    <div class="container-fluid px-4 d-flex align-items-stretch justify-content-between h-100">
        <!-- Brand Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center m-0 p-0 h-100" href="#dashboard">
            <i class="bi bi-clock-history me-2"></i>OJT Hours Tracker
        </a>
        
        <!-- Right Side Dropdowns -->
        <div class="d-flex align-items-stretch h-100">
            <div class="d-flex align-items-stretch h-100">
                
                <!-- 1. INBOX DROPDOWN (Updated with Inquiries) -->
                <div class="dropdown d-flex align-items-stretch h-100">
                    <button class="btn text-white d-flex align-items-center gap-2 px-3 border-0" type="button" data-bs-toggle="dropdown">
                        <span class="badge bg-danger"><?= (int)$pending_count + (int)$inbox_inquiry_count; ?></span>
                        <i class="bi bi-inbox-fill opacity-75"></i>
                        <span class="fw-semibold">Inbox</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm p-0" style="width: 380px; max-height: 400px; overflow-y: auto;">
                        <!-- Header -->
                        <li class="dropdown-header fw-bold bg-light border-bottom py-2">
                            <i class="bi bi-inbox me-2"></i>Pending Items (<?= (int)$pending_count + (int)$inbox_inquiry_count; ?>)
                        </li>
                        
                        <!-- Intern Registrations -->
                        <?php if ((int)$pending_intern_count > 0): ?>
                        <li>
                            <a href="#intern-management" class="dropdown-item py-2 border-bottom" onclick="switchAdminModule('intern-management', document.querySelector('.sidebar-menu a[href=\'#intern-management\']')); return false;">
                                <div class="d-flex align-items-center">
                                    <div class="me-2" style="width: 32px; height: 32px; background-color: #fff3e0; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person-plus text-warning"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small">Intern Registrations</div>
                                        <small class="text-muted"><?= (int)$pending_intern_count; ?> pending approval(s)</small>
                                    </div>
                                    <span class="badge bg-warning text-dark ms-2"><?= (int)$pending_intern_count; ?></span>
                                </div>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <!-- Deletion Requests -->
                        <?php if ((int)$request_count > 0): ?>
                        <li>
                            <a href="#intern-management" class="dropdown-item py-2 border-bottom" onclick="switchAdminModule('intern-management', document.querySelector('.sidebar-menu a[href=\'#intern-management\']')); return false;">
                                <div class="d-flex align-items-center">
                                    <div class="me-2" style="width: 32px; height: 32px; background-color: #ffebee; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-exclamation-triangle text-danger"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small">Deletion Requests</div>
                                        <small class="text-muted"><?= (int)$request_count; ?> request(s)</small>
                                    </div>
                                    <span class="badge bg-danger ms-2"><?= (int)$request_count; ?></span>
                                </div>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <!-- Intern Inquiries -->
                        <?php if (!empty($inbox_inquiries)): ?>
                        <li><hr class="dropdown-divider my-0"></li>
                        <li class="dropdown-header fw-bold bg-light border-bottom py-2">
                            <i class="bi bi-chat-dots me-2"></i>Intern Inquiries (<?= $inbox_inquiry_count; ?>)
                        </li>
                        <?php foreach ($inbox_inquiries as $inquiry): ?>
                        <li>
                            <a href="#inquiries" class="dropdown-item py-2 border-bottom" onclick="switchAdminModule('inquiries', document.querySelector('.sidebar-menu a[href=\'#inquiries\']')); return false;">
                                <div class="d-flex align-items-start">
                                    <div class="me-2 flex-shrink-0" style="width: 32px; height: 32px; background-color: #e3f2fd; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small">
                                            <?= html_escape(trim($inquiry['first_name'] . ' ' . $inquiry['last_name'])); ?>
                                            <span class="badge bg-secondary ms-1" style="font-size: 0.6rem;"><?= html_escape($inquiry['category']); ?></span>
                                        </div>
                                        <div class="small text-muted" style="font-size: 0.7rem;">
                                            <?= html_escape(substr($inquiry['message'], 0, 60)); ?><?= strlen($inquiry['message']) > 60 ? '...' : ''; ?>
                                        </div>
                                        <small class="text-muted" style="font-size: 0.65rem;">
                                            <i class="bi bi-clock me-1"></i><?= date('M d, g:i A', strtotime($inquiry['created_at'])); ?>
                                        </small>
                                    </div>
                                    <span class="badge bg-danger ms-2 align-self-start">New</span>
                                </div>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <!-- Empty State -->
                        <?php if ((int)$pending_count === 0 && empty($inbox_inquiries)): ?>
                        <li>
                            <div class="dropdown-item py-4 text-center text-muted">
                                <i class="bi bi-check-circle display-6 d-block mb-2 text-success"></i>
                                <div class="fw-semibold">All caught up!</div>
                                <small>No pending items or inquiries.</small>
                            </div>
                        </li>
                        <?php endif; ?>
                        
                        <!-- Footer -->
                        <li class="border-top">
                            <a href="#inquiries" class="dropdown-item text-center py-2 fw-semibold text-sdca" onclick="switchAdminModule('inquiries', document.querySelector('.sidebar-menu a[href=\'#inquiries\']')); return false;">
                                <i class="bi bi-eye me-1"></i>View All Inquiries
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- 2. ADMINISTRATOR PROFILE DROPDOWN (Original) -->
                <div class="dropdown admin-nav-divider d-flex align-items-center h-100">
                    <button class="btn dropdown-toggle d-flex align-items-center gap-2 px-3 border-0 bg-transparent text-white h-100" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-4"></i>
                        <div class="text-start lh-sm">
                            <span class="d-block fw-bold text-white" style="font-size:.85rem;">Administrator</span>
                            <span class="d-block text-white-50" style="font-size:.7rem;">Admin</span>
                        </div>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow border-0 p-0 overflow-hidden" style="width:260px;">
                        <div class="text-center p-3 bg-light border-bottom">
                            <i class="bi bi-shield-lock display-5 text-dark d-block mb-1"></i>
                            <h6 class="fw-bold mb-0">Administrator</h6>
                            <small class="text-muted">ADMIN ACCOUNT</small>
                        </div>
                        <div class="list-group list-group-flush small">
                            <a href="<?= base_url('portfolio'); ?>" class="list-group-item list-group-item-action py-2"><i class="bi bi-eye me-2"></i>View Portfolio</a>
                            <a href="<?= base_url('portfolio/edit'); ?>" class="list-group-item list-group-item-action py-2"><i class="bi bi-pencil-square me-2"></i>Edit Portfolio</a>
                            <a href="<?= base_url('auth/logout'); ?>" class="list-group-item list-group-item-action py-2 text-danger fw-bold btn-logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</nav>
        <main class="main-content-area">
            <?php if ($this->session->flashdata('success')): ?><div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;"><div id="successToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true"><div class="d-flex"><div class="toast-body"><?= html_escape($this->session->flashdata('success')); ?></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div></div><?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= html_escape($this->session->flashdata('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

        <section id="dashboard" class="section-anchor mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h3 class="fw-bold mb-1">Admin Dashboard</h3>
                    <p class="text-muted mb-0">System-wide internship monitoring and verification.</p>
                </div>
            </div>
            
            <div class="row g-3">
                <!-- Registered Interns -->
                <div class="col-md-3">
                    <div class="card stat-card shadow-sm p-3 border-0 border-start border-4 border-sdca">
                        <div class="d-flex align-items-center">
                            <div class="me-3 fs-1 text-sdca">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block">Registered Interns</small>
                                <h2 class="mb-0 fw-bold"><?= (int)$intern_count; ?></h2>
                                <small class="text-muted">Admin-verified accounts</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Time Ins Today -->
                <div class="col-md-3">
                    <div class="card stat-card shadow-sm p-3 border-0 border-start border-4 border-sdca">
                        <div class="d-flex align-items-center">
                            <div class="me-3 fs-1 text-sdca">
                                <i class="bi bi-fingerprint"></i>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block">Time Ins Today</small>
                                <h2 class="mb-0 fw-bold"><?= (int)$time_ins_today; ?></h2>
                                <small class="text-muted">Intern attendance for today</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Approvals / Requests -->
                <div class="col-md-3">
                    <div class="card stat-card shadow-sm p-3 border-0 border-start border-4 border-sdca">
                        <div class="d-flex align-items-center">
                            <div class="me-3 fs-1 text-sdca">
                                <i class="bi bi-file-earmark-check-fill"></i>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block">Pending Approvals</small>
                                <h2 class="mb-0 fw-bold"><?= (int)$pending_count; ?></h2>
                                <small class="text-muted">Interns: <?= (int)$pending_intern_count; ?> · Deletions: <?= (int)$request_count; ?></small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Late Today -->
                <div class="col-md-3">
                    <div class="card stat-card shadow-sm p-3 border-0 border-start border-4 border-sdca">
                        <div class="d-flex align-items-center">
                            <div class="me-3 fs-1 text-sdca">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block">Late Today</small>
                                <h2 class="mb-0 fw-bold"><?= (int)$late_today; ?></h2>
                                <small class="text-muted">Time-ins after 8:00 AM</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-2 mt-2">
                <div>
                    <h6 class="fw-bold mb-1">Quick Actions</h6>
                </div>
    <!-- Manage Interns -->
    <div class="col-6 col-md-4 col-lg">
        <button type="button" class="quick-card p-2 border rounded shadow-sm w-100" style="background: #ffffff; border: 1px solid #ddd; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#manageInternsModal">
            <div class="icon-circle" style="background-color: #e3f2fd; color: #1976d2;">
                <i class="bi bi-people-fill"></i>
            </div>
            <span class="card-title-text">Manage Interns</span>
        </button>
    </div>

    <!-- Review DTR Records -->
    <div class="col-6 col-md-4 col-lg">
        <button type="button" class="quick-card p-2 border rounded shadow-sm w-100" style="background: #ffffff; border: 1px solid #ddd; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#reviewDTRModal">
            <div class="icon-circle" style="background-color: #e8f5e9; color: #388e3c;">
                <i class="bi bi-clock-history"></i>
            </div>
            <span class="card-title-text">Review DTR</span>
        </button>
    </div>

    <!-- Pending Approvals -->
    <div class="col-6 col-md-4 col-lg">
        <button type="button" class="quick-card p-2 border rounded shadow-sm w-100" style="background: #ffffff; border: 1px solid #ddd; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#pendingApprovalsModal">
            <div class="icon-circle" style="background-color: #fff3e0; color: #f57c00;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <span class="card-title-text">Pending Approvals</span>
        </button>
    </div>

    <!-- View Analytics -->
    <div class="col-6 col-md-4 col-lg">
        <a href="#analytics" id="viewAnalyticsCard" style="text-decoration: none; color: inherit;" class="quick-card p-2 border rounded shadow-sm">
            <div class="icon-circle" style="background-color: #e0f2f1; color: #00897b;">
                <i class="bi bi-bar-chart-line-fill"></i>
            </div>
            <span class="card-title-text">View Analytics</span>
        </a>
    </div>

    <!-- Post Announcement -->
    <div class="col-6 col-md-4 col-lg">
        <button type="button" class="quick-card p-2 border rounded shadow-sm w-100" style="background: #ffffff; border: 1px solid #ddd; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#newAnnouncementModal">
            <div class="icon-circle" style="background-color: #ffebee; color: #a12124;">
                <i class="bi bi-megaphone-fill"></i>
            </div>
            <span class="card-title-text">Post an Announcement</span>
        </button>
    </div>

    <!-- Administrative Tools -->
    <div class="col-6 col-md-4 col-lg">
        <a href="#admin-tools" id="adminToolsCard" style="text-decoration: none; color: inherit;" class="quick-card p-2 border rounded shadow-sm">
            <div class="icon-circle" style="background-color: #f3e5f5; color: #7b1fa2;">
                <i class="bi bi-gear-wide-connected"></i>
            </div>
            <span class="card-title-text">Admin Tools</span>
        </a>
    </div>
</div>
        </section>
            <section id="dashboard-quick-panels" class="row g-2 mb-4">
            <!-- Latest Time In / Time Outs -->
            <div class="col-lg-6">
                <div class="card section-card shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between">
                        <strong><i class="bi bi-clock-history me-2"></i>Latest Time In / Time Outs</strong>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php if (!empty($latest_attendance)): foreach (array_slice($latest_attendance, 0, 3) as $attendance): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <i class="bi bi-person-fill text-secondary"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark"><?= html_escape(trim($attendance['first_name'] . ' ' . $attendance['last_name'])); ?></strong>
                                        <small class="text-muted"><?= html_escape($attendance['log_date']); ?> · In: <?= html_escape($attendance['time_in']); ?><?php if (!empty($attendance['time_out'])): ?> · Out: <?= html_escape($attendance['time_out']); ?><?php endif; ?></small>
                                    </div>
                                </div>
                                <span class="small text-muted ms-2"><?= !empty($attendance['time_out']) ? 'Timed out' : 'Timed in'; ?></span>
                            </div>
                        <?php endforeach; else: ?>
                            <div class="list-group-item text-muted">No attendance activity yet.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Newly Approved Interns -->
            <div class="col-lg-6">
                <div class="card section-card shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between">
                        <strong><i class="bi bi-person-check me-2"></i>Newly Approved Interns</strong>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php if (!empty($newly_approved_interns)): foreach ($newly_approved_interns as $approved): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <i class="bi bi-person-fill text-secondary"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark"><?= html_escape(trim($approved['first_name'] . ' ' . $approved['last_name'])); ?></strong>
                                        <small class="text-muted d-block"><?= html_escape($approved['email']); ?></small>
                                    </div>
                                </div>
                                <small class="text-muted ms-2"><?= html_escape($approved['created_at']); ?></small>
                            </div>
                        <?php endforeach; else: ?>
                            <div class="list-group-item text-muted">No approved interns yet.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Interns to Approve -->
            <div class="col-lg-6 mt-4">
                <div class="card section-card shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between">
                        <strong><i class="bi bi-person-plus me-2"></i>Interns to Approve</strong>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php if (!empty($interns_to_approve)): foreach ($interns_to_approve as $pending_intern): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <i class="bi bi-person-fill text-secondary"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark"><?= html_escape(trim($pending_intern['first_name'] . ' ' . $pending_intern['last_name'])); ?></strong>
                                        <small class="text-muted d-block"><?= html_escape($pending_intern['email']); ?></small>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 ms-2">
                                    <button type="button" class="btn btn-sm btn-success intern-decision-button" data-decision="approve" data-decision-url="<?= base_url('admin/approve_intern/' . (int)$pending_intern['id']); ?>" data-bs-toggle="modal" data-bs-target="#internDecisionModal">Approve</button>
                                    <button type="button" class="btn btn-sm btn-danger intern-decision-button" data-decision="deny" data-decision-url="<?= base_url('admin/reject_intern/' . (int)$pending_intern['id']); ?>" data-bs-toggle="modal" data-bs-target="#internDecisionModal">Deny</button>
                                </div>
                            </div>
                        <?php endforeach; else: ?>
                            <div class="list-group-item text-muted">No interns awaiting approval.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Deletion Requests -->
            <div class="col-lg-6 mt-4">
                <div class="card section-card shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <strong><i class="bi bi-envelope-exclamation me-2"></i>Deletion Requests</strong>
                        <?php if (!empty($requests)): ?>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#clearDeletionRequestsModal">Clear</button>
                        <?php endif; ?>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php if (!empty($requests)): foreach ($requests as $request): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <i class="bi bi-person-fill text-secondary"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark"><?= html_escape($request['sender_name']); ?></strong>
                                        <small class="text-muted d-block"><?= html_escape($request['subject']); ?></small>
                                    </div>
                                </div>
                                <a href="<?= base_url('admin/mark_request_read/' . (int)$request['id']); ?>" class="btn btn-sm btn-outline-success ms-2">Review</a>
                            </div>
                        <?php endforeach; else: ?>
                            <div class="list-group-item text-muted">No deletion requests.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

            <section id="intern-management" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white d-flex justify-content-between align-items-center"><h5 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i>Intern Management & Verification</h5><div><button type="button" class="btn btn-sm btn-outline-danger me-2" data-bs-toggle="modal" data-bs-target="#rejectedInternsModal"><i class="bi bi-person-x me-1"></i>Rejected Registrations <span class="badge bg-danger"><?= (int)$rejected_intern_count; ?></span></button><a href="#intern-management" class="btn btn-sm btn-outline-primary"><i class="bi bi-search me-1"></i>Search Directory</a></div></div><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Intern</th><th>Department / School</th><th>Supervisor</th><th>Progress</th><th>Status</th><th>Action</th></tr></thead><tbody><?php if (!empty($interns)): foreach ($interns as $intern): ?><?php $progress = $required_hours > 0 ? min(100, round(((float)$intern['rendered_hours'] / $required_hours) * 100, 1)) : 0; ?><tr><td><strong><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></strong><br><small class="text-muted"><?= html_escape($intern['email']); ?></small></td><td><?= html_escape(!empty($intern['school']) ? $intern['school'] : 'Not assigned'); ?></td><td>Not assigned</td><td><div class="d-flex justify-content-between small"><span><?= number_format((float)$intern['rendered_hours'], 1); ?> / <?= number_format((float)$required_hours, 0); ?> hrs</span><strong><?= $progress; ?>%</strong></div><div class="progress"><div class="progress-bar bg-danger" style="width:<?= $progress; ?>%"></div></div></td><td><?php $intern_st = strtolower(trim($intern['account_status'] ?? '')); $intern_badge = ($intern_st === 'done') ? 'text-bg-secondary' : (($intern_st === 'terminated') ? 'text-bg-danger' : 'text-bg-success'); $intern_label = ($intern_st === 'done') ? 'Done' : (($intern_st === 'terminated') ? 'Terminated' : 'Active'); ?><span class="badge <?= $intern_badge; ?>"><?= $intern_label; ?></span></td><td><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#intern<?= (int)$intern['id']; ?>"><i class="bi bi-pencil"></i> Edit</button></td></tr><?php endforeach; else: ?><tr><td colspan="6" class="text-center text-muted py-4">No intern accounts found.</td></tr><?php endif; ?></tbody></table></div></section>
            <?php if (!empty($interns)): foreach ($interns as $intern): ?>
            <div class="modal fade" id="intern<?= (int)$intern['id']; ?>" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="<?= base_url('admin/update_intern/' . (int)$intern['id']); ?>" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title">Verify / Edit Intern Account</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <?php foreach (array('first_name' => 'First Name', 'middle_name' => 'Middle Name', 'last_name' => 'Last Name', 'email' => 'Email', 'student_id' => 'Student ID', 'school' => 'Department / School', 'year_section' => 'Year / Section', 'academic_year' => 'Academic Year', 'semester' => 'Semester') as $field => $label): ?>
                                        <div class="col-md-4">
                                            <label class="form-label"><?= $label; ?></label>
                                            <input type="<?= $field === 'email' ? 'email' : 'text'; ?>" class="form-control" name="<?= $field; ?>" value="<?= html_escape($intern[$field]); ?>" <?= in_array($field, array('first_name', 'last_name', 'email')) ? 'required' : ''; ?>>
                                        </div>
                                    <?php endforeach; ?>

                                    <!-- Account Status Dropdown Field -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Account Status</label>
                                        <select name="status" class="form-select">
                                            <?php $st = strtolower(trim($intern['account_status'] ?? '')); ?>
                                            <option value="active" <?= ($st === 'active' || $st === 'approved' || $st === 'pending') ? 'selected' : ''; ?>>Active</option>
                                            <option value="done" <?= ($st === 'done') ? 'selected' : ''; ?>>Done</option>
                                            <option value="terminated" <?= ($st === 'terminated' || $st === 'rejected' || $st === 'deactivated') ? 'selected' : ''; ?>>Terminated</option>
                                        </select>
                                    </div>

                                    <!-- Role/Position Field -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Role/Position</label>
                                        <select name="role_position" class="form-select">
                                            <?php $current_role = $intern['role_position'] ?? 'Web Developer'; ?>
                                            <option value="Web Developer" <?= ($current_role === 'Web Developer') ? 'selected' : ''; ?>>Web Developer</option>
                                            <option value="Technical Support" <?= ($current_role === 'Technical Support') ? 'selected' : ''; ?>>Technical Support</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save Intern</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
            <div class="modal fade" id="rejectedInternsModal" tabindex="-1" aria-labelledby="rejectedInternsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectedInternsModalLabel"><i class="bi bi-person-x me-2"></i>Rejected Intern Registrations</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <?php if (!empty($rejected_interns)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light"><tr><th>Intern</th><th>Department / School</th><th>Rejected On</th></tr></thead>
                                    <tbody>
                                        <?php foreach ($rejected_interns as $rejected): ?>
                                        <tr>
                                            <td><strong><?= html_escape(trim($rejected['first_name'] . ' ' . $rejected['last_name'])); ?></strong><br><small class="text-muted"><?= html_escape($rejected['email']); ?></small></td>
                                            <td><?= html_escape(!empty($rejected['school']) ? $rejected['school'] : 'Not assigned'); ?></td>
                                            <td><?= !empty($rejected['created_at']) ? date('M d, Y g:i A', strtotime($rejected['created_at'])) : 'N/A'; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <p class="text-muted text-center mb-0">No rejected intern registrations.</p>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <section id="ojt-management" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white"><h5 class="mb-0 fw-bold"><i class="bi bi-person-check me-2"></i>OJT Management & Verification</h5></div><div class="table-responsive"><table id="ojtManagementTable" class="table table-hover mb-0"><thead class="table-light"><tr><th>Intern</th><th>Date</th><th>Task Description</th><th>Hours</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php if (!empty($recent_logs)): foreach ($recent_logs as $log): ?><tr><td><?= html_escape(trim($log['first_name'] . ' ' . $log['last_name'])); ?></td><td><?= html_escape($log['log_date']); ?></td><td><?= html_escape($log['task_summary']); ?></td><td><?= number_format((float)$log['hours_rendered'], 2); ?></td><td><span class="badge text-bg-secondary"><?= html_escape($log['status']); ?></span></td><td><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#log<?= (int)$log['id']; ?>">Edit / Verify</button> <button type="button" class="btn btn-sm btn-outline-danger delete-log-button" data-delete-url="<?= base_url('admin/delete_log/' . (int)$log['id'] . '?redirect=ojt-management'); ?>" data-bs-toggle="modal" data-bs-target="#deleteLogModal">Delete</button></td></tr><?php endforeach; else: ?><tr><td colspan="6" class="text-center text-muted py-4">No OJT records found.</td></tr><?php endif; ?></tbody></table></div></section>
            <?php if (!empty($recent_logs)): foreach ($recent_logs as $log): ?><div class="modal fade" id="log<?= (int)$log['id']; ?>" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form action="<?= base_url('admin/update_log/' . (int)$log['id']); ?>" method="POST"><input type="hidden" name="redirect" value="ojt-management"><div class="modal-header"><h5 class="modal-title">Verify OJT Record</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><label class="form-label">Date</label><input type="date" name="log_date" class="form-control mb-2" value="<?= html_escape($log['log_date']); ?>" required><label class="form-label">Time In</label><input name="time_in" class="form-control mb-2" value="<?= html_escape($log['time_in']); ?>" required><label class="form-label">Time Out</label><input name="time_out" class="form-control mb-2" value="<?= html_escape($log['time_out']); ?>"><label class="form-label">Hours Rendered</label><input type="number" step="0.01" name="hours_rendered" class="form-control mb-2" value="<?= html_escape($log['hours_rendered']); ?>"><label class="form-label">Task Description</label><textarea name="task_summary" class="form-control mb-2"><?= html_escape($log['task_summary']); ?></textarea><label class="form-label">Verification Status</label><select name="status" class="form-select"><?php $log_st = $log['status']; foreach (array('Pending', 'Approved', 'Rejected', 'Completed') as $log_status_option): ?><option <?= ($log_st === $log_status_option) ? 'selected' : ''; ?>><?= $log_status_option; ?></option><?php endforeach; ?></select></div><div class="modal-footer"><button type="submit" class="btn btn-primary">Save Verification</button></div></form></div></div></div><?php endforeach; endif; ?>

            <section id="dtr-records" class="section-anchor card section-card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold"><i class="bi bi-calendar3 me-2"></i>DTR and Time Records</h5>
    </div>
    
    <!-- Filter Bar -->
    <div class="card-body border-bottom bg-light">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold small mb-1">
                    <i class="bi bi-calendar-month me-1"></i>Filter by Month
                </label>
                <select id="dtrMonthFilter" class="form-select form-select-sm">
                    <option value="">All Months</option>
                    <?php 
                    $month_names = ['', 'January', 'February', 'March', 'April', 'May', 'June', 
                                   'July', 'August', 'September', 'October', 'November', 'December'];
                    for ($m = 1; $m <= 12; $m++): 
                    ?>
                        <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT); ?>"><?= $month_names[$m]; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small mb-1">
                    <i class="bi bi-calendar-week me-1"></i>Filter by Week
                </label>
                <select id="dtrWeekFilter" class="form-select form-select-sm">
                    <option value="">All Weeks</option>
                    <option value="1">Week 1 (Days 1-7)</option>
                    <option value="2">Week 2 (Days 8-14)</option>
                    <option value="3">Week 3 (Days 15-21)</option>
                    <option value="4">Week 4 (Days 22-28)</option>
                    <option value="5">Week 5 (Days 29-31)</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" id="dtrApplyFilter" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i>Apply
                </button>
            </div>
            <div class="col-md-2">
                <button type="button" id="dtrClearFilter" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="bi bi-x-circle me-1"></i>Clear
                </button>
            </div>
        </div>
        
        <!-- Filter Summary -->
        <div class="mt-2 small text-muted" id="dtrFilterSummary">
            <i class="bi bi-info-circle me-1"></i>
            Showing <strong id="dtrVisibleCount"><?= count($recent_logs); ?></strong> of <strong><?= count($recent_logs); ?></strong> records
        </div>
    </div>

    <div class="table-responsive">
        <table id="dtrRecordsTable" class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Intern</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Rendered</th>
                    <th>Role/Position</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recent_logs)): foreach ($recent_logs as $log): 
                    // Calculate month and week for filtering
                    $log_month = date('m', strtotime($log['log_date']));
                    $log_day = (int)date('d', strtotime($log['log_date']));
                    $log_week = ceil($log_day / 7);
                ?>
                    <tr class="dtr-record-row" 
                        data-month="<?= $log_month; ?>" 
                        data-week="<?= $log_week; ?>">
                        <td><?= html_escape(trim($log['first_name'] . ' ' . $log['last_name'])); ?></td>
                        <td><?= html_escape($log['log_date']); ?></td>
                        <td><?= html_escape($log['time_in']); ?></td>
                        <td><?= !empty($log['time_out']) ? html_escape($log['time_out']) : '<span class="badge bg-warning text-dark">Timed in</span>'; ?></td>
                        <td><?= number_format((float)$log['hours_rendered'], 2); ?> hrs</td>
                        <td>
                            <?php 
                            $role = !empty($log['role_position']) ? $log['role_position'] : 'Web Developer';
                            $role_badge = ($role === 'Web Developer') ? 'bg-primary' : 'bg-success';
                            ?>
                            <span class="badge <?= $role_badge; ?>"><?= html_escape($role); ?></span>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No DTR records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
            <section id="analytics" class="section-anchor card section-card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold"><i class="bi bi-bar-chart-line me-2"></i>Program Analytics & Reports</h5>
                        <small class="text-muted">Academic Year: <?= html_escape($academic_year); ?></small>
                    </div>
                    <button class="btn btn-sm btn-outline-sdca" onclick="window.print()">
                        <i class="bi bi-printer me-1"></i>Print Report
                    </button>
                </div>
                <div class="card-body">
                    <!-- Summary Statistics Cards (Clickable) -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card border-start border-4 border-sdca shadow-sm h-100" style="cursor: pointer;" 
                                data-bs-toggle="modal" data-bs-target="#totalInternsModal">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle me-3" style="background-color: #ffebee; color: #a12124;">
                                            <i class="bi bi-people-fill"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-semibold d-block">Total Interns</small>
                                            <h3 class="mb-0 fw-bold"><?= (int)$intern_count; ?></h3>
                                            <small class="text-muted">Click to view list</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-start border-4 border-success shadow-sm h-100" style="cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#thisMonthModal">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle me-3" style="background-color: #e8f5e9; color: #388e3c;">
                                            <i class="bi bi-calendar-check"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-semibold d-block">This Month</small>
                                            <h3 class="mb-0 fw-bold"><?= (int)$this_month_interns; ?></h3>
                                            <small class="text-muted">New registrations</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-start border-4 border-primary shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle me-3" style="background-color: #e3f2fd; color: #1976d2;">
                                            <i class="bi bi-clock-history"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-semibold d-block">Total Hours</small>
                                            <h3 class="mb-0 fw-bold"><?= number_format($total_hours_rendered, 0); ?></h3>
                                            <small class="text-muted">All time rendered</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-start border-4 border-info shadow-sm h-100" style="cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#newInternsModal">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle me-3" style="background-color: #e1f5fe; color: #0288d1;">
                                            <i class="bi bi-person-plus-fill"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-semibold d-block">New Interns This Month</small>
                                            <h3 class="mb-0 fw-bold"><?= (int)$this_month_interns; ?></h3>
                                            <small class="text-muted">Click to view list</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row 1 -->
                    <div class="row g-3 mb-4">
                        <!-- Interns by Gender - Pie Chart -->
                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0 fw-bold"><i class="bi bi-pie-chart me-2"></i>Interns by Gender</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="genderChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Interns by School/Department - Bar Chart -->
                        <div class="col-md-8">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0 fw-bold"><i class="bi bi-bar-chart me-2"></i>Interns by School/Department</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="schoolChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row 2 -->
                    <div class="row g-3 mb-4">
                        <!-- Monthly Registration Trend - Line Chart -->
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0 fw-bold"><i class="bi bi-graph-up me-2"></i>Monthly Registration Trend</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="monthlyChart" height="220"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Intern Status Distribution - Doughnut Chart -->
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0 fw-bold"><i class="bi bi-donut-chart me-2"></i>Intern Status Distribution</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="statusChart" height="220"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hours & Progression Metrics Section -->
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0 fw-bold text-sdca"><i class="bi bi-speedometer2 me-2"></i>Hours & Progression Metrics</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Tabs for different metrics -->
                                    <ul class="nav nav-tabs mb-3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pending-approval-tab" data-bs-toggle="tab" data-bs-target="#pending-approval" type="button" role="tab">
                                                <i class="bi bi-clock-history me-2"></i>Pending Hours Approval 
                                                <span class="badge bg-warning text-dark ms-1"><?= count($pending_approval_interns); ?></span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="behind-schedule-tab" data-bs-toggle="tab" data-bs-target="#behind-schedule" type="button" role="tab">
                                                <i class="bi bi-exclamation-triangle me-2"></i>Behind Schedule 
                                                <span class="badge bg-danger ms-1"><?= count($behind_schedule_interns); ?></span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="near-completion-tab" data-bs-toggle="tab" data-bs-target="#near-completion" type="button" role="tab">
                                                <i class="bi bi-trophy me-2"></i>Near Completion (80%+) 
                                                <span class="badge bg-success ms-1"><?= count($near_completion_interns); ?></span>
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <!-- Pending Hours Approval Tab -->
                                        <div class="tab-pane fade show active" id="pending-approval" role="tabpanel">
                                            <?php if (!empty($pending_approval_interns)): ?>
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Intern Name</th>
                                                            <th>School/Department</th>
                                                            <th>Pending Logs</th>
                                                            <th>Total Pending Hours</th>
                                                            <th>Submission Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($pending_approval_interns as $pending): ?>
                                                        <tr>
                                                            <td><strong><?= html_escape(trim($pending['first_name'] . ' ' . $pending['last_name'])); ?></strong></td>
                                                            <td><?= html_escape($pending['school'] ?? 'Not assigned'); ?></td>
                                                            <td><span class="badge bg-warning text-dark"><?= (int)$pending['pending_logs']; ?> logs</span></td>
                                                            <td><?= number_format((float)$pending['pending_hours'], 1); ?> hrs</td>
                                                            <td><?= date('M d, Y', strtotime($pending['latest_submission'])); ?></td>
                                                            <td>
                                                                <a href="#ojt-management" class="btn btn-sm btn-outline-primary" onclick="switchAdminModule('ojt-management')">
                                                                    <i class="bi bi-eye me-1"></i>Review
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php else: ?>
                                            <p class="text-muted text-center mb-0"><i class="bi bi-check-circle me-2"></i>No pending hours awaiting approval.</p>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Behind Schedule Tab -->
                                        <div class="tab-pane fade" id="behind-schedule" role="tabpanel">
                                            <?php if (!empty($behind_schedule_interns)): ?>
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Intern Name</th>
                                                            <th>School/Department</th>
                                                            <th>Hours Rendered</th>
                                                            <th>Expected Hours</th>
                                                            <th>Shortfall</th>
                                                            <th>Progress</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($behind_schedule_interns as $behind): ?>
                                                        <tr>
                                                            <td><strong><?= html_escape(trim($behind['first_name'] . ' ' . $behind['last_name'])); ?></strong></td>
                                                            <td><?= html_escape($behind['school'] ?? 'Not assigned'); ?></td>
                                                            <td><?= number_format((float)$behind['rendered_hours'], 1); ?> hrs</td>
                                                            <td><?= number_format((float)$behind['expected_hours'], 1); ?> hrs</td>
                                                            <td><span class="text-danger fw-bold">-<?= number_format((float)$behind['shortfall'], 1); ?> hrs</span></td>
                                                            <td>
                                                                <div class="progress" style="height: 8px; width: 150px;">
                                                                    <div class="progress-bar bg-danger" style="width: <?= $behind['progress']; ?>%"></div>
                                                                </div>
                                                                <small class="text-danger"><?= $behind['progress']; ?>%</small>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php else: ?>
                                            <p class="text-muted text-center mb-0"><i class="bi bi-check-circle me-2"></i>All interns are on track with their weekly targets.</p>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Near Completion Tab -->
                                        <div class="tab-pane fade" id="near-completion" role="tabpanel">
                                            <?php if (!empty($near_completion_interns)): ?>
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Intern Name</th>
                                                            <th>School/Department</th>
                                                            <th>Hours Rendered</th>
                                                            <th>Required Hours</th>
                                                            <th>Remaining</th>
                                                            <th>Progress</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($near_completion_interns as $near): ?>
                                                        <tr>
                                                            <td><strong><?= html_escape(trim($near['first_name'] . ' ' . $near['last_name'])); ?></strong></td>
                                                            <td><?= html_escape($near['school'] ?? 'Not assigned'); ?></td>
                                                            <td><?= number_format((float)$near['rendered_hours'], 1); ?> hrs</td>
                                                            <td><?= number_format((float)$required_hours, 0); ?> hrs</td>
                                                            <td><span class="text-success fw-bold"><?= number_format((float)$near['remaining_hours'], 1); ?> hrs</span></td>
                                                            <td>
                                                                <div class="progress" style="height: 8px; width: 150px;">
                                                                    <div class="progress-bar bg-success" style="width: <?= $near['progress']; ?>%"></div>
                                                                </div>
                                                                <small class="text-success fw-bold"><?= $near['progress']; ?>%</small>
                                                            </td>
                                                            <td><span class="badge bg-success">Ready for Final Eval</span></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php else: ?>
                                            <p class="text-muted text-center mb-0"><i class="bi bi-info-circle me-2"></i>No interns in the 80%+ completion range yet.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- New Interns This Month Modal -->
            <div class="modal fade" id="newInternsModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title"><i class="bi bi-person-plus-fill me-2"></i>New Interns This Month (<?= date('F Y'); ?>)</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <?php if (!empty($this_month_interns_list)): ?>
                            <div class="alert alert-info border-0">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong><?= count($this_month_interns_list); ?></strong> new intern(s) registered in <?= date('F Y'); ?>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>School/Department</th>
                                            <th>Registration Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 1; foreach ($this_month_interns_list as $intern): ?>
                                        <tr>
                                            <td><?= $counter++; ?></td>
                                            <td><strong><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></strong></td>
                                            <td><?= html_escape($intern['email']); ?></td>
                                            <td><?= html_escape($intern['school'] ?? 'Not assigned'); ?></td>
                                            <td><?= date('M d, Y g:i A', strtotime($intern['created_at'])); ?></td>
                                            <td>
                                                <?php 
                                                $status_class = 'secondary';
                                                $status_label = ucfirst($intern['account_status']);
                                                if ($intern['account_status'] === 'approved') {
                                                    $status_class = 'success';
                                                    $status_label = 'Active';
                                                } elseif ($intern['account_status'] === 'pending') {
                                                    $status_class = 'warning';
                                                    $status_label = 'Pending Approval';
                                                }
                                                ?>
                                                <span class="badge bg-<?= $status_class; ?>"><?= $status_label; ?></span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-inbox display-4 text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">No new interns registered this month.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            </section>

            <!-- Total Interns Modal -->
            <div class="modal fade" id="totalInternsModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-sdca text-white">
                            <h5 class="modal-title"><i class="bi bi-people-fill me-2"></i>All Registered Interns</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>School/Department</th>
                                            <th>Status</th>
                                            <th>Hours Rendered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($interns)): foreach ($interns as $intern): ?>
                                        <tr>
                                            <td><strong><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></strong></td>
                                            <td><?= html_escape($intern['email']); ?></td>
                                            <td><?= html_escape($intern['school'] ?? 'Not assigned'); ?></td>
                                            <td>
                                                <?php 
                                                $status_class = 'secondary';
                                                $status_label = ucfirst($intern['account_status']);
                                                if ($intern['account_status'] === 'approved') {
                                                    $status_class = 'success';
                                                    $status_label = 'Active';
                                                } elseif ($intern['account_status'] === 'pending') {
                                                    $status_class = 'warning';
                                                }
                                                ?>
                                                <span class="badge bg-<?= $status_class; ?>"><?= $status_label; ?></span>
                                            </td>
                                            <td><?= number_format((float)$intern['rendered_hours'], 1); ?> hrs</td>
                                        </tr>
                                        <?php endforeach; else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No interns found.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This Month Interns Modal -->
            <div class="modal fade" id="thisMonthModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title"><i class="bi bi-calendar-check me-2"></i>Interns Registered This Month (<?= date('F Y'); ?>)</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>School/Department</th>
                                            <th>Registration Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($this_month_interns_list)): foreach ($this_month_interns_list as $intern): ?>
                                        <tr>
                                            <td><strong><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></strong></td>
                                            <td><?= html_escape($intern['email']); ?></td>
                                            <td><?= html_escape($intern['school'] ?? 'Not assigned'); ?></td>
                                            <td><?= date('M d, Y', strtotime($intern['created_at'])); ?></td>
                                            <td>
                                                <?php 
                                                $status_class = 'secondary';
                                                $status_label = ucfirst($intern['account_status']);
                                                if ($intern['account_status'] === 'approved') {
                                                    $status_class = 'success';
                                                    $status_label = 'Active';
                                                } elseif ($intern['account_status'] === 'pending') {
                                                    $status_class = 'warning';
                                                }
                                                ?>
                                                <span class="badge bg-<?= $status_class; ?>"><?= $status_label; ?></span>
                                            </td>
                                        </tr>
                                        <?php endforeach; else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No interns registered this month.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <section id="announcements" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white d-flex justify-content-between align-items-center"><h5 class="mb-0 fw-bold"><i class="bi bi-megaphone me-2"></i>Announcements</h5><button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#newAnnouncementModal"><i class="bi bi-plus-circle me-1"></i>New Announcement</button></div><div class="list-group list-group-flush"><?php if (!empty($announcements)): foreach ($announcements as $announcement): ?><div class="list-group-item"><div class="d-flex justify-content-between"><strong><?= html_escape($announcement['title']); ?></strong><span class="badge <?= $announcement['is_active'] ? 'bg-success' : 'bg-secondary'; ?>"><?= $announcement['is_active'] ? 'Active' : 'Inactive'; ?></span></div><small class="text-muted d-block mt-1"><?= html_escape($announcement['message']); ?></small><small class="text-muted d-block mt-2">Target: <?= !empty($announcement['target_user_id']) ? html_escape($announcement['recipient_first_name'] . ' ' . $announcement['recipient_last_name']) : 'All Interns'; ?></small></div><?php endforeach; else: ?><div class="list-group-item text-muted">No announcements yet.</div><?php endif; ?></div></section>
            <section id="inquiries" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white d-flex justify-content-between align-items-center"><h5 class="mb-0 fw-bold"><i class="bi bi-question-circle me-2"></i>Inquiries &amp; Concerns</h5><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#inquiryHistoryModal"><i class="bi bi-clock-history me-1"></i>Reply History</button></div><div class="card-body"><?php $has_open_inquiries = FALSE; if (!empty($inquiries)): foreach ($inquiries as $inquiry): if ($inquiry['status'] !== 'Open') { continue; } $has_open_inquiries = TRUE; ?><article class="border-start border-4 border-danger ps-3 mb-4"><div class="d-flex justify-content-between gap-3"><div><strong><?= html_escape(trim($inquiry['first_name'] . ' ' . $inquiry['last_name'])); ?></strong><small class="d-block text-muted"><?= html_escape($inquiry['email']); ?> | <?= date('M d, Y g:i A', strtotime($inquiry['created_at'])); ?></small><span class="badge bg-secondary my-2"><?= html_escape($inquiry['category']); ?></span><p><?= nl2br(html_escape($inquiry['message'])); ?></p></div><span class="badge align-self-start bg-warning text-dark">Open</span></div><form action="<?= base_url('admin/reply_to_inquiry/' . (int)$inquiry['id']); ?>" method="post"><input type="hidden" name="redirect" value="inquiries"><label class="form-label small fw-bold">Reply</label><textarea class="form-control" name="admin_reply" rows="3" required></textarea><button type="submit" class="btn btn-sm btn-danger mt-2"><i class="bi bi-reply me-1"></i>Send Reply</button></form></article><?php endforeach; endif; if (!$has_open_inquiries): ?><p class="text-muted mb-0">No open intern inquiries.</p><?php endif; ?></div></section>
            <section id="admin-tools" class="section-anchor card section-card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-tools me-2"></i>Administrative Tools & System Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- User Role Control -->
                        <div class="col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3" style="width: 60px; height: 60px; background-color: #e3f2fd; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-people-fill text-primary" style="font-size: 1.8rem;"></i>
                                    </div>
                                    <h6 class="fw-bold">User Role Control</h6>
                                    <p class="text-muted small mb-3">Manage intern account details through the Intern Management edit controls.</p>
                                    <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#manageInternsModal">
                                        <i class="bi bi-pencil-square me-1"></i>Manage Users
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Reports & PDF Export -->
                        <div class="col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3" style="width: 60px; height: 60px; background-color: #ffebee; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-file-earmark-pdf-fill text-danger" style="font-size: 1.8rem;"></i>
                                    </div>
                                    <h6 class="fw-bold">Reports & PDF Export</h6>
                                    <p class="text-muted small mb-3">Generate an official master DTR audit report.</p>
                                    <button type="button" class="btn btn-sm btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#exportPdfModal">
                                        <i class="bi bi-download me-1"></i>Export PDF
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- System Logs & Audit Trail -->
                        <div class="col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3" style="width: 60px; height: 60px; background-color: #f3e5f5; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-clock-history text-purple" style="font-size: 1.8rem; color: #7b1fa2;"></i>
                                    </div>
                                    <h6 class="fw-bold">System Logs & Audit Trail</h6>
                                    <p class="text-muted small mb-3">Review deletion requests and account activity from the management queues.</p>
                                    <button type="button" class="btn btn-sm btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#activityLogsModal">
                                        <i class="bi bi-eye me-1"></i>Review Activity
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Intern Support -->
                        <div class="col-md-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3" style="width: 60px; height: 60px; background-color: #e8f5e9; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-headset text-success" style="font-size: 1.8rem;"></i>
                                    </div>
                                    <h6 class="fw-bold">Intern Support</h6>
                                    <p class="text-muted small mb-3">Review and respond to intern inquiries and concerns.</p>
                                    <button type="button" class="btn btn-sm btn-outline-success w-100" id="openInquiriesBtn">
                                        <i class="bi bi-chat-dots me-1"></i>Open Inquiries
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>
<div class="modal fade" id="inquiryHistoryModal" tabindex="-1" aria-labelledby="inquiryHistoryModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-scrollable modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="inquiryHistoryModalLabel">Inquiry Reply History</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><?php $has_reply_history = FALSE; foreach ($inquiries as $inquiry): if ($inquiry['status'] === 'Answered' && !empty($inquiry['admin_reply'])): $has_reply_history = TRUE; ?><article class="border-start border-4 border-success ps-3 mb-4"><div class="d-flex justify-content-between"><strong><?= html_escape(trim($inquiry['first_name'] . ' ' . $inquiry['last_name'])); ?></strong><small class="text-muted"><?= !empty($inquiry['replied_at']) ? date('M d, Y g:i A', strtotime($inquiry['replied_at'])) : ''; ?></small></div><span class="badge bg-secondary my-2"><?= html_escape($inquiry['category']); ?></span><p class="mb-2"><strong>Inquiry:</strong> <?= nl2br(html_escape($inquiry['message'])); ?></p><div class="bg-light p-3"><strong>Reply:</strong><br><?= nl2br(html_escape($inquiry['admin_reply'])); ?></div></article><?php endif; endforeach; if (!$has_reply_history): ?><p class="text-muted text-center mb-0">No replies have been sent yet.</p><?php endif; ?></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div></div></div></div>
<div class="modal fade" id="newAnnouncementModal" tabindex="-1" aria-labelledby="newAnnouncementModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><form action="<?= base_url('admin/create_announcement_process'); ?>" method="post"><input type="hidden" name="redirect" value="announcements"><div class="modal-header"><h5 class="modal-title" id="newAnnouncementModalLabel">New Announcement</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title" required></div><div class="mb-3"><label class="form-label">Message</label><textarea class="form-control" name="message" rows="4" required></textarea></div><div class="mb-3"><label class="form-label">Target</label><select class="form-select" name="target_type"><option value="all">All Interns</option><option value="specific">Specific Intern</option></select></div><div class="mb-3"><label class="form-label">Specific Intern</label><select class="form-select" name="target_user_id"><option value="">Select an intern</option><?php foreach ($announcement_interns as $intern): ?><option value="<?= (int)$intern['id']; ?>"><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></option><?php endforeach; ?></select></div><div class="mb-3"><label class="form-label">Category</label><input class="form-control" name="category"></div><div><label class="form-label">Expiration Date</label><input class="form-control" type="date" name="expires_at"></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="submit">Send Announcement</button></div></form></div></div></div>
<div class="modal fade" id="clearDeletionRequestsModal" tabindex="-1" aria-labelledby="clearDeletionRequestsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('admin/clear_deletion_requests'); ?>" method="post">
                <input type="hidden" name="redirect" value="pending-approvals">
                <div class="modal-header">
                    <h5 class="modal-title" id="clearDeletionRequestsModalLabel">Clear Deletion Requests</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Clear all listed deletion requests? This action cannot be undone.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Clear Requests</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="internDecisionModal" tabindex="-1" aria-labelledby="internDecisionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="internDecisionForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="internDecisionModalLabel">Confirm Registration Decision</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="internDecisionMessage"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmInternDecision" type="submit" class="btn">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteLogModal" tabindex="-1" aria-labelledby="deleteLogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLogModalLabel">Delete OJT Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Are you sure you want to delete this OJT record? This action cannot be undone.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a id="confirmDeleteLog" class="btn btn-danger" href="#">Delete Record</a>
            </div>
        </div>
    </div>
</div>

<!-- Review DTR Records Modal -->
<div class="modal fade" id="reviewDTRModal" tabindex="-1" aria-labelledby="reviewDTRModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewDTRModalLabel">Review DTR Records</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 d-flex align-items-center gap-2">
                    <div>
                        <label class="form-label fw-semibold">Search Intern</label>
                        <input type="text" id="dtrSearchInput" class="form-control" placeholder="Search by name, email, or ID..." style="min-width: 620px; flex-grow: 1; border-radius: 0px;">
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Filter by Status</label>
                        <select id="dtrStatusFilter" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="done">Done</option>
                            <option value="terminated">Terminated</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Intern Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="dtrInternsList">
                            <?php if (!empty($interns)): foreach ($interns as $intern): ?>
                            <tr class="dtr-intern-row">
                                <td><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></td>
                                <td><small><?= html_escape($intern['email']); ?></small></td>
                                <td>
                                    <span class="badge bg-success">
                                        <?php 
                                        $status = strtolower(trim($intern['account_status'] ?? 'active'));
                                        if ($status === 'active' || $status === 'approved' || $status === 'pending') {
                                            echo 'Active';
                                        } elseif ($status === 'done') {
                                            echo 'Done';
                                        } else {
                                            echo ucfirst($status);
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td>
                                <a href="<?= base_url('admin/view_dtr/' . (int)$intern['id']); ?>" class="btn btn-sm btn-outline-primary">View DTR</a>                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No interns found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Pending Approvals Modal -->
<div class="modal fade" id="pendingApprovalsModal" tabindex="-1" aria-labelledby="pendingApprovalsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pendingApprovalsModalLabel">Pending Approvals</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabs for different approval types -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="intern-registrations-tab" data-bs-toggle="tab" data-bs-target="#intern-registrations" type="button" role="tab" aria-controls="intern-registrations" aria-selected="true">
                            <i class="bi bi-person-plus me-2"></i>Intern Registrations (<?= (int)$pending_intern_count; ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="deletion-requests-tab" data-bs-toggle="tab" data-bs-target="#deletion-requests" type="button" role="tab" aria-controls="deletion-requests" aria-selected="false">
                            <i class="bi bi-exclamation-circle me-2"></i>Deletion Requests (<?= (int)$request_count; ?>)
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Intern Registrations Tab -->
                    <div class="tab-pane fade show active" id="intern-registrations" role="tabpanel" aria-labelledby="intern-registrations-tab">
                        <h6 class="fw-bold mb-3">Interns Awaiting Approval</h6>
                        <div class="list-group">
                            <?php if (!empty($interns_to_approve)): foreach ($interns_to_approve as $pending_intern): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1 fw-semibold"><?= html_escape(trim($pending_intern['first_name'] . ' ' . $pending_intern['last_name'])); ?></h6>
                                        <small class="text-muted d-block"><?= html_escape($pending_intern['email']); ?></small>
                                        <small class="text-muted d-block">Student ID: <?= html_escape($pending_intern['student_id'] ?? 'N/A'); ?></small>
                                    </div>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                </div>
                                <div class="d-flex gap-2 mt-2">
                                    <button type="button" class="btn btn-sm btn-success intern-decision-button" data-decision="approve" data-decision-url="<?= base_url('admin/approve_intern/' . (int)$pending_intern['id'] . '?redirect=pending-approvals'); ?>" data-bs-toggle="modal" data-bs-target="#internDecisionModal">
                                        <i class="bi bi-check-circle me-1"></i>Approve
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger intern-decision-button" data-decision="deny" data-decision-url="<?= base_url('admin/reject_intern/' . (int)$pending_intern['id'] . '?redirect=pending-approvals'); ?>" data-bs-toggle="modal" data-bs-target="#internDecisionModal">
                                        <i class="bi bi-x-circle me-1"></i>Deny
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-check-circle fs-4 d-block mb-2"></i>
                                <p>No pending registration approvals.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Deletion Requests Tab -->
                    <div class="tab-pane fade" id="deletion-requests" role="tabpanel" aria-labelledby="deletion-requests-tab">
                        <h6 class="fw-bold mb-3">Account & Record Deletion Requests</h6>
                        <div class="list-group">
                            <?php if (!empty($requests)): foreach ($requests as $request): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold"><?= html_escape($request['sender_name']); ?></h6>
                                        <small class="text-muted d-block"><?= html_escape($request['subject']); ?></small>
                                        <small class="text-muted d-block" style="margin-top: 4px; white-space: pre-wrap;"><?= html_escape(substr($request['message'] ?? '', 0, 150)); ?></small>
                                    </div>
                                    <span class="badge bg-danger ms-2">New</span>
                                </div>
                                <div class="d-flex gap-2 mt-3">
                                    <a href="<?= base_url('admin/mark_request_read/' . (int)$request['id'] . '?redirect=pending-approvals'); ?>" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye me-1"></i>Review
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#requestDetailsModal" onclick="showRequestDetails(<?= (int)$request['id']; ?>, '<?= html_escape($request['sender_name']); ?>', '<?= html_escape($request['subject']); ?>', '<?= html_escape(addslashes($request['message'] ?? '')); ?>')">
                                        <i class="bi bi-file-text me-1"></i>Details
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-check-circle fs-4 d-block mb-2"></i>
                                <p>No deletion requests pending.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Request Details Modal -->
<div class="modal fade" id="requestDetailsModal" tabindex="-1" aria-labelledby="requestDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestDetailsModalLabel">Deletion Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">From:</label>
                    <p class="text-dark" id="requestSenderName"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Subject:</label>
                    <p class="text-dark" id="requestSubject"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Message:</label>
                    <div class="bg-light p-3 rounded" style="white-space: pre-wrap; word-wrap: break-word;">
                        <p id="requestMessage" class="text-dark mb-0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Large Manage Interns Modal -->
<div class="modal fade" id="manageInternsModal" tabindex="-1" aria-labelledby="manageInternsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-sdca text-white">
                <h5 class="modal-title" id="manageInternsModalLabel">
                    <i class="bi bi-people-fill me-2"></i>Manage Interns
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Search and Filter Bar -->
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Search Intern</label>
                        <input type="text" id="manageInternSearch" class="form-control" placeholder="Search by name, email, or school...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Filter by Status</label>
                        <select id="manageInternStatusFilter" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="approved">Active</option>
                            <option value="pending">Pending</option>
                            <option value="done">Done</option>
                            <option value="terminated">Terminated</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="clearManageInternFilters" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-circle"></i> Clear
                        </button>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">
                        Showing <strong id="manageInternCount"><?= count($interns); ?></strong> intern(s)
                    </small>
                    <small class="text-muted">Total Hours: <strong><?= number_format(array_sum(array_column($interns, 'rendered_hours')), 1); ?> hrs</strong></small>
                </div>

                <!-- Interns Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Intern Name</th>
                                <th style="width: 20%;">Email</th>
                                <th style="width: 15%;">School/Department</th>
                                <th style="width: 15%;">Progress</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 10%;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="manageInternsTableBody">
                            <?php if (!empty($interns)): $counter = 1; foreach ($interns as $intern): ?>
                                <?php $progress = $required_hours > 0 ? min(100, round(((float)$intern['rendered_hours'] / $required_hours) * 100, 1)) : 0; ?>
                                <tr class="manage-intern-row" 
                                    data-name="<?= html_escape(strtolower(trim($intern['first_name'] . ' ' . $intern['last_name']))); ?>"
                                    data-email="<?= html_escape(strtolower($intern['email'])); ?>"
                                    data-school="<?= html_escape(strtolower($intern['school'] ?? '')); ?>"
                                    data-status="<?= html_escape(strtolower($intern['account_status'] ?? '')); ?>">
                                    <td><?= $counter++; ?></td>
                                    <td>
                                        <strong><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></strong>
                                        <?php if (!empty($intern['student_id'])): ?>
                                            <br><small class="text-muted">ID: <?= html_escape($intern['student_id']); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><small><?= html_escape($intern['email']); ?></small></td>
                                    <td><small><?= html_escape(!empty($intern['school']) ? $intern['school'] : 'Not assigned'); ?></small></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 6px; min-width: 80px;">
                                                <div class="progress-bar bg-<?= $progress >= 80 ? 'success' : ($progress >= 25 ? 'warning' : 'danger'); ?>" style="width: <?= $progress; ?>%"></div>
                                            </div>
                                            <small class="fw-bold"><?= $progress; ?>%</small>
                                        </div>
                                        <small class="text-muted"><?= number_format((float)$intern['rendered_hours'], 1); ?>/<?= number_format((float)$required_hours, 0); ?> hrs</small>
                                    </td>
                                    <td>
                                        <?php 
                                        $intern_st = strtolower(trim($intern['account_status'] ?? ''));
                                        $intern_badge = ($intern_st === 'done') ? 'bg-secondary' : (($intern_st === 'terminated' || $intern_st === 'rejected') ? 'bg-danger' : ($intern_st === 'pending' ? 'bg-warning text-dark' : 'bg-success'));
                                        $intern_label = ($intern_st === 'done') ? 'Done' : (($intern_st === 'terminated') ? 'Terminated' : ($intern_st === 'pending' ? 'Pending' : ($intern_st === 'rejected' ? 'Rejected' : 'Active')));
                                        ?>
                                        <span class="badge <?= $intern_badge; ?>"><?= $intern_label; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary open-edit-modal" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#intern<?= (int)$intern['id']; ?>"
                                                data-bs-dismiss="modal">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-people display-6 d-block mb-2"></i>
                                        No intern accounts found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Export PDF Modal -->
<div class="modal fade" id="exportPdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-file-earmark-pdf me-2"></i>Export DTR Report</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="exportPdfForm" action="<?= base_url('admin/export_dtr_pdf'); ?>" method="POST" target="_blank">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Report Type</label>
                        <select name="report_type" class="form-select" required>
                            <option value="all">All Interns DTR Report</option>
                            <option value="approved">Approved Interns Only</option>
                            <option value="pending">Pending Interns Only</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Date Range</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-01'); ?>">
                            </div>
                            <div class="col-6">
                                <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Include</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_hours" value="1" checked>
                            <label class="form-check-label">Total Rendered Hours</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_logs" value="1" checked>
                            <label class="form-check-label">Detailed Time Logs</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_status" value="1" checked>
                            <label class="form-check-label">Intern Status</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('exportPdfForm').submit();">
                    <i class="bi bi-download me-1"></i>Generate PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Activity Logs Modal -->
<div class="modal fade" id="activityLogsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title"><i class="bi bi-clock-history me-2"></i>System Logs & Audit Trail</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Deletion Requests -->
                <div class="mb-4">
                    <h6 class="fw-bold text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Pending Deletion Requests</h6>
                    <?php if (!empty($requests)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>From</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($requests as $request): ?>
                                <tr>
                                    <td><?= html_escape($request['sender_name']); ?></td>
                                    <td><?= html_escape($request['subject']); ?></td>
                                    <td><small><?= date('M d, Y g:i A', strtotime($request['created_at'] ?? 'now')); ?></small></td>
                                    <td>
                                        <a href="<?= base_url('admin/mark_request_read/' . (int)$request['id']); ?>" class="btn btn-xs btn-outline-success">
                                            <i class="bi bi-check"></i> Review
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <p class="text-muted text-center py-3"><i class="bi bi-check-circle me-2"></i>No pending deletion requests.</p>
                    <?php endif; ?>
                </div>

                <!-- Recent System Activities -->
                <div>
                    <h6 class="fw-bold text-primary"><i class="bi bi-activity me-2"></i>Recent System Activities</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Activity</th>
                                    <th>User</th>
                                    <th>Date/Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_logs)): foreach (array_slice($recent_logs, 0, 10) as $log): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-info">OJT Log</span>
                                        <small class="ms-2"><?= html_escape($log['task_summary'] ?? 'No description'); ?></small>
                                    </td>
                                    <td><?= html_escape(trim($log['first_name'] . ' ' . $log['last_name'])); ?></td>
                                    <td><small><?= date('M d, Y g:i A', strtotime($log['created_at'] ?? $log['log_date'])); ?></small></td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">No recent activities.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Load SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const successToastElement = document.getElementById('successToast');
if (successToastElement) {
    new bootstrap.Toast(successToastElement, { delay: 4000 }).show();
}
</script>
<script>
document.querySelectorAll('.delete-log-button').forEach(function(button) {
    button.addEventListener('click', function() {
        document.getElementById('confirmDeleteLog').href = button.dataset.deleteUrl;
    });
});
</script>
<script>
document.querySelectorAll('.intern-decision-button').forEach(function(button) {
    button.addEventListener('click', function() {
        const isApproval = button.dataset.decision === 'approve';
        const confirmButton = document.getElementById('confirmInternDecision');

        document.getElementById('internDecisionForm').action = button.dataset.decisionUrl;
        document.getElementById('internDecisionModalLabel').textContent = isApproval ? 'Approve Intern Registration' : 'Deny Intern Registration';
        document.getElementById('internDecisionMessage').textContent = isApproval ? 'Approve this intern registration request?' : 'Deny this intern registration request?';
        confirmButton.textContent = isApproval ? 'Approve' : 'Deny';
        confirmButton.className = 'btn ' + (isApproval ? 'btn-success' : 'btn-danger');
    });
});
</script>

<!-- DTR Search and Filter Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dtrSearchInput = document.getElementById('dtrSearchInput');
    const dtrStatusFilter = document.getElementById('dtrStatusFilter');
    const dtrInternRows = document.querySelectorAll('.dtr-intern-row');

    function filterDTRInterns() {
        const searchQuery = dtrSearchInput.value.toLowerCase().trim();
        const statusFilter = dtrStatusFilter.value.toLowerCase();

        dtrInternRows.forEach(function(row) {
            const cells = row.querySelectorAll('td');
            if (cells.length < 4) return;

            const name = cells[0].textContent.toLowerCase();
            const email = cells[1].textContent.toLowerCase();
            const status = cells[2].textContent.toLowerCase().trim();

            const matchesSearch = searchQuery === '' || name.includes(searchQuery) || email.includes(searchQuery);
            const matchesStatus = statusFilter === '' || status.includes(statusFilter);

            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    dtrSearchInput.addEventListener('input', filterDTRInterns);
    dtrStatusFilter.addEventListener('change', filterDTRInterns);
});
</script>

<!-- Request Details Modal Population -->
<script>
function showRequestDetails(id, senderName, subject, message) {
    document.getElementById('requestSenderName').textContent = senderName;
    document.getElementById('requestSubject').textContent = subject;
    document.getElementById('requestMessage').textContent = message;
}
</script>

<script>
// Universal event listener that handles logout across all Admin layouts
document.addEventListener('click', function (e) {
    const logoutTarget = e.target.closest('.btn-logout, a[href*="auth/logout"], a[href*="admin/logout"]');

    if (logoutTarget) {
        e.preventDefault();
        const targetUrl = logoutTarget.getAttribute('href');

        Swal.fire({
            title: 'Confirm Admin Logout',
            text: 'Are you sure you want to exit the Administrative Portal?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#a12124', /* Maroon theme */
            cancelButtonColor: '#625f5f',  /* Dark neutral gray */
            confirmButtonText: 'Yes, Log Out',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'rounded-0',        /* Sharp corners matching UI design */
                confirmButton: 'rounded-0',
                cancelButton: 'rounded-0'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = targetUrl;
            }
        });
    }
});
</script>
<script>
    const adminModuleIds = [
        'dashboard',
        'intern-management',
        'ojt-management',
        'dtr-records',
        'analytics',
        'announcements',
        'inquiries',
        'admin-tools'
    ];

    function setupInternFilters() {
        const section = document.getElementById('intern-management');
        const header = section.querySelector('.card-header');
        const oldSearchLink = header.querySelector('a');
        if (oldSearchLink) {
            oldSearchLink.remove();
        }

        const controls = document.createElement('div');
        controls.className = 'd-flex gap-2';
        controls.innerHTML = '<input type="search" id="internSearch" class="form-control form-control-sm" placeholder="Search intern or email" aria-label="Search interns" style="min-width: 320px; flex-grow: 1; border-radius: 0px;"><select id="internStatusFilter" class="form-select form-select-sm" aria-label="Filter intern status"><option value="">All statuses</option><option value="active">Active</option><option value="pending">Pending</option><option value="deactivated">Deactivated</option></select>';
        header.appendChild(controls);

        const search = document.getElementById('internSearch');
        const statusFilter = document.getElementById('internStatusFilter');
        const rows = section.querySelectorAll('tbody tr');
        const internStatuses = <?= json_encode(array_values(array_column($interns, 'account_status'))); ?>;
        let internIndex = 0;

        rows.forEach(function(row) {
            const cells = row.querySelectorAll('td');
            if (cells.length < 6 || !internStatuses[internIndex]) {
                return;
            }
            const status = internStatuses[internIndex++];
            cells[4].innerHTML = '<span class="badge text-bg-' + (status === 'approved' ? 'success' : (status === 'pending' ? 'warning' : 'secondary')) + '">' + status.charAt(0).toUpperCase() + status.slice(1) + '</span>';
        });

        function filterInterns() {
            const query = search.value.toLowerCase().trim();
            const status = statusFilter.value.toLowerCase();
            rows.forEach(function(row) {
                const cells = row.querySelectorAll('td');
                if (cells.length < 6) {
                    return;
                }
                const rowText = row.textContent.toLowerCase();
                const rowStatus = cells[4].textContent.toLowerCase().trim();
                row.classList.toggle('d-none', (query && rowText.indexOf(query) === -1) || (status && rowStatus !== status));
            });
        }

        search.addEventListener('input', filterInterns);
        statusFilter.addEventListener('change', filterInterns);
    }

    function switchAdminModule(moduleName, link) {
        let targetId;

        switch (moduleName) {
            case 'dashboard':
                targetId = 'dashboard';
                break;
            case 'intern-management':
                targetId = 'intern-management';
                break;
            case 'ojt-management':
                targetId = 'ojt-management';
                break;
            case 'dtr-records':
                targetId = 'dtr-records';
                break;
            case 'analytics':
                targetId = 'analytics';
                break;
            case 'announcements':
                targetId = 'announcements';
                break;
            case 'inquiries':
                targetId = 'inquiries';
                break;
            case 'admin-tools':
                targetId = 'admin-tools';
                break;
            default:
                targetId = 'dashboard';
        }

        adminModuleIds.forEach(function(id) {
            const module = document.getElementById(id);
            if (module) {
                module.classList.toggle('d-none', id !== targetId);
            }
        });

        const quickPanels = document.getElementById('dashboard-quick-panels');
        if (quickPanels) {
            quickPanels.classList.toggle('d-none', targetId !== 'dashboard');
        }

        document.querySelectorAll('.sidebar-menu li').forEach(function(item) {
            item.classList.remove('active');
        });
        if (link) {
            link.closest('li').classList.add('active');
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.querySelectorAll('.sidebar-menu a').forEach(function(link) {
        link.addEventListener('click', function(event) {
            const href = link.getAttribute('href');
            // Only prevent default for anchor links (starting with #)
            if (href.startsWith('#')) {
                event.preventDefault();
                switchAdminModule(href.substring(1), link);
            }
            // Allow full URLs to navigate normally (e.g., /admin/announcements)
        });
    });

    setupInternFilters();
    switchAdminModule(<?= json_encode(!empty($active_module) ? $active_module : 'dashboard'); ?>, document.querySelector('.sidebar-menu a[href="#<?= !empty($active_module) ? $active_module : 'dashboard'; ?>"]'));

    function updateAdminSidebarClock() { const now = new Date(); document.getElementById('adminSidebarTime').textContent = now.toLocaleTimeString('en-US', { timeZone: 'Asia/Manila', hour: 'numeric', minute: '2-digit', second: '2-digit', hour12: true }); document.getElementById('adminSidebarDate').textContent = now.toLocaleDateString('en-US', { timeZone: 'Asia/Manila', month: 'long', day: 'numeric', year: 'numeric' }); }
    updateAdminSidebarClock(); setInterval(updateAdminSidebarClock, 1000);

</script>
<!-- DataTables Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#ojtManagementTable').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "destroy": true,
        "language": {
            "paginate": {
                "previous": '<i class="bi bi-chevron-left"></i>',
                "next": '<i class="bi bi-chevron-right"></i>'
            }
        }
    });
});
</script>
<script>
$(document).ready(function() {
    // Initialize DTR Records Table
    $('#dtrRecordsTable').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "destroy": true,
        "language": {
            "paginate": {
                "previous": '<i class="bi bi-chevron-left"></i>',
                "next": '<i class="bi bi-chevron-right"></i>'
            }
        }
    });
});
</script>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = "'Century Gothic', 'CenturyGothic', sans-serif";
    Chart.defaults.color = '#343434';
    
    // Get data from PHP
    const genderData = <?= json_encode($gender_distribution ?? []); ?>;
    const schoolData = <?= json_encode($school_distribution ?? []); ?>;
    const monthlyData = <?= json_encode($monthly_registration ?? []); ?>;
    const statusData = <?= json_encode($status_distribution ?? []); ?>;
    
    // Get intern names for tooltips
    const internNamesByGender = <?= json_encode($intern_names_by_gender ?? []); ?>;
    const internNamesBySchool = <?= json_encode($intern_names_by_school ?? []); ?>;
    const internNamesByMonth = <?= json_encode($intern_names_by_month ?? []); ?>;
    const internNamesByStatus = <?= json_encode($intern_names_by_status ?? []); ?>;

    // Helper: format names list (comma-separated, max 5 shown + count)
    function formatNamesList(names) {
        if (!names || names.length === 0) return 'No interns';
        if (names.length <= 5) return names.join(', ');
        return names.slice(0, 5).join(', ') + '... (+' + (names.length - 5) + ' more)';
    }

    // 1. Gender Distribution - Pie Chart
    new Chart(document.getElementById('genderChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: genderData.labels || ['Male', 'Female', 'Unspecified'],
            datasets: [{
                data: genderData.values || [0, 0, 0],
                backgroundColor: ['#e91e63', '#1976d2', '#9c27b0'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true, pointStyle: 'circle' } },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#a12124',
                    borderWidth: 2,
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 12 },
                    callbacks: {
                        title: function(context) {
                            return '👥 ' + context[0].label;
                        },
                        label: function(context) {
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return 'Count: ' + value + ' (' + percentage + '%)';
                        },
                        afterBody: function(context) {
                            const label = context[0].label;
                            const names = internNamesByGender[label] || [];
                            return ['', 'Interns:', formatNamesList(names)];
                        }
                    }
                }
            }
        }
    });

    // 2. School/Department Distribution - Bar Chart
    new Chart(document.getElementById('schoolChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: schoolData.labels || [],
            datasets: [{
                label: 'Number of Interns',
                data: schoolData.values || [],
                backgroundColor: [
                    '#a12124', // SDCA Maroon
                    '#1976d2', // Blue
                    '#388e3c', // Green
                    '#f57c00', // Orange
                    '#7b1fa2', // Purple
                    '#00838f', // Teal
                    '#c2185b', // Pink
                    '#455a64', // Blue Grey
                    '#5d4037', // Brown
                    '#2e7d32'  // Dark Green
                ],
                borderColor: [
                    '#801a1c',
                    '#0d47a1',
                    '#1b5e20',
                    '#e65100',
                    '#4a148c',
                    '#006064',
                    '#880e4f',
                    '#263238',
                    '#3e2723',
                    '#1b5e20'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#a12124',
                    borderWidth: 2,
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    callbacks: {
                        title: function(context) {
                            return '🏫 ' + context[0].label;
                        },
                        label: function(context) {
                            return 'Interns: ' + context.parsed.y;
                        },
                        afterBody: function(context) {
                            const label = context[0].label;
                            const names = internNamesBySchool[label] || [];
                            return ['', 'Interns:', formatNamesList(names)];
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, grid: { color: '#f0f0f0' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 3. Monthly Registration Trend - Line Chart
    new Chart(document.getElementById('monthlyChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: monthlyData.labels || [],
            datasets: [{
                label: 'New Interns',
                data: monthlyData.values || [],
                borderColor: '#a12124',
                backgroundColor: 'rgba(161, 33, 36, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#a12124',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#a12124',
                    borderWidth: 2,
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    callbacks: {
                        title: function(context) {
                            return '📅 ' + context[0].label;
                        },
                        label: function(context) {
                            return 'New Registrations: ' + context.parsed.y;
                        },
                        afterBody: function(context) {
                            const label = context[0].label;
                            const names = internNamesByMonth[label] || [];
                            return ['', 'Interns:', formatNamesList(names)];
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, grid: { color: '#f0f0f0' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 4. Status Distribution - Doughnut Chart
    new Chart(document.getElementById('statusChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: statusData.labels || ['Active', 'Pending', 'Done', 'Terminated'],
            datasets: [{
                data: statusData.values || [0, 0, 0, 0],
                backgroundColor: ['#388e3c', '#f57c00', '#1976d2', '#d32f2f'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true, pointStyle: 'circle' } },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#a12124',
                    borderWidth: 2,
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    callbacks: {
                        title: function(context) {
                            return '📊 ' + context[0].label;
                        },
                        label: function(context) {
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return 'Count: ' + value + ' (' + percentage + '%)';
                        },
                        afterBody: function(context) {
                            const label = context[0].label;
                            const names = internNamesByStatus[label] || [];
                            return ['', 'Interns:', formatNamesList(names)];
                        }
                    }
                }
            }
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const analyticsCard = document.getElementById('viewAnalyticsCard');
    if (analyticsCard) {
        analyticsCard.addEventListener('click', function(e) {
            e.preventDefault();
            switchAdminModule('analytics', document.querySelector('.sidebar-menu a[href="#analytics"]'));
        });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manage Interns Modal - Search and Filter
    const manageInternSearch = document.getElementById('manageInternSearch');
    const manageInternStatusFilter = document.getElementById('manageInternStatusFilter');
    const clearManageInternFilters = document.getElementById('clearManageInternFilters');
    const manageInternRows = document.querySelectorAll('.manage-intern-row');
    const manageInternCount = document.getElementById('manageInternCount');

    function filterManageInterns() {
        const searchQuery = manageInternSearch.value.toLowerCase().trim();
        const statusFilter = manageInternStatusFilter.value.toLowerCase();
        let visibleCount = 0;

        manageInternRows.forEach(function(row) {
            const name = row.dataset.name || '';
            const email = row.dataset.email || '';
            const school = row.dataset.school || '';
            const status = row.dataset.status || '';

            const matchesSearch = searchQuery === '' || 
                                  name.includes(searchQuery) || 
                                  email.includes(searchQuery) || 
                                  school.includes(searchQuery);
            const matchesStatus = statusFilter === '' || status === statusFilter;

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update count display
        if (manageInternCount) {
            manageInternCount.textContent = visibleCount;
        }
    }

    // Event listeners
    if (manageInternSearch) {
        manageInternSearch.addEventListener('input', filterManageInterns);
    }
    if (manageInternStatusFilter) {
        manageInternStatusFilter.addEventListener('change', filterManageInterns);
    }
    if (clearManageInternFilters) {
        clearManageInternFilters.addEventListener('click', function() {
            if (manageInternSearch) manageInternSearch.value = '';
            if (manageInternStatusFilter) manageInternStatusFilter.value = '';
            filterManageInterns();
        });
    }

    // Reset filters when modal is closed
    const manageInternsModal = document.getElementById('manageInternsModal');
    if (manageInternsModal) {
        manageInternsModal.addEventListener('hidden.bs.modal', function() {
            if (manageInternSearch) manageInternSearch.value = '';
            if (manageInternStatusFilter) manageInternStatusFilter.value = '';
            filterManageInterns();
        });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Admin Tools Card Navigation
    const adminToolsCard = document.getElementById('adminToolsCard');
    if (adminToolsCard) {
        adminToolsCard.addEventListener('click', function(e) {
            e.preventDefault();
            switchAdminModule('admin-tools', document.querySelector('.sidebar-menu a[href="#admin-tools"]'));
        });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle all edit intern modals
    document.querySelectorAll('.modal').forEach(function(modal) {
        // Only target modals with intern edit forms
        if (modal.querySelector('form[action*="update_intern"]')) {
            const form = modal.querySelector('form');
            const saveButton = modal.querySelector('button[type="submit"]');
            const inputs = form.querySelectorAll('input, select, textarea');
            
            // Store initial values
            let initialValues = {};
            
            modal.addEventListener('show.bs.modal', function() {
                // Capture initial values when modal opens
                initialValues = {};
                inputs.forEach(function(input, index) {
                    initialValues[index] = input.value;
                });
                
                // Disable button initially (no changes yet)
                if (saveButton) {
                    saveButton.disabled = true;
                    saveButton.style.opacity = '0.5';
                    saveButton.style.cursor = 'not-allowed';
                }
            });
            
            // Check for changes on any input
            inputs.forEach(function(input) {
                input.addEventListener('input', checkForChanges);
                input.addEventListener('change', checkForChanges);
            });
            
            function checkForChanges() {
                let hasChanges = false;
                
                inputs.forEach(function(input, index) {
                    if (input.value !== initialValues[index]) {
                        hasChanges = true;
                    }
                });
                
                // Enable/disable button based on changes
                if (saveButton) {
                    saveButton.disabled = !hasChanges;
                    if (hasChanges) {
                        saveButton.style.opacity = '1';
                        saveButton.style.cursor = 'pointer';
                    } else {
                        saveButton.style.opacity = '0.5';
                        saveButton.style.cursor = 'not-allowed';
                    }
                }
            }
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Verify OJT Record modals
    document.querySelectorAll('.modal').forEach(function(modal) {
        // Target modals with OJT verification forms
        if (modal.querySelector('form[action*="update_log"]')) {
            const form = modal.querySelector('form');
            const saveButton = modal.querySelector('button[type="submit"]');
            const inputs = form.querySelectorAll('input, select, textarea');
            
            let initialValues = {};
            
            // When modal opens, capture initial values and disable button
            modal.addEventListener('show.bs.modal', function() {
                initialValues = {};
                inputs.forEach(function(input, index) {
                    initialValues[index] = input.value;
                });
                
                // Disable button initially (no changes yet)
                if (saveButton) {
                    saveButton.disabled = true;
                    saveButton.classList.add('btn-disabled-look');
                }
            });
            
            // Check for changes on any input
            inputs.forEach(function(input) {
                input.addEventListener('input', checkForChanges);
                input.addEventListener('change', checkForChanges);
            });
            
            function checkForChanges() {
                let hasChanges = false;
                
                inputs.forEach(function(input, index) {
                    if (input.value !== initialValues[index]) {
                        hasChanges = true;
                    }
                });
                
                // Enable/disable button based on changes
                if (saveButton) {
                    saveButton.disabled = !hasChanges;
                    if (hasChanges) {
                        saveButton.classList.remove('btn-disabled-look');
                    } else {
                        saveButton.classList.add('btn-disabled-look');
                    }
                }
            }
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dtrMonthFilter = document.getElementById('dtrMonthFilter');
    const dtrWeekFilter = document.getElementById('dtrWeekFilter');
    const dtrApplyFilter = document.getElementById('dtrApplyFilter');
    const dtrClearFilter = document.getElementById('dtrClearFilter');
    const dtrVisibleCount = document.getElementById('dtrVisibleCount');
    const dtrRows = document.querySelectorAll('.dtr-record-row');

    function filterDTRRecords() {
        const selectedMonth = dtrMonthFilter.value;
        const selectedWeek = dtrWeekFilter.value;
        let visibleCount = 0;

        dtrRows.forEach(function(row) {
            const rowMonth = row.dataset.month;
            const rowWeek = row.dataset.week;

            const matchesMonth = !selectedMonth || rowMonth === selectedMonth;
            const matchesWeek = !selectedWeek || rowWeek === selectedWeek;

            if (matchesMonth && matchesWeek) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update count display
        if (dtrVisibleCount) {
            dtrVisibleCount.textContent = visibleCount;
        }
    }

    // Apply filter button
    if (dtrApplyFilter) {
        dtrApplyFilter.addEventListener('click', filterDTRRecords);
    }

    // Clear filter button
    if (dtrClearFilter) {
        dtrClearFilter.addEventListener('click', function() {
            dtrMonthFilter.value = '';
            dtrWeekFilter.value = '';
            filterDTRRecords();
        });
    }

    // Auto-filter on change (optional - remove if you only want button click)
    if (dtrMonthFilter) {
        dtrMonthFilter.addEventListener('change', filterDTRRecords);
    }
    if (dtrWeekFilter) {
        dtrWeekFilter.addEventListener('change', filterDTRRecords);
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const openInquiriesBtn = document.getElementById('openInquiriesBtn');
    if (openInquiriesBtn) {
        openInquiriesBtn.addEventListener('click', function() {
            switchAdminModule('inquiries', document.querySelector('.sidebar-menu a[href="#inquiries"]'));
        });
    }
});
</script>
</body>
</html>
