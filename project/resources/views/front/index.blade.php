@extends('layouts.jbs')

@section('content')

@if(Session::has('msg'))
<div class="alert alert-success validation" id="alert">
    <button onclick="alert()" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h3 class="text-center" style="color: #fff">{{ Session::get("msg") }}</h3>
</div>
@endif

@if(Session::has('success'))
<div class="alert alert-success validation" id="alert">
    <button onclick="alert()" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h3 class="text-center" style="color: #fff">{{ Session::get("success") }}</h3>
</div>
@endif

<section class="intro-section">
    <div class="owl-carousel owl-theme owl-nav-inner owl-dot-inner owl-nav-lg gutter-no row cols-1" data-owl-options="{
      'nav': false,
      'dots': false,
      'loop': true,
      'items': 1,
      'autoplay':true,
        'autoplayTimeout':2200,
        'autoplaySpeed': 2200,
        'autoplayHoverPause':true,
        'slideTransition': 'linear',
      'responsive': {
      '1600': {
      'nav': true,
      'dots': false
      }   
      }
      }">
        @if($ps->slider == 1)
        @foreach($sliders as $data)
        <div class="banner banner-fixed intro-slide intro-slide1" style="background-color: #000000; height: min-content !important;">
            <div class="container">
                <figure class="slide-image skrollable custom_added_carousel">
                    <picture>
                            <img style="display: none;" src="" data-load="{{ asset('assets/images/sliders') }}/{{ $data->photo }}" alt="Banner" data-bottom-top="transform: translateY(10vh);" data-top-bottom="transform: translateY(-10vh);" width="474" height="397">
                        </picture>
                </figure>
                <div class="banner-content y-50">
                    <h1 class="banner-subtitle font-weight-normal text-default ls-50 lh-1 mb-2 slide-animate" data-animation-options="{
                  'name': 'fadeInRightShorter',
                  'duration': '1s',
                  'delay': '.2s'
                  }" style="font-size: {{ $data->title_size }} !important; color: {{ $data->title_color }} !important;">{{ $data->title_text }}
                    </h1>
                    <h2 class="banner-title ls-25 lh-1 slide-animate" data-animation-options="{
                  'name': 'fadeInRightShorter',
                  'duration': '1s',
                  'delay': '.4s'
                  }" style="font-weight: 500 !important; font-size: {{ $data->subtitle_size }} !important; color: {{ $data->subtitle_color }} !important;">{!! $data->subtitle_text !!}
                    </h2>
                    <p class="font-weight-normal text-default slide-animate" data-animation-options="{
                  'name': 'fadeInRightShorter',
                  'duration': '1s',
                  'delay': '.6s'
                  }" style="font-size: {{ $data->details_size }} !important; color: {{ $data->details_color }} !important;">{{ $data->details_text }}
                    </p>
                    <a href="javascript:void(0)" class="btn btn-outline-custom btn-rounded btn-icon-right slide-animate" data-animation-options="{
                  'name': 'fadeInRightShorter',
                  'duration': '1s',
                  'delay': '.8s'
                  }" onclick="location.href='{{ $data->link }}'">SHOP NOW<i class="w-icon-long-arrow-right"></i></a>
                </div>
                <!-- End of .banner-content -->
            </div>
            <!-- End of .container -->
        </div>
        @endforeach
        @endif
        <!-- End of .intro-slide1 -->
        <!-- End of .intro-slide3 -->
    </div>
    <!-- End of .owl-carousel -->
</section>
<div class="container" style="display: none;" id="service_container">
    <div class="owl-carousel owl-theme row cols-md-4 cols-sm-3 cols-1 br-sm mt-6 mb-6" data-owl-options="{
      'nav': false,
      'dots': false,
      'loop': false,
      'responsive': {
      '0': {
      'items': 1
      },
      '576': {
      'items': 2
      },
      '768': {
      'items': 3
      },
      '992': {
      'items': 3
      },
      '1200': {
      'items': 4
      }
      }
      }">
        @if(!empty($services))
        @foreach($services as $service)
        <div class="icon-box icon-box-side icon-box-primary">
            <span class="icon-box-icon icon-shipping">
                {{-- <img src="{{ asset('assets/images/services') }}/{{ $service->photo }}" width="42" height="45" alt="services"> --}}
                {{-- <i class="w-icon-chat"></i> --}}
                {!! $service->photo !!}
            </span>
            <div class="icon-box-content">
                <h4 class="icon-box-title font-weight-bold mb-1">{{ $service->title }}</h4>
                <p class="text-default">{{ $service->details }}</p>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <!-- End of Iocn Box Wrapper -->
