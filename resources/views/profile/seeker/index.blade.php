@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{Session::get('error')}}
                </div>
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
            <form action="{{route('user.profile.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="img">Profile Image</label>
                        <input type="file" class="form-control" id="img" name="profile_pic">
                        @if(auth()->user()->profile_pic)
                            <img src="{{Storage::url(auth()->user()->profile_pic)}}" class="img-fluid" width="150">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}}">
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">Update Profile</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row justify-content-center">
            <h2>Change your password</h2>
            <form action="{{route('user.password.update')}}" method="POST">
                @csrf
                <div class="col-md-8">
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
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
