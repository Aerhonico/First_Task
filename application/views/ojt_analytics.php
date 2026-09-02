<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { width: 250px; background: #2c3e50; color: #fff; min-height: 100vh; }
        .sidebar a { color: #b8c7ce; text-decoration: none; display: block; padding: 14px 20px; }
        .sidebar a:hover, .sidebar li.active a { background: #1e2b37; color: #fff; border-left: 4px solid #800000; }
    </style>
</head>
<body>
<div class="d-flex">
    <aside class="sidebar">
        <div class="p-3 fw-bold bg-dark"><i class="fas fa-clock text-warning me-2"></i>OJT TRACKER</div>
        <ul class="list-unstyled">
            <li><a href="<?= base_url('ojt'); ?>"><i class="fas fa-home me-2"></i>Dashboard</a></li>
            <li class="active"><a href="<?= base_url('ojt/analytics'); ?>"><i class="fas fa-chart-bar me-2"></i>Analytics & Goals</a></li>
            <li><a href="<?= base_url('ojt/logs'); ?>"><i class="fas fa-calendar-alt me-2"></i>DTR Records & Filters</a></li>
            <li><a href="<?= base_url('ojt/export_pdf'); ?>" target="_blank"><i class="fas fa-file-pdf me-2"></i>Export DTR (PDF)</a></li>
        </ul>
    </aside>

    <main class="p-4 flex-grow-1">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Analytics & Weekly Goal Progress</h4>
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#targetHoursModal">
                <i class="fas fa-pen me-2"></i>Set Target Hours
            </button>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= html_escape($this->session->flashdata('success')); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= html_escape($this->session->flashdata('error')); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="row g-4">
            <!-- Feature 6: Weekly Goal Ring -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 text-center">
                    <h6 class="fw-bold text-muted mb-3">Weekly Target (40.0 hrs)</h6>
                    <?php $pct = min(100, round(($weekly_hours / $weekly_goal) * 100)); ?>
                    <div class="position-relative d-inline-flex justify-content-center align-items-center my-3">
                        <div class="spinner-border text-danger" style="width: 120px; height: 120px;" role="status"></div>
                        <span class="position-absolute fs-4 fw-bold text-dark"><?= $pct; ?>%</span>
                    </div>
                    <h3 class="fw-bold text-danger mt-2"><?= number_format($weekly_hours, 1); ?> / <?= $weekly_goal; ?> hrs</h3>
                    <small class="text-secondary">Logged this week</small>
                </div>
            </div>

            <!-- Feature 3: Daily Chart -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm p-4">
                    <h6 class="fw-bold text-muted mb-3">Hours Logged Per Day (This Week)</h6>
                    <canvas id="weeklyChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="targetHoursModal" tabindex="-1" aria-labelledby="targetHoursModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= site_url('ojt/update_target_hours'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="targetHoursModalLabel">Set Target Hours</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="required_hours" class="form-label">Target OJT hours</label>
                    <input id="required_hours" name="required_hours" type="number" class="form-control" min="0.5" step="0.5" value="<?= html_escape(number_format($weekly_goal, 1, '.', '')); ?>" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Save Target</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const ctx = document.getElementById('weeklyChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= $chart_labels; ?>,
        datasets: [{
            label: 'Hours Rendered',
            data: <?= $chart_data; ?>,
            backgroundColor: '#800000',
            borderRadius: 6
        }]
    },
    options: {
        scales: { y: { beginAtZero: true, max: 12 } }
    }
});
</script>
</body>
</html>