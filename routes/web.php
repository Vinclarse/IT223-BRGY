<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfficialController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\EserviceController;
use App\Http\Controllers\TransparencyController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BarangayOfficialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentDashboardController; 
use App\Http\Controllers\RequestComplaintController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\AnnouncementsController;
use Illuminate\Http\Request;

// Logout route (use POST with CSRF)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* Guest Pages */
Route::get('/', fn() => view('index'));
Route::get('/about_guest', [BarangayOfficialController::class, 'about_guest'])->name('about_guest');
Route::get('/community_guest', [EventsController::class, 'communityGuest'])->name('community_guest');
Route::get('/disasterPreparedness_guest', fn() => view('disasterPreparedness_guest'))->name('disasterPreparedness_guest');
Route::get('/e-serbisyo_guest', fn() => view('e-serbisyo_guest'))->name('e-serbisyo_guest');
Route::get('/transparency_guest', [TransparencyController::class, 'transparency_guest'])->name('transparency_guest');
Route::get('/profile_guest', fn() => view('profile_guest'))->name('profile_guest');

/* Signup & Login */
Route::get('/signup', fn() => view('signup'))->name('signup');
Route::post('/signup-process', [AuthController::class, 'signup'])->name('signup.process');
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login-process', [AuthController::class, 'login'])->name('login.process');
 
/* Resident Routes */
Route::middleware('checkRole:Resident')->group(function () {
    Route::get('/resident_dashboard', [ResidentDashboardController::class, 'dashboard'])->name('resident_dashboard');
    Route::get('/resident_appointments', [ResidentDashboardController::class, 'appointments'])->name('resident_appointments');
    Route::get('/about', [BarangayOfficialController::class, 'about'])->name('about');
    Route::get('/community', [EventsController::class, 'community'])->name('community');
    Route::get('/disasterPreparedness', fn() => view('disasterPreparedness'))->name('disasterPreparedness');
    Route::get('/e-serbisyo', [EserviceController::class, 'showESerbisyo'])->name('e-serbisyo');
    Route::get('/transparency', [TransparencyController::class, 'transparency']);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::get('/requestDocument', [RequestComplaintController::class, 'showRequestForm'])->name('requestDocument');
    Route::post('/requestDocument', [RequestComplaintController::class, 'storeDocumentRequest'])->name('requestDocument.store');
    Route::get('/request-success/{id}', [RequestComplaintController::class, 'showRequestSuccess'])->name('request.success');
    Route::get('/my-requests', [RequestComplaintController::class, 'myDocumentRequests'])->name('my-requests');
    Route::get('/file-complaint', [RequestComplaintController::class, 'showComplaintForm'])->name('complaint.create');
    Route::post('/file-complaint', [RequestComplaintController::class, 'storeComplaint'])->name('complaint.store');
    Route::get('/my-complaints', [RequestComplaintController::class, 'myComplaints'])->name('my-complaints');
    Route::get('/api/appointments/{id}/details', [ResidentDashboardController::class, 'getAppointmentDetails']);
    
    // ========== FEEDBACK ROUTES ==========
    Route::post('/feedback', [EserviceController::class, 'storeFeedback'])->name('feedback.store');
});

