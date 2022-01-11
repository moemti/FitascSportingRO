@extends('layouts.base')

@push('scripts')

<script defer type="module" src="{{asset('js/pages/clasamente.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/clasamente.css')}}"/>

@endpush

<script>

        let dsClasament2021= @Json($clasament2021);
           

</script>

@push('content')

    <div class="page_content page_content_master page_content_participanti">
        <h1>Clasamente</h1>

        <h2>Clasament 2021</h2>

        <smart-grid id="gridclasament2021" class="smart__participanti"></smart-grid>
    </div>
    


@endpush