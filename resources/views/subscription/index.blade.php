@extends('layouts.admin.main')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            @if(Session::has('message'))
                <div class="alert alert-warning">{{Session::get('message')}}</div>
            @endif
            <div class="col-md-4">
                <div class="card shadow-lg" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Weekly - BHD 20</h5>
                        <hr class=""/>
                        <p class="card-text">Get started with our Weekly Plan for just BHD 20. This plan offers flexibility for short-term hiring needs.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Post your job listings</li>
                        <li class="list-group-item">Access candidate applications</li>
                        <li class="list-group-item">Quick and easy recruitment</li>
                    </ul>
                    <div class="card-body text-center">
                        <a href="{{ route('pay.weekly') }}" class="card-link">
                            <button class="btn btn-primary" style="width: 100%">Pay</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Monthly - BHD 70</h5>
                        <hr class=""/>
                        <p class="card-text">For a more cost-effective option, choose our Monthly Plan at BHD 70 per month. Perfect for businesses looking to hire consistently.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Unlimited job postings for a month</li>
                        <li class="list-group-item">Access to applicant data</li>
                        <li class="list-group-item">Ideal for ongoing recruitment</li>
                    </ul>
                    <div class="card-body text-center">
                        <a href="{{ route('pay.monthly') }}" class="card-link">
                            <button class="btn btn-primary" style="width: 100%">Pay</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Yearly - BHD 500</h5>
                        <hr class=""/>
                        <p class="card-text">Maximize your savings with our Yearly Plan at only BHD 500 per year. This plan is perfect for long-term hiring strategies.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Post jobs throughout the year</li>
                        <li class="list-group-item">Applicant tracking and manage</li>
                        <li class="list-group-item">Significant cost savings</li>
                    </ul>
                    <div class="card-body text-center">
                        <a href="{{ route('pay.yearly') }}" class="card-link">
                            <button class="btn btn-primary" style="width: 100%">Pay</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
