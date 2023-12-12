<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ShortlistMail;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApplicantController extends Controller
{
    public function index() {
        $listings = Listing::latest()->withCount('users')->where('user_id', auth()->user()->id)->get();
        return view('applicants.index', compact('listings'));
    }

    public function view(Listing $listing) {
        $this->authorize('view', $listing);
        $listing = Listing::with('users')->where('slug', $listing->slug)->first();
        return view('applicants.view', compact('listing'));
    }

    public function shortlist($listingId, $userId) {
        $listing = Listing::find($listingId);
        $user = User::find($userId);
        if($listing){
            $listing->users()->updateExistingPivot($userId, ['is_shortlisted' => true]);
            Mail::to($user->email)->queue(new ShortlistMail($user->name, $listing->title));
            return back()->with('success', 'Successfully shortlisted applicant');
        }
        return back()->with('error', 'There was an error shortlisting applicant. Please try again later.');
    }

    public function apply($listingId, Request $request) {
        $user = auth()->user();
        $user->listings()->syncWithoutDetaching($listingId);
        $fileData = json_decode($request->get('file'));
        if ($fileData && isset($fileData->file)){
            $filePath = $fileData->file;
            $user->listings()->updateExistingPivot($listingId, ['cover_letter' => $filePath]);
        }
        return back()->with('success', 'Your application has been submitted successfully');
    }
}
