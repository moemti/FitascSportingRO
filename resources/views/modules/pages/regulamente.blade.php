@extends('layouts.baseex')



@push('footerscripts')
<script>

    @switch(app()->getLocale())
        @case('HU')
            var lan = 'hu';
            @break
    
        @case('EN')
            var lan = 'en';
            @break
    
        @default
            var lan = 'ro';
    @endswitch


    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'ro', 
            includedLanguages: lan, 
            autoDisplay: false
        }, 'google_translate_element');

        function ttr(ll) {
   
        var selectElement = document.querySelector('#google_translate_element select');
        selectElement.value = ll;
        selectElement.dispatchEvent(new Event('change'));
      }
     
        setTimeout(ttr, 1000, lan);
       
    }
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

@endpush


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
                        <a href="https://www.fitasc.com/upload/images/reglements/2025_rglt_pc_eng.pdf" target="_blank" class="">{{transex('Regulament sporting')}}</a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a href=" https://www.fitasc.com/upload/images/cg_inscrip_2025/20241122_cg_en_newsletter/20241122_newsletter_en.pdf" target="_blank" class="">{{transex('Noul regulament pentru inscriere si anulare inscriere la competitii FITASC incepand din 2025')}}</a>
                    </li>
                </ul>
               
            </ul>
    </div>
    
</section>       

<section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">


    @switch(app()->getLocale())
        @case('HU')
            @include('modules.pages.regulamentRO')
            @break
    
        @case('EN')
            @include('modules.pages.regulamentRO')
            @break
    
        @default
            @include('modules.pages.regulamentRO')
    @endswitch

   

    </div>
    
</section>   

@endpush