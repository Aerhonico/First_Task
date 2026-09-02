<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'DTR Log Records'; ?></title>
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root { --sdca-red: #800000; }
        body { background-color: #f4f6f9; margin: 0; padding: 0; }
        .app-container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #2c3e50; color: #fff; flex-shrink: 0; }
        .sidebar-header { background-color: #1a252f; padding: 20px 15px; font-weight: bold; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li a { display: flex; align-items: center; padding: 14px 20px; color: #b8c7ce; text-decoration: none; border-left: 4px solid transparent; }
        .sidebar-menu li a:hover, .sidebar-menu li.active a { color: #fff; background-color: #1e2b37; border-left-color: var(--sdca-red); }
        .sidebar-menu i { margin-right: 12px; width: 20px; text-align: center; }
        .main-content { flex-grow: 1; padding: 30px; }
    </style>
</head>
<body>

<div class="app-container">
    <!-- SIDEBAR -->
    <aside class="sidebar shadow">
        <div class="sidebar-header text-uppercase">
            <i class="fas fa-clock text-warning"></i> OJT TRACKER
        </div>
        <ul class="sidebar-menu">
            <li><a href="<?= base_url('ojt'); ?>"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="<?= base_url('ojt/analytics'); ?>"><i class="fas fa-chart-bar"></i> Analytics & Goals</a></li>
            <li class="active"><a href="<?= base_url('ojt/logs'); ?>"><i class="fas fa-calendar-alt"></i> DTR Records & Filters</a></li>
            <li><a href="<?= base_url('ojt/export_pdf'); ?>" target="_blank"><i class="fas fa-file-pdf"></i> Export DTR (PDF)</a></li>
        </ul>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">
        <h4 class="fw-bold mb-4"><i class="bi bi-filter-square me-2"></i>DTR Records & Search Filter</h4>

        <!-- FILTER FORM -->
        <div class="card border-0 shadow-sm p-4 mb-4">
            <form action="<?= base_url('ojt/logs'); ?>" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Search Tasks / Keywords</label>
                    <input type="text" name="search" class="form-control" placeholder="Search accomplishment..." value="<?= html_escape($search); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="<?= $start_date; ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="<?= $end_date; ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-sdca w-100 fw-bold"><i class="bi bi-search me-1"></i> Filter</button>
                    <a href="<?= base_url('ojt/logs'); ?>" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-clockwise"></i></a>
                </div>
            </form>
        </div>

        <!-- LOGS TABLE -->
        <div class="card border-0 shadow-sm p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Rendered</th>
                            <th>Tasks / Accomplishments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($logs)): ?>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td class="fw-bold"><?= date('M d, Y', strtotime($log['log_date'])); ?></td>
                                    <td><?= date('h:i A', strtotime($log['time_in'])); ?></td>
                                    <td><?= !empty($log['time_out']) ? date('h:i A', strtotime($log['time_out'])) : '<span class="badge bg-warning text-dark">Running</span>'; ?></td>
                                    <td><span class="badge bg-danger"><?= number_format($log['hours_rendered'], 2); ?> hrs</span></td>
                                    <td class="small"><?= !empty($log['task_summary']) ? html_escape($log['task_summary']) : '<em class="text-muted">No description recorded</em>'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No attendance logs match your filter criteria.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

</body>
</html>