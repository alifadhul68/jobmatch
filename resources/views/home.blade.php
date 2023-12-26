
@extends('layouts.app')

@section('content')
    <div class="container my-5">

        <!-- Hero Section -->
        <div class="jumbotron text-center bg-primary mb-4">
            <h1 class="display-4">Find Your Dream Job</h1>
            <p class="lead">Explore top opportunities across various industries</p>
            <a href="{{ route('jobs') }}" class="btn btn-light btn-lg">Browse All Jobs</a>
        </div>

        <!-- Filter and Sorting Section -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Job Listings</h4>
        </div>

        <!-- Jobs Listing -->
        <div class="row g-3">
            @forelse ($jobs as $job)
                <div class="col-md-3">
                    <div class="card p-2">
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
            @empty
                <p>No jobs available at the moment.</p>
            @endforelse
        </div>

        <!-- Why Choose Us Section -->
        <div class="mt-5">
            <h4 class="">Why Choose Us?</h4>
            <hr>
            <p>Learn about our commitment to helping you find the best opportunities. At [Your Company], we prioritize your career growth by offering:</p>
            <ul>
                <li>Personalized job matches based on your skills and preferences</li>
                <li>Expert career advice and support</li>
                <li>Access to exclusive job openings in top companies</li>
            </ul>
        </div>

        <!-- Testimonials Section -->
        <div class="mt-5">
            <h4 class="">Testimonials</h4>
            <hr>
            <p>See what others are saying about their experiences with us:</p>
            <div class="testimonial-wrapper">
                <!-- First Testimonial -->
                <blockquote class="testimonial">
                    <p>"I found my dream job through Job Match! The process was seamless and the support I received was outstanding."</p>
                    <footer>- Jane Doe, Software Developer</footer>
                </blockquote>

                <!-- Second Testimonial -->
                <blockquote class="testimonial">
                    <p>"The personalized service at Job Match set it apart. They really understood my career goals and helped me navigate my job search effectively."</p>
                    <footer>- John Smith, Digital Marketer</footer>
                </blockquote>

                <!-- Third Testimonial -->
                <blockquote class="testimonial">
                    <p>"Thanks to Job Match, I transitioned to a new industry smoothly. Their insights and network were invaluable."</p>
                    <footer>- Emily Johnson, Project Manager</footer>
                </blockquote>
            </div>
        </div>

    </div>

    <!-- Custom Styling -->
    <style>
        .jumbotron {
            background: url('{{ asset('assets/img/hero.png') }}') no-repeat center center;
            background-size: cover;
            padding: 10rem;
        }

        .card:hover {
            background-color: #efefef;
        }
        .testimonial-wrapper {
            border-left: 4px solid #007bff;
            padding-left: 20px;
            margin-top: 15px;
        }

        .testimonial {
            font-style: italic;
            margin-bottom: 15px;
        }

        .testimonial footer {
            font-weight: bold;
            text-align: right;
        }

        .news-list article {
            margin-bottom: 15px;
        }
    </style>
@endsection
