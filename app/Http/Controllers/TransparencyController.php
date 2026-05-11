<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TransparencyReport;
use Illuminate\Support\Facades\DB;


class TransparencyController extends Controller
{
    // GET /transparency_records
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        $category = $request->query('category', null);

        $query = TransparencyReport::query();

        if ($q !== '') {
            $query->where(function ($qr) use ($q) {
                $qr->where('title', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($category && $category !== '') {
            $query->where('category', $category);
        }

        $reports = $query->orderBy('report_date', 'desc')->paginate(10)->appends($request->query());

        $categories = TransparencyReport::distinct()->pluck('category');

        return view('transparency_records', [
            'reports' => $reports,
            'q' => $q,
            'category' => $category,
            'categories' => $categories,
        ]);
    }


    public function transparency()
    {
        $reports = DB::table('transparency_report')
            ->orderBy('report_date', 'desc')
            ->get();

        return view('transparency', compact('reports'));
    }

    public function transparency_guest()
    {
        $reports = DB::table('transparency_report')
            ->orderBy('report_date', 'desc')
            ->get();

        return view('transparency_guest', compact('reports'));
    }

    // POST /transparency_records
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'report_date' => 'required|date',
        ]);

        $report = TransparencyReport::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
            'report_date' => $request->input('report_date'),
        ]);

        if ($request->wantsJson()) {
            return response()->json($report, 201);
        }

        return back()->with('success', 'Report added successfully.');
    }

    // DELETE /transparency_records/{id}
    public function destroy($reportId)
    {
        TransparencyReport::where('report_id', $reportId)->delete();

        if (request()->wantsJson()) {
            return response()->json(['deleted' => true]);
        }

        return back()->with('success', 'Report deleted.');
    }

    // Debug / API helper: return JSON list (no auth) to verify data fetch
    public function data(Request $request)
    {
        $q = trim($request->query('q', ''));
        $category = $request->query('category', null);

        $query = TransparencyReport::query();

        if ($q !== '') {
            $query->where(function ($qr) use ($q) {
                $qr->where('title', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($category && $category !== '') {
            $query->where('category', $category);
        }

        $reports = $query->orderBy('report_date', 'desc')->limit(200)->get();

        return response()->json($reports);
    }


}
