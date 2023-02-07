@extends('layouts.jbs')
@section('meta_tags')
<link rel="canonical" href="{{ url()->current() }}" />
@endsection
@section('content')

 <!-- Start of Breadcrumb -->
<nav class="breadcrumb-nav container">
    <ul class="breadcrumb bb-no">
        <li><a href="{{ url('') }}">Home</a></li>
        <li><a href="{{ route('front.category',['category' => $productt->category->slug]) }}">{{$productt->category->name}}</a></li>
        @if($productt->subcategory_id != null)
        <li><a href="{{ route('front.subcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug]) }}">{{$productt->subcategory->name}}</a></li>
        @endif
         @if($productt->childcategory_id != null)
         <li><a href="{{ route('front.childcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug, 'slug3' => $productt->childcategory->slug]) }}">{{$productt->childcategory->name}}</a></li>
        @endif
         <li>{{ $productt->name }}</a></li>
    </ul>
</nav>
<!-- End of Breadcrumb -->

<!-- Start of Page Content -->
<div class="page-content">
    <div class="container">
        <div class="row gutter-lg">
            <div class="main-content">
                <div class="product product-single row">
                    <div class="col-md-4 mb-6">
                        <div class="product-gallery product-gallery-sticky">
                            <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no">
                               <figure class="product-image">
                                  <img style="display: none;"  src="" data-load="{{$productt->photo}}"
                                        data-zoom-image="{{$productt->photo}}"
                                        alt="{{ $productt->name }}" width="800" height="900">
                               </figure>
                            </div>
                            <div class="product-thumbs-wrap">
                               <div class="product-thumbs row cols-4 gutter-sm">
                                @foreach($productt->galleries as $gal)
                                  <div class="product-thumb active">
                                     <img src="{{asset('assets/images/galleries/'.$gal->photo)}}"
                                        alt="{{ $productt->name }}" width="800" height="900">
                                  </div>
                                @endforeach
                               </div>
                               <button aria-label="Disable btn" class="thumb-up disabled"><i class="w-icon-angle-left"></i></button>
                               <button aria-label="Disable button" class="thumb-down disabled"><i
                                  class="w-icon-angle-right"></i></button>
                            </div>
                            <p class="text-center small text-muted">** The image may not match the actual product. Look for part number to identify the right product. **</p>
                        </div>
                    </div>
                    <div class="col-md-8 mb-4 mb-md-6">
                        <div class="product-details" data-sticky-options="{'minWidth': 767}">
                            <h2 class="product-title">{{ $productt->name }}</h2>
                            <div class="product-bm-wrapper">
                               
                                <div class="product-meta">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>Availability</td>
                                                <td>{{ $gs->show_stock == 0 ? '' : $productt->stock }} {{ $langg->lang79 }}</td>
                                            </tr>
                                            <tr>
                                                <td>SKU</td>
                                                <td>{{ $productt->sku }}</td>
                                            </tr>
                                            @if(!empty($productt->brand->link))
                                            <tr>
                                                <td>Manufacturer</td>
                                                <td><a href="{{ route('front.brand',\Str::slug($productt->brand->link)) }}" target="_blank">{{ $productt->brand->link }}</a></td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td>Manufacturer</td>
                                                <td><a href="javascript:;">Unspecified</a></td>
                                            </tr>
                                            @endif
                                            @if($productt->ship != null)
                                            <tr>
                                                <td>Est. Shipment time</td>
                                                <td>{{ $productt->ship }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td>Payment</td>
                                                <td><img style="display: none;" src="" data-load="{{ asset('assets/images/stripe.jpeg') }}" alt="Payment Methods" class="hover-img" width="180" height="28"></td>
                                            </tr>
                                            <tr>
                                                <td>Express Shipping to</td>
                                                <td><img style="display: none;" src="" data-load="{{ asset('assets/images/united-states.png') }}" style="display:inline-block" width="25" alt="Shipping"/><a href="javascript:;" class="express-ship"> United States</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <hr class="product-divider">
                      
                            <div class="product-price">
                            	<del>
	                                <span class="woocommerce-Price-amount amount">
	                                 {{ $productt->showPreviousPrice() }}
	                                </span>
	                            </del>
                            	 @if($productt->price != 0.00)
                                 <ins class="new-price" id="sizeprice">
                                 {{ $productt->showPrice() }}
                                 </ins>
                                 @endif
                            </div>
                            <hr class="product-divider">
                            <form id="cat-prods-form" enctype="multipart/form-data" method="post" class="cart ext-cart-frm d-block">
                                 @if(!empty($productt->color))
                                <div class="product-form product-variation-form product-color-swatch">
                                    <label>{{ $langg->lang89 }} :</label>
                                    <div class="d-flex align-items-center product-variations">
                                        @php
                                     $is_first = true;
                                     @endphp
                                     @foreach($productt->color as $key => $data1)
                                        <a href="#" class="color {{ $is_first ? 'active' : '' }}" data-color="{{ $productt->color[$key] }}" style="background-color: {{ $productt->color[$key] }}"></a>
                                         @php
                                     $is_first = false;
                                     @endphp
                                     @endforeach   
                                    </div>
                                </div>
                                @endif
                                 @if(!empty($productt->size))
                                 <input type="hidden" id="stock" value="{{ $productt->size_qty[0] }}">
                                @else
                               @php
                                 $stck = (string)$productt->stock;
                               @endphp
                               @if($stck != null)
                               <input type="hidden" id="stock" value="{{ $stck }}">
                               @elseif($productt->type != 'Physical')
                               <input type="hidden" id="stock" value="0">
                               @else
                               <input type="hidden" id="stock" value="">
                               @endif
                               @endif
                               <input type="hidden" id="product_price" value="{{ round($productt->vendorPrice() * $curr->value,2) }}">
                               <input type="hidden" id="product_id" value="{{ $productt->id }}">
                               <input type="hidden" id="curr_pos" value="{{ $gs->currency_format }}">
                               <input type="hidden" id="curr_sign" value="{{ $curr->sign }}">
                               <div class="row">
                                    <div class="col-lg-12">
                                       @if (!empty($productt->attributes))
                                       @php
                                       $attrArr = json_decode($productt->attributes, true);
                                       @endphp
                                       @endif
                                       @if (!empty($attrArr))
                                       <div class="product-attributes mb-3">
                                          <div class="row">
                                             @foreach ($attrArr as $attrKey => $attrVal)
                                             @if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)
                                             <div class="col-lg-6">
                                                <div class="form-group mb-2">
                                                   <strong for="" class="text-capitalize">{{ str_replace("_", " ", $attrKey) }} :</strong>
                                                   <div class="">
                                                      @foreach ($attrVal['values'] as $optionKey => $optionVal)
                                                      <div class="custom-control custom-radio">
                                                         <input type="hidden" class="keys" value="">
                                                         <input type="hidden" class="values" value="">
                                                         <input type="radio" id="{{$attrKey}}{{ $optionKey }}" name="{{ $attrKey }}" class="custom-control-input product-attr"  data-key="{{ $attrKey }}" data-price = "{{ $attrVal['prices'][$optionKey] * $curr->value }}" value="{{ $optionVal }}" {{ $loop->first ? 'checked' : '' }}>
                                                         <label class="custom-control-label" for="{{$attrKey}}{{ $optionKey }}">{{ $optionVal }}
                                                         @if (!empty($attrVal['prices'][$optionKey]))
                                                         +
                                                         {{$curr->sign}} {{$attrVal['prices'][$optionKey] * $curr->value}}
                                                         @endif
                                                         </label>
                                                      </div>
                                                      @endforeach
                                                   </div>
                                                </div>
                                             </div>
                                             @endif
                                             @endforeach
                                          </div>
                                       </div>
                                       @endif
                                    </div>
                               </div>
                                @if($productt->price != 0.00)
                                <div class="fix-bottom product-sticky-content sticky-content">
                                    <div class="product-form container">
                                    	
                                    	 @if($productt->product_type != "affiliate")
                                        <div class="product-qty-form {{ $productt->type == 'Physical' ? '' : 'd-none' }}">
                                            <div class="input-group">
                                                <input class="quantity form-control qttotal" type="number" placeholder="Total" min="1"
                                                    max="10000000">
                                                <button aria-label="Increament" class="quantity-plus w-icon-plus" type="button"></button>
                                                <button aria-label="Decreament" class="quantity-minus w-icon-minus" type="button"></button>
                                            </div>
                                        </div>
                                         @endif
                                         @if($productt->emptyStock())
                                        <button class="btn-dark btn-outline btn-cart" disabled="">
                                            <i class="w-icon-cart"></i>
                                            <span>Out of Stock</span>
                                        </button>
                                        @else
                                        <button class="single_add_to_cart_button btn-dark btn-outline btn-cart" onclick="addToCartClick()"  name="add-to-cart" type="button">
                                            <i class="w-icon-cart"></i>
                                            <span>Add to Cart</span>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <div class="col-lg-12">
                                    <label class="text-dark text-justify text-uppercase call-price">Call for price:</label>
                                    <a href="tel:{{ $gs->phone }}" class="text-primary call-price">{{ $gs->phone }}</a>
                                </div>
                                @endif
                            </form>    
                            <div class="social-links-wrapper">
                                @if(Auth::guard('web')->check())
                                <span class="divider d-xs-show"></span>
                                <div class="product-link-wrapper d-flex">
                                     <a data-href="{{ route('user-wishlist-add',$productt->id) }}" rel="nofollow" class="btn-product-icon btn-wishlist w-icon-heart add-to-wish add_to_wishlist" title="Add to wishlist"></a>
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-12 d-flex mt-3">
                                <a href="javascript:;" class="cal-ship express-ship"><i class="w-icon-truck" style="font-size:20px;color:#fd7114"></i> Calculate Shipping</a>
                            </div>
                            <div class="widget_LBZszSyOnv">
                               <div class="expert_LBZszSyOnv"><img alt="Deals On Drives" title="Deals On Drives Computer Expert" width="60px" height="60px" style="display: none;" src="" data-load="{{ asset('assets/images/chat-expert.png') }}"></div>
                               <section class="content_LBZszSyOnv">
                                  <header>
                                     <h2 class="title_LBZszSyOnv">We Are Here</h2>
                                     <h3 class="subtitle_LBZszSyOnv">Ask Our Experts</h3>
                                  </header>
                                  <div class="contact_LBZszSyOnv">
                                     <span class="caret_LBZszSyOnv">
                                     <a href="javascript:void(Tawk_API.toggle())" class="text_v_wGSQBcdt compact_v_wGSQBcdt sizeBody2_v_wGSQBcdt weightNormal_v_wGSQBcdt primaryLink_aEALyqkgyT hoverUnderline_v_wGSQBcdt">Live Chat</a>
                                     </span>
                                     <span class="caret_LBZszSyOnv">
                                     <a href="tel:+1 469-459-9688" class="text_v_wGSQBcdt compact_v_wGSQBcdt sizeBody2_v_wGSQBcdt weightNormal_v_wGSQBcdt primary_aEALyqkgyT">+1 847-677-2771</a>
                                     </span>
                                     <div>
                                        <div class="button_rqpY_qfrS7"><a href="mailto:sales@dealsondrives.com" class="text_v_wGSQBcdt compact_v_wGSQBcdt sizeBody2_v_wGSQBcdt weightNormal_v_wGSQBcdt primaryLink_aEALyqkgyT hoverUnderline_v_wGSQBcdt">Email</a>
                                        </div>
                                     </div>
                                  </div>
                               </section>
                            </div>
                        </div>
                    </div>
                    @php
                    $sku = substr($productt->sku, 0, 3);
                    $related = \App\Models\Product::where('childcategory_id',$productt->childcategory->id)
                            ->where('brand_id',$productt->brand->id ?? '')
                            ->whereNotIn('sku',[$productt->sku])
                            ->where(\DB::raw('SUBSTRING(sku,1,3)'),$sku)
                            ->limit(5)
                            ->inRandomOrder()
                            ->get();
                    @endphp
                    <div class="product-form product-variation-form product-size-swatch">
                        <label class="mb-1">Related Products</label>
                        <div class="flex-wrap d-flex product-variations">
                            @foreach($related as $row)
                            <a href="{{ route('front.product', $row->slug) }}" class="size">{{ $row->sku }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="additional-info text-left">
                            <div class="box1">
                                <i class="w-icon-truck"></i>
                            </div>
                            <div>
                                <strong>FREE GROUND SHIPPING</strong><br><p>Under 10 lbs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="additional-info text-left">
                            <div class="box1">
                                <i class="w-icon-call"></i>
                            </div>
                            <div>
                                <strong>ONLINE SUPPORT</strong><br><p>Mon-Fri / 8:00AM-5:00PM (PST)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="additional-info text-left">
                            <div class="box1">
                                <i class="w-icon-chat"></i>
                            </div>
                            <div>
                                <strong>SELLER WARRANTY</strong><br><p>30 Days</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="additional-info text-left">
                            <div class="box1">
                                <i class="w-icon-money"></i>
                            </div>
                            <div>
                                <strong>PAYMENT METHOD</strong><br><p>Secure payment</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab tab-nav-boxed tab-nav-underline product-tabs mt-5">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#product-tab-description" class="nav-link active">Overview</a>
                        </li>
                         @if(!empty($productt->specs))
                        <li class="nav-item">
                            <a href="#product-tab-specification" class="nav-link">Specs</a>
                        </li>
                         @endif
                        <li class="nav-item">
                            <a href="#product-tab-policy" class="nav-link">Warranty</a>
                        </li>
                        <li class="nav-item shipping_tab">
                            <a href="#product-tab-shipping" class="nav-link">Shipping</a>
                        </li>
                        <li class="nav-item">
                            <a href="#product-tab-qa" class="nav-link">Q&A</a>
                        </li>
                        <li class="nav-item">
                            <a href="#product-tab-reviews" class="nav-link">Reviews</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="product-tab-description">
                            <div class="row mb-4">
                                <div class="col-md-6 mb-5">
                                    <h4 class="title tab-pane-title font-weight-bold mb-2">Detail</h4>
                                    <p class="mb-4">{!! $productt->details !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="product-tab-policy">
                            <div class="row mb-4">
                                <div class="col-md-6 mb-5">
                                    <p class="mb-4">{!! $gs->policy !!}</p>
                                </div>
                            </div>
                        </div>
                         @if(!empty($productt->specs))
                        <div class="tab-pane" id="product-tab-specification">
                            <ul class="list-none">
                                <li>
                                    <p> {!! $productt->specs !!}</p>
                                </li>
                               
                            </ul>
                        </div>
                        @endif
                        <div class="tab-pane" id="product-tab-shipping">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3><strong>Our list of shipping services with their corresponding cut-off time: </strong></h3>
                                    <table style="border-collapse: collapse; width: 100%; height: 198px;" border="1">
                                     <tbody>
                                        <tr style="height: 54px;">
                                           <td style="width: 15.1123%; height: 54px; text-align: center;"><strong>Ground</strong></td>
                                           <td style="width: 84.8877%; height: 54px; text-align: left;">In the US ONLY, the transit time is between 3-7 business days, cut-off time stands at 1 PM Central Time. Depending on your location, Ground orders may be delivered by either UPS or USPS.</td>
                                        </tr>
                                        <tr style="height: 36px;">
                                           <td style="width: 15.1123%; height: 36px; text-align: center;"><strong>UPS 3 Day</strong></td>
                                           <td style="width: 84.8877%; height: 36px;">UPS orders take 3 business days in transit, however ONLY in the US. UPS 3 Day’s cut-off time is 1 PM Central Time.</td>
                                        </tr>
                                        <tr style="height: 36px;">
                                           <td style="width: 15.1123%; height: 36px; text-align: center;"><strong>FedEx 2 Day</strong></td>
                                           <td style="width: 84.8877%; height: 36px;">FedEx takes 2 business days in transit for orders placed ONLY in the US, and the cut-off time is 1 PM Central Time.</td>
                                        </tr>
                                        <tr style="height: 18px;">
                                           <td style="width: 15.1123%; height: 18px; text-align: center;"><strong>Standard Overnight</strong></td>
                                           <td style="width: 84.8877%; height: 18px;">Standard delivery service takes about 1 business day in transit for orders placed ONLY in the US. Cut-off time is 1 PM Central Time. Depending on the location, we may deliver the order by UPS Red Saver or FedEx Standard Overnight service.</td>
                                        </tr>
                                        <tr style="height: 18px;">
                                           <td style="width: 15.1123%; height: 18px; text-align: center;"><strong>Priority Overnight</strong></td>
                                           <td style="width: 84.8877%; height: 18px;">1 business day transit time for orders placed in the US ONLY, with the cut-off time at 1 PM Central Time. Depending on the location, we may deliver by UPS Red or FedEx P1 Overnight service, guaranteeing the delivery by 10:30 AM on the same day.</td>
                                        </tr>
                                        <tr style="height: 18px;">
                                           <td style="width: 15.1123%; height: 18px; text-align: center;"><strong>International Shipping</strong></td>
                                           <td style="width: 84.8877%; height: 18px;">Cut-off time for all international orders is 1 PM Central Time. We ship international orders using FedEx International Economy method.</td>
                                        </tr>
                                        <tr style="height: 18px;">
                                           <td style="width: 15.1123%; height: 18px; text-align: center;"><strong>APO/FPO</strong></td>
                                           <td style="width: 84.8877%; height: 18px;">DOD Drives ships all APO/FPO orders using USPS Registered Mail.</td>
                                        </tr>
                                        <tr style="height: 18px;">
                                           <td style="width: 15.1123%; height: 18px; text-align: center;"><strong>Puerto Rico/Canada</strong></td>
                                           <td style="width: 84.8877%; height: 18px;">All orders delivered to Puerto Rico/Canada are shipped by the delivery system of FedEx's International Economy, although their cut-off time is 1 PM Central Time</td>
                                        </tr>
                                        <tr style="height: 18px;">
                                           <td style="width: 15.1123%; height: 18px; text-align: center;"><b>Saturday Shipping</b></td>
                                           <td style="width: 84.8877%; height: 18px;">DOD Drives ships all APO/FPO orders using USPS Registered Mail.</td>
                                        </tr>
                                        <tr style="height: 18px;">
                                           <td style="width: 15.1123%; height: 18px; text-align: center;"><strong>Countries we ship to</strong></td>
                                           <td style="width: 84.8877%; height: 18px;">USA, Canada, Australia, New Zealand United Kingdom, Ireland, Germany, France, Sweden, UAE, Oman, Singapore, and China</td>
                                        </tr>
                                     </tbody>
                                    </table>
                                    <h3 class="mt-2"><strong>Shipping Charges</strong></h3>
                                      Shipping costs vary depending on a variety of factors, from shipment type, weight, and location. Once these variables are calculated during checkout, a carrier will put a price on your shipment.<br><br>
                                    <p>Read more <a href="{{ url('/') }}/shipping">{{ url('/') }}/shipping</a></p>
                                    <h3 class="mt-2"><strong>Shipping Calculator</strong></h3>
                                    <div class="row shipping-cal">
                                        <div class="col-lg-4">
                                            <div class="form-row">
                                                <div class="col-lg-12">
                                                    <p id="billing_country_field" class="validate-required validate-email">
                                                        <label class="" for="billing_country">Country Code<abbr title="required" class="required">*</abbr></label>
                                                         <select class="select2 ship-field form-control" name="customer_country" aria-labelledBy="Country" required="" id="country">
                                                            <option value="">Select Country</option>
                                                            @foreach(\DB::table('countries')->whereIn('country_code',['US','CA','GB'])->get() as $country)
                                                            <option data-id="{{ $country->id }}" value="{{ $country->country_code }}" {{ $country->country_code == "US" ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </p>
                                                </div>
                                                <div class="col-lg-12">
                                                    <p id="billing_state_field" class="address-field validate-required" data-o_class="form-row form-row form-row-wide address-field validate-required">
                                                        <label class="" for="billing_city">State Code <abbr title="required" class="required">*</abbr></label>
                                                        <select class="select2 ship-field form-control" aria-labelledBy="State" name="state" required="" id="administrative_area_level_1">
                                                            <option value="">Select Country First!</option>
                                                        </select>
                                                    </p>
                                                </div>
                                                <div class="col-lg-12">
                                                    <p id="billing_city_field" class="address-field validate-required" data-o_class="form-row form-row form-row-wide address-field validate-required">
                                                        <label class="" for="billing_city">Town / City <abbr title="required" class="required">*</abbr></label>
                                                        <input class="form-control form-control-sm ship-field" aria-labelledBy="city" placeholder="City" type="text" required id="locality" name="city" spellcheck="true" value="{{ old('city') }}">
                                                    </p>
                                                </div>
                                                <div class="col-lg-12">
                                                    <p id="billing_postcode_field" class="address-field validate-postcode validate-required" data-o_class="form-row form-row form-row-last address-field validate-required validate-postcode">
                                                        <label class="" for="billing_postcode">Postcode / ZIP <abbr title="required" class="required">*</abbr></label>
                                                        <input class="form-control form-control-sm ship-field" aria-labelledBy="Zip Code" placeholder="Zip Code" type="text" required id="postal_code" name="zip" spellcheck="true" value="{{ old('zip') }}">
                                                    </p>  
                                                </div>
                                                <div class="col-lg-12">
                                                    <button type="button" class="btn btn-primary btn-calculate mt-2">Calculate</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div id="shipments" class="mt-3">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="product-tab-qa">
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="accordion-item">
                                        <h4 class="accordion-header" id="heading1">
                                            <a href="javacript:;">How soon my order will be processed?</a>
                                        </h4>
                                        <div>
                                            <div class="card-body">
                                                <p>
                                                    Order placed during the business hours usually process within 1-2 working days, but it also depends on the type of shipping you choose during checkout. 
                                                    All the refurbished items got tested include a full cleaning and cosmetic evaluation by our certified technicians before shipping to the customer.

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h4 class="accordion-header" id="heading2">
                                            <a href="javacript:;">Do you ship outside USA?</a>
                                        </h4>
                                        <div>
                                            <div class="card-body">
                                                <p>
                                                    Yes, we ship internationally including Asia, Europe, South America and Australia. You can <a href="{{ url('/contact') }}" target="_blank">contact us</a> if you need more details.

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h4 class="accordion-header" id="heading3">
                                            <a href="javacript:;">Where is your warehouse located?</a>
                                        </h4>
                                        <div>
                                            <div class="card-body">
                                                <p>
                                                    We have multiple warehouses all over the world including USA, UK, Canada, and some parts of Europe. We ship inventory from the closest location.

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h4 class="accordion-header" id="heading4">
                                            <a href="javacript:;">Do you accept bulk orders?</a>
                                        </h4>
                                        <div>
                                            <div class="card-body">
                                                <p>
                                                   Yes, We Accept PO's from SMEs, Fortune 500 Companies, Government Agencies, Universities, and Schools.

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h4 class="accordion-header" id="heading1">
                                            <a href="javacript:;">What are refurbished items?</a>
                                        </h4>
                                        <div>
                                            <div class="card-body">
                                                <p>
                                                    Refurbished means that the item was sent back to the original manufacturer, and it has been rechecked or reassembled and to provide cost effective solution and to provide end of life products.
                                                </p>
                                                <p>
                                                    Reason to buy refurbished IT devices:
                                                </p>
                                                <ul>
                                                    <li>Better quality</li>
                                                    <li>Lower costs</li>
                                                    <li>Extend the Life of your Current Technology</li>
                                                    <li>A More Reliable Warranty</li>
                                                    <li>A Greener Solution</li>
                                                    <li>Save IT budget</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h4 class="accordion-header" id="heading6">
                                            <a href="javacript:;">The exact model I need is not listed, different image or specs are different, what should I do now?</a>
                                        </h4>
                                        <div>
                                            <div class="card-body">
                                                <p>
                                                   We have an inventory of 500,000+ SKUs and it's not possible to keep all the data up to date on our website, you can <a href="{{ url('contact') }}" target="_blank">contact us</a> with all the details and we will try to correct information or procure required part for you.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h4 class="accordion-header" id="heading7">
                                            <a href="javacript:;">Can I make a change to my order after it’s been submitted?</a>
                                        </h4>
                                        <div>
                                            <div class="card-body">
                                                <p>
                                                   Yes, but only if the order has not been processed already (check your order status). To change your order, you must get in touch with our Customer Service Department via chat or call <a href="mailto:{{ $gs->phone }}">{{ $gs->phone }}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <p>If you still have question(s) please write us at <a href="mailto:{{ $gs->email2 }}">{{ $gs->email2 }}</a> or call <a href="tel:{{ $gs->phone }}">{{ $gs->phone }}</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="product-tab-reviews">
                            <div class="row mb-4">
                                <div class="col-xl-4 col-lg-5 mb-4">
                                    <div class="ratings-wrapper">
                                        <div class="avg-rating-container">
                                            <h4 class="avg-mark font-weight-bolder ls-50">{{App\Models\Rating::rating($productt->id)}}</h4>
                                            <div class="avg-rating">
                                                <p class="text-dark mb-1">Average Rating</p>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" title="Rated {{App\Models\Rating::rating($productt->id)}} out of 5" style="width:{{ App\Models\Rating::rating($productt->id)*20 }}%"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <a href="#" class="rating-reviews">({{ count($productt->ratings) }} Reviews)</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ratings-list">
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <div class="progress-bar progress-bar-sm ">
                                                    <span></span>
                                                </div>
                                                <div class="progress-value">
                                                    <mark>100%</mark>
                                                </div>
                                            </div>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 80%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <div class="progress-bar progress-bar-sm ">
                                                    <span></span>
                                                </div>
                                                <div class="progress-value">
                                                    <mark>80%</mark>
                                                </div>
                                            </div>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 60%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <div class="progress-bar progress-bar-sm ">
                                                    <span></span>
                                                </div>
                                                <div class="progress-value">
                                                    <mark>60%</mark>
                                                </div>
                                            </div>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 40%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <div class="progress-bar progress-bar-sm ">
                                                    <span></span>
                                                </div>
                                                <div class="progress-value">
                                                    <mark>40%</mark>
                                                </div>
                                            </div>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 20%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <div class="progress-bar progress-bar-sm ">
                                                    <span></span>
                                                </div>
                                                <div class="progress-value">
                                                    <mark>20%</mark>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-7 mb-4">
                                    <div class="review-form-wrapper">
                                        <h3 class="title tab-pane-title font-weight-bold mb-1">Submit Your
                                            Review</h3>
                                        <p class="mb-3">Your email address will not be published. Required
                                            fields are marked *</p>
                                        <form novalidate="" class="comment-form review-form" id="reviewform" method="post" action="{{route('front.review.submit')}}" data-href="{{ route('front.reviews',$productt->id) }}">
                                            @include('includes.admin.form-both')
                                            @if(!Auth::check())
                                            <div class="alert alert-danger" style="\width:100%;">
                                                <button type="button" class="close alert-close"><span>×</span></button>
                                                <ul class="text-left">
                                                    Only Logged in users can rate this product.
                                                </ul>
                                            </div>
                                            @endif
                                            {{ csrf_field() }}
                                            <input type="hidden" id="rating" name="rating" value="5">
                                            <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id ?? ''}}">
                                            <input type="hidden" name="product_id" value="{{$productt->id}}">
                                            <div class="comment-form-rating">
                                                <label>Your Rating</label>
                                                <p class="stars">
                                                    <span>
                                                        <a href="javascript: void(0);" class="star-1 rate-star active">1</a>
                                                        <a href="javascript: void(0);" class="star-2 rate-star active">2</a>
                                                        <a href="javascript: void(0);" class="star-3 rate-star active">3</a>
                                                        <a href="javascript: void(0);" class="star-4 rate-star active">4</a>
                                                        <a href="javascript: void(0);" class="star-5 rate-star active">5</a>
                                                    </span>
                                                </p>
                                            </div>
                                            <p class="comment-form-comment">
                                                <label for="comment">Your Review</label>
                                                <textarea aria-required="true" rows="8" cols="45" name="review" id="comment" class="form-control" aria-labelledBy="Review"></textarea>
                                            </p>
                                            <p class="comment-form-author">
                                                <label for="author-name">Name <span class="required">*</span></label> 
                                                <input type="text" aria-required="true" class="form-control"aria-labelledBy="author-name" size="30" value="{{Auth::guard('web')->user()->name ?? ''}}" name="author" id="author">
                                            </p>
                                            <p class="comment-form-email">
                                                <label for="author-email">Email <span class="required">*</span></label> 
                                                <input type="text" aria-required="true" class="form-control" size="30"aria-labelledBy="author-email" value="{{Auth::guard('web')->user()->email ?? ''}}" name="email" id="email">
                                            </p>
                                            <p class="form-submit">
                                                <input type="submit" value="Add Review" class="submit submit-btn btn btn-dark" id="submit2" name="submit"> 
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if(count($productt->ratings) > 0)
                            <div class="tab tab-nav-boxed tab-nav-outline tab-nav-center">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="show-all">
                                        <ul class="comments list-style-none">
                                            @foreach($productt->ratings as $review)
                                            <li class="comment">
                                                <div class="comment-body">
                                                    <div class="comment-content">
                                                        <h4 class="comment-author">
                                                            <a href="#">{{ $review->user->name }}</a>
                                                            <span class="comment-date">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$review->review_date)->diffForHumans() }}</span>
                                                        </h4>
                                                        <div class="ratings-container comment-rating">
                                                            <div class="ratings-full">
                                                                <span class="ratings"
                                                                    style="width:{{$review->rating*20}}%"></span>
                                                                <span
                                                                    class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                        </div>
                                                        <p>{{$review->review}}</p>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- End of Main Content -->
            <aside class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper">
                <div class="sidebar-overlay"></div>
                <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
                <div class="sidebar-content scrollable">
                    <div class="sticky-sidebar">
                        <div class="product-actions-wrapper">
                           <div id="customScrollSection" class="product-actions">
                              <div class="comment-respond" id="respond">
                                 <h3 class="comment-reply-title mb-2" id="reply-title">Request for Quote:</h3>
                                 <div class="d-sm-block" id="quote-form-div">
                                    <form novalidate="" class="comment-form" id="quoteform" method="post" action="{{ route('request.quote') }}">
                                       {{csrf_field()}}
                                       @include('includes.admin.form-both')
                                       <div class="comment-form-rating">
                                          <label>Request a quote below or call <a href="tel:{{ $gs->phone }}">{{ $gs->phone }}</a> for further assistance with this part number</label>
                                       </div>
                                       <p class="comment-form-author">
                                          <label for="name">Name <span class="required">*</span></label> 
                                          <input type="text" class="form-control" placeholder="Enter name" aria-labelledBy="name" aria-required="true" size="30" value="" name="name" id="name">
                                       </p>
                                       <p class="comment-form-author">
                                          <label for="Email">Email <span class="required">*</span></label> 
                                          <input type="text" class="form-control" placeholder="Enter email" aria-labelledBy="Email" aria-required="true" size="30" value="" name="email" id="email">
                                       </p>
                                       <p class="comment-form-author">
                                          <label for="author-phone">Phone <span class="required">*</span></label> 
                                          <input type="text" class="form-control" placeholder="Enter phone" aria-labelledBy="author-hone" aria-required="true" size="30" value="" name="phone" id="">
                                       </p>
                                       <p class="comment-form-author">
                                          <label for="Target-Price">Target Price <span class="required">*</span></label> 
                                          <input type="text" class="form-control" placeholder="Enter target price" aria-labelledBy="Target-Price" aria-required="true" size="30" value="" name="target_price" id="">
                                       </p>
                                       <p class="comment-form-comment">
                                          <label for="comment">Quantity</label>
                                          <input type="text" class="form-control" placeholder="Enter quantity" aria-labelledBy="Quantity" class="qty-num" aria-required="true" size="30" value="" name="quantity" id="">
                                       </p>
                                       <p class="form-submit">
                                          <input type="submit" value="Get a Quote" class="submit btn btn-dark btn-outline" id="submit" name="submit"> 
                                          <input type="hidden" id="" placeholder="quote" value="{{ $productt->id }}" name="product_id">
                                       </p>
                                    </form>
                                 </div>
                                 <p class="text-center">We Accept PO's from SMEs, Startups, Fortune 1000 Companies, Government Agencies, Universities, and Schools. </p>
                                 <!-- /.comment-form -->
                              </div>
                              <!-- /.comment-respond -->
                           </div>
                           <!-- .product-actions -->
                        </div>
                    </div>
                </div>
            </aside>
            <!-- End of Sidebar -->
        </div>
    </div>
