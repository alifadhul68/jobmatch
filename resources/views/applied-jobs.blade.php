@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-md-8">
                <h3>Job Applications</h3>
                @foreach($users as $user)
                    @foreach($user->listings as $listing)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $listing->title }}</h5>
                                <p class="card-text">Applied at: {{ $listing->pivot->created_at }}</p>
                                <p class="card-text">Salary: ${{ number_format($listing->salary, 2) }}</p>
                                <a href="{{route('job.show', [$listing->slug])}}" class="btn btn-primary">View</a>
                                @if($listing->pivot->cover_letter)
                                    <a href="{{ Storage::url($listing->pivot->cover_letter) }}" class="btn btn-primary" download>Download Cover Letter</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

    </div>
@endsection
