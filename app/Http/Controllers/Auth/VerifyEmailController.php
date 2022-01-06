<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {

        $user = User::where('id', $request->route('id'))->first();

        if ($user->email_verified_at != NULL) {
            // return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            return view('verified-email');
        } else {
            $user->markEmailAsVerified();
            
            return view('verified-email');
        }

        // // Auth::user()->markEmailAsVerified();

        // if ($user()->markEmailAsVerified()) {
        //     event(new Verified($request->user()));
        // }

        
        // echo "Email sudah di verifikasi";
        // return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
