<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Official Daily Time Record - <?= $student_name; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
            body { padding: 0; background: #fff; }
        }
        body { padding: 30px; background: #f8f9fa; }
        .cert-header { border-bottom: 2px solid #800000; }
    </style>
</head>
<body>
    <div class="container bg-white p-5 shadow-sm rounded">
        <div class="d-flex justify-content-between align-items-center no-print mb-4">
            <a href="<?= base_url('ojt'); ?>" class="btn btn-secondary btn-sm">&larr; Back to Dashboard</a>
            <button onclick="window.print()" class="btn btn-danger btn-sm fw-bold"><i class="bi bi-printer"></i> Print / Save as PDF</button>
        </div>

        <div class="text-center cert-header pb-3 mb-4">
            <h3 class="fw-bold text-uppercase mb-1">St. Dominic College of Asia</h3>
            <h6 class="text-secondary">OJT DAILY TIME RECORD (DTR) REPORT</h6>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <strong>Student Name:</strong> <?= $student_name; ?><br>
                <strong>Student ID:</strong> <?= $student_id; ?>
            </div>
            <div class="col-6 text-end">
                <strong>Total Accumulated Hours:</strong> <span class="text-danger fw-bold fs-5"><?= number_format($total_hours, 2); ?> hrs</span><br>
                <strong>Generated Date:</strong> <?= date('F d, Y'); ?>
            </div>
        </div>

        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Hours</th>
                    <th>Task Summary</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($logs)): foreach($logs as $log): ?>
                <tr>
                    <td><?= date('M d, Y', strtotime($log['log_date'])); ?></td>
                    <td><?= date('h:i A', strtotime($log['time_in'])); ?></td>
                    <td><?= !empty($log['time_out']) ? date('h:i A', strtotime($log['time_out'])) : 'N/A'; ?></td>
                    <td class="fw-bold"><?= number_format($log['hours_rendered'], 2); ?></td>
                    <td><?= !empty($log['task_summary']) ? html_escape($log['task_summary']) : 'N/A'; ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="text-center">No logs recorded.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="row mt-5 pt-4 text-center">
            <div class="col-6">
                _________________________________<br>
                <strong>Student Signature</strong>
            </div>
            <div class="col-6">
                _________________________________<br>
                <strong>OJT Supervisor Signature</strong>
            </div>
        </div>
    </div>
</body>
</html>