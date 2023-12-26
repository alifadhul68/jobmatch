@extends('layouts.admin.main')

@section('content')
    <div class="container py-5">
        <!-- Alerts -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
                @if(Session::has('errors'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach (Session::get('errors')->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Profile Update Form -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-danger-subtle">Update Profile</div>
                    <div class="card-body">
                        <!-- Profile Picture Display -->
                        @if(auth()->user()->profile_pic)
                            <div class="text-center mb-4">
                                <img src="{{ Storage::url(auth()->user()->profile_pic) }}" class="img-fluid rounded-circle" width="150" alt="Profile Picture">
                                <p class="text-muted">Current Profile Picture</p>
                            </div>
                        @endif
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="logo">Company Logo</label>
                                <input type="file" class="form-control" id="logo" name="profile_pic">
                            </div>
                            <div class="form-group">
                                <label for="name">Company Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group">
                                <label for="about">About</label>
                                <textarea class="form-control" id="about" name="about">{{ auth()->user()->about }}</textarea>
                            </div>
                            <div class="form-group text-right mt-3">
                                <button type="submit" class="btn btn-success">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Update Form -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-danger-subtle">Change Your Password</div>
                    <div class="card-body">
                        <form action="{{ route('user.password.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="********">
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="********">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="********">
                            </div>
                            <div class="form-group text-right mt-3">
                                <button type="submit" class="btn btn-success">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
