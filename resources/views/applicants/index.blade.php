@extends('layouts.admin.main')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <h2>Applicants</h2>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Your Jobs
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                        <tr>
                            <th>Job title</th>
                            <th>Created on</th>
                            <th>Total applicants</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listings as $listing)
                            <tr>
                                <td>{{$listing->title}}</td>
                                <td>{{$listing->created_at->format('Y-m-d')}}</td>
                                <td>{{$listing->users_count}}</td>
                                <td>
                                    <a href="{{route('applicants.view', $listing->slug)}}" class="btn btn-primary">
                                        View Applicants
                                    </a>
                                    <a href="{{route('applicants.generate', $listing->slug)}}" class="btn btn-primary">
                                        Generate PDF
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
