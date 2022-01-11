@extends('layouts.base')

@push('scripts')



<script defer type="module" src="{{asset('js/pages/poligoane.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('css/pages/poligoane.css')}}"/>
@endpush

<script>

        let dsPoligoane = @Json($poligoane);
           

</script>

@push('content')

    <div class="page_content page_content_master page_content_poligoane">
        <h1>Poligoane</h1>

        <smart-grid id="gridpoligoane" class="smart__poligoane"></smart-grid>
    </div>
    
       

@endpush