/* Official Routes */
Route::middleware('checkRole:Official')->group(function () {
    Route::get('/official_dashboard', [OfficialController::class, 'dashboard'])->name('official_dashboard');
    Route::get('/manage_residents', [ResidentController::class, 'index'])->name('manage_residents');
    Route::get('/manage_residents/{resident_id}', [ResidentController::class, 'show'])->name('residents.show');
    Route::get('/manage_residents/{resident_id}/edit', [ResidentController::class, 'edit'])->name('residents.edit');
    Route::put('/manage_residents/{resident_id}', [ResidentController::class, 'update'])->name('residents.update');
    Route::delete('/manage_residents/{resident_id}', [ResidentController::class, 'destroy'])->name('residents.destroy');
    Route::get('/manage_e-serbisyo', [EserviceController::class, 'indexRequests'])->name('manage_e-serbisyo');
    Route::get('/manage_e-serbisyo/complaints', [EserviceController::class, 'indexComplaints'])->name('manage_e-serbisyo.complaints');
    
    // ========== FEEDBACK MANAGEMENT ROUTES ==========
    Route::get('/manage_feedback', [EserviceController::class, 'getAllFeedback'])->name('manage_feedback');
    Route::delete('/feedback/{id}', [EserviceController::class, 'destroyFeedback'])->name('feedback.destroy');
    
    Route::put('/manage_e-serbisyo/request/{request_id}/status', [EserviceController::class, 'updateRequestStatus'])->name('request.status');
    Route::put('/manage_e-serbisyo/complaint/{complaint_id}/status', [EserviceController::class, 'updateComplaintStatus'])->name('complaint.status');
    Route::delete('/manage_e-serbisyo/request/{request_id}', [EserviceController::class, 'destroyRequest'])->name('request.destroy');
    Route::delete('/manage_e-serbisyo/complaint/{complaint_id}', [EserviceController::class, 'destroyComplaint'])->name('complaint.destroy');
    Route::get('/transparency_records', [TransparencyController::class, 'index'])->name('transparency_records');
    Route::post('/transparency_records', [TransparencyController::class, 'store'])->name('transparency_records.store');
    Route::delete('/transparency_records/{report_id}', [TransparencyController::class, 'destroy'])->name('transparency_records.destroy');
    Route::get('/events_announcements', fn() => view('events_announcements'))->name('events_announcements');
    Route::get('/disaster_preparednessedit', fn() => view('disaster_preparednessedit'))->name('disaster_preparednessedit');
    Route::get('/appointments_feedback', [AppointmentController::class, 'index'])->name('appointments_feedback');
    Route::put('/appointments_feedback/appointment/{appointment_id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::delete('/appointments_feedback/appointment/{appointment_id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::put('/appointments_feedback/appointment/{appointment_id}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments_feedback/feedback/{feedback_id}', [AppointmentController::class, 'destroyFeedback'])->name('feedback.destroy');
    Route::post('/appointments_feedback', [AppointmentController::class, 'store'])->name('appointments.store');
});

// Debug endpoint to list transparency reports as JSON (no auth) - useful for testing
Route::get('/transparency_records_data', [TransparencyController::class, 'data']);

// Events JSON endpoints (used by the events_announcements UI)
Route::get('/events_data', [EventsController::class, 'data']);
Route::post('/events', [EventsController::class, 'store'])->name('events.store');
Route::delete('/events/{event_id}', [EventsController::class, 'destroy'])->name('events.destroy');
Route::put('/events/{event_id}', [EventsController::class, 'update'])->name('events.update');

Route::get('/announcements_data', [AnnouncementsController::class, 'data']);
Route::post('/announcements', [AnnouncementsController::class, 'store'])->name('announcements.store');
Route::put('/announcements/{id}', [AnnouncementsController::class, 'update'])->name('announcements.update');
Route::delete('/announcements/{id}', [AnnouncementsController::class, 'destroy'])->name('announcements.destroy');

// ========== FEEDBACK API ROUTE ==========
Route::get('/api/feedback', function(Request $request) {
    $page = $request->query('page', 1);
    $perPage = 4;
    
    $feedback = DB::table('feedback')
        ->join('resident', 'feedback.resident_id', '=', 'resident.resident_id')
        ->select(
            'feedback.*',
            DB::raw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) as full_name"),
            'resident.first_name',
            'resident.last_name'
        )
        ->orderBy('feedback.date_submitted', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);
    
    // Format the date for JSON response
    $formattedFeedback = collect($feedback->items())->map(function($item) {
        $date = \Carbon\Carbon::parse($item->date_submitted);
        return [
            'feedback_id' => $item->feedback_id,
            'resident_id' => $item->resident_id,
            'message' => $item->message,
            'rating' => $item->rating,
            'date_submitted' => $item->date_submitted,
            'formatted_date' => $date->format('M d, Y h:i A'),
            'resident' => [
                'first_name' => $item->first_name,
                'last_name' => $item->last_name,
                'full_name' => $item->full_name,
            ]
        ];
    });
    
    return response()->json([
        'feedback' => $formattedFeedback,
        'hasMore' => $feedback->hasMorePages(),
        'currentPage' => $feedback->currentPage(),
        'total' => $feedback->total(),
    ]);
});

/* Admin Routes */
Route::middleware('checkRole:Admin')->group(function () {
    Route::get('/admin_dashboard', [AdminController::class, 'dashboard'])->name('admin_dashboard');
    Route::get('/manageusers_admin', [AdminController::class, 'manageUsers'])->name('manageusers_admin');
    Route::post('/manageusers_admin', [AdminController::class, 'storeUser'])->name('manageusers_admin.store');
    Route::put('/manageusers_admin/{user}', [AdminController::class, 'updateUser'])->name('manageusers_admin.update');
    Route::delete('/manageusers_admin/{user}', [AdminController::class, 'destroyUser'])->name('manageusers_admin.destroy');
    Route::get('/website_management', [AdminController::class, 'websiteManagement'])->name('website_management');
    Route::get('/system_settings', [AdminController::class, 'systemSettings'])->name('system_settings');
    
    // ========== ADMIN FEEDBACK ROUTES ==========
    Route::get('/manage_feedback', [EserviceController::class, 'getAllFeedback'])->name('admin.manage_feedback');
});