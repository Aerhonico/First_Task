<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SDCA OJT Tracker</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/sdcalogoorig.png'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root { --sdca-red: #800000; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; background-color: #f4f6f9; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1000' height='1000' viewBox='0 0 1000 1000'%3E%3Cg stroke='%23800000' stroke-width='1.2' fill='none' opacity='0.12'%3E%3Cpolygon points='100,200 400,100 700,300 900,150'/%3E%3Cpolygon points='300,800 600,950 900,700'/%3E%3Cline x1='100' y1='200' x2='600' y2='950'/%3E%3Cline x1='400' y1='100' x2='900' y2='700'/%3E%3Cline x1='700' y1='300' x2='300' y2='800'/%3E%3Ccircle cx='400' cy='100' r='4' fill='%23800000'/%3E%3Ccircle cx='700' cy='300' r='4' fill='%23800000'/%3E%3Ccircle cx='300' cy='800' r='4' fill='%23800000'/%3E%3C/g%3E%3C/svg%3E"); background-repeat: repeat; background-size: 800px 800px; animation: floatBackground 35s linear infinite; color: #212529; }
        @keyframes floatBackground { 0% { background-position: 0 0; } 50% { background-position: 100px -150px; } 100% { background-position: 0 0; } }
        .app-container { display: flex; min-height: 100vh; }
        .sidebar { width: 240px; height: 100vh; position: fixed; inset: 0 auto 0 0; display: flex; flex-direction: column; background: #fff; z-index: 1030; box-shadow: 4px 0 15px rgba(0,0,0,.1); overflow-y: auto; }
        .sidebar-brand { border-bottom: 1px solid #eee; }
        .sidebar-logo { max-height: 52px; width: auto; }
        .sidebar-menu { list-style: none; padding: 0; margin: 8px 0 0; }
        .sidebar-menu a { color: #495057; padding: 9px 16px; display: flex; align-items: center; gap: 10px; text-decoration: none; font-size: .82rem; font-weight: 500; border-left: 4px solid transparent; }
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
            background-color: #800000 !important; /* Base maroon header background */
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
    </style>
</head>
<body>
<div class="app-container">
    <aside class="sidebar">
        <div class="sidebar-brand p-3 text-center">
            <a href="<?= base_url('admin'); ?>"><img src="<?= base_url('assets/images/sdcalogo.png'); ?>" alt="SDCA Logo" class="sidebar-logo img-fluid"></a>
            <hr class="my-2">
            <div class="sidebar-clock" ><div class="small text-muted mb-2"><i class="bi bi-shield-lock me-1"></i>ADMIN PORTAL</div><div id="adminSidebarTime" class="sidebar-time">--:--:-- --</div><div id="adminSidebarDate" class="sidebar-date mt-1">----------------</div></div>
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
        <nav class="top-navbar navbar navbar-dark p-0 shadow-sm"><div class="container-fluid px-4 d-flex align-items-stretch justify-content-between h-100"><a class="navbar-brand fw-bold d-flex align-items-center m-0 p-0 h-100" href="#dashboard"><i class="bi bi-clock-history me-2"></i>OJT Hours Tracker</a><div class="d-flex align-items-stretch h-100"><div class="d-flex align-items-stretch h-100"><div class="dropdown d-flex align-items-stretch h-100"><button class="btn text-white d-flex align-items-center gap-2 px-3 border-0" type="button" data-bs-toggle="dropdown"><span class="badge bg-danger"><?= (int)$pending_count; ?></span><i class="bi bi-inbox-fill opacity-75"></i><span class="fw-semibold">Inbox</span></button><ul class="dropdown-menu dropdown-menu-end shadow-sm p-2"><li class="dropdown-header fw-bold">Pending approvals and requests</li><li><hr class="dropdown-divider"></li><li class="small px-2 py-1">Intern registrations: <?= (int)$pending_intern_count; ?></li><li class="small px-2 py-1">Deletion requests: <?= (int)$request_count; ?></li></ul></div><div class="dropdown admin-nav-divider d-flex align-items-center h-100"><button class="btn dropdown-toggle d-flex align-items-center gap-2 px-3 border-0 bg-transparent text-white h-100" type="button" data-bs-toggle="dropdown"><i class="bi bi-person-circle fs-4"></i><div class="text-start lh-sm"><span class="d-block fw-bold text-white" style="font-size:.85rem;">Administrator</span><span class="d-block text-white-50" style="font-size:.7rem;">Admin</span></div></button><div class="dropdown-menu dropdown-menu-end shadow border-0 p-0 overflow-hidden" style="width:260px;"><div class="text-center p-3 bg-light border-bottom"><i class="bi bi-shield-lock display-5 text-dark d-block mb-1"></i><h6 class="fw-bold mb-0">Administrator</h6><small class="text-muted">ADMIN ACCOUNT</small></div><div class="list-group list-group-flush small"><a href="<?= base_url('portfolio'); ?>" class="list-group-item list-group-item-action py-2"><i class="bi bi-eye me-2"></i>View Portfolio</a><a href="<?= base_url('portfolio/edit'); ?>" class="list-group-item list-group-item-action py-2"><i class="bi bi-pencil-square me-2"></i>Edit Portfolio</a><a href="<?= base_url('auth/logout'); ?>" class="list-group-item list-group-item-action py-2 text-danger fw-bold btn-logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></div></div></div></div></div></div></nav>
        <main class="main-content-area">
            <?php if ($this->session->flashdata('success')): ?><div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;"><div id="successToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true"><div class="d-flex"><div class="toast-body"><?= html_escape($this->session->flashdata('success')); ?></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div></div><?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= html_escape($this->session->flashdata('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

            <section id="dashboard" class="section-anchor mb-4"><div class="d-flex justify-content-between align-items-center mb-3"><div><h3 class="fw-bold mb-1">Admin Dashboard</h3><p class="text-muted mb-0">System-wide internship monitoring and verification.</p></div><span class="badge bg-danger">Administrator</span></div><div class="row g-3"><div class="col-md-3"><div class="card stat-card shadow-sm p-3"><small class="text-muted">REGISTERED INTERNS</small><h2 class="mb-0"><?= (int)$intern_count; ?></h2><small class="text-muted">Active, pending, and completed accounts</small></div></div><div class="col-md-3"><div class="card stat-card shadow-sm p-3"><small class="text-muted">TIME INS TODAY</small><h2 class="mb-0"><?= (int)$time_ins_today; ?></h2><small class="text-muted">Intern attendance for today</small></div></div><div class="col-md-3"><div class="card stat-card shadow-sm p-3"><small class="text-muted">PENDING APPROVALS / REQUESTS</small><h2 class="mb-0"><?= (int)$pending_count; ?></h2><small class="text-muted">Interns: <?= (int)$pending_intern_count; ?> · Deletions: <?= (int)$request_count; ?></small></div></div><div class="col-md-3"><div class="card stat-card shadow-sm p-3"><small class="text-muted">LATE TODAY</small><h2 class="mb-0"><?= (int)$late_today; ?></h2><small class="text-muted">Time-ins after 8:00 AM</small></div></div></div></section>

            <section id="dashboard-quick-panels" class="row g-3 mb-4">
                <div class="col-lg-6"><div class="card section-card shadow-sm h-100"><div class="card-header bg-white d-flex justify-content-between"><strong><i class="bi bi-clock-history me-2"></i>Latest Time In / Time Outs</strong><span class="badge bg-secondary">Latest 3</span></div><div class="list-group list-group-flush"><?php if (!empty($latest_attendance)): foreach (array_slice($latest_attendance, 0, 3) as $attendance): ?><div class="list-group-item"><strong><?= html_escape(trim($attendance['first_name'] . ' ' . $attendance['last_name'])); ?></strong><span class="float-end small"><?= !empty($attendance['time_out']) ? 'Timed out' : 'Timed in'; ?></span><small class="d-block text-muted"><?= html_escape($attendance['log_date']); ?> · In: <?= html_escape($attendance['time_in']); ?><?php if (!empty($attendance['time_out'])): ?> · Out: <?= html_escape($attendance['time_out']); ?><?php endif; ?></small></div><?php endforeach; else: ?><div class="list-group-item text-muted">No attendance activity yet.</div><?php endif; ?></div></div></div>
                <div class="col-lg-6"><div class="card section-card shadow-sm h-100"><div class="card-header bg-white d-flex justify-content-between"><strong><i class="bi bi-person-check me-2"></i>Newly Approved Interns</strong><span class="badge bg-success">Latest 3</span></div><div class="list-group list-group-flush"><?php if (!empty($newly_approved_interns)): foreach ($newly_approved_interns as $approved): ?><div class="list-group-item d-flex justify-content-between"><span><?= html_escape(trim($approved['first_name'] . ' ' . $approved['last_name'])); ?><small class="d-block text-muted"><?= html_escape($approved['email']); ?></small></span><small class="text-muted"><?= html_escape($approved['created_at']); ?></small></div><?php endforeach; else: ?><div class="list-group-item text-muted">No approved interns yet.</div><?php endif; ?></div></div></div>
                <div class="col-lg-6"><div class="card section-card shadow-sm h-100"><div class="card-header bg-white d-flex justify-content-between"><strong><i class="bi bi-person-plus me-2"></i>Interns to Approve</strong><span class="badge bg-warning text-dark">Latest 3</span></div><div class="list-group list-group-flush"><?php if (!empty($interns_to_approve)): foreach ($interns_to_approve as $pending_intern): ?><div class="list-group-item d-flex justify-content-between align-items-center"><span><?= html_escape(trim($pending_intern['first_name'] . ' ' . $pending_intern['last_name'])); ?><small class="d-block text-muted"><?= html_escape($pending_intern['email']); ?></small></span><div class="d-flex gap-2"><button type="button" class="btn btn-sm btn-success intern-decision-button" data-decision="approve" data-decision-url="<?= base_url('admin/approve_intern/' . (int)$pending_intern['id']); ?>" data-bs-toggle="modal" data-bs-target="#internDecisionModal">Approve</button><button type="button" class="btn btn-sm btn-danger intern-decision-button" data-decision="deny" data-decision-url="<?= base_url('admin/reject_intern/' . (int)$pending_intern['id']); ?>" data-bs-toggle="modal" data-bs-target="#internDecisionModal">Deny</button></div></div><?php endforeach; else: ?><div class="list-group-item text-muted">No interns awaiting approval.</div><?php endif; ?></div></div></div>
                <div class="col-lg-6"><div class="card section-card shadow-sm h-100"><div class="card-header bg-white d-flex justify-content-between"><strong><i class="bi bi-envelope-exclamation me-2"></i>Deletion Requests</strong><div class="d-flex align-items-center gap-2"><span class="badge bg-danger">Latest 3</span><?php if (!empty($requests)): ?><button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#clearDeletionRequestsModal">Clear</button><?php endif; ?></div></div><div class="list-group list-group-flush"><?php if (!empty($requests)): foreach ($requests as $request): ?><div class="list-group-item d-flex justify-content-between align-items-center"><span><?= html_escape($request['sender_name']); ?><small class="d-block text-muted"><?= html_escape($request['subject']); ?></small></span><a href="<?= base_url('admin/mark_request_read/' . (int)$request['id']); ?>" class="btn btn-sm btn-outline-success">Review</a></div><?php endforeach; else: ?><div class="list-group-item text-muted">No deletion requests.</div><?php endif; ?></div></div></div>
            </section>

            <section id="intern-management" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white d-flex justify-content-between align-items-center"><h5 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i>Intern Management & Verification</h5><a href="#intern-management" class="btn btn-sm btn-outline-primary"><i class="bi bi-search me-1"></i>Search Directory</a></div><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Intern</th><th>Department / School</th><th>Supervisor</th><th>Progress</th><th>Status</th><th>Action</th></tr></thead><tbody><?php if (!empty($interns)): foreach ($interns as $intern): ?><?php $progress = $required_hours > 0 ? min(100, round(((float)$intern['rendered_hours'] / $required_hours) * 100, 1)) : 0; ?><tr><td><strong><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></strong><br><small class="text-muted"><?= html_escape($intern['email']); ?></small></td><td><?= html_escape(!empty($intern['school']) ? $intern['school'] : 'Not assigned'); ?></td><td>Not assigned</td><td><div class="d-flex justify-content-between small"><span><?= number_format((float)$intern['rendered_hours'], 1); ?> / <?= number_format((float)$required_hours, 0); ?> hrs</span><strong><?= $progress; ?>%</strong></div><div class="progress"><div class="progress-bar bg-danger" style="width:<?= $progress; ?>%"></div></div></td><td><span class="badge text-bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#intern<?= (int)$intern['id']; ?>"><i class="bi bi-pencil"></i> Edit</button></td></tr><?php endforeach; else: ?><tr><td colspan="6" class="text-center text-muted py-4">No intern accounts found.</td></tr><?php endif; ?></tbody></table></div></section>
            <?php if (!empty($interns)): foreach ($interns as $intern): ?><div class="modal fade" id="intern<?= (int)$intern['id']; ?>" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><form action="<?= base_url('admin/update_intern/' . (int)$intern['id']); ?>" method="POST"><div class="modal-header"><h5 class="modal-title">Verify / Edit Intern Account</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="row g-3"><?php foreach (array('first_name' => 'First Name', 'middle_name' => 'Middle Name', 'last_name' => 'Last Name', 'email' => 'Email', 'student_id' => 'Student ID', 'school' => 'Department / School', 'year_section' => 'Year / Section', 'academic_year' => 'Academic Year', 'semester' => 'Semester') as $field => $label): ?><div class="col-md-4"><label class="form-label"><?= $label; ?></label><input type="<?= $field === 'email' ? 'email' : 'text'; ?>" class="form-control" name="<?= $field; ?>" value="<?= html_escape($intern[$field]); ?>" <?= in_array($field, array('first_name', 'last_name', 'email')) ? 'required' : ''; ?>></div><?php endforeach; ?></div></div><div class="modal-footer"><button type="submit" class="btn btn-primary">Save Intern</button></div></form></div></div></div><?php endforeach; endif; ?>

            <section id="ojt-management" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white"><h5 class="mb-0 fw-bold"><i class="bi bi-person-check me-2"></i>OJT Management & Verification</h5></div><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Intern</th><th>Date</th><th>Task Description</th><th>Hours</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php if (!empty($recent_logs)): foreach ($recent_logs as $log): ?><tr><td><?= html_escape(trim($log['first_name'] . ' ' . $log['last_name'])); ?></td><td><?= html_escape($log['log_date']); ?></td><td><?= html_escape($log['task_summary']); ?></td><td><?= number_format((float)$log['hours_rendered'], 2); ?></td><td><span class="badge text-bg-secondary"><?= html_escape($log['status']); ?></span></td><td><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#log<?= (int)$log['id']; ?>">Edit / Verify</button> <button type="button" class="btn btn-sm btn-outline-danger delete-log-button" data-delete-url="<?= base_url('admin/delete_log/' . (int)$log['id']); ?>" data-bs-toggle="modal" data-bs-target="#deleteLogModal">Delete</button></td></tr><?php endforeach; else: ?><tr><td colspan="6" class="text-center text-muted py-4">No OJT records found.</td></tr><?php endif; ?></tbody></table></div></section>
            <?php if (!empty($recent_logs)): foreach ($recent_logs as $log): ?><div class="modal fade" id="log<?= (int)$log['id']; ?>" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form action="<?= base_url('admin/update_log/' . (int)$log['id']); ?>" method="POST"><div class="modal-header"><h5 class="modal-title">Verify OJT Record</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><label class="form-label">Date</label><input type="date" name="log_date" class="form-control mb-2" value="<?= html_escape($log['log_date']); ?>" required><label class="form-label">Time In</label><input name="time_in" class="form-control mb-2" value="<?= html_escape($log['time_in']); ?>" required><label class="form-label">Time Out</label><input name="time_out" class="form-control mb-2" value="<?= html_escape($log['time_out']); ?>"><label class="form-label">Hours Rendered</label><input type="number" step="0.01" name="hours_rendered" class="form-control mb-2" value="<?= html_escape($log['hours_rendered']); ?>"><label class="form-label">Task Description</label><textarea name="task_summary" class="form-control mb-2"><?= html_escape($log['task_summary']); ?></textarea><label class="form-label">Verification Status</label><select name="status" class="form-select"><option>Pending</option><option>Approved</option><option>Rejected</option><option>completed</option></select></div><div class="modal-footer"><button class="btn btn-primary">Save Verification</button></div></form></div></div></div><?php endforeach; endif; ?>

            <section id="dtr-records" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white"><h5 class="mb-0 fw-bold"><i class="bi bi-calendar3 me-2"></i>DTR and Time Records</h5></div><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Intern</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Rendered</th><th>Status</th></tr></thead><tbody><?php if (!empty($recent_logs)): foreach ($recent_logs as $log): ?><tr><td><?= html_escape(trim($log['first_name'] . ' ' . $log['last_name'])); ?></td><td><?= html_escape($log['log_date']); ?></td><td><?= html_escape($log['time_in']); ?></td><td><?= !empty($log['time_out']) ? html_escape($log['time_out']) : '<span class="badge bg-warning text-dark">Timed in</span>'; ?></td><td><?= number_format((float)$log['hours_rendered'], 2); ?> hrs</td><td><?= html_escape($log['status']); ?></td></tr><?php endforeach; else: ?><tr><td colspan="6" class="text-center text-muted py-4">No DTR records found.</td></tr><?php endif; ?></tbody></table></div></section>

            <section id="analytics" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white"><h5 class="mb-0 fw-bold"><i class="bi bi-bar-chart-line me-2"></i>Program Analytics & Reports</h5></div><div class="card-body"><div class="row g-3"><div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">AT-RISK / LAGGING INTERNS</small><h3><?= count($at_risk_interns); ?></h3></div></div><div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">REQUIRED HOURS TARGET</small><h3><?= number_format((float)$required_hours, 0); ?> hrs</h3></div></div><div class="col-md-4"><div class="p-3 bg-light rounded"><small class="text-muted">APPROVED RECORDS</small><h3><?php $approved_count = 0; foreach ($recent_logs as $analytics_log) { if ($analytics_log['status'] === 'Approved') { $approved_count++; } } echo $approved_count; ?></h3></div></div></div><hr><h6 class="fw-bold">At-Risk Intern Alert</h6><?php if (!empty($at_risk_interns)): ?><div class="list-group list-group-flush"><?php foreach ($at_risk_interns as $risk): ?><div class="list-group-item d-flex justify-content-between"><span><?= html_escape(trim($risk['first_name'] . ' ' . $risk['last_name'])); ?></span><span class="text-danger fw-bold"><?= $risk['progress']; ?>% complete</span></div><?php endforeach; ?></div><?php else: ?><p class="text-muted mb-0">No interns are currently below the alert threshold.</p><?php endif; ?><hr><h6 class="fw-bold">Department / School Overview</h6><div class="row g-2"><?php foreach ($departments as $department): ?><div class="col-md-4"><div class="border rounded p-2 d-flex justify-content-between"><span><?= html_escape($department['department']); ?></span><strong><?= (int)$department['intern_count']; ?></strong></div></div><?php endforeach; ?></div></div></section>

            <section id="announcements" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white d-flex justify-content-between align-items-center"><h5 class="mb-0 fw-bold"><i class="bi bi-megaphone me-2"></i>Announcements</h5><button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#newAnnouncementModal"><i class="bi bi-plus-circle me-1"></i>New Announcement</button></div><div class="list-group list-group-flush"><?php if (!empty($announcements)): foreach ($announcements as $announcement): ?><div class="list-group-item"><div class="d-flex justify-content-between"><strong><?= html_escape($announcement['title']); ?></strong><span class="badge <?= $announcement['is_active'] ? 'bg-success' : 'bg-secondary'; ?>"><?= $announcement['is_active'] ? 'Active' : 'Inactive'; ?></span></div><small class="text-muted d-block mt-1"><?= html_escape($announcement['message']); ?></small><small class="text-muted d-block mt-2">Target: <?= !empty($announcement['target_user_id']) ? html_escape($announcement['recipient_first_name'] . ' ' . $announcement['recipient_last_name']) : 'All Interns'; ?></small></div><?php endforeach; else: ?><div class="list-group-item text-muted">No announcements yet.</div><?php endif; ?></div></section>
            <section id="inquiries" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white d-flex justify-content-between align-items-center"><h5 class="mb-0 fw-bold"><i class="bi bi-question-circle me-2"></i>Inquiries &amp; Concerns</h5><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#inquiryHistoryModal"><i class="bi bi-clock-history me-1"></i>Reply History</button></div><div class="card-body"><?php $has_open_inquiries = FALSE; if (!empty($inquiries)): foreach ($inquiries as $inquiry): if ($inquiry['status'] !== 'Open') { continue; } $has_open_inquiries = TRUE; ?><article class="border-start border-4 border-danger ps-3 mb-4"><div class="d-flex justify-content-between gap-3"><div><strong><?= html_escape(trim($inquiry['first_name'] . ' ' . $inquiry['last_name'])); ?></strong><small class="d-block text-muted"><?= html_escape($inquiry['email']); ?> | <?= date('M d, Y g:i A', strtotime($inquiry['created_at'])); ?></small><span class="badge bg-secondary my-2"><?= html_escape($inquiry['category']); ?></span><p><?= nl2br(html_escape($inquiry['message'])); ?></p></div><span class="badge align-self-start bg-warning text-dark">Open</span></div><form action="<?= base_url('admin/reply_to_inquiry/' . (int)$inquiry['id']); ?>" method="post"><label class="form-label small fw-bold">Reply</label><textarea class="form-control" name="admin_reply" rows="3" required></textarea><button type="submit" class="btn btn-sm btn-danger mt-2"><i class="bi bi-reply me-1"></i>Send Reply</button></form></article><?php endforeach; endif; if (!$has_open_inquiries): ?><p class="text-muted mb-0">No open intern inquiries.</p><?php endif; ?></div></section>
            <section id="admin-tools" class="section-anchor card section-card shadow-sm mb-4"><div class="card-header bg-white"><h5 class="mb-0 fw-bold"><i class="bi bi-tools me-2"></i>Administrative Tools & System Settings</h5></div><div class="card-body"><div class="row g-3"><div class="col-md-3"><h6 class="fw-bold">User Role Control</h6><p class="text-muted small">Manage intern account details through the Intern Management edit controls.</p><a href="#intern-management" class="btn btn-sm btn-outline-primary">Manage Users</a></div><div class="col-md-3"><h6 class="fw-bold">Reports & PDF Export</h6><p class="text-muted small">Generate an official master DTR audit report.</p><a href="<?= base_url('ojt/export_pdf'); ?>" target="_blank" class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf me-1"></i>Export PDF</a></div><div class="col-md-3"><h6 class="fw-bold">System Logs & Audit Trail</h6><p class="text-muted small">Review deletion requests and account activity from the management queues.</p><a href="#ojt-management" class="btn btn-sm btn-outline-secondary">Review Activity</a></div><div class="col-md-3"><h6 class="fw-bold">Intern Support</h6><p class="text-muted small">Review and respond to intern inquiries and concerns.</p><a href="#inquiries" class="btn btn-sm btn-outline-success">Open Inquiries</a></div></div></div></section>
        </main>
    </div>
</div>
<div class="modal fade" id="inquiryHistoryModal" tabindex="-1" aria-labelledby="inquiryHistoryModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-scrollable modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="inquiryHistoryModalLabel">Inquiry Reply History</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><?php $has_reply_history = FALSE; foreach ($inquiries as $inquiry): if ($inquiry['status'] === 'Answered' && !empty($inquiry['admin_reply'])): $has_reply_history = TRUE; ?><article class="border-start border-4 border-success ps-3 mb-4"><div class="d-flex justify-content-between"><strong><?= html_escape(trim($inquiry['first_name'] . ' ' . $inquiry['last_name'])); ?></strong><small class="text-muted"><?= !empty($inquiry['replied_at']) ? date('M d, Y g:i A', strtotime($inquiry['replied_at'])) : ''; ?></small></div><span class="badge bg-secondary my-2"><?= html_escape($inquiry['category']); ?></span><p class="mb-2"><strong>Inquiry:</strong> <?= nl2br(html_escape($inquiry['message'])); ?></p><div class="bg-light p-3"><strong>Reply:</strong><br><?= nl2br(html_escape($inquiry['admin_reply'])); ?></div></article><?php endif; endforeach; if (!$has_reply_history): ?><p class="text-muted text-center mb-0">No replies have been sent yet.</p><?php endif; ?></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div></div></div></div>
<div class="modal fade" id="newAnnouncementModal" tabindex="-1" aria-labelledby="newAnnouncementModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><form action="<?= base_url('admin/create_announcement_process'); ?>" method="post"><div class="modal-header"><h5 class="modal-title" id="newAnnouncementModalLabel">New Announcement</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title" required></div><div class="mb-3"><label class="form-label">Message</label><textarea class="form-control" name="message" rows="4" required></textarea></div><div class="mb-3"><label class="form-label">Target</label><select class="form-select" name="target_type"><option value="all">All Interns</option><option value="specific">Specific Intern</option></select></div><div class="mb-3"><label class="form-label">Specific Intern</label><select class="form-select" name="target_user_id"><option value="">Select an intern</option><?php foreach ($announcement_interns as $intern): ?><option value="<?= (int)$intern['id']; ?>"><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name'])); ?></option><?php endforeach; ?></select></div><div class="mb-3"><label class="form-label">Category</label><input class="form-control" name="category"></div><div><label class="form-label">Expiration Date</label><input class="form-control" type="date" name="expires_at"></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger" type="submit">Send Announcement</button></div></form></div></div></div>
<div class="modal fade" id="clearDeletionRequestsModal" tabindex="-1" aria-labelledby="clearDeletionRequestsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('admin/clear_deletion_requests'); ?>" method="post">
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
            confirmButtonColor: '#800000', /* Maroon theme */
            cancelButtonColor: '#4a5568',  /* Dark neutral gray */
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
        controls.innerHTML = '<input type="search" id="internSearch" class="form-control form-control-sm" placeholder="Search intern or email" aria-label="Search interns"><select id="internStatusFilter" class="form-select form-select-sm" aria-label="Filter intern status"><option value="">All statuses</option><option value="active">Active</option><option value="pending">Pending</option><option value="deactivated">Deactivated</option></select>';
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
</body>
</html>
