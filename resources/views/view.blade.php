@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <img src="{{Storage::url($listing->feature_image)}}" class="card-img-top" alt="Featured Job Image"
                         style="height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h2 class="card-title">{{$listing->title}}</h2>
                        <h6>{{$listing->profile->name}}</h6>
                        <p class="card-text">Address: {{$listing->address}}</p>
                        <span class="badge bg-primary">
                            @if ($listing->job_type == 'fulltime')
                                Full Time
                            @elseif ($listing->job_type == 'remote')
                                Remote
                            @elseif ($listing->job_type == 'parttime')
                                Part Time
                            @endif
                    </span>

                        <h4 class="mt-4">Description</h4>
                        <p class="card-text">{!! $listing->description !!}</p>
                        <h4>Roles and Responsibilities</h4>
                        {!! $listing->roles !!}


                        <h4 class="mt-4">Compensation</h4>
                        <p class="card-text">${{ number_format($listing->salary, 2) }}</p>

                        <p class="card-text mt-4">Application Due
                            date: {{ \Carbon\Carbon::parse($listing->application_close_date)->format('jS \of F, Y') }}</p>
                        @if(auth()->user())
                            @if(auth()->user()->resume)
                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    Apply Now
                                </button>
                            @else
                                <span
                                    class="alert alert-danger d-block mt-5 text-center">You need to upload your resume to apply for a job. Update your <a href="{{route('seeker.profile')}}">Profile</a> now.</span>
                            @endif
                        @else
                            <span class="alert alert-danger d-block mt-5 text-center">You need to log in to apply for a job. <a
                                    href="{{route('login')}}">Login</a> or <a
                                    href="{{route('create.seeker')}}">Register</a> now.</span>
                        @endif

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <form action="{{ route('job.apply', [$listing->id]) }}" method="POST">
                                @csrf
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Attach a cover letter (Optional)</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="file" name="file"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if(Session::has('success'))
                    <div class="alert alert-success mt-4">
                        {{ Session::get('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement);
        pond.setOptions({
            server: {
                url: '/coverletter/upload',
                process: {
                    method: 'POST',
                    withCredentials: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                },
            },
        });
    </script>
@endsection
