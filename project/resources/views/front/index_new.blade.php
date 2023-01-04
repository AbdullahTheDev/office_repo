@extends('layouts.front')

@section('styles')
	<style type="text/css">
		body{
			overflow-x: hidden;
		}
		.pre-bg{
			background: #fff;
			width: 100%;
			height: 100%;
			position: fixed;
		    z-index: 9999999999999;
		}
		.loder{
		    height:50px;
		    width:50px;
		    -webkit-animation: expand 2s;
		    animation-fill-mode: forwards; 
		    position:fixed;
		    left:50%;
		    border:2px solid #e8582b;
		    border-radius:50%;
		}

		.pre-img{
		  width: 30px;
		  height:30px;
		  margin:10px;
		  -webkit-animation: expand2 2s;
		    animation-fill-mode: forwards;
		}

		@-webkit-keyframes expand{
		    0%{top:0%;width:50px;height:50px;}
		    /*2%{top:0%;width:50px;height:50px;}*/
		    30%{top:50%;width:50px;height:50px;}
		    40%{top:50%;width:50px;height:50px;}
		    60%{top:50%;width:50px;height:50px;}
		    79%{top:90%;width:10px;height:10px;}
		    80%{top:90%;width:10px;height:10px;background: transparent;}
		    90%{top:90%;transform: scale(1);background: #e8582b;}
		    100%{top:90%;transform: scale(50);background: #e8582b;}
		}

		@-webkit-keyframes expand2{
		    0%{top:0%;width:30px;height:30px;}
		    /*2%{top:0%;width:30px;height:30px;}*/
		    30%{top:50%;width:30px;height:30px;}
		    40%{top:50%;width:30px;height:30px;}
		    60%{top:50%;width:30px;height:30px;}
		    79%{top:90%;width:0px;height:0px;}
		    90%{top:90%;width:0px;height:0px;}
		    100%{top:90%;width:0px;height:0px;}
		}
		.preloader{
			display: none !important; 
		}
	</style>
@endsection
@section('home-preloader')
<div class="pre-bg">
	<div class="loder">
	    <img src="{{asset('assets/front/images')}}/logo-footer.png" class="pre-img">
	</div>
</div>	
@endsection
@section('content')

	@if($ps->slider == 1)

		@if(count($sliders))
			@include('includes.slider-style')
		@endif
	@endif

	@if($ps->slider == 1)
		<!-- Hero Area Start -->
		<section class="hero-area">
			@if($ps->slider == 1)

				@if(count($sliders))
					<div class="hero-area-slider">
						<div class="slide-progress"></div>
						<div class="intro-carousel">
							@foreach($sliders as $data)
								<div class="intro-content {{$data->position}}" style="background-image: url({{asset('assets/images/sliders/'.$data->photo)}})">
									<!-- <div class="container">
										<div class="row">
											<div class="col-lg-12">
												<div class="slider-content">
													<div class="layer-1">
														<h4 style="font-size: {{$data->subtitle_size}}px; color: {{$data->subtitle_color}}" class="subtitle subtitle{{$data->id}}" data-animation="animated {{$data->subtitle_anime}}">{{$data->subtitle_text}}</h4>
														<h2 style="font-size: {{$data->title_size}}px; color: {{$data->title_color}}" class="title title{{$data->id}}" data-animation="animated {{$data->title_anime}}">{{$data->title_text}}</h2>
													</div>
													<div class="layer-2">
														<p style="font-size: {{$data->details_size}}px; color: {{$data->details_color}}"  class="text text{{$data->id}}" data-animation="animated {{$data->details_anime}}">{{$data->details_text}}</p>
													</div>
													<div class="layer-3">
														<a href="{{$data->link}}" target="_blank" class="mybtn1"><span>{{ $langg->lang25 }} <i class="fas fa-chevron-right"></i></span></a>
													</div>
												</div>
											</div>
										</div>
									</div> -->
								</div>
							@endforeach
						</div>
					</div>
				@endif

			@endif

		</section>
		<!-- Hero Area End -->
	@endif

	
	@if($ps->featured_category == 1)

	{{-- Slider buttom Category Start --}}
	<section class="slider-buttom-category d-none d-md-block p-0">
		<div class="container pt-24 bg-white">
			<div class="row">
				@foreach($categories->where('is_featured','=',1) as $cat)
					<div class="col-xl-1 col-lg-3 col-md-4">
						<a href="{{ route('front.category',$cat->slug) }}" class="single-category rounded-circle h-85p border-2">
							<!-- <div class="left">
								<h5 class="title">
									{{ $cat->name }}
								</h5>
								<p class="count">
									{{ count($cat->products) }} {{ $langg->lang4 }}
								</p>
							</div> -->
							<!-- <div class="right"> -->
								<img src="{{asset('assets/images/categories/'.$cat->image) }}" alt="" class="rounded-circle ">
							<!-- </div> -->
						</a>
					</div>
				@endforeach
			</div>
		</div>
	</section>
	{{-- Slider buttom banner End --}}

	@endif

	@if(!empty($sections))
        @foreach($sections as $section)
            @if($section->type == "products" || $section->type == "category")
            	<section class="trending p-0">
					<div class="container pt-36 bg-white">
						<div class="row">
							<div class="col-lg-12 remove-padding">
								<div class="section-top">
									<h2 class="section-title">
										{{$section->heading}}
									</h2>
									@if($section->link != "")
										<a href="{{$section->link}}" class="link">View All</a>
									@endif
								</div>
							</div>
						</div>
						@php
                            $section_products = $section->products($section->id,$section->type,$section->category_id);
                        @endphp
                        @if(!empty($section_products))
						<div class="row">
							<div class="col-lg-12 remove-padding">
								<div class="trending-item-slider">
									@foreach($section_products as $prod)
										@include('includes.product.slider-product')
									@endforeach
								</div>
							</div>
						</div>
						@endif
					</div>
				</section>
            @else
	            @php
	                $columns = 12/$section->columns;
	            @endphp
            	<section class="banner-section p-0">
					<div class="container ptb-30 bg-white">
						<div class="row">
							@for($i=1;$i<=$section->columns;$i++)
								<div class="col-lg-{{$columns}} remove-padding">
									<div class="left">
										<a class="banner-effect" href="{{ $section->{'link'.$i} }}" target="_blank">
											<img src="{{asset('assets/images/sections/'.$section->{'img'.$i})}}" alt="">
											<h3 class="color-black" style="background-color: {{ $section->{'bg'.$i} }}">{{ $section->{'heading'.$i} }}</h3>
										</a>
									</div>
								</div>
							@endfor
						</div>
					</div>
				</section>
            @endif
        @endforeach
    @endif

@endsection

@section('scripts')
	<script type="text/javascript">
		function load_func() {
		    $('.pre-bg').delay(350).fadeOut('slow');
		}
		var pageLoaded = false;
		var timeoutElapsed = false;

		$(window).on('load', function() {
		    pageLoaded = true;
		    if (timeoutElapsed) {
		        load_func();
		    }
		});

		setTimeout(function() {
		    timeoutElapsed = true;
		    if (pageLoaded) {
		        load_func();
		    }
		}, 2000);
	</script>
@endsection