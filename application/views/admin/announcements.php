<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - SDCA OJT Tracker</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/sdcalogoorig.png'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root { --sdca-red: #800000; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; padding-top: 48px; background-color: #f4f6f9; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1000' height='1000' viewBox='0 0 1000 1000'%3E%3Cg stroke='%23800000' stroke-width='1.2' fill='none' opacity='0.12'%3E%3Cpolygon points='100,200 400,100 700,300 900,150'/%3E%3Cpolygon points='300,800 600,950 900,700'/%3E%3Cline x1='100' y1='200' x2='600' y2='950'/%3E%3Cline x1='400' y1='100' x2='900' y2='700'/%3E%3Cline x1='700' y1='300' x2='300' y2='800'/%3E%3C/g%3E%3C/svg%3E"); background-repeat: repeat; background-size: 800px 800px; animation: floatBackground 35s linear infinite; }
        @keyframes floatBackground { 0% { background-position: 0 0; } 50% { background-position: 100px -150px; } 100% { background-position: 0 0; } }

        .sidebar { width: 240px; height: 100vh; position: fixed; inset: 0 auto 0 0; background: #fff; z-index: 1030; box-shadow: 4px 0 15px rgba(0,0,0,.1); overflow-y: auto; }
        .sidebar-brand { border-bottom: 1px solid #eee; }
        .sidebar-logo { max-height: 52px; width: auto; }
        .sidebar-menu { list-style: none; padding: 0; margin: 12px 0 0; }
        .sidebar-menu a { color: #495057; padding: 12px 20px; display: flex; align-items: center; gap: 12px; text-decoration: none; font-size: .92rem; font-weight: 500; border-left: 4px solid transparent; }
        .sidebar-menu a i { width: 20px; text-align: center; color: #6c757d; }
        .sidebar-menu a:hover, .sidebar-menu li.active a { background: #fff5f5; color: var(--sdca-red); border-left-color: var(--sdca-red); font-weight: 700; }
        .sidebar-menu li.active a i, .sidebar-menu a:hover i { color: var(--sdca-red); }

        :root { --sdca-red: #8b0000; }

        .sidebar-menu a { position: relative; z-index: 1; pointer-events: auto; }
        .bg-sdca { background-color: var(--sdca-red) !important; }
        .top-navbar { height: 48px; background: var(--sdca-red); position: fixed; top: 0; left: 240px; width: calc(100% - 240px); z-index: 1020; }
        .main-content { margin-left: 240px; padding: 28px 32px; }

        .page-header { margin-bottom: 2rem; }
        .page-header h2 { color: #25292d; font-weight: 700; }

        .announcement-card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); margin-bottom: 1rem; transition: box-shadow 0.3s ease; }
        .announcement-card:hover { box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }

        .announcement-card.inactive { opacity: 0.6; background-color: #f8f9fa; }

        .category-badge { font-size: 0.75rem; padding: 0.4rem 0.8rem; }

        .btn-sdca { background-color: var(--sdca-red); color: white; border: none; }
        .btn-sdca:hover { background-color: #6a0000; color: white; }
        @media (max-width: 768px) { .sidebar { width: 76px; } .sidebar-brand span, .sidebar-menu span { display: none; } .sidebar-menu a { justify-content: center; padding: 15px 8px; } .main-content { margin-left: 76px; padding: 20px 14px; } .top-navbar { left: 76px; width: calc(100% - 76px); } }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand p-3 text-center">
        <a href="<?= base_url('admin'); ?>"><img src="<?= base_url('assets/images/sdcalogo.png'); ?>" alt="SDCA Logo" class="sidebar-logo img-fluid"></a>
    </div>
    <ul class="sidebar-menu">
        <li><a href="<?= base_url('admin'); ?>"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
        <li><a href="#"><i class="fas fa-users"></i><span>Intern Management</span></a></li>
        <li><a href="#"><i class="fas fa-user-clock"></i><span>OJT Management</span></a></li>
        <li><a href="#"><i class="fas fa-calendar-alt"></i><span>DTR and Time Records</span></a></li>
        <li><a href="#"><i class="fas fa-chart-line"></i><span>Analytics and Reports</span></a></li>
        <li class="active"><a href="<?= base_url('admin/announcements'); ?>"><i class="bi bi-megaphone"></i><span>Announcements</span></a></li>
        <li><a href="#"><i class="fas fa-cogs"></i><span>Administrative Tools</span></a></li>
    </ul>
</aside>

<nav class="top-navbar bg-sdca navbar navbar-dark shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="<?= base_url('admin'); ?>"><i class="bi bi-clock-history me-2"></i>OJT Hours Tracker</a>
        <a class="btn btn-sm text-white" href="<?= base_url('auth/logout'); ?>"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="bi bi-megaphone me-2"></i>Announcements</h2>
            <p class="text-muted">Broadcast important messages to all interns</p>
        </div>
        <button type="button" class="btn btn-sdca btn-lg" data-bs-toggle="modal" data-bs-target="#newAnnouncementModal">
            <i class="bi bi-plus-circle me-2"></i>New Announcement
        </button>
    </div>

    <!-- ALERT MESSAGES -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i><?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- ANNOUNCEMENTS LIST -->
    <?php if (!empty($announcements)): ?>
        <?php foreach ($announcements as $announcement): ?>
            <div class="card announcement-card <?= $announcement['is_active'] ? '' : 'inactive'; ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <h5 class="card-title mb-0"><?= html_escape($announcement['title']); ?></h5>
                                <?php if (!$announcement['is_active']): ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                                <?php if (!empty($announcement['category'])): ?>
                                    <span class="badge bg-info category-badge"><?= html_escape($announcement['category']); ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="card-text text-muted" style="max-height: 80px; overflow: hidden; text-overflow: ellipsis;">
                                <?= nl2br(html_escape(substr($announcement['message'], 0, 200))); ?>
                                <?php if (strlen($announcement['message']) > 200): ?>...<strong>Read more</strong><?php endif; ?>
                            </p>
                            <small class="text-muted d-block">
                                <i class="bi bi-person me-1"></i>Posted by <?= html_escape($announcement['first_name'] . ' ' . $announcement['last_name']); ?>
                                <br>
                                <i class="bi bi-calendar me-1"></i><?= date('F j, Y \a\t g:i A', strtotime($announcement['created_at'])); ?>
                                <?php if (!empty($announcement['expires_at'])): ?>
                                    <br><i class="bi bi-clock me-1"></i>Expires: <?= date('F j, Y', strtotime($announcement['expires_at'])); ?>
                                <?php endif; ?>
                                <br><i class="bi bi-send me-1"></i><?= !empty($announcement['target_user_id']) ? 'Sent to ' . html_escape($announcement['recipient_first_name'] . ' ' . $announcement['recipient_last_name']) : 'All Interns'; ?>
                            </small>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="<?= base_url('admin/edit_announcement/' . $announcement['id']); ?>" class="btn btn-sm btn-outline-primary mb-2">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </a>
                            <a href="<?= base_url('admin/delete_announcement/' . $announcement['id']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this announcement?');">
                                <i class="bi bi-trash me-1"></i>Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-megaphone display-4 text-muted mb-3 d-block"></i>
                <h5 class="text-muted">No announcements yet</h5>
                <p class="text-muted">Create your first announcement to communicate with interns</p>
                <button type="button" class="btn btn-sdca" data-bs-toggle="modal" data-bs-target="#newAnnouncementModal">
                    <i class="bi bi-plus-circle me-2"></i>Create Announcement
                </button>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="newAnnouncementModal" tabindex="-1" aria-labelledby="newAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('admin/create_announcement_process'); ?>" method="post">
                <div class="modal-header bg-sdca text-white">
                    <h5 class="modal-title" id="newAnnouncementModalLabel">New Announcement</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label" for="announcementTitle">Title</label><input id="announcementTitle" class="form-control" name="title" maxlength="255" required></div>
                    <div class="mb-3"><label class="form-label" for="announcementMessage">Message</label><textarea id="announcementMessage" class="form-control" name="message" rows="5" required></textarea></div>
                    <div class="row g-3"><div class="col-md-6"><label class="form-label" for="announcementCategory">Category</label><select id="announcementCategory" class="form-select" name="category"><option value="">General</option><option value="Important">Important</option><option value="Event">Event</option><option value="Deadline">Deadline</option><option value="Maintenance">Maintenance</option><option value="Policy">Policy</option></select></div><div class="col-md-6"><label class="form-label" for="announcementExpiry">Expiration Date</label><input id="announcementExpiry" class="form-control" type="date" name="expires_at"></div></div>
                    <div class="mt-3"><label class="form-label" for="announcementTarget">Recipient / Target</label><select id="announcementTarget" class="form-select" name="target_type"><option value="all">All Interns</option><option value="specific">Specific Intern</option></select></div>
                    <div id="specificInternField" class="mt-3 d-none"><label class="form-label" for="targetUserId">Intern</label><select id="targetUserId" class="form-select" name="target_user_id"><option value="">Select an intern</option><?php foreach ($interns as $intern): ?><option value="<?= (int)$intern['id']; ?>"><?= html_escape(trim($intern['first_name'] . ' ' . $intern['last_name']) . ' - ' . $intern['email']); ?></option><?php endforeach; ?></select></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-sdca">Send Announcement</button></div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const announcementTarget = document.getElementById('announcementTarget');
const specificInternField = document.getElementById('specificInternField');
const targetUserId = document.getElementById('targetUserId');
announcementTarget.addEventListener('change', function() {
    const isSpecific = announcementTarget.value === 'specific';
    specificInternField.classList.toggle('d-none', !isSpecific);
    targetUserId.required = isSpecific;
});
</script>
</body>
</html>
