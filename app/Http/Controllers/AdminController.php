<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAnnouncements = \DB::table('announcement')->count();
        $totalResidents     = \DB::table('resident')->count();
        $totalOfficials     = \DB::table('barangay_official')->count();
        $totalComplaints    = \DB::table('complaint')->count();

        $hasAuditLog = Schema::hasTable('audit_log');
        $recentActivities = $hasAuditLog
            ? DB::table('audit_log')->orderBy('timestamps', 'desc')->limit(6)->get()
            : collect();

        $hasUserAccount  = Schema::hasTable('user_account');
        $hasUserStatus   = $hasUserAccount && Schema::hasColumn('user_account', 'status');
        $activeAdmins    = $hasUserAccount
            ? DB::table('user_account')
                ->where('role', 'Admin')
                ->when($hasUserStatus, fn ($q) => $q->where('status', 'Active'))
                ->count()
            : 0;
        $inactiveUsers   = $hasUserStatus
            ? DB::table('user_account')->where('status', 'Inactive')->count()
            : 0;

        $hasResidentTable  = Schema::hasTable('resident');
        $hasResidentStatus = $hasResidentTable && Schema::hasColumn('resident', 'status');
        $pendingResidents  = $hasResidentStatus
            ? DB::table('resident')->where('status', 'Pending')->count()
            : 0;

        $openComplaints = (Schema::hasTable('complaint') && Schema::hasColumn('complaint', 'status'))
            ? DB::table('complaint')->whereIn('status', ['Pending', 'Open', 'In Progress', 'Processing'])->count()
            : $totalComplaints;

        try {
            DB::select('select 1');
            $dbStatus = ['label' => 'Connected', 'badge' => 'success'];
        } catch (\Throwable $e) {
            $dbStatus = ['label' => 'Offline', 'badge' => 'danger'];
        }

        $logsToday = $hasAuditLog
            ? DB::table('audit_log')->whereDate('timestamps', now()->toDateString())->count()
            : 0;

        $serverLoadPercent = min(
            100,
            max(
                5,
                $totalResidents > 0
                    ? round(($openComplaints / max(1, $totalResidents)) * 100)
                    : ($openComplaints ? 25 : 10)
            )
        );

        $dashboardStats = [
            'activeAdmins'      => $activeAdmins,
            'inactiveUsers'     => $inactiveUsers,
            'pendingResidents'  => $pendingResidents,
            'logsToday'         => $logsToday,
            'openComplaints'    => $openComplaints,
            'dbStatus'          => $dbStatus,
            'serverLoadPercent' => $serverLoadPercent,
        ];

        return view('admin_dashboard', compact(
            'totalAnnouncements',
            'totalResidents',
            'totalOfficials',
            'totalComplaints',
            'recentActivities',
            'dashboardStats'
        ));
    }

    public function manageUsers(Request $request)
    {
        $query  = $request->input('search');
        $role   = $request->input('role');
        $status = $request->input('status');

        $users = DB::table('user_account')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($inner) use ($query) {
                    $inner->where('email', 'like', "%{$query}%")
                          ->orWhere('user_id', 'like', "%{$query}%");
                });
            })
            ->when($role, fn ($q) => $q->where('role', $role))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderBy('user_id', 'desc')
            ->get();

        $counts = [
            'admins'    => DB::table('user_account')->where('role', 'Admin')->count(),
            'officials' => DB::table('user_account')->where('role', 'Official')->count(),
            'residents' => DB::table('user_account')->where('role', 'Resident')->count(),
            'pendingResidents' => DB::table('resident')->where('status', 'Pending')->count(),
        ];

        return view('manageusers_admin', compact('users', 'counts'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|unique:user_account,email',
            'password' => 'required|string|min:4',
            'role'     => 'required|in:Admin,Official,Resident',
            'status'   => 'required|in:Active,Inactive',
        ]);

        DB::table('user_account')->insert([
            'email'        => $request->email,
            'password'     => $request->password, // existing system stores plain text
            'role'         => $request->role,
            'status'       => $request->status,
            'date_created' => now(),
        ]);

        return redirect()->route('manageusers_admin')->with('success', 'User added.');
    }

    public function updateUser(Request $request, $userId)
    {
        $request->validate([
            'role'   => 'required|in:Admin,Official,Resident',
            'status' => 'required|in:Active,Inactive',
            'password' => 'nullable|string|min:4',
        ]);

        $payload = [
            'role'   => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $payload['password'] = $request->password; // keep in sync with AuthController (plain compare)
        }

        DB::table('user_account')
            ->where('user_id', $userId)
            ->update($payload);

        return redirect()->route('manageusers_admin')->with('success', 'User updated.');
    }

    public function destroyUser($userId)
    {
        DB::table('user_account')->where('user_id', $userId)->delete();

        return redirect()->route('manageusers_admin')->with('success', 'User deleted.');
    }

    public function websiteManagement()
    {
        $events = DB::table('events')->orderBy('event_date', 'desc')->limit(200)->get();
        $announcements = DB::table('announcement')->orderBy('date_posted', 'desc')->limit(200)->get();
        $transparency = DB::table('transparency_report')->orderBy('report_date', 'desc')->limit(100)->get();

        return view('website_management', compact('events', 'announcements', 'transparency'));
    }

    public function systemSettings()
    {
        $adminUsers = DB::table('user_account')->where('role', 'Admin')->orderBy('user_id', 'asc')->get();
        $auditLogs = DB::table('audit_log')->orderBy('timestamps', 'desc')->limit(50)->get();

        $settingsStats = [
            'totalAdmins' => $adminUsers->count(),
            'activeAdmins' => $adminUsers->where('status', 'Active')->count(),
            'logsToday' => $auditLogs->filter(function ($log) {
                return Carbon::parse($log->timestamps)->isToday();
            })->count(),
        ];

        return view('system_settings', compact('adminUsers', 'auditLogs', 'settingsStats'));
    }
}
