<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTR Records - <?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?> - SDCA OJT Tracker</title>
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
        .main-content .btn:not(:disabled):hover, 
        .main-content .btn:not(:disabled):focus { 
            background-color: #5a0000 !important;
            border-color: #5a0000 !important; 
            color: #ffffff !important;
        }
        .stat-card { border: 0; border-left: 4px solid var(--sdca-red); }
        .section-card { border: 0; }
        .table td, .table th { vertical-align: middle; }
        .progress { height: 8px; min-width: 130px; }
        @media (max-width: 768px) { .sidebar { width: 76px; } .sidebar-brand span, .sidebar-menu span, .sidebar-clock { display: none; } .sidebar-menu a { justify-content: center; padding: 15px 8px; } .main-content { margin-left: 76px; } .main-content-area { padding: 76px 14px 20px; } .top-navbar { left: 76px; width: calc(100% - 76px); } .top-navbar .navbar-brand span { display: none; } }
        .navbar-top, .top-header { background-color: #a12124 !important; padding: 0 !important; }
        .navbar-top .nav-item, .navbar-top .dropdown, .navbar-top .inbox-btn { border-radius: 0 !important; border-left: 1px solid rgba(0, 0, 0, 0.2) !important; border-right: 1px solid rgba(255, 255, 255, 0.1) !important; padding: 8px 16px !important; margin: 0 !important; }
        .navbar-top .user-profile-tab { background-color: #5a0000 !important; border-radius: 0 !important; }
        .navbar-top .badge-danger, .navbar-top .inbox-count { background-color: #dc2626 !important; border-radius: 4px !important; padding: 2px 6px !important; font-weight: bold; font-size: 11px; }
        .top-navbar .btn, .top-navbar .nav-link, .top-navbar .dropdown-toggle, .nav-boxed-btn { border-radius: 0 !important; }
        .top-navbar .btn:hover, .top-navbar .nav-link:hover, .top-navbar .dropdown-toggle:hover, .nav-boxed-btn:hover { border-radius: 0 !important; background-color: rgba(0, 0, 0, 0.25) !important; }
        .border-sdca { border-color: #a12124 !important; }
        .text-sdca { color: #a12124 !important; }
        .bg-sdca { background-color: #a12124 !important; }
        .navbar, .navbar * { font-family: 'Century Gothic', 'CenturyGothic', AppleGothic, sans-serif !important; font-weight: bold !important; }
        .sidebar-menu a { font-family: 'Century Gothic', 'CenturyGothic', AppleGothic, sans-serif !important; font-weight: 400 !important; color: #343434; display: flex; align-items: center; padding: 10px 16px; text-decoration: none; border-radius: 0 !important; transition: background-color 0.2s ease, color 0.2s ease; }
        .sidebar-menu a:hover, .sidebar-menu a.active, .sidebar-menu li.active > a { border-radius: 0 !important; background-color: #a12124 !important; color: #ffffff !important; }
        .sidebar-menu a:hover i, .sidebar-menu a.active i, .sidebar-menu li.active > a i { color: #ffffff !important; }
        .main-content, .card, .card-body { font-family: 'Century Gothic', 'CenturyGothic', AppleGothic, sans-serif !important; }
        h1, h2, h3, h4, h5, h6, .card-title, strong, b { font-family: 'Century Gothic', 'CenturyGothic', AppleGothic, sans-serif !important; font-weight: 700 !important; }
        p, small, span, .text-muted, td, th { font-family: 'Century Gothic', 'CenturyGothic', AppleGothic, sans-serif !important; font-weight: 400 !important; }
        .btn, .form-control, .form-select, .card, .modal-content, .modal-header, .modal-footer, .modal-body, .badge, .table, .input-group { border-radius: 0 !important; }
        
        /* DTR Specific Styles */
        .intern-profile-card { border-left: 4px solid var(--sdca-red); }
        .dtr-filter-bar { background-color: #fff; padding: 15px; border-bottom: 2px solid #eee; }
        .status-badge { padding: 4px 12px; font-size: 0.75rem; font-weight: 600; }
        .hours-highlight { font-size: 1.5rem; font-weight: 700; color: var(--sdca-red); }
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
            <li><a href="<?= base_url('admin'); ?>#dashboard"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
            <li><a href="<?= base_url('admin'); ?>#intern-management"><i class="fas fa-users"></i><span>Intern Management</span></a></li>
            <li><a href="<?= base_url('admin'); ?>#ojt-management"><i class="fas fa-user-clock"></i><span>OJT Management</span></a></li>
            <li class="active"><a href="<?= base_url('admin/view_dtr/' . $intern['id']); ?>"><i class="fas fa-calendar-alt"></i><span>DTR and Time Records</span></a></li>
            <li><a href="<?= base_url('admin'); ?>#analytics"><i class="fas fa-chart-line"></i><span>Analytics and Reports</span></a></li>
            <li><a href="<?= base_url('admin'); ?>#announcements"><i class="bi bi-megaphone"></i><span>Announcements</span></a></li>
            <li><a href="<?= base_url('admin'); ?>#inquiries"><i class="bi bi-question-circle"></i><span>Inquiries &amp; Concerns</span></a></li>
            <li><a href="<?= base_url('admin'); ?>#admin-tools"><i class="fas fa-cogs"></i><span>Administrative Tools</span></a></li>
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
                <a class="navbar-brand fw-bold d-flex align-items-center m-0 p-0 h-100" href="<?= base_url('admin'); ?>#dashboard"><i class="bi bi-clock-history me-2"></i>OJT Hours Tracker</a>
                <div class="d-flex align-items-stretch h-100">
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
        </nav>
        <main class="main-content-area">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show"><?= html_escape($this->session->flashdata('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show"><?= html_escape($this->session->flashdata('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>#dashboard" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>#dtr-records" class="text-decoration-none">DTR Records</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></li>
                </ol>
            </nav>

            <!-- Intern Profile Card -->
            <div class="card intern-profile-card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="me-3" style="width: 60px; height: 60px; background-color: #ffebee; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person-fill text-sdca" style="font-size: 2rem;"></i>
                                </div>
                                <div>
                                    <h3 class="mb-1 fw-bold"><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></h3>
                                    <p class="mb-1 text-muted">
                                        <i class="bi bi-envelope me-1"></i><?= html_escape($intern['email']); ?>
                                        <?php if (!empty($intern['school'])): ?>
                                            <span class="ms-3"><i class="bi bi-building me-1"></i><?= html_escape($intern['school']); ?></span>
                                        <?php endif; ?>
                                    </p>
                                    <span class="badge bg-<?= $intern['account_status'] === 'approved' ? 'success' : ($intern['account_status'] === 'pending' ? 'warning' : 'secondary'); ?>">
                                        <?= ucfirst($intern['account_status']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="mb-2">
                                <small class="text-muted text-uppercase fw-semibold">Total Hours Rendered</small>
                                <div class="hours-highlight"><?= number_format((float)$intern['total_hours'], 1); ?> hrs</div>
                            </div>
                            <a href="<?= base_url('admin'); ?>#intern-management" class="btn btn-sm btn-outline-sdca">
                                <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DTR Records Card -->
            <div class="card section-card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-calendar3 me-2"></i>Daily Time Records</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-sdca" onclick="window.print()">
                            <i class="bi bi-printer me-1"></i>Print
                        </button>
                        <a href="<?= base_url('admin/view_dtr/' . $intern['id'] . '?export=csv'); ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download me-1"></i>Export CSV
                        </a>
                    </div>
                </div>
                
                <!-- Filter Bar -->
                <div class="dtr-filter-bar">
                    <form method="get" action="<?= base_url('admin/view_dtr/' . $intern['id']); ?>" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Filter by Month</label>
                            <select name="month" class="form-select">
                                <option value="">All Months</option>
                                <?php 
                                $month_names = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                for ($m = 1; $m <= 12; $m++): 
                                ?>
                                    <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT); ?>" <?= $selected_month == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : ''; ?>>
                                        <?= $month_names[$m]; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Year</label>
                            <select name="year" class="form-select">
                                <?php 
                                $current_year = date('Y');
                                for ($y = $current_year - 2; $y <= $current_year + 1; $y++): 
                                ?>
                                    <option value="<?= $y; ?>" <?= $selected_year == $y ? 'selected' : ''; ?>><?= $y; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-1"></i>Apply Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="<?= base_url('admin/view_dtr/' . $intern['id']); ?>" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-circle me-1"></i>Clear
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Summary Stats -->
                <div class="card-body border-bottom">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase fw-semibold d-block">Filtered Period Logs</small>
                                <h3 class="mb-0 fw-bold text-sdca"><?= $filtered_total_logs; ?></h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase fw-semibold d-block">Filtered Hours</small>
                                <h3 class="mb-0 fw-bold text-sdca"><?= number_format($filtered_total_hours, 1); ?> hrs</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase fw-semibold d-block">Average Hours/Day</small>
                                <h3 class="mb-0 fw-bold text-sdca"><?= $filtered_total_logs > 0 ? number_format($filtered_total_hours / $filtered_total_logs, 1) : 0; ?> hrs</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DTR Table -->
                <div class="table-responsive">
                    <table id="dtrTable" class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Hours Rendered</th>
                                <th>Task Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($dtr_logs)): foreach ($dtr_logs as $log): ?>
                                <tr>
                                    <td><strong><?= date('M d, Y', strtotime($log['log_date'])); ?></strong><br><small class="text-muted"><?= date('l', strtotime($log['log_date'])); ?></small></td>
                                    <td>
                                        <?php if (!empty($log['time_in'])): ?>
                                            <span class="badge bg-success"><?= date('h:i A', strtotime($log['time_in'])); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($log['time_out'])): ?>
                                            <span class="badge bg-info text-dark"><?= date('h:i A', strtotime($log['time_out'])); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Not timed out</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong class="text-sdca"><?= number_format((float)$log['hours_rendered'], 2); ?> hrs</strong></td>
                                    <td>
                                        <small><?= html_escape($log['task_summary'] ?: 'No description'); ?></small>
                                    </td>
                                    <td>
                                        <?php 
                                        $status_class = 'secondary';
                                        if ($log['status'] === 'Approved') $status_class = 'success';
                                        elseif ($log['status'] === 'Pending') $status_class = 'warning';
                                        elseif ($log['status'] === 'Rejected') $status_class = 'danger';
                                        elseif ($log['status'] === 'Completed') $status_class = 'primary';
                                        ?>
                                        <span class="badge bg-<?= $status_class; ?>"><?= html_escape($log['status']); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-calendar-x display-4 d-block mb-2"></i>
                                        No DTR records found for the selected period.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#dtrTable').DataTable({
        "pageLength": 25,
        "lengthChange": true,
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

// Sidebar clock
function updateAdminSidebarClock() { 
    const now = new Date(); 
    document.getElementById('adminSidebarTime').textContent = now.toLocaleTimeString('en-US', { timeZone: 'Asia/Manila', hour: 'numeric', minute: '2-digit', second: '2-digit', hour12: true }); 
    document.getElementById('adminSidebarDate').textContent = now.toLocaleDateString('en-US', { timeZone: 'Asia/Manila', month: 'long', day: 'numeric', year: 'numeric' }); 
}
updateAdminSidebarClock(); 
setInterval(updateAdminSidebarClock, 1000);

// Logout confirmation
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
            confirmButtonColor: '#a12124',
            cancelButtonColor: '#625f5f',
            confirmButtonText: 'Yes, Log Out',
            cancelButtonText: 'Cancel',
            customClass: { popup: 'rounded-0', confirmButton: 'rounded-0', cancelButton: 'rounded-0' }
        }).then((result) => { if (result.isConfirmed) { window.location.href = targetUrl; } });
    }
});
</script>
</body>
</html>