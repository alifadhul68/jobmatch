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
                @if(Session::has('errors'))
                    <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                    </div>
                @endif
            </div>
            @foreach($listing->users as $user)
                <div class="card mt-5" style="{{$user->pivot->is_shortlisted ? 'background-color: #42cf8e47;' : ''}}">
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
                                    <a href="{{Storage::url($user->resume)}}" class="m-2 btn btn-primary" download>Download
                                        Resume</a>
                                @else
                                    <p class="m-2 card-text text-danger">No resume uploaded</p>
                                @endif
                                @if($user->pivot->cover_letter)
                                    <a href="{{Storage::url($user->pivot->cover_letter)}}" class="m-2 btn btn-primary"
                                       download>Download
                                        Cover Letter</a>
                                @endif
                                <button type="button" class="m-2 btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#messageModal_{{$user->pivot->id}}">
                                    Message
                                </button>
                                <button type="submit"
                                        class="m-2 {{$user->pivot->is_shortlisted ? 'd-none' : 'btn btn-dark'}}">
                                     {{$user->pivot->is_shortlisted ? 'Shortlisted' : 'Shortlist'}}
                                </button>
                                @if($user->pivot->is_shortlisted)
                                    <button type="button" class="m-2 btn btn-primary" data-bs-toggle="modal" data-bs-target="#interviewModal_{{$user->pivot->id}}">Schedule Interview</button>
                                @endif
                            </form>

                            <!-- Interview Modal -->
                            <div class="modal fade" id="interviewModal_{{$user->pivot->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="interviewModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="interviewModalLabel">Schedule an interview</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('applicants.interview', $listing->id) }}" method="POST">
                                            @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="applicantId" value="{{$user->pivot->id}}">
                                            <input type="hidden" name="interviewerId" value="{{auth()->user()->id}}">
                                            <input type="hidden" name="intervieweeId" value="{{$user->id}}">
                                            <div class="form-group">
                                                <label for="interviewTime">Interview Time</label>
                                                <input type="datetime-local" class="form-control" id="interviewTime" name="interviewTime">
                                            </div>
                                            <div class="form-group">
                                                <label for="interviewLocation">Interview Location</label>
                                                <input type="text" class="form-control" id="interviewLocation" name="interviewLocation">
                                            </div>
                                            <div class="form-group">
                                                <label for="interviewNotes">Notes</label>
                                                <textarea id="interviewNotes" class="form-control" name="interviewNotes" placeholder="Optional"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Schedule</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Message Modal -->
                            <div class="modal fade" id="messageModal_{{$user->pivot->id}}" tabindex="-1" aria-labelledby="messageModalLabel"
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

