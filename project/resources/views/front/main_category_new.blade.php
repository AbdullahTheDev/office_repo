@extends('layouts.front')
@section('content')
<!-- SubCategori Area Start -->
<section class="sub-categori pt-0">
   <div class="container bg-white">
      <div class="row">
         <div class="col-lg-2 ptb-30 b1">
         	<h6 class="cat-list-heading pb-2 pl-4 pt-2">FEATURED CATEGORIES</h6>
         	<ul class="pl-4 cat-list">
         		@forelse($category->subs as $sub)
         			<li class="pt-3"><a href="{{ route('front.subcat',['slug1' => $category->slug, 'slug2' => $sub->slug]) }}">{{$sub->name}}</a></li>
         		@empty
         			<li class="pt-3"><a href="#">No categories found!</a></li>
         		@endforelse
         	</ul>
         	<hr />
         </div>
         <div class="col-lg-10 order-first order-lg-last ajax-loader-parent">
         	@if($category->img1 != "")
		        <section class="banner-section p-0">
					<div class="container ptb-30">
						<div class="row">
							<div class="col-lg-12 remove-padding">
								<div class="left">
									<a class="banner-effect" href="{{ $category->link1 }}" target="_blank">
										<img src="{{ asset('assets/images/categories/'.$category->img1) }}" alt="">
									</a>
								</div>
							</div>
						</div>
					</div>
				</section>
		    @endif

			@if($category->img2 != "")
		        <section class="banner-section p-0">
					<div class="container ptb-30">
						<div class="row">
							<div class="col-lg-6 remove-padding">
								<div class="left">
									<a class="banner-effect" href="{{ $category->link2 }}" target="_blank">
										<img src="{{ asset('assets/images/categories/'.$category->img2) }}" alt="">
									</a>
								</div>
							</div>
							<div class="col-lg-6 remove-padding">
								<div class="left">
									<a class="banner-effect" href="{{ $category->link3 }}" target="_blank">
										<img src="{{ asset('assets/images/categories/'.$category->img3) }}" alt="">
									</a>
								</div>
							</div>
						</div>
					</div>
				</section>
		    @endif

			@if($category->img4 != "")
		        <section class="banner-section p-0">
					<div class="container ptb-30">
						<div class="row">
							<div class="col-lg-3 remove-padding">
								<div class="left">
									<a class="banner-effect" href="{{ $category->link4 }}" target="_blank">
										<img src="{{ asset('assets/images/categories/'.$category->img4) }}" alt="">
									</a>
								</div>
							</div>
							<div class="col-lg-3 remove-padding">
								<div class="left">
									<a class="banner-effect" href="{{ $category->link5 }}" target="_blank">
										<img src="{{ asset('assets/images/categories/'.$category->img5) }}" alt="">
									</a>
								</div>
							</div>
							<div class="col-lg-3 remove-padding">
								<div class="left">
									<a class="banner-effect" href="{{ $category->link6 }}" target="_blank">
										<img src="{{ asset('assets/images/categories/'.$category->img6) }}" alt="">
									</a>
								</div>
							</div>
							<div class="col-lg-3 remove-padding">
								<div class="left">
									<a class="banner-effect" href="{{ $category->link7 }}" target="_blank">
										<img src="{{ asset('assets/images/categories/'.$category->img7) }}" alt="">
									</a>
								</div>
							</div>
						</div>
					</div>
				</section>
		    @endif
            <div class="right-area container" id="app">
               @forelse($category->subs as $sub)
					@if($sub->products->count() > 0)
					<div class="row">
						<div class="col-lg-12 remove-padding">
							<div class="section-top">
								<h2 class="section-title">
									{{$sub->name}}
								</h2>
								<a href="{{ route('front.subcat',['slug1' => $category->slug, 'slug2' => $sub->slug]) }}" class="link">View All</a>
							</div>
						</div>
					</div>
           			<div class="row">
						<div class="col-lg-12 remove-padding">
							<div class="trending-item-slider">
								@foreach($sub->products as $prod)
									@include('includes.product.slider-product')
								@endforeach
							</div>
						</div>
					</div>
					@endif
               @empty
               	<h4>No Products Found for your selected filters!</h4>
               	<center>
               		<h4><a href="{{url('')}}">Browse for more</a></h4>
               	</center>
               @endforelse
            </div>
         </div>
      </div>
   </div>
</section>
<!-- SubCategori Area End -->
@endsection


@section('scripts')

<script>

</script>

@endsection