@extends('layouts.jbs')
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
          <h4 class="text-center">Don't have an account ? Place Order as Guest</h4>
            <div id="loginFirstArea" class="text-center mt-10">
            <div class="check mt-2">
              <a href="{{ url('checkout') }}" class="btn btn-dark chkout-btn">
                Checkout as Guest <i class="fa fa-long-arrow-right arrow-right"></i>
              </a>
            </div>
            <div class="check mt-2">
              <a href="{{ url('category') }}" class="btn btn-dark chkout-btn">
                  <i class="fa fa-long-arrow-left arrow-left"></i>  Back to Shopping 
              </a>
            </div>
          </div>
         </div>
         <div class="col-lg-6 col-md-6 col-sm-12 mt-5">
            <h4>Sign In</h4>
            <form class="login mloginform signin-form" action="{{ route('user.login.submit') }}" method="post">
               {{ csrf_field() }}
               @include('includes.admin.form-login')
               <div class="form-group mb-2">
                  <label>Username or email address *</label>
                  <input type="email" class="form-control" name="email" id="email" required placeholder="{{ $langg->lang173 }}">
               </div>
               <div class="form-group mb-2">
                  <label>Password *</label>
                  <input type="password" class="form-control" name="password" id="password" required placeholder="{{ $langg->lang174 }}">
               </div>
               <input type="hidden" name="modal" value="1">
               <input class="mauthdata" type="hidden" value="{{ $langg->lang177 }}">
               <div class="form-checkbox d-flex align-items-center justify-content-between mb-2">
                  <input type="checkbox" class="custom-checkbox" id="remember1" name="remember1" required="" {{ old('remember') ? 'checked' : '' }}>
                  <label for="remember1">Remember me</label>
                  <a href="{{ route('user-forgot') }}">Lost your password?</a>
               </div>
               <input type="submit" class="btn btn-primary submit-btn" name="login" />
            </form>
         </div>
      </div>
   </div>
</div>
@endsection