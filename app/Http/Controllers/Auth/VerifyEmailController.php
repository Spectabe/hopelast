<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class VerifyEmailController extends Controller
{

    public function showPageForResultOfMailVerification(Request $request)//: RedirectResponse
    {
        $user = User::find($request->route('id'));

        if (!$user) {
            $msg = 'Errore nel verificare la mail, contattaci hopelast532@gmail.com';
            return view('auth.mail-verification-page', ['message' => $msg]);
            // return redirect(env('FRONT_URL') . '/email/verify/error');
        }

        if ($user->hasVerifiedEmail()) {
            $msg = 'Mail gia\' verificata';
            return view('auth.mail-verification-page', ['message' => $msg]);
            // return redirect(env('FRONT_URL') . '/email/verify/already-success');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        $msg = 'Mail verificata con successo';
        return view('auth.mail-verification-page', ['message' => $msg]);
        // return redirect(env('FRONT_URL') . '/email/verify/success');
    }
}