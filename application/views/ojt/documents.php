<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents - OJT Hours Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --sdca-red: #800000; }
        body { min-height: 100vh; margin: 0; padding-top: 48px; background: #f4f6f9; color: #25292d; }
        .app-container { display: flex; min-height: 100vh; }
        .sidebar { position: fixed; inset: 0 auto 0 0; z-index: 1030; width: 240px; background: #fff; box-shadow: 4px 0 15px rgba(0, 0, 0, .1); }
        .sidebar-logo { max-height: 52px; width: auto; }
        .sidebar-menu { list-style: none; padding: 0; margin: 12px 0 0; }
        .sidebar-menu a { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #495057; text-decoration: none; border-left: 4px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu li.active a { color: var(--sdca-red); background: #fff5f5; border-left-color: var(--sdca-red); font-weight: 700; }
        .main-content { flex: 1; min-width: 0; margin-left: 240px; }
        .bg-sdca { background: var(--sdca-red); }
        .topbar { position: fixed; top: 0; left: 240px; z-index: 1020; width: calc(100% - 240px); height: 48px; }
        .nav-boxed-btn { height: 48px; border-radius: 0 !important; color: #fff !important; display: flex; align-items: center; background: transparent !important; }
        .nav-boxed-btn:hover, .nav-boxed-btn:focus, .nav-boxed-btn:active, .nav-boxed-btn.show { background-color: rgba(0, 0, 0, .25) !important; color: #fff !important; }
        .page-wrap { max-width: 1080px; }
        .document-card { border-left: 4px solid var(--sdca-red); }
        .status-pending { color: #8a5a00; background: #fff3cd; }
        .status-verified { color: #146c43; background: #d1e7dd; }
        .status-rejected { color: #b02a37; background: #f8d7da; }
        @media (max-width: 768px) { .sidebar { width: 76px; } .sidebar-menu span { display: none; } .sidebar-menu a { justify-content: center; padding: 15px 8px; } .main-content { margin-left: 76px; } .topbar { left: 76px; width: calc(100% - 76px); } .topbar .navbar-brand span { display: none; } }
    </style>
</head>
<body>
<div class="app-container">
<aside class="sidebar"><div class="p-3 text-center border-bottom"><a href="<?= base_url('ojt'); ?>"><img src="<?= base_url('assets/images/sdcalogo.png'); ?>" alt="SDCA Logo" class="sidebar-logo img-fluid"></a></div><ul class="sidebar-menu"><li><a href="<?= base_url('ojt'); ?>"><i class="bi bi-house"></i><span>Dashboard</span></a></li><li class="active"><a href="<?= base_url('ojt/documents'); ?>"><i class="bi bi-file-earmark-text"></i><span>Documents</span></a></li><li><a href="<?= base_url('ojt/inquiries'); ?>"><i class="bi bi-question-circle"></i><span>Inquiries / Support</span></a></li></ul></aside>
<div class="main-content">
<nav class="navbar navbar-dark bg-sdca topbar shadow-sm p-0"><div class="container-fluid px-4 h-100"><a class="navbar-brand fw-bold d-flex align-items-center h-100 m-0" href="<?= base_url('ojt'); ?>"><i class="bi bi-clock-history me-2"></i><span>OJT Hours Tracker</span></a><div class="d-flex align-items-stretch h-100"><a class="nav-boxed-btn btn px-3" href="<?= base_url('ojt'); ?>"><i class="bi bi-inbox-fill me-2"></i><span>Inbox</span></a><div class="dropdown"><button class="nav-boxed-btn btn px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown"><i class="bi bi-person-circle me-2"></i><span><?= html_escape(!empty($intern_name) ? $intern_name : 'OJT Student'); ?></span></button><ul class="dropdown-menu dropdown-menu-end shadow-sm"><li><a class="dropdown-item" href="<?= base_url('ojt'); ?>">Dashboard</a></li><li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout'); ?>">Logout</a></li></ul></div></div></div></nav>
<main class="container page-wrap py-4">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><h2 class="fw-bold mb-1">Documents</h2><p class="text-muted mb-0">Submit your required internship documents for verification.</p></div></div>
    <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= html_escape($this->session->flashdata('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= html_escape($this->session->flashdata('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
    <div class="card shadow-sm border-0 mb-4"><div class="card-body p-4"><form action="<?= base_url('ojt/upload_document'); ?>" method="post" enctype="multipart/form-data" class="row g-3 align-items-start"><div class="col-md-4"><label class="form-label fw-semibold" for="documentType">Document type</label><select class="form-select" id="documentType" name="document_type" required><option value="">Select a document</option><option value="Resume / CV">Resume / CV</option><option value="Registration Form / COE">Registration Form / Certificate of Enrollment</option><option value="Endorsement Letter">Endorsement Letter</option><option value="Internship Agreement / Waiver">Internship Agreement / Waiver</option></select></div><div class="col-md-5"><label class="form-label fw-semibold" for="documentFile">File</label><input class="form-control" id="documentFile" type="file" name="document_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required><small class="text-muted">PDF, DOC, DOCX, JPG, or PNG, up to 5 MB.</small></div><div class="col-md-3"><label class="form-label fw-semibold invisible">Upload</label><button class="btn btn-danger w-100" type="submit"><i class="bi bi-upload me-1"></i>Upload Document</button></div></form></div></div>
    <div class="row g-3">
        <?php $required_documents = array('Resume / CV', 'Registration Form / COE', 'Endorsement Letter', 'Internship Agreement / Waiver'); ?>
        <?php foreach ($required_documents as $required_document): ?>
            <?php $document = NULL; foreach ($documents as $item) { if ($item['document_type'] === $required_document) { $document = $item; break; } } ?>
            <div class="col-md-6"><div class="card document-card shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between gap-3"><div><h5 class="mb-1"><?= html_escape($required_document); ?></h5><?php if ($document): ?><small class="text-muted d-block text-break"><?= html_escape($document['original_name']); ?></small><small class="text-muted">Uploaded <?= date('M d, Y g:i A', strtotime($document['uploaded_at'])); ?></small><?php else: ?><small class="text-muted">Not uploaded yet</small><?php endif; ?></div><?php if ($document): ?><span class="badge align-self-start status-<?= strtolower($document['status']); ?>"><?= html_escape($document['status']); ?></span><?php else: ?><span class="badge bg-secondary align-self-start">Missing</span><?php endif; ?></div><?php if ($document): ?><a class="btn btn-sm btn-outline-secondary mt-3" href="<?= base_url($document['file_path']); ?>" target="_blank" rel="noopener"><i class="bi bi-eye me-1"></i>View File</a><?php endif; ?></div></div></div>
        <?php endforeach; ?>
    </div>
</main>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
