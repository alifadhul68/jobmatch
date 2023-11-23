@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">

            <div class="col-md-6">
                <h1>Looking for Talents?</h1>
                <h3>Please create an account</h3>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card">
                        <div class="card-header">Employer Register</div>
                        <form action="{{route('store.employer')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Company name</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                    @if($errors->has('name'))
                                        <span class="text-danger"> {{ $errors->first('name') }}  </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email" class="form-control">
                                    @if($errors->has('email'))
                                        <span class="text-danger"> {{ $errors->first('email') }}  </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control">
                                    @if($errors->has('password'))
                                        <span class="text-danger"> {{ $errors->first('password') }}  </span>
                                    @endif
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