</div>
@if($ps->featured_category == 1)
<section class="category-section top-category bg-grey pt-10 pb-10">
    <div class="container pb-2">
        <h2 data-aos="fade-up" data-aos-duration="3000" class="title justify-content-center pt-1 ls-normal mb-5">Our <span style="color: #9e1d14; margin: 0px 6px">Featured</span> Categories</h2>
        <div class="owl-carousel owl-theme row cols-lg-6 cols-md-5 cols-sm-3 cols-2" data-owl-options="{
         'nav': false,
         'dots': false,
         'margin': 20,
         'responsive': {
         '0': {
         'items': 2
         },
         '576': {
         'items': 3
         },
         '768': {
         'items': 5
         },
         '992': {
         'items': 6
         }
         }
         }">
            @foreach($categories->where('is_featured','=',1) as $cat)
            <div class="category category-classic category-absolute overlay-zoom radius-10">
                <a href="{{ route('front.category',$cat->slug) }}" class="category-media">
                    <img style="display: none;" src="" data-load="{{ asset('assets/images/categories') }}/{{ $cat->image }}" alt="{{ $cat->name }}">
                </a>
                <div class="category-content">
                    <h4 class="category-name">{{ $cat->name }}</h4>
                    <a href="{{ route('front.category',$cat->slug) }}" class="btn btn-primary btn-link btn-underline">Shop
                        Now</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Sales  --}}
