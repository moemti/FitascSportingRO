<?php

namespace App\Models\Dictionaries;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class Poligon extends BObject{

    protected $IsInsertUnprepared = true; // true if multiple statements etc
    protected $IsUpdateUnprepared = true; // true if multiple statements etc
    protected $IsDeleteUnprepared = true; // true if multiple statements etc
  
    public function MasterKeyField(){
        return 'RangeId';
    } 
    public function DetailKeyField(){
        return 'RangexpersonId';
    } 





    public $MasterSelect = 
                "SELECT `RangeId`, `Name`, `Address`, `Contact`, `CountryId`, `Phone`, `Coordinates`, `Link`, MapLink FROM `range` 
                order by Name"  ;

    public $MasterItemSelect = "SELECT `RangeId`, `Name`, `Address`, `Contact`, `CountryId`, `Phone`, `Coordinates`, `Link`, MapLink FROM `range` 
                where RangeId = :RangeId" ;
                                        

    public $MasterInsert = "INSERT INTO `range`(`Name`, `Address`, `Contact`, `CountryId`, `Phone`, `Coordinates`, `Link`, MapLink)  
                                values ( ':Name', ':Address', ':Contact', :CountryId, ':Phone', ':Coordinates', ':Link', ':MapLink')";         
   

    public $MasterUpdate = "UPDATE `range` SET
                        `Name`= ':Name', 
                        `Address`=':Address', 
                        Contact = ':Contact', 
                        Phone = ':Phone', 
                        CountryId = :CountryId,
                        Coordinates = ':Coordinates',
                        Link = ':Link',
                        MapLink = ':MapLink'
                        WHERE RangeId = :RangeId;
                        ";



    //-------- details -------------


    
    // punem old si new pentru a sti care a fost OLD la update/delete si NEW pentru insert/update
    public $DetailSelect = "SELECT x.RangexpersonId, x.RangeId, x.PersonId,
                            r.Name as `Range`, p.Name as Person
                    from  rangexperson x 
                    inner join `range` r on r.RangeId = x.RangeId
                    left join person p on p.PersonId = x.PersonId
                   
                    where x.RangeId = :RangeId
                    order by p.Name"  ;


    public $DetailInsert = "INSERT INTO `rangexperson`(`RangeId`, `PersonId`)
                                         values(:RangeId, :PersonId)";

    public $DetailUpdate = "update `rangexperson`
                         set RangeId = :RangeId,
                         PersonId = :PersonId
                        where RangexpersonId = :RangexpersonId";    

    public $DetailDelete = "delete from `rangexperson`
                        where RangexpersonId = :RangexpersonId";



    // alte statice

    public static function hasRangesRight($PersonId){
        if (!$PersonId)
            return false;

       return count( DB::select("select 1 from rangexperson where PersonId = $PersonId")) > 0;
    }



    public function  validatebeforeSave($fields){

        if (session('IsSuperUser') == 1)
            return;

        $PersonId = session('PersonId');
        $RangeId = $fields['RangeId'];

        if (!count( DB::select("select 1 from rangexperson where PersonId = $PersonId and RangeId = $RangeId")) > 0)
         throw new \Exception("Nu aveti drept de editare a poligonului");
   
    }
    

    public static function hasCompetitionRight($PersonId, $CompetitionId){
        return count( DB::select("select 1 from rangexperson x inner join competition c on c.RangeId = x.RangeId where PersonId = $PersonId and CompetitionId = $CompetitionId")) > 0;
    }

    public function getRangesAPI(){
        $sql =       "SELECT `RangeId`, r.`Name` as RangeName, `Address`, `Contact`, c.Name as Country, `Phone`, `Coordinates`, `Link`, MapLink FROM `range` r
        inner join country c on c.CountryId = r.CountryId
        order by Country, RangeName"  ;

        return DB::Select($sql);
    }   

}
