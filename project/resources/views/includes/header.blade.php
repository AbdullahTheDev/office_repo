 <header class="header header-border">
    <div class="header-top d-none d-md-flex">
        <div class="container">
            <div class="header-right">
                <p class="welcome-msg">{!! $gs->headr !!}</p>
            </div>
            <div class="header-right">
                <a class="live-chat" href="javascript:void(Tawk_API.toggle())"><i class="fa fa-comment"></i> Live Chat</a>
                <span class="divider d-lg-show"></span>
                @if($gs->is_currency == 1)
                <a href="javascript:;">{{ Session::has('currency') ?   DB::table('currencies')->where('id','=',Session::get('currency'))->first()->sign   : DB::table('currencies')->where('is_default','=',1)->first()->sign }}</a>
                <select name="currency" class="currency selectors nice">
                @foreach(DB::table('currencies')->get() as $currency)
                    <option value="{{route('front.currency',$currency->id)}}" {{ Session::has('currency') ? ( Session::get('currency') == $currency->id ? 'selected' : '' ) : (DB::table('currencies')->where('is_default','=',1)->first()->id == $currency->id ? 'selected' : '') }} >{{$currency->name}}</option>
                @endforeach
                </select>
                @endif
                <!-- End of DropDown Menu -->
                <span class="divider d-lg-show"></span>
                @if(Auth::guard('web')->check())
                <a href="{{ url('user/login') }}" class="d-lg-show">My Account</a>
                @else
                <a href="{{ url('user/login') }}" class="d-lg-show login sign-in">Sign In</a>
                <span class="delimiter d-lg-show">/</span>
                <a href="{{ url('user/login') }}" class="ml-0 d-lg-show login register">Register</a>
                @endif
            </div>
        </div>
    </div>
    <!-- End of Header Top -->

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <a href="#" class="mobile-menu-toggle  w-icon-hamburger">
                </a>
                <a href="{{url('')}}" class="logo ml-lg-0">
                    <img src="{{ asset('assets/images') }}/{{$gs->logo}}" alt="logo" width="190" height="45" />
                </a>
                <form style="" method="get" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" class="header-search hs-expanded hs-round d-none d-md-flex input-wrapper search-form navbar-search" id="searchForm">
                    @if (!empty(request()->input('sort')))
                        <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
                    @endif
                    @if (!empty(request()->input('minprice')))
                        <input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
                    @endif
                    @if (!empty(request()->input('maxprice')))
                        <input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
                    @endif
                    <input type="hidden" id="search-param" name="post_type" value="product"/>
                    <input type="text" class="form-control" name="search" id="prod_name"
                        placeholder="Search for products" autocomplete="off" required  value="{{ request()->input('search') }}" />
                    <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                    </button>
                    <div class="autocomplete">
                        <div id="myInputautocomplete-list" class="autocomplete-items">
                        </div>
                    </div>
                </form>
            </div>
            <div class="header-right ml-4">
                <div class="header-call d-xs-show d-lg-flex align-items-center">
                    <a href="tel:#" class="w-icon-call"></a>
                    <div class="call-info d-lg-show">
                        <h4 class="chat font-weight-normal font-size-md text-normal ls-normal text-light mb-0">
                            <a href="javascript:void(Tawk_API.toggle())" class="text-capitalize">Live Chat</a> or :</h4>
                        <a href="tel:{{ $gs->phone }}" class="phone-number font-weight-bolder ls-50">{{ $gs->phone }}</a>
                    </div>
                </div>
                <a class="wishlist label-down link d-xs-show" href="{{ route('user-wishlists') }}">
                    <i class="w-icon-heart"></i>
                    <span class="wishlist-label d-lg-show">Wishlist</span>
                </a>
                <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
                    <div class="cart-overlay"></div>
                    @include('load.cart')
                    <!-- End of Dropdown Box -->
                </div>
            </div>
        </div>
    </div>
    <!-- End of Header Middle -->

    <div class="header-bottom sticky-content fix-top sticky-header">
        <div class="container">
            <div class="inner-wrap">
                <div class="header-left">
                    <div class="dropdown category-dropdown has-border" data-visible="true">
                        <a href="#" class="category-toggle " role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true" data-display="static"
                            title="Browse Categories">
                            <i class="w-icon-category"></i>
                            <span>Browse Categories</span>
                        </a>

                        <div class="dropdown-box">
                            <ul class="menu vertical-menu category-menu">
                                @php
                                $i=1;
                                @endphp
                                
                                @foreach($categories as $category)
                                    @if(count($category->subs) > 0)
                                        <?php
                                            if($category->id == 30){
                                                $colls = 3;
                                            }else{
                                                $colls = 6;
                                            }
                                        ?>
                                        <li class="{{ $category->id == 30 ? 'yamm-fw' : 'yamm-tfw' }}">
                                            <a href="{{ route('front.main_category', ['category' => $category->slug]) }}">
                                                {{ $category->name }}
                                            </a>
                                            <ul class="megamenu">
                                                @foreach($category->subs as $subcat)
                                                <li class="col-md-{{$colls}} col-sm-12">
                                                    <h4 class="menu-title"><a href="{{ route('front.subcat' , ['slug1' => $category->slug, 'slug2' => $subcat->slug]) }}">{{$subcat->name}}</a></h4>
                                                    <hr class="divider">
                                                    <ul>
                                                        @if(count($subcat->childs) > 0)
                                                            
                                                            @foreach($subcat->childs as $childcat)
                                                            <li><a href="{{ route('front.childcat',['slug1' => $childcat->subcategory->category->slug, 'slug2' => $childcat->subcategory->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a>
                                                            </li>
                                                            

                                                            @endforeach
                                                        @endif
                                                        <li><a href="{{ route('front.subcat',['slug1' => $subcat->category->slug, 'slug2' => $subcat->slug]) }}">All in {{$subcat->name}}</a></li>
                                                    </ul>
                                                </li>
                                                @endforeach
                                                <li>
                                                    <div class="banner-fixed menu-banner menu-banner2">
                                                        <figure>
                                                            <img src="{{ asset('assets/jbs/images/megamenu.jpg') }}" alt="Menu Banner"
                                                                width="235" height="347" />
                                                        </figure>
                                                        <div class="banner-content">
                                                            <!-- <div class="banner-price-info mb-1 ls-normal">Get up to
                                                                <strong
                                                                    class="text-primary text-uppercase">20%Off</strong>
                                                            </div>
                                                            <h3 class="banner-title ls-normal">Hot Sales</h3> -->
                                                            <a href="{{ route('front.category',$category->slug) }}"
                                                                class="btn btn-dark btn-sm btn-link btn-slide-right btn-icon-right">
                                                                All in {{$category->name}}<i class="w-icon-long-arrow-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ route('front.category',$category->slug) }}">
                                                {{ $category->name }}
                                            </a>
                                        </li>

                                    @endif
                                        @php
                                        $i++;
                                        @endphp 
                                        @if($i == 10)
                                            <li>
                                                <a href="{{ route('front.categories') }}">
                                                   See All Categories
                                                </a>
                                            </li>
                                            @break
                                        @endif 
                                @endforeach  
                            </ul>
                        </div>
                    </div>
                    <nav class="main-nav">
                        <ul class="menu active-underline">
                            @if(!empty($header_menu))
                            @foreach($header_menu as $item)
                            <li class="">
                                <a href="{{ route('front.category',['category' => $item->slug]) }}">{{ $item->name }}</a>
                            </li>
                            @endforeach
                            @endif
                            <li class="">
                                <a href="{{ url('managed-services') }}">Managed Services</a>
                            </li>
                        </ul>
                    </nav>
                </div>
               <!--  <div class="header-right">
                    <a href="#" class="d-xl-show"><i class="w-icon-map-marker mr-1"></i>Track Order</a>
                    <a href="#"><i class="w-icon-sale"></i>Daily Deals</a>
                </div> -->
            </div>
        </div>
    </div>
</header>