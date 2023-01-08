@extends('layouts.master')
@section('content')
    <div class="container">
        <section class="login-area my-5">
            <div class="container">
                @include('layouts.includes.flash-message')
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-center text-uppercase font-weight-bold">Account Login</h4>
                            </div>
                            <div class="card-body">
                                <div>
                                    <!-- Pills logo -->
                                    <div class="text-center">
                                        <a href="{{url("/")}}"> <img src="{{asset('assets/img/logo.png')}}" alt="logo"
                                                                     class="img-fluid img-thumbnail border-0">
                                        </a>
                                    </div>
                                    <!-- Pills content -->
                                    <div class="tab-content" id="pills-login" role="tabpanel"
                                         aria-labelledby="tab-login">
                                        <form action="{{ route('login') }}" method="post">
                                            @csrf
                                            <div class="text-center mb-3">
                                                <p>Sign in with:</p>
                                                <button type="button" class="btn btn-link btn-floating mx-1">
                                                    <i class="fab fa-facebook-f"></i>
                                                </button>

                                                <button type="button" class="btn btn-link btn-floating mx-1">
                                                    <i class="fab fa-google"></i>
                                                </button>

                                                <button type="button" class="btn btn-link btn-floating mx-1">
                                                    <i class="fab fa-github"></i>
                                                </button>
                                            </div>
                                            <p class="text-center text-uppercase font-weight-bold">or:</p>
                                            <!-- Email input -->
                                            <div class="form-group">
                                                <label for="loginName" class="label">{{__('Email')}}</label>
                                                <input type="email" name="email" id="loginName" class="form-control"
                                                       required autofocus>
                                                @error('email')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <!-- Password input -->
                                            <div class="form-group">
                                                <label for="loginPassword" class="label">{{__('Password')}}</label>
                                                <input type="password" name="password" id="loginPassword"
                                                       class="form-control" required
                                                       autocomplete="current-password">
                                                @error('password')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <!-- 2 column grid layout -->
                                            <div class="row mb-4">
                                                <div class="col-md-6 d-flex justify-content-center">
                                                    <!-- Checkbox -->
                                                    <div class="form-check mb-3 mb-md-0">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="loginCheck" checked/>
                                                        <label class="form-check-label"
                                                               for="loginCheck">{{ __('Remember me') }}</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 d-flex justify-content-center">
                                                    <!-- Simple link -->
                                                    @if (Route::has('password.request'))
                                                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                                           href="{{ route('password.request') }}">
                                                            {{ __('Forgot your password?') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Submit button -->
                                            <button type="submit"
                                                    class="btn btn-success btn-block mb-4">{{ __('Login') }}</button>

                                            <!-- Register buttons -->
                                            <div class="text-center">
                                                <p>{{__("Don't have an account ?")}} <a href="{{ route('register') }}">Register</a>
                                                </p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

