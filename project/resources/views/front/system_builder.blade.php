@extends('layouts.front')

@section('styles')

<style type="text/css">
	
	    .root.root--in-iframe {
      background: #4682b447 !important;
    }
    .mybtn1{
    	width: auto;
	    padding-left: 10px;
	    padding-right: 10px;
    }
</style>

@endsection



@section('content')

<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul class="pages">
					<li>
						<a href="{{ route('front.index') }}">
							{{ $langg->lang17 }}
						</a>
					</li>
					<li>
						<a href="{{ route('front.checkout') }}">
							System Builder
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- Breadcrumb Area End -->

	<!-- Check Out Area Start -->
	<section class="checkout">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="text-center">SYSTEM BUILDER</h4>
					<div class="checkout-area">
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade active show" id="pills-step2" role="tabpanel" aria-labelledby="pills-step2-tab">
								<div class="content-box">
									@forelse($components as $component)
									<div class="content">
										@php $show = true; @endphp
										@if(!empty($component["products"]))
										@foreach($component["products"] as $product)
										<div class="order-area">
											<div class="order-item row">
												<div class="product-img col-lg-2">
													<div class="d-flex">
														<img src="{{asset('assets/images/products/'.$product->photo)}}" height="80" width="80" class="p-1">
													</div>
												</div>
												<div class="product-content col-lg-10">
													<div class="align-items-center d-flex justify-content-md-center row h-100">
														<div class="col-sm-8">
															<p class="name"><a href="{{ route('front.product',$product->slug) }}" target="_blank">{{$product->name}}</a></p>
														</div>
														<div class="total-price col-sm-2">
															<h5 class="label">Price : </h5>
															<p>{{ App\Models\Product::convertPrice($product->price) }}
															</p>
														</div>
														<div class="col-sm-2">
															<a href="{{url('carts')}}"class="mybtn1">Buy Now</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										@endforeach
										@endif

										@if($component["products"]->count() > 0 && $component['component']->multiple_products == 0)
											@php $show = false; @endphp
										@endif

										@if($show)
										<div class="row">
											<div class="col-lg-12 mt-3">
												<div class="bottom-area">
													<a href="{{ route('front.subcat',['slug1' => $component['component']->subcategory->category->slug, 'slug2' => $component['component']->subcategory->slug]) }}" class="mybtn1">+ Choose a {{$component['component']->name}}</a>
												</div>
											</div>
										</div>
										<hr>
										@endif
									</div>
									@empty
									@endforelse

									<a href="{{url('carts')}}"class="float-right m-3 mybtn1">Continue</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
		<!-- Check Out Area End-->

@endsection

@section('scripts')

@endsection