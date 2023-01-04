@extends('layouts.front')

@section('styles')

@endsection
@section('content')

	@if($category->img1 != "")
        <section class="banner-section p-0">
			<div class="container ptb-30 bg-white">
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="left">
							<a class="banner-effect" href="{{ $category->link1 }}" target="_blank">
								<img src="{{ asset('assets/images/sections/'.$category->img1) }}" alt="">
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
    @endif

	@if($category->img2 != "")
        <section class="banner-section p-0">
			<div class="container ptb-30 bg-white">
				<div class="row">
					<div class="col-lg-6 remove-padding">
						<div class="left">
							<a class="banner-effect" href="{{ $category->link2 }}" target="_blank">
								<img src="{{ asset('assets/images/sections/'.$category->img2) }}" alt="">
							</a>
						</div>
					</div>
					<div class="col-lg-6 remove-padding">
						<div class="left">
							<a class="banner-effect" href="{{ $category->link3 }}" target="_blank">
								<img src="{{ asset('assets/images/sections/'.$category->img3) }}" alt="">
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
    @endif

	@if($category->img4 != "")
        <section class="banner-section p-0">
			<div class="container ptb-30 bg-white">
				<div class="row">
					<div class="col-lg-3 remove-padding">
						<div class="left">
							<a class="banner-effect" href="{{ $category->link4 }}" target="_blank">
								<img src="{{ asset('assets/images/sections/'.$category->img4) }}" alt="">
							</a>
						</div>
					</div>
					<div class="col-lg-3 remove-padding">
						<div class="left">
							<a class="banner-effect" href="{{ $category->link5 }}" target="_blank">
								<img src="{{ asset('assets/images/sections/'.$category->img5) }}" alt="">
							</a>
						</div>
					</div>
					<div class="col-lg-3 remove-padding">
						<div class="left">
							<a class="banner-effect" href="{{ $category->link6 }}" target="_blank">
								<img src="{{ asset('assets/images/sections/'.$category->img6) }}" alt="">
							</a>
						</div>
					</div>
					<div class="col-lg-3 remove-padding">
						<div class="left">
							<a class="banner-effect" href="{{ $category->link7 }}" target="_blank">
								<img src="{{ asset('assets/images/sections/'.$category->img7) }}" alt="">
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
    @endif

@endsection

@section('scripts')
	<script type="text/javascript">
		function load_func() {
		    $('.pre-bg').delay(350).fadeOut('slow');
		}
		var pageLoaded = false;
		var timeoutElapsed = false;

		$(window).on('load', function() {
		    pageLoaded = true;
		    if (timeoutElapsed) {
		        load_func();
		    }
		});

		setTimeout(function() {
		    timeoutElapsed = true;
		    if (pageLoaded) {
		        load_func();
		    }
		}, 2000);
	</script>
@endsection