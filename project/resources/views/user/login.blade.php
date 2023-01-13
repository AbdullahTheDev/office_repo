@extends('layouts.jbs')
@section('body-class', 'page home page-template-default')
@section('content')

<!-- Start of Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="page-title mb-0">My Account</h1>
    </div>
</div>
<!-- End of Page Header -->

<!-- Start of Breadcrumb -->
<nav class="breadcrumb-nav">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li>My Account</li>
        </ul>
    </div>
</nav>
<!-- End of Breadcrumb -->
<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 mt-5">
                <h2>Sign In</h2>
                {{-- <img src="{{ asset('assets/images/capcha_code.png') }}" alt="capcha"> --}}
                <form class="login mloginform signin-form" action="{{ route('user.login.submit') }}" method="post">
                    {{ csrf_field() }}

                    @include('includes.admin.form-login')
                    <div class="form-group mb-2">
                        <label>Username or email address *</label>
                        <input type="email" class="form-control" name="email" id="email" required
                            placeholder="{{ $langg->lang173 }}">
                    </div>
                    <div class="form-group mb-2">
                        <label>Password *</label>
                        <input type="password" class="form-control" name="password" id="password" required
                            placeholder="{{ $langg->lang174 }}">
                    </div>
                    <input type="hidden" name="modal" value="1">
                    <input type="hidden" name="vendor" value="1">
                    <input class="mauthdata" type="hidden" value="{{ $langg->lang177 }}">
                    <div class="form-checkbox d-flex align-items-center justify-content-between mb-2">
                        <input type="checkbox" class="custom-checkbox" id="remember1" name="remember1" {{
                            old('remember') ? 'checked' : '' }}>
                        <label for="remember1">Remember me</label>
                        <a href="{{ route('user-forgot') }}">Lost your password?</a>
                    </div>
                    <input type="submit" class="btn btn-primary submit-btn" name="login" />
                </form>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mt-5">
                <h2>Sign Up</h2>
                <form method="post" class="register signup-form mregisterform"
                    action="{{route('user-register-submit')}}">
                    {{ csrf_field() }}
                    @include('includes.admin.form-login')
                    <div class="form-group mb-2">
                        <label>Your User Name *</label>
                        <input type="text" class="form-control" name="name" id="name" required
                            placeholder="{{ $langg->lang182 }}">
                    </div>
                    <div class="form-group mb-2">
                        <label>Your email address *</label>
                        <input type="email" class="form-control" name="email" id="email" required
                            placeholder="{{ $langg->lang183 }}">
                    </div>
                    <div class="form-group mb-2">
                        <label>Phone *</label>
                        <input type="text" class="form-control" name="phone" id="phone" required
                            placeholder="{{ $langg->lang184 }}">
                    </div>
                    <div class="form-group mb-2">
                        <label>Address *</label>
                        <input type="text" class="form-control" name="address" id="address" required
                            placeholder="{{ $langg->lang185 }}">
                    </div>

                    <div class="form-group mb-2">
                        <label>Password *</label>
                        <input type="password" class="form-control" name="password" id="password" required
                            placeholder="{{ $langg->lang186 }}">
                    </div>
                    <div class="form-group mb-2">
                        <label>Confirm Password *</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation" required placeholder="{{ $langg->lang187 }}">
                    </div>
                    <input class="mprocessdata" type="hidden" value="{{ $langg->lang188 }}">
                    <input type="submit" class="btn btn-primary submit-btn" value="Register" />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection