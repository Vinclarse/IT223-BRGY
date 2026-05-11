<?php

namespace App\Http\Controllers;

use App\Models\BarangayOfficial;
use Illuminate\Http\Request;

class BarangayOfficialController extends Controller
{
    public function about()
    {
        $officials = BarangayOfficial::where('status', 'Active')->get();

        return view('about', compact('officials'));
    }
     public function about_guest()
    {
        $officials = BarangayOfficial::where('status', 'Active')->get();

        return view('about_guest', compact('officials'));
    }
}
