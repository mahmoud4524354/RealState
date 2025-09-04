<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        toastr()->info('You are logged in successfully');

        if($request->user()->role === 'admin'){
            return redirect()->intended(route('admin.dashboard'));
        }elseif ($request->user()->role === 'agent'){
            return redirect()->intended(route('agent.dashboard'));
        }

        return redirect()->intended(RouteServiceProvider::HOME);



    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $role = $request->user()->role;     // Store The Role

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if($role === 'admin'){
            return redirect('/admin/login');
        }
        return redirect('/login');
    }
}
