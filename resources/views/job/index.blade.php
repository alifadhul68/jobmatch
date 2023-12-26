@extends('layouts.admin.main')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <h2>All Jobs</h2>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Your Jobs
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Created on</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Title</th>
                            <th>Created on</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($listings as $listing)
                            <tr>
                                <td>{{$listing->title}}</td>
                                <td>{{$listing->created_at->format('Y-m-d')}}</td>
                                <td><a href="{{route('job.edit', $listing->id)}}" class="btn btn-primary">Edit</a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal{{$listing->id}}" class="btn btn-danger">Delete</a>
                                    <a href="{{route('job.show', $listing->slug)}}" class="btn btn-primary">
                                        View Job
                                    </a>
                                </td>
                            </tr>
                            <!-- Modal -->

                            <div class="modal fade" id="exampleModal{{$listing->id}}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <form action="{{route('job.remove', [$listing->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Job</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this job?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
