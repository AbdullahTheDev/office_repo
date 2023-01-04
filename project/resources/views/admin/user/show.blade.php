@extends('layouts.admin')

@section('styles')

<style type="text/css">
    .table-responsive {
    overflow-x: hidden;
}
table#example2 {
    margin-left: 10px;
}

</style>

@endsection

@section('content')

                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __("Customer Details") }} <a class="add-btn" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> {{ __("Back") }}</a></h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">{{ __("Dashboard") }} </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-user-index') }}">{{ __("Customers") }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-user-show',$data->id) }}">{{ __("Details") }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                            <div class="add-product-content1 customar-details-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">
                                            <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="user-image">
                                                            @if($data->is_provider == 1)
                                                            <img src="{{ $data->photo ? asset($data->photo):asset('assets/images/'.$gs->user_image)}}" alt="No Image">
                                                            @else
                                                            <img src="{{ $data->photo ? asset('assets/images/users/'.$data->photo):asset('assets/images/'.$gs->user_image)}}" alt="No Image">                                            
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                        <table class="table">
                                                        <tr>
                                                            <th>{{ __("ID#") }}</th>
                                                            <td>{{$data->id}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Name") }}</th>
                                                            <td>{{$data->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Email") }}</th>
                                                            <td>{{$data->email}}</td>
                                                        </tr>
                                                        <tr>
                                                                <th>{{ __("Phone") }}</th>
                                                                <td>{{$data->phone}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{ __("Address") }}</th>
                                                                <td>{{$data->address}}</td>
                                                            </tr>

                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                    <table class="table">
                                                            
                                                            @if($data->city != null)
                                                            <tr>
                                                                <th>{{ __("City") }}</th>
                                                                <td>{{$data->city}}</td>
                                                            </tr>
                                                            @endif
                                                            @if($data->fax != null)
                                                            <tr>
                                                                <th>{{ __("Fax") }}</th>
                                                                <td>{{$data->fax}}</td>
                                                            </tr>
                                                            @endif
                                                            @if($data->zip != null)
                                                            <tr>
                                                                <th>{{ __("Zip Code") }}</th>
                                                                <td>{{$data->zip}}</td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <th>{{ __("Joined") }}</th>
                                                                <td>{{$data->created_at->diffForHumans()}}</td>
                                                            </tr>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-table-wrap">
                                                <div class="order-details-table">
                                                    <div class="mr-table">
                                                        <h4 class="title">{{ __("Products Ordered") }}</h4>
                                                        <div class="table-responsive">
                                                                <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>{{ __("Order ID") }}</th>
                                                                            <th>{{ __("Purchase Date") }}</th>
                                                                            <th>{{ __("Amount") }}</th>
                                                                            <th>{{ __("Status") }}</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($data->orders as $order)
                                                                        <tr>
            <td><a href="{{ route('admin-order-invoice',$order->id) }}">{{sprintf("%'.08d", $order->id)}}</a></td>
                                                                            <td>{{ date('Y-m-d h:i:s a',strtotime($order->created_at)) }}</td>
                                                                            <td>{{ $order->currency_sign . round($order->pay_amount * $order->currency_value , 2) }}</td>
                                                                            <td>{{ $order->status }}</td>
                                                                            <td>
                                                                                <a href=" {{ route('admin-order-show',$order->id) }}" class="view-details">
                                                                                    <i class="fas fa-check"></i>{{ __("Details") }}
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

@endsection

@section('scripts')

<script type="text/javascript">
$('#example2').dataTable( {
  "ordering": false,
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'responsive'  : true
} );
</script>


@endsection