<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Passwords\Confirm;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'show'])->name('home');

Route::middleware('guest')->group(function() {
  Route::get('login', Login::class)
    ->name('login');

  Route::get('register', Register::class)
    ->name('register');
});

Route::get('password/reset', Email::class)
  ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
  ->name('password.reset');

Route::middleware('auth')->group(function() {
  Route::get('email/verify', Verify::class)
    ->middleware('throttle:6,1')
    ->name('verification.notice');

  Route::get('password/confirm', Confirm::class)
    ->name('password.confirm');
});

Route::middleware('auth')->group(function() {
  Route::view('/team', 'team')->name('team.index');
  Route::view('/team/add-user', 'users.create')->name('users.create');

  Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
    ->middleware('signed')
    ->name('verification.verify');

  Route::post('logout', LogoutController::class)
    ->name('logout');

  Route::get('/documents/{user}/{filebane}', [DocumentController::class, 'show']);

  Route::get('leave-impersonation', function() {
    if (session()->has('impersonate')) {
      $old_uid = session('impersonate');
      \Illuminate\Support\Facades\Auth::login(\App\Models\User::withoutGlobalScopes()->find($old_uid));
      session()->forget('impersonate');
    }

    return redirect()->route('team.index');
  })->name('leave-impersonation');
});

Route::get('/load-logins', function() {
  $users = User::withoutGlobalScopes()->whereNotNull('tenant_id')->get();
  foreach($users as $user) {
    \App\Models\Login::factor(1)->create([
      'user_id' => $user->id,
      'tenant_id' => $user->tenant_id,
      'created_at' => now(),
    ]);
  }
});
