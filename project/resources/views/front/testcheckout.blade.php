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
        border: 2px solid #c12228;
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
        border: 2px solid #c12228;
        width: 100%;
        font-size: 1em;
        margin: 7px 0px;
    }
    .checkout .grid-container select{
        padding: 15px 6px;
        border-radius: 6px;
        border: 2px solid #c12228;
        width: 100%;
        font-size: 1em;
        margin: 7px 0px;
    }
    .checkout .grid-container h1, h2, h3, h4, h5, h6{
        cursor: default;
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
    .checkout .grid-container .contact_info .sub_contact_info .second_more_sub_contact_info .shipping_display .un_shippment{
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
    }
    .checkout .grid-container .contact_info .sub_contact_info .second_more_sub_contact_info .shipping_display .un_shippment .un_shippment_text label{
        display: flex;
        flex-direction: row;
    }
    .checkout .grid-container .contact_info .sub_contact_info .second_more_sub_contact_info .shipping_display .un_shippment .un_shippment_text span{
        font-weight: bold;
        margin: 0px 10px;
    }
    .checkout .grid-container .contact_info .sub_contact_info .second_more_sub_contact_info .shipping_display .un_shippment .un_shippment_price input{
        width: 15px;
        height: 15px;
        margin: 0 !important;
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
        margin-top: 4px;
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
        object-fit: contain;
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
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .checkout .order_info .sub_order_info .order_img_box span{
        display: flex;
        align-content: center;
        height: 100%;
        justify-content: end;
    }
    .checkout .order_info .sub_order_info .order_img_box .order_price_box{
        /* width: 100%;
        text-align: end */
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
        padding: 13px 0px;
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
    .checkout .order_info .inside_order_amount_box span input{
        border: none;
        background: transparent;
        width: 70px;
        height: 30px;
        padding: 0px 0px;
        text-align: end;
    }
</style>
<main class="checkout">
    <div class="container">
        <form class="form checkout-form checkoutform" action="" method="post" name="checkout">
            @csrf
            <div class="grid-container">
                <div class="box contact_info">
                    <h3>Contact Information</h3>
                    <div class="sub_contact_info">
                        <input class="name-email" type="email" id="check_name_email" name="email"
                        placeholder="{{ $langg->lang154 }}" required=""
                        value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->email : old('email') }}">
                        <hr>
                        <div class="more_sub_contact_info">
                            <h6>Shipping Details</h6>
                            <div>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" name="name"
                                        placeholder="{{ $langg->lang152 }}" required=""
                                        value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->name : old('name') }}" >
                                    </div>
                                    <div class="col-6">
                                        <input type="text" name="phone"
                                        placeholder="{{ $langg->lang153 }}" required=""
                                        onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                        value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->phone : old('phone') }}">
                                    </div>
                                    <div class="col-12">
                                        <input placeholder="Please Enter Your Complete Address" required type="text" name="address" spellcheck="true"  value="{{ old('address') }}">
                                    </div>
                                    <div class="col-6">
                                        <select class="select2 form-control form-control-md ship-field" name="state" required="" id="administrative_area_level_1">
                                            <option value="">Select Country First!</option>
                                         </select>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" placeholder="City" name="city" id="">
                                    </div>
                                    <div class="col-6">
                                        <select class="select2 form-control form-control-md ship-field" name="customer_country" required="" id="country">
                                            @foreach(\DB::table('countries')->whereIn('country_code',['US','CA','GB','DE','AN','NL','FR','IT','IE','DK','BE','SE','FI','LU'])->get() as $country)
                                            <option data-id="{{ $country->id }}" value="{{ $country->country_code }}" {{ $country->country_code == "US" ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                            @endforeach
                                         </select>
                                    </div>
                                    <div class="col-6">
                                        <input placeholder="{{ $langg->lang159 }}" type="text" required id="postal_code" name="zip" spellcheck="true" value="{{ old('zip') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="second_more_sub_contact_info">
                            <h6>Shipping Method</h6>
                            <div class="shipping_display">
                                <div id="shipments" class="mt-3">
                                    {{-- <div class="un_shippment" >
                                        <div class="un_shippment_text">
                                            <label for="free-shepping">
                                            <p>Ground</p>
                                            <span>+ $15.45</span>
                                            </label>
                                        </div>
                                        <div class="un_shippment_price">
                                            <input type="radio" name="" id="">
                                        </div>
                                    </div> --}}
                                    
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
                                            <input type="radio" required name="pay" class="payment" data-val="" data-show="yes" data-form="{{route('stripe.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'stripe','slug2' => 0]) }}" id="v-pills-tab2-tab" data-toggle="pill" href="#stripe_card" role="tab" aria-controls="stripe_card" aria-selected="false">
                                            {{-- <a style="display: none;" name="pay" class="payment" data-val="" data-show="yes" data-form="{{route('stripe.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'stripe','slug2' => 0]) }}" id="" data-toggle="pill" href="#stripe_card" role="tab" aria-controls="stripe_card" aria-selected="false">click</a> --}}
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stripe_bundle">
                                            <h4>Credit Card</h4>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <picture>
                                            <img width="40" height="10" src="{{asset('assets/images/checkout/visa.webp')}}" alt="Visa">
                                            <img width="40" height="10" src="{{asset('assets/images/checkout/mastercard.png')}}" alt="Mastercard">
                                            <img width="40" height="10" src="{{asset('assets/images/checkout/unionpay.png')}}" alt="Union Pay">
                                        </picture>
                                    </div>
                                </div>
                                <div id="stripe_card" class="stripe_card">
                                </div>
                                {{-- <div id="stripe_card" class="stripe_card">
                                    <input type="text" placeholder="Card Number" name="" id="">
                                    <input type="text" placeholder="Name On Card" name="" id="">
                                    <div class="flex_stripe_card">
                                        <input type="text" placeholder="Expiration Date" name="" id="">
                                        <input type="text" placeholder="Security Code" name="" id="">
                                    </div>
                                </div> --}}
                            </div>
                            <div class="paypal">
                            <div class="row">
                                <div class="col-1">
                                    <div class="paypal_bundle">
                                        <input  type="radio" required name="pay" class="payment" data-val="" data-show="no" data-form="{{route('paypal.submit')}}" data-href="{{ route('front.load.payment',['slug1' => 'paypal','slug2' => 0]) }}" id="paypal" data-toggle="pill" href="#v-pills-tab1" role="tab" aria-controls="v-pills-tab1" aria-selected="true">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="paypal_image">
                                        <img src="{{asset('assets/images/paypal.webp')}}" width="55" height="10" alt="Paypal">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <picture>
                                        <img width="40" height="10" src="{{asset('assets/images/checkout/visa.webp')}}" alt="Visa">
                                        <img width="40" height="10" src="{{asset('assets/images/checkout/mastercard.png')}}" alt="Mastercard">
                                        <img width="40" height="10" src="{{asset('assets/images/checkout/unionpay.png')}}" alt="Union Pay">
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
                                        <input type="radio" name="bill_address" required id="same_bill">
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
                                            <input type="radio" name="bill_address" required id="diff_bill">
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
                                                <input type="text" name="shipping_name"
                                                id="shippingFull_name" placeholder="{{ $langg->lang152 }}" value="{{ old('shipping_name') }}">
                                                <input type="hidden" name="shipping_email" value="">
                                            </div>
                                            <div class="col-6">
                                                <input type="number" name="shipping_phone"
                                                id="shipingPhone_number" placeholder="{{ $langg->lang153 }}" value="{{ old('shipping_phone') }}">
                                            </div>
                                            <div class="col-12">
                                                <input placeholder="Please Enter Your Complete Address" type="text" name="shipping_address" spellcheck="true" value="{{ old('shipping_address') }}">
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control" name="shipping_country" required="" id="country_2">
                                                    <option value="">Select Country</option>
                                                    @foreach(\DB::table('countries')->whereIn('country_code',['US','CA','GB','DE','AN','NL','FR','IT','IE','DK','BE','SE','FI','LU'])->get() as $country)
                                                    <option data-id="{{ $country->id }}" value="{{ $country->country_code }}" {{ $country->country_code == "US" ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                    @endforeach
                                                 </select>
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control" name="shipping_state" id="administrative_area_level_1_2">
                                                    <option value="">Select Country First!</option>
                                                 </select>
                                            </div>
                                            <div class="col-6">
                                                <input placeholder="{{ $langg->lang158 }}" placeholder="City" type="text" id="locality_2" name="shipping_city" spellcheck="true" value="{{ old('shipping_city') }}">
                                            </div>
                                            <div class="col-6">
                                                <input placeholder="{{ $langg->lang159 }}" type="text" id="postal_code_2" name="shipping_zip" spellcheck="true" value="{{ old('shipping_zip') }}">
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
                        @foreach($products as $product)
                        <div class="order_img_box">
                                <figure>
                                    <img src="{{ asset('assets/images/products/1672854016SsAK7iqH.png') }}" width="100" height="80" alt="Product Image">
                                </figure>
                                <div class="order_description_box">
                                    <p>
                                        {{ $product['qty'] }} X {{ $product['item']['name'] }} 
                                    </p>
                                </div>
                                <div class="order_price_box">
                                    <span>{{ App\Models\Product::convertPrice($product['price']) }}</span>
                                </div>
                        </div>
                        @endforeach
                        
                        <hr>
                        <div class="order_amount_box">
                            <div class="inside_order_amount_box">
                                <p>Subtotal</p>
                                <p>
                                    <span>    
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
                                       <input type="hidden" id="subTotalCustom" name="subtotal" value="{{ $subtotal }}"/>
                                    </span>
                                </p>
                            </div>
                            <div class="inside_order_amount_box">
                                <p>Shipping</p>
                                <p>
                                    <span id="shippment_price_display"> 
                                        -- 
                                    </span>
                                </p>
                            </div>
                            <div class="inside_order_amount_box">
                                <p>Tax</p>
                                <p>
                                    <span> 
                                        @if($gs->tax != 0)
                                            <input name="sub_tax" id="taxtCalculate" value="0" />
                                            {{-- {{$gs->tax}}%  --}}
                                            {{-- {{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00' }} --}}
                                            {{-- @php
                                                $tax = $gs->tax;
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
                                                    $dueTax = round($subtotal * ($tax / 100),2);
                                                    $finalTax = round($subtotal * (1 + ($tax / 100)),2);
                                                    // echo $subtotal . '<br />';
                                                    echo '$' . $dueTax . '<br />';
                                                    // echo  `<span id="finalTax_span">`.$finalTax.`</span>`;
                                                    // echo $finalTax . '<br />';
                                                }else{
                                                    $subtotal = 0.00;
                                                }
                                            @endphp --}}
                                        @else
                                        --
                                        <input type="hidden" name="sub_tax" value="" />
                                        @endif
                                    </span>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="order_total">
                            <p>Total</p>
                            <p>
                                <span>
                                           @if(Session::has('coupon_total'))
                                              @if($gs->currency_format == 0)
                                                 <span id="total-cost">{{ $curr->sign }}{{ $totalPrice }}</span>
                                              @else 
                                                 <span id="total-cost">{{ $totalPrice }}{{ $curr->sign }}</span>
                                              @endif
 
                                           @elseif(Session::has('coupon_total1'))
                                              <span id="total-cost"> {{ Session::get('coupon_total1') }}</span>
                                              @else
                                              <span id="total-cost">
                                                {{ App\Models\Product::convertPrice($totalPrice) }}
                                            </span>
                                           @endif
                                </span>
                            </p>
                        </div>
                    </div>
                    {{-- Hidden Inputs --}}
                                        <input placeholder="terms-field" type="hidden" value="1" name="terms-field"> 
                                 {{-- <input type="hidden" id="shipping-cost" name="shipping_cost" value="0"> --}}
                                 <input placeholder="shipping-cost" type="hidden" id="shipping-cost" name="shipping_cost" value="0">
                                        <input placeholder="packing-cost" type="hidden" id="packing-cost" name="packing_cost" value="0">
                                        <input placeholder="dp (Digital)" type="hidden" name="dp" value="{{$digital}}">
                                        <input placeholder="Tax" type="hidden" name="tax" value="{{$gs->tax}}">
                                        <input placeholder="totalQty" type="hidden" name="totalQty" value="{{$totalQty}}">
                                        <input placeholder="shipping" type="hidden" name="shipping" value="shipto">

                                        <input placeholder="vendor_shipping_id" type="hidden" name="vendor_shipping_id" value="{{ $vendor_shipping_id }}">
                                        <input placeholder="vendor_packing_id" type="hidden" name="vendor_packing_id" value="{{ $vendor_packing_id }}">
                                    @if(Session::has('coupon_total'))
                                        <input placeholder="grandtotal (coupon)" type="hidden" name="total" id="grandtotal" value="{{ $totalPrice }}">
                                        <input placeholder="tgrandtotal (coupon)" type="hidden" id="tgrandtotal" value="{{ $totalPrice }}">
                                 @elseif(Session::has('coupon_total1'))
                                    <input placeholder="grandtotal (coupon1)" type="hidden" name="total" id="grandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
                                    <input placeholder="tgrandtotal (coupon2)" type="hidden" id="tgrandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
                                 @else
                                        <input placeholder="grandtotal" type="hidden" name="total" id="grandtotal" value="{{round($totalPrice * $curr->value,2)}}">
                                        <input placeholder="tgrandtotal" type="hidden" id="tgrandtotal" value="{{round($totalPrice * $curr->value,2)}}">
                                 @endif


                                        <input placeholder="coupon_code" type="hidden" name="coupon_code" id="coupon_code" value="{{ Session::has('coupon_code') ? Session::get('coupon_code') : '' }}">
                                        <input placeholder="coupon_discount" type="hidden" name="coupon_discount" id="coupon_discount" value="{{ Session::has('coupon') ? Session::get('coupon') : '' }}">
                                        <input placeholder="coupon_id" type="hidden" name="coupon_id" id="coupon_id" value="{{ Session::has('coupon') ? Session::get('coupon_id') : '' }}">
                                        <input placeholder="user_id" type="hidden" name="user_id" id="user_id" value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->id : '' }}">
                    {{-- Finish Hidden Inputs --}}
                    <div class="checkout_order">
                        <button type="submit" id="final-btn">Complete Purchase</button>
                    </div>
                    {{-- <hr> --}}
                </div>
            </div>
        </form>
    </div>
</main>
<div id="preloader">
    <img src="{{asset('assets/images/1560575570spinner.gif')}}" alt="Loader">
</div>
@endsection
@section('styles')
<style type="text/css">
	#preloader{
        display: none;
		position: fixed;
	    top: 40%;
        left: 40%;
	    /* width: 100%;
	    height: 100%; */
	    z-index: 99999;
	    background-color: transparent !important;
	}
    #preloader img{
        /* width: 10%;
        height: 10%; */
    }
</style>
@endsection

@section('scripts')

    <script>

        $('#stripe').click(function() {
            // alert("Clickll");
            $('#stripe_card').addClass('stripe_card_show');
            $('#stripe_month').prop('required', 'required');
            $('#stripe_cardcvc').prop('required', 'required');
            $('#stripe_cardnumber').prop('required', 'required');

            // setRequired(true);
            $('#v-pills-tab2-tab').prop("checked", true);
        });

        $('#inner_different_billing').click(function() {
            $('#extended_billing_address').addClass('extended_billing_address_show');
        });

        $('.paypal').click(function(){
            $('#paypal').prop("checked", true);
            $('#stripe_card').removeClass('stripe_card_show');
        });

        $('#same_billing').click(function(){
            $('#same_bill').prop("checked", true);
            $('#extended_billing_address').removeClass('extended_billing_address_show');
        });

        $('#different_billing').click(function(){
            $('#diff_bill').prop("checked", true);
        });

        $('#same_bill').click(function(){
            if($('#same_bill').is(':checked')){
                // alert("Same Bill");
                $('select[name="shipping_state"] option').prop("selected", false);
            }
        });

        let taxJS = 6;
        let subTotalCustom = $('#subTotalCustom').val();
        let dueTaxJS = parseFloat(subTotalCustom * (taxJS / 100)).toFixed(2);

        $('#check_name_email').keyup(function(){
            let getEmailValue = $('#check_name_email').val();
            let afterAt = getEmailValue.split('@').pop();

            applyTax($(this));
        });
        
    </script>
    {{-- @endsection

    @section('scripts') --}}

    @php
    $coupon = Session::has('coupon') ? Session::get('coupon') : '0.00';   
    @endphp

    <script>
    //    let productArr = <?php echo json_encode($products); ?>;
    //  //  console.log(productArr);
    
        // for(const key in productArr){
        //     const element = productArr[key];
        //     gtag("event", "begin_checkout", {
        //         transaction_id: "T_12345_1",
        //         value: 25.42,
        //         tax: {!!$gs->tax!!},
        //         currency: "USD",
        //         coupon: {!!$coupon!!},
        //         items: [
        //             {
        //             id: element.item.id,
        //             name: element.item.name,
        //             slug: element.item.slug,
        //             price: element.item.price,
        //             quantity: element.item.qty
        //         }]
        //     });
        // }

        // console.log(items);
    </script>




    <script type="text/javascript">

        var mainurl = "{{url('/')}}";
        var gs      = {!! json_encode($gs) !!};
        var langg    = {!! json_encode($langg) !!};

    </script>

    {{-- Shipping and Tax Script --}}

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
            // alert("D");
            $("#final-btn").prop("disabled", true);
            let street = country = state = city = zip = "";
            var shipping_service = '{{ old('shipping_service') }}';

            if($("#extended_billing_address").is(":checked")){
                street = $("input[name='shipping_address']").val();
                country = $("select[name='shipping_country'] option:selected").val();
                state = $("select[name='shipping_state'] option:selected").val();
                city = $("input[name='shipping_city']").val();
                zip = $("input[name='shipping_zip']").val();
            }
            else{
                street = $("input[name='address']").val();
                country = $("select[name='customer_country'] option:selected").val();
                city = $("input[name='city']").val();
                state = $("select[name='state'] option:selected").val();
                zip = $("input[name='zip']").val();
            }

            //   alert(street)
            //   alert(country)
            //   alert(state)
            //   alert(city)
            //   alert(zip)

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
                                    var opts = ``;
                                    $("#shipments").empty();
                                    $.each(data.rates, function (i, rate) {
                                        if(rate.name == "FedEx Ground"){
                                            rate.name = "Ground";
                                        }
                                        if(shipping_service == rate.name+"___"+rate.amount){
                                            opts += `
                                            <div class="un_shippment" >
                                                    <div class="un_shippment_text">
                                                        <label for="free-shepping${i}">
                                                        <p>${rate.name}
                                                + </p>
                                                        <span>+ {{ $curr->sign }}${rate.amount}</span>
                                                        </label>
                                                    </div>
                                                    <div class="un_shippment_price">
                                                        <input type="radio" required class="shipping" id="free-shepping${i}" checked name="shipping_service" value="${rate.name+"___"+rate.amount}">
                                                    </div>
                                                </div>`;   
                                        }else{
                                            opts += `
                                            <div class="un_shippment" >
                                                    <div class="un_shippment_text">
                                                        <label for="free-shepping${i}">
                                                        <p>${rate.name}
                                                + </p>
                                                        <span>+ {{ $curr->sign }}${rate.amount}</span>
                                                        </label>
                                                    </div>
                                                    <div class="un_shippment_price">
                                                        <input type="radio" required class="shipping" id="free-shepping${i}" name="shipping_service" value="${rate.name+"___"+rate.amount}">
                                                    </div>
                                                </div>`;
                                        }
                                        $("#shipments").html(opts);
                                    });
                                    $('.shipping:checked').change();
                                    $("#final-btn").prop("disabled", false);
                                }
                                else{
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
            var getEmailValue = $('#check_name_email').val().split('@').pop();
            // var afterAt = getEmailValue.split('@').pop();
            // $('#check_name_email').val().split('@').pop();
            // console.log($('#check_name_email').val().split('@').pop());
            // let mailCheck = 'zoho.com' || 'gmail.com' || 'zoho.com' || 'aol.com' || 'yahoo.com';
            var subtotal = parseFloat($('input[name="subtotal"]').val());
            if((getEmailValue == 'gmail.com') || (getEmailValue == 'zoho.com') || (getEmailValue == 'yahoo.com') || (getEmailValue == 'aol.com') || (getEmailValue == 'outlook.com') || (getEmailValue == 'protonmail.com') || (getEmailValue == 'icloud.com') || (getEmailValue == 'gmx.com') || (getEmailValue == 'mail.com')){
                // alert($('#check_name_email').val().split('@').pop());
                if(_this.val() == "TX"){
                    // alert("Tx");
                    var tax = parseFloat(( 8.25 / 100 ) * subtotal).toFixed(2);
                    subtotal = parseFloat(subtotal) + parseFloat(tax);

                    $('input[name="sub_tax"]').val(tax);
                    $('#taxtCalculate').val('$'+tax);
                    $('#total-cost').text('$'+parseFloat(subtotal).toFixed(2));
                    $('#grandtotal').val(subtotal);
                    $('#tgrandtotal').val(subtotal);
                    $('input[name="tax"]').val(6.25);
                }
                else if(_this.val() == "CA"){
                    // alert("CA");
                    var tax = parseFloat(( 10.25 / 100 ) * subtotal).toFixed(2);
                    subtotal = parseFloat(subtotal) + parseFloat(tax);
                    
                    $('input[name="sub_tax"]').val(tax);
                    $('.cart-tax').remove();

                    $('#taxtCalculate').val('$'+tax);
                    
                    $('#total-cost').text('$'+parseFloat(subtotal).toFixed(2));
                    $('#grandtotal').val(subtotal);
                    $('#tgrandtotal').val(subtotal);
                    $('input[name="tax"]').val(7.25);
                }
                else{
                    // alert("Diff state");
                    var tax = parseFloat(( 6 / 100 ) * subtotal).toFixed(2);
                    subtotal = parseFloat(subtotal) + parseFloat(tax);

                    $('input[name="sub_tax"]').val(tax);
                    $('#taxtCalculate').val('$'+tax);
                    $('#total-cost').text('$'+parseFloat(subtotal).toFixed(2));
                    $('#grandtotal').val(subtotal);
                    $('#tgrandtotal').val(subtotal);
                    $('input[name="tax"]').val(6);
                }
            }
            else{
                    var tax = 0;
                    // subtotal = parseFloat(subtotal).toFixed(2);
                    // alert(subtotal);
                    $('input[name="sub_tax"]').val(tax);
                    $('#taxtCalculate').val('$'+tax);
                    $('#total-cost').text('$'+subtotal);
                    // $('#total-cost').text('$'+parseFloat(subtotal).toFixed(2));
                    $('#grandtotal').val(subtotal);
                    $('#tgrandtotal').val(subtotal);
                    $('input[name="tax"]').val(0);
            }
        }
    
        $(document).on('change','input[name="email"]',function(e){
            // alert("D");
            applyTax($(this));
        });

        $(document).on('change','select[name="state"]',function(e){
            let ShippingStateTax = $("select[name='shipping_state'] option:selected").val();
            if(ShippingStateTax == ''){
                // alert(ShippingStateTax);
                applyTax($(this));
            }
        });

        $(document).on('change','select[name="shipping_state"]',function(e){
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

            if(ftotal % 1 != 0){
                ftotal = ftotal.toFixed(2);
            }

            $('#grandtotal').val(ftotal);

            $(document).on('change','.shipping',function(){
                mship = $(this).val();
                mship = mship.split("___");
                mship_text = mship[0];
                mship = mship[1];
                $('#shipping-cost').val(mship);
                if($(".shipping-cost").length > 0){
                    $(".shipping-cost").remove();
                }
                $(".woocommerce-checkout-review-order-table").find("tr:last").before(`  <tr class="shipping-cost">
                                                                                            <th>Shipping</th>
                                                                                            <td>
                                                                                                <span class="woocommerce-Price-amount amount">
                                                                                                $${mship}
                                                                                                </span>
                                                                                            </td>
                                                                                        </tr>`
                );
                
                var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
                ttotal = parseFloat(ttotal);
                if(ttotal % 1 != 0){
                    ttotal = ttotal.toFixed(2);
                }
                if(pos == 0){
                    $('#final-cost').html('$'+ttotal);
                }
                else{
                    $('#final-cost').html(ttotal+'$');
                }
                // alert(ttotal);
                $("#total-cost").text("$"+ttotal);
                $("#shippment_price_display").text("$"+parseFloat(mship));
                $('#grandtotal').val(ttotal);

            });

    </script>


    <script type="text/javascript">
            var ck = 0;

            $('.checkoutform').on('submit',function(e){
                // alert("Submit");
                    if(ck == 0) {
                    }else {
                    $('#preloader').show();
                    }
            });

            // Step 2 btn DONE

            $(document).on('click','#final-btn',function(){
                // alert('ck');
                ck = 1;
            });

            $('.payment').on('click',function(){
                    // alert("Payment Click");
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

                    
            });

            $(document).on('submit','#step1-form',function(){
                // alert('#step1-form');
                $('#preloader').hide();
                var val = $('#sub').val();
                var total = $('#grandtotal').val();
                total = Math.round(total);
                    if(val == 0){
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