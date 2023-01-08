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
            <div class="tab-content" id="pills-forgotPassword" role="tabpanel" aria-labelledby="tab-confirmPassword">
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </div>
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="registerPassword">{{__('Password')}}</label>
                        <input type="password" id="registerPassword" class="form-control" required/>
                        @error('password')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <button type="submit">{{ __('Confirm') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </section>
    @csrf
@endsection
