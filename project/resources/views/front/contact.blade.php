@extends('layouts.jbs')
@section('body-class', 'page home page-template-default')
@section('content')

<!-- Start of Page Header -->
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">Contact Us</h1>
                </div>
            </div>
            <!-- End of Page Header -->

            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav mb-10 pb-1">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href="demo1.html">Home</a></li>
                        <li>Contact Us</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of PageContent -->
            <div class="page-content contact-us">
                <div class="container">
                    <section class="content-title-section mb-10">
	   					<h2 class="contact-page-title">Leave us a Message</h2>
						<p>Send us a message and we' ll respond as soon as possible</p>
                    </section>
                    <!-- End of Contact Title Section -->

                    <section class="contact-information-section mb-10">
                        <div class="row owl-carousel owl-theme cols-xl-4 cols-md-3 cols-sm-2 cols-1" data-owl-options="{
                        'items': 4,
                        'nav': false,
                        'dots': false,
                        'loop': false,
                        'margin': 20,
                        'responsive': {
                            '0': {
                                'items': 1
                            },
                            '480': {
                                'items': 2
                            },
                            '768': {
                                'items': 3
                            },
                            '992': {
                                'items': 4
                            }
                        }
                    }">
                            <div class="icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-email">
                                    <i class="w-icon-envelop-closed"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">E-mail Address</h4>
                                    <p><b>Sales :</b> {{ $gs->email1 }}<br>
											<b>Support :</b> {{ $gs->email2 }}</p>
                                </div>
                            </div>
                            <div class="icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-headphone">
                                    <i class="w-icon-headphone"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">Hourse of Operations</h4>
                                    <p>{{ $gs->working_hours }}</p>
                                </div>
                            </div>
                            <div class="icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-map-marker">
                                    <i class="w-icon-map-marker"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">Address</h4>
                                    <p>{!! $ps->street !!}</p>
                                </div>
                            </div>
                             <div class="icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-fax">
                                    <i class="w-icon-fax"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">Fax</h4>
                                    <p>{{$gs->phone}}</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- End of Contact Information section -->

                    <hr class="divider mb-10 pb-1">

                    <section class="contact-section">
                        <div class="row gutter-lg pb-3">
                            
                            <div class="col-lg-12 mb-8">
                                <h4 class="title mb-3">Send Us a Message</h4>
                                <form class="form contact-us-form" id="contactform" action="{{route('front.contact.submit')}}" method="post">
                                	@csrf
                                    @include('includes.admin.form-both')
                                    <div class="form-group">
                                        <label for="username">Full Name</label>
                                        <input type="text" id="username" name="name"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="email_1">Your Email</label>
                                        <input type="email" id="email_1" name="email"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Phone</label>
                                        <input type="text"  name="phone"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Your Message</label>
                                        <textarea id="message" name="text" cols="30" rows="5"
                                            class="form-control"></textarea>
                                    </div>
                                    <input type="hidden" name="to" value="{{ $ps->contact_email }}">
                                    <button type="submit" class="btn btn-dark btn-rounded">Send Now</button>
                                </form>
                            </div>
                        </div>
                    </section>
                    <!-- End of Contact Section -->
                </div>

                
                <!-- End Map Section -->
            </div>
            <!-- End of PageContent -->
@endsection