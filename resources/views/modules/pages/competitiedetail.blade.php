@extends('layouts.base')

@push('scripts')



<script defer type="module" src="{{asset('js/pages/competitie.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('css/pages/competitii.css')}}"/>
@endpush

<script>

        let dsClasament= @Json($clasament);
           

</script>

@push('content')

<div class="detail detail_competitii ">

    <div class="page_content page_content_detail">

        <h1>Competitie</h1>


        <div class='row'>
            <!-- <label for="input_competitie">Competitie</label> -->
    
            <div>
                <input id="input_competitie" value='{{$master[0]->Name}}' disabled> </input>
                <input id="input_sportfield" value='{{$master[0]->SportField}}'disabled> </input>
            </div>
        </div>


            
        <div class='row'>
            <!-- <label for="input_locatie">Locatie</label> -->
            <div>
                <input id="input_locatie" value='{{$master[0]->Range}}'disabled> </input>
            </div>
        </div>

        <div class='row'>
            <!-- <label for="input_startdate">Perioada</label> -->
            <div>
                <input id="input_startdate" value='{{$master[0]->StartDate}}'disabled> </input>
                <input id="input_enddate" value='{{$master[0]->EndDate}}'disabled> </input>
            </div>
        </div>

    </div>


    <div class="page_content page_content_master page_content_competitii">
        

        <h2>Clasament </h2>

        <smart-grid id="clasamentcompetitie"></smart-grid>

    </div>


</div>
    


@endpush