@extends('layouts.jbs')
@section('body-class', 'woocommerce-active page-template-default woocommerce-checkout woocommerce-page can-uppercase')
@section('content')
<main class="main">
   <!-- .header-v1 -->
   <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb shop-breadcrumb bb-no">
            <li class="passed"><a href="{{ url('/carts') }}">Shopping Cart</a></li>
            <li class="active"><a href="javascript:;">Checkout</a></li>
            <li><a href="javascript:;">Order Complete</a></li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->
   <!-- Start of PageContent -->
   <div class="page-content">
      <div class="container">
         <div class="row">
            <div class="col-lg-7 pr-lg-4 mb-4">
               <div class="alert alert-info mb-2">
                  Having trouble with your order? or Have any questions?<br> Please call customer service ( {{ $gs->working_hours }} ) <a class="text-white" href="tel: {{ $gs->phone }}">{{ $gs->phone }}</a>
               </div>
               @include('includes.form-success')
               @include('includes.form-error')
            </div>
         </div>
         <form class="form checkout-form checkoutform" action="" method="post" name="checkout">
            @csrf    
            
            <div class="row mb-9">
               <div class="col-lg-7 pr-lg-4 mb-4">
                  <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                     Billing Details
                  </h3>
                  <div class="row gutter-sm">
                     <div class="col-xs-6">
                        <div class="form-group">
                           <label>Full name *</label>
                           <input class="form-control form-control-md onlyAlphaNumber" type="text" name="name"
                              placeholder="{{ $langg->lang152 }}" required=""
                              value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->name : old('name') }}" autofocus="">
                        </div>
                     </div>
                     <div class="col-xs-6">
                        <div class="form-group">
                           <label>Phone  *</label>
                           <input class="form-control form-control-md" type="text" name="phone"
                              placeholder="{{ $langg->lang153 }}" required=""
                              onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                              value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->phone : old('phone') }}">
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label>Email *</label>
                     <input class="form-control form-control-md" type="email" name="email"
                        placeholder="{{ $langg->lang154 }}" required=""
                        value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->email : old('email') }}">
                  </div>
                  <div class="form-group">
                     <label class="" for="billing_address_1">Address<abbr title="required" class="required">*</abbr></label>
                     <input class="form-control form-control-md " placeholder="Please Enter Your Complete Address" required type="text" name="address" spellcheck="true"  autocomplete="nope" value="{{ old('address') }}"/>
                  </div>
                  <div class="form-group">
                     <label>Country / Region *</label>
                     <div class="">
                        <select class="select2 form-control form-control-md ship-field" name="customer_country" required="" id="country">
                           @foreach(\DB::table('countries')->whereIn('country_code',['US','CA','GB','DE','AN','NL','FR','IT','IE','DK','BE','SE','FI','LU'])->get() as $country)
                           <option data-id="{{ $country->id }}" value="{{ $country->country_code }}" {{ $country->country_code == "US" ? 'selected' : '' }}>{{ $country->country_name }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="row gutter-sm">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>State *</label>
                           <div class="">
                              <select class="select2 form-control form-control-md ship-field" name="state" required="" id="administrative_area_level_1">
                                 <option value="">Select Country First!</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Town / City *</label>
                           <input class="form-control form-control-md ship-field" placeholder="{{ $langg->lang158 }}" type="text" required id="locality" name="city" spellcheck="true" value="{{ old('city') }}">
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label>ZIP *</label>
                           <input class="form-control form-control-md ship-field" placeholder="{{ $langg->lang159 }}" type="text" required id="postal_code" name="zip" spellcheck="true" value="{{ old('zip') }}">
                        </div>
                     </div>
                  </div>
                  <div class="form-group mb-7">
                     <label class="" for="billing_address_1">Company Name <abbr title="optional">(optional)</abbr></label>
                     <input class="form-control form-control-md" placeholder="Company Name" type="text" id="company_name" name="company_name" value="{{ old('company_name') }}">
                  </div>
                  <div class="form-group checkbox-toggle pb-2">
                     <input type="checkbox" class="custom-checkbox" id="shipping-toggle"
                        name="shipping-toggle">
                     <label for="shipping-toggle">Ship to a different address?</label>
                  </div>
                  <div class="checkbox-content" style="display:none;">
                     <div class="shipping_address" id="shipping-address">
                        <div class="row">
                           <p id="shipping_first_name_field" class="col-md-6 validate-required">
                              <label class="" for="shipping_first_name">Full name <abbr title="required" class="required">*</abbr></label>
                              <input class="form-control ship_input onlyAlphaNumber" type="text" name="shipping_name"
                                 id="shippingFull_name" placeholder="{{ $langg->lang152 }}" value="{{ old('shipping_name') }}">
                              <input type="hidden" name="shipping_email" value="">
                           </p>
                           <p id="shipping_last_name_field" class="col-md-6 validate-required">
                              <label class="" for="shipping_last_name">Phone <abbr title="required" class="required">*</abbr></label>
                              <input class="form-control ship_input" type="number" name="shipping_phone"
                                 id="shipingPhone_number" placeholder="{{ $langg->lang153 }}" value="{{ old('shipping_phone') }}">
                           </p>
                           <p id="shipping_company_field" class="col-md-12">
                              <label class=" ship-field" for="shipping_company">Address</label>
                              <input class="form-control form-control-lg ship-field" placeholder="Please Enter Your Complete Address" type="text" name="shipping_address" spellcheck="true"  autocomplete="nope" value="{{ old('shipping_address') }}"/>
                           </p>
                           <p id="shipping_country_field" class="col-md-6 address-field update_totals_on_change validate-required woocommerce-validated">
                              <label class="" for="shipping_country">Country Code<abbr title="required" class="required">*</abbr></label>
                              <select class="form-control" name="shipping_country" required="" id="country_2">
                                 <option value="">Select Country</option>
                                 @foreach(\DB::table('countries')->whereIn('country_code',['US','CA','GB','DE','AN','NL','FR','IT','IE','DK','BE','SE','FI','LU'])->get() as $country)
                                 <option data-id="{{ $country->id }}" value="{{ $country->country_code }}" {{ $country->country_code == "US" ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                 @endforeach
                              </select>
                           </p>
                           <p id="shipping_state_field" class="col-md-6 address-field validate-required">
                              <label class="" for="shipping_state">State Code <abbr title="required" class="required">*</abbr></label>
                              <select class="form-control" name="shipping_state" id="administrative_area_level_1_2">
                                 <option value="">Select Country First!</option>
                              </select>
                           </p>
                           <p id="shipping_city_field" class="col-md-6 address-field validate-required">
                              <label class="" for="shipping_city">Town / City <abbr title="required" class="required">*</abbr></label>
                              <input class="form-control form-control-sm ship-field" placeholder="{{ $langg->lang158 }}" type="text" id="locality_2" name="shipping_city" spellcheck="true" value="{{ old('shipping_city') }}">
                           </p>
                           <p data-priority="90" id="shipping_postcode_field" class="col-md-6 address-field validate-postcode validate-required">
                              <label class="" for="shipping_postcode">Postcode / ZIP <abbr title="required" class="required">*</abbr></label>
                              <input class="form-control form-control-sm ship-field" placeholder="{{ $langg->lang159 }}" type="text" id="postal_code_2" name="shipping_zip" spellcheck="true" value="{{ old('shipping_zip') }}">
                           </p>
                        </div>
                        <!-- .woocommerce-shipping-fields__field-wrapper -->
                     </div>
                  </div>
                  <div class="form-group mt-3">
                     <label for="order-notes">Order notes (optional)</label>
                     <textarea class="form-control mb-0" id="order-notes" name="order_notes" cols="30"
                        rows="4"
                        placeholder="Notes about your order, e.g special notes for delivery"></textarea>
                  </div>
               </div>
               <div class="col-lg-5 mb-4 sticky-sidebar-wrapper">
                  <div class="order-summary-wrapper sticky-sidebar">
                     <h3 class="title text-uppercase ls-10">Your Order</h3>
                     <div class="order-summary">
                        <table class="shop_table woocommerce-checkout-review-order-table order-table table table-responsive">
                           <thead>
                              <tr>
                                 <th class="product-name">Product</th>
                                 <th class="product-total">Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($products as $product)
                              <tr class="cart_item">
                                 <td class="product-name"> <strong class="product-quantity">{{ $product['qty'] }} ×</strong> {{ $product['item']['name'] }} </td>
                                 <td class="product-total"> 
                                    <span class="woocommerce-Price-amount amount">
                                       {{ App\Models\Product::convertPrice($product['price']) }}
                                    </span>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                           <tfoot>
                              <tr class="cart-subtotal">
                                 <th>Subtotal</th>
                                 <td>
                                    <span class="woocommerce-Price-amount amount">
                                       {{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00' }}
                                       @php
                                           if (Session::has('currency'))
                                           {
                                                $curr = \App\Models\Currency::find(\Session::get('currency'));
                                            }
                                            else
                                            {
                                                $curr = \App\Models\Currency::where('is_default','=',1)->first();
                                            }
                                            if(\Session::has('cart')){
                                                $subtotal = round(\Session::get('cart')->totalPrice * $curr->value,2);
                                            }else{
                                                $subtotal = 0.00;
                                            }
                                       @endphp
                                       <input type="hidden" name="subtotal" value="{{ $subtotal }}"/>
                                       <input type="hidden" name="sub_tax" value="" />
                                    </span>
                                 </td>
                              </tr>
                              @if($gs->tax != 0)
                              <tr class="cart-subtotal">
                                 <th>Tax</th>
                                 <td>
                                    <span class="woocommerce-Price-amount amount">
                                       {{$gs->tax}}%
                                    </span>
                                 </td>
                              </tr>
                              @endif
                              <tr class="order-total">
                                 <th>Total</th>
                                 <td>
                                    <strong>
                                       <span class="woocommerce-Price-amount amount">
                                          @if(Session::has('coupon_total'))
                                             @if($gs->currency_format == 0)
                                                <span id="total-cost">{{ $curr->sign }}{{ $totalPrice }}</span>
                                             @else 
                                                <span id="total-cost">{{ $totalPrice }}{{ $curr->sign }}</span>
                                             @endif

                                          @elseif(Session::has('coupon_total1'))
                                             <span id="total-cost"> {{ Session::get('coupon_total1') }}</span>
                                             @else
                                             <span id="total-cost">{{ App\Models\Product::convertPrice($totalPrice) }}</span>
                                          @endif
                                       </span>
                                    </strong> 
                                 </td>
                              </tr>
                           </tfoot>
                        </table>
                        <div class="woocommerce-checkout-payment to-disp" id="payment">
                           <div id="shipments" class="mt-3">
                              @foreach($shipping_data as $data)
                                 <!-- <div class="radio-design">
                                       <input type="radio" class="shipping" id="free-shepping{{ $data->id }}" name="ship_type" value="{{ round($data->price * $curr->value,2) }}" {{ ($loop->first) ? 'checked' : '' }}> 
                                       <label for="free-shepping{{ $data->id }}"> 
                                             {{ $data->title }}
                                             @if($data->price != 0)
                                             + {{ $curr->sign }}{{ round($data->price * $curr->value,2) }}
                                             @endif
                                             <small>{{ $data->subtitle }}</small>
                                       </label>
                                 </div> -->
                              @endforeach
                           </div>
                        <!-- <div class="payment-methods" id="payment_method"> -->
                           <h4 class="title font-weight-bold ls-25 mt-3">Payment Methods</h4>
                           <div class="accordion payment-accordion">
                              @if($gs->paypal_check == 1)
                              <div class="card">
                                 <div class="card-header">
                                    <input type="radio" required name="pay" class="payment" data-val="" data-show="no" data-form="{{route('paypal.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'paypal','slug2' => 0]) }}" id="v-pills-tab1-tab" data-toggle="pill" href="#v-pills-tab1" role="tab" aria-controls="v-pills-tab1" aria-selected="true"> {{ $langg->lang760 }}
                                    @if($gs->paypal_text != null)
                                    <small>
                                       {{ $gs->paypal_text }}
                                    </small>
                                    @endif
                                 </div>
                                 <div id="v-pills-tab1" class="card-body payarea">
                                 </div>
                              </div>
                              @endif
                              @if($gs->stripe_check == 1)
                              <div class="card">
                                 <div class="card-header">
                                    <input type="radio" required name="pay" class="payment" data-val="" data-show="yes" data-form="{{route('stripe.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'stripe','slug2' => 0]) }}" id="v-pills-tab2-tab" data-toggle="pill" href="#v-pills-tab2" role="tab" aria-controls="v-pills-tab2" aria-selected="false"> {{ $langg->lang761 }}
                                    @if($gs->stripe_text != null)
                                    <small>
                                       {{ $gs->stripe_text }}
                                    </small>
                                    @endif
                                 </div>
                                 <div id="v-pills-tab2" class="card-body payarea">
                                 </div>
                              </div>
                              @endif
                              @if($gs->cod_check == 1)
                              @if($digital == 0)
                              <div class="card">
                                 <div class="card-header">
                                    <input type="radio" required name="pay" class="payment" data-val="" data-show="no" data-form="{{route('cash.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'cod','slug2' => 0]) }}" id="v-pills-tab3-tab" data-toggle="pill" href="#v-pills-tab3" role="tab" aria-controls="v-pills-tab3" aria-selected="false"> {{ $langg->lang762 }}
                                    @if($gs->cod_text != null)
                                    <small>
                                       {{ $gs->cod_text }}
                                    </small>
                                    @endif
                                 </div>
                                 <div id="v-pills-tab3" class="card-body payarea">
                                 </div>
                              </div>
                              @endif
                              @endif
                           </div>
                           <div class="form-row place-order">
                              <p class="form-row terms wc-terms-and-conditions woocommerce-validated">
                                 <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                    <input type="checkbox" id="terms" name="terms" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" required=""> <span>I’ve read and accept the <a class="woocommerce-terms-and-conditions-link" target="_blank" href="{{ url('') }}/terms-and-conditions">terms &amp; conditions</a></span> <span class="required">*</span> </label>
                                 <input type="hidden" value="1" name="terms-field"> 
                                 <input type="hidden" id="shipping-cost" name="shipping_cost" value="0">
                                        <input type="hidden" id="packing-cost" name="packing_cost" value="0">
                                        <input type="hidden" name="dp" value="{{$digital}}">
                                        <input type="hidden" name="tax" value="{{$gs->tax}}">
                                        <input type="hidden" name="totalQty" value="{{$totalQty}}">
                                        <input type="hidden" name="shipping" value="shipto">

                                        <input type="hidden" name="vendor_shipping_id" value="{{ $vendor_shipping_id }}">
                                        <input type="hidden" name="vendor_packing_id" value="{{ $vendor_packing_id }}">
                                        @if(Session::has('coupon_total'))
                                          <input type="hidden" name="total" id="grandtotal" value="{{ $totalPrice }}">
                                          <input type="hidden" id="tgrandtotal" value="{{ $totalPrice }}">
                                 @elseif(Session::has('coupon_total1'))
                                    <input type="hidden" name="total" id="grandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
                                    <input type="hidden" id="tgrandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
                                 @else
                                          <input type="hidden" name="total" id="grandtotal" value="{{round($totalPrice * $curr->value,2)}}">
                                          <input type="hidden" id="tgrandtotal" value="{{round($totalPrice * $curr->value,2)}}">
                                 @endif


                                        <input type="hidden" name="coupon_code" id="coupon_code" value="{{ Session::has('coupon_code') ? Session::get('coupon_code') : '' }}">
                                        <input type="hidden" name="coupon_discount" id="coupon_discount" value="{{ Session::has('coupon') ? Session::get('coupon') : '' }}">
                                        <input type="hidden" name="coupon_id" id="coupon_id" value="{{ Session::has('coupon') ? Session::get('coupon_id') : '' }}">
                                        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->id : '' }}">

                              </p> 
                              <button type="submit" id="final-btn" class="btn btn-block btn-dark mybtn1 checkout-btn">Place Order</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
   <!-- End of PageContent -->
</main>
@endsection
@section('styles')
<style type="text/css">
	#preloader{
		position: fixed;
	    top: 0;
	    width: 100%;
	    height: 100%;
	    z-index: 99999;
	    background-color: transparent !important;
	}
</style>
@endsection
@section('scripts')
@php
 $coupon = Session::has('coupon') ? Session::get('coupon') : '0.00';   
@endphp
<script>
   let productArr = <?php echo json_encode($products); ?>;
   console.log(productArr);
   var items = [{
      id: productArr.item
   }];
   console.log(items);
</script>
<script>

   gtag("event", "purchase", {
       transaction_id: "T_12345_1",
       value: 25.42,
       tax: {!!$gs->tax!!},
       currency: "USD",
       coupon: {!!$coupon!!},
       items: [
       // If someone purchases more than one item, 
       // you can add those items to the items array
        {
         item_id: "SKU_12345",
         item_name: "Stan and Friends Tee",
         affiliation: "Google Merchandise Store",
         coupon: "SUMMER_FUN",
         discount: 2.22,
         index: 0,
         item_brand: "Google",
         item_category: "Apparel",
         item_category2: "Adult",
         item_category3: "Shirts",
         item_category4: "Crew",
         item_category5: "Short sleeve",
         item_list_id: "related_products",
         item_list_name: "Related Products",
         item_variant: "green",
         location_id: "ChIJIQBpAG2ahYAR_6128GcTUEo",
         price: 9.99,
         quantity: 1
       }]
   });
   </script>




<script type="text/javascript">
   var mainurl = "{{url('/')}}";
   var gs      = {!! json_encode($gs) !!};
   var langg    = {!! json_encode($langg) !!};
 </script>
<script type="text/javascript">

    loadShipping();
    
    function loadShipping(){
        if($('input[name="zip"]').val() != "" || $('input[name="shipping_zip"]').val() != ""){
            shipments();
        }
    }
    
    function reverse(array){
      return array.map((item,idx) => array[array.length-1-idx])
    }
    
   function shipments() {
      $("#final-btn").prop("disabled", true);
      let street = country = state = city = zip = "";
      var shipping_service = '{{ old('shipping_service') }}';
      if($("#ship-to-different-address-checkbox").is(":checked")){
         street = $("input[name='shipping_address']").val();
         country = $("select[name='shipping_country'] option:selected").val();
         state = $("select[name='shipping_state'] option:selected").val();
         city = $("input[name='shipping_city']").val();
         zip = $("input[name='shipping_zip']").val();
      }else{
         street = $("input[name='address']").val();
         country = $("select[name='customer_country'] option:selected").val();
         city = $("input[name='city']").val();
         state = $("select[name='state'] option:selected").val();
         zip = $("input[name='zip']").val();
      }

      // alert(street)
      // alert(country)
      // alert(state)
      // alert(city)
      // alert(zip)

      if(street != "" || country != "" || state != "" || city != "" || zip != ""){
         $("#preloader").show();
         // alert("LOC");
         $.ajax({
                    type: "GET",
                    url:mainurl+"/checkout/get_ship",
                    dataType: "json",
                    data:{street, country, state, city, zip},
                    success:function(data){
                        if(data.status){
                           var opts = `<h4 class="title font-weight-bold ls-25 mt-3">Shipping Methods</h4>`;
                           $("#shipments").empty();
                           $.each(data.rates, function (i, rate) {
                               if(rate.name == "FedEx Ground"){
                                   rate.name = "Ground";
                               }
                               if(shipping_service == rate.name+"___"+rate.amount){
                                   opts += `<div class="radio-design">
                                 <input type="radio" required class="shipping" id="free-shepping${i}" checked name="shipping_service" value="${rate.name+"___"+rate.amount}"> 
                                 <label for="free-shepping${i}"> 
                                       ${rate.name}
                                       + {{ $curr->sign }}
                                       <small>${rate.amount}</small>
                                 </label>
                              </div>`;   
                               }else{
                                   opts += `<div class="radio-design">
                                 <input type="radio" required class="shipping" id="free-shepping${i}" name="shipping_service" value="${rate.name+"___"+rate.amount}"> 
                                 <label for="free-shepping${i}"> 
                                       ${rate.name}
                                       + {{ $curr->sign }}
                                       <small>${rate.amount}</small>
                                 </label>
                              </div>`;
                               }
                              $("#shipments").html(opts);
                           });
                           $('.shipping:checked').change();
                           $("#final-btn").prop("disabled", false);
                        }else{
                            $("#shipments").empty();
                            var ship = $('.shipping-cost').find('.amount').text();
                            if(ship != ""){
                                ship = ship.split('$')[1];
                                $('.shipping-cost').remove();   
                            }else{
                                ship = 0;
                            }
                            var ototal = $('#grandtotal').val();
                            var ntotal = parseFloat(ototal) - parseFloat(ship);
                            $('#total-cost').text('$'+ntotal);
                            $('#tgrandtotal').val(ntotal);
                            $('#grandtotal').val(ntotal);
                        }
                     },
                     error:function(data){
                         console.log(data);
                        $("#final-btn").prop("disabled", true);
                     toastr.error("An error occured! please Re-enter address");
                     },
                     complete:function(){
                        $("#final-btn").prop("disabled", false);
                        $("#preloader").fadeOut();
                     }
              }); 
      }
   }
   var timer, delay = 1000;
   
   $(document).on("input",'input[name="zip"]',function(e){
       clearTimeout(timer);
        timer = setTimeout(function() {
         // alert("kk");
            shipments(); 
        }, delay );
   });
   
   $(document).on("input",'input[name="shipping_zip"]',function(e){
       clearTimeout(timer);
        timer = setTimeout(function() {
            shipments(); 
        }, delay );
   });
   
   
   function applyTax(_this){
       var subtotal = parseFloat($('input[name="subtotal"]').val());
       if(_this.val() == "TX"){
           var tax = parseFloat(( 6.25 / 100 ) * subtotal).toFixed(2);
           subtotal = parseFloat(subtotal) + parseFloat(tax);
           
           $('input[name="sub_tax"]').val(tax);
           $('.cart-tax').remove();
           $('.shop_table').find('tfoot tr:first').after(`<tr class="cart-tax">
               <th>Tax</th>
               <td>
                  <span class="woocommerce-Price-amount amount">
                  $${tax}
                  </span>
               </td>
            </tr>`);
            if($('.shipping').length > 0){
                mship = $('.shipping:checked').val();
                mship = mship.split("___");
                mship_text = mship[0];
                mship = mship[1];
                subtotal = parseFloat(subtotal) + parseFloat(mship);
            }
           $('#total-cost').text('$'+parseFloat(subtotal).toFixed(2));
           $('#grandtotal').val(subtotal);
           $('#tgrandtotal').val(subtotal);
           $('input[name="tax"]').val(6.25);
       }else if(_this.val() == "CA"){
           var tax = parseFloat(( 7.25 / 100 ) * subtotal).toFixed(2);
           subtotal = parseFloat(subtotal) + parseFloat(tax);
           
           $('input[name="sub_tax"]').val(tax);
           $('.cart-tax').remove();
           $('.shop_table').find('tfoot tr:first').after(`<tr class="cart-tax">
               <th>Tax</th>
               <td>
                  <span class="woocommerce-Price-amount amount">
                  $${tax}
                  </span>
               </td>
            </tr>`);
            if($('.shipping').length > 0){
                mship = $('.shipping:checked').val();
                mship = mship.split("___");
                mship_text = mship[0];
                mship = mship[1];
                subtotal = parseFloat(subtotal) + parseFloat(mship);
            }
           $('#total-cost').text('$'+parseFloat(subtotal).toFixed(2));
           $('#grandtotal').val(subtotal);
           $('#tgrandtotal').val(subtotal);
           $('input[name="tax"]').val(7.25);
       }else{
           if($('.cart-tax').length > 0){
              var subtotal = parseFloat($('input[name="subtotal"]').val());
              var tax = parseFloat($('input[name="sub_tax"]').val());
              var ototal = parseFloat($('#grandtotal').val());
              var ntotal = ototal - tax;
              $('#total-cost').text('$'+parseFloat(ntotal).toFixed(2));
              $('#grandtotal').val(ntotal);
              $('input[name="tax"]').val('');
              $('.cart-tax').remove();
           }
       }
   }
   
   $(document).on('change','select[name="state"]',function(e){
       applyTax($(this));
   });


    clearTimeout(timer);
    timer = setTimeout(function() {
        loadTax(); 
    }, delay );
    
   function loadTax(){
       if($('select[name="state"] option:selected').val() == "TX" || $('select[name="state"] option:selected').val() == "CA"){
           applyTax($('select[name="state"]'));
       }
   }

   $('a.payment:first').addClass('active');
   $('.checkoutform').prop('action',$('a.payment:first').data('form'));
   $($('a.payment:first').attr('href')).load($('a.payment:first').data('href'));
      var show = $('a.payment:first').data('show');
      if(show != 'no') {
         $('.pay-area').removeClass('d-none');
      }
      else {
         $('.pay-area').addClass('d-none');
      }
   $($('a.payment:first').attr('href')).addClass('active').addClass('show');
   
         $('.submit-loader').hide();
</script>


<script type="text/javascript">

var coup = 0;
var pos = 0;


var mship = $('.shipping').length > 0 ? $('.shipping').first().val() : 0;
var mpack = $('.packing').length > 0 ? $('.packing').first().val() : 0;
mship = parseFloat(mship);
mpack = parseFloat(mpack);

$('#shipping-cost').val(mship);
$('#packing-cost').val(mpack);
var ftotal = parseFloat($('#grandtotal').val()) + mship + mpack;
ftotal = parseFloat(ftotal);
      if(ftotal % 1 != 0)
      {
        ftotal = ftotal.toFixed(2);
      }
      if(pos == 0){
         $('#final-cost').html('$'+ftotal)
      }
      else{
         $('#final-cost').html(ftotal+'$')
      }

$('#grandtotal').val(ftotal);

$('#shipop').on('change',function(){

   var val = $(this).val();
   if(val == 'pickup'){
      $('#shipshow').removeClass('d-none');
      $("#ship-diff-address").parent().addClass('d-none');
        $('.ship-diff-addres-area').addClass('d-none');  
        $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);  
   }
   else{
      $('#shipshow').addClass('d-none');
      $("#ship-diff-address").parent().removeClass('d-none');
        $('.ship-diff-addres-area').removeClass('d-none');  
        $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true); 
   }

});


