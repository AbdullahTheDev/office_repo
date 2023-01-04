@extends('layouts.jbs')
@section('body-class', 'woocommerce-active left-sidebar')
@section('meta_tags')
<link rel="canonical" href="{{ url()->current() }}" />
@endsection
@section('content')
<div id="content" class="site-content" tabindex="-1">
  <form id="cat-prods-form" action="" method="GET">
    <input type="hidden" value="{{ request()->layout ?? 'grid' }}" name="layout" id="pge_layout">
    <input type="hidden" value="{{ request()->min ?? 0 }}" name="min" id="amt_min">
    <input type="hidden" value="{{ request()->max ?? 10000 }}" name="max" id="amt_max">
    
    <div class="col-full">
      <div class="row">
        <nav class="woocommerce-breadcrumb">
          <a href="index.php">Home</a>
          <span class="delimiter"><i class="tm tm-breadcrumbs-arrow-right"></i></span>Shop
        </nav>
        <!-- .woocommerce-breadcrumb -->
        <div id="primary" class="content-area">
          <main id="main" class="site-main">
            <div class="shop-archive-header" style="display: none;">
              <div class="jumbotron">
                <div class="jumbotron-img">
                  <!-- <img width="416" height="283" alt="" src="assets/images/products/jumbo.jpg" class="jumbo-image alignright"> -->
                </div>
                <div class="jumbotron-caption">
                  <h3 class="jumbo-title"></h3>
                  <p class="jumbo-subtitle">Nullam dignissim elit ut urna rutrum, a fermentum mi auctor. Mauris efficitur magna orci, et dignissim lacus scelerisque sit amet. Proin malesuada tincidunt nisl ac commodo. Vivamus eleifend porttitor ex sit amet suscipit. Vestibulum at ullamcorper lacus, vel facilisis arcu. Aliquam erat volutpat.
                    <a href="https://www.google.com/search?q=" target="_blank">read more <i class="tm tm-long-arrow-right"></i></a>
                  </p>
                </div>
                <!-- .jumbotron-caption -->
              </div>
              <!-- .jumbotron -->
            </div>
            <!-- .shop-archive-header -->
            <div class="shop-control-bar">
              <div class="handheld-sidebar-toggle">
                <button type="button" class="btn sidebar-toggler">
                <i class="fa fa-sliders"></i><span>Filters</span>
                </button>
              </div>
              <!-- .handheld-sidebar-toggle -->
              <h1 class="woocommerce-products-header__title page-title">Shop</h1>
              <ul role="tablist" class="shop-view-switcher nav nav-tabs mr-5">
                <li class="nav-item">
                  <a href="#" title="Grid View" class="nav-link layout-chng {{ request()->layout == '' || request()->layout == 'grid' ? 'active' : '' }}" data-layout="grid">
                  <i class="tm tm-grid-small"></i>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" title="Grid Extended View" class="nav-link layout-chng {{ request()->layout == 'extended' ? 'active' : '' }}" data-layout="extended">
                  <i class="tm tm-grid"></i>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" title="List View Large" class="nav-link layout-chng {{ request()->layout == 'list' ? 'active' : '' }}" data-layout="list">
                  <i class="tm tm-listing-large"></i>
                  </a>
                </li>
              </ul>
              <!-- .shop-view-switcher -->
              <div class="row">
                  <div class="col-lg-12">
                    <select class="techmarket-wc-wppp-select c-select mr-3 border-0 disp-prod1" onchange="this.form.submit()" name="display_prods">
                      <option value="50" {{ request()->display_prods == "50" ? 'selected' : '' }}>Show 50</option>
                      <option value="100" {{ request()->display_prods == "100" ? 'selected' : '' }}>Show 100</option>
                      <option value="-1" {{ request()->display_prods == "-1" ? 'selected' : '' }}>Show All</option>
                    </select>
                  <!-- .form-techmarket-wc-ppp -->
                    <select class="orderby p-2 ml-1" name="sort" onchange="this.form.submit()">
                      <option value="date_desc" {{ request()->sort == "date_desc" ? 'selected' : '' }}>Sort by newness</option>
                      <option value="date_asc" {{ request()->sort == "date_asc" ? 'selected' : '' }}>Sort by oldest</option>
                      <option value="price_asc" {{ request()->sort == "price_asc" ? 'selected' : '' }}>Sort by price: low to high</option>
                      <option value="price_desc" {{ request()->sort == "price_desc" ? 'selected' : '' }}>Sort by price: high to low</option>
                    </select>
                    </div>
                </div>
              <!-- .woocommerce-ordering -->
              <nav class="techmarket-advanced-pagination ml-1">
                  <input name="page" type="number" value="{{ $prods->currentPage() }}" class="form-control" step="1" data-max="{{ $prods->lastPage() }}" max="{{ $prods->lastPage() }}" min="1" size="2" id="goto-page">
                &nbsp;of&nbsp;{{ $prods->lastPage() }}<a href="#" class="next page-numbers">→</a>
              </nav>
              <!-- .techmarket-advanced-pagination -->
            </div>
            <!-- .shop-control-bar -->
            <div class="tab-content">
                <p class="col" style="font-size:18px;">If you don't see an item that you are looking for, feel free to <strong><a href="https://jbsdevices.com/contact">contact us</a></strong>. We have access to over 1 million items in stock and can help locate your required item. <br> <br>   <strong>Phone:</strong>  <a href="tel:+1 469-459-9688">+923368473429</a> <br>  <strong>Email: </strong><a href="mailto:support@jbsdevices.com ">support@jbsdevices.com </a></p>
              <div id="grid" class="tab-pane {{ request()->layout == '' || request()->layout == 'grid' ? 'active' : '' }}" role="tabpanel">
                <div class="woocommerce columns-5">
                  <div class="products">
                    @forelse($prods as $prod)
                      <div class="product">
                        @if(Auth::guard('web')->check())
                        <div class="yith-wcwl-add-to-wishlist">
                          <a data-href="{{ route('user-wishlist-add',$prod->id) }}" rel="nofollow" class="add-to-wish add_to_wishlist"> Add to Wishlist</a>
                        </div>
                        @endif
                        <a href="{{ route('front.product', $prod->slug) }}" class="woocommerce-LoopProduct-link">
                          <img src="{{ $prod->photo }}" width="224" height="197" class="wp-post-image" alt="">
                          <span class="price">
                          <span class="amount">{{ $prod->showPrice() }} </span>
                          <del><span class="amount"> {{ $prod->showPreviousPrice() }}</span></del>
                          </span><!-- /.price -->
                          <h2 class="woocommerce-loop-product__title">
                            {{ $prod->showName() }}
                          </h2>
                        </a>
                        <div class="hover-area">
                          @if($prod->stock === 0)
                          <span class="add-to-cart-btn cart-out-of-stock">
                            <i class="icofont-close-circled"></i> {{ $langg->lang78 }}
                          </span>
                          @else
                          <span class="button add_to_cart_button add-to-cart add-to-cart-btn" data-href="{{ route('product.cart.add',$prod->id) }}" rel="nofollow">Add to cart</span>
                          @endif
                          <span class="add-to-compare add-to-compare-link" data-href="{{ route('product.compare.add',$prod->id) }}">Add to compare</span>
                        </div>
                      </div>
                      <!-- /.product-outer -->
                      @empty
                        <p class="col">No products found in your selected filters!</p>
                      @endforelse
                  </div>
                  <!-- .products -->
                </div>
                <!-- .woocommerce -->
              </div>
              <!-- .tab-pane -->
              <div id="grid-extended" class="tab-pane {{ request()->layout == 'extended' ? 'active' : '' }}" role="tabpanel">
                <div class="woocommerce columns-3">
                  <div class="products">
                    @forelse($prods as $prod)
                    <div class="product first">
                      @if(Auth::guard('web')->check())
                      <div class="yith-wcwl-add-to-wishlist">
                        <a data-href="{{ route('user-wishlist-add',$prod->id) }}" rel="nofollow" class="add-to-wish add_to_wishlist"> Add to Wishlist</a>
                      </div>
                      @endif
                      <!-- .yith-wcwl-add-to-wishlist -->
                      <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="{{ route('front.product', $prod->slug) }}">
                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="{{ $prod->photo }}">
                        <span class="price">
                          <span class="amount">{{ $prod->showPrice() }} </span>
                          <del><span class="amount"> {{ $prod->showPreviousPrice() }}</span></del>
                        </span>
                        <h2 class="woocommerce-loop-product__title">{{ $prod->showName() }}</h2>
                      </a>
                      <!-- .woocommerce-LoopProduct-link -->
                      <div class="techmarket-product-rating">
                        <div title="Rated 0 out of 5" class="star-rating"><span style="width:{{App\Models\Rating::ratings($prod->id)}}%"><strong class="rating">{{App\Models\Rating::rating($prod->id)}}</strong> out of 5</span>
                        </div>
                        <span class="review-count">({{App\Models\Rating::count($prod->id)}})</span>
                      </div>
                      <!-- .techmarket-product-rating -->
                      <span class="sku_wrapper">SKU: <span class="sku">{{ $prod->sku }}</span></span>
                      <div class="woocommerce-product-details__short-description">
                        <ul>
                          <li>Condition : {{ $prod->condition == 0 ? 'New' : ($prod->condition == 1 ? 'Used' : 'New') }}</li>
                          <li>Availability : @if($prod->emptyStock()) Out of Stock @else In Stock @endif</li>
                          <li>Manufacturer : {{ $prod->brand->link ?? "Unspecified" }}</li>
                        </ul>
                      </div>
                      <!-- .woocommerce-product-details__short-description -->
                      @if($prod->stock === 0)
                      <span class="add-to-cart-btn cart-out-of-stock">
                        <i class="icofont-close-circled"></i> {{ $langg->lang78 }}
                      </span>
                      @else
                      <span class="button add_to_cart_button add-to-cart add-to-cart-btn" data-href="{{ route('product.cart.add',$prod->id) }}" rel="nofollow">Add to cart</span>
                      @endif
                      <span class="add-to-compare add-to-compare-link" data-href="{{ route('product.compare.add',$prod->id) }}">Add to compare</span>
                    </div>
                    @empty
                      <p class="col">No products found in your selected filters!</p>
                    @endforelse
                  </div>
                  <!-- .products -->
                </div>
                <!-- .woocommerce -->
              </div>
              <!-- .tab-pane -->
              <div id="list-view-large" class="tab-pane {{ request()->layout == 'list' ? 'active' : '' }}" role="tabpanel">
                <div class="woocommerce columns-1">
                  <div class="products">
                    @forelse($prods as $prod)
                    <div class="product list-view-large first ">
                      <div class="media">
                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="{{ $prod->photo }}">
                        <div class="media-body">
                          <div class="product-info">
                            @if(Auth::guard('web')->check())
                            <div class="yith-wcwl-add-to-wishlist">
                              <a data-href="{{ route('user-wishlist-add',$prod->id) }}" rel="nofollow" class="add-to-wish add_to_wishlist"> Add to Wishlist</a>
                            </div>
                            @endif
                            <!-- .yith-wcwl-add-to-wishlist --> 
                            <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="{{ route('front.product', $prod->slug) }}">
                              <h2 class="woocommerce-loop-product__title">{{ $prod->showName() }}</h2>
                              <div class="techmarket-product-rating">
                                <div title="Rated 0 out of 5" class="star-rating"><span style="width:{{App\Models\Rating::ratings($prod->id)}}%"><strong class="rating">{{App\Models\Rating::rating($prod->id)}}</strong> out of 5</span>
                                </div>
                                <span class="review-count">({{App\Models\Rating::count($prod->id)}})</span>
                              </div>
                            </a>
                            <!-- .woocommerce-LoopProduct-link -->
                            @if($prod->brand)
                            <div class="brand">
                              <a href="#">
                              <img alt="galaxy" src="{{ asset('assets/images/partner/'.$prod->brand->photo) }}"></a>
                            </div>
                            <!-- .brand -->
                            @endif
                            <div class="woocommerce-product-details__short-description">
                              <ul>
                                <li>Condition : {{ $prod->condition == 0 ? 'New' : ($prod->condition == 1 ? 'Used' : 'New') }}</li>
                                <li>Availability : @if($prod->emptyStock()) Out of Stock @else In Stock @endif</li>
                                <li>Manufacturer : {{ $prod->brand->link ?? "Unspecified" }}</li>
                              </ul>
                            </div>
                            <!-- .woocommerce-product-details__short-description -->
                            <span class="sku_wrapper">SKU: <span class="sku">{{ $prod->sku }}</span></span>
                          </div>
                          <!-- .product-info -->
                          <div class="product-actions">
                            <div class="availability">
                              Availability: 
                              @if($prod->emptyStock())
                              <p class="stock out-of-stock">out of stock</p>
                              @else
                              <p class="stock in-stock">in stock</p>
                              @endif
                            </div>
                            <span class="price">
                              <span class="amount">{{ $prod->showPrice() }} </span>
                              <del><span class="amount"> {{ $prod->showPreviousPrice() }}</span></del>
                            </span>
                            @if($prod->stock === 0)
                            <span class="add-to-cart-btn cart-out-of-stock">
                              <i class="icofont-close-circled"></i> {{ $langg->lang78 }}
                            </span>
                            @else
                            <span class="button add_to_cart_button add-to-cart add-to-cart-btn" data-href="{{ route('product.cart.add',$prod->id) }}" rel="nofollow">Add to cart</span>
                            @endif
                            <span class="add-to-compare add-to-compare-link" data-href="{{ route('product.compare.add',$prod->id) }}">Add to compare</span>
                          </div>
                          <!-- .product-actions -->
                        </div>
                        <!-- .media-body -->
                      </div>
                      <!-- .media -->
                    </div>
                    <!-- .product -->
                    @empty
                      <p class="col">No products found in your selected filters!</p>
                    @endforelse
                  </div>
                  <!-- .products -->
                </div>
                <!-- .woocommerce -->
              </div>
              <!-- .tab-pane -->          
            </div>
            <!-- .tab-content -->
            <div class="shop-control-bar-bottom">
              <!-- <form class="form-techmarket-wc-ppp" method="POST"> -->
                <select class="techmarket-wc-wppp-select c-select border-0 disp-prod2">
                  <option value="50" {{ request()->display_prods == "50" ? 'selected' : '' }}>Show 50</option>
                  <option value="100" {{ request()->display_prods == "100" ? 'selected' : '' }}>Show 100</option>
                  <option value="-1" {{ request()->display_prods == "-1" ? 'selected' : '' }}>Show All</option>
                </select>
              <!-- </form> -->
              <!-- .form-techmarket-wc-ppp -->
              <p class="woocommerce-result-count">
                Showing {{ $prods->currentPage() != 1 ? (($prods->currentPage() - 1) * $prods->perPage())+1 : 1 }}
                &ndash;{{ $prods->currentPage() != $prods->lastPage() ? $prods->count() * $prods->currentPage() : $prods->total() }}
                 of {{ $prods->total() }} results
              </p>
              <!-- .woocommerce-result-count -->
              <nav class="woocommerce-pagination">

                {!! $prods->appends(['search' => request()->input('search'), 'display_prods' => request()->input('display_prods'), 'layout' => request()->input('layout'), 'min' => request()->input('min'), 'max' => request()->input('max'), 'sort' => request()->input('sort')])->links() !!}

              </nav>
              <!-- .woocommerce-pagination -->
            </div>
            <!-- .shop-control-bar-bottom -->       
          </main>
          <!-- #main -->
        </div>
        <!-- #primary -->
        <div id="secondary" class="widget-area shop-sidebar" role="complementary">
          <div class="widget woocommerce widget_product_categories techmarket_widget_product_categories" id="techmarket_product_categories_widget-2">
            <ul class="product-categories ">
              <li class="product_cat">
                <span>Browse Categories</span>
                <ul>
                  @foreach ($categories as $element)
                  <li class="mcat_item">
                    <div class="content">
                        <a href="{{route('front.category', $element->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="category-link"> <i class="fa fa-angle-right"></i> {{$element->name}}</a>
                        @if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs))
                            @foreach ($cat->subs as $key => $subelement)
                            <div class="sub-content">
                              <a href="{{route('front.category', [$cat->slug, $subelement->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="subcategory-link"><i class="fa fa-angle-right"></i>{{$subelement->name}}</a>
                              @if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs))
                                @foreach ($subcat->childs as $key => $childcat)
                                <div class="child-content">
                                  <a href="{{route('front.category', [$cat->slug, $subcat->slug, $childcat->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="subcategory-link"><i class="fa fa-angle-right"></i> {{$childcat->name}}</a>
                                </div>
                                @endforeach
                              @endif
                            </div>
                            @endforeach

                          </div>
                        @endif
                  </li>
                  @endforeach
                </ul>
              </li>
            </ul>
          </div>
          <div id="techmarket_products_filter-3" class="widget widget_techmarket_products_filter">
            <div class="widget woocommerce widget_price_filter" id="woocommerce_price_filter-2">
              <p>
                <span class="gamma widget-title">Filter by price</span>
              <div class="price_slider_amount">
                <input id="amount" type="text" placeholder="Min price" data-min="0 - 100" value="0 - 100" style="display: none;">
                <!-- <button class="button filterPrice" type="button">Filter</button> -->
              </div>
              <div id="slider-range" class="price_slider"></div>
            </div>   
            <button class="button filterPrice btn-block" type="button">Filter</button>
          </div>      
        </div>
        <!-- #secondary -->
      </div>
      <!-- .row -->
    </div>
    <!-- .col-full -->
  </form>
</div>
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