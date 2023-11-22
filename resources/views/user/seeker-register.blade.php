@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">

            <div class="col-md-6">
                <h1>Looking for a Job?</h1>
                <h3>Please create an account</h3>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card">
                        <div class="card-header">Register</div>
                        <form action="{{route('store.seeker')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Full name</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
