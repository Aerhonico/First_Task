<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
       <!-- Tab Icon -->
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/favicon.png'); ?>">
    <style>
        :root { --sdca-red: #800000; --sdca-gold: #FFD700; }
        .bg-sdca { background-color: var(--sdca-red); }
        .progress-bar-sdca { background-color: var(--sdca-red); }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-sdca mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url(); ?>"><i class="bi bi-clock-history me-2"></i>OJT Hours Tracker</a>
        <!-- Action Buttons -->
        <div class="d-flex gap-2">
            <!-- Calculator Modal Trigger Button -->
            <button type="button" class="btn btn-warning btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#calcModal">
                <i class="bi bi-calculator me-1"></i> Calculator
            </button>
        <a href="<?= base_url(); ?>" class="btn btn-outline-light btn-sm">Back to Portfolio</a>
    </div>
</nav>

<div class="container pb-5">
    <!-- Progress Dashboard -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 text-center border-start border-4 border-danger">
                <small class="text-secondary uppercase">Hours Rendered</small>
                <h2 class="fw-bold text-danger mb-0"><?= number_format($rendered_hours, 1); ?> hrs</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 text-center border-start border-4 border-warning">
                <small class="text-secondary">Hours Remaining</small>
                <h2 class="fw-bold text-warning mb-0"><?= number_format($remaining_hours, 1); ?> hrs</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 text-center border-start border-4 border-dark">
                <small class="text-secondary">Target Hours</small>
                <h2 class="fw-bold text-dark mb-0"><?= $required_hours; ?> hrs</h2>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="card border-0 shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between mb-2">
            <span class="fw-bold">Overall Progress</span>
            <span class="fw-bold text-danger"><?= $progress_pct; ?>% Completed</span>
        </div>
        <div class="progress" style="height: 22px;">
            <div class="progress-bar progress-bar-sdca progress-bar-striped progress-bar-animated" 
                 role="progressbar" style="width: <?= $progress_pct; ?>%;">
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Log Entry Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2"></i>Log Daily Task</h5>
                <form action="<?= site_url('ojt/add_log'); ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Date</label>
                        <input type="date" name="log_date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Time In</label>
                            <input type="time" name="time_in" class="form-control" value="08:00" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Time Out</label>
                            <input type="time" name="time_out" class="form-control" value="17:00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tasks Accomplished</label>
                        <textarea name="task_summary" class="form-control" rows="3" placeholder="Type your accomplishments here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold bg-sdca">Save Log Entry</button>
                </form>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-table me-2"></i>Daily Time Record (DTR)</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Schedule</th>
                                <th>Hours</th>
                                <th>Task Description</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($logs)): ?>
                            <?php foreach($logs as $log): ?>
                                <tr>
                                    <td class="fw-bold"><?= date('M d, Y', strtotime($log['log_date'])); ?></td>
                                    <td class="small"><?= date('h:i A', strtotime($log['time_in'])); ?> - <?= date('h:i A', strtotime($log['time_out'])); ?></td>
                                    <?php $badge_class = ($log['hours_rendered'] >= 8) ? 'bg-success' : 'bg-danger'; ?>
                                    <td><span class="badge <?= $badge_class; ?>"><?= number_format($log['hours_rendered'], 2); ?> hrs</span></td>
                                    <td class="small"><?= html_escape($log['task_summary']); ?></td>
                                    
                                    <!-- Action Buttons: Edit & Delete -->
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $log['id']; ?>" title="Edit Log">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <a href="<?= site_url('ojt/delete_log/' . $log['id']); ?>" 
                                            class="btn btn-outline-danger" 
                                            onclick="return confirm('Are you sure you want to delete this time log?');"
                                            title="Delete Log">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>

                                        <!-- Edit Modal for this specific row -->
                                        <div class="modal fade text-start" id="editModal<?= $log['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content shadow border-0">
                                                    <div class="modal-header bg-sdca text-white">
                                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Time Log</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="<?= site_url('ojt/update_log/' . $log['id']); ?>" method="POST">
                                                        <div class="modal-body bg-light">
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-bold">Date</label>
                                                                <input type="date" name="log_date" class="form-control" value="<?= $log['log_date']; ?>" required>
                                                            </div>
                                                            <div class="row g-2 mb-3">
                                                                <div class="col-6">
                                                                    <label class="form-label small fw-bold">Time In</label>
                                                                    <input type="time" name="time_in" class="form-control" value="<?= $log['time_in']; ?>" required>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label small fw-bold">Time Out</label>
                                                                    <input type="time" name="time_out" class="form-control" value="<?= $log['time_out']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-bold">Tasks Accomplished</label>
                                                                <textarea name="task_summary" class="form-control" rows="3" required><?= html_escape($log['task_summary']); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-white">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-warning btn-sm fw-bold">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">No time logs submitted yet.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

                                <!-- Calculator Modal -->
<div class="modal fade" id="calcModal" tabindex="-1" aria-labelledby="calcModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-sdca text-white">
                <h6 class="modal-title fw-bold" id="calcModalLabel"><i class="bi bi-calculator me-2"></i>Simple Calculator</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <!-- Display Screen -->
                <input type="text" id="calcDisplay" class="form-control form-control-lg text-end bg-white fs-4 mb-3 border-secondary fw-bold" readonly value="0">
                
                <!-- Buttons Grid -->
                <div class="row g-2">
                    <div class="col-3"><button class="btn btn-danger w-100 fw-bold" onclick="calcClear()">C</button></div>
                    <div class="col-3"><button class="btn btn-secondary w-100 fw-bold" onclick="calcInput('/')">÷</button></div>
                    <div class="col-3"><button class="btn btn-secondary w-100 fw-bold" onclick="calcInput('*')">×</button></div>
                    <div class="col-3"><button class="btn btn-secondary w-100 fw-bold" onclick="calcBackspace()"><i class="bi bi-backspace"></i></button></div>

                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('7')">7</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('8')">8</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('9')">9</button></div>
                    <div class="col-3"><button class="btn btn-secondary w-100 fw-bold" onclick="calcInput('-')">-</button></div>

                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('4')">4</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('5')">5</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('6')">6</button></div>
                    <div class="col-3"><button class="btn btn-secondary w-100 fw-bold" onclick="calcInput('+')">+</button></div>

                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('1')">1</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('2')">2</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('3')">3</button></div>
                    <div class="col-3" rowspan="2"><button class="btn btn-warning w-100 h-100 fw-bold" onclick="calcEqual()">=</button></div>

                    <div class="col-6"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('0')">0</button></div>
                    <div class="col-3"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('.')">.</button></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Calculator Logic -->
<script>
    let display = document.getElementById('calcDisplay');

    function calcInput(val) {
        if (display.value === '0' || display.value === 'Error') {
            display.value = val;
        } else {
            display.value += val;
        }
    }

    function calcClear() {
        display.value = '0';
    }

    function calcBackspace() {
        display.value = display.value.slice(0, -1);
        if (display.value === '') display.value = '0';
    }

    function calcEqual() {
        try {
            display.value = eval(display.value);
        } catch (e) {
            display.value = 'Error';
        }
    }
</script>

</body>
</html>