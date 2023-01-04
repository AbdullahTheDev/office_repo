@extends('layouts.jbs')
@section('content')
<div id="content" class="site-content" tabindex="-1">
  <div class="col-full">
     <div class="row">
        <nav class="breadcrumb-nav">
           <div class="container">
              <ul class="breadcrumb bb-no">
                 <li><a href="{{ url('/') }}">Home</a></li>
                 <li><a href="javascript:;">Profile</a></li>
              </ul>
           </div>
        </nav>
        <div id="primary" class="content-area">
           <main id="main" class="site-main">
              <div id="post-7" class="container">
                 <header class="entry-header">
                    <div class="page-header-caption">
                       <h1 class="entry-title">Profile</h1>
                    </div>
                 </header>
                 <!-- .entry-header -->
                 <div class="entry-content">
                    <div class="row">
                       @include('includes.dashboardsidebar')
                       <div class="col-xl-8 col-lg-8">
                           <div class="tab-pane" id="account-details">
                               <div class="icon-box icon-box-side icon-box-light">
                                  <span class="icon-box-icon icon-account mr-2">
                                  <i class="w-icon-user"></i>
                                  </span>
                                  <div class="icon-box-content">
                                     <h4 class="icon-box-title mb-0 ls-normal">{{ $langg->lang262 }}</h4>
                                  </div>
                               </div>
                               @include('includes.admin.form-both')
                               <form id="userform" action="{{route('user-reset-submit')}}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-12">
                                            <input type="password" name="cpass"  class="input-field form-control mb-3" placeholder="{{ $langg->lang273 }}" value="" required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                            <input type="password" name="newpass"  class="input-field form-control mb-3" placeholder="{{ $langg->lang274 }}" value="" required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                            <input type="password" name="renewpass"  class="input-field form-control mb-3" placeholder="{{ $langg->lang275 }}" value="" required="">
                                    </div>
                                </div>

                                    <div class="form-links">
                                        <button class="submit-btn btn btn-dark btn-rounded btn-sm mb-4" type="submit">{{ $langg->lang276 }}</button>
                                    </div>
                            </form>
                           </div>
                        </div>
                    </div>
                 </div>
                 <!-- .entry-content -->
              </div>
              <!-- #post-## -->
           </main>
           <!-- #main -->
        </div>
        <!-- #primary -->
     </div>
     <!-- .col-full -->
  </div>
  <!-- .row -->
</div>
@endsection