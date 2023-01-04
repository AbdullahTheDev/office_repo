@extends('layouts.jbs')
@section('content')
<nav class="breadcrumb-nav">
    <div class="container">
        <ul class="breadcrumb bb-no">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="javascript:;">404</a></li>
        </ul>
    </div>
</nav>
<div class="page-content mb-10">
  <div class="container">
    <div class="type-page hentry error404" style="text-align:left">
     <img class="m-auto" width="100" src="{{ $gs->error_banner ? asset('assets/images/'.$gs->error_banner):asset('assets/images/noimage.png') }}" alt="">
     <p class="lead error-text text-center">Oops! That page can’t be found.</p>
     <div class="row">
        <div class="col-md-12">
           <p class="text-center">Can't find your desired part? No worries call us at <a href="tel:{{ $gs->phone }}">{{ $gs->phone }}</a> or email: <a href="mailto:{{ $gs->email1 }}">{{ $gs->email1 }}</a></p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
        <section class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
           <div class="sales-inquiry">
                <div class="container-fluid">
                <h2 class="inquiry-title">Sales Inquiry</h2>
                <p>Our Dedicated Account Manager will get in touch with you shortly</p>
                <div class="alert alert-success validation" style="display: none; width:100%;">
                    <button type="button" class="close alert-close"><span>×</span></button>
                    <p class="text-left"></p> 
                </div>
                <div class="alert alert-danger validation" style="display: none;width:100%;">
                    <button type="button" class="close alert-close"><span>×</span></button>
                    <ul class="text-left">
                    </ul>
                </div>
                <form method="post" action="{{ route('request.sale_inquiry') }}" id="quoteform">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="phone" required/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="company_name" required/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
                            <label>Part Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="part_number" required/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-1">
                            <label>Target Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="target_price" required/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-1">
                            <label>Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="qty" required/>
                        </div>
                    </div>
                    <p class="form-submit mt-2">
                        <input type="submit" class="btn btn-dark btn-outline btn-rounded btn-sm" value="Submit" class="submit" id="submit" name="submit"> 
                    </p>
                </form>
                </div>
            </div>
        </section>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
     </div>
  </div>
  </div>
</div>
@endsection