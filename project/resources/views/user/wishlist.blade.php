@extends('layouts.jbs')
@section('content')
<div id="content" class="site-content" tabindex="-1">
  <div class="col-full">
     <div class="row">
        <nav class="breadcrumb-nav">
           <div class="container">
              <ul class="breadcrumb bb-no">
                 <li><a href="{{ url('/') }}">Home</a></li>
                 <li><a href="javascript:;">Wishlist</a></li>
              </ul>
           </div>
        </nav>
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
                                            Wishlist
                                         </h4>
                                      </div>
                                      <div class="mr-table allproduct mt-4">
                                         <div class="table-responsive">
                                            <form class="woocommerce" method="post" action="#">
        
                                                <table class="shop_table cart wishlist_table">
                                                    <thead>
                                                        <tr>
                                                            <th class="product-remove"></th>

                                                            <th class="product-thumbnail"></th>

                                                            <th class="product-name">
                                                                <span class="nobr">Product Name</span>
                                                            </th>


                                                            <th class="product-price">
                                                                <span class="nobr">
                                                                    Unit Price                    
                                                                </span>
                                                            </th>


                                                            <th class="product-stock-status">
                                                                <span class="nobr">
                                                                    Stock Status                    
                                                                </span>
                                                            </th>

                                                            <th class="product-add-to-cart"></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                      @if(count($wishlists) > 0)
                                                      @foreach($wishlists->items() as $wishlist)

                                                      @php
                                                        $prodd = App\Models\Product::find($wishlist->product_id);
                                                      @endphp
                                                        <tr>

                                                            <td class="product-remove">
                                                                <div>
                                                                    <a title="Remove this product" class="remove remove_from_wishlist remove wishlist-remove" href="javascript: void(0);"  data-href="{{ route('user-wishlist-remove', $wishlist->id ) }}">×</a>
                                                                </div>
                                                            </td>

                                                            <td class="product-thumbnail">
                                                                <a href="{{ route('front.product', $prodd->slug) }}">
                                                                    <img width="180" height="180" alt="" class="wp-post-image" src="{{ $prodd->photo ? $prodd->photo : asset('assets/images/noimage.pngp') }}">                            
                                                                </a>
                                                            </td>

                                                            <td class="product-name">
                                                                <a href="{{ route('front.product', $prodd->slug) }}">{{ $prodd->name }}</a>
                                                            </td>

                                                            <td class="product-price">
                                                                <ins>
                                                                  <span class="woocommerce-Price-amount amount">
                                                                    {{ $prodd->showPrice() }}
                                                                  </span>
                                                                </ins> 

                                                                <del>
                                                                  <span class="woocommerce-Price-amount amount">
                                                                    {{ $prodd->showPreviousPrice() }}
                                                                  </span>
                                                                </del>                            
                                                            </td>

                                                            <td class="product-stock-status">
                                                                <span class="wishlist-in-stock">{{ $gs->show_stock == 0 ? '' : $prodd->stock }} {{ $langg->lang79 }}</span>                            
                                                            </td>

                                                            <td class="product-add-to-cart">
                                                                <a class="button add_to_cart_button button alt" href="{{ route('front.product', $prodd->slug) }}"> View Product</a>
                                                            </td>
                                                        </tr>
                                                      @endforeach
                                                      @endif
                                                    </tbody>
                                                </table><!-- .wishlist_table -->
                                            </form>
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