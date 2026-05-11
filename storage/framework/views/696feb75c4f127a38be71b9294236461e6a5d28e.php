<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Serbisyo | Community e-Portal (Guest)</title>
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
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('e-serbisyo_guest')); ?>">E-Serbisyo</a></li>
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
   <header class="container mb-4">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-lg-8 text-center mx-auto">
                <h1 class="display-5 fw-bold text-navy"><i class="bi bi-globe2"></i> E-Serbisyo</h1>
                <p class="lead text-secondary">
                    Your one-stop portal for digital barangay services. Submit requests, apply for certificates, schedule appointments, and get assistance—all online, anytime.
                </p>
                <a href="#services" class="btn btn-outline-navy btn-lg mt-2">Explore Services</a>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="container mb-5">
        <div class="row text-center mb-4">
            <div class="col">
                <h2 class="fw-bold text-navy">Why Use E-Serbisyo?</h2>
                <p class="text-secondary">Experience the convenience of digital governance with these benefits:</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-clock-history"></i></div>
                    <h5 class="fw-bold">24/7 Accessibility</h5>
                    <p class="text-secondary">Request documents and services anytime, anywhere—no need to visit the barangay hall.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-shield-check"></i></div>
                    <h5 class="fw-bold">Secure & Reliable</h5>
                    <p class="text-secondary">Your data is protected with industry-standard security and privacy measures.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-lightning-charge"></i></div>
                    <h5 class="fw-bold">Fast Processing</h5>
                    <p class="text-secondary">Get updates and notifications on your requests for a hassle-free experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="container mb-5" id="services">
        <div class="row text-center mb-4">
            <div class="col">
                <h2 class="fw-bold text-navy">Our Services</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title text-navy text-center mb-4"><i class="bi bi-file-earmark-text"></i> Online Document Requests</h5>
                        <a href="<?php echo e(url('requestDocument')); ?>" class="btn btn-outline-navy btn-md d-flex justify-content-center">Request Document</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title text-navy text-center mb-4"><i class="bi bi-calendar-check"></i> E-Services & Applications</h5>
                        <a href="<?php echo e(url('requestDocument#Complaint')); ?>" class="btn btn-outline-navy btn-md d-flex justify-content-center">File a Complaint</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title text-navy text-center mb-4"><i class="bi bi-chat-dots"></i> Write a Feedback</h5>
                        <a href="<?php echo e(url('requestDocument#Complaint')); ?>" class="btn btn-outline-navy btn-md d-flex justify-content-center"> Feedback</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="container mb-5">
        <div class="row text-center mb-4">
            <div class="col">
                <h2 class="fw-bold text-navy">How It Works</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-3 process-step">
                <div class="feature-icon mb-2"><i class="bi bi-pencil-square"></i></div>
                <h6 class="fw-bold">1. Fill Out Online Form</h6>
                <p class="text-secondary small">Choose your service and complete the required details.</p>
            </div>
            <div class="col-md-3 process-step">
                <div class="feature-icon mb-2"><i class="bi bi-upload"></i></div>
                <h6 class="fw-bold">2. Submit & Upload</h6>
                <p class="text-secondary small">Upload necessary documents and submit your request.</p>
            </div>
            <div class="col-md-3 process-step">
                <div class="feature-icon mb-2"><i class="bi bi-envelope-check"></i></div>
                <h6 class="fw-bold">3. Get Notified</h6>
                <p class="text-secondary small">Receive updates and instructions.</p>
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
</html><?php /**PATH C:\Users\Gaan's Computer\Documents\Main Main file\resources\views/e-serbisyo_guest.blade.php ENDPATH**/ ?>