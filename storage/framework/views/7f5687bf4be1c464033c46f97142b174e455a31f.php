<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Community e-Portal (Guest)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(url('frontend/style.css')); ?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold ms-4" href="#">Community e-Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                   <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('about_guest')); ?>">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('e-serbisyo_guest')); ?>">E-Serbisyo</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('transparency_guest')); ?>">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('community_guest')); ?>">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('disasterPreparedness_guest')); ?>">Disaster Preparedness</a></li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="<?php echo e(url('profile_guest')); ?>"><i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i></a>
                </div>       
            </div>
        </div>
    </nav>

    <section class="container mb-5">
        <div class="row align-items-center about-hero p-4 mb-4">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold">About Barangay Online Services</h1>
                <p class="lead">
                    Barangay Del Pilar Online Services and Public Information System is dedicated to making local governance more accessible, transparent, and responsive. Our platform empowers residents to connect with barangay officials, request documents, access vital information, and participate in community programsall from the comfort of their homes.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <img src="<?php echo e(url('frontend/logo.png')); ?>" alt="Barangay Logo" width="200px" height="200px" class="img-fluid mb-3">
                <div class="bg-white rounded p-2 shadow-sm mt-2 text-primary">
                    <i class="bi bi-people-fill"></i>
                    <span class="fw-semibold text-navy">Serving our community since 2025</span>
                </div>
            </div>
        </div>

        <div class="about-section-title">Our Mission</div>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card about-card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="mb-0 fs-5">
                            To deliver fast, reliable, and transparent barangay services through digital innovation, fostering a more connected and empowered community.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-section-title">Core Values</div>
        <div class="row about-values g-4 mb-4">
            <div class="col-md-4">
                <div class="card about-card h-100 border-primary">
                    <div class="card-body text-center">
                        <i class="bi bi-lightbulb"></i>
                        <h5 class="card-title mt-2">Innovation</h5>
                        <p class="card-text">We embrace technology to improve public service and make processes easier for everyone.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card about-card h-100 border-primary">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check"></i>
                        <h5 class="card-title mt-2">Transparency</h5>
                        <p class="card-text">We ensure that information and services are open, clear, and accessible to all residents.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card about-card h-100 border-primary">
                    <div class="card-body text-center">
                        <i class="bi bi-people"></i>
                        <h5 class="card-title mt-2">Community</h5>
                        <p class="card-text">We foster participation, inclusivity, and collaboration among all barangay members.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-section-title">Meet the Team</div>
        <div class="row g-4 mb-4">

        <?php $__empty_1 = true; $__currentLoopData = $officials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $official): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <?php
                $icon = "https://img.icons8.com/ios-filled/80/4a90e2/user-male-circle.png";

                if (Str::contains($official->position, 'Secretary')) {
                    $icon = "https://img.icons8.com/ios-filled/80/4a90e2/user-female-circle.png";
                }

                if (Str::contains($official->position, 'Council')) {
                    $icon = "https://img.icons8.com/ios-filled/80/4a90e2/user-group-man-man.png";
                }
            ?>

            <div class="col-md-4">
                <div class="card about-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <img src="<?php echo e($icon); ?>" class="mb-2" width="60">

                        <h6 class="fw-bold mb-0">
                            <?php echo e($official->full_name); ?>

                        </h6>

                        <small class="text-muted">
                            <?php echo e($official->position); ?>

                        </small>

                        <p class="mt-2 mb-0" style="font-size:0.95rem;">
                            Serving from <?php echo e(\Carbon\Carbon::parse($official->term_start)->year); ?> 
                            to <?php echo e(\Carbon\Carbon::parse($official->term_end)->year); ?>

                        </p>
                    </div>
                </div>
            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center">No officials available.</p>
        <?php endif; ?>

        </div>


        <div class="about-section-title" id="Contact">Contact Us</div>
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card about-card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="mb-1"><i class="bi bi-envelope me-2"></i> Email: <a href="mailto:info@barangayservices.ph" class="link-primary">info@barangayservices.ph</a></p>
                        <p class="mb-1"><i class="bi bi-telephone me-2"></i> Phone: (02) 1234-5678</p>
                        <p class="mb-0"><i class="bi bi-geo-alt me-2"></i> Address: Barangay Hall, Main Street, City, Philippines</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-primary text-white text-center py-3 mt-auto w-100 position-relative bottom-0 start-0">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Main Main file\resources\views/about_guest.blade.php ENDPATH**/ ?>