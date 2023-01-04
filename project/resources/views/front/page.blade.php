@extends('layouts.jbs')
@section('body-class', 'page home page-template-default')
@section('content')



 <!-- Start of Page Header -->
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">{{ $page->title }}</h1>
                </div>
            </div>
            <!-- End of Page Header -->

            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav mb-10 pb-8">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href="{{url('')}}">Home</a></li>
                        <li>{{ $page->title }}</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->
            
            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">
                    <section class="introduce mb-10 pb-10">
                      {!! $page->details !!}
                    </section>

                    
                </div>

              
            </div>
@endsection