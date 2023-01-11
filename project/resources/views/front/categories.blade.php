@extends('layouts.jbs')
@section('body-class', 'page home page-template-default all-categories-page')
@section('content')
<div id="content" class="site-content" style="background-color: #f5f6f8;">
    <div class="col-full">
        <div class="row">

            {{-- <nav class="woocommerce-breadcrumb">
                <a href="index.php">Home</a>
                <span class="delimiter"><i class="tm tm-breadcrumbs-arrow-right"></i></span>
                Categories
            </nav> --}}
            <!-- .woocommerce-breadcrumb -->

            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="type-page hentry">
                        <div class="entry-content">
                            <div class="row faq-first-row">
                                <div class="container" style="padding: 20px 0px">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="bg-white" style="padding: 25px 30px">
                                                @foreach($categories as $category)
                                                    <div class="sub-category-menu">
                                                        <h2 class="kc_title faq-page-title" style="color: #c12228;"><a style="color: #c12228;" href="{{ route('front.category',$category->slug) }}">{{ $category->name }}</a></h2>
                                                        @if(count($category->subs) > 0)
                                                            <ul class="parent-category row">
                                                            @foreach($category->subs as $subcat)
                                                                <li class="col-4">
                                                                    <a class="p-c-title" href="{{ route('front.subcat',['slug1' => $subcat->category->slug, 'slug2' => $subcat->slug]) }}">{{$subcat->name}}</a>

                                                                @if(count($subcat->childs) > 0)
                                                                    <ul>
                                                                    @foreach($subcat->childs as $childcat)
                                                                        <li>
                                                                            <a href="{{ route('front.childcat',['slug1' => $childcat->subcategory->category->slug, 'slug2' => $childcat->subcategory->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a>
                                                                        </li>
                                                                    @endforeach
                                                                    </ul>
                                                                @endif

                                                                </li>
                                                            @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .row -->
                        </div><!-- .entry-content -->
                    </div><!-- .hentry -->
                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- .row -->
    </div><!-- .col-full -->
</div>

@endsection
