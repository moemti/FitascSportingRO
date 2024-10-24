<?php

namespace App\Models\Common;
use Illuminate\Support\Facades\DB;
use Exception;
use Cache;



class Translate
{
     
    public static function getTranslation($base, $locale){
        $found = false;
        $translation = null;

        $translations = Cache::remember("locale.dictionaries.{$locale}", 60,
            function () use ($locale) {
                return self::getDictionary($locale);
            });

        foreach($translations as $tran){
            if ($tran['Base'] == $base){
                $found = true;
                $translation = $tran['Translation'];
                break;
            }
        }

        if ($translation){
            return $translation;
        }else{
            if (!$found)
                self::addTranslation($base, $locale);

            return $base;
        }    
    }

    public static function getDictionary($locale){
        $sql = "SELECT Base, Translation 
        from translation 
        where Locale = '$locale' ";

        $result = DB::select($sql);  
        
        $result = array_map(function ($value) {
            return (array)$value;
        }, $result);
        return $result;
    }
    public static function getDictionaryNoNull($locale){
        $sql = "SELECT Base, Translation 
        from translation 
        where Locale = '$locale' and Translation is not null ";

        $result = DB::select($sql);  
        
        $result = array_map(function ($value) {
            return (array)$value;
        }, $result);
        return $result;
    }

    public static function addTranslation($base, $locale){
    // nu ma mai uit la locale pun pe cele doua

        $locale = 'EN';
        $sql = "insert into translation (Base, Locale) select '$base', '$locale' from DUAL where not exists (select 1 from translation where Base  = BINARY '$base' and Locale = '$locale') ";
        DB::select($sql); 
         
        $locale = 'HU';
        $sql = "insert into translation (Base, Locale) select '$base', '$locale' from DUAL where not exists (select 1 from translation where Base  = BINARY '$base' and Locale = '$locale') ";
        DB::select($sql); 
    }



    public static function getTranslationDB(){
        $sql = "SELECT  Locale, Base, Translation
        from translation 
        where Translation is not null 
        order by Locale, Base";
        $r = DB::select($sql);  
        
        $result =null;
        $old_lang = '';
        $i = 0;

        foreach ($r as $value){
            $result[$value->Locale][$value->Base] = $value->Translation;
            if ($value->Locale != $old_lang){
                $i = $i + 1;
            }
        }
      
        return $result;
    }

}