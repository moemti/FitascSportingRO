@extends('layouts.baseex')

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/theme/demo-photography-3.css')}}">
@endpush

@push('footerscripts')
<script src="{{asset('js/pages/attach.js')}}"></script>
@endpush

@push('content')
<div class="container pt-4">
	@if (isset($edit))
	<div class="container pt-4 m-4">

		<div class="form-row pb-2">
			<form id="uploadform" action="/attachUpload" method="POST">
				@csrf
				<input id="CompetitionId" name="CompetitionId" value="{{$competition}}" hidden>
				<label for="files">Alege atasamente:</label>
				<input type="file" id="file" name="file[]" multiple accept="*"><br><br>
				<button type="submit">Incarca</button>
			</form>
		</div>

		<form id="StergeSelectate" action="attachDelete" method="POST">
			@csrf
		</form>
		<Button id="btnStergeSelectate">Sterge selectate</Button>

		<label class="ms-4 me-2" for="">Selecteza toate</label><input id="checkall" type="checkbox">

	</div>

	<div class="container pt-4 m-4">
		<h3>Atasamente</h3>
		<form id="ModificaNume" action="">
			
			@csrf
			@foreach ($attachments as $att)

			<div class="row pb-12">
				<div class="col-md-2">
					<a href=" {{url('/competitionattachment/'.$competition.'/'.$att->FileName)}}" target="_blank"
						width="75%" class="mr-4">{{$att->FileName}}</a>
				</div>
				<div class="col-md-4">
					<label>Denumire</label><input class="attachments ms-4 me-2" type="text"
						data-filename="{{$competition.'/'.$att->FileName}}" data-id="{{$att->CompetitionattachId}}"
						value="{{$att->Name}}">
				
					<input class="checkpic ms-4 me-2" type="checkbox"
						data-filename="{{$competition.'/'.$att->FileName}}" data-id="{{$att->CompetitionattachId}}">
				</div>
			</div>

			@endforeach
			<div class="row pb-12 ">
				<div class="col-md-6"></div>
				<div class="col-md-2">
			
				<button type="submit" class="btn-outline btn-pill btn-shadow btn-hover-shine btn btn-primary btn-md  ">{{transex('Salveaza')}}</button>
				</div>
			</div>
		</form>
	</div>

	@endif
</div>

@endpush