<div class="container">
    <div class="row pt-10 pb-10">
        <div class="col-12 col-lg-3 col-sm-6 mb-4">
            <div class="sales-inquiry">
                <div class="container-fluid">
                    <h2 class="inquiry-title">Sales <span class="theme_color">Inquiry</span></h2>
                    <p>Our Dedicated Account Manager will get in touch with you shortly</p>
                    <div class="alert alert-success validation" style="display: none; width:100%;">
                        <button type="button" class="close alert-close"><span>×</span></button>
                        <p>Query Submitted Successfully</p>
                    </div>
                    <div class="alert alert-danger validation" style="display: none;width:100%;">
                        <button type="button" class="close alert-close"><span>×</span></button>
                        <ul class="text-left">
                        </ul>
                    </div>
                    <form method="POST" action="{{ route('request.sale_inquiry') }}" id="quoteform">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" placeholder="ex.John" class="form-control" name="name" required />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" placeholder="ex.john@example.com" class="form-control" name="email" required />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="number" placeholder="ex.12345" class="form-control" name="phone" required />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                                <label>Company Name <span class="text-danger">*</span></label>
                                <input type="text" placeholder="ex.Company" class="form-control" name="company_name" required />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                                <label>Part Number <span class="text-danger">*</span></label>
                                <input type="text" placeholder="ex.65892" class="form-control" name="part_number" required />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-1">
                                <label>Target Price <span class="text-danger">*</span></label>
                                <input type="number" placeholder="ex.5400" class="form-control" name="target_price" required />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-1">
                                <label>Quantity <span class="text-danger">*</span></label>
                                <input type="number" placeholder="ex.10" class="form-control" name="qty" required />
                            </div>
                        </div>
                        <p class="form-submit mt-2">
                            <input type="submit" class="btn btn-dark btn-outline btn-sm radius-10" value="Submit" class="submit" id="submit" name="submit">
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <!-- End of Inquiry Form -->
        <div class="col-12 col-lg-9 col-sm-12">
            @php
            $multiple_sections = $sections->whereIn("sort",[2,3,4])->where("status",1)->take(2);
            @endphp
            @if(!empty($multiple_sections))
            <div class="tab tab-nav-boxed tab-nav-outline">
                <ul class="nav nav-tabs active-underline" role="tablist">
                    @foreach($multiple_sections as $key => $section)
                    <li role="tab" class="nav-item mr-2 mb-2">
                        <a class="nav-link br-sm font-size-md ls-normal {{ $key == 1 ? 'active' : '' }}" href="#tab{{ $key }}">{{ $section->heading }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div style="overflow-y: auto; height: 550px;"  class="tab-content product-wrapper">
                @foreach($multiple_sections as $key => $section)
                @php
                $section_products = $section->products(
                $section->id,
                $section->type,
                $section->category_id, $section->sub_category_id, $section->child_category_id
                );
                @endphp
                <div class="tab-pane pt-4 {{ $key == 1 ? 'active' : '' }}" id="tab{{ $key }}">
                    {{-- <div class="row cols-xl-3 cols-md-3 cols-sm-2 cols-2"> --}}
                    <div class="grid-container-4">
                        @if($section_products->count())
                        @foreach($section_products as $prod)
                        <div style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;" class="custom_feature">
                            <figure class="custom_feature_image">
                                <a class="" href="{{ route('front.product', $prod->slug) }}">
                                    <img loading="lazy" width="400" height="200" src="{{ $prod->photo  }}" alt="{{ $prod->showName() }}">
                                </a>
                            </figure>
                            <div class="custom_feature_details">
                                <div class="product-cat">
                                    <a class="hidden_a" href="{{ route('front.category',$prod->category->slug) }}">{{ $prod->category->name }}</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="{{ route('front.product', $prod->slug) }}" class=" text_ellipse">{{ $prod->showName() }}</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">{{ $prod->showPrice() }}</ins><del class="old-price">{{ $prod->showPreviousPrice() }}</del>
                                </div>
                            </div>
                            <div class="custom_feature_details_hidden">
                                <div class="custom_feature_div">
                                    @if($prod->stock !== 0)
                                        @if($prod->price != 0)
                                            <a href="{{ route('product.cart.add',$prod->id) }}" class="button single_add_to_cart_button custom_btn_add_to_cart" name="add-to-cart" title="Add to Cart">
                                                <i class="w-icon-cart"></i>
                                                <span>Add To Cart</span>
                                            </a>
                                            <a href="{{ route('product.cart.add-checkout',$prod->id) }}" class="button single_add_to_cart_button custom_btn_add_to_cart" name="add-to-cart" title="Add to Cart">
                                                {{-- <i class="w-icon-cart"></i> --}}
                                                <span>Buy Now</span>
                                            </a>
                                        @else
                                            <a href="#" class="call_price" title="Call Of Price">
                                                <span>Call For Price</span>
                                            </a>
                                        @endif
                                    @else
                                        <a href="#" class="out_stock" title="{{ $langg->lang78 }}">
                                            <span>{{ $langg->lang78 }}</span>
                                        </a>
                                    @endif
                                    @if(Auth::guard('web')->check())
                                        <a data-href="{{ route('user-wishlist-add',$prod->id) }}" rel="nofollow" class="custom_btn_wishlist btn-wishlist w-icon-heart add-to-wish add_to_wishlist" title="Add to wishlist"></a>
                                    @endif
                                    {{-- <a data-href="{{ route('product.compare.add',$prod->id) }}" class="btn-product-icon btn-compare w-icon-compare add-to-compare add-to-compare-link" title="Compare"></a> --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                @endforeach
                <!-- End of Tab Pane -->
                <!-- End of Tab Pane -->
            </div>
            <!-- End of Tab Content -->
            @endif
        </div>
        </div>
    </div>
{{-- Sales End  --}}
<div class="container-fluid">
    @php
    $section = $sections->where("sort",5)->where("status",1)->first();
    @endphp
    @if(!empty($section))
    <div class="fullwidth-notice stretch-full-width br-sm mb-9" style="background: url('{{ asset('assets/images/sections') }}/{{ $section->img1 }}')">
        <div class="banner-content align-items-center">
            <div class="col-full">
                <p class="message">{{ $section->heading1 }}</p>
            </div>
            <!-- .col-full -->
        </div>
    </div>
    <!-- End of Banner Fashion -->
    @endif
</div>
<div class="container">
    @php
    $section = $sections->where("sort",7)->where("status",1)->first();
    @endphp
    @if(!empty($section))
    @php
    $bg = $sections->where("sort",6)->first();
    $section_products = $section->products($section->id,$section->type,$section->category_id, $section->sub_category_id, $section->child_category_id);
    //background-size: cover; background-position: center center; background-image: url( {{ asset('assets/images/sections') }}/{{ $bg->img1 }} );
    @endphp
    <section class="mb-2 mb-lg-6 pt-3 pb-3 pl-3 pr-3">
        <h2 class="title title-center mb-5">{{ $section->heading }}</h2>
        <div class="row product-wrapper">
            @if($section_products->count())
            @foreach($section_products as $prod)
            <div class="col-md-2 col-6">
                <div class="product product-slideup-content">
                    <figure class="product-media">
                        <a href="{{ route('front.product', $prod->slug) }}">
                            <img loading="lazy" src="{{ $prod->photo  }}" alt="{{ $prod->showName() }}" width="295" height="335">
                        </a>
                    </figure>
                    <div class="product-details">
                        <div class="product-cat">
                            <a href="{{ route('front.category',$prod->category->slug) }}">{{ $prod->category->name }}</a>
                        </div>
                        <h3 class="product-name">
                            <a href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a>
                        </h3>
                        <div class="product-price">
                            <ins class="new-price">{{ $prod->showPrice() }}</ins><del class="old-price">{{ $prod->showPreviousPrice() }}</del>
                        </div>
                    </div>
                    <div class="product-hidden-details">
                        <div class="product-action">
                            @if($prod->stock !== 0)
                            @if($prod->price != 0)
                            <a data-href="{{ route('product.cart.add',$prod->id) }}" class="button add_to_cart_button add-to-cart add-to-cart-btn btn-product btn btn-dark btn-outline btn-rounded btn-sm btn-cart" title="Add to Cart">
                                <i class="w-icon-cart"></i>
                                <span>Add To Cart</span>
                            </a>
                            @else
                            <a href="#" class="call_price" title="Call Of Price">
                                <span>Call For Price</span>
                            </a>
                            @endif
                            @else
                            <a href="#" class="out_stock" title="{{ $langg->lang78 }}">
                                <span>{{ $langg->lang78 }}</span>
                            </a>
                            @endif
                            @if(Auth::guard('web')->check())
                            <a href="{{ route('user-wishlist-add',$prod->id) }}" class="btn-product-icon btn-wishlist w-icon-heart" title="Add to wishlist"></a>
                            @endif
                            <a href="{{ route('product.compare.add',$prod->id) }}" class="btn-product-icon btn-compare w-icon-compare" title="Compare"></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </section>
    @endif
</div>
</div>
<div class="container-fluid" style="background-color: #f8f8f8;">
    <div class="container" style="padding: 10px 0px">

    <h2 class="title justify-content-center ls-normal mb-4 mt-10 pt-1">Popular Products
    </h2>
    @php
    $multiple_sections = $sections->whereIn("sort",[8,9,10])->where("status",1);
    @endphp
    @if(!empty($multiple_sections))
    <div class="tab tab-nav-boxed tab-nav-outline">
        <ul class="nav nav-tabs" role="tablist">
            @foreach($multiple_sections as $key => $section)
            <li role="tab" class="nav-item mr-2 mb-2">
                <a class="nav-link br-sm font-size-md ls-normal {{ $key == 7 ? 'active' : '' }}" href="#{{ $section->id }}g{{ $key }}">{{ $section->heading }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <div style="background-color: transparent !important;" class="tab-content product-wrapper">
        @foreach($multiple_sections as $key => $section)
        @php
        $section_products = $section->products(
        $section->id,
        $section->type,
        $section->category_id, $section->sub_category_id, $section->child_category_id
        );
        @endphp
        <div class="tab-pane pt-4 {{ $key == 7 ? 'active' : '' }}" id="{{ $section->id }}{{ $key }}">
            <div class="grid-container-6">
                @if($section_products->count())
                @foreach($section_products as $prod)
                <div class="custom_feature">
                    <figure class="custom_feature_image">
                        <a href="{{ route('front.product', $prod->slug) }}">
                            <img loading="lazy" width="400" height="200" src="{{ $prod->photo  }}" alt="{{ $prod->showName() }}" width="295" height="335">
                        </a>
                    </figure>
                    <div class="custom_feature_details">
                        <div class="product-cat">
                            <a href="{{ route('front.category',$prod->category->slug) }}">{{ $prod->category->name }}</a>
                        </div>
                        <h3 class="product-name">
                            <a href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a>
                        </h3>
                        <div class="product-price">
                            <ins class="new-price">{{ $prod->showPrice() }}</ins><del class="old-price">{{ $prod->showPreviousPrice() }}</del>
                        </div>
                    </div>
                    <div class="custom_feature_details_hidden">
                        <div class="product-action">
                            @if($prod->stock !== 0)
                            @if($prod->price != 0)
                            <a data-href="{{ route('product.cart.add',$prod->id) }}" class="button custom_btn_add_to_cart" title="Add to Cart">
                                <i class="w-icon-cart"></i>
                                <span>Add To Cart ff</span>
                            </a>
                            @else
                            <a href="#" class="call_price" title="Call Of Price">
                                <span>Call For Price</span>
                            </a>
                            @endif
                            @else
                            <a href="#" class="out_stock" title="{{ $langg->lang78 }}">
                                <span>{{ $langg->lang78 }}</span>
                            </a>
                            @endif
                            @if(Auth::guard('web')->check())
                            <a href="{{ route('user-wishlist-add',$prod->id) }}" class="custom_btn_wishlist btn-wishlist w-icon-heart" title="Add to wishlist"></a>
                            @endif
                            <a href="{{ route('product.compare.add',$prod->id) }}" class="btn-product-icon btn-compare w-icon-compare" title="Compare"></a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        @endforeach
        <!-- End of Tab Pane -->
        <!-- End of Tab Pane -->
    </div>
    <!-- End of Tab Content -->
    @endif
    </div>
</div>
@endsection
<script>
    function alert(){
        document.getElementById("alert").style.display = 'none';
    }
</script>