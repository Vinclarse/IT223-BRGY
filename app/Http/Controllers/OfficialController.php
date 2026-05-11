<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OfficialController extends Controller
{
    public function dashboard()
    {
        // Requests counts (pending / completed)
        $hasRequestTable = Schema::hasTable('request');

        $pendingRequests = 0;
        $completedRequests = 0;
        $recentRequests = collect();

        if ($hasRequestTable) {
            $pendingRequests = Schema::hasColumn('request', 'status')
                ? DB::table('request')->where('status', 'Pending')->count()
                : DB::table('request')->count();

            $completedRequests = Schema::hasColumn('request', 'status')
                ? DB::table('request')->whereIn('status', ['Completed', 'Complete'])->count()
                : 0;

            $recentRequests = DB::table('request')
                ->orderBy('request_date', 'desc')
                ->limit(5)
                ->get();

            // Enrich recent requests with resident/service names if possible
            $hasResident = Schema::hasTable('resident');
            $hasService = Schema::hasTable('service');

            $recentRequests = $recentRequests->map(function ($r) use ($hasResident, $hasService) {
                $r->resident_name = null;
                $r->service_name = null;

                if ($hasResident && isset($r->resident_id)) {
                    $res = DB::table('resident')->where('resident_id', $r->resident_id)->first();
                    if ($res) {
                        if (isset($res->full_name) && $res->full_name) {
                            $r->resident_name = $res->full_name;
                        } elseif (isset($res->first_name)) {
                            $parts = array_filter([trim($res->first_name ?? ''), trim($res->middle_name ?? ''), trim($res->last_name ?? '')]);
                            $r->resident_name = $parts ? implode(' ', $parts) : null;
                        } else {
                            $r->resident_name = $res->name ?? null;
                        }
                    }
                }

                if ($hasService && isset($r->service_id)) {
                    $srv = DB::table('request')->where('service_id', $r->service_id)->first();
                    if ($srv) {
                        $r->service_name = $srv->name ?? $srv->title ?? ($srv->service_name ?? null);
                    }
                }

                return $r;
            });
        }

        // Verified residents
        $verifiedResidents = 0;
        if (Schema::hasTable('resident')) {
            if (Schema::hasColumn('resident', 'status')) {
                $verifiedResidents = DB::table('resident')->where('status', 'Verified')->count();
            } else {
                $verifiedResidents = DB::table('resident')->count();
            }
        }

        // Active announcements
        $activeAnnouncements = 0;
        if (Schema::hasTable('announcement')) {
            if (Schema::hasColumn('announcement', 'status')) {
                $activeAnnouncements = DB::table('announcement')->where('status', 'Active')->count();
            } else {
                $activeAnnouncements = DB::table('announcement')->count();
            }
        }

        // Appointments statistics
        $pendingAppointments = 0;
        $totalAppointments = 0;
        $recentAppointments = collect();
        if (Schema::hasTable('appointment')) {
            $pendingAppointments = DB::table('appointment')->where('status', 'Pending')->count();
            $totalAppointments = DB::table('appointment')->count();
            
            $recentAppointments = DB::table('appointment')
                ->leftJoin('resident', 'appointment.resident_id', '=', 'resident.resident_id')
                ->leftJoin('barangay_official', 'appointment.official_id', '=', 'barangay_official.official_id')
                ->select(
                    'appointment.*',
                    DB::raw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) as resident_name"),
                    'barangay_official.full_name as official_name'
                )
                ->orderBy('appointment.created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Complaints statistics
        $pendingComplaints = 0;
        $totalComplaints = 0;
        $recentComplaints = collect();
        if (Schema::hasTable('complaint')) {
            $pendingComplaints = DB::table('complaint')->where('status', 'Pending')->count();
            $totalComplaints = DB::table('complaint')->count();
            
            $recentComplaints = DB::table('complaint')
                ->leftJoin('resident', 'complaint.resident_id', '=', 'resident.resident_id')
                ->select(
                    'complaint.*',
                    DB::raw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) as resident_name")
                )
                ->orderBy('complaint.date_filed', 'desc')
                ->limit(5)
                ->get();
        }

        // Events statistics
        $upcomingEvents = 0;
        $totalEvents = 0;
        $recentEvents = collect();
        if (Schema::hasTable('events')) {
            $totalEvents = DB::table('events')->count();
            $upcomingEvents = DB::table('events')
                ->where('event_date', '>=', now()->toDateString())
                ->count();
            
            $recentEvents = DB::table('events')
                ->orderBy('event_date', 'asc')
                ->limit(5)
                ->get();
        }

        // Total residents
        $totalResidents = 0;
        if (Schema::hasTable('resident')) {
            $totalResidents = DB::table('resident')->count();
        }

        return view('official_dashboard', compact(
            'pendingRequests',
            'completedRequests',
            'verifiedResidents',
            'activeAnnouncements',
            'recentRequests',
            'pendingAppointments',
            'totalAppointments',
            'recentAppointments',
            'pendingComplaints',
            'totalComplaints',
            'recentComplaints',
            'upcomingEvents',
            'totalEvents',
            'recentEvents',
            'totalResidents'
        ));
    }
}
