<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


class Pages {

    public static function getParticipanti(){
        $sql = 'select p.Name, p.Code, c.Code as Country  
            from person p 
            inner join country c on p.CountryId = c.CountryId 
            order by p.PersonId';
        return  DB::select($sql); 
    } 


    public static function getPoligoane(){
        $sql = 'SELECT r.RangeId, r.`Name`, `Address`, `Contact`, c.Code as Country, `Phone`, `Coordinates`, MapLink
            FROM `range` r inner join country c on c.CountryId = r.CountryId order by r.Name' ;
        return  DB::select($sql); 
    }

    public static function getPoligon($RangeId){
        $sql = "SELECT r.RangeId, r.`Name`, `Address`, `Contact`, c.Code as Country, `Phone`, `Coordinates`, MapLink
                FROM `range` r inner join country c on c.CountryId = r.CountryId where RangeId = {$RangeId}" ;
            return  DB::select($sql); 
    }


}