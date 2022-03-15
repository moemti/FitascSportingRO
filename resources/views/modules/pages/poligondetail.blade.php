



@extends('layouts.baseex')

@push('scripts')



@endpush



@push('content')

<section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">
         <div class="row justify-content-center text-center">
            <div class="col-lg-6 custom-sm-margin-bottom-1">
                <h2> {{$poligon->Name}}</h2>
                <a href='{{$poligon->Coordinates}}' target="_blank" class="a a__medium">
                    <i class="fas fa-map-marker-alt text-color-primary custom-icon-size-1"></i>
                    
                    <p class="custom-text-color-2 alternative-font-4 text-3-5">
                        {{$poligon->Address}} <br>{{$poligon->Country}}
                    </p>
                </a>
                <p class="custom-text-color-2 alternative-font-4 text-3-5">   <h4> {{$poligon->Contact}}</h4>
                    <a href="tel:+" class="text-decoration-none custom-text-color-2">
                        
                    <i class="fas fa-phone text-color-primary custom-icon-size-1"></i>
                    Telefon: {{$poligon->Phone}}</a><br>
                </p>
            </div>
        </div>

    </div>
</section>
    


@endpush