$(document).on('change','.shipping',function(){
   mship = $(this).val();
    mship = mship.split("___");
    mship_text = mship[0];
    mship = mship[1];
    $('#shipping-cost').val(mship);
    if($(".shipping-cost").length > 0){
        $(".shipping-cost").remove();
    }
    $(".woocommerce-checkout-review-order-table").find("tr:last").before(`<tr class="shipping-cost">
                                                                       <th>Shipping</th>
                                                                       <td>
                                                                          <span class="woocommerce-Price-amount amount">
                                                                          $${mship}
                                                                          </span>
                                                                       </td>
                                                                    </tr>`);
    
    var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
    ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }
      if(pos == 0){
         $('#final-cost').html('$'+ttotal);
      }
      else{
         $('#final-cost').html(ttotal+'$');
      }
   $("#total-cost").text("$"+ttotal);
    $('#grandtotal').val(ttotal);

})

$('.packing').on('click',function(){
   mpack = $(this).val();
$('#packing-cost').val(mpack);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }

      if(pos == 0){
         $('#final-cost').html('$'+ttotal);
      }
      else{
         $('#final-cost').html(ttotal+'$');
      }  


$('#grandtotal').val(ttotal);
      
})
// let mainurl = "http://127.0.0.1:8000/checkout";
    $("#check-coupon-form").on('submit', function () {
        var val = $("#code").val();
        var total = $("#grandtotal").val();
        var ship = 0;
            $.ajax({
                    type: "GET",
                    url:mainurl+"/carts/coupon/check",
                    data:{code:val, total:total, shipping_cost:ship},
                    success:function(data){
                        if(data == 0)
                        {
                           toastr.error(langg.no_coupon);
                            $("#code").val("");
                        }
                        else if(data == 2)
                        {
                           toastr.error(langg.already_coupon);
                            $("#code").val("");
                        }
                        else
                        {
                            $("#check-coupon-form").toggle();
                            $(".discount-bar").removeClass('d-none');

                     if(pos == 0){
                        $('#total-cost').html('$'+data[0]);
                        $('#discount').html('$'+data[2]);
                     }
                     else{
                        $('#total-cost').html(data[0]+'$');
                        $('#discount').html(data[2]+'$');
                     }
                        $('#grandtotal').val(data[0]);
                        $('#tgrandtotal').val(data[0]);
                        $('#coupon_code').val(data[1]);
                        $('#coupon_discount').val(data[2]);
                        if(data[4] != 0){
                        $('.dpercent').html('('+data[4]+')');
                        }
                        else{
                        $('.dpercent').html('');                           
                        }


var ttotal = parseFloat($('#grandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }

      if(pos == 0){
         $('#final-cost').html('$'+ttotal)
      }
      else{
         $('#final-cost').html(ttotal+'$')
      }  

                           toastr.success(langg.coupon_found);
                            $("#code").val("");
                        }
                      }
              }); 
              return false;
    });

// Password Checking

        $("#open-pass").on( "change", function() {
            if(this.checked){
             $('.set-account-pass').removeClass('d-none');  
             $('.set-account-pass input').prop('required',true); 
             $('#personal-email').prop('required',true);
             $('#personal-name').prop('required',true);
            }
            else{
             $('.set-account-pass').addClass('d-none');   
             $('.set-account-pass input').prop('required',false); 
             $('#personal-email').prop('required',false);
             $('#personal-name').prop('required',false);

            }
        });

// Password Checking Ends


// Shipping Address Checking

      $("#ship-diff-address").on( "change", function() {
            if(this.checked){
             $('.ship-diff-addres-area').removeClass('d-none');  
             $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true); 
            }
            else{
             $('.ship-diff-addres-area').addClass('d-none');  
             $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);  
            }
            
        });


