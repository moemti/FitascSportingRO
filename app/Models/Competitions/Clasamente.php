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
            and p.CountryId = 1 and c.Oficial = 1
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
                                        inner join competition c on c.CompetitionId = r.CompetitionId and c.Status = 'Finished' and c.Oficial = 1
                                        where year(c.StartDate) =  :Year 
                                        and p.CountryId = 1 and ifNull(r.Aborted,0) = 0 
                      ORDER BY p.PersonId, PercentR desc
                            ) T where row_num <= 3
                      group by PersonId
                  ) aa on aa.PersonId = p.PersonId
                    where year(c.StartDate) = :Year 
                    and p.CountryId = 1 and ifNull(r.Aborted,0) = 0 and c.Oficial = 1
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
        $sql = "SELECT p.PersonId,  Round(case when ifNull(r.Aborted,1) = 0 then Percent else null end, 2) as Percent, 
            Round(case when ifNull(r.Aborted,1) = 0 then PercentR else null end, 2) as PercentR, r.Total, concat(c.Name , ' ' , rr.Name , ' ' ,  
            concat(DATE_FORMAT(c.StartDate, '%d/%m'), ' - ', DATE_FORMAT(c.EndDate, '%d/%m %Y'))) as Name, r.Position as Loc, c.CompetitionId
          
            FROM result r 
            inner join person p on p.PersonId = r.PersonId 
            inner join competition c on c.CompetitionId = r.CompetitionId and c.Status = 'Finished'  
            inner join `range` rr on rr.RangeId = c.RangeId    
            where year(c.StartDate) = {$year} and r.PersonId = {$PersonId} and c.Oficial = 1
            order by c.StartDate"
            ;
        
        return DB::select($sql); 

    }

        public function getSQLClas($ResultId, $CompetitionId){
            $sql = "select Y.* , concat(c.Name , ' ' , rr.Name ) as Competitie,
                    concat(case when month(StartDate) <> month(EndDate) then
                    DATE_FORMAT(StartDate, '%d/%m') else  DATE_FORMAT(StartDate, '%d') end,
                    '-',
                    DATE_FORMAT(EndDate, '%d/%m/%Y') 
                    ) as Perioada,
                year(c.StartDate) as An
                
                from 
                result r 
                inner join person p on p.PersonId = r.PersonId 
                inner join competition c on c.CompetitionId = r.CompetitionId and c.Status = 'Finished'  
                inner join `range` rr on rr.RangeId = c.RangeId 
                inner join 
                (
                
                SELECT rank() over(order by ifnull(sof.Total,0) desc, ifnull(sof.ShootOff, 0) desc)  as Position, r.ResultId, r.CompetitionId, r.PuncteSC,
                     sc.Code as Category, t.Name as Team ,  r.TeamName,
                                    case when r.Aborted = 1 then null else Round(Percent,2) end as Procent, 
                                    case when r.Aborted = 1 then null else Round(PercentR,2) end as ProcentR, 
                                nullif(d1.Result, 0) as M1,
                                nullif(d2.Result, 0) as M2,
                                nullif(d3.Result, 0) as M3,
                                nullif(d4.Result, 0) as M4,
                                nullif(d5.Result, 0) as M5,
                                nullif(d6.Result, 0) as M6,
                                nullif(d7.Result, 0) as M7,
                                nullif(d8.Result, 0) as M8,
                                nullif(sof.Total, 0) as Total,
                                sof.ShootOffS,
                                nullif(sof.Total1, 0) as Total1,
                                nullif(sof.Total2, 0) as Total2,
                                cps.ResultatCat
                                FROM result r
                                left join resultdetail d1 on r.ResultId = d1.ResultId and d1.RoundNr = 1
                                left join resultdetail d2 on r.ResultId = d2.ResultId and d2.RoundNr = 2
                                left join resultdetail d3 on r.ResultId = d3.ResultId and d3.RoundNr = 3
                                left join resultdetail d4 on r.ResultId = d4.ResultId and d4.RoundNr = 4
                                left join resultdetail d5 on r.ResultId = d5.ResultId and d5.RoundNr = 5
                                left join resultdetail d6 on r.ResultId = d6.ResultId and d6.RoundNr = 6
                                left join resultdetail d7 on r.ResultId = d7.ResultId and d7.RoundNr = 7
                                left join resultdetail d8 on r.ResultId = d8.ResultId and d8.RoundNr = 8
                                left join (
                                    select GROUP_CONCAT(case when d.RoundNr > 8 then d.Result else null end  order by d.RoundNr) as ShootOffS,
                                            sum(case when d.RoundNr > 8 then d.Result/(10 *( d.RoundNr - 8))  else 0 end ) as ShootOff, 
                                            sum(case when d.RoundNr <= 8 then d.Result else 0 end ) as Total,
                                            sum(case when d.RoundNr <= 4 then d.Result else 0 end ) as Total1,
                                            sum(case when d.RoundNr <= 8 and d.RoundNr > 4 then d.Result else 0 end ) as Total2,
                                    d.ResultId
                                    from resultdetail d 
                                    group by ResultId
                                    order by d.RoundNr 
                                ) sof on sof.ResultId = r.ResultId 
                                left join (select concat(loc,' ' , vvv.Code ) as ResultatCat , ResultId from (
                                    SELECT  
                                            ROW_NUMBER() OVER (
                                              PARTITION BY sc.Code 
                                              ORDER BY sof.Total desc, ShootOff desc) as loc ,
                                              r.ResultId, sc.Code
                                                        FROM result r
                                                        left join (
                                                            select GROUP_CONCAT(case when d.RoundNr > 8 then d.Result else null end  order by d.RoundNr) as ShootOffS,
                                                                    sum(case when d.RoundNr > 8 then d.Result/(10 *( d.RoundNr - 8))  else 0 end ) as ShootOff, 
                                                                    sum(case when d.RoundNr <= 8 then d.Result else 0 end ) as Total,
                                                            d.ResultId
                                                            from resultdetail d 
                                                            group by ResultId
                                                            order by d.RoundNr 
                                                        ) sof on sof.ResultId = r.ResultId 
                                                        left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId
                                                        where r.CompetitionId = $CompetitionId and sc.code <> 'STR'
                                                        order by sc.Code, loc )vvv
                                                        where loc < 4) cps on cps.ResultId = r.ResultId
                                inner join person p on p.PersonId = r.PersonId
                                left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId
                                left join team t on t.TeamId = r.TeamId
                                where r.CompetitionId = $CompetitionId
                                order by Position, p.Name
                )Y on r.ResultId = Y.ResultId
                where r.ResultId = $ResultId";
                return $sql;
            }
           
           
    public function getResultsPerson($PersonId){
           $sql2 = "select r.ResultId, r.CompetitionId
                from result r 
                inner join competition c on c.CompetitionId = r.CompetitionId and c.Status = 'Finished'  
                where r.PersonId = $PersonId and c.Oficial = 1 order by  c.StartDate  desc                                         
            ";

            $result = [];

            $rez = DB::select($sql2); 

            foreach($rez as $r){
                $sql = $this->getSQLClas($r->ResultId, $r->CompetitionId);

                $result = [...$result, DB::select($sql)];


            }
        
            return $result;

    }

    public function getClasamentPersonalYear($PersonId, $Year){
        $sql = "
                select $Year as  An, Y.* from (
                    SELECT row_number() over(order by ProcentR desc) as Position, p.Name as Person, Min(sc.Code) as Category, max(t.Name) as Team , p.PersonId, 
                    Round(aa.Percent,2) as Procent,-- Round(Avg(case when ifNull(r.Aborted,1) = 0 then Percent else null end),2) as Procent , 
                    Round(Avg(case when ifNull(r.Aborted,1) = 0 then PercentR else null end),2) as ProcentR, 
                    count(distinct r.ResultId) as NrCompetitions,
                    PositionSC, SSC.PuncteSC
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
                                        inner join competition c on c.CompetitionId = r.CompetitionId and c.Status = 'Finished' and c.Oficial = 1
                                        where year(c.StartDate) =  $Year 
                                        and p.CountryId = 1 and ifNull(r.Aborted,0) = 0 
                    ORDER BY p.PersonId, PercentR desc
                            ) T where row_num <= 3
                    group by PersonId
                    ) aa on aa.PersonId = p.PersonId

                    left join (
                        select  rank() over(order by PuncteSC desc) as PositionSC, PuncteSC, PersonId from 
                        (
                            select r.PersonId,  sum(PuncteSC) as PuncteSC  
                                FROM result r
                                inner join competition c on r.CompetitionId = c.CompetitionId and
                                year(StartDate) = $Year and Status = 'Finished'
                                group by r.PersonId
                        )ZZ

                    )SSC on SSC.PersonId = p.PersonId

                    where year(c.StartDate) = $Year 
                    and p.CountryId = 1 and ifNull(r.Aborted,0) = 0 and c.Oficial = 1
                    group by p.Name, p.PersonId
                    order by ProcentR desc
                )Y where PersonId = $PersonId
        ";
        return DB::select($sql);  
    }


    public function GetClasamentSuperCupa($Year){
       $sql = "
            select  rank() over(order by Puncte desc) as Position, Person, Puncte, PersonId from 
            (
                select PersonId,
                Person, sum(Puncte) as Puncte from (
                    select * ,
                    case YY.Position
                    when 1 then 25
                    when 2 then 18
                    when 3 then 15
                    when 4 then 12
                    when 5 then 10
                    when 6 then 8
                    when 7 then 6
                    when 8 then 4
                    when 9 then 2
                    when 10 then 1
                    end as Puncte
                    from 

                    (SELECT r.CompetitionId, rank() over(partition by CompetitionId order by ifnull(sof.Total,0) desc, ifnull(sof.ShootOff, 0) desc)  as Position, 
                    p.PersonId, p.Name as Person,
                    nullif(sof.Total, 0) as Total,
                    sof.ShootOffS
                    FROM result r
                    inner join competition c on r.CompetitionId = c.CompetitionId
                    left join (
                        select GROUP_CONCAT(case when d.RoundNr > 8 then d.Result else null end  order by d.RoundNr) as ShootOffS,
                        sum(case when d.RoundNr > 8 then d.Result/(10 *( d.RoundNr - 8))  else 0 end ) as ShootOff, 
                        sum(case when d.RoundNr <= 8 then d.Result else 0 end ) as Total,
                        ResultId
                        from resultdetail d 
                        group by ResultId
                        order by d.RoundNr 
                    ) sof on sof.ResultId = r.ResultId 

                    inner join person p on p.PersonId = r.PersonId
                    left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId
                    left join team t on t.TeamId = r.TeamId
                    where  Ifnull(sc.code, '') <> 'STR' and year(StartDate) = $Year and Status = 'Finished' and c.Oficial = 1
                    order by r.CompetitionId, Position, p.Name
                    )YY where Position <= 10
                )XX group by Person, PersonId
            order by 2 desc
            )ZZ
       ";
       return DB::select($sql);  
    }

    function getClasamentYearsAPI(){
        return $this->getCompetitionYears();
    }
    
    function getClasamentByYearAPI($year){
        return $this->GetClasament($year);
    }


}