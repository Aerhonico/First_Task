<main class="main-content">
    <!-- ADMIN NAVBAR -->
    <nav class="navbar navbar-dark bg-sdca mb-4 shadow-sm">
        <div class="container-fluid px-4">
            <span class="navbar-brand fw-bold">
                <i class="bi bi-shield-lock me-2"></i>Admin Dashboard
            </span>
            <div class="d-flex gap-2">
                <!-- PORTFOLIO CONTROLS -->
                <a href="<?= base_url(); ?>" class="btn btn-outline-light btn-sm fw-bold">
                    <i class="bi bi-eye me-1"></i> View Portfolio
                </a>
                <a href="<?= base_url('portfolio/edit'); ?>" class="btn btn-warning btn-sm fw-bold">
                    <i class="bi bi-pencil-square me-1"></i> Edit Portfolio
                </a>
                <a href="<?= site_url('auth/logout'); ?>" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 pb-5">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 14px;">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-people me-2"></i>Interns & OJT Records</h5>
            <p class="text-muted">Welcome, Admin! Here you will manage intern records and track OJT progress.</p>
        </div>
    </div>
</main>