@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h4>Job Listings</h4>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Salary
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{route("jobs", ['salary' => 'high_to_low'])}}" class="dropdown-item">High to Low</a></li>
                    <li><a href="{{route("jobs", ['salary' => 'low_to_high'])}}" class="dropdown-item">Low to High</a></li>
                </ul>
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Date
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{route("jobs", ['date' => 'newest'])}}" class="dropdown-item">Newest</a></li>
                    <li><a href="{{route("jobs", ['date' => 'oldest'])}}" class="dropdown-item">Oldest</a></li>
                </ul>
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Job Type
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{route("jobs", ['job_type' => 'fulltime'])}}" class="dropdown-item">Full Time</a></li>
                    <li><a href="{{route("jobs", ['job_type' => 'parttime'])}}" class="dropdown-item">Part Time</a></li>
                    <li><a href="{{route("jobs", ['job_type' => 'remote'])}}" class="dropdown-item">Remote</a></li>
                </ul>
                <a href="{{ route('jobs') }}" class="btn btn-danger btn-close"></a>
            </div>
        </div>
        <div class="row mt-2 g-1">
            @foreach ($jobs as $job)
                <div class="col-md-3">
                    <div class="card m-3 p-2">
                        <div class="text-right">
                            <small class="badge text-bg-info">
                                @if ($job->job_type == 'fulltime')
                                    Full Time
                                @elseif ($job->job_type == 'remote')
                                    Remote
                                @elseif ($job->job_type == 'parttime')
                                    Part Time
                                @endif
                            </small>
                        </div>
                        <div class="text-center mt-3 p-3">
                            <img src="{{Storage::url($job->profile->profile_pic)}}" alt="Job Image" width="100"
                                 class="rounded-circle">
                            <span class="d-block fw-bold mt-2">{{$job->title}}</span>
                            <hr>
                            <span>{{$job->profile->name}}</span>
                            <div class="d-flex flex-row align-items-center justify-content-center">
                                <small class="ml-1">{{$job->address}}</small>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <span>
                                    @if (is_numeric($job->salary))
                                        ${{number_format($job->salary, 2)}}
                                    @else
                                        {{$job->salary}}
                                    @endif
                                </span>
                                <a href="{{route('job.show', [$job->slug])}}"><button class="btn btn-sm btn-outline-dark">Apply</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <style>
        .card {
            transition: background-color 0.5s ease;
        }

        .card:hover {
            background-color: #efefef;
        }
    </style>
@endsection
