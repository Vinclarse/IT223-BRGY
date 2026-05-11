<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Serbisyo | Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(url('frontend/style.css')); ?>">
    <style>
        .rating-stars {
            font-size: 24px;
            color: #ffc107;
            cursor: pointer;
        }
        .rating-stars .star {
            transition: transform 0.2s;
        }
        .rating-stars .star:hover {
            transform: scale(1.2);
        }
        .star.selected {
            color: #ffc107;
        }
        .star.unselected {
            color: #e4e5e9;
        }
        .feedback-modal .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .feedback-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #e9ecef;
        }
        .feedback-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .service-card {
            height: 100%;
            transition: all 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }
        .process-step {
            text-align: center;
            padding: 1.5rem;
        }
    </style>
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
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('resident_dashboard')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('about')); ?>">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('e-serbisyo')); ?>">E-Serbisyo</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('transparency')); ?>">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('community')); ?>">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('disasterPreparedness')); ?>">Disaster Preparedness</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            <?php if(isset($appointmentCount) && $appointmentCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                <?php echo e($appointmentCount); ?>

                            </span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0 notification-dropdown" aria-labelledby="notificationDropdown" style="width: 400px; max-height: 500px; overflow-y: auto;">
                            <!-- Scroll Wrapper -->
                            <div class="notif-scroll notif">
                                <li class="dropdown-header fw-bold text-white p-3" style="background: linear-gradient(135deg, #5664a0ff 0%, #764ba2 100%);">
                                    <i class="bi bi-calendar-check me-2"></i>Appointments
                                    <span class="badge bg-light text-dark ms-2"><?php echo e($appointmentCount ?? 0); ?></span>
                                </li>

                                <?php if(isset($userAppointments) && count($userAppointments) > 0): ?>
                                    <?php $__currentLoopData = $userAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <!-- Remove href or change to modal trigger -->
                                        <a href="#" class="dropdown-item py-3 border-bottom view-appointment-details" 
                                        data-appointment-id="<?php echo e($appointment->appointment_id); ?>"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#appointmentDetailsModal">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div style="flex: 1;">
                                                    <!-- Appointment Status Badge with better colors -->
                                                    <?php
                                                        $badgeClass = 'bg-secondary text-white';
                                                        $statusText = $appointment->status;
                                                        if($appointment->status === 'Confirmed') {
                                                            $badgeClass = 'bg-success text-white';
                                                        } elseif($appointment->status === 'Pending') {
                                                            $badgeClass = 'bg-warning text-dark';
                                                        } elseif($appointment->status === 'Completed') {
                                                            $badgeClass = 'bg-info text-white';
                                                        } elseif($appointment->status === 'Cancelled') {
                                                            $badgeClass = 'bg-danger text-white';
                                                        }
                                                    ?>
                                                    <span class="badge <?php echo e($badgeClass); ?> mb-2 px-2 py-1" style="font-size: 0.75rem;">
                                                        <?php echo e($statusText); ?>

                                                    </span>
                                                    
                                                    <h6 class="mb-1 text-dark fw-bold" style="font-size: 0.95rem;"><?php echo e($appointment->purpose); ?></h6>
                                                    
                                                    <?php if($appointment->description): ?>
                                                    <p class="mb-2 text-secondary" style="font-size: 0.85rem; line-height: 1.4;">
                                                        <i class="bi bi-card-text me-1"></i>
                                                        <?php echo e(Str::limit($appointment->description, 60)); ?>

                                                    </p>
                                                    <?php endif; ?>
                                                    
                                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                                        <span class="text-secondary small d-flex align-items-center">
                                                            <i class="bi bi-calendar-event me-1"></i>
                                                            <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?>

                                                        </span>
                                                        <span class="text-secondary small d-flex align-items-center">
                                                            <i class="bi bi-clock me-1"></i>
                                                            <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A')); ?>

                                                        </span>
                                                    </div>
                                                    
                                                    <?php if($appointment->official_full_name): ?>
                                                    <p class="mb-0 text-primary small d-flex align-items-center">
                                                        <i class="bi bi-person-badge me-1"></i>
                                                        <?php echo e($appointment->official_full_name); ?>

                                                    </p>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-muted small ms-2 text-end" style="min-width: 70px;">
                                                    <?php
                                                        $now = \Carbon\Carbon::now();
                                                        $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_date);
                                                        
                                                        if($now->gt($appointmentDate)) {
                                                            echo '<span class="badge bg-light text-dark">Past</span>';
                                                        } else {
                                                            $diffInDays = $now->diffInDays($appointmentDate);
                                                            if($diffInDays > 0) {
                                                                echo '<span class="badge bg-light text-dark">' . $diffInDays . ' day' . ($diffInDays > 1 ? 's' : '') . '</span>';
                                                            } else {
                                                                echo '<span class="badge bg-light text-dark">Today</span>';
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <li>
                                        <div class="dropdown-item py-4 text-center text-muted">
                                            <i class="bi bi-calendar-x fs-1 mb-3" style="color: #dee2e6;"></i>
                                            <h6 class="mb-2">No appointments scheduled</h6>
                                            <p class="mb-0 small">You don't have any appointments at the moment.</p>
                                            <a href="<?php echo e(url('e-serbisyo')); ?>" class="btn btn-sm btn-outline-primary mt-2">Schedule One</a>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </div>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="<?php echo e(url('profile')); ?>"><i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
    <div class="container mb-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="container mb-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>

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
                <div class="card border-primary service-card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title text-navy mb-4"><i class="bi bi-file-earmark-text"></i> Online Document Requests</h5>
                        <p class="card-text text-secondary mb-4">
                            Request barangay clearance, certificates, and other official documents online.
                        </p>
                        <a href="<?php echo e(url('requestDocument')); ?>" class="btn btn-outline-navy w-100">Request Document</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-primary service-card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title text-navy mb-4"><i class="bi bi-megaphone"></i> File a Complaint</h5>
                        <p class="card-text text-secondary mb-4">
                            Report issues, concerns, or violations within the barangay community.
                        </p>
                        <a href="<?php echo e(url('requestDocument#Complaint')); ?>" class="btn btn-outline-navy w-100">Submit Complaint</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-primary service-card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title text-navy mb-4"><i class="bi bi-chat-dots"></i> Submit Feedback</h5>
                        <p class="card-text text-secondary mb-4">
                            Share your experience and suggestions to help us improve our services.
                        </p>
                        <button type="button" class="btn btn-outline-navy w-100" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                            Submit Feedback
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Feedback Section -->
    <section class="container mb-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold text-navy">Recent Community Feedback</h2>
                <p class="text-secondary">See what other residents are saying about our services</p>
            </div>
        </div>
        
        <div class="row g-4" id="feedbackContainer">
            <!-- Feedback will be loaded here via JavaScript -->
        </div>
        
        <div class="text-center mt-4">
            <button type="button" class="btn btn-link text-decoration-none" id="loadMoreFeedback">
                <i class="bi bi-arrow-down-circle me-1"></i> Load More Feedback
            </button>
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

    <!-- Feedback Modal -->
    <div class="modal fade feedback-modal" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="feedbackModalLabel">
                        <i class="bi bi-chat-square-text me-2"></i>Share Your Feedback
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('feedback.store')); ?>" method="POST" id="feedbackForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-bold">How would you rate our services?</label>
                            <div class="rating-stars mb-2" id="ratingStars">
                                <span class="star" data-value="1">☆</span>
                                <span class="star" data-value="2">☆</span>
                                <span class="star" data-value="3">☆</span>
                                <span class="star" data-value="4">☆</span>
                                <span class="star" data-value="5">☆</span>
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" required>
                            <small class="text-muted">Click on the stars to rate</small>
                            <div class="invalid-feedback" id="ratingError">Please select a rating.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label fw-bold">Your Feedback</label>
                            <textarea class="form-control" 
                                      id="message" 
                                      name="message" 
                                      rows="4" 
                                      placeholder="Share your experience, suggestions, or concerns..."
                                      maxlength="1000"
                                      required></textarea>
                            <div class="form-text">
                                <span id="charCount">0</span> / 1000 characters
                            </div>
                            <div class="invalid-feedback">Please enter your feedback.</div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Your feedback helps us improve our services for the entire community.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Submit Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Appointment Details Modal -->
    <div class="modal fade" id="appointmentDetailsModal" tabindex="-1" aria-labelledby="appointmentDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentDetailsModalLabel">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="appointmentDetailsContent">
                    <!-- Content will be loaded via JavaScript -->
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading appointment details...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3 mt-auto w-100">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Rating system
            const stars = document.querySelectorAll('#ratingStars .star');
            const ratingInput = document.getElementById('ratingInput');
            const ratingError = document.getElementById('ratingError');
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = value;
                    
                    // Update star display
                    stars.forEach(s => {
                        const sValue = parseInt(s.getAttribute('data-value'));
                        if (sValue <= value) {
                            s.textContent = '★';
                            s.classList.add('selected');
                            s.classList.remove('unselected');
                        } else {
                            s.textContent = '☆';
                            s.classList.remove('selected');
                            s.classList.add('unselected');
                        }
                    });
                    
                    ratingError.style.display = 'none';
                });
                
                star.addEventListener('mouseover', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    stars.forEach(s => {
                        const sValue = parseInt(s.getAttribute('data-value'));
                        if (sValue <= value) {
                            s.style.color = '#ffc107';
                        } else {
                            s.style.color = '#e4e5e9';
                        }
                    });
                });
                
                star.addEventListener('mouseout', function() {
                    const currentRating = ratingInput.value ? parseInt(ratingInput.value) : 0;
                    stars.forEach(s => {
                        const sValue = parseInt(s.getAttribute('data-value'));
                        if (sValue <= currentRating) {
                            s.style.color = '#ffc107';
                        } else {
                            s.style.color = '#e4e5e9';
                        }
                    });
                });
            });

            // Character counter for feedback message
            const messageTextarea = document.getElementById('message');
            const charCount = document.getElementById('charCount');
            
            messageTextarea.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length;
                
                if (length > 1000) {
                    this.value = this.value.substring(0, 1000);
                    charCount.textContent = 1000;
                }
            });

            // Form validation
            const feedbackForm = document.getElementById('feedbackForm');
            
            feedbackForm.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Validate rating
                if (!ratingInput.value) {
                    ratingError.style.display = 'block';
                    isValid = false;
                }
                
                // Validate message
                if (!messageTextarea.value.trim()) {
                    messageTextarea.classList.add('is-invalid');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Reset form when modal is closed
            const feedbackModal = document.getElementById('feedbackModal');
            feedbackModal.addEventListener('hidden.bs.modal', function() {
                feedbackForm.reset();
                ratingInput.value = '';
                stars.forEach(star => {
                    star.textContent = '☆';
                    star.classList.remove('selected', 'unselected');
                    star.style.color = '#e4e5e9';
                });
                messageTextarea.classList.remove('is-invalid');
                ratingError.style.display = 'none';
                charCount.textContent = '0';
            });

            // Load feedback via AJAX
            let currentPage = 1;
            const feedbackContainer = document.getElementById('feedbackContainer');
            const loadMoreBtn = document.getElementById('loadMoreFeedback');
            
            function loadFeedback(page = 1) {
                fetch(`/api/feedback?page=${page}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.feedback.length > 0) {
                            data.feedback.forEach(feedback => {
                                const feedbackCard = createFeedbackCard(feedback);
                                feedbackContainer.appendChild(feedbackCard);
                            });
                            
                            if (data.hasMore) {
                                loadMoreBtn.style.display = 'block';
                            } else {
                                loadMoreBtn.style.display = 'none';
                            }
                        } else {
                            feedbackContainer.innerHTML = `
                                <div class="col-12">
                                    <div class="alert alert-info text-center">
                                        <i class="bi bi-info-circle me-2"></i>
                                        No feedback yet. Be the first to share your thoughts!
                                    </div>
                                </div>
                            `;
                            loadMoreBtn.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading feedback:', error);
                    });
            }
            
            function createFeedbackCard(feedback) {
                const card = document.createElement('div');
                card.className = 'col-md-6';
                card.innerHTML = `
                    <div class="card feedback-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar me-3">
                                    ${feedback.resident.first_name.charAt(0)}${feedback.resident.last_name.charAt(0)}
                                </div>
                                <div>
                                    <h6 class="mb-0">${feedback.resident.first_name} ${feedback.resident.last_name}</h6>
                                    <small class="text-muted">${feedback.formatted_date}</small>
                                </div>
                                <div class="ms-auto">
                                    ${'★'.repeat(feedback.rating)}${'☆'.repeat(5 - feedback.rating)}
                                </div>
                            </div>
                            <p class="card-text">${feedback.message}</p>
                        </div>
                    </div>
                `;
                return card;
            }
            
            loadMoreBtn.addEventListener('click', function() {
                currentPage++;
                loadFeedback(currentPage);
            });
            
            // Load initial feedback
            loadFeedback();
        });

        // Handle appointment details modal
    document.addEventListener('DOMContentLoaded', function() {
        // When a user clicks on an appointment in the dropdown
        document.querySelectorAll('.view-appointment-details').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const appointmentId = this.getAttribute('data-appointment-id');
                loadAppointmentDetails(appointmentId);
            });
        });
        
        // Reset modal content when hidden
        const appointmentModal = document.getElementById('appointmentDetailsModal');
        appointmentModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('appointmentDetailsContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading appointment details...</p>
                </div>
            `;
        });
    });

    function loadAppointmentDetails(appointmentId) {
        // You need to create an API endpoint to get appointment details
        // For now, let's create a simple version with the data we have
        fetch(`/api/appointments/${appointmentId}/details`)
            .then(response => response.json())
            .then(data => {
                displayAppointmentDetails(data);
            })
            .catch(error => {
                console.error('Error loading appointment details:', error);
                document.getElementById('appointmentDetailsContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> 
                        Error loading appointment details. Please try again.
                    </div>
                `;
            });
    }

    function displayAppointmentDetails(appointment) {
        // Format the appointment date
        const appointmentDate = new Date(appointment.appointment_date);
        const formattedDate = appointmentDate.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        const formattedTime = appointmentDate.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        // Determine badge class based on status
        let badgeClass = 'bg-secondary';
        if (appointment.status === 'Confirmed') badgeClass = 'bg-success';
        else if (appointment.status === 'Pending') badgeClass = 'bg-warning text-dark';
        else if (appointment.status === 'Completed') badgeClass = 'bg-info';
        else if (appointment.status === 'Cancelled') badgeClass = 'bg-danger';
        
        // Create HTML for appointment details
        const html = `
            <div class="appointment-details">
                <!-- Status Badge -->
                <div class="text-end mb-3">
                    <span class="badge ${badgeClass} px-3 py-2 fs-6">
                        ${appointment.status}
                    </span>
                </div>
                
                <!-- Purpose -->
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Purpose</h6>
                    <div class="p-3 bg-light rounded">
                        <h5 class="mb-0">${appointment.purpose}</h5>
                    </div>
                </div>
                
                <!-- Description -->
                ${appointment.description ? `
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Description</h6>
                    <div class="p-3 bg-light rounded">
                        <p class="mb-0">${appointment.description}</p>
                    </div>
                </div>
                ` : ''}
                
                <div class="row">
                    <!-- Date & Time -->
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted mb-2">Date & Time</h6>
                        <div class="p-3 bg-light rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-calendar-check me-2 text-primary"></i>
                                <div>
                                    <div class="fw-bold">${formattedDate}</div>
                                    <div class="text-muted small">${formattedTime}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Official -->
                    ${appointment.official_full_name ? `
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted mb-2">Assigned Official</h6>
                        <div class="p-3 bg-light rounded">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-badge me-2 text-primary fs-4"></i>
                                <div>
                                    <div class="fw-bold">${appointment.official_full_name}</div>
                                    <div class="text-muted small">Barangay Official</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                </div>
                
                <!-- Timeline -->
                <div class="mt-4">
                    <h6 class="text-muted mb-3">Timeline</h6>
                    <div class="ps-3">
                        <div class="border-start ps-3 pb-3 position-relative">
                            <div class="position-absolute top-0 start-0 translate-middle">
                                <div class="bg-primary rounded-circle" style="width: 12px; height: 12px;"></div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-plus me-2 text-success"></i>
                                    <div>
                                        <div class="fw-bold">Created</div>
                                        <div class="text-muted small">${new Date(appointment.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute bottom-0 start-0 translate-middle">
                                <div class="bg-info rounded-circle" style="width: 12px; height: 12px;"></div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-arrow-clockwise me-2 text-info"></i>
                                    <div>
                                        <div class="fw-bold">Last Updated</div>
                                        <div class="text-muted small">${new Date(appointment.updated_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('appointmentDetailsContent').innerHTML = html;
    }

    // For now, let's create a simple mock API response
    // In your web.php, add this route:
    // Route::get('/api/appointments/{id}/details', [ResidentDashboardController::class, 'getAppointmentDetails']);
    </script>
</body>
</html><?php /**PATH C:\Users\Gaan's Computer\Documents\Main Main file\resources\views/e-serbisyo.blade.php ENDPATH**/ ?>