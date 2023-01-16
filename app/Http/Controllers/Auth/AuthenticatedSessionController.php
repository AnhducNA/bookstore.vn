<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->validate(
            [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', Rules\Password::defaults()]
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attributecó độ dài lớn nhất :max ký tự',
            ],
            [
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );

        $request->authenticate();
        $request->session()->regenerate();
        $role_id = Auth::user()->role_id;
        switch ($role_id) {
            case 1:
                return redirect('admin/home');
                break;
            case  2:
                return redirect('user/home');
                break;
            case 3:
                return redirect('/');
                break;
            default:
                return redirect('login');
                break;
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
