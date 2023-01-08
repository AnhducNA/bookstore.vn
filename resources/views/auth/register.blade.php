@extends('layouts.master')
@section('content')
    <div class="container" style="">
        <section class="login-area my-5">
            <div class="container">
                @include('layouts.includes.flash-message')
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-center text-uppercase font-weight-bold">Account Register</h4>
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
                                        <form action="{{route('register')}}" method="post">
                                            @csrf
                                            <div class="text-center mb-3">
                                                <p>Sign up with:</p>
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
                                            <p class="text-center">or:</p>
                                            <!-- Name input -->
                                            <div class="form-group">
                                                <label for="registerName" class="label">{{__('Fullname')}}</label>
                                                <input type="text" name="name" id="registerName" class="form-control"
                                                       required autofocus>
                                                @error('name')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <!-- Email input -->
                                            <div class="form-group">
                                                <label for="registerEmail" class="label">{{__('Email')}}</label>
                                                <input type="email" name="email" id="registerEmail" class="form-control"
                                                       required>
                                                @error('email')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <!-- Password input -->
                                            <div class="form-outline mb-4">
                                                <label class="form-label"
                                                       for="registerPassword">{{__('Password')}}</label>
                                                <input type="password" name="password" id="registerPassword"
                                                       class="form-control" required/>
                                                @error('password')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <!-- Repeat Password input -->
                                            <div class="form-outline mb-4">
                                                <label class="form-label"
                                                       for="registerRepeatPassword">{{__('Repeat password')}}</label>
                                                <input type="password" name="password_confirmation"
                                                       id="registerRepeatPassword"
                                                       class="form-control"/>
                                                @error('password')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <!-- telephone -->
                                            <div class="form-outline mb-4">
                                                <label class="form-label"
                                                       for="registerRepeatPassword">{{__('Telephone contact :')}}</label>
                                                <input type="password" name="telContact" id="registerRepeatPassword"
                                                       class="form-control"/>
                                                @error('telContact')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <!-- Check input -->
                                            <div class="form-control">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        {{ __('Gender: ') }}
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                               value="male">Male
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                               value="female">Female
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                               value="other">Other
                                                    </label>
                                                </div>
                                                @error('gender')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>

                                            <!-- Checkbox -->
                                            <div class="form-check d-flex justify-content-center my-4">
                                                <input class="mx-2" type="checkbox" value="" id="registerCheck" checked
                                                       aria-describedby="registerCheckHelpText"/>
                                                <label class="form-check-label" for="registerCheck">
                                                    I have read and agree to the terms
                                                </label>

                                            </div>

                                            <!-- Submit button -->
                                            <button type="submit" class="btn btn-success btn-block my-3">Register
                                            </button>
                                            <!-- Register buttons -->
                                            <div class="text-center">
                                                <p>{{ __('Already registered ?') }} <a
                                                            href="{{ route('login') }}">Login</a></p>
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

