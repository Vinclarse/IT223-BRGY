<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AppointmentComposer
{
    /**
     * Bind appointment data to the view.
     */
    public function compose(View $view)
    {
        // Get logged-in user from session
        $sessionUser = session('user');
        
        // Only for resident users
        if (!$sessionUser || $sessionUser['role'] !== 'Resident') {
            $view->with('appointmentCount', 0);
            $view->with('userAppointments', collect());
            return;
        }

        // Get resident ID
        $resident = DB::table('resident')
            ->where('user_id', $sessionUser['user_id'])
            ->first();
            
        if (!$resident) {
            $view->with('appointmentCount', 0);
            $view->with('userAppointments', collect());
            return;
        }

        // Get ALL appointment count (for total badge)
        $appointmentCount = DB::table('appointment')
            ->where('resident_id', $resident->resident_id)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->count();

        // Get recent appointments (limit to 5 for dropdown)
        $userAppointments = DB::table('appointment')
            ->leftJoin('barangay_official', 'appointment.official_id', '=', 'barangay_official.official_id')
            ->select(
                'appointment.*',
                DB::raw("CONCAT_WS(' ', barangay_official.full_name) as official_full_name")
            )
            ->where('appointment.resident_id', $resident->resident_id)
            ->orderBy('appointment.created_at', 'desc')
            ->limit(5)
            ->get();

        // Share data with the view
        $view->with('appointmentCount', $appointmentCount);
        $view->with('userAppointments', $userAppointments);
    }
}