// Shipping Address Checking Ends


</script>


<script type="text/javascript">

var ck = 0;

   $('.checkoutform').on('submit',function(e){
      // alert("Submit");
      if(ck == 0) {
         e.preventDefault();        
      $('#pills-step2-tab').removeClass('disabled');
      $('#pills-step2-tab').click();

   }else {
      $('#preloader').show();
   }
   $('#pills-step1-tab').addClass('active');
   });

   $('#step1-btn').on('click',function(){
      $('#pills-step1-tab').removeClass('active');
      $('#pills-step2-tab').removeClass('active');
      $('#pills-step3-tab').removeClass('active');
      $('#pills-step2-tab').addClass('disabled');
      $('#pills-step3-tab').addClass('disabled');

      $('#pills-step1-tab').click();

   });

// Step 2 btn DONE
// $('#final-btn').on('click', function(){
//    alert('PRes');
// })

   $('#allowGuest').on('click',function(){
      // $("#final-btn").prop("disabled", false);
      $('#loginFirstArea').hide();
      $('.to-disp').fadeIn();
   });

   $('#step2-btn').on('click',function(){
      $('#pills-step3-tab').removeClass('active');
      $('#pills-step1-tab').removeClass('active');
      $('#pills-step2-tab').removeClass('active');
      $('#pills-step3-tab').addClass('disabled');
      $('#pills-step2-tab').click();
      $('#pills-step1-tab').addClass('active');

   });

   $('#step3-btn').on('click',function(){
      if($('a.payment:first').data('val') == 'paystack'){
         $('.checkoutform').prop('id','step1-form');
      }
      else {
         $('.checkoutform').prop('id','');
      }
      $('#pills-step3-tab').removeClass('disabled');
      $('#pills-step3-tab').click();

      var shipping_user  = !$('input[name="shipping_name"]').val() ? $('input[name="name"]').val() : $('input[name="shipping_name"]').val();
      var shipping_location  = !$('input[name="shipping_address"]').val() ? $('input[name="address"]').val() : $('input[name="shipping_address"]').val();
      var shipping_phone = !$('input[name="shipping_phone"]').val() ? $('input[name="phone"]').val() : $('input[name="shipping_phone"]').val();
      var shipping_email= !$('input[name="shipping_email"]').val() ? $('input[name="email"]').val() : $('input[name="shipping_email"]').val();

      $('#shipping_user').html('<i class="fas fa-user"></i>'+shipping_user);
      $('#shipping_location').html('<i class="fas fas fa-map-marker-alt"></i>'+shipping_location);
      $('#shipping_phone').html('<i class="fas fa-phone"></i>'+shipping_phone);
      $('#shipping_email').html('<i class="fas fa-envelope"></i>'+shipping_email);

      $('#pills-step1-tab').addClass('active');
      $('#pills-step2-tab').addClass('active');
   });

   $(document).on('click','#final-btn',function(){
      // alert('ck');
      ck = 1;
   })


   $('.payment').on('click',function(){
       
      $('.submit-loader').show();
      if($(this).data('val') == 'paystack'){
         $('.checkoutform').prop('id','step1-form');
      }
      else {
         $('.checkoutform').prop('id','');
      }
      $('.checkoutform').prop('action',$(this).data('form'));
      $('.pay-area #v-pills-tabContent .tab-pane.fade').not($(this).attr('href')).html('');
      var show = $(this).data('show');
      if(show != 'no') {
         $('.pay-area').removeClass('d-none');
      }
      else {
         $('.pay-area').addClass('d-none');
      }
      $($(this).attr('href')).load($(this).data('href'), function() {
            $('.submit-loader').hide();
        });

        
   })


        $(document).on('submit','#step1-form',function(){
         $('#preloader').hide();
            var val = $('#sub').val();
            var total = $('#grandtotal').val();
         total = Math.round(total);
                if(val == 0)
                {
                var handler = PaystackPop.setup({
                  key: 'pk_test_162a56d42131cbb01932ed0d2c48f9cb99d8e8e2',
                  email: $('input[name=email]').val(),
                  amount: total * 100,
                  currency: "USD",
                  ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                  callback: function(response){
                    $('#ref_id').val(response.reference);
                    $('#sub').val('1');
                    $('#final-btn').click();
                  },
                  onClose: function(){
                     window.location.reload();
                     
                  }
                });
                handler.openIframe();
                    return false;                    
                }
                else {
                  $('#preloader').show();
                    return true;   
                }
        });
        
        function getStates(){
            var id = $('select[name="customer_country"]').find(":selected").data('id');
            var old_state = '{{ old('state') }}';
            $.ajax({
                type:'get',
                url:'{{ route('fetch.states') }}',
                data:{country_id:id},
                dataType:'json',
                success: function(resp){
                    $('select[name="state"]').empty().append('<option value="">Select State</option>');
                    $(resp.data).each(function(i,v){
                        if(v.code == old_state){
                            $('select[name="state"]').append('<option value="'+v.code+'" selected>'+v.name+'</option>');   
                        }else{
                             $('select[name="state"]').append('<option value="'+v.code+'">'+v.name+'</option>');
                        }
                    });
                },
                error: function(resp){
                    console.log(resp);
                }
            });
        }
        
        function getShippingStates(){
            var id = $('select[name="shipping_country"]').find(":selected").data('id'); 
            var old_state = '{{ old('shipping_state') }}';
            $.ajax({
                type:'get',
                url:'{{ route('fetch.states') }}',
                data:{country_id:id},
                dataType:'json',
                success: function(resp){
                    $('select[name="shipping_state"]').empty().append('<option value="">Select State</option>');
                    $(resp.data).each(function(i,v){
                        if(v.code == old_state){
                            $('select[name="shipping_state"]').append('<option value="'+v.code+'" selected>'+v.name+'</option>');
                        }else{
                            $('select[name="shipping_state"]').append('<option value="'+v.code+'">'+v.name+'</option>');
                        }
                    });
                },
                error: function(resp){
                    console.log(resp);
                }
            });
        }
        
        $(document).on('change','select[name="customer_country"]',function(e){
            getStates();
        });
        
        $(document).on('change','select[name="shipping_country"]',function(e){
            getShippingStates();
        });
        
        getStates();
        getShippingStates();
        $(document).on('keypress','input[name="month"]',function(event){
            $(this).attr('maxlength',2);
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        
        $(document).on('paste','input[name="month"]',function(event){
            $(this).attr('maxlength',2);
            if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
                event.preventDefault();
              }
        });
        
        $(document).on('keypress','input[name="year"]',function(event){
            $(this).attr('maxlength',4);
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        
        $(document).on('paste','input[name="year"]',function(event){
            $(this).attr('maxlength',4);
            if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
                event.preventDefault();
              }
        });
        
        $(document).ready(function(){
            $('input[name="month"]').removeAttr('placeholder').attr('placeholder','02');       
        });

</script>
@endsection