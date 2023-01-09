@extends('layouts.jbs')
@section('content')
<div id="content" class="site-content" tabindex="-1">
  <div class="col-full">
     <div class="row">
        {{-- <nav class="breadcrumb-nav">
           <div class="container">
              <ul class="breadcrumb bb-no">
                 <li><a href="{{ url('/') }}">Home</a></li>
                 <li><a href="javascript:;">Orders</a></li>
              </ul>
           </div>
        </nav> --}}
        <div id="primary" class="content-area">
           <main id="main" class="site-main">
              <div id="post-7" class="container">
                 <header class="entry-header">
                    <div class="page-header-caption">
                       <h1 class="entry-title">My Account</h1>
                    </div>
                 </header>
                 <!-- .entry-header -->
                 <div class="entry-content">
                    <div class="row">
                       @include('includes.dashboardsidebar')
                       <div class="col-xl-8 col-lg-8">
                          <div class="row">
                             <div class="col-lg-10">
                                <div class="user-profile-details">
                                   <div class="order-history">
                                      <div class="header-area">
                                         <h4 class="title">
                                            {{ $langg->lang277 }}
                                         </h4>
                                      </div>
                                      <div class="mr-table allproduct mt-4">
                                         <div class="table-responsive">
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
                                                  @foreach($orders as $order)
                                                  <tr>
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
                                                      <a class="mybtn2 sm btn btn-primary btn-sm" href="{{route('user-order',$order->id)}}">
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
@section('scripts')
<script>
    $(document).on("click", "#tid", function (e) {
        $(this).hide();
        $("#tc").show();
        $("#tin").show();
        $("#tbtn").show();
    });
    $(document).on("click", "#tc", function (e) {
        $(this).hide();
        $("#tid").show();
        $("#tin").hide();
        $("#tbtn").hide();
    });
    $(document).on("submit", "#tform", function (e) {
        var oid = $("#oid").val();
        var tin = $("#tin").val();
        $.ajax({
            type: "GET",
            url: "{{URL::to('user/json/trans')}}",
            data: {
                id: oid,
                tin: tin
            },
            success: function (data) {
                $("#ttn").html(data);
                $("#tin").val("");
                $("#tid").show();
                $("#tin").hide();
                $("#tbtn").hide();
                $("#tc").hide();
            }
        });
        return false;
    });
</script>
<script type="text/javascript">
    $(document).on('click', '#license', function (e) {
        var id = $(this).parent().find('input[type=hidden]').val();
        $('#key').html(id);
    });
</script>

@endsection