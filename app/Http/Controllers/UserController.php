<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => bcrypt($request->input('password')),
                'user_type' => self::SEEKER
            ]);

            $user->sendEmailVerificationNotification();
            Auth::login($user);

            DB::commit();
            return response()->json('success');
            //return redirect()->route('verification.notice')->with('successMessage', 'Your account was successfully created');
        } catch (\Exception $e) {
            // If an error occurs during email sending, catch the exception
            // Roll back the database transaction
            DB::rollBack();

            // Delete the user from the database
            $user->delete();

            // Rethrow the exception to log it or handle it further if needed
            throw $e;
        }
    }

    public function createEmployer()
    {
        return view('user.employer-register');
    }

    public function storeEmployer(RegistrationRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => bcrypt($request->input('password')),
                'user_type' => self::EMPLOYER,
                'user_trial' => now()->addWeek(),
            ]);

            $user->sendEmailVerificationNotification();
            Auth::login($user);

            DB::commit();

            return response()->json('success');
            //return redirect()->route('verification.notice')->with('successMessage', 'Your account was successfully created');
        } catch (\Exception $e) {
            // If an error occurs during email sending, catch the exception
            // Roll back the database transaction
            DB::rollBack();

            // Delete the user from the database
            $user->delete();

            // Rethrow the exception to log it or handle it further if needed
            throw $e;
        }
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
            if(auth()->user()->user_type == self::EMPLOYER) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->to('/');
            }
        } else {
            return redirect()->back()->with('errorMessage', 'Invalid email or password');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function employerProfile()
    {
        return view('profile.employer.index');
    }

    public function updateProfile(Request $request){
        if($request->hasFile('profile_pic')){
            $request->validate([
                'profile_pic' => 'image|mimes:jpeg,png,jpg|max:10240'
            ]);
            $imgPath = $request->file('profile_pic')->store('profile', 'public');
            User::find(auth()->user()->id)->update(['profile_pic' => $imgPath]);
        }
        User::find(auth()->user()->id)->update($request->except('profile_pic'));
        return back()->with('success', 'Your profile has been updated');
    }


    public function seekerProfile()
    {
        return view('profile.seeker.index');
    }

    public function updatePassword(Request $request){
        $request->validate([
           'current_password' => 'required',
            'password' => 'required|min:4|confirmed'
        ]);
        $user = auth()->user();
        if(!Hash::check($request->current_password, $user->password)){
            return back()->with('error', 'Your current password does not match');
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Your password has been updated');
    }

    public function uploadResume(Request $request){
        $request->validate([
            'resume' =>'required|mimes:pdf,doc,docx'
        ]);

        if ($request->hasFile('resume')) {
            $resume = $request->file('resume')->store('resume', 'public');
            User::find(auth()->user()->id)->update(['resume' => $resume]);
            return back()->with('success', 'Your resume has been uploaded');
        }
    }

    public function deleteResume(){
        User::find(auth()->user()->id)->update(['resume' => null]);
        return back()->with('success', 'Your resume has been deleted');
    }
}
