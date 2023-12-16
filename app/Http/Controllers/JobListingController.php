<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobListingController extends Controller
{
    public function index(Request $request) {
        $salary = $request->query('salary');
        $date = $request->query('date');
        $jobType = $request->query('job_type');

        $listings = Listing::query();

        switch ($salary) {
            case 'high_to_low':
                $listings = $listings->orderBy(DB::raw('CAST(salary AS UNSIGNED)'), 'desc');
                break;
            case 'low_to_high':
                $listings = $listings->orderBy(DB::raw('CAST(salary AS UNSIGNED)'), 'asc');
                break;
        }

        switch ($date) {
            case 'newest':
                $listings = $listings->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $listings = $listings->orderBy('created_at', 'asc');
                break;
        }

        switch ($jobType) {
            case 'fulltime':
                $listings = $listings->where('job_type', 'fulltime');
                break;
            case 'parttime':
                $listings = $listings->where('job_type', 'parttime');
                break;
            case 'remote':
                $listings = $listings->where('job_type', 'remote');
                break;
        }

        $jobs = $listings->with('profile')->get();
        return view('home', compact('jobs'));
    }

    public function view(Listing $listing) {
        return view('view', compact('listing'));
    }

    public function uploadCover(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('coverletters', 'public');
            return response()->json(['success' => true, 'file' => $file]);
        }

        return response()->json(['success' => true, 'message' => 'File upload failed']);
    }
}
