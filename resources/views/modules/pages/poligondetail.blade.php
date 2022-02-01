



@extends('layouts.base')

@push('scripts')



@endpush



@push('content')

<div class="detail  ">

    <div class="page_content page_content_detail">

        <h1>Poligon</h1>

        <div class='row'>
       <h2> {{$poligon->Name}}</h2>
        </div>


        <div class='row'>
            <label>Adresa</label> <input value='{{$poligon->Address}}' disabled/>
        </div>
        <div class='row'>
            <label>Contact</label> <input value='{{$poligon->Contact}}' disabled/>
        </div>
        <div class='row'>
            <label>Telefon</label> <input value='{{$poligon->Phone}}' disabled/>
        </div>
        <div class='row'>
            <label>Tara</label> <input value='{{$poligon->Country}}' disabled/>
        </div>

        <div class='row'>
            <a href='{{$poligon->Coordinates}}' target="_blank" class="a a__medium">Locatia pe harta</a>
        </div>

        

      

    </div>




</div>
    


@endpush
