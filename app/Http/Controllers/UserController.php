<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    const SEEKER = 'seeker';
    const EMPLOYER = 'employer';

    public function createSeeker()
    {
        return view('user.seeker-register');
    }

    public function storeSeeker(RegistrationRequest $request)
    {
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt($request->input('password')),
            'user_type' => self::SEEKER
        ]);

        $user->sendEmailVerificationNotification();
        Auth::login($user);
        return redirect()->route('verification.notice')->with('successMessage', 'Your account was successfully created');
    }

    public function createEmployer()
    {
        return view('user.employer-register');
    }
    public function storeEmployer(RegistrationRequest $request)
    {
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt($request->input('password')),
            'user_type' => self::EMPLOYER,
            'user_trial' => now()->addWeek(),
        ]);

        $user->sendEmailVerificationNotification();
        Auth::login($user);
        return redirect()->route('verification.notice')->with('successMessage', 'Your account was successfully created');
    }


    public function login()
    {
        return view('user.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $creds = $request->only('email', 'password');

        if (Auth::attempt($creds)) {
            return redirect()->intended('dashboard');
        } else {
            return redirect()->back()->withInput()->withErrors(['email' => 'Invalid email or password']);
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
