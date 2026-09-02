<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries and Support - OJT Hours Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>:root { --sdca-red: #800000; } body { min-height: 100vh; background: #f4f6f9; color: #25292d; } .topbar { background: var(--sdca-red); } .page-wrap { max-width: 1080px; } .ticket-card { border-left: 4px solid var(--sdca-red); } .reply-box { background: #edf7f1; border-left: 3px solid #198754; }</style>
</head>
<body>
<nav class="navbar navbar-dark topbar shadow-sm"><div class="container page-wrap"><a class="navbar-brand fw-bold" href="<?= base_url('ojt'); ?>"><i class="bi bi-clock-history me-2"></i>OJT Hours Tracker</a><a class="btn btn-sm btn-outline-light" href="<?= base_url('ojt'); ?>"><i class="bi bi-arrow-left me-1"></i>Dashboard</a></div></nav>
<main class="container page-wrap py-4">
    <div class="mb-4"><h2 class="fw-bold mb-1">Inquiries and Support</h2><p class="text-muted mb-0">Send concerns to the OJT administrator and track their response.</p></div>
    <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= html_escape($this->session->flashdata('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= html_escape($this->session->flashdata('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
    <div class="card shadow-sm border-0 mb-4"><div class="card-body p-4"><form action="<?= base_url('ojt/submit_inquiry'); ?>" method="post"><div class="row g-3"><div class="col-md-4"><label class="form-label fw-semibold" for="inquiryCategory">Category</label><select class="form-select" id="inquiryCategory" name="category" required><option value="">Select category</option><option value="DTR Discrepancy">DTR Discrepancy</option><option value="Requirement Query">Requirement Query</option><option value="General Concern">General Concern</option></select></div><div class="col-md-8"><label class="form-label fw-semibold" for="inquiryMessage">Message</label><textarea class="form-control" id="inquiryMessage" name="message" rows="3" maxlength="2000" required></textarea></div><div class="col-12"><button class="btn btn-danger" type="submit"><i class="bi bi-send me-1"></i>Submit Inquiry</button></div></div></form></div></div>
    <h5 class="fw-bold mb-3">My Inquiry History</h5>
    <?php if (!empty($inquiries)): foreach ($inquiries as $inquiry): ?><article class="card ticket-card shadow-sm mb-3"><div class="card-body"><div class="d-flex justify-content-between align-items-start gap-3"><div><span class="badge bg-secondary mb-2"><?= html_escape($inquiry['category']); ?></span><p class="mb-1"><?= nl2br(html_escape($inquiry['message'])); ?></p><small class="text-muted">Submitted <?= date('M d, Y g:i A', strtotime($inquiry['created_at'])); ?></small></div><span class="badge <?= $inquiry['status'] === 'Answered' ? 'bg-success' : ($inquiry['status'] === 'Closed' ? 'bg-secondary' : 'bg-warning text-dark'); ?>"><?= html_escape($inquiry['status']); ?></span></div><?php if (!empty($inquiry['admin_reply'])): ?><div class="reply-box p-3 mt-3"><strong class="d-block mb-1"><i class="bi bi-reply-fill me-1"></i>Administrator Reply</strong><?= nl2br(html_escape($inquiry['admin_reply'])); ?><?php if (!empty($inquiry['replied_at'])): ?><small class="text-muted d-block mt-2"><?= date('M d, Y g:i A', strtotime($inquiry['replied_at'])); ?></small><?php endif; ?></div><?php endif; ?></div></article><?php endforeach; else: ?><div class="text-center text-muted py-5">No inquiries submitted yet.</div><?php endif; ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
