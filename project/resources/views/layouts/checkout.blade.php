<!DOCTYPE html>
<html lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
		@if(isset($page->meta_tag) && isset($page->meta_description))
        <meta name="keywords" content="{{ $page->meta_tag }}">
        <meta name="description" content="{{ $page->meta_description }}">
		<title>{{$gs->title}}</title>
	    @elseif(isset($blog->meta_tag) && isset($blog->meta_description))
        <meta name="keywords" content="{{ $blog->meta_tag }}">
        <meta name="description" content="{{ $blog->meta_description }}">
		<title>{{$gs->title}}</title>
	    @elseif(isset($productt))
		<meta name="keywords" content="{{ !empty($productt->meta_tag) ? implode(',', $productt->meta_tag ): '' }}">
		<meta name="description" content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}">
	    <meta property="og:title" content="{{$productt->name}}" />
	    <meta property="og:description" content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}" />
	    <meta property="og:image" content="{{asset('assets/images/thumbnails/'.$productt->thumbnail)}}" />
	    <meta name="author" content="EezeSolutions">
    	<title>{{substr($productt->name, 0,11)."-"}}{{$gs->title}}</title>
	    @else
	    <meta name="keywords" content="{{ $seo->meta_keys }}">
	    <meta name="author" content="EezeSolutions">
		<title>{{$gs->title}}</title>
	    @endif
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/bootstrap.min.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/font-awesome.min.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/bootstrap-grid.min.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/bootstrap-reboot.min.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/font-techmarket.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/slick.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/techmarket-font-awesome.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/slick-style.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/animate.min.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/toastr.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/style.min.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/colors/orange.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/jbs') }}/css/custom-styles.css" media="all" />
		<link rel="stylesheet" href="{{ asset('assets/jbs') }}/css/light_box.min.css" media="all" />
		<!--<link rel="stylesheet" href="{{ asset('assets/jbs') }}/css/app.css" media="all" />-->
		<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,900" rel="stylesheet">
		<link rel="shortcut icon" href="{{asset('assets/images/'.$gs->favicon)}}">
		@yield('styles')
        <!-- Global site tag (gtag.js) - Google Ads: 383955002 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-383955002"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'AW-383955002');
        </script>
        <script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>
        @yield('ga_script')
	</head>
	<body class="@yield('body-class')">
		@if($gs->is_loader == 1)
			<div class="preloader" id="preloader" style="background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center #FFF;"></div>
		@endif
		@if($gs->is_popup== 1)
			@if(isset($visited))
			    <div style="display:none">
			        <img src="{{asset('assets/images/'.$gs->popup_background)}}">
			    </div>
			    <!--  Starting of subscribe-pre-loader Area   -->
			    <div class="subscribe-preloader-wrap" id="subscriptionForm" style="display: none;">
			        <div class="subscribePreloader__thumb" style="background-image: url({{asset('assets/images/'.$gs->popup_background)}});">
			            <span class="preload-close"><i class="fas fa-times"></i></span>
			            <div class="subscribePreloader__text text-center">
			                <h1>{{$gs->popup_title}}</h1>
			                <p>{{$gs->popup_text}}</p>
			                <form action="{{route('front.subscribe')}}" id="subscribeform" method="POST">
			                    {{csrf_field()}}
			                    <div class="form-group">
			                        <input type="email" name="email"  placeholder="{{ $langg->lang741 }}" required="">
			                        <button id="sub-btn" type="submit">{{ $langg->lang742 }}</button>
			                    </div>
			                </form>
			            </div>
			        </div>
			    </div>
			    <!--  Ending of subscribe-pre-loader Area   -->
			@endif
		@endif
		<div id="page" class="hfeed site">
			<div class="top-bar top-bar-v1">
				<div class="col-lg-12 text-center" style="display: -webkit-inline-box;">
					{!! $gs->headr !!}
					
					@if($gs->is_currency == 1)
							<div class="currency-selector" style="position:relative;right:84px;">
					<span>{{ Session::has('currency') ?   DB::table('currencies')->where('id','=',Session::get('currency'))->first()->sign   : DB::table('currencies')->where('is_default','=',1)->first()->sign }}</span>
							<select name="currency" class="currency selectors nice">
							@foreach(DB::table('currencies')->get() as $currency)
								<option value="{{route('front.currency',$currency->id)}}" {{ Session::has('currency') ? ( Session::get('currency') == $currency->id ? 'selected' : '' ) : (DB::table('currencies')->where('is_default','=',1)->first()->id == $currency->id ? 'selected' : '') }} >{{$currency->name}}</option>
							@endforeach
							</select>
							</div>
						@endif
				</div>
			</div>
			<!-- .top-bar-v1 -->
			<header id="masthead" class="site-header header-v1" style="background-image: none; padding-top:0.6em;padding-bottom:0.6em;">
				<div class="col-full desktop-only">
					<div class="">
						<div class="row">
						    <div style="flex:0 0 25%; max-width:25%"></div>
							<div class="site-branding" style="flex:0 0 20%; max-width:20%;display:flex;justify-content:center;">
								<a href="{{url('')}}" class="custom-logo-link" rel="home">
									<img src="{{asset('assets/images/'.$gs->logo)}}" style="max-width:160px;">
								</a><!-- /.custom-logo-link -->
							</div>
							<ul class="header-compare nav navbar-nav mt-3">
							<li class="nav-item">
								<a href="tel:{{ $gs->phone }}" class="nav-link">
								<i class="tm tm-call-us-footer"></i>
								<span id="top-cart-compare-count" class="value">{{ $gs->phone }}</span>
								</a>
							</li>
						</ul>
						<!-- .header-compare -->
						<ul class="header-wishlist nav navbar-nav mt-3">
							<li class="nav-item">
								<a href="{{ url('user/login') }}" class="nav-link">
								<i class="fa fa-user-o"></i>
								<span id="top-cart-wishlist-count" class="value">Account</span>
								</a>
							</li>
						</ul>
						<!-- .header-wishlist -->
						<ul id="site-header-cart" class="site-header-cart menu mt-4">
							<li class="animate-dropdown dropdown ">
								<a class="cart-contents" href="index.php?page=cart" data-toggle="dropdown" title="View your shopping cart">
								<i class="tm tm-shopping-bag"></i>
								<span id="cart-count" class="count cart-quantity">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
								<span class="amount"><span class="price-label">Your Cart</span> 
								<!-- <b class="cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '' }}</b> -->
								</span>
								</a>
								<ul class="dropdown-menu dropdown-menu-mini-cart">
									<li>
										<div class="widget woocommerce widget_shopping_cart">
											<div class="widget_shopping_cart_content" id="cart-items">
												@include('load.cart')
											</div>
											<!-- .widget_shopping_cart_content -->
										</div>
										<!-- .widget_shopping_cart -->
									</li>
								</ul>
								<!-- .dropdown-menu-mini-cart -->
							</li>
						</ul>
						<!-- .site-header-cart -->
							<!-- /.site-branding -->
							<!-- ============================================================= End Header Logo ============================================================= -->
							
						</div>
						<!-- /.row -->
					</div>
					<!-- .techmarket-sticky-wrap -->
					
					<!-- /.row -->
				</div>
				<!-- .col-full -->
				<div class="col-full handheld-only">
					<div class="handheld-header">
						<div class="row">
							<div class="site-branding">
								<a href="{{url('')}}" class="custom-logo-link" rel="home">
								<img src="{{asset('assets/images/'.$gs->logo)}}">
								</a><!-- /.custom-logo-link -->
							</div>
							<!-- /.site-branding -->
							<!-- ============================================================= End Header Logo ============================================================= -->
							<div class="handheld-header-links">
								<ul class="columns-3">
									<li class="my-account">
										<a href="{{ url('user/login') }}" class="has-icon">
										<i class="tm tm-login-register"></i>
										</a>
									</li>
									<li class="wishlist">
										<a href="tel:{{ $gs->phone }}" class="has-icon">
										<i class="tm tm-call-us-footer"></i>
										</a>
									</li>
									<!-- <li class="compare">
										<a href="index.php?page=compare" class="has-icon">
											<i class="tm tm-compare"></i><span class="count">3</span>
										</a>
										</li> -->
								</ul>
								<!-- .columns-3 -->
							</div>
							<!-- .handheld-header-links -->
						</div>
						<!-- /.row -->
						<div class="techmarket-sticky-wrap">
							<div class="row">
								<nav id="handheld-navigation" class="handheld-navigation" aria-label="Handheld Navigation">
									<button class="btn navbar-toggler" type="button">	
									<i class="tm tm-departments-thin"></i>
									<span>Menu</span>
									</button>
									<div class="handheld-navigation-menu">
										<span class="tmhm-close">Close</span>
										<ul id="menu-departments-menu-1" class="nav">
											@foreach($categories as $category)
											@if(count($category->subs) > 0)
											<li class="yamm-tfw menu-item menu-item-has-children animate-dropdown dropdown-submenu">
												<a title="{{ $category->name }}" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="#">{{ $category->name }} <span class="caret"></span></a>
												<ul role="menu" class=" dropdown-menu">
													<li class="menu-item menu-item-object-static_block animate-dropdown">
														<div class="yamm-content">
															<div class="bg-yamm-content bg-yamm-content-bottom bg-yamm-content-right">
																<div class="kc-col-container">
																	<div class="kc_single_image">
																		<img src="{{ asset('assets/jbs') }}/images/megamenu.jpg" class="" alt=""/>
																	</div>
																	<!-- .kc_single_image -->
																</div>
																<!-- .kc-col-container -->
															</div>
															<!-- .bg-yamm-content -->
															<div class="row yamm-content-row">
																@foreach($category->subs as $subcat)
																<div class="col-md-6 col-sm-12">
																	<div class="kc-col-container">
																		<div class="kc_text_block">
																			<ul>
																				<li class="nav-title">
																					{{$subcat->name}}
																				</li>
																				@if(count($subcat->childs) > 0)
																				@foreach($subcat->childs as $childcat)
																				<li><a href="{{ route('front.childcat',['slug1' => $childcat->subcategory->category->slug, 'slug2' => $childcat->subcategory->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a></li>
																				@endforeach
																				@endif
																				<li><a href="{{ route('front.subcat',['slug1' => $subcat->category->slug, 'slug2' => $subcat->slug]) }}">All in {{$subcat->name}}</a></li>
																			</ul>
																		</div>
																		<!-- .kc_text_block -->
																	</div>
																	<!-- .kc-col-container -->
																</div>
																<!-- .kc_column -->
																@endforeach
																<div class="col-md-12 col-sm-12">
																	<div class="kc-col-container">
																		<div class="kc_text_block">
																			<ul class="p-0">
																				<li class="nav-divider"></li>
																				<li><a href="{{ route('front.category',$category->slug) }}">All in {{$category->name}}</a></li>
																			</ul>
																		</div>
																		<!-- .kc_text_block -->
																	</div>
																	<!-- .kc-col-container -->
																</div>
															</div>
															<!-- .kc_row -->
														</div>
														<!-- .yamm-content -->
													</li>
												</ul>
											</li>
											@else
											<li class="menu-item animate-dropdown">
												<a title="{{ $category->name }}" href="{{ route('front.category',$category->slug) }}">{{ $category->name }}</a>
											</li>
											@endif
											@endforeach
										</ul>
									</div>
									<!-- .handheld-navigation-menu -->
								</nav>
								<!-- .handheld-navigation -->
								<div class="site-search">
									<div class="widget woocommerce widget_product_search">
										<form role="search" method="get" class="woocommerce-product-search" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}">
											<label class="screen-reader-text" for="woocommerce-product-search-field-0">Search for:</label>
											<input type="search" id="woocommerce-product-search-field-0" class="search-field" placeholder="Search products&hellip;" value="{{ request()->get('search') }}" name="search"/>
											<input type="submit" value="Search"/>
											<input type="hidden" name="post_type" value="product"/>
										</form>
									</div>
									<!-- .widget -->
								</div>
								<!-- .site-search -->
								<a class="handheld-header-cart-link has-icon" href="{{ url('checkout') }}" title="View your shopping cart">
								<i class="tm tm-shopping-bag"></i>
								<span class="count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
								</a>
							</div>
							<!-- /.row -->
						</div>
						<!-- .techmarket-sticky-wrap -->
					</div>
					<!-- .handheld-header -->
				</div>
				<!-- .handheld-only -->
			</header>
			<!-- .header-v1 -->
			@yield('content')
			<!-- #content -->
			<footer class="site-footer footer-v1">
				<div class="col-full">
					<div class="footer-widgets-block">
						<div class="row">
							<div class="footer-contact col-md-3">
								<div class="footer-logo">
									<a href="index.php" class="custom-logo-link" rel="home">
									<img src="{{asset('assets/images/'.$gs->logo)}}">
									</a>
								</div>
								<!-- .footer-logo -->					
							</div>
							<!-- .footer-logo -->
							<div class="footer-widgets">
								<div class="columns">
									<aside class="widget widget_nav_menu clearfix">
										<div class="body">
											<h4 class="widget-title">Categories</h4>
											<div class="menu-footer-menu-1-container">
												<ul id="menu-footer-menu-1" class="menu">
													@if(!empty($footers))
													@foreach($footers as $footer)
													<li class="menu-item">
														<a href="{{ route('front.category',['slug1' => $footer->slug]) }}">{{$footer->name}}</a>
													</li>
													@endforeach
													@endif
												</ul>
											</div>
											<!-- .menu-footer-menu-1-container -->
										</div>
										<!-- .body -->
									</aside>
									<!-- .widget -->
								</div>
								<!-- .columns -->
								<div class="columns">
									<aside class="widget widget_nav_menu clearfix">
										<div class="body">
											<h4 class="widget-title">Costumer Services</h4>
											<div class="menu-footer-menu-1-container">
												<ul id="menu-footer-menu-1" class="menu">
													@foreach(DB::table('pages')->where('footer','=',1)->get() as $data)
													<li class="menu-item">
														<a href="{{ route('front.page',$data->slug) }}">{{ $data->title }}</a>
													</li>
													@endforeach
													<li class="menu-item">
														<a href="{{ url('contact') }}"> Contact Us </a>
													</li>
													<li class="menu-item">
														<a href="{{ url('faq') }}"> FAQs </a>
													</li>
												</ul>
											</div>
											<!-- .menu-footer-menu-1-container -->
										</div>
										<!-- .body -->
									</aside>
									<!-- .widget -->
								</div>
								<!-- .columns -->
								<div class="columns">
									<aside class="widget widget_nav_menu clearfix">
										<div class="body">
											<h4 class="widget-title">Your account</h4>
											<div class="menu-footer-menu-1-container">
												<ul id="menu-footer-menu-1" class="menu">
													<li class="menu-item">
														<a href="{{ url('user/login') }}">Login & Register</a>
													</li>
													<li class="menu-item">
														<a href="{{ url('user/login') }}">My account</a>
													</li>
													<li class="menu-item">
														<a href="{{ url('carts') }}">Shopping cart</a>
													</li>
													<li class="menu-item">
														<a href="{{ route('user-wishlists') }}">Wishlist</a>
													</li>
												</ul>
											</div>
											<!-- .menu-footer-menu-1-container -->
										</div>
										<!-- .body -->
									</aside>
									<!-- .widget -->
								</div>
								<!-- .columns -->
							</div>
							<!-- .footer-widgets -->
							<div class="footer-contact pt-0 ml-3">
								<div class="contact-payment-wrap">
									<div class="footer-contact-info p-0">
										<div class="media">
											<!--<span class="media-left icon media-middle"> <i class="tm tm-call-us-footer"></i></span>-->
											<div class="media-body">
												<span class="call-us-title mt-0">Contact information</span>
												<b class="font-bold"> <i class="fa fa-map-marker"></i> Address</b>
												<address class="footer-contact-address">{{ $gs->address }}</address>
												<b class="font-bold"> <i class="fa fa-envelope-o"></i> Email</b>
												<address class="footer-contact-address m-0"><b class="font-bold"></b> {{ $gs->email1 }}</address>
												<address class="footer-contact-address"><b class="font-bold"></b> {{ $gs->email2 }}</address>
												<b class="font-bold"> <i class="fa fa-clock-o"></i> Working Hours</b>
												<address class="footer-contact-address">{{ $gs->working_hours }}</address>

												<b class="font-bold"> <i class="fa fa-phone"></i> Phone</b>
												<address class="footer-contact-address"><a href="tel:{{ $gs->phone }}">{{ $gs->phone }}</a></address>
											</div>
											<!-- .media-body -->
										</div>
										<!-- .media -->
									</div>
									<!-- .footer-contact-info -->
								</div>
								<!-- .contact-payment-wrap -->					
							</div>
							<!-- .footer-contact -->
						</div>
						<!-- .row -->
						<!-- <div class="row d-none">
							<ul class="footer-links d-flex flex-wrap">
								<li>
									<a href="index.php?page=about">About Us</a>
								</li>
								<li>
									<a href="index.php?page=services">Services</a>
								</li>
								<li>
									<a href="index.php?page=careers">Careers at JBS</a>
								</li>
								<li>
									<a href="index.php?page=contact">Contact Us</a>
								</li>
							</ul>
						</div> -->
						<!-- .row -->
						<div class="row">
							<div class="col-full">
								<img src="{{ asset('assets/jbs') }}/images/payments.png">
							</div>
						</div>
						<!-- .row -->
					</div>
					<!-- .footer-widgets-block -->
					<div class="site-info">
						<div class="col-full">
							<div class="copyright">
								{!! $gs->copyright !!}
								<br>
								<center>
									Designed and Developed By
									<br>
									<img src="{{ asset('assets/images/ez-logo.png') }}" width="100" onclick="window.open('https://eezesolutions.com')" class="dev-logo">
								</center>
							</div>
						</div>
						<!-- .col-full -->
					</div>
					<!-- .site-info -->
				</div>
				<!-- .col-full -->
			</footer>
			<!-- .site-footer -->
		</div>
		<script type="text/javascript">
			var mainurl = "{{url('/')}}";
			var gs      = {!! json_encode($gs) !!};
			var langg    = {!! json_encode($langg) !!};
		</script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/jquery.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/tether.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/jquery-migrate.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/hidemaxlistitem.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/jquery.easing.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/scrollup.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/jquery.waypoints.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/waypoints-sticky.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/pace.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/slick.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/toastr.min.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/scripts.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/custom.js"></script>
		<script type="text/javascript" src="{{ asset('assets/jbs') }}/js/light_box.min.js"></script>
		{!! $seo->google_analytics !!}

		@if($gs->is_talkto == 1)
			<!--Start of Tawk.to Script-->
			{!! $gs->talkto !!}
			<!--End of Tawk.to Script-->
		@endif
		@yield('scripts')
	</body>
</html>
<?php die; ?>