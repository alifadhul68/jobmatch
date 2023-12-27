<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\InterviewMail;
use App\Mail\ShortlistMail;
use App\Models\Interview;
use App\Models\Listing;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

    public function generatePDF($slug)
    {
        $listing = Listing::where('slug', $slug)->where('user_id', auth()->user()->id)->firstOrFail();

        // Load the view for the PDF and pass the data
        $pdf = PDF::loadView('applicants.pdf', compact('listing'));

        // Generate the PDF file with a unique name
        $pdfFileName = 'job_' . $listing->id . '_applicants.pdf';

        // Define the directory path where the PDF should be saved
        $pdfDirectory = 'public/pdfs/';

        // Check if the directory exists; if not, create it
        if (!Storage::exists($pdfDirectory)) {
            Storage::makeDirectory($pdfDirectory);
        }

        // Save the PDF to the storage directory
        $pdf->save(storage_path('app/' . $pdfDirectory . $pdfFileName));

        // Return a response to download the PDF
        return response()->download(storage_path('app/' . $pdfDirectory . $pdfFileName));
    }

    public function scheduleInterview($listingId, Request $request) {
        $request->validate([
            'interviewTime' => 'required|date|after:today',
            'interviewLocation' => 'required',
        ]);

        $applicantId = $request->applicantId;
        $interviewerId = $request->interviewerId;
        $intervieweeId = $request->intervieweeId;
        $interviewTime = Carbon::parse($request->interviewTime)->format('Y-m-d H:i');
        $interviewLocation = $request->interviewLocation;
        $interviewNotes = $request->interviewNotes;

        $interview = Interview::create([
            'applicant_id' => $applicantId,
            'interviewer_id' => $interviewerId,
            'interviewee_id' => $intervieweeId,
            'interview_date' => $interviewTime,
            'location' => $interviewLocation,
            'notes' => $interviewNotes,
        ]);

        if($interview){
            $user = User::find($intervieweeId);
            $listing = Listing::find($listingId);
            Mail::to($user->email)->queue(new InterviewMail($listing, $interview, $user));
            return back()->with('success', 'Successfully scheduled interview');
        }

        return back()->with('error', 'There was an error scheduling the interview. Please try again later.');
    }
}
