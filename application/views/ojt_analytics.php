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
        <h4 class="fw-bold mb-4">Analytics & Weekly Goal Progress</h4>
        
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