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
                               <form class="form account-details-form" id="userform" action="{{route('user-profile-update')}}" method="POST" enctype="multipart/form-data">
                                  {{ csrf_field() }}
                                  @if($user->is_provider == 1)
                                  <div class="img"><img src="{{ $user->photo ? asset($user->photo):asset('assets/images/'.$gs->user_image) }}" width="100">
                                  </div>
                                  @else
                                    <div class="img"><img
                                            src="{{ $user->photo ? asset('assets/images/users/'.$user->photo):asset('assets/images/'.$gs->user_image) }}" width="100">
                                    </div>
                                    @endif
                                    @if($user->is_provider != 1)
                                    <div class="file-upload-area mt-3">
                                     <div class="upload-file">
                                        <input type="file" name="photo" class="upload">
                                     </div>
                                    </div>
                                  @endif
                                  <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="firstname">{{ $langg->lang264 }} </label>
                                           <input type="text" id="firstname" name="name" placeholder="{{ $langg->lang264 }}" class="form-control form-control-md" value="{{ $user->name }}">
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="email_1">{{ $langg->lang265 }} </label>
                                           <input type="email" id="email_1" name="email" class="form-control form-control-md" placeholder="{{ $langg->lang265 }}" required="" value="{{ $user->email }}" disabled="">
                                        </div>
                                     </div>
                                  </div>
                                  <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="firstname">{{ $langg->lang266 }} </label>
                                           <input name="phone" type="text" class="form-control form-control-md" placeholder="{{ $langg->lang266 }}" required="" value="{{ $user->phone }}">
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="email_1">{{ $langg->lang267 }} </label>
                                           <input name="fax" type="text" class="form-control form-control-md" placeholder="{{ $langg->lang267 }}" value="{{ $user->city }}">
                                        </div>
                                     </div>
                                  </div>
                                  <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="firstname">City </label>
                                           <input name="city" type="text" class="form-control form-control-md" placeholder="City" value="{{ $user->city }}">
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="email_1">{{ $langg->lang157 }} </label>
                                           <select class="form-control form-control-md" name="country">
                                              <option value="">{{ $langg->lang157 }}</option>
                                              @foreach (DB::table('countries')->get() as $data)
                                                <option value="{{ $data->country_name }}" {{ $user->country == $data->country_name ? 'selected' : '' }}>
                                                    {{ $data->country_name }}
                                                </option>   
                                             @endforeach
                                           </select>
                                        </div>
                                     </div>
                                  </div>
                                  <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="firstname">{{ $langg->lang269 }} </label>
                                           <input name="zip" type="text" class="form-control form-control-md" placeholder="{{ $langg->lang269 }}" value="{{ $user->zip }}">
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="email_1">{{ $langg->lang270 }}</label>
                                           <textarea class="form-control form-control-md" name="address" required="" placeholder="{{ $langg->lang270 }}">{{ $user->address }}</textarea>
                                        </div>
                                     </div>
                                  </div>
                                  <button class="submit-btn btn btn-dark btn-rounded btn-sm mb-4" type="submit">{{ $langg->lang271 }}</button>
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