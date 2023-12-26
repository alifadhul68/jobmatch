@extends('layouts.admin.main')

@section('content')
    <div class="container mt-5">

        <div class="row justify-content-center">
            @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">{{Session::get('error')}}</div>
            @endif
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-2">
                        @if(auth()->user()->bill_end)
                            @if(auth()->user()->bill_end > auth()->user()->user_trial)
                                <p><b>Your subscription {{now()->format('Y-m-d') > auth()->user()->bill_end ? 'ended': 'ends'}}
                                        on: {{ auth()->user()->bill_end }}</b></p>
                            @else
                                <p><b>Your free trial {{now()->format('Y-m-d') > auth()->user()->user_trial ? 'ended': 'ends'}}
                                        on: {{ auth()->user()->user_trial }}</b></p>
                            @endif
                        @else
                            <p><b>Your free trial {{now()->format('Y-m-d') > auth()->user()->user_trial ? 'ended': 'ends'}}
                                    on: {{ auth()->user()->user_trial }}</b></p>
                        @endif
                    </ol>
                    <div class="row mb-3">

                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card custom">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex justify-content-between">
                                            <div class="media-body text-right">
                                                <h3>{{$user->jobs_count}}</h3>
                                                <span>Posted Jobs</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-note text-info font-large-2 fa-3x float-left"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card custom">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex justify-content-between">
                                            <div class="media-body text-right">
                                                <h3>{{$applicantsCount}}</h3>
                                                <span>Applicants</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-users text-info fa-3x float-left"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card custom">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex justify-content-between">
                                            <div class="media-body text-right">
                                                <h3>{{$shortlistedCount}}</h3>
                                                <span>Shortlisted candidates</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-pin text-info font-large-2 fa-3x float-left"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card custom">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex justify-content-between">
                                            <div class="media-body text-right">
                                                <h3>{{ $interviewCount }}</h3>
                                                <span>Interviews scheduled</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-calendar text-info font-large-2 fa-3x float-left"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Applicants per day
                                </div>
                                <div class="card-body">
                                    <canvas id="myAreaChart" width="100%" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Applicants per job
                                </div>
                                <div class="card-body chart-container">
                                    <canvas id="myBarChart" width="100%" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Interviews
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                <tr>
                                    <th>Interviewee Name</th>
                                    <th>Applied For</th>
                                    <th>Interview Date</th>
                                    <th>Interview Location</th>
                                    <th>Interview Notes</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Interviewee Name</th>
                                    <th>Applied For</th>
                                    <th>Interview Date</th>
                                    <th>Interview Location</th>
                                    <th>Interview Notes</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($interviews as $interview)
                                    <tr>
                                        <td>{{$interview->interviewee->name}}</td>
                                        <td>{{$interview->listing->title}}</td>
                                        <td>{{$interview->interview_date}}</td>
                                        <td>{{$interview->location}}</td>
                                        <td>{{$interview->notes}}</td>
                                        <td>{{ $interview->interview_date > \Carbon\Carbon::now() ? 'Upcoming' : 'Passed' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>


        </div>
    </div>
    <style>
        .custom {
            border-bottom: 4px solid #0074d9;
        }
    </style>
    <script>
        var chartData = {
            dates: @json($dates),
            counts: @json($counts),
        };
        var barData = {
            jobs: @json($jobTitles),
            appCount: @json($applicantCounts),
        };
    </script>
@endsection

