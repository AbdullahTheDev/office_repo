@extends('layouts.jbs')
@section('body-class', 'page home page-template-default')
@section('content')
<div id="content" class="site-content">
	<div class="col-full">
		<div class="row">

			{{-- <nav class="container">
				<a href="index.php">Home</a>
				<span class="delimiter"><i class="tm tm-breadcrumbs-arrow-right"></i></span>
				Frequently Asked Questions
			</nav> --}}
			<!-- .woocommerce-breadcrumb -->

			<div id="primary" class="container" style="padding: 20px 10px">
				<main id="main" class="site-main">
					<div class="type-page hentry">
						<header class="entry-header">
							<div class="page-header-caption">
								<h1 class="entry-title">Frequently Asked Questions</h1>
								<p class="entry-subtitle">Questions most frequently asked by Deals On Drives users</p>
							</div>
						</header><!-- .entry-header -->
						
						<div class="entry-content">

							<!-- <h2 class="kc_title faq-page-title">Shipping Information</h2> -->
							<div class="row faq-first-row">
								@foreach($faqs as $fq)
								<div class="col-md-6">
									<div class="text-block">
									<h3 class="faq-title">{{ $fq->title }}</h3>
										<div class="text-content">
											{!! $fq->details !!}
										</div>
									</div>							
								</div><!-- .col -->
								@endforeach
							</div><!-- .row -->
						</div><!-- .entry-content -->
					</div><!-- .hentry -->
				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .row -->
	</div><!-- .col-full -->
</div>
@endsection