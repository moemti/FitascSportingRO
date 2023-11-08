<?php

namespace App\Models\Dictionaries;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class Competitie extends BObject{

    protected $IsInsertUnprepared = true; // true if multiple statements etc
    protected $IsUpdateUnprepared = true; // true if multiple statements etc
    protected $IsDeleteUnprepared = true; // true if multiple statements etc
  
    public function MasterKeyField(){
        return 'CompetitionId';
    } 

    public $MasterSelect = "SELECT `CompetitionId`, c.Name, `StartDate`, `EndDate`, c.`RangeId`, `Targets`, c.`SportFieldId` , 
                    r.name as `Range`, s.Name as SportField, year(StartDate) as Year,  concat(c.Name , ' ' , r.Name , ' ' , c.StartDate) as NumeLung,

                    
                    concat(case when month(StartDate) <> month(EndDate) then
                                    DATE_FORMAT(StartDate, '%d/%m') else  DATE_FORMAT(StartDate, '%d') end,
                                    '-',
                                    DATE_FORMAT(EndDate, '%d/%m/%Y') 
                                    ) as Perioada, 
                    
                    Status, IsOficial, IsEtapa, IsFinala, InSupercupa
                    FROM `competition` c
                    inner join `range` r on r.RangeId = c.RangeId
                    inner join sportfield s on s.SportFieldId = c.SportFieldId
                
                order by Year desc, c.StartDate ";

    public $MasterItemSelect = "SELECT `CompetitionId`, c.Name, `StartDate`, `EndDate`, c.`RangeId`, `Targets`, c.`SportFieldId` ,
                r.name as `Range`, s.Name as SportField, year(StartDate) as Year,
                concat(case when month(StartDate) <> month(EndDate) then
                                    DATE_FORMAT(StartDate, '%d/%m') else  DATE_FORMAT(StartDate, '%d') end,
                                    '-',
                                    DATE_FORMAT(EndDate, '%d/%m/%Y') 
                                    )as Perioada, Status, IsOficial, IsEtapa, IsFinala, InSupercupa, Descriere
                FROM `competition` c
                inner join `range` r on r.RangeId = c.RangeId
                inner join sportfield s on s.SportFieldId = c.SportFieldId
            WHERE 
                c.CompetitionId = :CompetitionId ";
                                    

    public $MasterInsert = "INSERT INTO `competition`(`OrganizationId`, Name, `StartDate`, `EndDate`, `RangeId`, `Targets`, `SportId`, IsOficial, IsEtapa, IsFinala, InSupercupa, Descriere)  
        values  (:_OrganizationId_, ':Name', ':StartDate',  ':EndDate', :RangeId, :Targets, :SportId, , :IsOficial, :IsEtapa, :IsFinala, :InSupercupa, ':Descriere')";            
   

    public $MasterUpdate = "UPDATE `competition` 
                set Name = ':Name',
                `StartDate` = ':StartDate', 
                `EndDate` = ':EndDate', 
                `RangeId` = :RangeId, 
                `Targets` = :Targets, 
                `SportId` = :SportId,
                 IsOficial = :IsOficial, 
                 IsEtapa = :IsEtapa, 
                 IsFinala = :IsFinala, 
                 InSupercupa = :InSupercupa,
                 Descriere  = ':Descriere'
            where CompetitionId = :CompetitionId";

    public $MasterDelete = "delete from competition
            where CompetitionId = :CompetitionId"  ;

    

}
