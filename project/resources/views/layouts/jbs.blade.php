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
	<title>{{$productt->name}}</title>
	@else
	<meta name="keywords" content="{{ $seo->meta_keys }}">
	<meta name="author" content="Abdullah">
	<meta name="description" content="deals on drive provide best hardwares">
	<title>{{$gs->title}}</title>
	@endif
	@yield('meta_tags')
	<script src="{{asset('assets/frontend-assets/fonts/webfont.js')}}" async="defer"></script>
	 {{-- <script>
		WebFontConfig = {
			google: {
				families: ['Poppins:400,500,600,700,800']
			}
		};
		(function(d) {
			var wf = d.createElement('script'),
				s = d.scripts[0];
			wf.src = '{{asset("assets/frontend-assets/fonts/webfont.js")}}';
			wf.async = true;
			s.parentNode.insertBefore(wf, s);
		})(document);
	</script> --}}
	<!-- Global site tag (gtag.js) - Google Ads: 383955002 -->
	{{-- <script async src="https://www.googletagmanager.com/gtag/js?id=AW-383955002"></script> --}}
	{{-- <script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'AW-383955002');
	</script> --}}
	@include('includes.styles')
	@yield('styles')
	
</head>

<body class="home">
	@if($gs->is_loader == 1)
	<div class="preloader" id="preloader" style="background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center #FFF;"></div>
	@endif

	@if($gs->is_popup== 1)
	@if(isset($visited))
	<div style="display:none">
		<img src="{{asset('assets/images/'.$gs->popup_background)}}" loading="lazy">
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
						<input type="email" name="email" placeholder="{{ $langg->lang741 }}" required="">
						<button id="sub-btn" type="submit" aria-label="lang">{{ $langg->lang742 }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--  Ending of subscribe-pre-loader Area   -->
	@endif
	@endif

	<div class="page-wrapper">

		<!-- .top-bar-v1 -->

		{{-- Header --}}
		@include('includes.header')

		<main class="main">
			<!-- .header-v1 -->
			
			@yield('content')

			<!-- #content -->
			<div class="container"style="padding: 10px 0px;">
				@if(!empty($brands))
				<h2 class="title" style="justify-content: center; padding: 8px 0px">Our Partners</h2>
				<div class="owl-carousel owl-theme brands-wrapper mb-9 row gutter-no cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2" data-owl-options="{
		                    'nav': false,
		                    'dots': false,
		                    'margin': 0,
		                    'loop': true,
		                    'responsive': {
		                        '0': {
		                            'items': 3
		                        },
		                        '576': {
		                            'items': 4
		                        },
		                        '768': {
		                            'items': 6
		                        },
		                        '992': {
		                            'items': 6
		                        },
		                        '1200': {
		                            'items': 6
		                        }
		                    }
		                }">
					@foreach($brands as $brand)
					<div class="brand-col">
						<a href="{{url('category?brand='.$brand->id)}}" aria-label="partners">
							<figure class="">
								<img src="{{ asset('assets/images/partner/'.$brand->photo) }}" alt="{{ $brand->name }}" width="410" height="186" />
							</figure>
						</a>
					</div>
					@endforeach
				</div>

				@endif
			</div>

		</main>


		@include('includes.footer')
		<!-- .site-footer -->
	</div>
	<div class="sticky-footer sticky-content fix-bottom">
		<a href="{{ url('') }}" class="sticky-link">
			<i class="w-icon-home"></i>
			<p>Home</p>
		</a>
		<a href="{{ url('/category') }}" class="sticky-link">
			<i class="w-icon-category"></i>
			<p>Shop</p>
		</a>
		<a href="{{ url('user/login') }}" class="sticky-link">
			<i class="w-icon-account"></i>
			<p>Account</p>
		</a>
		<div class="cart-dropdown dir-up">
			<a href="{{ url('/carts') }}" class="sticky-link">
				<i class="w-icon-cart"></i>
				<p>Cart</p>
			</a>
		</div>

		<div class="header-search hs-toggle dir-up">
			<a href="#" class="search-toggle sticky-link">
				<i class="w-icon-search"></i>
				<p>Search</p>
			</a>
			<form method="get" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" class="input-wrapper">
				@if (!empty(request()->input('sort')))
				<input type="hidden" name="sort" value="{{ request()->input('sort') }}">
				@endif
				@if (!empty(request()->input('minprice')))
				<input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
				@endif
				@if (!empty(request()->input('maxprice')))
				<input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
				@endif
				<input type="hidden" id="search-param" name="post_type" value="product" />
				<input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search" required value="{{ request()->input('search') }}" />
				<button class="btn btn-search" aria-label="search" type="submit">
					<i class="w-icon-search"></i>
				</button>
			</form>
		</div>
	</div>
	<!-- End of Sticky Footer -->

	<!-- Start of Scroll Top -->
	<a id="scroll-top" class="" href="#top" title="Top" role="button">
		<i class="w-icon-angle-up"></i>
		<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">
			<circle id="progress-indicator" fill="transparent" stroke="#000000" stroke-miterlimit="10" cx="35" cy="35" r="34" style="stroke-dasharray: 16.4198, 400;">
			</circle>
		</svg>
	</a>
	<div class="mobile-menu-wrapper">
		<div class="mobile-menu-overlay"></div>
		<!-- End of .mobile-menu-overlay -->
		<a href="#" class="mobile-menu-close"><i class="close-icon"></i></a>
		<!-- End of .mobile-menu-close -->
		<div class="mobile-menu-container scrollable">
			<form action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="get" class="input-wrapper">
				@if (!empty(request()->input('sort')))
				<input type="hidden" name="sort" value="{{ request()->input('sort') }}">
				@endif
				@if (!empty(request()->input('minprice')))
				<input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
				@endif
				@if (!empty(request()->input('maxprice')))
				<input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
				@endif
				<input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search" required value="{{ request()->input('search') }}" />
				<button class="btn btn-search" aria-label="search" type="submit">
					<i class="w-icon-search"></i>
				</button>
			</form>
			<!-- End of Search Form -->
			<div class="tab">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a href="#categories" class="nav-link">Categories</a>
					</li>
				</ul>
			</div>
			<div class="tab-content">
				<div class="tab-pane active" id="categories">
					<ul class="mobile-menu">
						@php
						$i=1;
						@endphp

						@foreach($categories as $category)
						@if(count($category->subs) > 0)
						<?php
						if ($category->id == 30) {
							$colls = 3;
						} else {
							$colls = 6;
						}
						?>
						<li>
							<a href="{{ route('front.main_category', ['category' => $category->slug]) }}">
								{{ $category->name }}
							</a>
							<ul>
								@foreach($category->subs as $subcat)
								<li>
									<a href="{{ route('front.subcat' , ['slug1' => $category->slug, 'slug2' => $subcat->slug]) }}">{{$subcat->name}}
									</a>
									<ul>
										@if(count($subcat->childs) > 0)
										@foreach($subcat->childs as $childcat)
										<li><a href="{{ route('front.childcat',['slug1' => $childcat->subcategory->category->slug, 'slug2' => $childcat->subcategory->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a></li>
										@endforeach
										@endif
									</ul>
								</li>
								@endforeach
							</ul>
						</li>
						@endif
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>



	{{-- Aos Animation --}}
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();
	</script>
	<!-- End of Scroll Top -->
	<script type="text/javascript">
		
		var mainurl = "{{url('/')}}";
		var gs = `<?php echo json_encode($gs); ?>;`;
		var langg = `<?php echo json_encode($langg); ?>;`;
		// var gs = {
		// 	!!json_encode($gs) !!
		// };
		// var langg = {
		// 	!!json_encode($langg) !!
		// };
	</script>
	@include('includes.scripts')
	{!! $seo->google_analytics !!}

	{{-- @if($gs->is_talkto == 1)
	<!--Start of Tawk.to Script-->
	{!! $gs->talkto !!}
	<!--End of Tawk.to Script-->
	@endif --}}
	@yield('scripts')
</body>

</html>
<?php die; ?>