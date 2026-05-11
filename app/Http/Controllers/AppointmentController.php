<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /* =========================================================
       SHOW APPOINTMENTS + FEEDBACK (OFFICIAL VIEW)
    ========================================================= */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $status = $request->query('status');

        $query = DB::table('appointment as a')
            ->leftJoin('resident as r', 'a.resident_id', '=', 'r.resident_id')
            ->leftJoin('barangay_official as o', 'a.official_id', '=', 'o.official_id')
            ->select(
                'a.appointment_id',
                'a.resident_id',
                'a.official_id',
                'a.appointment_date',
                'a.purpose',

                // ✅ NULL-SAFE DESCRIPTION
                DB::raw("COALESCE(a.description, '') as description"),

                'a.status',
                DB::raw("CONCAT(r.first_name, ' ', r.last_name) as resident_full_name"),
                'r.email as resident_email',
                'r.contact_number as resident_contact',
                'o.full_name as official_full_name',
                'o.position as official_position'
            );

        if (!empty($q)) {
            $query->where(function ($query) use ($q) {
                $query->where('r.first_name', 'like', "%{$q}%")
                    ->orWhere('r.last_name', 'like', "%{$q}%")
                    ->orWhere('a.appointment_id', 'like', "%{$q}%")
                    ->orWhere('a.purpose', 'like', "%{$q}%")
                    ->orWhere('o.full_name', 'like', "%{$q}%");
            });
        }

        if (!empty($status)) {
            $query->where('a.status', $status);
        }

        $appointments = $query->orderBy('a.appointment_date', 'desc')->paginate(10);

        // ✅ Fetch verified residents only
        $residents = DB::table('resident')
            ->where('status', 'Verified')
            ->orderBy('first_name')
            ->get();

        // ✅ Feedback (also NULL SAFE)
        $feedbacks = DB::table('feedback as f')
            ->leftJoin('resident as r', 'f.resident_id', '=', 'r.resident_id')
            ->select(
                'f.*',
                DB::raw("CONCAT(r.first_name, ' ', r.last_name) as full_name")
            )
            ->orderBy('f.date_submitted', 'desc')
            ->limit(20)
            ->get();

        return view('appointments_feedback', compact(
            'appointments',
            'feedbacks',
            'q',
            'status',
            'residents'
        ));
    }

    /* =========================================================
       UPDATE STATUS ONLY
    ========================================================= */
    public function updateStatus(Request $request, $appointment_id)
    {
        $validated = $request->validate([
            'status' => 'required|string'
        ]);

        DB::table('appointment')
            ->where('appointment_id', $appointment_id)
            ->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Appointment status updated.');
    }

    /* =========================================================
       UPDATE APPOINTMENT (SAFE FOR NULL)
    ========================================================= */
    public function update(Request $request, $appointment_id)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date',
            'purpose'          => 'nullable|string|max:100',
            'description'       => 'nullable|string|max:500',
            'status'            => 'nullable|string'
        ]);

        $data = [
            'appointment_date' => $validated['appointment_date'],

            // ✅ NULL SAFE
            'purpose' => $request->filled('purpose') ? $validated['purpose'] : null,
            'description' => $request->filled('description') ? $validated['description'] : null,
        ];

        if (!empty($validated['status'])) {
            $data['status'] = $validated['status'];
        }

        DB::table('appointment')
            ->where('appointment_id', $appointment_id)
            ->update($data);

        return redirect()->back()->with('success', 'Appointment updated successfully.');
    }

    /* =========================================================
       DELETE APPOINTMENT
    ========================================================= */
    public function destroy($appointment_id)
    {
        DB::table('appointment')
            ->where('appointment_id', $appointment_id)
            ->delete();

        return redirect()->back()->with('success', 'Appointment deleted.');
    }

    /* =========================================================
       DELETE FEEDBACK
    ========================================================= */
    public function destroyFeedback($feedback_id)
    {
        DB::table('feedback')
            ->where('feedback_id', $feedback_id)
            ->delete();

        return redirect()->back()->with('success', 'Feedback deleted.');
    }

    /* =========================================================
       STORE NEW APPOINTMENT (NULL SAFE)
    ========================================================= */
    public function store(Request $request)
    {
        $request->validate([
            'resident_id'       => 'required|exists:resident,resident_id',
            'appointment_date'  => 'required|date',
            'purpose'            => 'required|string|max:100',
            'description'        => 'nullable|string|max:500',
            'status'             => 'required|in:Pending,Confirmed,Completed,Cancelled',
        ]);

        // ✅ Get official ID from session
        $official_id = session('user.official_id');

        if (!$official_id) {
            return redirect()->back()
                ->with('error', 'Official ID not found. Please log in again.')
                ->withInput();
        }

        DB::table('appointment')->insert([
            'resident_id'      => $request->resident_id,
            'official_id'      => $official_id,
            'appointment_date' => $request->appointment_date,
            'purpose'           => $request->purpose,

            // ✅ NULL SAFE DESCRIPTION
            'description'       => $request->filled('description') ? $request->description : null,

            'status'            => $request->status,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->route('appointments_feedback')
            ->with('success', 'Appointment created successfully!');
    }
}
