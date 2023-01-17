<footer class="footer">
    {{-- <div class="footer-newsletter bg-main">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="icon-box icon-box-side text-white">
                        <div class="icon-box-icon d-inline-flex">
                            <i class="w-icon-envelop3"></i>
                        </div>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title text-white text-uppercase font-weight-bold">Subscribe To
                                Our Newsletter</h4>
                            <p class="text-white">Get all the latest information on Events, Sales and Offers.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-9 mt-4 mt-lg-0 ">
                    <form action="{{route('front.subscribe')}}" id="subscribeform" method="post"
                        class="input-wrapper input-wrapper-inline input-wrapper-rounded">
                        {{csrf_field()}}
                        <input type="email" class="form-control mr-2 bg-white" name="email" id="email"
                            placeholder="{{ $langg->lang741 }}" />
                        <button class="btn btn-main btn-rounded" type="submit" id="sub-btn">{{ $langg->lang742 }}<i
                                class="w-icon-long-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <div class="widget widget-about">
                        <a href="{{url('/')}}" class="logo-footer">
                            <img src="{{ asset('assets/images') }}/{{ $gs->logo }}" alt="logo-footer" width="144"
                                height="45" />
                        </a>
                        <div class="widget-body">
                            <p class="widget-about-title">Got Question? Call us</p>
                            <a href="tel:{{ $gs->phone }}" class="widget-about-call"><i class="fa fa-phone"></i> {{ $gs->phone }}</a>
                            <p class="widget-about-desc"><i class="fa fa-clock"></i> Working Hours: {{ $gs->working_hours }}</p>
                            <p class="widget-about-desc"><i class="fa fa-marker"></i><span style="font-size:15px;"><b> Email 1:</b><br /> </span>{{ $gs->email1 }} <br /> support@dealsondrives.com</p>
                            <p class="widget-about-desc"><i class="fa fa-marker"></i><span style="font-size:15px;"><b> Address 1:</b><br /> </span>{{ $gs->address }}</p>
                            <p class="widget-about-desc"><i class="fa fa-marker"></i><span style="font-size:15px;"> <b>Address 2:</b><br /> </span>2501 Chatham Rd Suite R, Springfield, IL 62704, United States</p>
                            

                            <div class="social-icons social-icons-colored">
                                <a href="https://www.linkedin.com/company/deals-on-drives/" aria-label="LinkedIn" target="_blank" style="background-color: #fff; border-radius: 50%">
                                    <img src="{{asset('assets/front/fonts/linkedin.svg')}}" alt="LinkedIn">
                                </a>
                                <!-- <a href="#" class="social-icon social-instagram w-icon-instagram"></a>
                                <a href="#" class="social-icon social-youtube w-icon-youtube"></a>
                                <a href="#" class="social-icon social-pinterest w-icon-pinterest"></a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="widget">
                        <h3 class="widget-title">Categories</h3>
                        <ul class="widget-body">
                            @if(!empty($footers))
                                @foreach($footers as $footer)
                                  <li><a href="{{ route('front.category',['slug1' => $footer->slug]) }}">{{$footer->name}}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">My Account</h4>
                        <ul class="widget-body">
                            <li><a href="{{ url('user/login') }}">Login & Register</a></li>
                            <li><a href="{{ url('user/login') }}">My account</a></li>
                            <li><a href="{{ url('carts') }}">Shopping cart</a></li>
                            <li><a href="{{ route('user-wishlists') }}">Wishlist</a></li>
                            
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">Costumer Services</h4>
                        <ul class="widget-body">
                            @foreach(DB::table('pages')->where('footer','=',1)->get() as $data)
                            <li><a href="{{ route('front.page',$data->slug) }}">{{ $data->title }}</a></li>
                            @endforeach
                            <li><a href="{{ url('contact') }}"> Contact Us </a></li>
                            <li><a href="{{ url('faq') }}"> FAQs</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="footer-middle">
            <div class="widget widget-category">
               
            </div>
        </div> -->
        <div class="footer-bottom">
            <div class="footer-left">
                <p class="copyright">{!! $gs->copyright !!}</p>
            </div>
            <div class="footer-right">
                <span class="payment-label mr-lg-8">We're using safe payment for</span>
                <figure class="payment">
                    <img src="{{ asset('assets/dod') }}/images/payments.png" alt="payment"  />
                </figure>
            </div>
        </div>
    </div>
</footer>
 <!-- Start of Sticky Footer -->
