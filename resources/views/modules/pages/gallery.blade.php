@extends('layouts.baseex')

@push('css')




        <link rel="stylesheet" type="text/css" href="{{asset('css/theme/demo-photography-3.css')}}">


@endpush


@push('footerscripts')








		<script src="{{asset('js/theme/vendor/jquery-mousewheel/jquery.mousewheel.min.js')}}"></script>


		<!-- Revolution Slider Scripts -->
		<script src="{{asset('js/theme/vendor/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>

	

		<!-- Demo -->
		<script src="{{asset('js/theme/demo-photography.js')}}"></script>

	





@endpush


@push('content')


<div class="container pt-4">

					<div id="portfolioSliderWithThumbs">
						<div class="thumb-gallery">
							<div class="owl-carousel owl-theme manual thumb-gallery-detail" id="thumbGalleryDetail">
                            @foreach ($images as $image)

                                @if (!in_array($image , ['.', '..']))

                                <div style="background: url( {{url('img/gallery/competitions/').'/'.$competition.'/'.$image}})"></div> 

                                @endif

                            @endforeach
							
							</div>
							<div class="owl-carousel owl-theme manual thumb-gallery-thumbs" id="thumbGalleryThumbs">
                        
                            @foreach ($images as $image)

                                @if (!in_array($image , ['.', '..']))

                                <div style="background: url( {{url('img/gallery/competitions/').'/'.$competition.'/'.$image}})"></div> 

                                @endif

                            @endforeach
							</div>
						</div>
					</div>

				</div>
   

@endpush