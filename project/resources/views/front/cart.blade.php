@extends('layouts.jbs')
@section('body-class', 'page home page-template-default')
@section('content')
<!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li class="active"><a href="{{ url('') }}">Home</a></li>
                        <li><a href="javascript:;">Cart</a></li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                    <div class="row gutter-lg mb-10">
                        <div class="col-lg-8 pr-lg-4 mb-6">
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
                                                <a href="javascript:void(0)" class="btn btn-close   cart-remove" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}"><i
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
                            
                            <div class="cart-action mb-6">
                                <a href="{{ route('front.category') }}" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i class="w-icon-long-arrow-left"></i>Continue Shopping</a>
                            </div>
                            
                            <!-- <form class="coupon">
                                <h5 class="title coupon-title font-weight-bold text-uppercase">Coupon Discount</h5>
                                <input type="text" class="form-control mb-4" placeholder="Enter coupon code here..." required />
                                <button class="btn btn-dark btn-outline btn-rounded">Apply Coupon</button>
                            </form> -->
                        </div>
                        <div class="col-lg-4 sticky-sidebar-wrapper">
                            <div class="sticky-sidebar">
                                <div class="cart-summary mb-4">
                                    <h3 class="cart-title text-uppercase">Cart Totals</h3>
                                    <div class="cart-subtotal d-flex align-items-center justify-content-between ">
                                        <label class="ls-25 ">Subtotal</label>
                                        <span class="cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice) : '0.00' }}</span>
                                    </div>
                                     <div class="cart-subtotal d-flex align-items-center justify-content-between ">
                                        <label class="ls-25 ">{{ $langg->lang129 }}</label>
                                        <span class="discount">{{ App\Models\Product::convertPrice(0)}}</span>
                                        <input type="hidden" id="d-val" value="{{ App\Models\Product::convertPrice(0)}}">
                                    </div>
                                    <div class="cart-subtotal d-flex align-items-center justify-content-between">
                                        <label class="ls-25">{{ $langg->lang130 }}</label>
                                        <span class="cart-subtotal">{{$tx ?? 0}}%</span>
                                    </div>
                                    

                                    <hr class="divider">


                                    <div class="shipping-calculator">
                                        <form class="woocommerce-shipping-calculator d-none" method="post" action="#">
                                            <p>
                                                <a class="shipping-calculator-button" data-toggle="collapse" href="#shipping-form" aria-expanded="false" aria-controls="shipping-form">Calculate shipping</a>
                                            </p>
                                            <div class="collapse" id="shipping-form">
                                                <div class="shipping-calculator-form">
                                                    <p id="calc_shipping_country_field" class="form-row form-row-wide">
                                                        <select rel="calc_shipping_state" class="country_to_state" id="calc_shipping_country" name="calc_shipping_country">
                                                            <option value="">Select a country…</option>
                                                            <option value="AX">Åland Islands</option>
                                                            <option value="AF">Afghanistan</option>
                                                            <option value="AL">Albania</option>
                                                            <option value="DZ">Algeria</option>
                                                            <option value="AS">American Samoa</option>
                                                            <option value="AD">Andorra</option>
                                                            <option value="AO">Angola</option>
                                                            <option value="AI">Anguilla</option>
                                                            <option value="AQ">Antarctica</option>
                                                            <option value="AG">Antigua and Barbuda</option>
                                                            <option value="AR">Argentina</option>
                                                            <option value="AM">Armenia</option>
                                                            <option value="AW">Aruba</option>
                                                            <option value="AU">Australia</option>
                                                            <option value="AT">Austria</option>
                                                            <option value="AZ">Azerbaijan</option>
                                                        </select>
                                                    </p>
                                                    <p id="calc_shipping_state_field" class="form-row form-row-wide validate-required">
                                                        <span>
                                                            <select id="calc_shipping_state" name="calc_shipping_state">
                                                                <option value="">Select an option…</option>
                                                                <option value="AP">Andhra Pradesh</option>
                                                                <option value="AR">Arunachal Pradesh</option>
                                                                <option value="AS">Assam</option>
                                                                <option value="BR">Bihar</option>
                                                                <option value="CT">Chhattisgarh</option>
                                                                <option value="GA">Goa</option>
                                                                <option value="GJ">Gujarat</option>
                                                                <option value="HR">Haryana</option>
                                                                <option value="HP">Himachal Pradesh</option>
                                                                <option value="JK">Jammu and Kashmir</option>
                                                                <option value="JH">Jharkhand</option>
                                                                <option value="KA">Karnataka</option>
                                                                <option value="KL">Kerala</option>
                                                                <option value="MP">Madhya Pradesh</option>
                                                                <option value="MH">Maharashtra</option>
                                                                <option value="MN">Manipur</option>
                                                                <option value="ML">Meghalaya</option>
                                                                <option value="MZ">Mizoram</option>
                                                                <option value="NL">Nagaland</option>
                                                                <option value="OR">Orissa</option>
                                                                <option value="PB">Punjab</option>
                                                                <option value="RJ">Rajasthan</option>
                                                                <option value="SK">Sikkim</option>
                                                                <option value="TN">Tamil Nadu</option>
                                                                <option value="TS">Telangana</option>
                                                                <option value="TR">Tripura</option>
                                                                <option value="UK">Uttarakhand</option>
                                                                <option value="UP">Uttar Pradesh</option>
                                                                <option value="WB">West Bengal</option>
                                                                <option value="AN">Andaman and Nicobar Islands</option>
                                                                <option value="CH">Chandigarh</option>
                                                                <option value="DN">Dadra and Nagar Haveli</option>
                                                                <option value="DD">Daman and Diu</option>
                                                                <option value="DL">Delhi</option>
                                                                <option value="LD">Lakshadeep</option>
                                                                <option value="PY">Pondicherry (Puducherry)</option>
                                                            </select>
                                                        </span>
                                                    </p>
                                                    <p id="calc_shipping_postcode_field" class="form-row form-row-wide validate-required">
                                                        <input type="text" id="calc_shipping_postcode" name="calc_shipping_postcode" placeholder="Postcode / ZIP" value="" class="input-text">
                                                    </p>
                                                    <p><button class="button" value="1" name="calc_shipping" type="submit">Update totals</button></p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <hr class="divider mb-6">
                                    <div class="cart-subtotal d-flex justify-content-between align-items-center">
                                        <label>{{ $langg->lang131 }}</label>
                                        <span class="ls-50 main-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($mainTotal) : '0.00' }}</span>
                                    </div>
                                    <a href="{{ route('check.guest') }}"
                                        class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                                        Proceed to checkout<i class="w-icon-long-arrow-right"></i></a>
                                </div>
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