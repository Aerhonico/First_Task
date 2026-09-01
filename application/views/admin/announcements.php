<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - SDCA OJT Tracker</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/sdcalogoorig.png'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }

        .sidebar { width: 240px; height: 100vh; position: fixed; inset: 0 auto 0 0; background: #fff; z-index: 1030; box-shadow: 4px 0 15px rgba(0,0,0,.1); overflow-y: auto; }
        .sidebar-brand { border-bottom: 1px solid #eee; }
        .sidebar-logo { max-height: 52px; width: auto; }
        .sidebar-menu { list-style: none; padding: 0; margin: 12px 0 0; }
        .sidebar-menu a { color: #495057; padding: 12px 20px; display: flex; align-items: center; gap: 12px; text-decoration: none; font-size: .92rem; font-weight: 500; border-left: 4px solid transparent; }
        .sidebar-menu a i { width: 20px; text-align: center; color: #6c757d; }
        .sidebar-menu a:hover, .sidebar-menu li.active a { background: #fff5f5; color: var(--sdca-red); border-left-color: var(--sdca-red); font-weight: 700; }
        .sidebar-menu li.active a i, .sidebar-menu a:hover i { color: var(--sdca-red); }

        :root { --sdca-red: #8b0000; }

        .main-content { margin-left: 240px; padding: 2rem; }

        .page-header { margin-bottom: 2rem; }
        .page-header h2 { color: #25292d; font-weight: 700; }

        .announcement-card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); margin-bottom: 1rem; transition: box-shadow 0.3s ease; }
        .announcement-card:hover { box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }

        .announcement-card.inactive { opacity: 0.6; background-color: #f8f9fa; }

        .category-badge { font-size: 0.75rem; padding: 0.4rem 0.8rem; }

        .btn-sdca { background-color: var(--sdca-red); color: white; border: none; }
        .btn-sdca:hover { background-color: #6a0000; color: white; }
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

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="bi bi-megaphone me-2"></i>Announcements</h2>
            <p class="text-muted">Broadcast important messages to all interns</p>
        </div>
        <a href="<?= base_url('admin/create_announcement'); ?>" class="btn btn-sdca btn-lg">
            <i class="bi bi-plus-circle me-2"></i>New Announcement
        </a>
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
                <a href="<?= base_url('admin/create_announcement'); ?>" class="btn btn-sdca">
                    <i class="bi bi-plus-circle me-2"></i>Create Announcement
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
