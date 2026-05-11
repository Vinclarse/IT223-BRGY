<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Reports & Project Updates | Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

    <header class="container mb-4 text-center">
        <h1 class="display-5 fw-bold text-navy">Financial Reports & Project Updates</h1>
        <p class="lead text-secondary">
            Stay informed about our barangay's financial health and ongoing projects. Access detailed reports and updates to see how we are working towards a better community.
        </p>
        <a href="#transparency-section" class="btn btn-outline-navy btn-lg mt-3">Explore More</a>
    </header>

    <section id="transparency-section" class="container mb-4">
        <h2 class="fw-bold text-navy text-center">Transparency Initiatives</h2>
        <p class="lead text-secondary">
            We are committed to transparency in our financial dealings and project implementations. Here are some key initiatives:
        </p>

        <div class="card shadow-sm">
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle-fill text-navy mt-3"></i> Regular financial audits</li>
                    <li><i class="bi bi-check-circle-fill text-navy mt-3"></i> Public access to financial reports</li>
                    <li><i class="bi bi-check-circle-fill text-navy mt-3"></i> Community consultations for project planning</li>
                </ul>
            </div>
        </div>

                <!-- Example Financial Audits -->
                <div class="mt-4">
                    <h3 class="text-navy fw-bold" id="Audit">Recent Financial Audits</h3>
                    <p class="text-secondary">Below are recent audit reports available for public review (sample placeholders):</p>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    2024 Annual Financial Audit
                                    <span>
                                        <a href="#" class="btn btn-sm btn-outline-navy me-2">View</a>
                                        <a href="#" class="btn btn-sm btn-primary">Download PDF</a>
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    2023 Annual Budget Audit
                                    <span>
                                        <a href="#" class="btn btn-sm btn-outline-navy me-2">View</a>
                                        <a href="#" class="btn btn-sm btn-primary">Download PDF</a>
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    2023 Quarterly Audit (Q4)
                                    <span>
                                        <a href="#" class="btn btn-sm btn-outline-navy me-2">View</a>
                                        <a href="#" class="btn btn-sm btn-primary">Download PDF</a>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <h3 class="text-navy fw-bold mt-4 mb-2" id="FinancialStatement">Sample Budget Summary (2024)</h3>
                     <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive mb-4">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Allocated (PHP)</th>
                                            <th>Spent (PHP)</th>
                                            <th>Remaining (PHP)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Health &amp; Sanitation</td>
                                            <td>1,500,000</td>
                                            <td>1,120,450</td>
                                            <td>379,550</td>
                                        </tr>
                                        <tr>
                                            <td>Infrastructure &amp; Roads</td>
                                            <td>2,200,000</td>
                                            <td>1,890,230</td>
                                            <td>309,770</td>
                                        </tr>
                                        <tr>
                                            <td>Education &amp; Training</td>
                                            <td>600,000</td>
                                            <td>412,000</td>
                                            <td>188,000</td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Preparedness</td>
                                            <td>350,000</td>
                                            <td>210,500</td>
                                            <td>139,500</td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td>Total</td>
                                            <td>4,650,000</td>
                                            <td>3,632,180</td>
                                            <td>1,017,820</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-navy fw-bold mt-4 mb-2">Ongoing Project Updates</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title" id="Park">Community Park Development</h5>
                                    <p class="text-secondary small mb-2">Status: Site preparation and landscaping</p>
                                    <div class="progress mb-2" style="height: 12px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                                    </div>
                                    <p class="small text-muted mb-0">Expected completion: November 2025</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title" id="Road">Road Improvement - Barangay North</h5>
                                    <p class="text-secondary small mb-2">Status: Drainage works completed; paving ongoing</p>
                                    <div class="progress mb-2" style="height: 12px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                                    </div>
                                    <p class="small text-muted mb-0">Expected completion: September 2025</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title" id="Health">Health Services Expansion</h5>
                                    <p class="text-secondary small mb-2">Status: Medical equipment procurement</p>
                                    <div class="progress mb-2" style="height: 12px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                                    </div>
                                    <p class="small text-muted mb-0">Expected completion: January 2026</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title" id="School">School Feeding Program</h5>
                                    <p class="text-secondary small mb-2">Status: Vendor agreements finalized</p>
                                    <div class="progress mb-2" style="height: 12px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                    </div>
                                    <p class="small text-muted mb-0">Expected rollout: December 2025</p>
                                </div>
                            </div>
                        </div>
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
</body>
</html>