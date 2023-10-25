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
            SELECT row_number() over(order by ProcentR desc) as Position, p.Name as Person, Min(sc.Code) as Category, max(t.Name) as Team , p.PersonId, 
            Round(Avg(case when ifNull(r.Aborted,1) = 0 then Percent else null end),2) as Procent,
            Round(Avg(case when ifNull(r.Aborted,1) = 0 then PercentR else null end),2) as ProcentR
            FROM result r 
            inner join person p on p.PersonId = r.PersonId 
            inner join competition c on c.CompetitionId = r.CompetitionId 
            inner join season s on Year(c.StartDate) = s.Year
            left join shooterxseason x on x.PersonId = r.PersonId and x.SeasonId = s.SeasonId 

            left join shootercategory sc on sc.ShooterCategoryId = x.ShooterCategoryId 
            left join team t on t.TeamId = x.TeamId 
            
            
            where year(c.StartDate) = :Year 
            and p.CountryId = 1
            group by p.Name, p.PersonId
            order by ProcentR desc
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


    public $ClasamentSelect = "
                    SELECT row_number() over(order by ProcentR desc) as Position, p.Name as Person, Min(sc.Code) as Category, max(t.Name) as Team , p.PersonId, 
                   Round(aa.Percent,2) as Procent,-- Round(Avg(case when ifNull(r.Aborted,1) = 0 then Percent else null end),2) as Procent , 
                    Round(Avg(case when ifNull(r.Aborted,1) = 0 then PercentR else null end),2) as ProcentR, 
                    count(distinct r.ResultId) as NrCompetitions
                    FROM result r 
                    inner join person p on p.PersonId = r.PersonId 
                    inner join competition c on c.CompetitionId = r.CompetitionId and c.Status = 'Finished'

                    inner join season s on Year(c.StartDate) = s.Year
                    left join shooterxseason x on x.PersonId = r.PersonId and x.SeasonId = s.SeasonId 

                    left join shootercategory sc on sc.ShooterCategoryId = x.ShooterCategoryId 
                    left join team t on t.TeamId = x.TeamId 

                    left join (
                        select avg(PercentR) as Percent, PersonId from (

                         SELECT p.PersonId, PercentR, row_number() OVER (
                            PARTITION BY p.PersonId ORDER BY PercentR DESC

                            ) AS row_num
                      FROM result r 
                                        inner join person p on p.PersonId = r.PersonId 
                                        inner join competition c on c.CompetitionId = r.CompetitionId and c.Status = 'Finished'
                                        where year(c.StartDate) =  :Year 
                                        and p.CountryId = 1


                      ORDER BY p.PersonId, PercentR desc
                            ) T where row_num <= 3
                      group by PersonId
                  ) aa on aa.PersonId = p.PersonId

                    
                    where year(c.StartDate) = :Year 
                    and p.CountryId = 1
                    group by p.Name, p.PersonId
                    order by ProcentR desc
                ";


    public  $ClasamentSelectNew = "
            SELECT 0 as Position, p.Name as Person, (sc.Code) as Category, (t.Name) as Team , p.PersonId, 
            0 as Procent 
            FROM season s 
            inner join shooterxseason x on s.SeasonId = x.SeasonId
            inner join person p on p.PersonId = x.PersonId 
            
            left join shootercategory sc on sc.ShooterCategoryId = x.ShooterCategoryId 
            left join team t on t.TeamId = x.TeamId  
            where s.Year = :Year  
            order by sc.Code, p.Name 
        ";

    public function getCompetitionYears(){
        $sql = "select Year from season order by  Year desc ";
        return DB::select($sql);
    }

    public function GetClasament($Year){
      $sql = str_replace( array(":Year") ,array($Year), $this->ClasamentSelect) ;
      $result = DB::select($sql);

        if (count($result) > 0)
            return $result;
        else{
            $sql = str_replace( array(":Year") ,array($Year), $this->ClasamentSelectNew) ;
            return DB::select($sql);
        }


    }

    public function getResultsPersonyYear($PersonId, $year){
        $sql = "SELECT p.PersonId,  Round(r.Percent, 2) as Percent, Round(r.PercentR, 2) as PercentR, r.Total, concat(c.Name , ' ' , rr.Name , ' ' ,  concat(DATE_FORMAT(c.StartDate, '%d/%m'), ' - ', DATE_FORMAT(c.EndDate, '%d/%m %Y'))) as Name, r.Position as Loc, c.CompetitionId
            FROM result r 
            inner join person p on p.PersonId = r.PersonId 
            inner join competition c on c.CompetitionId = r.CompetitionId and c.Status = 'Finished'  
            inner join `range` rr on rr.RangeId = c.RangeId    
            where year(c.StartDate) = {$year} and r.PersonId = {$PersonId}
            order by c.StartDate"
            ;
        
        return DB::select($sql); 

    }


}