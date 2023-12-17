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
                            <form action="{{route('applicants.shortlist', [$listing->id, $user->id])}}" method="post"
                                  class="d-flex flex-column align-items-stretch">
                                @csrf
                                @if($user->resume)
                                    <a href="{{Storage::url($user->resume)}}" class="btn btn-primary" download>Download
                                        Resume</a>
                                @else
                                    <p class="card-text text-danger">No resume uploaded</p>
                                @endif
                                @if($user->pivot->cover_letter)
                                    <a href="{{Storage::url($user->pivot->cover_letter)}}" class="btn btn-primary mt-2"
                                       download>Download
                                        Cover Letter</a>
                                @endif
                                <button type="submit"
                                        class="mt-2 {{$user->pivot->is_shortlisted ? 'btn btn-success disabled' : 'btn btn-dark'}}">
                                    Shortlist
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#messageModal">
                                Message
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="messageModal">Send a message</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('message.send') }}" method="POST" id="messageForm">
                                            <div class="modal-body">
                                                @csrf
                                                <input type="hidden" name="recipient_id" value="{{ $user->id }}">
                                                <input type="hidden" name="applicant_id" value="{{ $user->pivot->id }}">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="form-label">Recipient:</label>
                                                    <input type="text" class="form-control" id="recipient-name" disabled
                                                           value="{{ $user->name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text" class="form-label">Message:</label>
                                                    <textarea class="form-control" id="message-text" name="message"
                                                              rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">Send Message</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

