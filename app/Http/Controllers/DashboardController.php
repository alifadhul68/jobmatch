<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        // Load user, jobs count, listings with users count, and listings with shortlisted count in a single query
        $user = User::withCount('jobs')->where('id', auth()->user()->id)->first();
        $data = Listing::latest()
            ->withCount(['users', 'shortlisted'])
            ->where('user_id', auth()->user()->id)
            ->get();
        $interviewCount = Interview::where('interviewer_id', auth()->user()->id)->count();
        $interviews = Interview::where('interviewer_id', auth()->user()->id)->orderBy('interview_date', 'desc')->get();

        // Calculate applicantsCount and shortlistedCount
        $applicantsCount = $data->sum('users_count');
        $shortlistedCount = $data->sum('shortlisted_count');

        // Retrieve data for "Applicants per day" chart
        $dates = [];
        $counts = [];

        $listingUserCounts = DB::table('listing_user')
            ->selectRaw('DATE(listing_user.created_at) as date, COUNT(*) as count')
            ->join('listings', 'listings.id', '=', 'listing_user.listing_id')
            ->where('listings.user_id', auth()->user()->id)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        foreach ($listingUserCounts as $listingUserCount) {
            $dates[] = $listingUserCount->date;
            $counts[] = $listingUserCount->count;
        }

        $jobListings = Listing::select('id', 'title')
            ->where('user_id', auth()->user()->id)
            ->withCount('users') // Assuming you have defined a relationship named 'applicants'
            ->orderByDesc('users_count')
            ->take(5)
            ->get();

        // Initialize arrays to store job titles and applicant counts
        $jobTitles = [];
        $applicantCounts = [];

        foreach ($jobListings as $jobListing) {
            $jobTitles[] = $jobListing->title; // Store job titles
            $applicantCounts[] = $jobListing->users_count; // Store applicant counts
        }

        //$listings = Listing::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->take(5)->get();
        //dd($jobTitles, $applicantCounts);
        //dd($dates, $counts);
        return view('dashboard', compact('user', 'applicantsCount', 'shortlistedCount', 'dates', 'counts', 'jobTitles', 'applicantCounts', 'interviewCount', 'interviews'));
    }
    public function verify()
    {
        return view('user.verify');
    }

    public function resend(Request $request){
        $user = Auth::user();

        if($user->hasVerifiedEmail()){
            return redirect()->route('home')->with('success', 'Your email was verified');
        }

        $user->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent successfully');
    }
}
