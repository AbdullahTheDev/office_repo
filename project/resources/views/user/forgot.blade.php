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
                        <li><a href="{{ url('/') }}">{{ $langg->lang17 }}</a></li>
                        <li>{{ $langg->lang190 }}</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->
            <div class="page-content">
                <div class="container">
                    <div class="row justify-content-center pt-5 pb-5 pl-5 pr-5 shadow-sm bg-white rounded">
                        <div class="col-lg-5">
                            <div class="login-area">
                                <div class="header-area forgot-passwor-area">
                                    <h4 class="title">{{ $langg->lang191 }} </h4>
                                    <p class="text">{{ $langg->lang192 }} </p>
                                </div>
                                <div class="login-form">
                                    @include('includes.admin.form-login')
                                    <form id="forgotform" class="mt-3" action="{{route('user-forgot-submit')}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-input">
                                            <input type="email" name="email" class="form-control" class="User Name" placeholder="{{ $langg->lang193 }}"
                                                required="">
                                            <i class="icofont-user-alt-5"></i>
                                        </div>
                                        <div class="to-login-page mt-3">
                                            <a href="{{ route('user.login') }}">
                                                {{ $langg->lang194 }}
                                            </a>
                                        </div>
                                        <input class="authdata" type="hidden" value="{{ $langg->lang195 }}">
                                        <button type="submit" class="submit-btn btn btn-dark mt-3">{{ $langg->lang196 }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection