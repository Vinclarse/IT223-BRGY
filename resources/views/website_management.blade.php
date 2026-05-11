<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Management | Admin - Community e-Portal</title>
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
                    <li class="nav-item"><a class="nav-link" href="{{url('admin_dashboard')}}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('manageusers_admin')}}">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{url('website_management')}}">Website Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('system_settings')}}">System Settings</a></li>
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="#" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Log out
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <header class="container mb-4">
        <h1 class="display-5 fw-bold">Website Management</h1>
        <p class="lead text-secondary">
            Manage events, announcements, and transparency content shown to residents and guests.
        </p>
    </header>

    <section class="container mb-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>

    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-bold text-navy"><i class="bi bi-megaphone me-2"></i>Announcements</h5>
                    </div>
                    <div class="card-body">
                        <form class="row g-2 mb-3" method="POST" action="{{ route('announcements.store') }}">
                            @csrf
                            <div class="col-md-5">
                                <label class="form-label small text-muted">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Category</label>
                                <select name="category" class="form-select" required>
                                    @foreach(['General','Emergency','Event','Advisory'] as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small text-muted">Content</label>
                                <textarea name="content" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="col-md-12 d-flex justify-content-end">
                                <button class="btn btn-outline-navy btn-sm"><i class="bi bi-plus-lg"></i> Post</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($announcements as $ann)
                                        <tr>
                                            <td>{{ $ann->title }}</td>
                                            <td>{{ $ann->category }}</td>
                                            <td>{{ $ann->date_posted }}</td>
                                            <td class="text-end">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#ann-{{ $ann->announcement_id }}">Edit</button>
                                                <form class="d-inline" method="POST" action="{{ route('announcements.destroy', $ann->announcement_id) }}" onsubmit="return confirm('Delete this announcement?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="ann-{{ $ann->announcement_id }}">
                                            <td colspan="4">
                                                <form class="row g-2" method="POST" action="{{ route('announcements.update', $ann->announcement_id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="col-md-4">
                                                        <label class="form-label small text-muted">Title</label>
                                                        <input type="text" name="title" class="form-control" value="{{ $ann->title }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small text-muted">Category</label>
                                                        <select name="category" class="form-select" required>
                                                            @foreach(['General','Emergency','Event','Advisory'] as $cat)
                                                                <option value="{{ $cat }}" @selected($ann->category===$cat)>{{ $cat }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small text-muted">Date Posted</label>
                                                        <input type="datetime-local" name="date_posted" class="form-control" value="{{ $ann->date_posted }}">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label small text-muted">Content</label>
                                                        <textarea name="content" class="form-control" rows="2" required>{{ $ann->content }}</textarea>
                                                    </div>
                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <button class="btn btn-outline-navy btn-sm">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-muted text-center">No announcements yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-bold text-navy"><i class="bi bi-calendar-event me-2"></i>Events</h5>
                    </div>
                    <div class="card-body">
                        <form class="row g-2 mb-3" method="POST" action="{{ route('events.store') }}">
                            @csrf
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Date</label>
                                <input type="date" name="event_date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Location</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="col-md-12 d-flex justify-content-end">
                                <button class="btn btn-outline-navy btn-sm"><i class="bi bi-plus-lg"></i> Add Event</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events as $event)
                                        <tr>
                                            <td>{{ $event->title }}</td>
                                            <td>{{ $event->event_date }}</td>
                                            <td>{{ $event->location }}</td>
                                            <td class="text-end">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#event-{{ $event->event_id }}">Edit</button>
                                                <form class="d-inline" method="POST" action="{{ route('events.destroy', $event->event_id) }}" onsubmit="return confirm('Delete this event?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="event-{{ $event->event_id }}">
                                            <td colspan="4">
                                                <form class="row g-2" method="POST" action="{{ route('events.update', $event->event_id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="col-md-4">
                                                        <label class="form-label small text-muted">Title</label>
                                                        <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small text-muted">Date</label>
                                                        <input type="date" name="event_date" class="form-control" value="{{ \Illuminate\Support\Str::of($event->event_date)->substr(0,10) }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small text-muted">Location</label>
                                                        <input type="text" name="location" class="form-control" value="{{ $event->location }}" required>
                                                    </div>
                                                    <div class="col-md-2 d-flex align-items-end">
                                                        <button class="btn btn-outline-navy btn-sm w-100">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-muted text-center">No events yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-navy"><i class="bi bi-file-earmark-text me-2"></i>Transparency Reports</h5>
                <a class="btn btn-outline-navy btn-sm" href="{{ route('transparency_records') }}">Open full manager</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Report Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transparency as $report)
                                <tr>
                                    <td>{{ $report->title }}</td>
                                    <td>{{ $report->category }}</td>
                                    <td>{{ $report->report_date }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-muted text-center">No reports yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <small class="text-muted d-block">Use the Transparency page to upload, edit, or remove reports.</small>
            </div>
        </div>
    </section>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>