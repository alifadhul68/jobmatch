@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(Session::has('success'))
                    <div class="alert alert-success mb-4">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger mb-4">
                        {{ Session::get('error') }}
                    </div>
                @endif
                @if(Session::has('errors'))
                    <div class="alert alert-danger mb-4">
                        <ul>
                            @foreach (Session::get('errors')->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-between">
                            <h2 class="card-title mb-4 d-flex flex-column justify-content-center">Update Your
                                Profile</h2>
                            @if(auth()->user()->profile_pic)
                                <div class="border border-3 d-flex justify-content-center align-items-center"
                                     style="width: 150px; height: 200px;">
                                    <img src="{{ Storage::url(auth()->user()->profile_pic) }}"
                                         style="max-width: 100%; max-height: 100%; height: auto; width: auto;">
                                </div>
                            @endif
                        </div>
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="img">Profile Image</label><br>
                                <input type="file" class="form-control" id="img" name="profile_pic">
                            </div>
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">Update Profile</button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal" type="button">Delete Account</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteAccountModal">Delete Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete your account. This will delete all of your data stored on our website?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="{{ route('user.delete') }}" method="POST">@csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Change Your Password</h2>
                        <form action="{{ route('user.password.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password"
                                       name="current_password" placeholder="********">
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="********">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation" placeholder="********">
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Upload Your Resume</h2>
                        <form action="{{ route('user.resume.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="resume">Resume</label><br>
                                <input type="file" class="form-control" id="resume" name="resume">
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">Upload Resume</button>
                            </div>
                        </form>
                        @if(auth()->user()->resume)
                            <div class="mt-4">
                                <h3>Current Resume:</h3>
                                <p>
                                <form action="{{ route('user.resume.remove') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <a href="{{ Storage::url(auth()->user()->resume) }}" class="btn btn-primary"
                                       target="_blank">Download Resume</a>
                                    <button type="submit" class="btn btn-danger">Delete Resume</button>
                                </form>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
