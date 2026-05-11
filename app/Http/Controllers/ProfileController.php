<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        // Get user from session
        $user = Session::get('user');
        
        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }
        
        $userData = null;
        
        // First, get the user account data
        $userAccount = DB::table('user_account')
            ->where('user_id', $user['user_id'])
            ->first();
            
        if (!$userAccount) {
            return redirect()->route('login')->with('error', 'User account not found.');
        }
        
        // Get additional user data based on role
        if ($user['role'] === 'Resident') {
            $userData = DB::table('resident')
                ->where('user_id', $user['user_id'])
                ->first();
                
            if ($userData) {
                $userData->email = $userAccount->email;
            }
                
        } elseif ($user['role'] === 'Official') {
            $userData = DB::table('barangay_official')
                ->where('user_id', $user['user_id'])
                ->first();
                
            if ($userData) {
                $userData->email = $userAccount->email;
            }
                
        } elseif ($user['role'] === 'Admin') {
            $userData = $userAccount;
        }
        
        return view('profile', [
            'user' => $user,
            'userData' => $userData,
            'userAccount' => $userAccount,
            'editMode' => false // Default view mode
        ]);
    }

    public function edit()
    {
        // Get user from session
        $user = Session::get('user');
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }
        
        $userData = null;
        $userAccount = DB::table('user_account')
            ->where('user_id', $user['user_id'])
            ->first();
            
        if (!$userAccount) {
            return redirect()->route('login')->with('error', 'User account not found.');
        }
        
        if ($user['role'] === 'Resident') {
            $userData = DB::table('resident')
                ->where('user_id', $user['user_id'])
                ->first();
                
            if ($userData) {
                $userData->email = $userAccount->email;
            }
                
        } elseif ($user['role'] === 'Official') {
            $userData = DB::table('barangay_official')
                ->where('user_id', $user['user_id'])
                ->first();
                
            if ($userData) {
                $userData->email = $userAccount->email;
            }
                
        } elseif ($user['role'] === 'Admin') {
            $userData = $userAccount;
        }
        
        return view('profile', [
            'user' => $user,
            'userData' => $userData,
            'userAccount' => $userAccount,
            'editMode' => true // Edit mode
        ]);
    }

    public function update(Request $request)
    {
        // Get user from session
        $user = Session::get('user');
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }
        
        // Validation rules based on role
        if ($user['role'] === 'Resident') {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:50',
                'middle_name' => 'nullable|string|max:50',
                'last_name' => 'required|string|max:50',
                'sex' => 'required|in:Male,Female',
                'address' => 'required|string|max:150',
                'contact_number' => 'required|string|max:20',
                'birth_date' => 'required|date',
            ]);
            
        } elseif ($user['role'] === 'Official') {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:50',
                'middle_name' => 'nullable|string|max:50',
                'last_name' => 'required|string|max:50',
                'position' => 'required|string|max:100',
                'address' => 'required|string|max:150',
                'contact_number' => 'required|string|max:20',
            ]);
            
        } elseif ($user['role'] === 'Admin') {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:100',
            ]);
        }
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('editMode', true);
        }
        
        // Update based on role
        if ($user['role'] === 'Resident') {
            DB::table('resident')
                ->where('user_id', $user['user_id'])
                ->update([
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'sex' => $request->sex,
                    'address' => $request->address,
                    'contact_number' => $request->contact_number,
                    'birth_date' => $request->birth_date,
                ]);
                
        } elseif ($user['role'] === 'Official') {
            DB::table('barangay_official')
                ->where('user_id', $user['user_id'])
                ->update([
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'position' => $request->position,
                    'address' => $request->address,
                    'contact_number' => $request->contact_number,
                ]);
                
        } elseif ($user['role'] === 'Admin') {
            DB::table('user_account')
                ->where('user_id', $user['user_id'])
                ->update([
                    'email' => $request->email,
                ]);
        }
        
        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        // Get user from session
        $user = Session::get('user');
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }
        
        // Validation
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Current password is required',
            'new_password.required' => 'New password is required',
            'new_password.min' => 'New password must be at least 6 characters',
            'new_password.confirmed' => 'New password confirmation does not match',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('profile')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Get user account
        $userAccount = DB::table('user_account')
            ->where('user_id', $user['user_id'])
            ->first();
            
        if (!$userAccount) {
            return redirect()->route('profile')
                ->with('error', 'User account not found.');
        }
        
        // Check current password
        if ($userAccount->password !== $request->current_password) {
            return redirect()->route('profile')
                ->with('error', 'Current password is incorrect.')
                ->withInput();
        }
        
        // Update password
        DB::table('user_account')
            ->where('user_id', $user['user_id'])
            ->update([
                'password' => $request->new_password,
            ]);
        
        return redirect()->route('profile')
            ->with('success', 'Password changed successfully!');
    }
}