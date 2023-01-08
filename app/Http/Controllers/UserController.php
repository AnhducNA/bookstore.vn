<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Application|Factory|View
     */
    public function login()
    {
        return view('users.login');
    }

    /**
     * @return false|Application|RedirectResponse|Redirector
     */
    public function processLogin()
    {
        $this->request->validate(
            [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attributecó độ dài lớn nhất :max ký tự',
                'unique' => ':attribute đã tồn tại',
            ],
            [
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );
        if ($this->request->input('btnLogin')) {
            $user = User::where('email', $this->request->input('email'))
                ->where('password', md5($this->request->input('password')))
                ->get();
            if ($user) {
                Auth::check() == true;
                $this->request->isLogin = 1;
//                dd($this->request);
//                return redirect(url()->previous())->with('success', 'Đăng nhập thành công'); ;
            } else{
                $this->request->isLogin = 0;
            }
        } else {
            return false;
        }

    }

    public function register()
    {
        return view('users.register');
    }

    public function processRegister()
    {

        if ($this->request->input('btnRegister')) {
            $this->request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                    'gender' => 'required',
                    'telContact' => 'required'

                ],
                [
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute có độ dài ít nhất :min ký tự',
                    'max' => ':attributecó độ dài lớn nhất :max ký tự',
                    'confirmed' => 'xác nhận mật khẩu không thành công',
                    'unique' => ':attribute đã tồn tại',
                ],
                [
                    'name' => 'Họ và tên',
                    'email' => 'Email',
                    'password' => 'Mật khẩu',
                    'gender' => 'Giới tính',
                    'telContact' => 'Số điện thoại'
                ]
            );
            User::create([
                'name' => $this->request->input('name'),
                'email' => $this->request->input(('email')),
                'password' => md5($this->request->input('password')),
                'gender' => $this->request->input(('gender')),
                'telContact' => $this->request->input(('telContact')),
            ]);
            return redirect('user/login');
        } else {
//            don't click submit
            return false;
        }
    }

    public function logout()
    {
        $_SESSION['isLogin'] = 0;
    }
}
