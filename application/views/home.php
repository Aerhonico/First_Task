<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? html_escape($page_title) : 'My SDCA Portfolio'; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tab Icon -->
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/favicon.png'); ?>">
    
    <style>
        :root {
            --sdca-red: #800000;
            --sdca-gold: #FFD700;
        }

        /* Forces SDCA Red Navbar */
        .custom-sdca-nav {
            background-color: #800000 !important;
        }

        .text-sdca-red {
            color: #800000 !important;
        }

        /* Outlined Red Box Button (Matches Project Details Style) */
        .btn-outline-sdca {
            color: #800000 !important;
            border: 1px solid #800000 !important;
            background-color: transparent !important;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-outline-sdca:hover {
            color: #ffffff !important;
            background-color: #800000 !important;
        }

        /* Navbar Link Underline Styling */
        .navbar-nav .nav-link {
            position: relative;
            padding-bottom: 6px;
            transition: color 0.3s ease;
        }

        /* Underline for Active Tab */
        .navbar-nav .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #ffffff; /* Change color if your navbar isn't dark */
            border-radius: 2px;
        }

        .hero-section {
            background-color: #fcfcfc;
            background-image: radial-gradient(rgba(139, 0, 0, 0.25) 1px, transparent 1.5px);
            background-size: 18px 18px;
        }

        .hero-img {
            border-radius: 12px;
            box-shadow: -12px 12px 0px 0px #8b0000 !important;
            transition: transform 0.3s ease;
        }

        .hero-img:hover {
            transform: translateY(-4px);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            transition: transform 0.2s ease, background-color 0.2s ease;
            font-weight: 500;
        }

        .badge:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        /* Social Link Text & Icons */
        .social-link {
            color: #4a4a4a;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .social-link:hover {
            color: #8b0000;
            transform: translateY(-2px);
        }

        /* Vertical Divider Lines */
        .social-divider {
            color: #cccccc;
            font-weight: 300;
            user-select: none;
        }

        /* Vertical Divider Line */
        .vertical-divider {
            width: 2px;
            height: 180px;
            background-color: #e0e0e0;
            border-radius: 2px;
        }

        /* Hover Effect for Icon Cards */
        .tech-icon-card {
            padding: 10px;
            border-radius: 8px;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .tech-icon-card:hover {
            transform: translateY(-4px);
            background-color: #f8f9fa;
        }

        /* Badge Styles on Right Column */
        .skills-section .badge {
            background-color: #6c757d;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .skills-section .badge:hover {
            background-color: #8b0000;
            transform: translateY(-2px);
        }

        /* Custom size for the tech logos */
        .tech-icon-card i {
            font-size: 5rem; /* Increase this number (e.g., 4rem or 70px) to make them bigger */
        }

        /* Custom Navbar Color for Resume Button */
        .btn-navbar-theme {
            background-color: #8b0000 !important; /* Matches navbar dark maroon */
            border-color: #8b0000 !important;
            color: #ffffff !important;
        }

        /* Hover Effect */
        .btn-navbar-theme:hover {
            background-color: #6b0000 !important; /* Slightly darker on hover */
            border-color: #6b0000 !important;
        }

    </style>
</head>
<body>

<body data-bs-spy="scroll" data-bs-target="#mainNavbar" data-bs-offset="100" tabindex="0">

<div class="sticky-top style="z-index: 1030;">
<!-- Red Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark custom-sdca-nav sticky-top shadow-sm" id="mainNavbar">
  <div class="container">
    <a class="navbar-brand fw-bold text-white" href="<?= base_url(); ?>">
      PROFESSIONAL PORTFOLIO
    </a>
    <a class="navbar-brand text-white" style="font-size: 14px;" href="<?= base_url(); ?>">
    by Aerhon Magtira
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#projects">Projects</a></li>
        <li class="nav-item"><a class="nav-link" href="#skills">Tech Stack</a></li>
        <li class="nav-item"><a class="nav-link" href="#certifications">Certifications</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>

        <!-- LOGIN / LOGOUT BUTTON -->
        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
          <?php if($this->session->userdata('logged_in')): ?>
            <a href="<?= base_url('logout'); ?>" class="btn btn-sm btn-outline-light px-3 rounded-pill">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
          <?php else: ?>
            <a href="<?php echo base_url('login'); ?>" class="btn btn-outline-light rounded-pill px-3" target="_blank" rel="noopener noreferrer">
              <i class="fa-solid fa-lock me-1"></i> Login
            </a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

                    <!-- Flash Success Notification -->
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

<?php if($this->session->userdata('logged_in')): ?>
  <div class="bg-dark text-white py-2 px-3 d-flex justify-content-between align-items-center border-bottom border-warning">
    <span class="small fw-bold text-warning">
      <i class="bi bi-pencil-square me-1"></i> Admin Edit Mode Active
    </span>
    <div>
      <button class="btn btn-sm btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#editHeroModal">
        <i class="bi bi-person-gear"></i> Edit Hero Section
      </button>
      <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addProjectModal">
        <i class="fa-solid fa-plus"></i> Add New Project
      </button>
    </div>
  </div>
<?php endif; ?>
</div>

<?php if ($this->session->flashdata('hero_success')): ?>
    <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
        <?= $this->session->flashdata('hero_success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Hero Section -->
<header id="about" class="py-3 bg-white border-bottom">
<section class="hero-section py-5">
    <div class="container py-4">
        <div class="row align-items-center gy-4">
            
            <!-- Left Column: Portrait -->
            <div class="col-12 col-md-4 text-center text-md-start">
                <img src="<?= base_url('assets/images/grad-portrait.jpg'); ?>" 
                     alt="Aerhon Magtira Portrait" 
                     class="img-fluid rounded-3 hero-img shadow border border-3 border-light" 
                     style="width: 100%; max-width: 300px; height: 400px; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/300x400?text=Portrait';">
            </div>

            <!-- Right Column: Text & Buttons -->
            <div class="col-12 col-md-8">
            <h1 class="display-4 fw-bold">
                    Hi, I'm <span class="text-sdca-red"><?php echo htmlspecialchars($hero['full_name'] ?? 'Aerhon Louis Magtira'); ?></span>
                </h1>
                
                <p class="lead text-muted my-3">
                    <?php echo htmlspecialchars($hero['bio'] ?? ''); ?>
                </p>

                <!-- SDCA Styled Buttons -->
                <div class="d-flex align-items-center gap-2 mb-3">
                <!-- View My Resume (Solid Dark Red/Maroon) -->
                <a href="assets/uploads/Resume_Magtira.pdf" class="btn btn-navbar-theme text-white py-2 px-3"
                target="_blank" 
                rel="noopener noreferrer">
                    <i class="fa-solid fa-file-pdf me-1"></i> View My Resume
                </a>

                <!-- Contact Me (White Background with Dark Text & Border) -->
                <a href="#contact" class="btn btn-sm btn-outline-dark py-2 px-3">
                    Contact Me
                </a>
            </div>

            <!-- Professional Social Links with Separators -->
            <div class="hero-social-links mt-4 d-flex align-items-center gap-3">
                <!-- LinkedIn -->
                <a href="https://linkedin.com/in/aerhon-louis-magtira" target="_blank" title="LinkedIn Profile" class="social-link">
                    <i class="fa-brands fa-linkedin"></i> LinkedIn
                </a>
                <span class="social-divider">|</span>
                <!-- GitHub -->
                <a href="https://github.com/Aerhonico" target="_blank" title="GitHub Repository" class="social-link">
                    <i class="fa-brands fa-github"></i> GitHub
                </a>
                <span class="social-divider">|</span>
                <!-- Gmail -->
                <a href="mailto:aerhonlouis_magtira@sdca.edu.ph" title="Send me an email" class="social-link">
                    <i class="fa-solid fa-envelope"></i> Email
                </a>
            </div>
        </div>

            <!-- EDIT HERO MODAL -->
            <div class="modal fade" id="editHeroModal" tabindex="-1" aria-labelledby="editHeroModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <form action="<?php echo base_url('home/update_hero'); ?>" method="POST" enctype="multipart/form-data">                            
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title" id="editHeroModalLabel">
                                    <i class="fa-solid fa-pen-to-square text-warning me-2"></i>Edit Hero Details
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <!-- FULL NAME -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" 
                                        value="<?php echo htmlspecialchars($hero['full_name'] ?? 'Aerhon Louis Magtira', ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>

                                <!-- BIO / DESCRIPTION -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Bio</label>
                                    <textarea name="bio" id="heroBioInput" class="form-control" rows="5" required><?php 
                                        if (isset($hero['bio'])) {
                                            echo htmlspecialchars($hero['bio'], ENT_QUOTES, 'UTF-8');
                                        } elseif (isset($user['bio'])) {
                                            echo htmlspecialchars($user['bio'], ENT_QUOTES, 'UTF-8');
                                        } elseif (isset($profile['bio'])) {
                                            echo htmlspecialchars($profile['bio'], ENT_QUOTES, 'UTF-8');
                                        }
                                    ?></textarea>
                                    <div class="form-text">Enter your full summary paragraph here.</div>
                                </div>

                                <!-- PROFILE PICTURE UPLOAD 
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Profile Picture</label>
                                    <input type="file" name="profile_img" class="form-control" accept="image/*">
                                    <small class="text-muted">Leave blank if you do not want to change the current photo.</small>
                                </div>
                            </div> -->

                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn text-white" style="background-color: #800000;">Save Changes</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
</header>

<!-- Projects Section -->
<section id="projects" class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Recent Projects</h2>
            <p class="text-muted">Selected works presented as Capstone Project and Internet of Things (IoT).</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php if (!empty($projects) && is_array($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <!-- Added missing Bootstrap column wrapper -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 position-relative shadow border-0">

                            <?php if($this->session->userdata('logged_in')): ?>
                                <!-- Admin Quick Action Badges -->
                                <div class="position-absolute top-0 end-0 m-2 z-3">
                                    <button class="btn btn-sm btn-warning shadow-sm me-1" onclick="editProject(<?= isset($project['id']) ? $project['id'] : ''; ?>)">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <a href="<?= base_url('projects/delete/'.$project['id']); ?>" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Delete this project?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Dynamic Thumbnail Image with Fallback -->
                            <img src="<?= !empty($project['thumbnail_img']) && file_exists(FCPATH . 'assets/uploads/' . $project['thumbnail_img']) ? base_url('assets/uploads/' . $project['thumbnail_img']) : 'https://via.placeholder.com/400x220?text=Project+Preview'; ?>" 
                                 class="card-img-top object-fit-contain bg-light p-3"
                                 alt="<?= html_escape($project['title']); ?>" 
                                 style="height: 280px;">
                            
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold"><?= html_escape($project['title']); ?></h5>
                                <p class="card-text text-secondary flex-grow-1">
                                    <?= html_escape(character_limiter($project['description'], 110)); ?>
                                </p>

                                <!-- Tech Stack Badges -->
                                <?php if (!empty($project['tech_stack'])): ?>
                                    <div class="mb-3">
                                        <?php foreach (explode(',', $project['tech_stack']) as $tech): ?>
                                            <span class="badge bg-light text-dark border me-1 mb-1"><?= html_escape(trim($tech)); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Action Buttons Footer -->
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <!-- Details Button linked to Modal -->
                                    <button type="button" class="btn btn-outline-sdca btn-sm px-3" data-bs-toggle="modal" data-bs-target="#projectModal<?= $project['id']; ?>">
                                        Details
                                    </button>
                                    
                                    <!-- Redirect External Link or APK Download Button -->
                                    <?php if (!empty($project['demo_link'])): ?>
                                        
                                        <?php if (stristr($project['title'], 'JustiFi') || stristr($project['title'], 'Complaint')): ?>
                                            <!-- JUSTIFI: Download APK File -->
                                            <a href="<?php echo base_url('assets/apk/Justifi.apk'); ?>" download="Justifi.apk" class="btn btn-light border text-dark" title="Download APK">
                                                <i class="bi bi-download"></i> Download App
                                            </a>
                                        <?php else: ?>
                                            <!-- OTHER PROJECTS: Standard Arrow Link -->
                                            <a href="<?php echo html_escape($project['demo_link']); ?>" target="_blank" class="btn btn-sm btn-light border" title ="Visit Site Demo">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Modal with Carousel Slider for each Project -->
                        <div class="modal fade" id="projectModal<?= $project['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    
                                    <!-- Modal Header -->
                                    <div class="modal-header bg-sdca text-white">
                                        <h5 class="modal-title fw-bold"><?= html_escape($project['title']); ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body p-4 bg-light">
                                        
                                        <?php 
                                            // Prepare image array for Carousel
                                            $images = !empty($project['gallery_images']) ? explode(',', $project['gallery_images']) : [$project['image']];
                                        ?>

                                        <!-- Bootstrap Image Carousel -->
                                        <div id="carouselProject<?= $project['id']; ?>" class="carousel slide mb-4 shadow-sm rounded overflow-hidden" data-bs-ride="carousel">
                                            
                                            <!-- Carousel Indicators -->
                                            <?php if(count($images) > 1): ?>
                                                <div class="carousel-indicators">
                                                    <?php foreach($images as $index => $img): ?>
                                                        <button type="button" data-bs-target="#carouselProject<?= $project['id']; ?>" data-bs-slide-to="<?= $index; ?>" class="<?= $index === 0 ? 'active' : ''; ?>"></button>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Carousel Slides -->
                                            <div class="carousel-inner bg-dark">
                                                <?php foreach($images as $index => $img): ?>
                                                    <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                                                        <img src="<?= base_url('assets/uploads/' . trim($img)); ?>" 
                                                             class="d-block w-100" 
                                                             alt="Screenshot <?= $index + 1; ?>"
                                                             style="max-height: 420px; object-fit: contain; background: #1a1a1a;"
                                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/800x450?text=Project+Screenshot';">
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>

                                            <!-- Carousel Controls -->
                                            <?php if(count($images) > 1): ?>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselProject<?= $project['id']; ?>" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselProject<?= $project['id']; ?>" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Project Information Details -->
                                        <div class="bg-white p-3 rounded border">
                                            <h6 class="fw-bold text-dark mb-2">About the Project</h6>
                                            <p class="text-dark fs-6 lh-base mb-3" style="white-space: pre-line;">
                                                <?= nl2br(html_escape(!empty($project['long_description']) ? $project['long_description'] : $project['description'])); ?>
                                            </p>                            
                                        </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer bg-white">
                                        <?php if(!empty($project['project_url'])): ?>
                                            <a href="<?= $project['project_url']; ?>" target="_blank" class="btn btn-outline-sdca btn-sm">
                                                Live Preview / Code <i class="bi bi-box-arrow-up-right ms-1"></i>
                                            </a>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->

                    </div> <!-- End col-md-6 col-lg-4 -->
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">
                    <p class="lead">No projects found in the database. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

    <!-- Skills Section -->
    <section id="skills" class="py-5 bg-light border-top border-bottom">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Tech Stack</h2>
                <p class="text-muted">Tools and technologies I use to build web and mobile applications.</p>
            </div>

            <div class="row align-items-start">
        <!-- Left Column: Programming Languages & Essentials -->
        <div class="col-md-5">
    <h5 class="text-center fw-bold mb-4 text-dark">Languages & Essentials</h5>
    
    <!-- row-cols-5 forces 5 columns per row on desktop -->
    <div class="row row-cols-5 g-3 text-center justify-content-center">
        <!-- HTML -->
        <div class="col">
            <div class="tech-icon-card">
                <i class="fa-brands fa-html5 text-danger display-6"></i>
                <span class="d-block mt-2 fw-semibold text-secondary small" style="font-size: 0.75rem;">HTML</span>
            </div>
        </div>
        <!-- CSS -->
        <div class="col">
            <div class="tech-icon-card">
                <i class="fa-brands fa-css3-alt text-primary display-6"></i>
                <span class="d-block mt-2 fw-semibold text-secondary small" style="font-size: 0.75rem;">CSS</span>
            </div>
        </div>
        <!-- JavaScript -->
        <div class="col">
            <div class="tech-icon-card">
                <i class="fa-brands fa-js text-warning display-6"></i>
                <span class="d-block mt-2 fw-semibold text-secondary small" style="font-size: 0.75rem;">JavaScript</span>
            </div>
        </div>
        <!-- PHP -->
        <div class="col">
            <div class="tech-icon-card">
                <i class="fa-brands fa-php display-6" style="color: #777BB4;"></i>
                <span class="d-block mt-2 fw-semibold text-secondary small" style="font-size: 0.75rem;">PHP</span>
            </div>
        </div>
        <!-- Java -->
        <div class="col">
            <div class="tech-icon-card">
                <i class="fa-brands fa-java text-danger display-6"></i>
                <span class="d-block mt-2 fw-semibold text-secondary small" style="font-size: 0.75rem;">Java</span>
            </div>
        </div>
        <!-- SQL / MySQL -->
        <div class="col">
            <div class="tech-icon-card">
                <i class="fa-solid fa-database text-info display-6"></i>
                <span class="d-block mt-2 fw-semibold text-secondary small" style="font-size: 0.75rem;">MySQL</span>
            </div>
        </div>
        <!-- Bootstrap 5 -->
        <div class="col">
            <div class="tech-icon-card">
                <i class="fa-brands fa-bootstrap display-6" style="color: #6f42c1;"></i>
                <span class="d-block mt-2 fw-semibold text-secondary small" style="font-size: 0.75rem;">Bootstrap</span>
            </div>
        </div>
        <!-- Linux -->
        <div class="col">
            <div class="tech-icon-card">
                <i class="fa-brands fa-linux text-dark display-6"></i>
                <span class="d-block mt-2 fw-semibold text-secondary small" style="font-size: 0.75rem;">Linux</span>
            </div>
        </div>
        <!-- Git -->
        <div class="col">
            <div class="tech-icon-card">
                <i class="fa-brands fa-git-alt text-danger display-6"></i>
                <span class="d-block mt-2 fw-semibold text-secondary small" style="font-size: 0.75rem;">Git</span>
            </div>
        </div>
        <!-- Python -->
        <div class="col">
            <div class="tech-icon-card">
                <i class="fa-brands fa-python text-warning display-6"></i>
                <span class="d-block mt-2 fw-semibold text-secondary small" style="font-size: 0.75rem;">Python</span>
            </div>
        </div>
    </div>
</div>

        <!-- Center Vertical Divider -->
        <div class="col-md-2 d-none d-md-flex justify-content-center align-self-stretch">
            <div class="vertical-divider" style="width: 2px; background-color: #ccc; min-height: 100%;"></div>
        </div>

        <!-- Right Column: Development & Backend Concepts -->
        <div class="col-md-5 mt-4 mt-md-0">
            <h5 class="text-center fw-bold mb-4 text-dark">Development & Concepts</h5>
            <div class="d-flex flex-wrap justify-content-center gap-2">
            <span class="badge bg-secondary p-2 px-3 fs-6"><i class="fa-solid fa-sliders me-1"></i> Data Manipulation</span>
            <span class="badge bg-secondary p-2 px-3 fs-6"><i class="fa-solid fa-database me-1"></i> Database Administration</span>
            <span class="badge bg-secondary p-2 px-3 fs-6"><i class="fa-solid fa-folder-open me-1"></i> File Management</span>
            <span class="badge bg-secondary p-2 px-3 fs-6"><i class="fa-solid fa-microchip me-1"></i> Internet of Things</span>
            <span class="badge bg-secondary p-2 px-3 fs-6"><i class="fa-solid fa-cubes me-1"></i> Object-Oriented Programming</span>
            <span class="badge bg-secondary p-2 px-3 fs-6"><i class="fa-solid fa-code me-1"></i> Software Development</span>
            <span class="badge bg-secondary p-2 px-3 fs-6"><i class="fa-solid fa-globe me-1"></i> Web Applications</span>
            </div>
        </div>
        </div>
    </div>
    </section>

    <!-- Certifications Section -->
    <section id="certifications" class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark">Certifications</h2>
                <p class="text-muted">Click on any of my certificate to view full information.</p>
            </div>

            <div class="row g-4 justify-content-center">
                <?php if(!empty($certifications)): ?>
                    <?php foreach($certifications as $cert): ?>
                        <div class="col-md-6 col-lg-4">
                            <!-- Clickable Card Triggering Modal -->
                            <div class="card h-100 border-0 shadow-sm p-3 text-center cert-card cursor-pointer" 
                                data-bs-toggle="modal" 
                                data-bs-target="#certModal<?= $cert['id']; ?>"
                                style="cursor: pointer; transition: transform 0.2s ease, shadow 0.2s ease;">
                                
                                <div class="card-body">
                                <div class="mb-3 text-center d-flex justify-content-center align-items-center" style="height: 130px;">
                                    <img src="<?= base_url('assets/uploads/' . ($cert['badge_img'] ?? 'default-badge.png')); ?>" 
                                        alt="<?= html_escape($cert['title']); ?> Badge" 
                                        class="img-fluid"
                                        style="max-height: 125px; width: auto; object-fit: contain;"
                                        onerror="this.onerror=null; this.src='https://via.placeholder.com/85?text=Badge';">
                                </div>

                                    <div class="mt-2 text-danger small fw-bold">
                                        <i class="bi bi-eye-fill me-1"></i> View Certificate
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for displaying Certificate Image and Details -->
                            <div class="modal fade" id="certModal<?= $cert['id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content shadow border-0">
                                        <div class="modal-header bg-sdca text-white">
                                            <h5 class="modal-title fw-bold"><i class="bi bi-award me-2"></i><?= html_escape($cert['title']); ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center p-4 bg-light">
                                            <!-- Certificate Preview Image -->
                                            <div class="mb-4">
                                                <img src="<?= base_url('assets/uploads/' . $cert['cert_image']); ?>" 
                                                    alt="<?= html_escape($cert['title']); ?>" 
                                                    class="img-fluid rounded border shadow-sm"
                                                    style="max-height: 400px; width: auto;">
                                            </div>

                                            <!-- Details Info -->
                                            <div class="row g-2 text-start bg-white p-3 rounded border">
                                                <div class="col-md-6">
                                                    <strong>Issuing Organization:</strong> <?= html_escape($cert['issuer']); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Date Issued:</strong> <?= date('F d, Y', strtotime($cert['issue_date'])); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-white">
                                            <?php if(!empty($cert['credential_url'])): ?>
                                                <a href="<?= $cert['credential_url']; ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                                                    Verify Credential <i class="bi bi-box-arrow-up-right ms-1"></i>
                                                </a>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">
                        <p>No certifications added yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Hover Animation Style -->
    <style>
        .cert-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
    </style>

    <?php if ($this->session->flashdata('contact_success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <?= $this->session->flashdata('contact_success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Contact Section -->
    <section id="contact" class="py-9 bg-light" style="min-height: 80vh;">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Get In Touch</h2>
                        <p class="text-muted">Have a project in mind or a question? Send a message below.</p>
                    </div>

                    <!-- Form Validation Errors -->
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= validation_errors(); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form Helper Open Tag (Embeds CSRF Protection Automatically) -->
                    <form action="<?php echo site_url('index.php/home/send_message'); ?>" method="POST">                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Message</label>
                            <textarea name="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 border-top border-secondary">
        <div class="container text-center">
            <p class="mb-0 small text-secondary">&copy; <?= date('Y'); ?> Aerhon Louis Magtira. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        // 1. Shift active underline instantly on link click
        navLinks.forEach(link => {
            link.addEventListener('click', function () {
                navLinks.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // 2. Automatically activate 'Contact' tab when reaching bottom of page
        window.addEventListener('scroll', function () {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 50) {
                navLinks.forEach(nav => nav.classList.remove('active'));
                const contactLink = document.querySelector('.navbar-nav .nav-link[href*="contact"]');
                if (contactLink) contactLink.classList.add('active');
            }
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editHeroModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function () {
            var bioInput = document.getElementById('heroBioInput');
            
            // If the textarea is empty, grab the paragraph text directly from the hero section on screen
            if (!bioInput.value.trim()) {
                var heroParagraph = document.querySelector('#about p') || document.querySelector('.hero-section p');
                if (heroParagraph) {
                    bioInput.value = heroParagraph.innerText.trim();
                }
            }
        });
    }
});
</script>

<!-- ADD NEW PROJECT MODAL -->
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?php echo base_url('home/add_project'); ?>" method="POST" enctype="multipart/form-data">
                
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="addProjectModalLabel">
                        <i class="fa-solid fa-plus text-success me-2"></i>Add New Project
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- TITLE -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Project Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. JustiFi App" required>
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief details about the project..." required></textarea>
                    </div>

                    <!-- TECH STACK (Comma Separated) -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tech Stack / Tags</label>
                        <input type="text" name="tags" class="form-control" placeholder="e.g. PHP, MySQL, Bootstrap 5">
                        <div class="form-text">Separate tags with commas.</div>
                    </div>

                    <!-- PROJECT IMAGE -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Project Image / Banner</label>
                        <input type="file" name="project_img" class="form-control" accept="image/*" required>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Project</button>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>