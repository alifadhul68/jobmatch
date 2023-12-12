@extends('layouts.admin.main')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mt-5">
                <h1>{{$listing->title}}</h1>

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
            </div>
            @foreach($listing->users as $user)
                <div class="card mt-5 {{$user->pivot->is_shortlisted ? 'border border-5 border-success' : ''}}">
                    <div class="row g-0">

                        <div class="col-auto d-flex align-items-center">
                            @if ($user->profile_pic)
                                <img src="{{Storage::url($user->profile_pic)}}" class="rounded-circle"
                                     style="width: 150px;" alt="Profile picture">
                            @else
                                <img src="https://placehold.co/400" class="rounded-circle"
                                     style="width: 150px;" alt="Profile picture">
                            @endif
                        </div>
                        <div class="col">
                            <div class="card-body">
                                <p class="fw-bold">{{$user->name}}</p>
                                <p class="card-text">{{$user->email}}</p>
                                <p class="card-text">Applied on: {{$user->pivot->created_at}}</p>
                            </div>
                        </div>
                        <div class="col-auto align-self-center">
                            <form action="{{route('applicants.shortlist', [$listing->id, $user->id])}}" method="post" class="d-flex flex-column align-items-stretch">
                                @csrf
                            @if($user->resume)
                                <a href="{{Storage::url($user->resume)}}" class="btn btn-primary">Download Resume</a>
                            @else
                                <p class="card-text text-danger">No resume uploaded</p>
                            @endif
                                <button type="submit" class="mt-2 {{$user->pivot->is_shortlisted ? 'btn btn-success disabled' : 'btn btn-dark'}}">Shortlist</button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
