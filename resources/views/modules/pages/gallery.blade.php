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

	
		<script src="{{asset('js/pages/gallery.js')}}"></script>



@endpush


@push('content')


		<div class="container pt-4">


					@if (isset($edit))

					<div class="container pt-4 m-4">
						<div class="form-row pb-2">
							<form id="uploadform" action="/galleryUpload" method="POST">
								@csrf
								<input id="CompetitionId" name= "CompetitionId" value= "{{$competition}}"hidden>
								<label for="files">Alege imagini:</label>
								<input type="file" id="file" name="file[]" multiple accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*"><br><br>
								<button  type="submit">Incarca</button>
							</form>


						</div>
							<form id = "StergeSelectate" action="galleryDelete" method="POST">
								@csrf
							</form>
							<Button id="btnStergeSelectate">Sterge selectate</Button>
						
						<label class= "ms-4 me-2" for="">Selecteza toate</label><input id="checkall" type="checkbox" >
						
					</div>


					
						@foreach ($images as $image)

							@if (!in_array($image , ['.', '..']))
							<div class="form-row pb-2">
								<div class="col-md-12">
							
									<img src=" {{url('img/gallery/competitions/').'/'.$competition.'/'.$image}}" width="75%" class="mr-4">
									<input class= "checkpic ms-4 me-2" type="checkbox" data-image="{{$competition.'/'.$image}}">
								
								</div>
								
							</div>
							@endif

						@endforeach
						

					@else

						@if (getCompetitionRight($competition))
							<a href="{{url('/editgallery/').'/'.$competition}}" class = " btn btn-danger btn-outline ms-2 mb-2" >{{transex('Editeaza galerie')}}</a>
						@endif


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
					@endif
</div>
   

@endpush