</div>
<!-- End of Page Content -->

<!-- #content -->
@endsection
@section('styles')
@endsection
@section('scripts')
<script>
    function addToCartClick(){
        const product = {!! $productt !!};
        gtag("event", "add_to_cart", {
        currency: "USD",
        value: '',
        items: [
            {
            id: product.id,
            name: product.name,
            slug: product.slug,
            price: product.price
        }]
    });
    }
    const product = {!! $productt !!};
    gtag("event", "view_item", {
       currency: "USD",
        value: '',
       items: [
        {
         id: product.id,
         name: product.name,
         slug: product.slug,
         price: product.price
      }]
   });
</script>
<script type="text/javascript">
   // $(document).ready(function () {
   // 	quote_form();
   // 	$(window).on( 'scroll', function(){
   // 		quote_form();
   // 	});
   // });
   // function quote_form() {
   // 	var win_width = $(window).width();
   // 	if(win_width >= 992){
   // 		var scroll = $(window).scrollTop();
   // 	    if(scroll > 200){
   // 	    	$("#customScrollSection").addClass("cust-scroll");
   // 	    }else{
   // 	    	$("#customScrollSection").removeClass("cust-scroll");
   // 	    }
   // 	}
   // }

   $(document).on('click','.express-ship',function(){
        $('.shipping_tab a').addClass('active show');
        $('.shipping_tab').siblings().find('.nav-link').removeClass('active')
        $('#product-tab-shipping').addClass('active show').siblings().removeClass('active show');
        
        $('html, body').animate({
            scrollTop: $(".shipping-cal").offset().top - 160
        }, 1000);
    });

   $(document).on('click','.show-request-form',function(e){
       $('#quote-form-div').slideToggle('slow').removeClass("d-none d-sm-block"); 
   });
   
   // var resizeTimer;
   //    $(window).resize(function(e) {
   //        clearTimeout(resizeTimer);
   //        resizeTimer = setTimeout(function() {
   //            if ($(window).width() <= 800) {
   //                $('.woocommerce-tabs').removeAttr("style");
   //                $('.single-product .single-product-wrapper').css("margin-bottom","20px");
   //            } else {
   //                $('.woocommerce-tabs').css("margin-top","4.8rem");
   //                $('.single-product .single-product-wrapper').css("margin-bottom","80px");
   //            }
   //        },200);
   //    });

   function shipments() {
        let street = country = state = city = zip = "";
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
        if(street != "" || country != "" || state != "" || city != "" || zip != ""){
            $('.btn-calculate').text('Loading...');
            $.ajax({
                    type: "GET",
                    url:mainurl+"/checkout/get_ship",
                    dataType: "json",
                    data:{street, country, state, city, zip},
                    success:function(data){
                        if(data.status){
                            var opts = "";
                            $("#shipments").empty();
                            $.each(data.rates, function (i, rate) {
                                if(rate.name == "FedEx Ground"){
                                    rate.name = "Ground";
                                }
                                opts += `<div class="radio-design"> 
                                            <label for="free-shepping${i}" style="font-size:20px;font-weight:bold"> 
                                                    ${rate.name}
                                                    + {{ $curr->sign }}
                                                    <small>${rate.amount}</small>
                                            </label>
                                        </div>`;
                                        $("#shipments").html(opts);
                            });
                            $('.btn-calculate').text('Calculate');
                        }else{
                            $("#shipments").empty();
                            $('.btn-calculate').text('Calculate');
                        }
                    },
                    error:function(data){
                        $('.btn-calculate').text('Calculate');
                        toastr.error("An error occured! please Re-enter address");
                    },
                    complete:function(){
                        $('.btn-calculate').text('Calculate');
                    }
              }); 
        }
    }
    var timer, delay = 1000;
    
    $(document).on("click",'.btn-calculate',function(e){
       shipments(); 
    });
    
    function getStates(){
        var id = $('select[name="customer_country"]').find(":selected").data('id'); 
        $.ajax({
            type:'get',
            url:'{{ route('fetch.states') }}',
            data:{country_id:id},
            dataType:'json',
            success: function(resp){
                $('select[name="state"]').empty().append('<option value="">Select State</option>');
                $(resp.data).each(function(i,v){
                     $('select[name="state"]').append('<option value="'+v.code+'">'+v.name+'</option>');
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
    
    getStates();
   
</script>
<?php
   if(Session::has('currency')){
   	$curr = DB::table('currencies')->where('id','=',Session::get('currency'))->first();
   }else{
   	$curr = DB::table('currencies')->where('is_default','=',1)->first();
   }
   ?>
<script type="application/ld+json">
   {
   "@context": "schema.org",
   "@type": "Product",
   "name": "{{ $productt->name }}",
   "sku": "{{ $productt->sku }}",
   "image": "{{asset('assets/images/products/'.$productt->photo)}}",
   "description": "{{ preg_replace('/[^a-zA-Z0-9\s]/', '', strip_tags(html_entity_decode($productt->details))) }}",
   "itemCondition": "{{$productt->product_condition == 1 ? "Refurbished":"New"}}",
   "weight": {
   	"@type": "QuantitativeValue",
   	"value": "{!! $productt->weight !!}",
   	"unitText": "{!! $productt->measure !!}"
   },
   "brand": {
   	"@type": "Thing",
   	"name": "{{ $productt->brand->link ?? 'Unspecified' }}"
   },
   @if(count($productt->ratings) > 0)"aggregateRating": {
   	"@type": "AggregateRating",
   	"bestRating": "100",
   	"worstRating": "0",
   	"ratingValue": "{{ App\Models\Rating::rating($productt->id)*20 }}",
   	"reviewCount": "{{ count($productt->ratings) }}",
   	"ratingCount": "{{ count($productt->ratings) }}"
   },
   @foreach($productt->ratings as $review)
   "review": {
   	"@type": "Review",
   	"reviewRating": {
   		"@type": "Rating",
   		"ratingValue": {{ $review->rating }},
   		"bestRating": 5
   	},
   	"author": "{{$review->user->name}}"
   },
   @endforeach
   @endif"offers": [{
   	"@type": "Offer",
   	"availability": "http://schema.org/InStock",
   	"priceCurrency": "USD",
   	"priceValidUntil": "{{ date('Y-m-d', strtotime('+1 year')) }}",
   	"price": {{$productt->price}},
   	"url": "{{ url('item/'.$productt->slug) }}",
   	"itemCondition": "http://schema.org/{{ $productt->product_condition == 2 ? 'New' : 'Refurbished' }}Condition"
   }]
   }
</script>
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