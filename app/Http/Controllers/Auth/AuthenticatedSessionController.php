<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuditHelper;
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





    AuditHelper::create(

        'LOGIN',

        'Security',

        'User berhasil login ke sistem'

    );





        $user = auth()->user();


if($user->role == 'owner'){

    return redirect()->route('owner.dashboard');

}


if($user->role == 'admin'){

    return redirect('/admin/dashboard');

}


if($user->role == 'keuangan'){

    return redirect('/dashboard');

}


return redirect()->route('dashboard');
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        AuditHelper::create(

    'LOGOUT',

    'Security',

    'User keluar dari sistem'

);
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
