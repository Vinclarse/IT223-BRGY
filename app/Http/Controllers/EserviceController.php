<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EserviceController extends Controller
{
    // ========== MANAGE E-SERVICE REQUESTS ==========
    
    // Manage e-service requests
    public function indexRequests(Request $request)
    {
        $q = trim($request->query('q', ''));
        $status = $request->query('status', null);

        $query = DB::table('request')
            ->join('resident', 'request.resident_id', '=', 'resident.resident_id')
            ->select(
                'request.*', 
                DB::raw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) as full_name"), 
                'resident.email'
            );

        if ($q !== '') {
            $query->where(function ($qr) use ($q) {
                $qr->whereRaw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) LIKE ?", ["%{$q}%"]) 
                   ->orWhere('request.request_id', 'like', "%{$q}%")
                   ->orWhere('request.document_type', 'like', "%{$q}%");
            });
        }

        if ($status && $status !== '') {
            $query->where('request.status', $status);
        }

        $requests = $query->orderBy('request.submitted_date', 'desc')->paginate(10)->appends($request->query());

        return view('manage_e-serbisyo', [
            'requests' => $requests,
            'complaints' => collect(),
            'q' => $q,
            'status' => $status,
            'activeTab' => 'requests'
        ]);
    }

    // Manage complaints
    public function indexComplaints(Request $request)
    {
        $q = trim($request->query('q', ''));
        $status = $request->query('status', null);

        $query = DB::table('complaint')
            ->join('resident', 'complaint.resident_id', '=', 'resident.resident_id')
            ->select('complaint.*', DB::raw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) as full_name"), 'resident.email');

        if ($q !== '') {
            $query->where(function ($qr) use ($q) {
                $qr->whereRaw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) LIKE ?", ["%{$q}%"]) 
                   ->orWhere('complaint.complaint_id', 'like', "%{$q}%")
                   ->orWhere('complaint.subject', 'like', "%{$q}%");
            });
        }

        if ($status && $status !== '') {
            $query->where('complaint.status', $status);
        }

        $complaints = $query->orderBy('complaint.date_filed', 'desc')->paginate(10)->appends($request->query());

        return view('manage_e-serbisyo', [
            'requests' => collect(),
            'complaints' => $complaints,
            'q' => $q,
            'status' => $status,
            'activeTab' => 'complaints'
        ]);
    }

    // Update request status
    public function updateRequestStatus(Request $request, $requestId)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Approved,Rejected'
        ]);

        DB::table('request')->where('request_id', $requestId)->update([
            'status' => $request->input('status'),
            'processed_by' => auth()->id()
        ]);

        return back()->with('success', 'Request status updated.');
    }

    // Update complaint status
    public function updateComplaintStatus(Request $request, $complaintId)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved,Cancelled'
        ]);

        DB::table('complaint')->where('complaint_id', $complaintId)->update([
            'status' => $request->input('status'),
            'handled_by' => auth()->id()
        ]);

        return back()->with('success', 'Complaint status updated.');
    }

    // Delete request
    public function destroyRequest($requestId)
    {
        $requestRecord = DB::table('request')->where('request_id', $requestId)->first();
        
        if ($requestRecord && $requestRecord->supporting_document) {
            Storage::disk('public')->delete($requestRecord->supporting_document);
        }
        
        DB::table('request')->where('request_id', $requestId)->delete();
        
        return back()->with('success', 'Request deleted.');
    }

    // Delete complaint
    public function destroyComplaint($complaintId)
    {
        $complaintRecord = DB::table('complaint')->where('complaint_id', $complaintId)->first();
        
        if ($complaintRecord && $complaintRecord->supporting_document) {
            Storage::disk('public')->delete($complaintRecord->supporting_document);
        }
        
        DB::table('complaint')->where('complaint_id', $complaintId)->delete();
        
        return back()->with('success', 'Complaint deleted.');
    }

    // ========== E-SERBISYO PAGE FOR RESIDENTS ==========
    
    // Show E-Serbisyo page for residents
    public function showESerbisyo()
    {
        // Get recent feedback to display using DB query
        $recentFeedback = DB::table('feedback')
            ->join('resident', 'feedback.resident_id', '=', 'resident.resident_id')
            ->select(
                'feedback.*',
                DB::raw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) as full_name"),
                'resident.first_name',
                'resident.last_name'
            )
            ->orderBy('feedback.date_submitted', 'desc')
            ->take(6)
            ->get();
        
        return view('e-serbisyo', [
            'recentFeedback' => $recentFeedback
        ]);
    }

    // ========== FEEDBACK MANAGEMENT ==========
    
    /**
     * Store new feedback using DB query
     */
    public function storeFeedback(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Get user from session
        $sessionUser = session('user');
        
        if (!$sessionUser || !isset($sessionUser['user_id'])) {
            return back()->with('error', 'Please log in to submit feedback.');
        }

        // Get resident using the user_id from session
        $resident = DB::table('resident')
            ->where('user_id', $sessionUser['user_id'])
            ->first();

        if (!$resident) {
            return back()->with('error', 'Resident profile not found.');
        }

        // Insert feedback using DB query (no Eloquent timestamps)
        DB::table('feedback')->insert([
            'resident_id' => $resident->resident_id,
            'message' => $request->input('message'),
            'rating' => $request->input('rating'),
            'date_submitted' => now(),
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }

    /**
     * Get all feedback (for officials/admin) using DB query
     */
    public function getAllFeedback()
    {
        $feedback = DB::table('feedback')
            ->join('resident', 'feedback.resident_id', '=', 'resident.resident_id')
            ->select(
                'feedback.*',
                DB::raw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) as full_name"),
                'resident.email',
                'resident.first_name',
                'resident.last_name'
            )
            ->orderBy('feedback.date_submitted', 'desc')
            ->paginate(10);
            
        $stats = [
            'total' => DB::table('feedback')->count(),
            'averageRating' => DB::table('feedback')->avg('rating') ? round(DB::table('feedback')->avg('rating'), 1) : 0,
            'fiveStar' => DB::table('feedback')->where('rating', 5)->count(),
            'oneStar' => DB::table('feedback')->where('rating', 1)->count(),
        ];
        
        return view('manage_feedback', compact('feedback', 'stats'));
    }

    /**
     * Delete feedback using DB query
     */
    public function destroyFeedback($id)
    {
        DB::table('feedback')->where('feedback_id', $id)->delete();

        return back()->with('success', 'Feedback deleted successfully.');
    }

    /**
     * Get feedback statistics (for dashboard) using DB query
     */
    public function getFeedbackStats()
    {
        $total = DB::table('feedback')->count();
        $averageRating = DB::table('feedback')->avg('rating');
        $recent = DB::table('feedback')
            ->join('resident', 'feedback.resident_id', '=', 'resident.resident_id')
            ->select(
                'feedback.*',
                DB::raw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) as full_name"),
                'resident.first_name',
                'resident.last_name'
            )
            ->orderBy('feedback.date_submitted', 'desc')
            ->take(5)
            ->get();

        return [
            'total' => $total,
            'averageRating' => $averageRating ? round($averageRating, 1) : 0,
            'recent' => $recent,
        ];
    }
}