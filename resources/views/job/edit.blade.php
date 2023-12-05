@extends('layouts.admin.main')

@section('content')

    <div class="container mt-5">

        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <h1>Update Job</h1>
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                <form action="{{route('job.update', [$listing->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="featured_image">Featured Image</label>
                        <input type="file" name="featured_image" id="featured_image" class="form-control">
                        @if($errors->has('featured_image'))
                            <div class="text-danger">{{$errors->first('featured_image')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{$listing->title}}" placeholder="Job Title, Ex. Senior Developer">
                        @if($errors->has('title'))
                            <div class="text-danger">{{$errors->first('title')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description"
                                  class="form-control summernote">{{$listing->description}}</textarea>
                        @if($errors->has('description'))
                            <div class="text-danger">{{$errors->first('description')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="roles">Roles and Responsibilities</label>
                        <textarea name="roles" id="roles" class="form-control summernote">{{$listing->roles}}</textarea>
                        @if($errors->has('roles'))
                            <div class="text-danger">{{$errors->first('roles')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Job Schedule</label>
                        <div class="form-check">
                            <input type="radio" name="job_type" id="fulltime" class="form-check-input" value="fulltime"
                                {{ $listing->job_type === 'fulltime' ? 'checked' : '' }}>
                            <label for="fulltime" class="form-check-label">Full Time</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="job_type" id="parttime" class="form-check-input" value="parttime"
                                {{ $listing->job_type === 'parttime' ? 'checked' : '' }}>
                            <label for="parttime" class="form-check-label">Part Time</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="job_type" id="shift" class="form-check-input" value="shift"
                                {{ $listing->job_type === 'shift' ? 'checked' : '' }}>
                            <label for="shift" class="form-check-label">Shifts</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="job_type" id="remote" class="form-check-input" value="remote"
                                {{ $listing->job_type === 'remote' ? 'checked' : '' }}>
                            <label for="remote" class="form-check-label">Remote</label>
                        </div>
                        @if($errors->has('job_type'))
                            <div class="text-danger">{{$errors->first('job_type')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{$listing->address}}" placeholder="1234 Building, 1234 Street, 123 Block, City, Country">
                        @if($errors->has('address'))
                            <div class="text-danger">{{$errors->first('address')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="text" name="salary" id="salary" class="form-control" value="{{$listing->salary}}" placeholder="$$$$">
                        @if($errors->has('salary'))
                            <div class="text-danger">{{$errors->first('salary')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="due">Application Due Date</label>
                        <input type="text" name="due" id="datepicker" class="form-control" value="{{$listing->application_close_date}}" placeholder="yyyy-mm-dd">
                        @if($errors->has('due'))
                            <div class="text-danger">{{$errors->first('due')}}</div>
                        @endif
                    </div>
                    <div class="form-group mt-4 mb-4 text-center">
                        <button type="submit" class="btn btn-success">Update Job</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

@endsection
