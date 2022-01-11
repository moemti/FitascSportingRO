<?php

namespace App\Models\Competitions;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class Clasamente extends BObject{


  
    

    const CustomFilters=[
    ];

    const DefaultMasterValues = [];


    public function MasterKeyField(){
        return 'CompetitionId';
    } 



    public $MasterSelect = "
            SELECT row_number() over(order by Procent desc) as Position, p.Name as Person, Min(sc.Code) as Category, max(t.Name) as Team , p.PersonId, 
            Round(Avg(case when ifNull(r.Aborted,1) = 0 then Percent else null end),2) as Procent 
            FROM result r 
            inner join person p on p.PersonId = r.PersonId 
            inner join competition c on c.CompetitionId = r.CompetitionId 
            left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId 
            left join team t on t.TeamId = r.TeamId 
            
            where year(c.StartDate) = 2022 
            and p.CountryId = 1
            group by p.Name, p.PersonId
            order by Procent desc
        ";

    public $MasterItemSelect = "SELECT `CompetitionId`, c.Name, `StartDate`, `EndDate`, c.`RangeId`, `Targets`, c.`SportFieldId` ,
                r.name as `Range`, s.Name as SportField, year(StartDate) as Year
                FROM `competition` c
                inner join `range` r on r.RangeId = c.RangeId
                inner join sportfield s on s.SportFieldId = c.SportFieldId
            WHERE 
                c.CompetitionId = :CompetitionId ";
                                    

    public $MasterInsert = "INSERT INTO `competition`(`OrganizationId`, Name, `StartDate`, `EndDate`, `RangeId`, `Targets`, `SportId`)  
        values  (:_OrganizationId_, ':Name', ':StartDate',  ':EndDate', :RangeId, :Targets, :SportId)";            
   

    public $MasterUpdate = "UPDATE `competition` 
                set Name = ':Name',
                `StartDate` = ':StartDate', 
                `EndDate` = ':EndDate', 
                `RangeId` = :RangeId, 
                `Targets` = :Targets, 
                `SportId` = :SportId
    
            where CompetitionId = :CompetitionId";

    public $MasterDelete = "delete from competition
            where CompetitionId = :CompetitionId"  ;


    public $Clasament2021Select = "
                    SELECT row_number() over(order by Procent desc) as Position, p.Name as Person, Min(sc.Code) as Category, max(t.Name) as Team , p.PersonId, 
                    Round(Avg(case when ifNull(r.Aborted,1) = 0 then Percent else null end),2) as Procent 
                    FROM result r 
                    inner join person p on p.PersonId = r.PersonId 
                    inner join competition c on c.CompetitionId = r.CompetitionId 
                    left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId 
                    left join team t on t.TeamId = r.TeamId 
                    
                    where year(c.StartDate) = 2021 
                    and p.CountryId = 1
                    group by p.Name, p.PersonId
                    order by Procent desc
                ";



        public function GetClasament2021(){
            return DB::select($this->Clasament2021Select);
        }


}
