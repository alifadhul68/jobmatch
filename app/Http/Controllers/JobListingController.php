<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JobListingController extends Controller
{
    public function index(Request $request) {
        $jobs = Listing::with('profile')->orderBy('created_at', 'desc')->take(4)->get();
        return view('home', compact('jobs'));
    }

    public function allJobs(Request $request) {
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
        return view('jobs', compact('jobs'));
    }

    public function view(Listing $listing) {
        $applicant = null; // Initialize $applicant as null

        if(auth()->check()){
            $applicant = ListingUser::where('listing_id', $listing->id)
                ->where('user_id', auth()->user()->id)
                ->first(); // Execute the query and get the first result
        }

        // Now, $applicant is either an applicant object or null
        // Pass $applicant to the view in both cases
        return view('view', compact(['listing', 'applicant']));
    }

    public function uploadCover(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('coverletters', 'public');
            return response()->json(['success' => true, 'file' => $file]);
        }

        return response()->json(['success' => true, 'message' => 'File upload failed']);
    }

    public function generatePDF($listingId) {
        $listing = Listing::find($listingId);
        $pdf = PDF::loadView('pdf', compact('listing'));
        $pdfFileName = 'job_' . $listing->title . '.pdf';
        $pdfDirectory = 'public/pdfs/';
        if (!Storage::exists($pdfDirectory)) {
            Storage::makeDirectory($pdfDirectory);
        }
        $pdf->save(storage_path('app/' . $pdfDirectory . $pdfFileName));
        return response()->download(storage_path('app/' . $pdfDirectory . $pdfFileName));
    }
}
