<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user = User::withCount('jobs')->where('id', auth()->user()->id)->first();
        $listings = Listing::latest()->withCount('users')->where('user_id', auth()->user()->id)->get();
        $applicantsCount = $listings->sum('users_count');
        $listingShortlisted = Listing::latest()->withCount('shortlisted')->where('user_id', auth()->user()->id)->get();
        $shortlistedCount = $listingShortlisted->sum('shortlisted_count');
        return view('dashboard', compact(['user', 'applicantsCount', 'shortlistedCount']));
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
