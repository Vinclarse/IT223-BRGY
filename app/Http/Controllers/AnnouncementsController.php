<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AnnouncementsController extends Controller
{
    public function data(Request $request)
    {
        $q = trim($request->query('q', ''));
        $query = Announcement::query();
        if ($q !== '') {
            $query->where('title', 'like', "%{$q}%");
        }
        $ann = $query->orderBy('date_posted', 'desc')->limit(200)->get();

        // Set Philippine timezone
        $phTime = new \DateTimeZone('Asia/Manila');
        
        $ann = $ann->map(function ($a) use ($phTime) {
            try {
                // Parse the date and set to Philippine timezone
                if ($a->date_posted instanceof \Carbon\Carbon) {
                    $carbonDate = $a->date_posted->copy()->setTimezone($phTime);
                } else {
                    $carbonDate = \Carbon\Carbon::parse($a->date_posted, $phTime);
                    
                    // If date_posted is stored as UTC in database, convert it
                    // Assuming your database stores UTC, convert to PH time
                    if ($carbonDate->timezone->getName() !== 'Asia/Manila') {
                        $carbonDate->setTimezone($phTime);
                    }
                }
                
                // Format for API response (ISO string in PH time)
                $a->date_posted = $carbonDate->toIso8601String();
                
                // Format for display in Philippine format
                $timePart = $carbonDate->format('H:i:s');
                if ($timePart === '00:00:00') {
                    // Date only
                    $a->date_posted_display = $carbonDate->format('F j, Y'); // December 3, 2025
                } else {
                    // Date with time
                    $a->date_posted_display = $carbonDate->format('F j, Y, g:i A'); // December 3, 2025, 8:30 PM
                }
                
            } catch (\Exception $e) {
                // Fallback
                $a->date_posted = (string) $a->date_posted;
                $a->date_posted_display = (string) $a->date_posted;
            }
            
            return $a;
        });

        return response()->json($ann);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        // Get user from session
        $user = Session::get('user');
        
        if (!$user) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Authentication required'], 401);
            }
            return back()->with('error', 'Please log in first.');
        }

        // Determine official_id based on user role
        $official_id = null;
        
        if ($user['role'] === 'Official') {
            // Check if official_id exists in session
            if (isset($user['official_id'])) {
                $official_id = $user['official_id'];
            } else {
                try {
                    $official = DB::table('barangay_official')
                        ->where('user_id', $user['user_id'])
                        ->first();
                    
                    if ($official) {
                        if (isset($official->official_id)) {
                            $official_id = $official->official_id;
                        } elseif (isset($official->id)) {
                            $official_id = $official->id;
                        } elseif (isset($official->barangay_official_id)) {
                            $official_id = $official->barangay_official_id;
                        } else {
                            $official_id = $user['user_id'];
                        }
                        
                        Session::put('user.official_id', $official_id);
                    } else {
                        $official_id = $user['user_id'];
                    }
                } catch (\Exception $e) {
                    $official_id = $user['user_id'];
                }
            }
        }

        // Handle date_posted - convert to Philippine time if provided
        $datePosted = null;
        if ($request->input('date_posted')) {
            try {
                // Parse the input date and convert to Philippine time
                $datePosted = \Carbon\Carbon::parse($request->input('date_posted'), 'Asia/Manila');
            } catch (\Exception $e) {
                $datePosted = now('Asia/Manila');
            }
        } else {
            // Use current Philippine time
            $datePosted = now('Asia/Manila');
        }

        $ann = Announcement::create([
            'official_id' => $official_id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category' => $request->input('category'),
            'date_posted' => $datePosted,
        ]);

        if ($request->wantsJson()) return response()->json($ann, 201);
        return back()->with('success', 'Announcement added');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        $ann = Announcement::where('announcement_id', $id)->firstOrFail();
        
        // Check authorization
        $user = Session::get('user');
        if (!$user) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Authentication required'], 401);
            }
            return back()->with('error', 'Please log in first.');
        }

        if ($user['role'] === 'Official') {
            // Get official_id for comparison
            $official_id = $user['official_id'] ?? $user['user_id'];
            
            // Only check if announcement has an official_id
            if ($ann->official_id && $ann->official_id != $official_id) {
                if ($request->wantsJson()) {
                    return response()->json(['error' => 'Unauthorized to update this announcement'], 403);
                }
                return back()->with('error', 'Unauthorized to update this announcement');
            }
        }
        // Admin can update any announcement

        $ann->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category' => $request->input('category'),
            'date_posted' => $request->input('date_posted') ?? $ann->date_posted,
        ]);

        if ($request->wantsJson()) return response()->json($ann);
        return back()->with('success', 'Announcement updated');
    }

    public function destroy($id)
    {
        $ann = Announcement::where('announcement_id', $id)->firstOrFail();
        
        // Check authorization
        $user = Session::get('user');
        if (!$user) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'Authentication required'], 401);
            }
            return back()->with('error', 'Please log in first.');
        }

        if ($user['role'] === 'Official') {
            // Get official_id for comparison
            $official_id = $user['official_id'] ?? $user['user_id'];
            
            // Only check if announcement has an official_id
            if ($ann->official_id && $ann->official_id != $official_id) {
                if (request()->wantsJson()) {
                    return response()->json(['error' => 'Unauthorized to delete this announcement'], 403);
                }
                return back()->with('error', 'Unauthorized to delete this announcement');
            }
        }
        // Admin can delete any announcement

        $ann->delete();
        
        if (request()->wantsJson()) return response()->json(['deleted' => true]);
        return back()->with('success', 'Announcement deleted');
    }
}