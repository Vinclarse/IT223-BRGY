<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
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
                    <li class="nav-item"><a class="nav-link" href="resident_dashboard.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="About.html">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="E-Serbisyo.html">E-Serbisyo</a></li>
                    <li class="nav-item"><a class="nav-link" href="Transparency.html">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="Community.html">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="DisasterPreparedness.html">Disaster Preparedness</a></li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="Profile.html"><i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i></a>
                </div>
            </div>
        </div>
    </nav>
    
    
    <header class="container mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="display-5 fw-bold text-navy">E-Services & Applications</h1>
                <p class="lead text-secondary">
                    Access a variety of online services designed to make your interactions with the barangay easier and more efficient. From document requests to appointment scheduling, we've got you covered.
                </p>
        </div>
    </header>

    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title" id="Appointment">Appointment Scheduling</h5>
                        <p class="card-text">Book an appointment with a barangay official for document processing or inquiries.</p>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appointmentName" class="form-label fw-bold">Full Name</label>
                                        <input type="text" class="form-control" id="appointmentName" placeholder="Full Name" required>            
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-bold">Address</label>
                                        <input type="text" class="form-control" id="address" placeholder="Address" required>            
                                    </div>
                                    <div class="mb-3">
                                        <label for="contactNumber" class="form-label fw-bold">Contact Number</label>
                                        <input type="text" class="form-control" id="contactNumber" placeholder="Contact Number" required>            
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold">Email Address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Email" required>            
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="preferredDate" class="form-label fw-bold">Preferred Date & Time</label>
                                        <input type="datetime-local" class="form-control" id="preferredDate" required>            
                                    </div>
                                    <div class="mb-3">
                                        <label for="purpose" class="form-label fw-bold">Purpose of Appointment</label>
                                        <textarea class="form-control" id="purpose" rows="6" placeholder="Purpose of Appointment" required></textarea>
                                    </div>
                                        <button type="submit" class="btn btn-outline-navy">Submit Request</button>       
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title" id="Assistance">Request for Assistance</h5>
                        <p class="card-text">Submit a request for community aid or barangay support services.</p>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="assistanceName" class="form-label fw-bold">Full Name</label>
                                        <input type="text" class="form-control" id="assistanceName" placeholder="Full Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-bold">Address</label>
                                        <input type="text" class="form-control" id="address" placeholder="Address" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="contactNumber" class="form-label fw-bold">Contact Number</label>
                                        <input type="text" class="form-control" id="contactNumber" placeholder="Contact Number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold">Email Address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="assistanceType" class="form-label fw-bold">Type of Assistance</label>
                                        <select class="form-select" id="assistanceType" required>
                                            <option value="" disabled selected>Select Assistance Type</option>
                                            <option value="financial">Financial Assistance</option>
                                            <option value="medical">Medical Assistance</option>
                                            <option value="livelihood">Livelihood Support</option>
                                            <option value="LegalAid">Legal Aid / Documentation Help</option>
                                            <option value="BarangayClearance">Barangay Clearance Concern</option>
                                            <option value="PO">Peace and Order Concern</option>
                                            <option value="infrastructure">Infrastructure / Maintenance Request</option>
                                            <option value="educational">Educational Assistance</option>
                                            <option value="elderly">Senior Citizen / PWD Assistance</option>
                                            <option value="others">Others (Please Specify)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="details" class="form-label fw-bold">Details of Request</label>
                                        <textarea class="form-control" id="details" rows="3" placeholder="Details of Request" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="additionalInfo" class="form-label fw-bold">Upload Supporting Documents (Optional)</label>
                                        <input type="file" class="form-control" id="additionalInfo">
                                    </div>
                                        <button type="submit" class="btn btn-outline-navy">Submit Assistance Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-md">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title" id="Feedback">Community Feedback</h5>
                        <p class="card-text">Share your feedback and suggestions to help us improve our services. Your input is valuable in shaping the future of our barangay.</p>
                           <form class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="feedbackName" class="form-label fw-bold">Full Name (Optional)</label>
                                        <input type="text" class="form-control" id="feedbackName" placeholder="Full Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="feedbackEmail" class="form-label fw-bold">Email Address (Optional)</label>
                                        <input type="email" class="form-control" id="feedbackEmail" placeholder="Email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="feedbackAddress" class="form-label fw-bold">Address (Optional)</label>
                                        <input type="text" class="form-control" id="feedbackEmail" placeholder="Adress">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="feedbackMessage" class="form-label fw-bold">Your Feedback</label>
                                        <textarea class="form-control" id="feedbackMessage" rows="6" placeholder="Your Feedback" required></textarea>
                                    </div>
                                    <a href="#" class="btn btn-outline-navy">Give Feedback</a>
                                </div>
                        </form>
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

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>