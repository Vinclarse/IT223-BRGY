<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Preparedness | Community e-Portal (Guest)</title>
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
                    <li class="nav-item"><a class="nav-link active" href="<?php echo e(url('disasterPreparedness_guest')); ?>">Disaster Preparedness</a></li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="<?php echo e(url('profile_guest')); ?>"><i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <header class="container mb-4 text-center">
        <h1 class="display-5 fw-bold text-navy">Disaster Preparedness</h1>
        <p class="lead text-secondary">
            Stay informed and prepared for emergencies. Learn about disaster response plans, evacuation routes, and safety tips to protect your family and community.
        </p>
        <a href="#resources" class="btn btn-outline-navy btn-lg mt-3">Explore Resources</a>
    </header>

    <!-- Disaster Preparedness Resources Section -->
    <section class="container mb-5" id="resources">
        <div class="row text-center mb-4">
            <div class="col">
                <h3 class="fw-bold text-navy display-6">Preparedness Resources</h3>
                <p class="text-secondary">Access essential resources to stay safe and prepared during disasters.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title text-navy"><i class="bi bi-map"></i> Evacuation Maps</h5>
                        <p class="card-text text-secondary">Find the nearest evacuation centers and safe zones in your area.</p>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mapsModal">View Maps</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title text-navy"><i class="bi bi-telephone"></i> Emergency Hotlines</h5>
                        <p class="card-text text-secondary">Save important contact numbers for quick assistance during emergencies.</p>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#hotlinesModal">View Hotlines</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Safety Tips Section -->
    <section class="container mb-5">
        <div class="row text-center mb-4">
            <div class="col">
                <h3 class="fw-bold text-navy">Safety Tips</h3>
                <p class="text-secondary">Follow these tips to stay safe during disasters and emergencies.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-house-door"></i></div>
                    <h5 class="fw-bold">Prepare Your Home</h5>
                    <p class="text-secondary">Secure loose items, stock emergency supplies, and create a family emergency plan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-people"></i></div>
                    <h5 class="fw-bold">Stay Informed</h5>
                    <p class="text-secondary">Monitor weather updates and announcements from local authorities.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-broadcast"></i></div>
                    <h5 class="fw-bold">Follow Instructions</h5>
                    <p class="text-secondary">Evacuate when advised and cooperate with disaster response teams.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-primary text-white text-center py-3 mt-auto">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Hotlines Modal -->
    <div class="modal fade" id="hotlinesModal" tabindex="-1" aria-labelledby="hotlinesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-navy fw-bold" id="hotlinesModalLabel">Emergency Hotlines & Resources</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary">Keep these numbers handy. Call the appropriate service during emergencies and follow instructions from responders.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-navy">Emergency Services</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Police:</strong> 911 / (02) 1234-5678</li>
                                    <li><strong>Fire Department:</strong> 911 / (02) 2345-6789</li>
                                    <li><strong>Ambulance:</strong> 911 / (02) 3456-7890</li>
                                    <li><strong>Barangay Office:</strong> (02) 4567-8901</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-navy">Health & Support</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Municipal Health:</strong> (02) 5678-9012</li>
                                    <li><strong>Disaster Hotline:</strong> 1-800-000-000</li>
                                    <li><strong>Red Cross:</strong> (02) 6789-0123</li>
                                </ul>
                            </div>
                        </div>

                        <hr>
                        <h6 class="fw-bold text-navy">Quick Guidance</h6>
                        <ol>
                            <li>Stay calm and account for household members.</li>
                            <li>Move to the nearest evacuation center if advised.</li>
                            <li>Do not use open flames in areas with gas leaks.</li>
                            <li>Follow official updates via radio, social media, or barangay announcements.</li>
                        </ol>

                        <hr>
                        <h6 class="fw-bold text-navy">Evacuation Centers</h6>
                        <p class="text-secondary">Barangay Covered Court — Main Street; Elementary School Gym — North Road; Community Hall — Barangay Center.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Evacuation Maps Modal -->
        <div class="modal fade" id="mapsModal" tabindex="-1" aria-labelledby="mapsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-navy fw-bold" id="mapsModalLabel">Evacuation Maps</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary">Below are the barangay evacuation maps showing safe zones and evacuation center locations. Use the download links to save a copy for offline use.</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="https://tse4.mm.bing.net/th/id/OIP.jlycdmkRt3D2eHSdY7rMdgHaFS?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3" class="card-img-top" alt="Evacuation Map Zone A">
                                    <span class="badge bg-secondary" style="font-size: 10px;">
                                    Last Updated: 2023-08-01 | Uploaded by: Admin Jose Ramirez
                                    </span>
                                    <div class="card-body">
                                        <h6 class="card-title">Evacuation Map for Earthquake</h6>
                                        <p class="card-text text-secondary small">Shows nearest evacuation centers and designated routes for Earthquake</p>                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="https://th.bing.com/th/id/R.3bc0e5daf31d64268d3eda9fabc80a4d?rik=RVUFpqf7wLHXIQ&riu=http%3a%2f%2flgustamonica.gov.ph%2fwp-content%2fuploads%2f2022%2f11%2fLIBERTAD-1-1024x724.jpg&ehk=7D2q5t%2b%2fFlsNkD%2bNNdlfkSxq8n8pxLuecBtmNnNUMsI%3d&risl=&pid=ImgRaw&r=0" class="card-img-top" alt="Evacuation Map Zone B">
                                    <span class="badge bg-secondary" style="font-size: 10px;">
                                        Last Updated: 2023-07-15 | Uploaded by: Sec. Maria Santos
                                    </span>
                                    <div class="card-body">
                                        <h6 class="card-title">Evacuation Map for Flood</h6>
                                        <p class="card-text text-secondary small">Shows nearest evacuation centers and designated routes for Flood.</p>                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-secondary small"><strong>Tip:</strong> Save these maps to your phone or print them and keep them with your emergency kit.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Disaster Response Plans Modal -->
        <div class="modal fade" id="plansModal" tabindex="-1" aria-labelledby="plansModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-navy fw-bold" id="plansModalLabel">Disaster Response Plans</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary">The barangay has prepared the following response plans. Download the PDF copies for offline reference and share them with your household.</p>
                        <div class="list-group mb-3">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">Earthquake Response Plan</h6>
                                    <small class="text-secondary">Updated: 2024-02-10</small>
                                </div>
                                <p class="mb-1 text-secondary small">Guidance for immediate actions during and after an earthquake, including evacuation, first aid, and reporting.</p>
                                <div class="mt-1">
                                    <a href="#" class="btn btn-sm btn-outline-navy me-2" download>Download PDF</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Online</a>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold mt-3">Flood Response Plan</h6>
                                    <small class="text-secondary">Updated: 2023-11-05</small>
                                </div>
                                <p class="mb-1 text-secondary small">Procedures for early warning, safe evacuation routes, and temporary shelter operations during floods.</p>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-sm btn-outline-navy me-2" download>Download PDF</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Online</a>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold mt-3">Fire & Chemical Incident Plan</h6>
                                    <small class="text-secondary">Updated: 2023-06-20</small>
                                </div>
                                <p class="mb-1 text-secondary small">Safety procedures for fire response, evacuation, and coordination with municipal services.</p>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-sm btn-outline-navy me-2" download>Download PDF</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Online</a>
                                </div>
                            </a>
                        </div>
                        <hr>
                        <h6 class="fw-bold text-navy">How to use these plans</h6>
                        <ol>
                            <li class="text-secondary">Download the relevant plan and read it with your family.</li>
                            <li class="text-secondary">Prepare a household kit as described in the checklists.</li>
                            <li class="text-secondary">Familiarize yourselves with the nearest evacuation center and routes on the evacuation maps.</li>
                            <li class="text-secondary">Register vulnerable household members with the barangay health officer.</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
</body>
</html><?php /**PATH C:\Main Main file\resources\views/disasterPreparedness_guest.blade.php ENDPATH**/ ?>