<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'OJT Hours Tracker'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- FontAwesome Icons for Sidebar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png'); ?>">

    <style>
        :root { 
            --sdca-red: #800000; 
            --sdca-gold: #FFD700; 
        }

        .bg-sdca { background-color: var(--sdca-red); }
        .progress-bar-sdca { background-color: var(--sdca-red); }
        .clock-box { background: #1a1a1a; color: #00ffcc; border-radius: 8px; font-family: monospace; }

        /* ANIMATED GEOMETRIC NETWORK BACKGROUND */
        body {
            background-color: #f4f6f9;
            background-image: 
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1000' height='1000' viewBox='0 0 1000 1000'%3E%3Cg stroke='%23800000' stroke-width='1.2' fill='none' opacity='0.12'%3E%3Cpolygon points='100,200 400,100 700,300 900,150'/%3E%3Cpolygon points='300,800 600,950 900,700'/%3E%3Cline x1='100' y1='200' x2='600' y2='950'/%3E%3Cline x1='400' y1='100' x2='900' y2='700'/%3E%3Cline x1='700' y1='300' x2='300' y2='800'/%3E%3Ccircle cx='400' cy='100' r='4' fill='%23800000'/%3E%3Ccircle cx='700' cy='300' r='4' fill='%23800000'/%3E%3Ccircle cx='300' cy='800' r='4' fill='%23800000'/%3E%3C/g%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 800px 800px;
            animation: floatBackground 35s linear infinite;
            margin: 0;
            padding: 0;
        }

        /* KEYFRAME FOR FLOATING MOTION */
        @keyframes floatBackground {
            0% { background-position: 0px 0px; }
            50% { background-position: 100px -150px; }
            100% { background-position: 0px 0px; }
        }

        /* SIDEBAR & APP LAYOUT STYLES */
        .app-container { 
            display: flex; 
            min-height: 100vh; 
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #fff;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            background-color: #1a252f;
            padding: 20px 15px;
            font-weight: bold;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }

        .sidebar-menu { 
            list-style: none; 
            padding: 0; 
            margin: 0; 
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #b8c7ce;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: 0.2s;
        }

        .sidebar-menu li a:hover, 
        .sidebar-menu li.active a {
            color: #fff;
            background-color: #1e2b37;
            border-left-color: var(--sdca-red);
        }

        .sidebar-menu i { 
            margin-right: 12px; 
            width: 20px; 
            text-align: center; 
        }

        .main-content { 
            flex-grow: 1; 
            background-color: transparent; 
        }
        
    </style>
</head>
<body>

<div class="app-container">
    <!-- LEFT SIDEBAR PANEL -->
    <aside class="sidebar shadow">
        <div class="sidebar-header text-uppercase">
            <i class="fas fa-clock text-warning"></i> OJT TRACKER
        </div>
        <ul class="sidebar-menu">
            <li class="active">
                <a href="<?= base_url('ojt'); ?>"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            <li>
                <a href="<?= base_url('ojt/analytics'); ?>"><i class="fas fa-chart-bar"></i> Analytics & Goals</a>
            </li>
            <li>
                <a href="<?= base_url('ojt/logs'); ?>"><i class="fas fa-calendar-alt"></i> DTR Records & Filters</a>
            </li>
            <li>
                <a href="<?= base_url('ojt/export_pdf'); ?>" target="_blank"><i class="fas fa-file-pdf"></i> Export DTR (PDF)</a>
            </li>
        </ul>
    </aside>

    <!-- RIGHT MAIN CONTENT AREA -->
    <main class="main-content">
        <!-- TOP NAVBAR -->
        <nav class="navbar navbar-dark bg-sdca mb-4 shadow-sm">
            <div class="container-fluid px-4">
                <a class="navbar-brand fw-bold" href="<?= base_url(); ?>"><i class="bi bi-clock-history me-2"></i>OJT Hours Tracker</a>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-warning btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#calcModal">
                        <i class="bi bi-calculator me-1"></i> Calculator
                    </button>
                    <a href="<?= base_url(); ?>" class="btn btn-outline-light btn-sm">Back to Portfolio</a>
                </div>
            </div>
        </nav>

        <div class="container-fluid px-4 pb-5">

            <!-- LIVE PH TIMEZONE CLOCK BAR -->
            <div class="card border-0 shadow-sm clock-box p-3 mb-4 d-flex flex-row align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small text-uppercase fw-bold"><i class="bi bi-globe-asia-pacific me-1"></i>Philippine Standard Time (PST)</div>
                    <div id="phClock" class="fs-2 fw-bold text-warning">--:--:-- --</div>
                    <div id="phDate" class="small text-light">--------------------</div>
                </div>
                <div>
                    <button class="btn btn-outline-warning btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#targetHoursModal">
                        <i class="bi bi-pencil-square me-1"></i> Set Target Hours
                    </button>
                </div>
            </div>

            <!-- PROGRESS DASHBOARD -->
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

            <!-- PROGRESS BAR -->
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
                <!-- TIME IN / TIME OUT ACTION CARD -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 text-center">
                        <h5 class="fw-bold mb-3 text-start"><i class="bi bi-person-badge me-2"></i>Attendance Log</h5>
                        
                        <?php $has_active_log = isset($active_log) && !empty($active_log); ?>

                        <div class="d-grid gap-3 mb-3">
                            <!-- Time In Form -->
                            <form action="<?= site_url('ojt/time_in'); ?>" method="POST">
                                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold py-3" <?= $has_active_log ? 'disabled' : ''; ?>>
                                    <i class="bi bi-box-arrow-in-right me-2"></i> TIME IN
                                </button>
                            </form>

                            <!-- Time Out Form -->
                            <form action="<?= site_url('ojt/time_out'); ?>" method="POST">
                                <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold py-3" <?= !$has_active_log ? 'disabled' : ''; ?>>
                                    <i class="bi bi-box-arrow-left me-2"></i> TIME OUT
                                </button>
                            </form>
                        </div>

                        <div class="alert <?= $has_active_log ? 'alert-success' : 'alert-secondary'; ?> mb-0 small fw-bold">
                            Status: <?= $has_active_log ? 'Currently Timed In since ' . date('h:i A', strtotime($active_log['time_in'])) : 'Currently Timed Out'; ?>
                        </div>
                    </div>
                </div>

                <!-- LOGS TABLE (DTR) -->
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
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($logs)): ?>
                                    <?php foreach($logs as $log): ?>
                                        <tr>
                                            <td class="fw-bold"><?= date('M d, Y', strtotime($log['log_date'])); ?></td>
                                            <td class="small">
                                                <?= date('h:i A', strtotime($log['time_in'])); ?> - 
                                                <?= !empty($log['time_out']) ? date('h:i A', strtotime($log['time_out'])) : '<span class="badge bg-warning text-dark">Running...</span>'; ?>
                                            </td>
                                            <?php $badge_class = ($log['hours_rendered'] >= 8) ? 'bg-success' : (($log['hours_rendered'] > 0) ? 'bg-primary' : 'bg-secondary'); ?>
                                            <td><span class="badge <?= $badge_class; ?>"><?= number_format($log['hours_rendered'], 2); ?> hrs</span></td>
                                            <td class="small"><?= !empty($log['task_summary']) ? html_escape($log['task_summary']) : '<em class="text-muted">No task added yet</em>'; ?></td>
                                            
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $log['id']; ?>" title="Edit Log & Tasks">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <a href="<?= site_url('ojt/delete_log/' . $log['id']); ?>" 
                                                       class="btn btn-outline-danger" 
                                                       onclick="return confirm('Are you sure you want to delete this time log?');" title="Delete Log">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>

                                                <!-- EDIT ACCOMPLISHMENTS MODAL -->
                                                <div class="modal fade text-start" id="editModal<?= $log['id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content shadow border-0">
                                                            <div class="modal-header bg-sdca text-white">
                                                                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Update Entry & Tasks</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form action="<?= site_url('ojt/update_log/' . $log['id']); ?>" method="POST">
                                                                <div class="modal-body bg-light">
                                                                    <div class="mb-3">
                                                                        <label class="form-label small fw-bold">Tasks / Accomplishments</label>
                                                                        <textarea name="task_summary" class="form-control" rows="4" placeholder="Type your accomplishments for this shift..." required><?= html_escape($log['task_summary']); ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer bg-white">
                                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-warning btn-sm fw-bold">Save Tasks</button>
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
    </main>
