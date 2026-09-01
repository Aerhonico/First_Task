<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement - SDCA OJT Tracker</title>
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

        .btn-sdca { background-color: var(--sdca-red); color: white; border: none; }
        .btn-sdca:hover { background-color: #6a0000; color: white; }

        .form-card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }

        textarea.form-control { min-height: 300px; resize: vertical; }
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
    <div class="page-header">
        <h2><i class="bi bi-plus-circle me-2"></i>Create New Announcement</h2>
        <p class="text-muted">Send an important message to all interns in the system</p>
    </div>

    <!-- ALERT MESSAGES -->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i><?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- CREATE FORM -->
    <div class="card form-card">
        <div class="card-body p-4">
            <form action="<?= base_url('admin/create_announcement_process'); ?>" method="POST">

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Announcement Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g., OJT Program Update" required autofocus maxlength="255">
                    <small class="text-muted">Keep titles concise and informative</small>
                </div>

                <!-- Message -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Message *</label>
                    <textarea name="message" class="form-control" placeholder="Write your announcement message here..." required></textarea>
                    <small class="text-muted">This message will be visible to all interns</small>
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Category</label>
                    <select name="category" class="form-select">
                        <option value="">-- Select Category --</option>
                        <option value="General">General</option>
                        <option value="Important">Important</option>
                        <option value="Event">Event</option>
                        <option value="Deadline">Deadline</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Policy">Policy</option>
                    </select>
                </div>

                <!-- Expiration Date -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Expiration Date (Optional)</label>
                    <input type="date" name="expires_at" class="form-control">
                    <small class="text-muted">Leave blank to keep announcement active indefinitely</small>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-sdca btn-lg fw-semibold">
                        <i class="bi bi-send-check me-2"></i>Post Announcement
                    </button>
                    <a href="<?= base_url('admin/announcements'); ?>" class="btn btn-outline-secondary btn-lg fw-semibold">
                        <i class="bi bi-arrow-left me-2"></i>Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- INFO BOX -->
    <div class="alert alert-info mt-4" role="alert">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Note:</strong> All announcements will be immediately visible to all registered interns. Consider using categories to organize your messages.
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
