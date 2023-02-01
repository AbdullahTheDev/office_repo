@extends('layouts.jbs')
@section('body-class', 'woocommerce-active left-sidebar')
@section('meta_tags')
<link rel="canonical" href="{{ url()->current() }}" />
@endsection
@section('content')
<nav class="breadcrumb-nav">
    <div class="container">
        <ul class="breadcrumb bb-no">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="javascript:;">Shop</a></li>
        </ul>
    </div>
</nav>
            <!-- End of Breadcrumb-nav -->
<form id="cat-prods-form" action="" method="GET">
    <input type="hidden" value="{{ request()->layout ?? 'grid' }}" name="layout" id="pge_layout">
    <input type="hidden" value="{{ request()->min ?? 0 }}" name="min" id="amt_min">
    <input type="hidden" value="{{ request()->max ?? 10000 }}" name="max" id="amt_max">
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
                                    <div class="widget filter-data">
                                        <h3 class="widget-title"><span>All Categories</span></h3>
                                        <ul>
                                          @foreach ($categories as $element)
                                            <li><i class="fa fa-chevron-right"></i> <a href="{{route('front.category', $element->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">{{$element->name}}</a>
                                             <ul>
                                                       @if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs))
                                                          @foreach ($cat->subs as $key => $subelement)
                                                        <li>
                                                            <i class="fa fa-chevron-right"></i>  <a href="{{route('front.category', [$cat->slug, $subelement->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">{{$subelement->name}}</a>
                                                            <ul>
                                                                @if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs))
                                                                    @foreach ($subcat->childs as $key => $childcat)
                                                                    <li><i class="fa fa-chevron-right"></i>  <a href="{{route('front.category', [$cat->slug, $subcat->slug, $childcat->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">{{$childcat->name}}</a>
                                                                    </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </li>
                                                          @endforeach
                                                        @endif
                                                    </ul>  
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><span>Price</span></h3>
                                        <div class="widget-body price-range">
                                           <input type="number" id="min-price" value="{{ request('min') }}" name="min" class="min_price min-price" placeholder="500">
                                           <span class="delimiter">-</span>
                                           <input type="number" id="max-price" value="{{ request('max') }}" name="max" class="max_price" placeholder="10000">
                                           {{-- <button type="submit">OK</button> --}}
                                        </div>
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                   

                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><span>Brand</span></h3>
                                        <ul class="widget-body filter-items item-check mt-1" style="height:500px;overflow-y: scroll;padding-top: 10px;">
                                            @foreach (\App\Models\Partner::get() as $element)
                                            <li>
                                                <label class="">
                                                    <input type="radio" id="brand_filter" name="brand" value="{{ $element->id }}" {{ request()->get('brand') == $element->id ? 'checked' : '' }}/>
                                                    {{$element->link}}
                                                </label>
                                            </li>
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
                           
                            <nav class="toolbox sticky-toolbox sticky-content fix-top">
                                <div class="toolbox-left">
                                    <a href="#" class="btn btn-primary btn-outline btn-rounded left-sidebar-toggle 
                                        btn-icon-left d-block d-lg-none"><i
                                            class="w-icon-category"></i><span>Filters</span></a>
                                    <div class="toolbox-item toolbox-sort select-box text-dark">
                                        <label>Sort By :</label>
                                        <select  class="form-control" name="sort" onchange="this.form.submit()">
                                          <option value="date_desc" {{ request()->sort == "date_desc" ? 'selected' : '' }}>Sort by newness</option>
                                          <option value="date_asc" {{ request()->sort == "date_asc" ? 'selected' : '' }}>Sort by oldest</option>
                                          <option value="price_asc" {{ request()->sort == "price_asc" ? 'selected' : '' }}>Sort by price: low to high</option>
                                          <option value="price_desc" {{ request()->sort == "price_desc" ? 'selected' : '' }}>Sort by price: high to low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="toolbox-right">
                                    <div class="toolbox-item toolbox-show select-box">
                                        <select  class="form-control disp-prod1 c-select" onchange="this.form.submit()" name="display_prods" >
                                             <option value="50" {{ request()->display_prods == "50" ? 'selected' : '' }}>Show 50</option>
                                              <option value="100" {{ request()->display_prods == "100" ? 'selected' : '' }}>Show 100</option>
                                              <option value="-1" {{ request()->display_prods == "-1" ? 'selected' : '' }}>Show All</option>
                                        </select>
                                    </div>
                                    <!-- <div class="toolbox-item toolbox-layout">
                                        <a href="shop-boxed-banner.html" class="icon-mode-grid btn-layout {{ request()->layout == '' || request()->layout == 'grid' ? 'active' : '' }}">
                                            <i class="w-icon-grid"></i>
                                        </a>
                                        <a href="shop-list.html" class="icon-mode-list btn-layout {{ request()->layout == 'list' ? 'active' : '' }}">
                                            <i class="w-icon-list"></i>
                                        </a>
                                    </div> -->
                                </div>
                            </nav>
                            <div class="product-wrapper row cols-md-4 cols-sm-2 cols-2">
                              @forelse($prods as $prod)
                                <div class="product product-slideup-content">
                                    <figure class="product-media">
                                         <a href="{{ route('front.product', $prod->slug) }}">
                                             <img src="{{ $prod->photo  }}" alt="{{ $prod->showName() }}" width="295" height="335">
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
                                            <a data-href="{{ route('product.cart.add',$prod->id) }}" class="button btn-product btn btn-dark btn-outline btn-rounded btn-sm btn-cart" title="Add to Cart">
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
                                @empty
                                <p class="col">No products found in your selected filters!</p>
                              @endforelse
                            </div>
                            <div class="toolbox toolbox-pagination justify-content-between">
                                <div class="toolbox-item toolbox-show select-box">
                                        <select class="form-control disp-prod2">
                                             <option value="50" {{ request()->display_prods == "50" ? 'selected' : '' }}>Show 50</option>
                                              <option value="100" {{ request()->display_prods == "100" ? 'selected' : '' }}>Show 100</option>
                                              <option value="-1" {{ request()->display_prods == "-1" ? 'selected' : '' }}>Show All</option>
                                        </select>
                                    </div>
                                <p class="showing-info mb-2 mb-sm-0">
                                    Showing <span>{{ $prods->currentPage() != 1 ? (($prods->currentPage() - 1) * $prods->perPage())+1 : 1 }}&ndash;{{ $prods->currentPage() != $prods->lastPage() ? $prods->count() * $prods->currentPage() : $prods->total() }}
                                     of {{ $prods->total() }}</span> Products
                                </p>
                                <ul class="pagination">
                                    {!! $prods->appends(['search' => request()->input('search'), 'display_prods' => request()->input('display_prods'), 'layout' => request()->input('layout'), 'min' => request()->input('min'), 'max' => request()->input('max'), 'sort' => request()->input('sort')])->links() !!}

                                </ul>
                            </div>
                           
                        </div>
                        <!-- End of Main Content -->
                    </div>
                    <!-- End of Shop Content -->
                </div>
            </div>
</form>
<!-- #content -->
@endsection
@section('scripts')
<script type="text/javascript">
  $(".disp-prod2").change(function () {
     $(".disp-prod1").val($(this).val());
     $("#cat-prods-form")[0].submit();
  });

  $('#min-price').on("change", function () {
    min_price = parseInt($('#min-price').val());//Get the value
    $('#min-price-txt').text('$' + min_price);//Set the value
    $("#cat-prods-form")[0].submit();//Apply the filter
});

$('#max-price').on("change", function () {
    $("#cat-prods-form")[0].submit();//Apply the filter
});
$('#brand_filter').on("change", function () {
    alert("HH");
    $("#cat-prods-form")[0].submit();//Apply the filter
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