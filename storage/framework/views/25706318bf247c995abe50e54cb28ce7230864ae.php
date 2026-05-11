<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Community e-Portal (Guest)</title>
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
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('transparency_guest')); ?>">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('community_guest')); ?>">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('disasterPreparedness_guest')); ?>">Disaster Preparedness</a></li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="#"><i class="bi bi-person-circle fs-2 person text-white"></i></a>
                </div>
            </div> 
        </div>
    </nav>

    <header class="container mb-4 text-center">
        <h1 class="display-5 fw-bold text-navy">Who's Logging In?</h1>
            <p class="lead text-secondary">
                Choose your role to continue
            </p>

            <?php if(session('error')): ?>
                <div class="alert alert-danger text-center">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
   

            <div class="container mb-5">
                <div class="row">
                    <div class="col-md-4">
                        <a href="<?php echo e(url('login?role=Resident')); ?>" style="text-decoration: none; color: inherit;">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="https://tse2.mm.bing.net/th/id/OIP.4Ed55vY2dA1mQYqMOWAKOAHaHa?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3" alt="User Icon" class="mb-3" width="80" height="80">
                                    <h5 class="card-title">Resident</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo e(url('login?role=Official')); ?>" style="text-decoration: none; color: inherit;">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="https://tse1.mm.bing.net/th/id/OIP.imMJXeQUARLlzSExivLalwHaHa?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3" alt="User Icon" class="mb-3" width="80" height="80">
                                    <h5 class="card-title">Barangay Official</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo e(url('login?role=Admin')); ?>" style="text-decoration: none; color: inherit;">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="https://tse1.mm.bing.net/th/id/OIP.8u8kAJbwBdruAi1jjOnlpwHaHa?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3" alt="User Icon" class="mb-3" width="80" height="80">
                                    <h5 class="card-title">Admin</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
    <p class="lead text-secondary">
                Don't have an account? <a href="<?php echo e(url('signup')); ?>" class="link-primary">Sign Up</a>
            </p>
    
    </header>

    <footer class="bg-primary text-white text-center py-3 mt-auto">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Main Main file\resources\views/profile_guest.blade.php ENDPATH**/ ?>