<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Preparedness | Barangay Official Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{url('frontend/style.css')}}">
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
                    <li class="nav-item"><a class="nav-link" href="{{ url('official_dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('manage_residents')}}">Manage Residents</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('manage_e-serbisyo')}}">E-Serbisyo Requests</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            More
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="{{url('transparency_records')}}">Transparency Reports</a></li>
                            <li><a class="dropdown-item" href="{{url('events_announcements')}}">Community Events & Announcements</a></li>
                            <li><a class="dropdown-item active" href="{{url('disaster_preparednessedit')}}">Disaster Preparedness</a></li>
                            <li><a class="dropdown-item" href="{{url('appointments_feedback')}}">Appointments & Feedback</a></li>
                        </ul>
                    </li>
                    {{-- <li class="nav-item ms-5"><a class="nav-link" href="#"><i class="bi bi-bell text-white fs-6"></i></a></li> --}}
                    <li class="nav-item ms-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2" title="Logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
            <div class="container">
                <h1 class="mt-2 text-navy fw-bold">Disaster Preparedness</h1>
                <p class="lead text-secondary">Here you can manage disaster preparedness plans and resources.</p>
                <div class="mt-4">
                    <div class="alert alert-info d-flex justify-content-between" role="alert">
                        <span>Ensure that all disaster preparedness plans are up-to-date and accessible to the community.</span>
                        <button class="btn btn-sm btn-outline-navy">Add New Plan</button>
                    </div>
                    <form class="row g-3 mb-4">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Search by Plan Name or ID">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option selected>Filter by Type</option>
                                <option value="1">Evacuation Plan</option>
                                <option value="2">Resource Allocation</option>
                                <option value="3">Training Schedule</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="submit" class="btn btn-outline-navy">Search</button>
                        </div>  
                    </form>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Plan ID</th>
                                        <th scope="col">Plan Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Last Updated</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>DP001</td>
                                        <td>Flood Evacuation Plan</td>
                                        <td>Evacuation Plan</td>
                                        <td>2023-08-15</td>
                                        <td>
                                            <a href="#"><i class="bi bi-eye"></i></a>
                                            <a href="#" class="ms-3"><i class="bi bi-pencil"></i></a>
                                            <a href="#" class="ms-3 text-danger"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>DP002</td>
                                        <td>Resource Allocation for Typhoons</td>
                                        <td>Resource Allocation</td>
                                        <td>2023-07-10</td>
                                        <td>
                                            <a href="#"><i class="bi bi-eye"></i></a>
                                            <a href="#" class="ms-3"><i class="bi bi-pencil"></i></a>
                                            <a href="#" class="ms-3 text-danger"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>DP003</td>
                                        <td>Earthquake Response Training</td>
                                        <td>Training Schedule</td>
                                        <td>2023-06-05</td>
                                        <td>
                                            <a href="#"><i class="bi bi-eye"></i></a>
                                            <a href="#" class="ms-3"><i class="bi bi-pencil"></i></a>
                                            <a href="#" class="ms-3 text-danger"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>DP004</td>
                                        <td>Wildfire Evacuation Plan</td>
                                        <td>Evacuation Plan</td>
                                        <td>2023-05-20</td>
                                        <td>
                                            <a href="#"><i class="bi bi-eye"></i></a>
                                            <a href="#" class="ms-3"><i class="bi bi-pencil"></i></a>
                                            <a href="#" class="ms-3 text-danger"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>DP005</td>
                                        <td>Hurricane Resource Management</td>
                                        <td>Resource Allocation</td>
                                        <td>2023-04-18</td>
                                        <td>
                                            <a href="#"><i class="bi bi-eye"></i></a>
                                            <a href="#" class="ms-3"><i class="bi bi-pencil"></i></a>
                                            <a href="#" class="ms-3 text-danger"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>DP006</td>
                                        <td>Evacuation Plan Review</td>
                                        <td>Training Schedule</td>
                                        <td>2023-03-12</td>
                                        <td>
                                            <a href="#"><i class="bi bi-eye"></i></a>
                                            <a href="#" class="ms-3"><i class="bi bi-pencil"></i></a>
                                            <a href="#" class="ms-3 text-danger"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-header text-navy fw-bold">Evacuation Map</h5>
                        <button class="btn btn-outline-navy btn-sm">Add New Map</button>
                    </div>
                    <div class="card mt-4">
                        <img src="https://tse4.mm.bing.net/th/id/OIP.jlycdmkRt3D2eHSdY7rMdgHaFS?cb=12&rs=1&pid=ImgDetMain&o=7&rm=3" class="card-img-top" alt="Evacuation Map">
                        <div class="card-body">
                            <h5 class="card-title">Earthquake Evacuation Map</h5>
                            <div class="mt-2 d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">
                                    Last Updated: 2023-08-01 | Uploaded by: Admin Jose Ramirez
                                </span>
                                <span>
                                    <a href="#" class="btn btn-outline-navy btn-sm"><i class="bi bi-pencil"></i> Edit Map</a>
                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete Map</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <img src="https://th.bing.com/th/id/R.3bc0e5daf31d64268d3eda9fabc80a4d?rik=RVUFpqf7wLHXIQ&riu=http%3a%2f%2flgustamonica.gov.ph%2fwp-content%2fuploads%2f2022%2f11%2fLIBERTAD-1-1024x724.jpg&ehk=7D2q5t%2b%2fFlsNkD%2bNNdlfkSxq8n8pxLuecBtmNnNUMsI%3d&risl=&pid=ImgRaw&r=0" class="card-img-top" alt="Evacuation Map">
                        <div class="card-body">
                            <h5 class="card-title">Flood Evacuation Map</h5>
                            <div class="mt-2 d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">
                                    Last Updated: 2023-07-15 | Uploaded by: Sec. Maria Santos
                                </span>
                                <span>
                                    <a href="#" class="btn btn-outline-navy btn-sm"><i class="bi bi-pencil"></i> Edit Map</a>
                                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete Map</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
    @include('partials.footer')
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>