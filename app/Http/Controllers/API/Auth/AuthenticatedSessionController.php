<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $validate = $request->only('email', 'password');

        $validate = $request->only('email', 'password');

        if (Auth::attempt($validate)) {
            $token = Auth::user()->createToken('authToken')->accessToken;
            // return redirect()->intended(RouteServiceProvider::HOME);
            $data = [
                'message' => 'Succes',
                'token' => $token,
                'data' => Auth::user()
            ];
            
            return response()->json($data, 200);   
        }
        // if (Auth::attempt($validate)) {
        //     $request->authenticate();

        //     $request->session()->regenerate();
    
        //     $token = Auth::user()->createToken('authToken')->accessToken;
        //     // return redirect()->intended(RouteServiceProvider::HOME);
        //     $data = [
        //         'message' => 'Succes',
        //         'token' => $token,
        //         'data' => Auth::user()
        //     ];
    
        //     return response()->json($data, 200);   
        else {
            $data = [
                'message' => 'Failed',
                'data' => 'Email atau password salah'
            ];
    
            return response()->json($data, 200);   
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();
        $data = [
            'message' => 'Success Logout'
        ];
        return response()->json($data, 200);
    }
}