</div>

<!-- SET TARGET HOURS MODAL -->
<div class="modal fade" id="targetHoursModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-sdca text-white">
                <h6 class="modal-title fw-bold"><i class="bi bi-gear me-2"></i>Set Target Hours</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('ojt/update_target_hours'); ?>" method="POST">
                <div class="modal-body bg-light">
                    <label class="form-label small fw-bold">Required OJT Hours</label>
                    <input type="number" step="0.5" min="1" name="required_hours" class="form-control" value="<?= $required_hours; ?>" required>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm fw-bold bg-sdca">Save Target</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- CALCULATOR MODAL -->
<div class="modal fade" id="calcModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-sdca text-white">
                <h6 class="modal-title fw-bold"><i class="bi bi-calculator me-2"></i>Calculator</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light">
                <input type="text" id="calcDisplay" class="form-control form-control-lg text-end bg-white fs-4 mb-3 border-secondary fw-bold" readonly value="0">
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
                    <div class="col-3"><button class="btn btn-warning w-100 fw-bold" onclick="calcEqual()">=</button></div>

                    <div class="col-6"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('0')">0</button></div>
                    <div class="col-6"><button class="btn btn-outline-dark w-100 fw-bold" onclick="calcInput('.')">.</button></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- REAL-TIME PST CLOCK SCRIPT -->
<script>
    function tickPHClock() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-US', { timeZone: 'Asia/Manila', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
        const dateStr = now.toLocaleDateString('en-US', { timeZone: 'Asia/Manila', weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

        document.getElementById('phClock').innerText = timeStr;
        document.getElementById('phDate').innerText = dateStr;
    }
    setInterval(tickPHClock, 1000);
    tickPHClock();

    // Calculator Functions
    let display = document.getElementById('calcDisplay');
    function calcInput(val) { display.value = (display.value === '0' || display.value === 'Error') ? val : display.value + val; }
    function calcClear() { display.value = '0'; }
    function calcBackspace() { display.value = display.value.slice(0, -1) || '0'; }
    function calcEqual() { try { display.value = eval(display.value); } catch(e) { display.value = 'Error'; } }
</script>

</body>
</html>