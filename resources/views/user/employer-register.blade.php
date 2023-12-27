@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">

            <div class="col-md-6">
                <h1>Looking for Talents?</h1>
                <h3>Please create an account</h3>
            </div>

            <div class="col-md-6">
                    <div class="card" id="card">
                        <div class="card-header">Employer Register</div>
                        <form action="#" method="post" id="RegistrationForm">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Company name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                    @if($errors->has('name'))
                                        <span class="text-danger"> {{ $errors->first('name') }}  </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" required>
                                    @if($errors->has('email'))
                                        <span class="text-danger"> {{ $errors->first('email') }}  </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    @if($errors->has('password'))
                                        <span class="text-danger"> {{ $errors->first('password') }}  </span>
                                    @endif
                                </div>
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="RegisterBtn">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                <div id="message"></div>
            </div>
        </div>
    </div>
    <script>
        var url = "{{ route('store.employer') }}";
        document.getElementById("RegisterBtn").addEventListener("click", function(event) {
            var form = document.getElementById('RegistrationForm');
            var messageDiv = document.getElementById('message');
            messageDiv.innerHTML = '';
            var card = document.getElementById('card');
            var formData = new FormData(form);

            var button = event.target;
            button.disabled = true;
            button.innerHTML = 'Registering...';

            fetch(url, {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            }).then(response => {
                button.innerHTML = 'Register';
                button.disabled = false;
                if (response.ok) {
                    return response.json();
                } else {
                    return response.json().then(data => {
                        if (data.errors) {
                            throw data.errors;
                        } else {
                            throw new Error('Error submitting form data');
                        }
                    });
                }
            }).then(data => {
                messageDiv.innerHTML = '<div class="alert alert-success">Registration was successful. Please check your email to verify your registration.</div>';
                card.style.display = 'none';
            }).catch(errors => {
                if (typeof errors === 'object') {
                    var errorMessages = Object.values(errors).map(errorArray => errorArray.join('<br>')).join('<br>');
                    messageDiv.innerHTML = `<div class="alert alert-danger mt-3">${errorMessages}</div>`;
                } else {
                    messageDiv.innerHTML = `<div class="alert alert-danger mt-3">${errors.message}</div>`;
                }
            });
        });
    </script>
@endsection
