@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="card text-danger">
                <div class="card-header">Verify Account</div>
                <div class="card-body">
                    <p>Your account is not verified. Please verify your email address to access this page.
                    <a href="{{route('resend.email')}}">Resend Verification Email</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
