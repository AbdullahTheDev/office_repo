@extends('layouts.jbs')
@section('content')
<div id="content" class="site-content" tabindex="-1">
  <div class="col-full">
   <div class="row">
      <nav class="breadcrumb-nav">
         <div class="container">
            <ul class="breadcrumb bb-no">
               <li><a href="{{ url('/') }}">Home</a></li>
               <li><a href="javascript:;">Account</a></li>
            </ul>
         </div>
      </nav>
      <div id="primary" class="content-area">
         <main id="main" class="site-main">
            <div class="container">
               <header class="entry-header">
                  <div class="page-header-caption">
                     <h1 class="entry-title">My Account</h1>
                  </div>
               </header>
               <!-- .entry-header -->
               <div class="container">
                  <div class="row">
                     @include('includes.dashboardsidebar')
                     <div class="col-xl-8 col-lg-8 col-md-8">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="user-profile-details">
                                 <div class="account-info wallet">
                                    <div class="header-area">
                                       <h4 class="title">
                                          {{ isset($langg->lang808) ? $langg->lang808 : 'Recent Orders' }}
                                       </h4>
                                    </div>
                                    <div class="edit-info-area">
                                    </div>
                                    <div class="main-info">
                                       <div class="mr-table allproduct mt-4">
                                          <div class="table-responsiv">
                                             <table class="shop-table account-orders-table mb-6" cellspacing="0" width="100%">
                                                <thead>
                                                   <tr>
                                                      <th>{{ $langg->lang278 }}</th>
                                                      <th>{{ $langg->lang279 }}</th>
                                                      <th>{{ $langg->lang280 }}</th>
                                                      <th>{{ $langg->lang281 }}</th>
                                                      <th>{{ $langg->lang282 }}</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   @foreach(Auth::user()->orders()->latest()->take(5)->get() as $order)
                                                    <tr>
                                                      {{-- {{$random}} --}}
                                                      {{-- {{
                                                         $order
                                                      }} --}}
                                                      <td>
                                                          {{$order->order_number}}
                                                      </td>
                                                      <td>
                                                          {{date('d M Y',strtotime($order->created_at))}}
                                                      </td>
                                                      <td>
                                                          {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                                                      </td>
                                                      <td>
                                                        <div class="order-status {{ $order->status }}">
                                                            {{ucwords($order->status)}}
                                                        </div>
                                                      </td>
                                                      <td>
                                                        <a class="mybtn2 sm btn btn-info btn-sm" href="{{route('user-order',$order->id)}}">
                                                            {{ $langg->lang283 }}
                                                        </a>
                                                      </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
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