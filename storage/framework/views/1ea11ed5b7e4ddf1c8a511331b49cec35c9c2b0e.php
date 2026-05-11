<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparency | Community e-Portal (Guest)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(url('frontend/style.css')); ?>">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold ms-4" href="#">Community e-Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('about_guest')); ?>">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('e-serbisyo_guest')); ?>">E-Serbisyo</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('transparency_guest')); ?>">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('community_guest')); ?>">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('disasterPreparedness_guest')); ?>">Disaster Preparedness</a></li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="<?php echo e(url('profile_guest')); ?>"><i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <header class="container mb-4 text-center">
        <h1 class="display-5 fw-bold text-navy">Transparency in Barangay Services</h1>
        <p class="lead text-secondary">
            We are committed to transparency and accountability in our services. Explore financial reports, project updates, and community engagement initiatives.
        </p>
        <button class="btn btn-outline-navy btn-lg mt-3" onclick="scrollToSection()">Learn More</button>
    </header>

    <section class="container mb-5" id="transparency-section">

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <h3 class="fw-bold text-navy mb-4 text-center">
                    Transparency Reports
                </h3>

                <div class="row g-4">

                    <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0">

                                <!-- CARD HEADER -->
                                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">

                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-building text-primary"></i>
                                        <small class="text-muted">
                                            <?php echo e(\Carbon\Carbon::parse($report->report_date)->format('M d, Y')); ?>

                                        </small>
                                    </div>

                                    <span class="badge
                                        <?php if($report->category == 'Financial'): ?> bg-success
                                        <?php elseif($report->category == 'Project'): ?> bg-warning text-dark
                                        <?php elseif($report->category == 'Community'): ?> bg-info
                                        <?php else: ?> bg-secondary
                                        <?php endif; ?>
                                    ">
                                        <?php echo e($report->category); ?>

                                    </span>

                                </div>

                                <!-- CARD BODY -->
                                <div class="card-body">

                                    <h6 class="fw-bold text-navy mb-2">
                                        <?php echo e($report->title); ?>

                                    </h6>

                                    <p class="text-secondary small" style="line-height: 1.6;">
                                        <?php echo e($report->description); ?>

                                    </p>

                                </div>

                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <div class="col-12 text-center py-5">
                            <i class="bi bi-folder2-open fs-1 text-muted mb-3"></i>
                            <p class="text-muted fs-5">
                                No transparency reports available at the moment.
                            </p>
                        </div>

                    <?php endif; ?>

                </div>

            </div>
        </div>

    </section>

    <footer class="bg-primary text-white text-center py-3 mt-auto">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

    <script>
        function scrollToSection() {
            document.getElementById('transparency-section').scrollIntoView({ behavior: 'smooth' });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Main Main file\resources\views/transparency_guest.blade.php ENDPATH**/ ?>