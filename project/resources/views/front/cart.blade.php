@extends('layouts.jbs')
@section('body-class', 'page home page-template-default')
@section('content')
<!-- Start of Breadcrumb -->
<div style="padding: 40px 0px; margin-bottom: 30px;">
                <nav class="breadcrumb-nav">
                    <div class="container">
                        <ul style="margin: 0 !important;" class="breadcrumb shop-breadcrumb bb-no">
                            <li class="active"><a href="{{ url('') }}">Home</a></li>
                            <li><a href="javascript:;">Cart</a></li>
                        </ul>
                    </div>
                </nav>
                <!-- End of Breadcrumb -->

                <!-- Start of PageContent -->
                <div class="page-content">
                    <div class="container">
                        <div style="width: 67%; margin: auto; border-radius: 8px; border: 2px solid #c12228; padding: 25px; box-shadow: rgba(93, 50, 50, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;">
                            <table class="shop-table cart-table">
                                <thead>
                                    <tr>
                                        <th class="product-name"><span>Product</span></th>
                                        <th></th>
                                        <th class="product-price"><span>Price</span></th>
                                        <th class="product-quantity"><span>Quantity</span></th>
                                        <th class="product-subtotal"><span>Subtotal</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@if(Session::has('cart'))
									@foreach($products as $product)
                                    <tr class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}">
                                        <td class="product-thumbnail">
                                            <div class="p-relative">
                                                <a href="{{ route('front.product', $product['item']['slug']) }}">
                                                    <figure>
                                                        <img src="{{ $product['item']['photo'] }}" alt="product"
                                                            width="300" height="338">
                                                    </figure>
                                                </a>
                                                <a href="javascript:void(0)" class="btn btn-close cart-remove" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}"><i
                                                        class="fas fa-times"></i></a>
                                            </div>
                                        </td>
                                        <td class="product-name">
                                            <a href="{{ route('front.product', $product['item']['slug']) }}">
                                               {{mb_strlen($product['item']['name'],'utf-8') > 50 ? mb_substr($product['item']['name'],0,50,'utf-8').'...' : $product['item']['name']}}
                                            </a>
                                        </td>
                                        <td class="product-price"><span class="amount">{{ App\Models\Product::convertPrice($product['item']['price']) }}   </span></td>
                                        <td class="product-quantity">
                                            <div class="input-group">
                                            	<input type="hidden" class="prodid" value="{{$product['item']['id']}}">  
                                                <input type="hidden" class="itemid" value="{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">     
                                                <input type="hidden" class="size_qty" value="{{$product['size_qty']}}">     
                                                <input type="hidden" class="size_price" value="{{$product['item']['price']}}">
                                                 <span class="qttotal1" id="qty{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">{{ $product['qty'] }}</span>  
                                                <button class="quantity-plus w-icon-plus qtplus1 adding"></button>
                                                 
                                                <button class="quantity-minus w-icon-minus  qtminus1 reducing"></button>
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice) : '0.00' }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4">
                                            No products in cart...
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div style="display: flex;">
                                <a href="{{ route('front.category') }}" style="border-radius: 8px 0px 0px 8px; width: 100%; padding: 10px 0px; border: 3px solid #c12228; display:flex; align-items:center; justify-content: center; color:#c12228;">
                                    <i class="w-icon-long-arrow-left"></i>
                                    Continue Shopping
                                </a>
                                <a href="{{ route('check.guest') }}" style="border-radius: 0px 8px 8px 0px;  background-color: #c12228; width: 100%; color: #fff; display:flex; align-items:center; justify-content: center; padding: 10px 0px;">
                                    Proceed to checkout
                                    <i class="w-icon-long-arrow-right"></i>
                                </a>
                            </div>
                            
                           
                        </div>
                    </div>
                </div>
            </div>
                <!-- End of PageContent -->
<!-- #content -->
@endsection
@section('scripts')
<script type="text/javascript">
  $(".disp-prod2").change(function () {
     $(".disp-prod1").val($(this).val());
     $("#cat-prods-form")[0].submit();
  });

  $("#goto-page").change(function () {
    let page = $(this).val();
    let max = $(this).data("max");
      if(page > max){
        $(this).val(max);
        page = max;
      }
     $("#cat-prods-form")[0].submit();
  });

  $(".layout-chng").click(function () {
     $("#pge_layout").val($(this).data("layout"));
     $("#cat-prods-form")[0].submit();
  });

  $(".filterPrice").click(function () {
     $("#goto-page").val(1);
     $("#cat-prods-form")[0].submit();
  });
  
</script>
@endsection