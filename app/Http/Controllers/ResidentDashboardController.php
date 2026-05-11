<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ResidentDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // Get user from session instead of Auth facade
        $userSession = session('user');
        
        $residentId = null;
        $userAppointments = [];
        $appointmentCount = 0;

        if ($userSession) {
            // Get resident ID for the logged-in user
            $resident = DB::table('resident')
                ->where('user_id', $userSession['user_id'])
                ->first();
            
            if ($resident) {
                $residentId = $resident->resident_id;
                
                // Fetch user's appointments
                $userAppointments = DB::table('appointment as a')
                    ->leftJoin('barangay_official as o', 'a.official_id', '=', 'o.official_id')
                    ->where('a.resident_id', $residentId)
                    ->orderBy('a.appointment_date', 'desc')
                    ->select(
                        'a.*',
                        'o.full_name as official_full_name'
                    )
                    ->get();

                $appointmentCount = $userAppointments->count();
            }
        }

        return view('resident_dashboard', compact('userAppointments', 'appointmentCount'));
    }

    public function getAppointmentDetails($id)
    {
        $userSession = session('user');
        
        if (!$userSession) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }
        
        // Get resident ID
        $resident = DB::table('resident')
            ->where('user_id', $userSession['user_id'])
            ->first();
        
        if (!$resident) {
            return response()->json(['error' => 'Resident not found'], 404);
        }
        
        // Get appointment details
        $appointment = DB::table('appointment as a')
            ->leftJoin('barangay_official as o', 'a.official_id', '=', 'o.official_id')
            ->where('a.appointment_id', $id)
            ->where('a.resident_id', $resident->resident_id)
            ->select(
                'a.*',
                'o.full_name as official_full_name',
                'o.position as official_position',
                'o.contact_number as official_contact',
                'o.email as official_email'
            )
            ->first();
        
        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
        
        return response()->json($appointment);
    }
}