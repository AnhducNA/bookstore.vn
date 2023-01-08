@extends('layouts.master')
@section('content')
    <section class="w-100 p-4 d-flex justify-content-center pb-4">
        <div style="width: 26rem;">
            <!-- Pills logo -->
            <div class="text-center">
                <a href="{{url("/")}}"> <img src="{{asset('assets/img/logo.png')}}" alt="logo"
                                             class="img-fluid img-thumbnail border-0">
                </a>
            </div>
            <!-- Pills content -->
            <div class="tab-content" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <!-- Email input -->
                    <div class="form-group">
                        <label for="registerEmail" class="label">{{__('Email')}}</label>
                        <input type="email" name="email" id="registerEmail" class="form-control" required>
                        @error('email')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="registerPassword">{{__('Password')}}</label>
                        <input type="password" id="registerPassword" class="form-control" required/>
                        @error('password')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <!-- Repeat Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="registerRepeatPassword">{{__('Repeat password')}}</label>
                        <input type="password" id="registerRepeatPassword" class="form-control"/>
                        @error('password')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block my-3">{{ __('Reset Password') }}</button>
            </div>
    </section>
@endsection
