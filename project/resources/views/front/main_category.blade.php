@extends('layouts.jbs')
@section('body-class', 'woocommerce-active left-sidebar')
@section('meta_tags')
<link rel="canonical" href="{{ url()->current() }}" />
@endsection
@section('content')
<nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb bb-no">
                        <li><a href="demo1.html">Category</a></li>
                        <li>{{ $category->name }}</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb-nav -->

            <div class="page-content mb-10">
                <div class="container">
                    <!-- Start of Shop Content -->
                    <div class="shop-content row gutter-lg">
                        <!-- Start of Sidebar, Shop Sidebar -->
                        <aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed">
                            <!-- Start of Sidebar Overlay -->
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>

                            <!-- Start of Sidebar Content -->
                            <div class="sidebar-content scrollable">
                                <!-- Start of Sticky Sidebar -->
                                <div class="sticky-sidebar">
                                    <!-- Start of Collapsible widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><span>All Categories</span></h3>
                                        <ul class="widget-body filter-items search-ul">
                                        	@foreach($categories as $cat)
											@if($category->id != $cat->id)
											<li class="cat-item"><a href="{{ route('front.category',$cat->slug) }}">{{$cat->name}}</a></li>
											@endif
											@endforeach
                                            
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                </div>
                                <!-- End of Sidebar Content -->
                            </div>
                            <!-- End of Sidebar Content -->
                        </aside>
                        <!-- End of Shop Sidebar -->
                        <!-- Start of Main Content -->
                        <div class="main-content">
                            
                            @if(!empty($subs))
                            <div class="product-wrapper row cols-md-3 cols-sm-2 cols-2">
                            	@foreach($subs as $sub)
                                <div class="product-wrap">
                                    <div class="product text-center">
                                        <figure class="product-media">
                                            <a href="{{ route('front.subcat' , ['slug1' => $category->slug, 'slug2' => $sub->slug]) }}">
                                                <img src="{{ $sub->image != '' ? asset('assets/images/categories/'.$sub->image) : asset('assets/images/noimage.png') }}" alt="{{ $sub->name }}" width="300"
                                                    height="338" />
                                            </a>
                                        </figure>
                                        <div class="product-details">
                                            <div class="product-cat">
                                                <a href="">{{ $category->name }}</a>
                                            </div>
                                            <h3 class="product-name">
                                                <a href="{{ route('front.subcat' , ['slug1' => $category->slug, 'slug2' => $sub->slug]) }}">{{ $sub->name }}<sup class="count">({{$sub->count()}})</sup></a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            
                        </div>
                        <!-- End of Main Content -->
                    </div>
                    <!-- End of Shop Content -->
                </div>
            </div>

@endsection