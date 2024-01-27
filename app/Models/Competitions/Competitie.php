<?php

namespace App\Models\Competitions;
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
                    
                    Status, Oficial, IsEtapa, IsFinala, InSupercupa, Descriere
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
                                    )as Perioada, Status, Oficial, IsEtapa, IsFinala, InSupercupa, Descriere, ScheduleType,
                 ScheduleInterval ,
                 NrPoligoane,
                 NrPosturiPoligon,
                 DATE_FORMAT(FirstDayStartTime, '%H:%i') as FirstDayStartTime,
                 DATE_FORMAT(SecondDayStartTime, '%H:%i' )as SecondDayStartTime
                FROM `competition` c
                inner join `range` r on r.RangeId = c.RangeId
                inner join sportfield s on s.SportFieldId = c.SportFieldId
            WHERE 
                c.CompetitionId = :CompetitionId ";
                                    

    public $MasterInsert = "INSERT INTO `competition`( Name, `StartDate`, `EndDate`, `RangeId`, `Targets`, `SportFieldId`, Oficial, IsEtapa, IsFinala, InSupercupa, Descriere, Status,
                 ScheduleType,
                 ScheduleInterval ,
                 NrPoligoane,
                 NrPosturiPoligon,
                 FirstDayStartTime,
                 SecondDayStartTime)  
        values  ( ':Name', ':StartDate',  ':EndDate', :RangeId, :Targets, :SportFieldId,  :Oficial, :IsEtapa, :IsFinala, :InSupercupa, ':Descriere', 'Closed',
                ':ScheduleType',
                 :ScheduleInterval ,
                 :NrPoligoane,
                 :NrPosturiPoligon,
                 ':FirstDayStartTime',
                 ':SecondDayStartTime')";            
   

    public $MasterUpdate = "UPDATE `competition` 
                set Name = ':Name',
                `StartDate` = ':StartDate', 
                `EndDate` = ':EndDate', 
                `RangeId` = :RangeId, 
                `Targets` = :Targets, 
                `SportFieldId` = :SportFieldId,
                 Oficial = :Oficial, 
                 IsEtapa = :IsEtapa, 
                 IsFinala = :IsFinala, 
                 InSupercupa = :InSupercupa,
                 Descriere  = ':Descriere',
                 ScheduleType = ':ScheduleType',
                 ScheduleInterval = :ScheduleInterval, 
                 NrPoligoane = :NrPoligoane, 
                 NrPosturiPoligon = :NrPosturiPoligon ,
                 FirstDayStartTime = '1900-01-01 :FirstDayStartTime :00',
                 SecondDayStartTime = '1900-01-01 :SecondDayStartTime :00'

            where CompetitionId = :CompetitionId";

    public $MasterDelete = "delete from competition
            where CompetitionId = :CompetitionId"  ;

    public $DetailSelect = "select cr.PersonId as OLD_PersonId , cr.PersonId as NEW_PersonId
                            from competitionreferees cr
                             inner join person p on p.PersonId = cr.PersonId   
                            where cr.CompetitionId = :CompetitionId
                            order by p.Name";
    public $DetailInsert = 'insert into competitionreferees(CompetitionId, PersonId) values (:CompetitionId, :NEW_PersonId)';
    public $DetailUpdate = 'update competitionreferees set PersonId = :NEW_PersonId where  CompetitionId = :CompetitionId and PersonId = :OLD_PersonId';
    public $DetailDelete = 'delete from competitionreferees where CompetitionId = :CompetitionId and PersonId = :OLD_PersonId';




}
