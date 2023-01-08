<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );
        var_dump($status);
         print_r($request->only('email')); die;

//        echo $request->only('email')."  --- ". Password::RESET_LINK_SENT;
//        return $status == Password::RESET_LINK_SENT
//            ? back()->with('status', __($status))
//            : back()->withInput($request->only('email'))
//                ->withErrors(['email' => __($status)]);
    }
}
