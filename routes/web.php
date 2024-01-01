<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SubscriptionController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\DashboardController;
use App\Http\Middleware\CheckAuth;
use App\Http\Middleware\isEmployer;
use App\Http\Middleware\isSeeker;
use App\Http\Middleware\isSubscribed;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [JobListingController::class, 'index'])->name('home');
Route::get('/jobs', [JobListingController::class, 'allJobs'])->name('jobs');
Route::get('/jobs/{listing:slug}', [JobListingController::class, 'view'])->name('job.show');
Route::post('/coverletter/upload', [JobListingController::class, 'uploadCover'])->middleware(['auth', isSeeker::class]);
Route::get('/generate-pdf/{listingId}', [JobListingController::class, 'generatePDF'])->name('generate.job.pdf');

Route::get('/register/seeker', [UserController::class, 'createSeeker'])->middleware(CheckAuth::class)->name('create.seeker');
Route::post('/register/seeker', [UserController::class, 'storeSeeker'])->name('store.seeker');
Route::get('/register/employer', [UserController::class, 'createEmployer'])->middleware(CheckAuth::class)->name('create.employer');
Route::post('/register/employer', [UserController::class, 'storeEmployer'])->name('store.employer');

Route::get('/login', [UserController::class, 'login'])->middleware(CheckAuth::class)->name('login');
Route::post('/login', [UserController::class, 'postLogin'])->name('login.post');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/employer/profile', [UserController::class, 'employerProfile'])->middleware(['auth', 'verified'])->name('employer.profile');
Route::get('/seeker/profile', [UserController::class, 'seekerProfile'])->middleware(['auth', 'verified', isSeeker::class])->name('seeker.profile');
Route::post('/user/profile/update', [UserController::class, 'updateProfile'])->middleware('auth')->name('user.profile.update');
Route::post('/user/password/update', [UserController::class, 'updatePassword'])->middleware('auth')->name('user.password.update');
Route::post('/seeker/resume/upload', [UserController::class, 'uploadResume'])->middleware('auth')->name('user.resume.upload');
Route::post('/seeker/resume/remove', [UserController::class, 'deleteResume'])->middleware('auth')->name('user.resume.remove');
Route::delete('user/delete', [UserController::class, 'deleteUser'])->middleware(['auth', 'verified'])->name('user.delete');
Route::get('/company/{id}', [UserController::class, 'companyProfile'])->name('company.profile');
Route::get('user/job/applied', [UserController::class, 'appliedJobs'])->middleware(['auth', 'verified', isSeeker::class])->name('user.jobs');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified', isEmployer::class])
    ->name('dashboard');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/login');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/verify', [DashboardController::class, 'verify'])->name('verification.notice');
Route::get('/resend/verification/email', [DashboardController::class, 'resend'])->name('resend.email');

Route::get('/subscribe', [SubscriptionController::class, 'subscribe'])->name('pay');
Route::get('pay/weekly', [SubscriptionController::class, 'startPayment'])->name('pay.weekly');
Route::get('pay/monthly', [SubscriptionController::class, 'startPayment'])->name('pay.monthly');
Route::get('pay/yearly', [SubscriptionController::class, 'startPayment'])->name('pay.yearly');
Route::get('pay/success', [SubscriptionController::class, 'paymentSuccess'])->name('pay.success');
Route::get('pay/cancel', [SubscriptionController::class, 'paymentCancel'])->name('pay.cancel');

Route::get('job', [JobController::class, 'index'])->middleware(isEmployer::class)->name('job.index');
Route::get('job/create', [JobController::class, 'create'])->middleware(isSubscribed::class)->name('job.create');
Route::post('job/store', [JobController::class, 'store'])->middleware(isSubscribed::class)->name('job.store');
Route::get('job/{listing}/edit', [JobController::class, 'edit'])->middleware(isEmployer::class)->name('job.edit');
Route::put('job/{id}/update', [JobController::class, 'update'])->middleware(isEmployer::class)->name('job.update');
Route::delete('job/{id}/remove', [JobController::class, 'remove'])->middleware(isEmployer::class)->name('job.remove');

Route::get('/applicants', [ApplicantController::class, 'index'])->middleware(['auth', isEmployer::class])->name('applicants.index');
Route::get('/applicants/{listing:slug}', [ApplicantController::class, 'view'])->middleware(['auth', isEmployer::class])->name('applicants.view');
Route::post('/applicants/shortlist/{listingId}/{userId}', [ApplicantController::class, 'shortlist'])->middleware(['auth', isEmployer::class])->name('applicants.shortlist');
Route::post('/seeker/{listingId}/apply', [ApplicantController::class, 'apply'])->middleware('auth')->name('job.apply');
Route::get('/generate-pdf/{slug}', [ApplicantController::class, 'generateApplicantPDF'])->middleware('auth')->name('generate.applicant.pdf');
Route::post('/applicants/{listingId}/interview/schedule', [ApplicantController::class, 'scheduleInterview'])->middleware('auth')->name('applicants.interview');

Route::get('/messages', [MessageController::class,'index'])->middleware(['auth'])->name('messages');
Route::post('/message/send', [MessageController::class,'send'])->middleware(['auth'])->name('message.send');
