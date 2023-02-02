@extends('layouts.jbs')
@section('body-class')
@section('content')
<style>
    /* Global  */
    .checkout{
        min-height: 100vh;
        padding: 20px 0px
    }
    .checkout .container{
        width: 95%;
        margin: auto;
        border: 1px solid #ccc;
        padding: 10px 20px;
        border-radius: 9px;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }
    .checkout .grid-container{
        display: grid;
        /* gap: 5px; */
        grid-template-columns: 33.33% 33.33% 33.33%;
    }
    /* @media screen and (max-width: 1000px)
    {
        .checkout .grid-container{
            grid-template-columns: auto auto auto;
        }
    } */
    @media screen and (max-width: 1000px)
    {
        .checkout .grid-container{
            grid-template-columns: auto auto;
            grid-row-gap: 20px;
        }
    }
    @media screen and (max-width: 700px)
    {
        .checkout .grid-container{
            grid-template-columns: auto;
            grid-row-gap: 50px;
        }
    }
    .checkout .grid-container .box{
        /* text-align: center;         */
    }
    .checkout .grid-container input{
        padding: 15px 6px;
        border-radius: 6px;
        border: 1px solid #ccc;
        width: 100%;
        font-size: 1em;
        margin: 7px 0px;
    }
    .checkout .grid-container h3{
        font-weight: 500 !important;
        font-size: 1.5em;
        padding-top: 8px;
        font-family: ui-monospace;
    }
    /* Global End  */
    /* Contact Info  */
    .checkout .grid-container .contact_info{
        background-color: #fff;
        padding: 0px  10px;
    }
    .checkout .grid-container .contact_info .sub_contact_info{
        /* padding: 5px 2px; */
        /* background-color: rgb(203, 202, 202); */
    }
    .checkout .grid-container .contact_info .sub_contact_info .more_sub_contact_info{
        padding: 5px 0px;
    }
    .checkout .grid-container .contact_info .sub_contact_info h6{
        font-weight: 500;
        font-size: 1.2em;
    }
    .checkout .grid-container .contact_info hr{
        background-color: #ccc;
        height: 2px; 
    }
    .checkout .grid-container .contact_info .under_email{
        display: flex;
    }
    .checkout .grid-container .contact_info .under_email input{
        padding: 0px 0px !important;
        width: max-content;
        margin-right: 4px;
    }
    .checkout .grid-container .contact_info .second_more_sub_contact_info h5{
        font-weight: 500;
        font-size: 1.4em;
    }
    /* End Contact info  */
    /* Payment Info */
    .checkout .grid-container .payment_info{
        width: 90%;
        margin: auto;
        height: 100%;
        cursor: default;
    }
    .checkout .grid-container .payment_info .sub_payment_box{
        /* padding: 10px 7px; */
        border: 2px solid #f1efef;
        border-radius: 6px;
        overflow: hidden;
        width: 100%;
        background-color: #f8f8f8;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }
    .checkout .grid-container .payment_info .sub_payment_box .stripe{
        /* padding: 5px 0px; */
        background-color: #fff;
        border-bottom: 1px solid #f8f8f8;
        padding-top: 19px;
    }
    .checkout .grid-container .payment_info .sub_payment_box .stripe .row{
        border-bottom: 1px solid #f8f8f8;
        padding: 0px 20px;
    }
    .checkout .grid-container .payment_info .sub_payment_box .paypal .row{
        border-bottom: 1px solid #f8f8f8;
        padding: 0px 20px;
    }
    .checkout .grid-container .payment_info .sub_payment_box .stripe .row .stripe_bundle{
        display: flex;
        flex-direction: row;
    }
    .checkout .grid-container .payment_info .sub_payment_box .paypal .row .paypal_bundle{
        display: flex;
        flex-direction: row;
    }
    .checkout .grid-container .payment_info .sub_payment_box .stripe .row .stripe_bundle h4{
        font-size: 1.1em;
    }
    .checkout .grid-container .payment_info .sub_payment_box .stripe .row .stripe_bundle input{
        height: 15px;
        width: 15px;
        margin: 0;
    }
    .checkout .grid-container .payment_info .sub_payment_box .paypal .row input{
        height: 15px;
        width: 15px;
        margin: 0;
    }
    .checkout .grid-container .payment_info .sub_payment_box .stripe .row picture{
        width: 100%;
        display: flex;
        justify-content: end;
    }
    .checkout .grid-container .payment_info .sub_payment_box .stripe .row picture img{
        aspect-ratio: 2/1;
        object-fit: fill;
        margin: 0px 6px;

    }
    .checkout .grid-container .payment_info .sub_payment_box .paypal .row .paypal_image img{
        aspect-ratio: 2/1;
        object-fit: fill;
    }
    .checkout .grid-container .payment_info .sub_payment_box .paypal .row picture{
        width: 100%;
        display: flex;
        justify-content: end;
    }
    .checkout .grid-container .payment_info .sub_payment_box .paypal .row picture img{
        aspect-ratio: 2/1;
        object-fit: fill;
        margin: 0px 6px;

    }
    .checkout .grid-container .payment_info .sub_payment_box .stripe_card{
        background-color:#f8f8f8;
        /* display: none; */
        padding: 18px 9px;
        border-top: 1px solid #d5d2d2;
        border-bottom: 1px solid #d5d2d2;

    }
    #stripe_card{
        display: none;
    }
    .stripe_card_show{
        display: block !important;
    }
    .checkout .grid-container .payment_info .sub_payment_box .stripe_card .flex_stripe_card{
        display: flex;
        flex-direction: row;
        gap: 5px;
    }
    .checkout .grid-container .payment_info .sub_payment_box .paypal{
        width: 100%;
        height: 100%;
        position: relative;
        padding: 13px 0px;
    }
    .checkout .grid-container .payment_info .billing_address{
        padding: 10px 0px;
    }
    .checkout .grid-container .payment_info .billing_address h5{
        font-weight: 500;
        font-size: 1.2em;
    }
    .checkout .grid-container .payment_info .billing_address .sub_billing_address{
        border: 2px solid #f1efef;
        border-radius: 6px;
        overflow: hidden;
        width: 100%;
        background-color: #f8f8f8;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }
    .checkout .grid-container .payment_info .billing_address .sub_billing_address .same_billing{
        background-color: #f8f8f8;
        border-bottom: 1px solid #f8f8f8;
        padding-top: 19px;
        padding-left: 13px;
    }
    .checkout .grid-container .payment_info .billing_address .sub_billing_address .different_billing{
        background-color: #fff;
        border-bottom: 1px solid #f8f8f8;
        padding-top: 19px;
        /* padding-left: 13px; */
    }
    .checkout .grid-container .payment_info .billing_address .sub_billing_address .different_billing .inner_different_billing{
        padding: 0px 13px;
    }
    .checkout .grid-container .payment_info .billing_address .sub_billing_address .different_billing .extended_billing_address{
        border-top: 1px solid #f8f8f8;
        padding: 10px 10px;
        background-color: #f8f8f8;
    }
    #extended_billing_address{
        display: none;
    }
    .extended_billing_address_show{
        display: block !important;
    }
    /* End Payment Info  */
    /* Order_Info  */
    .checkout .order_info{

    }
    .checkout .order_info hr{
        background-color: #ccc;
        height: 2px; 
    }
    .checkout .order_info .sub_order_info{
        background-color: #f8f8f8;
        padding: 8px 2em;
        border-radius: 6px;
        cursor: default;
    }
    .checkout .order_info .checkout_order{
        background-color: #fff;
        padding: 8px 0px;
        margin-top: 10px;
    }
    .checkout .order_info .sub_order_info .order_img_box{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin: 10px 0px;
    }
    .checkout .order_info .sub_order_info .order_img_box figure{
        width: 100%;
    }
    .checkout .order_info .sub_order_info .order_img_box .order_description_box{
        width: 98%;
        margin: 0 2%;
    }
    .checkout .order_info .sub_order_info .order_img_box .order_description_box p{
        display: flex;
        align-content: center;
        height: 100%;
    }
    .checkout .order_info .sub_order_info .order_img_box .order_price_box{
        width: 100%;
        text-align: end
    }
    .checkout .order_info .sub_order_info .order_img_box img{
        aspect-ratio: 2/1;
        object-fit: fill;
        width: 100%;
    }
    .checkout .order_info .sub_order_info .order_amount_box{
        width: 100%;
        margin: 10px 0px;
        padding-top: 10px;
    }
    .checkout .order_info .sub_order_info .order_amount_box .inside_order_amount_box{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .checkout .order_info .sub_order_info .order_amount_box .inside_order_amount_box p span{
        font-weight: bold;
    }
    .checkout .order_info .sub_order_info .order_total{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .checkout .order_info .sub_order_info .order_total p{
        font-size: 1.4em;
    }
    .checkout .order_info .sub_order_info .order_total p span{
        font-weight: bolder;
        /* font-size: 1.3em; */
    }
    .checkout .order_info .checkout_order button{
        background-color: #c51b23;
        padding: 10px 0px;
        width: 100%;
        text-align: center;
        font-size: 1.8rem;
        font-weight: bold;
        border: 1px solid #c51b23;
        color: #fff;
        border-radius: 6px;
        transition: 0.3s;
    }
    .checkout .order_info .checkout_order button:hover{
        background-color: #cf1e27;
    }
</style>
<main class="checkout">
    <div class="container">
        <form >
            <div class="grid-container">
                <div class="box contact_info">
                    <h3>Contact Information</h3>
                    <div class="sub_contact_info">
                        <input class="name-email" type="text" placeholder="Email" name="" id="">
                        <hr>
                        <div class="more_sub_contact_info">
                            <h6>Shipping Details</h6>
                            <div>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" placeholder="First name" name="fname" id="">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" placeholder="Last name" name="lname" id="">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" placeholder="Address" name="address" id="">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" placeholder="City" name="city" id="">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" placeholder="Country" name="country" id="">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" placeholder="Zipcode" name="zipcode" id="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="second_more_sub_contact_info">
                            <h6>Shipping Method</h6>
                            <div class="shipping_display">
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
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="box payment_info">
                    <h3>
                        Payment Method
                    </h3>
                    <div class="sub_payment_box">
                        <div class="stripe">
                            <div id="stripe" class="row">
                                    <div class="col-1">
                                        <div class="stripe_bundle">
                                            <input type="radio" name="payment" id="stripe_radio">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stripe_bundle">
                                            <h4>Credit Card</h4>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <picture>
                                            <img width="40" height="10" src="{{asset('assets/images/checkout/visa.webp')}}" alt="">
                                            <img width="40" height="10" src="{{asset('assets/images/checkout/mastercard.png')}}" alt="">
                                            <img width="40" height="10" src="{{asset('assets/images/checkout/unionpay.png')}}" alt="">
                                        </picture>
                                    </div>
                                </div>
                                <div id="stripe_card" class="stripe_card">
                                    <input type="text" placeholder="Card Number" name="" id="">
                                    <input type="text" placeholder="Name On Card" name="" id="">
                                    <div class="flex_stripe_card">
                                        <input type="text" placeholder="Expiration Date" name="" id="">
                                        <input type="text" placeholder="Security Code" name="" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="paypal">
                            <div class="row">
                                <div class="col-1">
                                    <div class="paypal_bundle">
                                        <input type="radio" name="payment" id="paypal">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="paypal_image">
                                        <img src="{{asset('assets/images/checkout/paypal.png')}}" width="40" height="10" alt="">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <picture>
                                        <img width="40" height="10" src="{{asset('assets/images/checkout/visa.webp')}}" alt="">
                                        <img width="40" height="10" src="{{asset('assets/images/checkout/mastercard.png')}}" alt="">
                                        <img width="40" height="10" src="{{asset('assets/images/checkout/unionpay.png')}}" alt="">
                                    </picture>
                                </div>                 
                                {{-- <input type="radio" name="" id=""> --}}
                            </div>
                            </div>
                    </div>
                    <div class="billing_address">
                        <h5>Billing Address</h5>
                        <div class="sub_billing_address">
                            <div id="same_billing" class="same_billing">
                                <div class="row">
                                    <div class="col-2">
                                        <input type="radio" name="bill_address" id="same_bill">
                                    </div>
                                    <div class="col-10">
                                        <p>
                                            Same As Shipping Address
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div id="different_billing" class="different_billing">
                                <div id="inner_different_billing" class="inner_different_billing">
                                    <div class="row">
                                        <div class="col-2">
                                            <input type="radio" name="bill_address" id="diff_bill">
                                        </div>
                                        <div class="col-10">
                                           <p>    
                                                Use A Different Billing Address
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="extended_billing_address" class="extended_billing_address">
                                    <div>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" placeholder="First name" name="fname" id="">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" placeholder="Last name" name="lname" id="">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" placeholder="Address" name="address" id="">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" placeholder="City" name="city" id="">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" placeholder="Country" name="country" id="">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" placeholder="Zipcode" name="zipcode" id="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box order_info">
                    <div class="sub_order_info">
                        <h3>
                            Order Summary
                        </h3>
                        <div class="order_img_box">
                            <figure>
                                <img src="{{ asset('assets/images/products/1672854016SsAK7iqH.png') }}" width="100" height="80" alt="Product Image">
                            </figure>
                            <div class="order_description_box">
                                <p>Description</p>
                            </div>
                            <div class="order_price_box">
                                <span>$59.68</span>
                            </div>
                        </div>
                        <hr>
                        <div class="order_amount_box">
                            <div class="inside_order_amount_box">
                                <p>Subtotal</p>
                                <p>
                                    <span>    
                                        $70.43
                                    </span>
                                </p>
                            </div>
                            <div class="inside_order_amount_box">
                                <p>Shipping</p>
                                <p>
                                    <span> 
                                        -- 
                                    </span>
                                </p>
                            </div>
                            <div class="inside_order_amount_box">
                                <p>Tax</p>
                                <p>
                                    <span> 
                                        -- 
                                    </span>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="order_total">
                            <p>Total</p>
                            <p>
                                <span>
                                    $98.69
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="checkout_order">
                        <button type="submit">Complete Purchase</button>
                    </div>
                    {{-- <hr> --}}
                </div>
            </div>
        </form>
    </div>
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
<script>
    $('#stripe').click(function() {
        $('#stripe_card').addClass('stripe_card_show');
    });
    $('#inner_different_billing').click(function() {
        $('#extended_billing_address').addClass('extended_billing_address_show');
    });

    $('.paypal').click(function(){
        $('#paypal').prop("checked", true);
        $('#stripe_card').removeClass('stripe_card_show');
    });
    $('#stripe').click(function(){
        $('#stripe_radio').prop("checked", true);
    });

    $('#same_billing').click(function(){
        $('#same_bill').prop("checked", true);
        $('#extended_billing_address').removeClass('extended_billing_address_show');
    });
    $('#different_billing').click(function(){
        $('#diff_bill').prop("checked", true);
    });
</script>
@endsection

@section('scripts')
@php
 $coupon = Session::has('coupon') ? Session::get('coupon') : '0.00';   
@endphp
<script>
   let productArr = <?php echo json_encode($products); ?>;
   // console.log(productArr);
   
   for(const key in productArr){
      const element = productArr[key];
   gtag("event", "begin_checkout", {
       transaction_id: "T_12345_1",
       value: 25.42,
       tax: {!!$gs->tax!!},
       currency: "USD",
       coupon: {!!$coupon!!},
       items: [
        {
         id: element.item.id,
         name: element.item.name,
         slug: element.item.slug,
         price: element.item.price,
         quantity: element.item.qty
      }]
   });
}
// console.log(items);
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