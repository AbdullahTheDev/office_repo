@extends('layouts.jbs')
@section('body-class', 'woocommerce-active single-product full-width extended')
@section('content')
<div id="content" class="site-content">
	<div class="col-full">
		<div class="row">
			<nav class="woocommerce-breadcrumb">
				<a href="{{route('front.index')}}">Home</a>
				<span class="delimiter"><i class="tm tm-breadcrumbs-arrow-right"></i></span>
				<a href="{{route('front.category',$productt->category->slug)}}">{{$productt->category->name}}</a>
				@if($productt->subcategory_id != null)
				<span class="delimiter"><i class="tm tm-breadcrumbs-arrow-right"></i></span>
				<a
	              href="{{ route('front.subcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug]) }}">{{$productt->subcategory->name}}</a>
	            @endif
	            @if($productt->childcategory_id != null)
	            <span class="delimiter"><i class="tm tm-breadcrumbs-arrow-right"></i></span>
	            <a
	              href="{{ route('front.childcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug, 'slug3' => $productt->childcategory->slug]) }}">{{$productt->childcategory->name}}</a>
	            @endif
				<span class="delimiter"><i class="tm tm-breadcrumbs-arrow-right"></i></span>
				<span>{{ $productt->name }}</span>
			</nav>
			<!-- .woocommerce-breadcrumb -->
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
					<div class="product">
						<div class="single-product-wrapper">
							<div class="product-images-wrapper thumb-count-4">
								@if($productt->showPreviousPrice() != "")
								<span class="onsale">
									{{ $productt->get_percent() }}<span class="woocommerce-Price-currencySymbol">%</span> off
								</span>
								<!-- .onsale -->
								@endif
								<div id="techmarket-single-product-gallery" class="techmarket-single-product-gallery techmarket-single-product-gallery--with-images techmarket-single-product-gallery--columns-4 images" data-columns="4">
									<div class="techmarket-single-product-gallery-images" data-ride="tm-slick-carousel" data-wrap=".woocommerce-product-gallery__wrapper" data-slick="{&quot;infinite&quot;:false,&quot;slidesToShow&quot;:1,&quot;slidesToScroll&quot;:1,&quot;dots&quot;:false,&quot;arrows&quot;:false,&quot;asNavFor&quot;:&quot;#techmarket-single-product-gallery .techmarket-single-product-gallery-thumbnails__wrapper&quot;}">
										<div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4">
											<!-- <a href="#" class="woocommerce-product-gallery__trigger">🔍</a>  -->
											<figure class="woocommerce-product-gallery__wrapper ">

												<div data-thumb="{{asset('assets/images/products/'.$productt->photo)}}" class="woocommerce-product-gallery__image">
													<a href="#" tabindex="0">
													<img width="600" height="600" src="{{asset('assets/images/products/'.$productt->photo)}}" class="attachment-shop_single size-shop_single wp-post-image" alt="">
													</a>
												</div>
												@foreach($productt->galleries as $gal)
												<div data-thumb="{{asset('assets/images/galleries/'.$gal->photo)}}" class="woocommerce-product-gallery__image">
													<a href="#" tabindex="0">
													<img width="600" height="600" src="{{asset('assets/images/galleries/'.$gal->photo)}}" class="attachment-shop_single size-shop_single wp-post-image" alt="">
													</a>
												</div>
												@endforeach
											</figure>
										</div>
										<!-- .woocommerce-product-gallery -->
									</div>
									<!-- .techmarket-single-product-gallery-images -->
									<div class="techmarket-single-product-gallery-thumbnails" data-ride="tm-slick-carousel" data-wrap=".techmarket-single-product-gallery-thumbnails__wrapper" data-slick="{&quot;infinite&quot;:false,&quot;slidesToShow&quot;:4,&quot;slidesToScroll&quot;:1,&quot;dots&quot;:false,&quot;arrows&quot;:true,&quot;vertical&quot;:true,&quot;verticalSwiping&quot;:true,&quot;focusOnSelect&quot;:true,&quot;touchMove&quot;:true,&quot;prevArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-up\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;nextArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-down\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;asNavFor&quot;:&quot;#techmarket-single-product-gallery .woocommerce-product-gallery__wrapper&quot;,&quot;responsive&quot;:[{&quot;breakpoint&quot;:765,&quot;settings&quot;:{&quot;vertical&quot;:false,&quot;horizontal&quot;:true,&quot;verticalSwiping&quot;:false,&quot;slidesToShow&quot;:4}}]}">
										<figure class="techmarket-single-product-gallery-thumbnails__wrapper">

											<figure data-thumb="{{asset('assets/images/products/'.$productt->photo)}}" class="techmarket-wc-product-gallery__image">
												<img width="180" height="180" src="{{asset('assets/images/products/'.$productt->photo)}}" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="">
											</figure>
											@foreach($productt->galleries as $gal)
											<figure data-thumb="{{asset('assets/images/galleries/'.$gal->photo)}}" class="techmarket-wc-product-gallery__image">
												<img width="180" height="180" src="{{asset('assets/images/galleries/'.$gal->photo)}}" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="">
											</figure>
											@endforeach
										</figure>
										<!-- .techmarket-single-product-gallery-thumbnails__wrapper -->
									</div>
									<!-- .techmarket-single-product-gallery-thumbnails -->
								</div>
								<!-- .techmarket-single-product-gallery -->
							</div>
							<!-- .product-images-wrapper -->							
							<div class="summary entry-summary">
								<div class="single-product-header">
									<h1 class="product_title entry-title">
										{{ $productt->name }}
									</h1>
								</div>
								<!-- .single-product-header -->
								<div class="woocommerce-product-details__short-description">
									<div class="row">
										<div class="col-5">
											<ul>
												<li>Availability</li>
												<li>SKU</li>
												<li>Manufacturer</li>
												<!-- <li>Weight</li> -->
												<!-- <li>Condition</li> -->
												@if($productt->ship != null)
								                    <li>Est. Shipment time</li>
								                @endif
												<li>Payment</li>
											</ul>
										</div>
										<div class="col-7">
											<ul>
												<li class="stock in-stock">{{ $gs->show_stock == 0 ? '' : $productt->stock }} {{ $langg->lang79 }}</li>
												<li>{{ $productt->sku }}</li>
												<li>{{ $productt->brand->link ?? 'Unspecified' }}</li>
												<!-- <li>{!! $productt->weight."&nbsp;".$productt->measure !!}</li> -->
												<!-- <li>{{$productt->product_condition == 1
                                                    ? "Refurbished":"New"}}</li> -->
                                                @if($productt->ship != null)
								                    <li>{{ $productt->ship }}</li>
							                    @endif
												<li><img src="https://harddrivemart.com/media/wysiwyg/payment/payments.png" alt="" class="hover-img" width="120">
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="product-actions-wrapper mw-100 border-0 p-0">
									<div class="product-actions">
										<p class="price mb-3">
											<del>
											<span class="woocommerce-Price-amount amount">
												{{ $productt->showPreviousPrice() }}
											</span>
											</del>
											<ins>
											<span class="woocommerce-Price-amount amount" id="sizeprice">
												{{ $productt->showPrice() }}
											</span>
											</ins>
										</p>
										<!-- .single-product-header -->
										<form enctype="multipart/form-data" method="post" class="cart ext-cart-frm d-block">


											<div class="row">
										<div class="col-lg-12">
											@if(!empty($productt->color))
							                  <div class="product-color">
							                    <p class="title">{{ $langg->lang89 }} :</p>
							                    <ul class="color-list">
							                      @php
							                      $is_first = true;
							                      @endphp
							                      @foreach($productt->color as $key => $data1)
							                      <li class="{{ $is_first ? 'active' : '' }}">
							                        <span class="clr-box box" data-color="{{ $productt->color[$key] }}" style="background-color: {{ $productt->color[$key] }}"></span>
							                      </li>
							                      @php
							                      $is_first = false;
							                      @endphp
							                      @endforeach

							                    </ul>
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
										</div>
									</div>
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
										<div class="row mt-3">
										<div class="col-lg-12 d-flex">
											<div class="qty-bx"> 
												<label for="quantity-input">Quantity</label> 
												<!-- <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="quantity" id="quantity-input"> -->

												@if($productt->product_type != "affiliate")
							                      <li class="d-block count {{ $productt->type == 'Physical' ? '' : 'd-none' }}">
							                        <div class="qty gg-qty">
							                          <ul>
							                            <li>
							                              <span class="qtminus">
							                                <i class="fa fa-minus"></i>
							                              </span>
							                            </li>
							                            <li>
							                              <span class="qttotal">1</span>
							                            </li>
							                            <li>
							                              <span class="qtplus">
							                                <i class="fa fa-plus"></i>
							                              </span>
							                            </li>
							                          </ul>
							                        </div>
							                      </li>
							                    @endif

											</div>
											<!-- .quantity -->
											@if($productt->emptyStock())
											<button class="single_add_to_cart_button button alt cart-out-of-stock" value="185" name="add-to-cart" type="button">Add to cart</button>
											@else
											<button class="single_add_to_cart_button button alt" value="185" name="add-to-cart" type="button" id="addcrt">Add to cart</button>
											@endif
											@if(Auth::guard('web')->check())
											<span>
												<a href="javascript:;" class="add-to-wish"
                          data-href="{{ route('user-wishlist-add',$productt->id) }}" style="border: 1px solid;padding: 10px 15px;border-radius: 50%;"><i class="fa fa-heart-o"></i></a>
											</span>
											@endif
										</div>
										</div>
										</form>
										<!-- .cart -->
										<!-- <a class="add-to-compare-link" href="index.php?page=compare">Add to compare</a> -->
									</div>
									<!-- .product-actions -->
								</div>
								<!-- .product-actions-wrapper -->
								<!-- .woocommerce-product-details__short-description -->
							</div>
							<!-- .entry-summary -->	
							<div class="product-actions-wrapper">
								<div id="customScrollSection" class="product-actions">
									<div class="additional-info text-left">
										<div class="box1">
											<i class="fa fa-truck"></i>
										</div>
										<div>
											<strong>FREE GROUND SHIPPING</strong><br>Under 10 lbs.
										</div>
									</div>
									<div class="additional-info text-left">
										<div class="box1">
											<i class="fa fa-support"></i>
										</div>
										<div>
											<strong>ONLINE SUPPORT</strong><br>Mon-Fri / 8:00AM-5:00PM (EST)
										</div>
									</div>
									<div class="additional-info text-left">
										<div class="box1">
											<i class="fa fa-refresh"></i>
										</div>
										<div>
											<strong>SELLER WARRANTY</strong><br>30 Days
										</div>
									</div>
									<div class="additional-info text-left">
										<div class="box1">
											<i class="fa fa-credit-card"></i>
										</div>
										<div>
											<strong>PAYMENT METHOD</strong><br>Secure payment
										</div>
									</div>
									<!-- .additional-info -->	
								</div>
								<!-- .product-actions -->
							</div>
							<!-- .product-actions-wrapper -->	
						</div>
						<div class="row col-lg-9">
							<div class="col-lg-3">
								<div class="additional-info text-left">
									<div class="box1">
										<i class="fa fa-truck"></i>
									</div>
									<div>
										<strong>FREE GROUND SHIPPING</strong><br>Under 10 lbs.
									</div>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="additional-info text-left">
									<div class="box1">
										<i class="fa fa-support"></i>
									</div>
									<div>
										<strong>ONLINE SUPPORT</strong><br>Mon-Fri / 8:00AM-5:00PM (EST)
									</div>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="additional-info text-left">
									<div class="box1">
										<i class="fa fa-refresh"></i>
									</div>
									<div>
										<strong>SELLER WARRANTY</strong><br>30 Days
									</div>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="additional-info text-left">
									<div class="box1">
										<i class="fa fa-credit-card"></i>
									</div>
									<div>
										<strong>PAYMENT METHOD</strong><br>Secure payment
									</div>
								</div>
							</div>
						</div>
						<!-- .single-product-wrapper -->
						<div class="woocommerce-tabs wc-tabs-wrapper">
							<ul role="tablist" class="nav tabs wc-tabs">
								<li class="nav-item description_tab">
									<a class="nav-link active" data-toggle="tab" role="tab" aria-controls="tab-description" href="#tab-description">Product Overview</a>
								</li>
								<li class="nav-item accessories_tab">
									<a class="nav-link" data-toggle="tab" role="tab" aria-controls="tab-accessories" href="#tab-accessories">Warranty</a>
								</li>
								<li class="nav-item specification_tab">
									<a class="nav-link" data-toggle="tab" role="tab" aria-controls="tab-specification" href="#tab-specification">Technical Specs</a>
								</li>
								<li class="nav-item reviews_tab">
									<a class="nav-link" data-toggle="tab" role="tab" aria-controls="tab-reviews" href="#tab-reviews">Reviews</a>
								</li>
								<li class="nav-item reviews_tab">
									<a class="nav-link" data-toggle="tab" role="tab" aria-controls="tab-quote" href="#tab-quote">Request for Quote</a>
								</li>
							</ul>
							<!-- /.ec-tabs -->
							<div class="tab-content">
								<div class="tab-pane active panel wc-tab" id="tab-description" role="tabpanel">
									{!! $productt->details !!}
								</div>
								<div class="tab-pane" id="tab-accessories" role="tabpanel">
									<div class="tm-shop-attributes-detail like-column columns-3">
										<div class="row">
											<div class="col-md-12">
												{!! $gs->policy !!}
											</div>
										</div>
									</div>
									<!-- /.tm-shop-attributes-detail -->		
								</div>
								<div class="tab-pane" id="tab-specification" role="tabpanel">
									<div class="tm-shop-attributes-detail like-column columns-3">
										{!! $productt->specs !!}
									</div>
									<!-- /.tm-shop-attributes-detail -->		
								</div>
								<div class="tab-pane" id="tab-reviews" role="tabpanel">
									<div class="techmarket-advanced-reviews" id="reviews">
										<div class="advanced-review row">
											<div class="advanced-review-rating">
												<h2 class="based-title">Review ({{ count($productt->ratings) }})</h2>
												<div class="avg-rating">
													<span class="avg-rating-number">{{App\Models\Rating::rating($productt->id)}}</span>
													<div title="Rated {{App\Models\Rating::rating($productt->id)}} out of 5" class="star-rating">
														<span style="width:{{ App\Models\Rating::rating($productt->id)*20 }}%"></span>
													</div>
												</div>
												<!-- /.avg-rating -->
												<div class="rating-histogram">
													<div class="rating-bar">
														<div title="Rated 5 out of 5" class="star-rating">
															<span style="width:100%"></span>
														</div>
														<div class="rating-count">1</div>
														<div class="rating-percentage-bar">
															<span class="rating-percentage" style="width:100%"></span>
														</div>
													</div>
													<div class="rating-bar">
														<div title="Rated 4 out of 5" class="star-rating">
															<span style="width:80%"></span>
														</div>
														<div class="rating-count zero">0</div>
														<div class="rating-percentage-bar">
															<span class="rating-percentage" style="width:0%"></span>
														</div>
													</div>
													<div class="rating-bar">
														<div title="Rated 3 out of 5" class="star-rating">
															<span style="width:60%"></span>
														</div>
														<div class="rating-count zero">0</div>
														<div class="rating-percentage-bar">
															<span class="rating-percentage" style="width:0%"></span>
														</div>
													</div>
													<div class="rating-bar">
														<div title="Rated 2 out of 5" class="star-rating">
															<span style="width:40%"></span>
														</div>
														<div class="rating-count zero">0</div>
														<div class="rating-percentage-bar">
															<span class="rating-percentage" style="width:0%"></span>
														</div>
													</div>
													<div class="rating-bar">
														<div title="Rated 1 out of 5" class="star-rating">
															<span style="width:20%"></span>
														</div>
														<div class="rating-count zero">0</div>
														<div class="rating-percentage-bar">
															<span class="rating-percentage" style="width:0%"></span>
														</div>
													</div>
												</div>
												<!-- /.rating-histogram -->
											</div>
											<!-- /.advanced-review-rating -->
											<div class="advanced-review-comment">
												<div id="review_form_wrapper">
													<div id="review_form">
														<div class="comment-respond" id="respond">
															<h3 class="comment-reply-title" id="reply-title">Add a review</h3>
															<form novalidate="" class="comment-form" id="reviewform" method="post" action="{{route('front.review.submit')}}" data-href="{{ route('front.reviews',$productt->id) }}">
																@include('includes.admin.form-both')
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
																	<textarea aria-required="true" rows="8" cols="45" name="review" id="comment"></textarea>
																</p>
																<p class="comment-form-author">
																	<label for="author">Name <span class="required">*</span></label> 
																	<input type="text" aria-required="true" size="30" value="{{Auth::guard('web')->user()->name ?? ''}}" name="author" id="author" readonly="">
																</p>
																<p class="comment-form-email">
																	<label for="email">Email <span class="required">*</span></label> 
																	<input type="text" aria-required="true" size="30" value="{{Auth::guard('web')->user()->email ?? ''}}" name="email" id="email" readonly="">
																</p>
																<p class="form-submit">
																	<input type="submit" value="Add Review" class="submit submit-btn" id="submit" name="submit"> 
																</p>
															</form>
															<!-- /.comment-form -->
														</div>
														<!-- /.comment-respond -->
													</div>
													<!-- /#review_form -->
												</div>
												<!-- /#review_form_wrapper -->
											</div>
											<!-- /.advanced-review-comment -->
										</div>
										<!-- /.advanced-review -->
										@if(count($productt->ratings) > 0)
										<div id="comments">
											<ol class="commentlist">
												@foreach($productt->ratings as $review)
												<li id="li-comment-83" class="comment byuser comment-author-admin bypostauthor even thread-even depth-1">
													<!-- <div class="comment_container" id="comment-83">
														<div class="comment-text">
															<div class="star-rating">
																<span style="width:100%">Rated <strong class="rating">5</strong> out of 5</span>
															</div>
															<p class="meta">
																<strong itemprop="author" class="woocommerce-review__author">first last</strong> 
																<span class="woocommerce-review__dash">&ndash;</span> 
																<time datetime="2017-06-21T08:05:40+00:00" itemprop="datePublished" class="woocommerce-review__published-date">June 21, 2017</time>
															</p>
															<div class="description">
																<p>Wow great product</p>
															</div>
														</div>
													</div> -->
													<div class="single-review row">
					                                  <div class="left-area col-md-2 text-center">
					                                    <!-- <img
					                                      src="{{ $review->user->photo ? asset('assets/images/users/'.$review->user->photo):asset('assets/images/noimage.png') }}"
					                                      alt=""> -->
					                                    <h5 class="name mb-0">{{ $review->user->name }}</h5>
					                                    <p class="date">
					                                      {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$review->review_date)->diffForHumans() }}
					                                    </p>
					                                    <div class="star-rating m-auto">
															<span style="width:{{$review->rating*20}}%">Rated <strong class="rating">5</strong> out of 5</span>
														</div>
					                                  </div>
					                                  <div class="right-area col-md-10">
					                                    <div class="review-body">
					                                      <p>
					                                        {{$review->review}}
					                                      </p>
					                                    </div>
					                                  </div>
					                                </div>
												</li>
												<!-- /.comment -->
												@endforeach
											</ol>
											<!-- /.commentlist -->
										</div>
										<!-- /#comments -->
										@endif
									</div>
									<!-- /.techmarket-advanced-reviews -->		
								</div>
								<div class="tab-pane" id="tab-quote" role="tabpanel">
									<div class="techmarket-advanced-reviews" id="reviews">
										<div class="advanced-review row">
											<div class="advanced-review-comment">
												<div id="review_form_wrapper">
													<div id="review_form">
														<div class="comment-respond" id="respond">
															<h3 class="comment-reply-title" id="reply-title">Request for Quote:</h3>
															<form novalidate="" class="comment-form" id="quoteform" method="post" action="{{ route('request.quote') }}" >
																{{csrf_field()}}
																@include('includes.admin.form-both')
																<div class="comment-form-rating">
																	<label>Request a quote below or call (866) 705-5346 for further assistance with this part number</label>
																</div>
																<p class="comment-form-author">
																	<label for="author">Name <span class="required">*</span></label> 
																	<input type="text" aria-required="true" size="30" value="" name="name" id="author">
																</p>
																<p class="comment-form-author">
																	<label for="email">Email <span class="required">*</span></label> 
																	<input type="text" aria-required="true" size="30" value="" name="email" id="email">
																</p>
																<p class="comment-form-author">
																	<label for="author">Phone <span class="required">*</span></label> 
																	<input type="text" aria-required="true" size="30" value="" name="phone" id="">
																</p>
																<p class="comment-form-author">
																	<label for="email">Target Price <span class="required">*</span></label> 
																	<input type="text" aria-required="true" size="30" value="" name="target_price" id="">
																</p>
																<p class="comment-form-comment">
																	<label for="comment">Quantity</label>
																	<input type="text" aria-required="true" size="30" value="" name="quantity" id="">
																</p>
																<p class="form-submit">
																	<input type="submit" value="Get a Quote" class="submit" id="submit" name="submit"> 
																	<input type="hidden" id="" value="{{ $productt->id }}" name="product_id">
																</p>
															</form>
															<!-- /.comment-form -->
														</div>
														<!-- /.comment-respond -->
													</div>
													<!-- /#review_form -->
												</div>
												<!-- /#review_form_wrapper -->
											</div>
											<!-- /.advanced-review-comment -->
										</div>
										<!-- /.advanced-review -->
									</div>
									<!-- /.techmarket-advanced-reviews -->		
								</div>
							</div>
						</div>
						<div class="row tm-related-products-carousel section-products-carousel" id="tm-related-products-carousel" data-ride="tm-slick-carousel" data-wrap=".products" data-slick="{&quot;slidesToShow&quot;:5,&quot;slidesToScroll&quot;:7,&quot;dots&quot;:true,&quot;arrows&quot;:true,&quot;prevArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-left\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;nextArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-right\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;appendArrows&quot;:&quot;#tm-related-products-carousel .custom-slick-nav&quot;,&quot;responsive&quot;:[{&quot;breakpoint&quot;:767,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesToScroll&quot;:1}},{&quot;breakpoint&quot;:780,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesToScroll&quot;:4}},{&quot;breakpoint&quot;:1400,&quot;settings&quot;:{&quot;slidesToShow&quot;:5,&quot;slidesToScroll&quot;:5}}]}">
							<section class="col-lg-8 related">
								<header class="section-header">
									<h2 class="section-title">Related products</h2>
									<nav class="custom-slick-nav"></nav>
								</header>
								<!-- .section-header -->
								<div class="products">
									@foreach($productt->category->products()->where('status','=',1)->where('id','!=',$productt->id)->take(8)->get() as $prod)
									<div class="product">
										@if(Auth::guard('web')->check())
										<div class="yith-wcwl-add-to-wishlist">
											<a data-href="{{ route('user-wishlist-add',$prod->id) }}" rel="nofollow" class="add-to-wish add_to_wishlist"> Add to Wishlist</a>
										</div>
										@endif
										<a href="{{ route('front.product', $prod->slug) }}" class="woocommerce-LoopProduct-link">
											<img src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" width="224" height="197" class="wp-post-image" alt="">
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
									@endforeach
								</div>
							</section>
							<!-- .single-product-wrapper -->
						</div>
						<!-- .tm-related-products-carousel -->			
					</div>
					<!-- .product -->
				</main>
				<!-- #main -->
			</div>
			<!-- #primary -->
		</div>
		<!-- .row -->
	</div>
	<!-- .col-full -->
</div>
<!-- #content -->
@endsection
@section('styles')
<style type="text/css">
	.brand-sec-top, .footer-v1{
		position: relative;
		z-index: 101;
		background-color: #fff;
	}
	.brand-sec-top{
		background-color: #fff;
	}
	@media screen and (min-width: 992px) {
	  .wc-tabs{
			width: 80% !important;
		}
		.single-product-wrapper{
			max-height: 360px;
		}
	}
	.cust-scroll{
	  	position: fixed;
	    top: 135px;
	    z-index: 100;
	    width: 21%;
	    background: #fff;
	}
	.additional-info{
		font-size: 10px;
	}
	.additional-info strong{
		font-size: 14px;
	}
</style>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function () {
		quote_form();
		$(window).on( 'scroll', function(){
			quote_form();
		});
	});
	function quote_form() {
		var win_width = $(window).width();
		if(win_width >= 992){
			var scroll = $(window).scrollTop();
		    if(scroll > 200){
		    	$("#customScrollSection").addClass("cust-scroll");
		    }else{
		    	$("#customScrollSection").removeClass("cust-scroll");
		    }
		}
	}
</script>
@endsection