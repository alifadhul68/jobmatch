@extends('layouts.app')

@section('content')

    <div class="container py-4">
        <h1>Company Profile</h1>

        <!-- Company Information -->
        <div class="row mt-5 mb-4 align-items-center">
            <div class="col-md-3 text-center">
                <img src="{{ Storage::url($company->profile_pic) }}" alt="Company Logo" class="rounded-circle" style="max-width: 150px;">
            </div>
            <div class="col-md-9">
                <h2 class="mb-0">{{ $company->name }}</h2>
            </div>
        </div>
        @if ($company->about)
            <div class="row mt-5 mb-4 w-100">
                <div class="col-md-3">
                    <h3>About</h3>
                    <p class="lead text-muted">{{ $company->about }}</p>
                </div>
            </div>
        @endif
        <!-- Job Listings -->
        <div class="row">
            <div class="col-md-8">
                <h3>List of Jobs</h3>
                @forelse($company->jobs as $job)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $job->title }}</h5>
                            <p class="card-text">{{ $job->address }}</p>
                            <p class="card-text">Salary: ${{ number_format($job->salary, 2) }}</p>
                            <a href="{{ route('job.show', [$job->slug]) }}" class="btn btn-primary">View</a>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No jobs available at the moment.</p>
                @endforelse
            </div>
        </div>
    </div>

@endsection
