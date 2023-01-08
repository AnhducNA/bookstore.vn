@extends('layouts.master')
@section('content')
    <section class="w-100 p-4 d-flex justify-content-center pb-4">
        <div style="width: 26rem;">
            <!-- Pills logo -->
            <div class="text-center my-5">
                <a href="{{url("/")}}"> <img src="{{asset('assets/img/logo.png')}}" alt="logo"
                                             class="img-fluid img-thumbnail border-0">
                </a>
            </div>
            <!-- Pills content -->
            <div class="tab-content" id="pills-forgotPassword" role="tabpanel" aria-labelledby="tab-forgotPassword">
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <!-- Email Address -->
                    <div class="form-group">
                        <label class="block font-medium text-sm text-gray-700" for="email">{{__('Email')}}</label>
                        <input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit">{{ __('Email Password Reset Link') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
