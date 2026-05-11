<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transparency Records | Barangay Official Dashboard</title>
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
                        <ul class="dropdown-menu dropdown-menu-dark" style="background-color: #0b3d91; !important;">
                            <li><a class="dropdown-item active" href="{{url('transparency_records')}}">Transparency Reports</a></li>
                            <li><a class="dropdown-item" href="{{url('events_announcements')}}">Community Events & Announcements</a></li>
                            <li><a class="dropdown-item" href="{{url('appointments_feedback')}}">Appointments & Feedback</a></li>
                        </ul>
                    </li>
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
            <div class="container">
        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
        @endif

        <h1 class="mt-4 text-navy fw-bold">Transparency Records</h1>
        <p class="lead text-secondary">Here you can view and manage transparency reports.</p>
        
        <!-- Add New Report Form -->
        <div class="card mt-4 mb-4">
            <div class="card-body">
                <h5 class="card-title">Add New Report</h5>
                <form id="addReportForm" method="POST" action="{{ route('transparency_records.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" class="form-control" id="category" placeholder="e.g., Financial" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="report_date" class="form-label">Report Date</label>
                            <input type="date" name="report_date" class="form-control" id="report_date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-navy">Add Report</button>
                </form>
            </div>
        </div>

        <!-- Search and Filter (Vue-powered, no full page reload) -->
        <div class="mt-4" id="transparencyApp">
            <h5 class="mb-3 text-navy fw-bold">Transparency Reports</h5>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <input type="text" v-model="q" @input="debouncedFetch" class="form-control" placeholder="Search by title or description">
                </div>
                <div class="col-md-3">
                    <select v-model="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="button" @click="fetchReports()" class="btn btn-outline-navy">Search</button>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mt-3">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Category</th>
                                <th scope="col">Report Date</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="report in reports" :key="report.report_id">
                                <td><strong>{{""}}<span v-text="report.title"></span></strong></td>
                                <td><span class="badge bg-info" v-text="report.category"></span></td>
                                <td v-text="formatDate(report.report_date)"></td>
                                <td v-text="shorten(report.description, 80)"></td>
                                <td>
                                    <button class="btn btn-link btn-sm p-0" type="button" @click="showReport(report)" aria-label="View report">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-danger btn-link btn-sm p-0 ms-3" type="button" @click="deleteReport(report.report_id)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!reports.length">
                                <td colspan="5" class="text-center text-muted py-4">No reports found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Reusable Modal (single instance) -->
    <div class="modal fade" id="reportViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportViewTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Category:</strong> <span id="reportViewCategory"></span></p>
                    <p><strong>Report Date:</strong> <span id="reportViewDate"></span></p>
                    <p><strong>Description:</strong></p>
                    <p id="reportViewDescription"></p>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function () {
            const { createApp } = Vue;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            createApp({
                data() {
                    return {
                        reports: [],
                        q: @json($q ?? ''),
                        category: @json($category ?? ''),
                        categories: @json($categories ?? []),
                        loading: false,
                        debounceTimer: null,
                    }
                },
                mounted() {
                    this.fetchReports();
                    window.addEventListener('transparencyReportAdded', (e) => {
                        if (e && e.detail) {
                            this.reports.unshift(e.detail);
                        }
                    });
                },
                methods: {
                    debouncedFetch() {
                        clearTimeout(this.debounceTimer);
                        this.debounceTimer = setTimeout(() => this.fetchReports(), 350);
                    },
                    async fetchReports() {
                        this.loading = true;
                        try {
                            const params = new URLSearchParams();
                            if (this.q) params.set('q', this.q);
                            if (this.category) params.set('category', this.category);

                            const res = await fetch('/transparency_records_data?' + params.toString(), {
                                headers: { 'Accept': 'application/json' }
                            });
                            if (!res.ok) throw new Error('Network error');
                            this.reports = await res.json();
                        } catch (e) {
                            console.error('Failed to fetch reports', e);
                        } finally {
                            this.loading = false;
                        }
                    },
                    formatDate(d) {
                        try {
                            if (!d) return '';
                            const dt = new Date(d);
                            return dt.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: '2-digit' });
                        } catch (e) {
                            return d;
                        }
                    },
                    shorten(text, n) {
                        if (!text) return '';
                        return text.length > n ? text.substring(0, n) + '…' : text;
                    },
                    showReport(report) {
                        const titleEl = document.getElementById('reportViewTitle');
                        const categoryEl = document.getElementById('reportViewCategory');
                        const dateEl = document.getElementById('reportViewDate');
                        const descEl = document.getElementById('reportViewDescription');

                        titleEl.textContent = report.title || '';
                        categoryEl.textContent = report.category || '';
                        dateEl.textContent = this.formatDate(report.report_date || '');
                        descEl.textContent = report.description || '';

                        const modalEl = document.getElementById('reportViewModal');
                        const bsModal = new bootstrap.Modal(modalEl);
                        bsModal.show();
                    },
                    async deleteReport(id) {
                        if (!confirm('Delete this report?')) return;
                        try {
                            const res = await fetch('/transparency_records/' + encodeURIComponent(id), {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                }
                            });
                            if (!res.ok) throw new Error('Delete failed');
                            // Remove locally
                            this.reports = this.reports.filter(r => r.report_id !== id);
                        } catch (e) {
                            console.error('Delete failed', e);
                            alert('Failed to delete report.');
                        }
                    }
                }
                }).mount('#transparencyApp');

            // Attach AJAX submit handler for add form (outside Vue-managed DOM)
            const addForm = document.getElementById('addReportForm');
            if (addForm) {
                addForm.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    const form = e.target;
                    const formData = new FormData(form);
                    try {
                        const res = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        if (!res.ok) {
                            const txt = await res.text();
                            console.error('Add failed', txt);
                            alert('Failed to add report');
                            return;
                        }

                        const created = await res.json();
                        // If Vue app is present, push the created report
                        const vm = document.getElementById('transparencyApp') && document.getElementById('transparencyApp').__vue_app__;
                        // Fallback: try to find the Vue app instance (Vue doesn't expose instance easily from DOM)
                        // Instead, dispatch a custom event that Vue listens to (we'll implement event listener in Vue)
                        const event = new CustomEvent('transparencyReportAdded', { detail: created });
                        window.dispatchEvent(event);

                        form.reset();
                        alert('Report added');
                    } catch (err) {
                        console.error(err);
                        alert('Failed to add report');
                    }
                });
            }
        })();
    </script>
</body>
</html>