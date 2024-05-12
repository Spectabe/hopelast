<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;

/*
==========================
    AUTH
==========================
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

/*
==========================
    DBMS INTERACTIONS
==========================
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('event/all', [EventController::class, 'index']);
    Route::get('event/show/{id}', [EventController::class, 'show']);
    Route::post('event/add', [EventController::class, 'store']);
    Route::put('event/update/{id}', [EventController::class, 'update']);
});

/*
==========================
    FORGOT PASSWORD
==========================
*/

// invia mail ok
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');

// mostra la view con il form per il reset della psw
Route::get('/reset-password/{token}', function (string $token, Request $request) {
    return view('auth.reset-password-page', [
        'token' => $token,
        'email' => $request->email,
    ]);
})
    ->middleware('guest')
    ->name('password.reset');

// dalla view precedente fai una richiesta a questa rotta
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        return response()->json(['message' => 'Password reset successful'], 200);
    } else {
        return response()->json(['error' => 'Password reset failed'], 400);
    }
})->middleware('guest')->name('password.update');
/*
==========================
    VERIFICA MAIL
==========================
*/

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'showPageForResultOfMailVerification'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// ! da provare
// ! implementare throttle:6,1 in tutte le rotte
// ! eliminare view predefinite tipo homepage
Route::post('/email/verify/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
