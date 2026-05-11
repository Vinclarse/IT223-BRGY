<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required'
        ]);

        $email    = trim($request->email);
        $password = trim($request->password);
        $role     = trim($request->role);

        // Check if email exists
        $userByEmail = DB::table('user_account')
            ->where('email', $email)
            ->first();

        if (!$userByEmail) {
            return redirect()->route('login', ['role' => $role])
                ->with('error', 'No account found with that email.')
                ->withInput();
        }

        // Check if account is active
        if (isset($userByEmail->status) && $userByEmail->status !== 'Active') {
            return redirect()->route('login', ['role' => $role])
                ->with('error', 'Account is not active.')
                ->withInput();
        }

        // Check password
        if (!isset($userByEmail->password) || $userByEmail->password !== $password) {
            return redirect()->route('login', ['role' => $role])
                ->with('error', 'Incorrect password.')
                ->withInput();
        }

        // Check role match
        if (isset($userByEmail->role) && $userByEmail->role !== $role) {
            return redirect()->route('login', ['role' => $role])
                ->with('error', 'Unauthorized role for this account.')
                ->withInput();
        }

        $user = $userByEmail;

        // If Resident, check verification
        if ($role === 'Resident') {
            $resident = DB::table('resident')
                ->where('user_id', $user->user_id)
                ->first();

            if (!$resident) {
                return redirect()->route('login', ['role' => $role])
                    ->with('error', 'No resident record found for this account.')
                    ->withInput();
            }

            if (!isset($resident->status) || $resident->status !== 'Verified') {
                return redirect()->route('login', ['role' => $role])
                    ->with('error', 'Account not verified yet. Please wait for verification.')
                    ->withInput();
            }
        }
        
        // If Official, get the official_id from barangay_official table
        $official_id = null;
        if ($role === 'Official') {
            $official = DB::table('barangay_official')
                ->where('user_id', $user->user_id)
                ->first();
                
            if ($official) {
                // Check for different possible ID column names
                if (isset($official->official_id)) {
                    $official_id = $official->official_id;
                } elseif (isset($official->id)) {
                    $official_id = $official->id;
                } elseif (isset($official->barangay_official_id)) {
                    $official_id = $official->barangay_official_id;
                }
            }
        }

        // Create session data array
        $sessionData = [
            'user_id' => $user->user_id,
            'role'    => $user->role,
            'email'   => $user->email,
        ];
        
        // Add official_id to session if available
        if ($official_id) {
            $sessionData['official_id'] = $official_id;
        }

        session(['user' => $sessionData]);

        // Redirect based on role
        if ($user->role === 'Admin') {
            return redirect('/admin_dashboard');
        } 
        elseif ($user->role === 'Official') {
            return redirect('/official_dashboard');
        } 
        else {
            return redirect('/resident_dashboard');
        }
    }

    public function logout()
    {
        session()->forget('user');

        return redirect('/profile_guest')->with('success', 'You have been logged out.');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'first_name'      => 'required|string|max:100',
            'middle_name'     => 'nullable|string|max:100',
            'last_name'       => 'required|string|max:100',
            'sex'              => 'nullable|in:Male,Female',
            'address'          => 'required|string|max:500',
            'contact_number'   => 'required|string|max:50',
            'email'            => 'required|email|max:255',
            'password'         => 'required|string|min:4|confirmed',
            'birth_date'       => 'nullable|date',
        ]);

        $email = trim($request->email);

        // Check if email already exists
        $existing = DB::table('user_account')->where('email', $email)->first();
        if ($existing) {
            return back()->with('error', 'An account with that email already exists.')->withInput();
        }

        DB::beginTransaction();

        try {
            $now = now();

            // Detect if user_id is numeric
            $userIdIsNumeric = false;
            try {
                $col = DB::selectOne("
                    SELECT DATA_TYPE, EXTRA 
                    FROM information_schema.COLUMNS 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'user_account' 
                    AND COLUMN_NAME = 'user_id'
                ");

                if ($col) {
                    $dataType = strtolower($col->DATA_TYPE ?? '');
                    $extra    = strtolower($col->EXTRA ?? '');

                    if (in_array($dataType, ['int', 'integer', 'bigint', 'smallint', 'mediumint']) 
                        || str_contains($extra, 'auto_increment')) {
                        $userIdIsNumeric = true;
                    }
                }
            } catch (\Throwable $e) {
                if (Schema::hasColumn('user_account', 'user_id')) {
                    $colType = Schema::getColumnType('user_account', 'user_id');
                    $userIdIsNumeric = in_array($colType, ['integer', 'bigInteger', 'bigint', 'int']);
                }
            }

            // Insert user account
            if ($userIdIsNumeric) {
                $userId = DB::table('user_account')->insertGetId([
                    'email'        => $email,
                    'password'     => $request->password,
                    'role'          => 'Resident',
                    'date_created'  => $now,
                    'status'        => 'Active',
                ]);
            } else {
                $userId = 'U' . time() . substr(uniqid(), -4);

                DB::table('user_account')->insert([
                    'user_id'      => $userId,
                    'email'        => $email,
                    'password'     => $request->password,
                    'role'          => 'Resident',
                    'date_created'  => $now,
                    'status'        => 'Active',
                ]);
            }

            // Prepare resident data
            $residentPayload = [
                'user_id'         => $userId,
                'first_name'      => $request->first_name,
                'middle_name'     => $request->middle_name,
                'last_name'       => $request->last_name,
                'sex'              => $request->sex,
                'address'          => $request->address,
                'contact_number'   => $request->contact_number,
                'email'            => $email,
                'birth_date'       => $request->birth_date,
                'date_registered'  => $now,
                'status'           => 'Pending'
            ];

            // Detect if resident_id is numeric
            $residentIdIsNumeric = false;

            try {
                $rcol = DB::selectOne("
                    SELECT DATA_TYPE, EXTRA 
                    FROM information_schema.COLUMNS 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'resident' 
                    AND COLUMN_NAME = 'resident_id'
                ");

                if ($rcol) {
                    $rDataType = strtolower($rcol->DATA_TYPE ?? '');
                    $rExtra    = strtolower($rcol->EXTRA ?? '');

                    if (in_array($rDataType, ['int', 'integer', 'bigint', 'smallint', 'mediumint']) 
                        || str_contains($rExtra, 'auto_increment')) {
                        $residentIdIsNumeric = true;
                    }
                }
            } catch (\Throwable $e) {
                if (Schema::hasColumn('resident', 'resident_id')) {
                    $rColType = Schema::getColumnType('resident', 'resident_id');
                    $residentIdIsNumeric = in_array($rColType, ['integer', 'bigInteger', 'bigint', 'int']);
                }
            }

            if ($residentIdIsNumeric) {
                DB::table('resident')->insert($residentPayload);
            } else {
                $residentId = 'RES' . time() . substr(uniqid(), -4);
                $residentPayload['resident_id'] = $residentId;

                DB::table('resident')->insert($residentPayload);
            }

            DB::commit();

            return redirect()->route('login', ['role' => 'Resident'])
                ->with('success', 'Account created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to create account: ' . $e->getMessage())->withInput();
        }
    }
}