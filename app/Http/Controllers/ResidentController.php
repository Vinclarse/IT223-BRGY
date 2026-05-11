<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('resident')) {
            return view('manage_residents', [
                'residents' => collect(),
                'q' => '',
                'status' => null,
                'hasStatus' => false,
                'error' => 'Table `resident` not found'
            ]);
        }

        $q = trim($request->query('q', ''));
        $status = $request->query('status', null);
        $hasStatus = Schema::hasColumn('resident', 'status');

        $query = DB::table('resident')
            ->select('resident.*', DB::raw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) as full_name"));

        if ($q !== '') {
            $query->where(function ($qr) use ($q) {
                $qr->where('resident_id', 'like', "%{$q}%")
                    ->orWhereRaw("CONCAT_WS(' ', resident.first_name, resident.middle_name, resident.last_name) LIKE ?", ["%{$q}%"])
                    ->orWhere('address', 'like', "%{$q}%")
                    ->orWhere('contact_number', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($status && $hasStatus) {
            $query->where('status', $status);
        }

        $residents = $query->orderBy('date_registered', 'desc')->paginate(15)->appends($request->query());

        return view('manage_residents', compact('residents', 'q', 'status', 'hasStatus'));
    }

    public function show($resident_id)
    {
        $resident = DB::table('resident')->where('resident_id', $resident_id)->first();
        if (!$resident) {
            return redirect()->route('manage_residents')->with('error', 'Resident not found.');
        }
        return view('show_resident', compact('resident'));
    }

    public function edit($resident_id)
    {
        $resident = DB::table('resident')->where('resident_id', $resident_id)->first();
        if (!$resident) {
            return redirect()->route('manage_residents')->with('error', 'Resident not found.');
        }
        return view('edit_resident', compact('resident'));
    }

    public function update(Request $request, $resident_id)
    {
        $resident = DB::table('resident')->where('resident_id', $resident_id)->first();
        if (!$resident) {
            return redirect()->route('manage_residents')->with('error', 'Resident not found.');
        }

        $hasStatusColumn = Schema::hasColumn('resident', 'status');

        $rules = [
            'user_id' => 'required|integer|exists:user_account,user_id',
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'sex' => 'required|in:Male,Female',
            'address' => 'required|string|max:150',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'birth_date' => 'required|date',
            'date_registered' => 'required|date',
        ];

        if ($hasStatusColumn) {
            $rules['status'] = 'required|in:Pending,Verified,Unverified,Active,Inactive';
        }

        $validated = $request->validate($rules);

        // Normalize values and prepare update payload while keeping nullable fields clearable
        $updatePayload = [
            'user_id' => (int) $validated['user_id'],
            'first_name' => trim($validated['first_name']),
            'middle_name' => isset($validated['middle_name']) ? trim($validated['middle_name']) : null,
            'last_name' => trim($validated['last_name']),
            'sex' => $validated['sex'],
            'address' => trim($validated['address']),
            'contact_number' => trim($validated['contact_number']),
            'email' => $validated['email'] ?? null,
            'birth_date' => $validated['birth_date'],
            'date_registered' => $validated['date_registered'] ?? ($resident->date_registered ?? now()->toDateString()),
        ];

        if ($hasStatusColumn && isset($validated['status'])) {
            $updatePayload['status'] = $validated['status'];
        }

        DB::table('resident')->where('resident_id', $resident_id)->update($updatePayload);

        // If status was changed and user_account table exists, keep user_account.status in sync
        if (isset($updatePayload['status']) && Schema::hasTable('user_account') && Schema::hasColumn('user_account', 'status')) {
            $userId = $updatePayload['user_id'] ?? $resident->user_id ?? null;
            // user_account.status only allows Active/Inactive; avoid truncation warnings
            $accountStatus = in_array($updatePayload['status'], ['Active', 'Inactive'], true)
                ? $updatePayload['status']
                : null;

            if ($userId && $accountStatus) {
                DB::table('user_account')->where('user_id', $userId)->update(['status' => $accountStatus]);
            }
        }

        return redirect()->route('manage_residents')->with('success', 'Resident updated successfully.');
    }

    public function destroy($resident_id)
    {
        DB::table('resident')->where('resident_id', $resident_id)->delete();
        return redirect()->route('manage_residents')->with('success', 'Resident deleted successfully.');
    }
}
