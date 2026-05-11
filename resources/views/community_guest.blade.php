<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community | Community e-Portal (Guest)</title>
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
                    <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('about_guest') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('e-serbisyo_guest')}}">E-Serbisyo</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('transparency_guest')}}">Transparency</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ url('community_guest') }}">Community</a></li>
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
                <h1 class="display-5 fw-bold text-navy">Community Engagement</h1>
                <p class="lead text-secondary">
                    Stay connected with your community. Explore events, volunteer opportunities, and programs that bring us together as one barangay.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <img src="{{url('frontend/community.png')}}" alt="Community Logo" class="img-fluid mb-3" aria-label="Community Logo">
            </div>
        </div>
    </header>

    <section class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-navy mb-0"><i class="bi bi-calendar3 me-2"></i>Barangay Events</h3>
            <span class="text-muted small">Pulled live from the Events table</span>
        </div>
        <div class="row g-4">
            @forelse($events ?? [] as $event)
                @php
                    $eventDate = \Carbon\Carbon::parse($event->event_date);
                    $isPast = $eventDate->isPast();
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge {{ $isPast ? 'bg-secondary' : 'bg-success' }}">
                                    {{ $isPast ? 'Past Event' : 'Upcoming' }}
                                </span>
                                <span class="text-muted small">{{ $eventDate->format('M d, Y') }}</span>
                            </div>
                            <h5 class="card-title text-navy mb-2">{{ $event->title }}</h5>
                            <p class="card-text mb-2 text-secondary">
                                <i class="bi bi-geo-alt me-1"></i>{{ $event->location }}
                            </p>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-clock-history me-1"></i>
                                Added {{ \Carbon\Carbon::parse($event->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        No events posted yet. Please check back soon.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <footer class="bg-primary text-white text-center py-3 mt-auto w-100 position-relative bottom-0 start-0">
        <div class="container">
            &copy; 2025 Barangay Online Services and Public Information System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>