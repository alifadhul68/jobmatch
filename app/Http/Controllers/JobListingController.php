<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index() {
        $jobs = Listing::with('profile')->get();
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
