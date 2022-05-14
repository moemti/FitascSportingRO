<?php


use App\Models\Common\Translate;

    function transex($base){

        $locale = app()->getLocale();

        return Translate::getTranslation($base, $locale);
      
    }

    function gettranarray(){
        $locale = app()->getLocale();

        return Translate::getDictionaryNoNull($locale);
    }