<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LoginRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:dashboard', ['except' => ['login' , 'getLogin']]);
    }

    /**
     * @return Application|Factory|View
     */
    public function getLogin()
    {
        return view('dashboard.auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        if (auth()  ->guard('dashboard')
            ->attempt([
                'email'         => $request->validated('email'),
                'password'      => $request->validated('password')
            ], $request->has('remember_me'))) {
            toastr()->success(  "Logged In Suuccessfully"  );
            return redirect()->route('dashboard.index');
        }
        toastr()->error(trans('auth.failed'));
        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function logout()
    {
        Auth::guard('dashboard')->logout();
        toastr()->success(__('auth.logout'));
        return redirect()->route('dashboard.auth.login');
    }
}
