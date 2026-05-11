<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Events & Announcements | Barangay Official Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('official_dashboard')); ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('manage_residents')); ?>">Manage Residents</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('manage_e-serbisyo')); ?>">E-Serbisyo Requests</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            More
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="<?php echo e(url('transparency_records')); ?>">Transparency Reports</a></li>
                            <li><a class="dropdown-item active" href="<?php echo e(url('events_announcements')); ?>">Community Events & Announcements</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(url('appointments_feedback')); ?>">Appointments & Feedback</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-2">
                        <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
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
                <h1 class="mt-2 text-navy fw-bold">Community Events & Announcements</h1>
                <p class="lead text-secondary">Here you can manage community events and announcements.</p>
                <div class="mt-4">
                    <div id="eventsApp">
                        <div class="card-header bg-navy d-flex justify-content-between align-items-center">
                            <h5 class="text-navy fw-bold">Events</h5>
                            <button class="btn btn-outline-navy btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addEventModal">+ Add New Event</button>
                        </div>
                        <div class="card mt-2">
                            <div class="table-responsive">
                                <table class="table table-hover mt-3">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Event ID</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="evt in events" :key="evt.event_id">
                                            <td v-text="evt.event_id"></td>
                                            <td v-text="evt.title"></td>
                                            <td v-text="evt.event_date_display || formatDate(evt.event_date)"></td>
                                            <td v-text="evt.location"></td>
                                                <td v-text="evt.created_at_display || formatDate(evt.created_at)"></td>
                                                <td>
                                                    <button class="btn btn-link p-0" @click="viewEvent(evt)"><i class="bi bi-eye"></i></button>
                                                    <button class="btn btn-link p-0 ms-3" @click="openEventEditModal(evt)"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-link p-0 ms-3 text-danger" @click="deleteEvent(evt.event_id)"><i class="bi bi-trash"></i></button>
                                                </td>
                                        </tr>
                                        <tr v-if="!events.length">
                                            <td colspan="5" class="text-center text-muted py-4">No events found.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Add Announcement Modal -->
                    <div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Announcement</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="announcementAddForm">
                                        <div class="mb-2">
                                            <label class="form-label">Title</label>
                                            <input class="form-control" name="title" required />
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Category</label>
                                            <select class="form-select" name="category" required>
                                                <option value="General">General</option>
                                                <option value="Emergency">Emergency</option>
                                                <option value="Event">Event</option>
                                                <option value="Advisory">Advisory</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Content</label>
                                            <textarea class="form-control" name="content" rows="4" required></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="submitAnnouncementAdd">Add Announcement</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Event Modal -->
                    <div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Event</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="eventAddForm">
                                        <div class="mb-2">
                                            <label class="form-label">Title</label>
                                            <input class="form-control" name="title" required />
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Event Date</label>
                                            <input class="form-control" type="date" name="event_date" required />
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Location</label>
                                            <input class="form-control" name="location" required />
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="submitEventAdd">Add Event</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Event View Modal -->
                    <div class="modal fade" id="eventViewModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventViewTitle"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="eventViewBody">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Event Edit Modal -->
                    <div class="modal fade" id="eventEditModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Event</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="eventEditForm">
                                        <input type="hidden" name="event_id" id="event_edit_id">
                                        <div class="mb-2">
                                            <label class="form-label">Title</label>
                                            <input class="form-control" name="title" id="event_edit_title" required />
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Event Date</label>
                                            <input class="form-control" type="date" name="event_date" id="event_edit_date" required />
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Location</label>
                                            <input class="form-control" name="location" id="event_edit_location" required />
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="saveEventEdit">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4" id="announcementsApp">
                    <div class="card-header bg-navy d-flex justify-content-between align-items-center">
                        <h5 class="text-navy fw-bold">Announcements</h5>
                        <button class="btn btn-outline-navy btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">+ Add New Announcement</button>
                    </div>
                    <div class="card mt-2">
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Announcement ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Date Posted</th>
                                        <th scope="col">Posted by:</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ann in announcements" :key="ann.announcement_id">
                                        <td v-text="ann.announcement_id"></td>
                                        <td v-text="ann.title"></td>
                                        <td v-text="ann.date_posted_display || formatDate(ann.date_posted)"></td>
                                        <td>Official #<span v-text="ann.official_id"></span></td>
                                        <td>
                                            <button class="btn btn-link p-0" @click="viewAnnouncement(ann)"><i class="bi bi-eye"></i></button>
                                            <button class="btn btn-link p-0 ms-3" @click="openEditModal(ann)"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-link p-0 ms-3 text-danger" @click="deleteAnnouncement(ann.announcement_id)"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr v-if="!announcements.length">
                                        <td colspan="5" class="text-center text-muted py-4">No announcements found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="announcementEditModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Announcement</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="announcementEditForm">
                                        <input type="hidden" name="announcement_id" v-model="edit.id">
                                        <div class="mb-2">
                                            <label class="form-label">Title</label>
                                            <input class="form-control" name="title" v-model="edit.title" required />
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Category</label>
                                            <select class="form-select" name="category" v-model="edit.category" required>
                                                <option value="General">General</option>
                                                <option value="Emergency">Emergency</option>
                                                <option value="Event">Event</option>
                                                <option value="Advisory">Advisory</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Content</label>
                                            <textarea class="form-control" name="content" v-model="edit.content" rows="4" required></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="saveAnnouncementEdit">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Announcement View Modal -->
                    <div class="modal fade" id="announcementViewModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="announcementViewTitle">Announcement</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="announcementViewBody">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script>
        (function(){
            const { createApp } = Vue;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const app = createApp({
                data(){
                    return { events: [] }
                },
                mounted(){
                    this.fetchEvents();
                },
                methods:{
                    async fetchEvents(){
                        try{
                            const res = await fetch('/events_data', { headers: { 'Accept': 'application/json' } });
                            if(!res.ok) throw new Error('Network');
                            this.events = await res.json();
                        }catch(e){ console.error(e); }
                    },
                    formatDate(d){
                        try{
                            if(!d) return '';
                            const s = String(d).trim();
                            // If format is YYYY-MM-DD (date input), create a T-suffixed ISO string
                            if (/^\d{4}-\d{2}-\d{2}$/.test(s)) {
                                const dt = new Date(s + 'T00:00:00');
                                if(!isNaN(dt.getTime())) return dt.toLocaleString();
                                return s;
                            }
                            // If already ISO-like or contains time
                            const dt = new Date(s);
                            if(!isNaN(dt.getTime())) return dt.toLocaleString();
                            // try replacing space with 'T' (for 'YYYY-MM-DD HH:MM:SS')
                            const alt = s.replace(' ', 'T');
                            const dt2 = new Date(alt);
                            if(!isNaN(dt2.getTime())) return dt2.toLocaleString();
                            return s;
                        }catch(e){ return String(d); }
                    },
                    viewEvent(evt){
                        // show a modal with details instead of alert
                        const modalBody = document.getElementById('eventViewBody');
                        document.getElementById('eventViewTitle').textContent = evt.title || '';
                        if(modalBody){ modalBody.innerHTML = `<p><strong>Date:</strong> ${this.formatDate(evt.event_date)}</p><p><strong>Location:</strong> ${evt.location}</p><p><strong>Created:</strong> ${this.formatDate(evt.created_at)}</p>`; }
                        const modal = new bootstrap.Modal(document.getElementById('eventViewModal'));
                        modal.show();
                    },
                    openEventEditModal(evt){
                        // populate edit modal fields
                        document.getElementById('event_edit_id').value = evt.event_id;
                        document.getElementById('event_edit_title').value = evt.title || '';
                        // ensure date is in YYYY-MM-DD
                        const d = evt.event_date ? new Date(evt.event_date) : null;
                        document.getElementById('event_edit_date').value = d ? d.toISOString().slice(0,10) : '';
                        document.getElementById('event_edit_location').value = evt.location || '';
                        const modal = new bootstrap.Modal(document.getElementById('eventEditModal'));
                        modal.show();
                    },
                    async deleteEvent(id){
                        if(!confirm('Delete event?')) return;
                        try{
                            const res = await fetch('/events/' + encodeURIComponent(id), {
                                method: 'DELETE',
                                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                            });
                            if(!res.ok) throw new Error('Delete failed');
                            this.events = this.events.filter(e => e.event_id !== id);
                        }catch(e){ console.error(e); alert('Failed to delete'); }
                    }
                }
            }).mount('#eventsApp');

            // Add event via modal form
            const submitEventAdd = document.getElementById('submitEventAdd');
            if(submitEventAdd){
                submitEventAdd.addEventListener('click', async function(){
                    const form = document.getElementById('eventAddForm');
                    const fd = new FormData(form);
                    try{
                        const res = await fetch('/events', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                        if(!res.ok){
                            if(res.status === 422){
                                const payload = await res.json().catch(()=>null);
                                const msgs = [];
                                if(payload && payload.errors){
                                    for(const k in payload.errors) msgs.push(...payload.errors[k]);
                                }
                                alert(msgs.length ? msgs.join('\n') : 'Validation failed');
                                return;
                            }
                            const txt = await res.text().catch(()=>null);
                            console.error(txt);
                            alert('Add failed: ' + (txt || res.status));
                            return;
                        }
                        const created = await res.json();
                        app.events.unshift(created);
                        // hide modal
                        bootstrap.Modal.getInstance(document.getElementById('addEventModal'))?.hide();
                        form.reset();
                    }catch(err){ console.error(err); alert('Add failed: ' + (err.message || err)); }
                });
            }
            // Event edit save
            const saveEventEdit = document.getElementById('saveEventEdit');
            if(saveEventEdit){
                saveEventEdit.addEventListener('click', async function(){
                    const id = document.getElementById('event_edit_id').value;
                    const fd = new FormData(document.getElementById('eventEditForm'));
                    // use method override
                    fd.append('_method', 'PUT');
                    try{
                        const res = await fetch('/events/' + encodeURIComponent(id), { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                        if(!res.ok){
                            const txt = await res.text(); console.error(txt); alert('Update failed'); return;
                        }
                        const updated = await res.json();
                        const idx = app.events.findIndex(e => e.event_id === updated.event_id);
                        if(idx !== -1) app.events.splice(idx, 1, updated);
                        bootstrap.Modal.getInstance(document.getElementById('eventEditModal'))?.hide();
                    }catch(err){ console.error(err); alert('Update failed'); }
                });
            }

            // Listen to created event to update list
            window.addEventListener('eventCreated', (e) => {
                const vmRoot = document.getElementById('eventsApp');
                // If Vue app mounted, push to its state
                try{
                    const vueInstances = vmRoot && vmRoot.__vue_app__;
                    // simplest: refetch via fetchEvents call
                    // (we also call fetch after addForm submit)
                }catch(e){/*ignore*/}
            });
        })();
    </script>
    <script>
        (function(){
            const { createApp } = Vue;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const announcementsApp = createApp({
                data(){
                    return {
                        announcements: [],
                        edit: { id: null, title: '', content: '', category: '' }
                    }
                },
                mounted(){ this.fetchAnnouncements(); },
                methods:{
                    async fetchAnnouncements(){
                        try{
                            const res = await fetch('/announcements_data', { headers: { 'Accept': 'application/json' } });
                            if(!res.ok) throw new Error('Network');
                            this.announcements = await res.json();
                        }catch(e){ console.error(e); }
                    },
                    formatDate(d){
                        try{
                            if(!d) return '';
                            const dt = new Date(d);
                            if(!isNaN(dt.getTime())) return dt.toLocaleString();
                            const alt = String(d).replace(' ', 'T');
                            const dt2 = new Date(alt);
                            if(!isNaN(dt2.getTime())) return dt2.toLocaleString();
                            return String(d);
                        }catch(e){ return String(d); }
                    },
                    viewAnnouncement(a){
                        const titleEl = document.getElementById('announcementViewTitle');
                        const bodyEl = document.getElementById('announcementViewBody');
                        titleEl.textContent = a.title || 'Announcement';
                        bodyEl.innerHTML = `<p><strong>Category:</strong> ${a.category || ''}</p><p>${(a.content||'')}</p><p class="text-muted mt-2"><small>Posted: ${this.formatDate(a.date_posted)}</small></p>`;
                        const modal = new bootstrap.Modal(document.getElementById('announcementViewModal'));
                        modal.show();
                    },
                    openEditModal(a){
                        this.edit = { id: a.announcement_id, title: a.title, content: a.content, category: a.category };
                        const modalEl = document.getElementById('announcementEditModal');
                        const bs = new bootstrap.Modal(modalEl);
                        bs.show();
                    },
                    async deleteAnnouncement(id){
                        if(!confirm('Delete announcement?')) return;
                        try{
                            const res = await fetch('/announcements/' + encodeURIComponent(id), { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
                            if(!res.ok) throw new Error('Delete failed');
                            this.announcements = this.announcements.filter(x => x.announcement_id !== id);
                        }catch(e){ console.error(e); alert('Failed to delete'); }
                    },
                    async saveEdit(){
                        try{
                            const id = this.edit.id;
                            const payload = new FormData();
                            payload.append('title', this.edit.title);
                            payload.append('content', this.edit.content);
                            payload.append('category', this.edit.category);

                            // Use POST with _method=PUT because PHP/Laravel may not parse multipart PUT bodies reliably
                            payload.append('_method', 'PUT');
                            const res = await fetch('/announcements/' + encodeURIComponent(id), { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: payload });
                            if(!res.ok) {
                                if (res.status === 422) {
                                    const payload = await res.json().catch(() => null);
                                    let msg = 'Validation failed.';
                                    if (payload && payload.errors) {
                                        msg = Object.values(payload.errors).flat().join('\n');
                                    }
                                    throw new Error(msg);
                                }
                                const t = await res.text();
                                console.error(t);
                                throw new Error('Update failed: ' + (t || res.status));
                            }
                            const updated = await res.json();
                            const idx = this.announcements.findIndex(x => x.announcement_id === updated.announcement_id);
                            if(idx !== -1) this.announcements.splice(idx, 1, updated);
                            // hide modal
                            const modalEl = document.getElementById('announcementEditModal');
                            bootstrap.Modal.getInstance(modalEl)?.hide();
                        }catch(e){ console.error(e); alert('Failed to update'); }
                    }
                }
            }).mount('#announcementsApp');

            // Add form AJAX
            const annAddForm = document.getElementById('announcementAddForm');
            const submitAnnouncementAdd = document.getElementById('submitAnnouncementAdd');
            if(submitAnnouncementAdd){
                submitAnnouncementAdd.addEventListener('click', async function(){
                    const fd = new FormData(annAddForm);
                    try{
                        const res = await fetch('/announcements', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                        if(!res.ok){
                            if(res.status === 422){
                                const payload = await res.json().catch(()=>null);
                                const msgs = [];
                                if(payload && payload.errors){
                                    for(const k in payload.errors) msgs.push(...payload.errors[k]);
                                }
                                alert(msgs.length ? msgs.join('\n') : 'Validation failed');
                                return;
                            }
                            const txt = await res.text().catch(()=>null);
                            console.error(txt);
                            alert('Add failed: ' + (txt || res.status));
                            return;
                        }
                        const created = await res.json();
                        announcementsApp.announcements.unshift(created);
                        // hide modal
                        bootstrap.Modal.getInstance(document.getElementById('addAnnouncementModal'))?.hide();
                        annAddForm.reset();
                    }catch(err){ console.error(err); alert('Add failed: ' + (err.message || err)); }
                });
            }

            // Save edit button hookup
            const saveBtn = document.getElementById('saveAnnouncementEdit');
            if(saveBtn){
                saveBtn.addEventListener('click', function(){ announcementsApp.saveEdit(); });
            }
        })();
    </script>
</body>
</html><?php /**PATH C:\Users\Gaan's Computer\Documents\Main Main file\resources\views/events_announcements.blade.php ENDPATH**/ ?>