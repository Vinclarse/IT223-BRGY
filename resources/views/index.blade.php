<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community e-Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('frontend/style.css')}}">
    <!-- Add Vue.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
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
                   <li class="nav-item"><a class="nav-link active" href="{{url('/')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('about_guest') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('e-serbisyo_guest')}}">E-Serbisyo</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('transparency_guest')}}">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('community_guest') }}">Community</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('disasterPreparedness_guest')}}">Disaster Preparedness</a></li>
                </ul>
                <div class="d-flex ms-2">
                    <a href="{{url('profile_guest')}}"><i class="bi bi-person-circle fs-2 person" style="color: rgb(115, 115, 225);"></i></a>
                </div>       
            </div>
        </div>
    </nav>

    <header class="container mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold">Welcome to Barangay Del Pilar Online Services and Public Information System</h1>
                <p class="lead text-secondary">
                    Bringing essential barangay services and information closer to you. Access announcements, request documents, schedule appointments, and stay informed about local programs and emergency updates.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <img src="{{url('frontend/logo.png')}}" alt="Barangay Logo" width="180px" height="180px" class="img-fluid mb-3">
                <div class="bg-light rounded p-3 shadow-sm">
                    <h5 class="mb-1 text-dark fw-bold">Message from the Barangay Chairman</h5>
                    <p class="mb-0 text-muted" style="font-size: 0.95rem;">
                        "Together, let's build a more responsive, transparent, and connected barangay for everyone."
                    </p>
                </div>
            </div>
        </div>
    </header>

    <section class="container mb-5" id="announcementsApp">
        <div class="row g-4">
            <div class="col-md-12">
                <h5 class="card-title text-navy mb-1 an">
                    <i class="bi bi-megaphone"></i> Announcements
                </h5>
            </div>

            <!-- LOOP FROM DATABASE -->
            <div class="col-md-12" v-for="ann in announcements" :key="ann.announcement_id">
                <div class="card border-primary">
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <!-- CATEGORY BADGE -->
                                <span class="badge me-2"
                                    :class="{
                                        'bg-success': ann.category === 'General',
                                        'bg-info': ann.category === 'Event',
                                        'bg-warning': ann.category === 'Advisory',
                                        'bg-danger': ann.category === 'Emergency'
                                    }">
                                    @{{ ann.category }}
                                </span>

                                <strong>@{{ ann.title }}</strong>
                                <br>
                                @{{ ann.content }}

                                <div class="text-muted small mt-2">
                                    Posted by Official #@{{ ann.official_id }} • 
                                    @{{ formatDate(ann.date_posted) }}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- EMPTY STATE -->
            <div v-if="announcements.length === 0" class="col-12 text-center text-muted mt-4">
                No announcements available
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
    
    <script>
        // Vue.js Application
        new Vue({
            el: '#announcementsApp',
            data: {
                announcements: []
            },
            mounted() {
                this.fetchAnnouncements();
            },
            methods: {
                fetchAnnouncements() {
                    // Use the correct endpoint from your routes
                    fetch('/announcements_data')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            this.announcements = data;
                        })
                        .catch(error => {
                            console.error('Error fetching announcements:', error);
                            // Optional: Show error message to user
                            this.announcements = [{
                                announcement_id: 0,
                                title: 'Error loading announcements',
                                content: 'Please try again later or contact support.',
                                category: 'General',
                                official_id: 0,
                                date_posted: new Date().toISOString()
                            }];
                        });
                },
                
                formatDate(dateString) {
                    if (!dateString) return '';
                    
                    try {
                        const date = new Date(dateString);
                        // Format to Philippine time: Month Day, Year, Time
                        return date.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true,
                            timeZone: 'Asia/Manila'
                        });
                    } catch (e) {
                        return dateString; // Return original string if parsing fails
                    }
                }
            }
        });
    </script>
</body>
</html>