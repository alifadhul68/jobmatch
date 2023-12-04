<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function create(){
        return view('job.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|min:5',
            'featured_image' => 'required|mimes:png,jpeg,jpg|max:2048',
            'description' => 'required|min:200',
            'roles' => 'required',
            'job_type' => 'required',
            'address' => 'required',
            'salary' => 'required',
            'due' => 'required',
        ]);

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
        $job->application_close_date = Carbon::createFromFormat('d/m/Y', $request->due)->format('Y-m-d');
        $job->slug = Str::slug($request->title).'.'.Str::uuid();
        $job->save();
        return back()->with('success', 'Job Created Successfully');
    }
}
