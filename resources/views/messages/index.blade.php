@extends($layout)

@section('content')
    <div class="container mt-5">
        <div class="row">
            <h1>Messages</h1>
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @endif
            <!-- Bootstrap tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#sentMessages">Sent Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#receivedMessages">Received Messages</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="sentMessages" class="container tab-pane active"><br>
                    <!-- Sent Messages -->
                    @if($sentMessages->isEmpty())
                        <p>No sent messages to display.</p>
                    @else
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="sentMessagesTable" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>To</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        @if(auth()->user()->user_type == 'employer')
                                            <th>Applied Job</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sentMessages as $message)
                                        <tr>
                                            <td>{{$message->recipient->name}}</td>
                                            <td>{{$message->message_content}}</td>
                                            <td>{{$message->created_at->format('Y-m-d H:i')}}</td>
                                            @if(auth()->user()->user_type == 'employer')
                                                <td>{{$message->listing->title}}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
                <div id="receivedMessages" class="container tab-pane fade"><br>
                    <!-- Received Messages -->
                    @if($receivedMessages->isEmpty())
                        <p>No received messages to display.</p>
                    @else
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="receivedMessagesTable" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>From</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        @if(auth()->user()->user_type == 'employer')
                                            <th>Applied Job</th>
                                        @endif
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($receivedMessages as $message)
                                        <tr>
                                            <td>{{$message->sender->name}}</td>
                                            <td>{{$message->message_content}}</td>
                                            <td>{{$message->created_at->format('Y-m-d H:i')}}</td>
                                            @if(auth()->user()->user_type == 'employer')
                                                <td>{{$message->listing->title}}</td>
                                            @endif
                                            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#messageModal">
                                                    Reply
                                                </button></td>
                                        </tr>
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
                                                            <input type="hidden" name="recipient_id" value="{{ $message->sender_id }}">
                                                            <input type="hidden" name="applicant_id" value="{{ $message->applicant_id }}">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="form-label">Recipient:</label>
                                                                <input type="text" class="form-control" id="recipient-name" disabled
                                                                       value="{{ $message->sender->name }}">
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
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        tr {
            text-align: center;
        }
        td {
            word-break: break-word;
        }
    </style>
@endsection
