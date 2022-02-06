@extends('frame.masterlist')

@push('title')
    {{$data[0]->Persoana}}
@endpush

@push('subtitle')

@endpush


@push('masterscripts')
    <script>        
        let ResultId = {{$ResultId}}

    </script>
    <script defer type="text/javascript" src={{asset('js/pages/competitie/resultedit.js')}}></script>

   
@endpush


