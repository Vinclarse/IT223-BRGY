<?php
// app/Http/Controllers/RequestComplaintController.php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\Complaint;
use App\Models\Resident;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RequestComplaintController extends Controller
{
    // ========== DOCUMENT REQUEST METHODS ==========
    
    /**
     * Show the document request form
     */
    public function showRequestForm()
    {
        $resident = null;
        if (Auth::check()) {
            $resident = Resident::where('user_id', Auth::id())->first();
        }
        
        return view('requestDocument', compact('resident'));
    }

    /**
     * Store a new document request
     */
    public function storeDocumentRequest(HttpRequest $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|max:100',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:150',
            'document_type' => 'required|string|max:100',
            'purpose' => 'required|string|max:255',
            'preferred_date' => 'required|date|after:today',
            'supporting_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        try {
            // Get or create resident
            $resident = $this->getOrCreateResident($validated);
            
            // Handle file upload
            $supportingDocumentPath = $this->handleFileUpload($request, 'supporting_document', 'documents');
            
            // Create document request record
            $documentRequest = DocumentRequest::create([
                'resident_id' => $resident->resident_id,
                'request_date' => now()->toDateString(),
                'document_type' => $validated['document_type'],
                'purpose' => $validated['purpose'],
                'preferred_date' => $validated['preferred_date'],
                'submitted_date' => now(),
                'status' => 'Pending',
                'remarks' => 'Submitted on: ' . now()->format('Y-m-d H:i:s'),
                'supporting_document' => $supportingDocumentPath,
            ]);

            return redirect()->route('requestDocument')
                ->with('success', 'Your document request has been submitted successfully! Request ID: #' . $documentRequest->request_id);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show user's document requests
     */
    public function myDocumentRequests()
    {
        $resident = Resident::where('user_id', Auth::id())->first();
        
        if (!$resident) {
            return redirect()->route('requestDocument')
                ->withErrors(['error' => 'Please complete your profile first']);
        }
        
        $documentRequests = DocumentRequest::where('resident_id', $resident->resident_id)
            ->orderBy('submitted_date', 'desc')
            ->get();
        
        return view('my-requests', compact('documentRequests'));
    }

    // ========== COMPLAINT METHODS ==========
    
    /**
     * Show the complaint form
     */
    public function showComplaintForm()
    {
        $resident = null;
        if (Auth::check()) {
            $resident = Resident::where('user_id', Auth::id())->first();
        }
        
        // Use requestDocument view but pass a flag to show complaint form
        return view('requestDocument', compact('resident'));
    }

    /**
     * Store a new complaint
     */
    public function storeComplaint(HttpRequest $request)
    {
        $validated = $request->validate([
            'complainant_name' => 'required|string|max:150',
            'complainant_email' => 'required|email|max:100',
            'complainant_contact' => 'required|string|max:20',
            'subject' => 'required|string|max:500',
            'description' => 'required|string',
            'supporting_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,mp4,mov,avi|max:10240',
        ]);

        try {
            // Get or create resident
            $residentData = [
                'full_name' => $validated['complainant_name'],
                'email' => $validated['complainant_email'],
                'contact_number' => $validated['complainant_contact'],
                'address' => 'Address to be updated', // Default
            ];
            
            $resident = $this->getOrCreateResident($residentData);
            
            // Handle file upload
            $supportingDocumentPath = $this->handleFileUpload($request, 'supporting_document', 'complaints');
            
            // Create complaint record
            // In storeComplaint() method, update the create statement:
            $complaint = Complaint::create([
                'resident_id' => $resident->resident_id,
                'subject' => $validated['subject'],
                'description' => $validated['description'],
                'date_filed' => now(),
                'status' => 'Pending',
                'handled_by' => null, // Explicitly set to null
                'resolution' => null, // Explicitly set to null
                'supporting_document' => $supportingDocumentPath,
            ]);

            return redirect()->route('requestDocument')
                ->with('success', 'Your complaint has been filed successfully! Complaint ID: #' . $complaint->complaint_id);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show user's complaints
     */
    public function myComplaints()
    {
        $resident = Resident::where('user_id', Auth::id())->first();
        
        if (!$resident) {
            return redirect()->route('complaint.create')
                ->withErrors(['error' => 'Please complete your profile first']);
        }
        
        $complaints = Complaint::where('resident_id', $resident->resident_id)
            ->orderBy('date_filed', 'desc')
            ->get();
        
        return view('my-complaints', compact('complaints'));
    }

    // ========== HELPER METHODS ==========
    
    /**
     * Get or create a resident record
     */
    private function getOrCreateResident(array $data)
    {
        $resident = Resident::where('email', $data['email'])->first();
        
        if (!$resident) {
            $names = explode(' ', $data['full_name'], 2);
            $first_name = $names[0] ?? '';
            $last_name = $names[1] ?? '';
            
            $residentData = [
                'last_name' => $last_name,
                'first_name' => $first_name,
                'email' => $data['email'],
                'contact_number' => $data['contact_number'],
                'address' => $data['address'] ?? 'To be updated',
                'date_registered' => now()->toDateString(),
                'status' => 'Pending',
                'user_id' => Auth::id() ?? null,
                'sex' => 'Male',
                'birth_date' => now()->subYears(18)->toDateString(),
                'middle_name' => '',
            ];
            
            $resident = Resident::create($residentData);
        }
        
        return $resident;
    }

    /**
     * Handle file upload
     */
    private function handleFileUpload(HttpRequest $request, string $fieldName, string $folder)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            return $file->storeAs($folder, $filename, 'public');
        }
        
        return null;
    }

    /**
     * Show request success page
     */
    public function showRequestSuccess($id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);
        
        // Check if the request belongs to the authenticated user
        if (Auth::check()) {
            $resident = Resident::where('user_id', Auth::id())->first();
            if ($resident && $documentRequest->resident_id != $resident->resident_id) {
                abort(403, 'Unauthorized access');
            }
        }
        
        return view('requestDocument', compact('documentRequest'));
    }
}