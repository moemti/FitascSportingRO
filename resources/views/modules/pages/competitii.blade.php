@extends('layouts.base')

@push('scripts')



<script defer type="module" src="{{asset('js/pages/competitii.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('css/pages/competitii.css')}}"/>
@endpush

<script>

        let dsCompetitii= @Json($masterlist);
           

</script>

@push('content')

    <div class="page_content page_content_master page_content_competitii">
        <h1>Competitii</h1>

        <h2>Competitii din Romania 2022 - 2021</h2>

        <smart-grid id="gridcompetitii" class="smart__competitii"></smart-grid>

    </div>

  


@endpush