<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobEditRequest;
use App\Http\Requests\JobPostRequest;
use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('job.create');
    }

    public function index()
    {
        $listings = Listing::where('user_id', auth()->user()->id)->get();
        return view('job.index', compact('listings'));
    }

    public function store(JobPostRequest $request)
    {
        $date = Carbon::parse($request->due)->format('Y-m-d');
        $imgPath = $request->file('featured_image')->store('images', 'public');

        $job = new Listing;
        $job->feature_image = $imgPath;
        $job->user_id = auth()->user()->id;
        $job->title = $request->title;
        $job->description = $request->description;
        $job->roles = $request->roles;
        $job->job_type = $request->job_type;
        $job->address = $request->address;
        $job->salary = $request->salary;
        $job->application_close_date = $date;
        $job->slug = Str::slug($request->title) . '.' . Str::uuid();
        $job->save();

        return back()->with('success', 'Job Created Successfully');
    }

    public function edit(Listing $listing)
    {
        return view('job.edit', compact('listing'));
    }

    public function update(JobEditRequest $request, $id)
    {
        if ($request->hasFile('featured_image')) {
            $imgPath = $request->file('featured_image')->store('images', 'public');
            Listing::find($id)->update(['feature_image' => $imgPath]);
        }
        $date = Carbon::parse($request->due)->format('Y-m-d');
        Listing::find($id)->update(['application_close_date' => $date]);
        Listing::find($id)->update($request->except('feature_image'));
        return back()->with('success', 'Job Updated Successfully');
    }

    public function remove($id){
        Listing::find($id)->delete();
        return back()->with('success', 'Job Deleted Successfully');
    }
}
