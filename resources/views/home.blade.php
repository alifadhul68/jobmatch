@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h4>Recommended Jobs</h4>
            <button class="btn btn-dark">View</button>
        </div>
        <div class="row mt-2 g-1">
            @foreach ($jobs as $job)
                <div class="col-md-3">
                    <div class="card p-2">
                        <div class="text-right fw-bold">
                            <small>
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
