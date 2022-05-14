@extends('layouts.baseex')

@push('content')

<section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">
        <h2>{{transex('Regulamente')}}</h2>

            <ul>
                <li>
                    <a href="https://www.fitasc.com/uk/content/10" target="_blank" class="">{{transex('Regulamente Fitasc')}}</a>
                </li>
                <ul>
                    <li>
                        <a href="https://www.fitasc.com/upload/images/reglements/rglt_pch_20220101_eng.pdf" target="_blank" class="">{{transex('Regulament sporting')}}</a>
                    </li>
                </ul>
            </ul>
    </div>
    
</section>       

<section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">

    @switch(app()->getLocale())
        @case('HU')
            @include('modules.pages.regulamentHU');
            @break
    
        @case('EN')
            @include('modules.pages.regulamentEN');
            @break
    
        @default
            @include('modules.pages.regulamentRO');
    @endswitch

   

    </div>
    
</section>   

@endpush