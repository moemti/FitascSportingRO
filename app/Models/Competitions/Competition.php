<?php

namespace App\Models\Competitions;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;
use App\Models\Competitions\Clasamente;
class Competition extends BObject{


  
    

    const CustomFilters=[
    ];

    const DefaultMasterValues = [];


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
                    
                    Status, Oficial, IsEtapa, IsFinala, InSupercupa, case when Oficial then 'Oficiala' else 'Locala' end as Tip
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
                                    )as Perioada, Status, Oficial, IsEtapa, IsFinala, InSupercupa, Descriere
                FROM `competition` c
                inner join `range` r on r.RangeId = c.RangeId
                inner join sportfield s on s.SportFieldId = c.SportFieldId
            WHERE 
                c.CompetitionId = :CompetitionId ";
                                    

    public $MasterInsert = "INSERT INTO `competition`(`OrganizationId`, Name, `StartDate`, `EndDate`, `RangeId`, `Targets`, `SportId`, Oficial, IsEtapa, IsFinala, InSupercupa, Descriere, Status)  
        values  (:_OrganizationId_, ':Name', ':StartDate',  ':EndDate', :RangeId, :Targets, :SportId, , :Oficial, :IsEtapa, :IsFinala, :InSupercupa, ':Descriere', 'Closed')";            
   

    public $MasterUpdate = "UPDATE `competition` 
                set Name = ':Name',
                `StartDate` = ':StartDate', 
                `EndDate` = ':EndDate', 
                `RangeId` = :RangeId, 
                `Targets` = :Targets, 
                `SportId` = :SportId,
                 Oficial = :Oficial, 
                 IsEtapa = :IsEtapa, 
                 IsFinala = :IsFinala, 
                 InSupercupa = :InSupercupa,
                 Descriere  = ':Descriere'
            where CompetitionId = :CompetitionId";

    public $MasterDelete = "delete from competition
            where CompetitionId = :CompetitionId"  ;


        public $ClasamentSelect2 = "
        SELECT row_number() over(order by p.Name)  as Position, 
            p.PersonId, p.Name as Person, sc.Code as Category, t.Name as Team , r.ResultId, NULL AS BIB, 
            r.IsInTeam, NULL AS NrSerie,  p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma, r.TeamName,
                        Round(Percent,2) as Procent, Round(PercentR,2) as ProcentR,
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
                                                where r.CompetitionId = :CompetitionId and ifnull(sc.code, '') <> 'STR'
                                                order by sc.Code, loc )vvv
                                                where loc < 4) cps on cps.ResultId = r.ResultId
                        inner join person p on p.PersonId = r.PersonId
                        left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId
                        left join team t on t.TeamId = r.TeamId
                        where r.CompetitionId = :CompetitionId 
                        order by  p.Name;
                ";

    public $ClasamentSelectOpen = "
     SELECT rank() over(order by ifnull(sof.Total,0) desc, ifnull(sof.ShootOff, 0) desc)  as Position, 
            p.PersonId, p.Name as Person, sc.Code as Category, t.Name as Team , r.ResultId, r.BIB, 
            r.IsInTeam, r.NrSerie,  p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma, r.TeamName,
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
                                                where r.CompetitionId = :CompetitionId and sc.code <> 'STR'
                                                order by sc.Code, loc )vvv
                                                where loc < 4) cps on cps.ResultId = r.ResultId
                        inner join person p on p.PersonId = r.PersonId
                        left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId
                        left join team t on t.TeamId = r.TeamId
                        where r.CompetitionId = :CompetitionId and sc.code <> 'STR'
                        order by Position, p.Name

                       
     
                ";

                public $ClasamentSelectOpenStr = "
                SELECT rank() over(order by ifnull(sof.Total,0) desc, ifnull(sof.ShootOff, 0) desc)  as Position, 
                       p.PersonId, p.Name as Person, sc.Code as Category, t.Name as Team , r.ResultId, r.BIB, 
                       r.IsInTeam, r.NrSerie,  p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma, r.TeamName,
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
                                                           where r.CompetitionId = :CompetitionId and sc.code <> 'STR'
                                                           order by sc.Code, loc )vvv
                                                           where loc < 4) cps on cps.ResultId = r.ResultId
                                   inner join person p on p.PersonId = r.PersonId
                                   left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId
                                   left join team t on t.TeamId = r.TeamId
                                   where r.CompetitionId = :CompetitionId and sc.code = 'STR'
                                   order by Position, p.Name
           
                                  
                
                           ";
           
           
           


                public $ClasamentSelect = "
                    SELECT row_number() over(order by ifnull(sof.Total,0) desc, ifnull(sof.ShootOff, 0) desc, ifnull(d8.Result, 0) desc, ifnull(d7.Result, 0)  desc, ifnull(d6.Result, 0) desc, ifnull(d5.Result, 0) desc, ifnull(d4.Result, 0) desc, ifnull(d3.Result, 0) desc, 
                    ifnull(d2.Result, 0) desc, ifnull(d1.Result, 0) desc, r.BIB)  as Position, 
            p.PersonId, p.Name as Person, sc.Code as Category, t.Name as Team , r.ResultId, r.BIB, 
            r.IsInTeam, r.NrSerie,  p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma, r.TeamName,
                        Round(Percent,2) as Procent, Round(PercentR,2) as ProcentR,
                        
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
                                                where r.CompetitionId = :CompetitionId and ifnull(sc.code, '') <> 'STR'
                                                order by sc.Code, loc )vvv
                                                where loc < 4) cps on cps.ResultId = r.ResultId
                        inner join person p on p.PersonId = r.PersonId
                        left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId
                        left join team t on t.TeamId = r.TeamId
                        where r.CompetitionId = :CompetitionId
                        order by Position, p.Name;
                ";

                public $ClasamentSelectSerii = "
                SELECT row_number() over(order by Total desc, ShootOff desc, d8.Result desc, d7.Result  desc, d6.Result desc, d5.Result desc, d4.Result desc, d3.Result desc, d2.Result desc, d1.Result desc, r.BIB)  as Position, 
                    p.PersonId, p.Name as Person, sc.Code as Category, t.Name as Team , r.ResultId,
                    r.BIB,
                    r.IsInTeam, r.NrSerie,  p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma, r.TeamName,
                                Round(Percent,2) as Procent, Round(PercentR,2) as ProcentR,
                                d1.Result as M1,
                                d2.Result as M2,
                                d3.Result as M3,
                                d4.Result as M4,
                                d5.Result as M5,
                                d6.Result as M6,
                                d7.Result as M7,
                                d8.Result as M8,
                                sof.Total,
                                sof.ShootOffS,
                                sof.Total1,
                                sof.Total2,
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
                                                        where r.CompetitionId = :CompetitionId and sc.code <> 'STR'
                                                        order by sc.Code, loc )vvv
                                                        where loc < 4) cps on cps.ResultId = r.ResultId
                                inner join person p on p.PersonId = r.PersonId
                                left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId
                                left join team t on t.TeamId = r.TeamId
                                where r.CompetitionId = :CompetitionId and ifnull(r.Aborted,0) = 0
                                order by BIB;
                        ";


        public function getTopCompetitions($PersonId){
            $sql = "SELECT  c.`CompetitionId`, c.Name, `StartDate`, `EndDate`, `Targets`, 
            r.name as `Range`, s.Name as SportField, concat(c.Name , ' ' , r.Name , ' ' ,  c.StartDate, ' ', c.EndDate) as NumeLung, year(c.StartDate) as Year, left(monthname(c.StartDate),3) as Month,
            day(c.StartDate) as Day,
            concat(case when month(StartDate) <> month(EndDate) then
                                    DATE_FORMAT(StartDate, '%d/%m') else  DATE_FORMAT(StartDate, '%d') end,
                                    '-',
                                    DATE_FORMAT(EndDate, '%d/%m/%Y') 
                                    )as Perioada, Status, 
            case when re.PersonId is null then 0 else 1 end as Inscris, r.RangeId, r.Coordinates, r.Address, r.Phone, cy.Name as Country,
            Oficial, IsEtapa, IsFinala, InSupercupa, case when Oficial then 'Oficiala' else 'Locala' end as Tip
            FROM `competition` c
            inner join `range` r on r.RangeId = c.RangeId
            inner join sportfield s on s.SportFieldId = c.SportFieldId
            left join result re on re.CompetitionId = c.CompetitionId and re.PersonId = $PersonId
            left join country cy on cy.CountryId = r.CountryId
            where c.EndDate > CURDATE()
             order by c.StartDate  limit 0, 4";
             return  DB::select($sql);
        }

        public static function getCompetitionAttachments($CompetitionId){
            $sql = "select CompetitionattachId,  Name, FileName from competitionattach where CompetitionId = $CompetitionId order by Name";
            return  DB::select($sql);
        }

        public static function getCompetitionAttachment($CompetitionattachId){
            $sql = "select CompetitionattachId, CompetitionId, Name, FileName from competitionattach where CompetitionattachId = $CompetitionattachId ";
            return  DB::select($sql);
        }

        public function deleteAttach($CompetitionattachId){
            $sql = "delete from competitionattach where CompetitionattachId = $CompetitionattachId ";
            return  DB::select($sql);
        }

        public function modifyAttach($CompetitionattachId, $Name){
            $sql = "update competitionattach  set Name = '$Name' where CompetitionattachId = $CompetitionattachId ";
            return  DB::select($sql);
        }

        public function addAttach($filename, $CompetitionId){
            $sql = "INSERT INTO `competitionattach`( `CompetitionId`, `Name`, `FileName`) VALUES ($CompetitionId, '$filename', '$filename')";
            return  DB::select($sql);
        }

        public function changeCompetitionStatus($CompetitionId, $Status){
            $sql = "UPDATE `competition` 
                set Status = '$Status'
            where CompetitionId = $CompetitionId";

            try{

                DB::beginTransaction();
                DB::select($sql);
                
                $sql = "call spResultsTotal(?)";

                DB::select($sql, [$CompetitionId]);
                DB::Commit();
                return 'OK';
            } catch (\Exception $e) {
                DB::Rollback();
                return $e->getMessage();
            }
        }


        public function putTogetherCompetitiorsEven($CompetitionId, $BibFrom, $SerieTo){
            return 0;
        }

        public function doCompetitionSquadsEven($CompetitionId){
            $MaxPerSquad = 6; // nr max de competitori
            $competitors = DB::select("select ResultId, BIB , c.Code as Cat
                                        from result r 
                                        left join shootercategory c on r.ShooterCategoryId = c.ShooterCategoryId where CompetitionId = $CompetitionId order by c.Code" );

            $nr = count($competitors);

            $S = ceil($nr/$MaxPerSquad);
            if ($S < 4)
                if (floor($nr/4) < 3)
                    $S = 2;
                else    
                    $S = 3;

            $Squads = [];

            // vad cate sunt peste minim 

            $M = $nr % $S;
            $N = floor($nr / $S);
            
            for ($i = 1; $i <= $S; $i++) {
                $p = ($i <= $M?1:0);
                array_push($Squads, [$N + $p, []]); // am pus in fiecare $Squads cati sunt si un array in care o sa intre competitorii

            }

            // punem in urne de catogorii

            $Valori = [];

            $OldCat = '';

            foreach ($competitors as $i => $comp){
                if ($OldCat !== $comp->Cat){
                    array_push($Valori, []);
                    $OldCat = $comp->Cat;
                }

                array_push($Valori[count($Valori) - 1], $comp->ResultId);

            }


            // acum le amestecam

            foreach($Valori as $i => $val){
                shuffle($val);
                $Valori[$i] = $val;
            }


            // impartim pe squads

            $k = 0;
            $l = 0;
            $snr = 0;
            
            foreach($Valori as $i => $val){
                foreach($val as $v){
                
                    // verific sa nu fie deja umplute
                    while (count($Squads[$snr][1]) >= $Squads[$snr][0]){
                        if ($snr >= $S - 1){ // daca e mai mare decat numarul de squaduri
                            $snr = 0;
                        }
                        else{
                            $snr += 1;
                        }
                    }
                    

                    array_push($Squads[$snr][1], $v);

                    if ($snr >= $S - 1){ // daca e mai mare decat numarul de squaduri
                        $snr = 0;
                    }
                    else{
                        $snr += 1;
                    }
                }
            }

            $bib = 1;
            $SS = 1;

           foreach($Squads as $sq){
               foreach($sq[1] as $r){
                    $ResultId = $r;
                    $sql = "update result set BIB = $bib, NrSerie = $SS where ResultId = $ResultId";
                    DB::select($sql);

                    $bib += 1;
               }

               $SS += 1;
           }
           return 'OK';
        }


        public function doCompetitionSquads($CompetitionId, $Type){

            if ($Type == 'Clear'){
                DB::select("update result set BIB = null, NrSerie = null where CompetitionId = $CompetitionId");
                return 'OK';
            }
            
            $MaxSquad = 6; // nr max de competitori
          //  $NrParallel = 2;  // nr de poligoane
            $nr = 0;
            $bibs = array();

            // get Results (competitors)
            $competitors = DB::select("select ResultId, BIB , c.Code
                    from result r 
                    left join shootercategory c on r.ShooterCategoryId = c.ShooterCategoryId where CompetitionId = $CompetitionId");

            $nr = count($competitors);

            // foreach ($competitors as $comp){
            //     if (isset($comp->BIB))
            //          array_push($bibs, $comp->BIB);
            // }  -- eu zic ca nu mai trebuie

            // Nr of squads
            $S = ceil($nr/$MaxSquad);
            if ($S < 4)
              if (floor($nr/4) < 3)
                    $S = 2;
                else    
                    $S = 3;

            $Squads = [];

            // vad cate sunt peste minim 

            $M = $nr % $S;
            $N = floor($nr/$S);
            

            for ($i = 1; $i <= $S; $i++) {
                $p = ($i <= $M?1:0);
                array_push($Squads, [$N + $p]);

            }

            $bibs = array();

            for ($i = 1;$i <= $nr; $i++) {
                $bibs[] = $i;
            }


            

            shuffle($bibs);

            // modificam intre ele acolo unde au deja pusi
            if ($Type == 'Diff'){
                foreach ($competitors as $i=>$comp){
                    if (isset($comp->BIB)){
                        
                        $old = $bibs[$i];
                        $new = $comp->BIB;

                        foreach($bibs as $ii => $b)
                            if ($b == $new)
                                $bibs[$ii] = $old;

                        $bibs[$i] = $new;
                    }
                }
            }
            
            // modificam BIB-urile in baza
         
            foreach ($competitors as $i=>$comp){
                $BIB = $bibs[$i];
                $ResultId = $comp->ResultId;
                $sql = "update result set BIB = $BIB where ResultId = $ResultId";
                DB::select($sql);
            }

            // punem si squad-urile
            $mesaj = [];
            $c = 1;
            foreach ($Squads as $i => $sq){
                $nr = $sq[0];
                $sql = "update result set NrSerie = $i + 1 where CompetitionId = $CompetitionId and BIB >= $c and BIB < $c + $nr";
                DB::select($sql);
                array_push($mesaj, [$nr, $c, $sql]);
                $c += $nr;
            }
            return 'OK';

        }


        public function registerMe($CompetitionId, $PersonId){

            // validare ora
            $sql = "SELECT TIMESTAMPDIFF(minute, now(), StartDate) as Diferenta, now() as OraCurenta, StartDate, (24 + 6) * 60 DiferentaMin,  DATE_ADD(StartDAte, INTERVAL  -(24 + 6) * 60 MINUTE) AS MAXDATE
                    FROM competition WHERE CompetitionId = $CompetitionId";

            $validare = DB::select($sql);

            if ($validare[0]->DiferentaMin > $validare[0]->Diferenta){

                $max = $validare[0]->MAXDATE;
                return "Inscrierea se poate face doar pana in ora $max. Contactati organizatorul pentru inscriere";
            };



            $sql = "insert into result (CompetitionId, PersonId, ShooterCategoryId, TeamId)
            select c.CompetitionId, $PersonId, TT.ShooterCategoryId, TT.TeamId 
            from competition c
            
            left join 
                (select x.ShooterCategoryId, x.TeamId, x.PersonId, s.Year
                from shooterxseason x 
                inner join season s  on s.SeasonId = x.SeasonId 
                ) TT on TT.PersonId = $PersonId and year(c.StartDate) = TT.Year
            where c.CompetitionId = $CompetitionId and not exists (select 1 from result where CompetitionId = $CompetitionId and PersonId = $PersonId)";

            try{
                DB::beginTransaction();
                DB::select($sql);
             
                $ResultId = DB::select("select LAST_INSERT_ID() as ResultId")[0]->ResultId;

                $sql = "INSERT INTO resultdetail( ResultId, RoundNr, Targets, Result, Description) 
                  select $ResultId, Nr, 25, 0, null
                  FROM `result` r 
                  inner join (
                  SELECT 
                      ROW_NUMBER() OVER (
                          ORDER BY PersonId
                      )as Nr
                      from person limit 0,8
                  ) TT on 1 = 1
                  WHERE ResultId = $ResultId";
                
                DB::select($sql);
                DB::Commit();
                return 'OK';
            } catch (\Exception $e) {
                DB::Rollback();
                return $e->getMessage();
            }
        }


        public function unRegisterMe($CompetitionId, $PersonId){
            $sql = " delete from result
             where CompetitionId = $CompetitionId and PersonId = $PersonId";

            try{

                DB::select($sql);
                return 'OK';
            }
            catch(\Exception $e){
            return $e->getMessage();
            }
        }

        
        public static function getCompetitionName($Item){
            return DB::select("select concat(c.Name , ' ' , r.Name , ' ' , c.StartDate) as NumeLung from competition c inner join `range` r on r.RangeId = c.RangeId where c.CompetitionId = $Item")[0]->NumeLung;
        }

        public static function getCompetitionInfo($Item){
            return DB::select("select concat(c.Name , ' ' , r.Name , ' ' , c.StartDate) as NumeLung, Status,  concat(c.Name , ' ' , r.Name , ' ' , DATE_FORMAT(StartDate, '%d/%m'), ' - ', DATE_FORMAT(EndDate, '%d/%m %Y')) as NumeSuperLung,
                StartDate, EndDate from competition c inner join `range` r on r.RangeId = c.RangeId where c.CompetitionId = $Item")[0];
        }


        ////////////////    rezultate    //////////////////
        
        public function getCompetitionYears(){
            $sql = "select Year from season order by  Year desc ";

            return DB::select($sql);
        }


        public static function getShootingCategories(){
            $sql = "select ShooterCategoryId, Name  from shootercategory order by Name ";

            return DB::select($sql);
        }


        static public function getTeams(){
            $sql = "select TeamId, Name  from team order by Name ";

            return DB::select($sql);
        }
        
        public function IsCompetitionAdmin($CompetitionId, $PersonId){
            $SuperUser = session('IsSuperUser') == 1?1:0;
            
            $sql = "SELECT 1 FROM `competition` c
                inner join rangexperson r on c.RangeId = r.RangeId
                where c.Status = 'Preparation' and ((c.CompetitionId = $CompetitionId and r.PersonId = $PersonId) or $SuperUser = 1 ) ";

            return count(DB::select($sql)) > 0;
        }

        public function GetClasament($CompetitionId){
            $PersonId= session('PersonId');
            if (!isset($PersonId))
                $PersonId = 0;

            $Status = self::getCompetitionInfo($CompetitionId)->Status;

            if ($Status == 'Preparation' ){
                if ($this->IsCompetitionAdmin($CompetitionId,  $PersonId))
                    return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelect));
                else
                    return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelect2));
            }
            if (in_array($Status, ['Finished', 'Progress'])){
                return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelectOpen));
            }
            if ($Status == 'Open' )
             return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelect2));
        }

        public function GetClasamentSerii($CompetitionId){
            return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelectSerii));
        }

        public function GetClasamentStr($CompetitionId){
            return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelectOpenStr));
        }
        

        public function GetClasamentCategory($CompetitionId){
        $sql =  "
            SELECT 
                p.Name as Person, sc.Code as Category, t.Name as Team ,loc, sof.Total, ShootOffS
                        FROM result r
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

                        left join (
                                select concat(loc,' ' , vvv.Code ) as ResultatCat , loc, ResultId , vvv.Code
                                from (
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
                                                        where r.CompetitionId = :CompetitionId 
                                                        order by sc.Code, loc 
                                        ) vvv
                                        where (loc < 4)
                                    ) cps on cps.ResultId = r.ResultId
                        inner join person p on p.PersonId = r.PersonId
                        left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId
                        left join team t on t.TeamId = r.TeamId
                        where r.CompetitionId = :CompetitionId
                        and ResultatCat is not null and ifnull(r.Aborted,0) = 0
                        order by Category, loc
                ";
            $clasament = DB::select(str_replace(':CompetitionId', $CompetitionId, $sql));
            $result = [];
            $cat = '';
            
            foreach ($clasament  as  $r){
                if ($cat != '' && $cat != $r->Category){
                    array_push($result, (object)[]);  
                    
                };
                $cat = $r->Category;
                array_push($result, $r);
            }
            return $result;

        }
        

        public function GetClasamentTeams($CompetitionId){


            $sql = "SELECT 1 FROM `result` WHERE TeamName is not null and CompetitionId = $CompetitionId";

            if (count(DB::select($sql)) > 0 )

                    $sql =  "
                    select ROW_NUMBER() OVER ( order by sum(Total) desc ) as Loc, sum(Total) as Total, Team , GROUP_CONCAT(person order by locechipa SEPARATOR ', ') as Members  
                    from   
                    ( select * from (
                                                            select    ROW_NUMBER() OVER (
                                                                Partition by Team
                                                                order by Team desc ,soft.Total desc
                                                            ) as locechipa, rr.ResultId, soft.Total, rr.PersonId, p.Name as Person, rr.TeamId, IfNull(TeamName, t.Name) as Team
                                                            FROM result rr
                                                            inner join person p on p.PersonId = rr.PersonId
                                                            inner join (
                                                                    select GROUP_CONCAT(case when d.RoundNr > 8 then d.Result else null end  order by d.RoundNr) as ShootOffS,
                                                                                sum(case when d.RoundNr > 8 then d.Result/(10 *( d.RoundNr - 8))  else 0 end ) as ShootOff, 
                                                                                sum(case when d.RoundNr <= 8 then d.Result else 0 end ) as Total,
                                                                        d.ResultId
                                                                        from resultdetail d 
                                                                        group by ResultId
                                                                    ) soft on soft.ResultId = rr.ResultId 
                                                            left join shootercategory sc on sc.ShooterCategoryId = rr.ShooterCategoryId
                                                            left join team t on t.TeamId = rr.TeamId
                                                            where rr.CompetitionId = :CompetitionId and ifnull(sc.code, '') <> 'STR'  and TeamName is not null                                                    
                                                            order by  Total desc, locechipa
                        ) X where locechipa < 4
                    order by Total desc , locechipa)
                    table1
                    group by Team
                    order by Total desc
                    limit 0,3 ";
                else
                    $sql =  "
                    select ROW_NUMBER() OVER ( order by sum(Total) desc ) as Loc, sum(Total) as Total, Team , GROUP_CONCAT(person order by locechipa SEPARATOR ', ') as Members  
                    from   
                    ( select * from (
                                                            select    ROW_NUMBER() OVER (
                                                                Partition by Team
                                                                order by Team desc ,soft.Total desc
                                                            ) as locechipa, rr.ResultId, soft.Total, rr.PersonId, p.Name as Person, rr.TeamId, IfNull(TeamName, t.Name) as Team
                                                            FROM result rr
                                                            inner join person p on p.PersonId = rr.PersonId
                                                            inner join (
                                                                    select GROUP_CONCAT(case when d.RoundNr > 8 then d.Result else null end  order by d.RoundNr) as ShootOffS,
                                                                                sum(case when d.RoundNr > 8 then d.Result/(10 *( d.RoundNr - 8))  else 0 end ) as ShootOff, 
                                                                                sum(case when d.RoundNr <= 8 then d.Result else 0 end ) as Total,
                                                                        d.ResultId
                                                                        from resultdetail d 
                                                                        group by ResultId
                                                                    ) soft on soft.ResultId = rr.ResultId 
                                                            left join shootercategory sc on sc.ShooterCategoryId = rr.ShooterCategoryId
                                                            left join team t on t.TeamId = rr.TeamId
                                                            where rr.CompetitionId = :CompetitionId and ifnull(sc.code, '') <> 'STR'                                                
                                                            order by  Total desc, locechipa
                        ) X where locechipa < 4
                    order by Total desc , locechipa)
                    table1
                    group by Team
                    order by Total desc
                    limit 0,3 ";


                return DB::select(str_replace(':CompetitionId', $CompetitionId, $sql));
            }
        
        public function GetCompetitors($CompetitionId){
            $sql =  " select BIB , NrSerie,  ROW_NUMBER() OVER ( Partition by NrSerie
                                                    order by BIB 
                                                ) as LocSerie, p.Name

            FROM result rr
            inner join person p on p.PersonId = rr.PersonId
            where rr.CompetitionId = $CompetitionId 
            order by  NrSerie, BIB";
            return DB::select($sql);

        }


        public function getresultDetails($ResultId){
            $sql = "select * from resultdetail r where ResultId = $ResultId";
            return DB::select($sql);
        }

        public function getresultDetail($ResultId){
            $sql = "select p.Name, coalesce(r.ShooterCategoryId, x.ShooterCategoryId) as ShooterCategoryId, coalesce(r.TeamId, x.TeamId) as TeamId, r.Aborted, Position, Total, Percent, ResultId, p.PersonId, PercentR,
                r.BIB, r.IsInTeam, r.NrSerie, r.TeamName,  p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma
            from result r 
            inner join person p on p.PersonId = r.PersonId
            inner join competition c on c.CompetitionId = r.CompetitionId
            inner join season s on Year(c.StartDate) = s.Year
            left join shooterxseason x on x.PersonId = r.PersonId and x.SeasonId = s.SeasonId 
            where r.ResultId = $ResultId";
            return DB::select($sql);
        }


        public function getCompetitionByStartDate($data){
            $sql = "select CompetitionId from competition c where  c.StartDate = '$data'";

            return    DB::select($sql)[0]->CompetitionId;
        }
        public function getCompetitionByResult($ResultId){
            $sql = "select CompetitionId from result c where  c.ResultId = $ResultId";

            return    DB::select($sql)[0]->CompetitionId;
        }
        
        
        public function SaveResultsDetail($fields){
            $ItemId = $fields['ResultId'];
            try {
                DB::beginTransaction();
                if (array_key_exists('delta', $fields)) 
                    $this->updateDetails($fields['delta'], $ItemId, $fields);
                DB::commit();
            }
            catch(\Exception $e){
                    DB::rollBack();
                    $this->OnSaveError($e);
                    throw $e;
            }
            return $this->getresults($ItemId);
        }
      

        public function updateDetails($delta, $MasterId, $master){

            if ($delta == [])
                return 'no delta';
    
            foreach($delta as $s){
                    
                $d = (object) ($s);
                switch ($d->Operation){
                    case "D": $this->deleteDetail($d, $master);
                        break;
                    case "U":  $this->updateDetail($d, $master);
                        break;
                    case "I": $this->insertDetail($d, $MasterId, $master);
                        break;    
                }
            }
        }


        public function insertDetail($detail, $ItemId, $master){
            $sql = "INSERT INTO resultdetail( ResultId, RoundNr, Targets, Result, Description) 
                    VALUES ($ItemId, :RoundNr, :Targets, :Result, ':Description')";

            foreach($detail as $key => $value){
                $sql = self::paramreplace($key, $value, $sql); 
            }

            foreach($master as $key => $value){
                if (!is_array($value))
                    $sql = self::paramreplace($key, $value, $sql); 
            }


            self::PutNullValues($sql);

            DB::unprepared($sql);
        }
    
        public function updateDetail($detail, $master){
            $sql = "
                UPDATE
                        `resultdetail`
                    SET
                        `RoundNr` = :RoundNr,
                        `Targets` = :Targets,
                        `Result` = :Result,
                        `Description` = ':Description'
                    WHERE
                        ResultDetailId = :ResultDetailId
                ";
    
        
            foreach($detail as $key => $value){
                $sql = self::paramreplace($key, $value, $sql); 
            }
            foreach($master as $key => $value){
                if (!is_array($value))
                    $sql = self::paramreplace($key, $value, $sql); 
            }
            self::PutNullValues($sql);
           
            DB::unprepared($sql);
        }
    
        public function deleteDetail($detail, $master){
            $sql = "
                DELETE from
                    `resultdetail`
                WHERE
                    ResultDetailId = :ResultDetailId
                ";
          
            foreach($detail as $key => $value){
                $sql = self::paramreplace($key, $value, $sql); 
            }
            foreach($master as $key => $value){
                if (!is_array($value))
                    $sql = self::paramreplace($key, $value, $sql); 
            }
            
        
            return DB::unprepared($sql);
        }

        public function getUnregisteredPersons($CompetitionId){
            $sql = "select p.Name, Email, p.PersonId, x.ShooterCategoryId, x.TeamId
                    from person p 
                    inner join competition c on c.CompetitionId = $CompetitionId
                    left join season s on year(c.StartDate) = s.Year
                    left join shooterxseason x on x.SeasonId = s.SeasonId and p.PersonId = x.PersonId
                    left join result u on p.PersonId = u.PersonId and u.CompetitionId = $CompetitionId
                    where u.PersonId is null order by p.Name";
            return  DB::select($sql);
        }

        public function registerCompetitorDB($request){
            try{
                $PersonId = $request['PersonId'];
                $TeamId = $request['TeamId'];
                $ShooterCategoryId = $request['ShooterCategoryId'];
                $CompetitionId = $request['CompetitionId'];
                $Team = $request['Team'];

                $sql = "SELECT TIMESTAMPDIFF(minute, now(), StartDate) as Diferenta, now() as OraCurenta, StartDate, (24 + 6) * 60 DiferentaMin,  DATE_ADD(StartDAte, INTERVAL  -(24 + 6) * 60 MINUTE) AS MAXDATE
                FROM competition WHERE CompetitionId = $CompetitionId";
    
                $validare = DB::select($sql);

                $LogedId= session('PersonId');
                if (!isset($LogedId))
                    $LogedId = 0;
    
           
                if (!$this->IsCompetitionAdmin($CompetitionId,  $LogedId))
                    if ($validare[0]->DiferentaMin > $validare[0]->Diferenta){
                        $max = $validare[0]->MAXDATE;
                        return "Inscrierea se poate face doar pana in ora $max. Contactati organizatorul pentru inscriere";
                    };

                if ($PersonId == -1){
                    $sql = "INSERT INTO person(Name, Code, Email,   SerieNrCI, CNP, SeriePermisArma, DataExpPermis, MarcaArma, SerieArma, CalibruArma, CountryId) 
                        values( ':Name', 'xxx', null,  ':SerieNrCI', ':CNP', ':SeriePermisArma', ':DataExpPermis', ':MarcaArma', ':SerieArma', ':CalibruArma', :CountryId )";
                      

                    // replace parameters
                    foreach($request as $key => $value){
                        if (!is_array($value))
                            $sql = self::paramreplace($key, $value, $sql); 
                    }
        
        
                    self::PutNullValues($sql);


                    DB::select($sql);


                    $PersonId = DB::select("select LAST_INSERT_ID() as PersonId")[0]->PersonId;


                    $sql = "insert into shooterxseason (PersonId, SeasonId) select $PersonId , SeasonId from season;";
                    DB::select($sql);

                }

                $sql =  "UPDATE `person` SET
                    
                        CountryId = :CountryId,
                        SerieNrCI = ':SerieNrCI',
                        CNP = ':CNP',
                        SeriePermisArma = ':SeriePermisArma',
                        DataExpPermis = ':DataExpPermis',
                        MarcaArma = ':MarcaArma',
                        SerieArma = ':SerieArma',
                        CalibruArma = ':CalibruArma'

                        WHERE PersonId = :PersonId;";

                 // replace parameters

           


                 foreach($request as $key => $value){
                    if (!is_array($value))
                        $sql = self::paramreplace($key, $value, $sql); 
                }
    

    
                self::PutNullValues($sql);


                DB::select($sql);       


                if (!($TeamId > 0) &&  ($Team != '')){
                    $sql = "insert into team (Name, IsActive) values ('$Team', 1)"; 
                    DB::select($sql);


                    $TeamId = DB::select("select LAST_INSERT_ID() as TeamId")[0]->TeamId;


                }

                if ($TeamId > 0){

                    $sql = "update shooterxseason set TeamId = $TeamId where PersonId = $PersonId;";
                    DB::select($sql); 

                }
                else
                    $TeamId = 'null';


                    
                if ($ShooterCategoryId > 0){

                    $sql = "update shooterxseason set ShooterCategoryId = $ShooterCategoryId where PersonId = $PersonId;";
                    DB::select($sql); 
                }else
                    $ShooterCategoryId = 'null';
                
                $sql = "insert into result (CompetitionId, PersonId, ShooterCategoryId, TeamId)
                    select $CompetitionId, $PersonId, $ShooterCategoryId, $TeamId from DUAL
                    where not exists (select 1 from result where CompetitionId = $CompetitionId and PersonId = $PersonId)";

                DB::select($sql);


                DB::Commit();
                return 'OK';
            } catch (\Exception $e) {
                DB::Rollback();
                return $e->getMessage();
            }


        }

        public static function outputFiles($path){
            $menu = [];

            if(file_exists($path) && is_dir($path)){
                $result = scandir($path);
                $dirs = array_diff($result, array('.', '..'));               
                if(count($dirs) > 0){
                    foreach($dirs as $file){
                        if(!is_file("$path/$file")){
                            // sa verific daca exista fisiere    
                            $result2 = scandir("$path/$file");
                            $dirs2 = array_diff($result2, array('.', '..'));
                            if (count($dirs2) > 0){
                                $id = $file;
                                $str = self::getCompetitionInfo($id)->NumeSuperLung;
                                array_push($menu, ["gallery/$id", "$str"]); 
                             }
                        }
                    } 
                }
             }
             return $menu;
        }

        public static function getGaleries(){
            // iau directoarele din folderul de galerii
            return self::outputFiles("img/gallery/competitions");
        }

        public static function getCurrentCompetition(){
            $res = [];
            $sql = "
            SELECT
                            *
                        FROM
                            (
                            SELECT
                                c.CompetitionId,
                                CONCAT(
                                    c.Name,
                                    ' ',
                                    r.Name,
                                    ' ',
                                    case when month(StartDate) <> month(EndDate) then
                                    DATE_FORMAT(StartDate, '%d/%m') else  DATE_FORMAT(StartDate, '%d') end,
                                    '-',
                                    DATE_FORMAT(EndDate, '%d/%m/%Y') 
                                ) AS NumeSuperLung,
                                s.Name as SportField,
                                r.Link,
                                CASE WHEN c.EndDate >= NOW() AND c.StartDate <= NOW() THEN 'Rezultate competitie (LIVE)' WHEN c.StartDate > NOW() THEN 'Urmatoarea competitie' WHEN c.EndDate < NOW() THEN 'Rezultate competitie' ELSE ''
                                END AS Mesaj
                            FROM
                                competition c
                            INNER JOIN `range` r ON
                                r.RangeId = c.RangeId
                                inner join sportfield s on s.SportFieldId = c.SportFieldId
                            WHERE
                                c.StartDate > DATE_ADD(NOW(), INTERVAL -5 DAY)
                            ORDER BY
                                c.StartDate ASC
                                LIMIT 0, 1) TT

                            UNION ALL
                        SELECT NULL
                            ,
                            'Sfarsit de sezon',
                            NULL, NULL,
                            ''
                        LIMIT 0, 1
            "
                     ;

            $r = DB::select($sql)[0];

            $id = $r->CompetitionId;

            $path = "img/gallery/competitions/$id";
          
            $i = 0;

            if(file_exists($path) && is_dir($path)){
                $result = scandir($path);
                natcasesort($result );
                $files = array_diff($result, array('.', '..'));

                if(count($files) > 0){
                    foreach($files as $file){
                        if ($i == 3)
                            break;

                        if(is_file("$path/$file")){
                            $url = $file;
                            $i++;
                           
                            array_push($res, (object) array_merge( (array)$r, array( 'Image' => $url ) ));
                        } 
                    }
                } 
            }

            for ($j = $i; $j < 3; $j++ ){
                array_push($res, $r);
            }
         
            return $res;

        }

        public static function switchPersons ($CompetitionId, $PersonId1, $PersonId2){
            $sql = "select BIB, NrSerie from result where PersonId = $PersonId1 and CompetitionId = $CompetitionId";
            $r = DB::select($sql);

            $BIB1 = $r[0]->BIB;
            $NrSerie1 = $r[0]->NrSerie;

            $sql = "select BIB, NrSerie from result where PersonId = $PersonId2 and CompetitionId = $CompetitionId";
            $r = DB::select($sql);

            $BIB2 = $r[0]->BIB;
            $NrSerie2 = $r[0]->NrSerie;

            try{

                DB::beginTransaction();

                $sql = "update result set  BIB = $BIB2, NrSerie = $NrSerie2 where PersonId = $PersonId1 and CompetitionId = $CompetitionId";
                DB::select($sql);
    
                $sql = "update result set  BIB = $BIB1, NrSerie = $NrSerie1 where PersonId = $PersonId2 and CompetitionId = $CompetitionId";
                DB::select($sql);

                DB::Commit();

                return 'OK';
            } catch (\Exception $e) {
                DB::Rollback();
                return $e->getMessage();
            }
        }

        public function getCompetitiiAPI(){
            $sql = "SELECT `CompetitionId`, c.Name as Competition, `StartDate`, `EndDate`, c.`RangeId`, `Targets`, 
            r.name as `Range`, s.Name as SportField, year(StartDate) as Year,  concat(c.Name , ' ' , r.Name , ' ' , c.StartDate) as NumeLung,

            
            concat(case when month(StartDate) <> month(EndDate) then
                            DATE_FORMAT(StartDate, '%d/%m') else  DATE_FORMAT(StartDate, '%d') end,
                            '-',
                            DATE_FORMAT(EndDate, '%d/%m/%Y') 
                            ) as Perioada, 
            
            Status
            FROM `competition` c
            inner join `range` r on r.RangeId = c.RangeId
            inner join sportfield s on s.SportFieldId = c.SportFieldId
            order by Year desc, c.StartDate ";

          return DB::select($sql);

        }

        public function imregisteredAPI($CompetitionId, $PersonId){
            $sql = " select 1 from result
            where CompetitionId = $CompetitionId and PersonId = $PersonId";
            return ["Registered" => count(DB::select($sql)) > 0];
        }
    
        public function registermeAPI($CompetitionId, $PersonId){
            $registered = $this->imregisteredAPI($CompetitionId, $PersonId)["Registered"];
            if ($registered == true){
                 $this->unRegisterMe($CompetitionId, $PersonId);
            }
            else{
                 $this->registerMe($CompetitionId, $PersonId);
            }
            return $this->imregisteredAPI($CompetitionId, $PersonId);
        }

        public function listaParticipantiAPI($CompetitionId){
            return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelect2));
        }

        public function geCompetitionTimetable($CompetitionId, $Day){
            $sql = "
            select c.ScheduleType, c.NrPosturiPoligon, c.NrPoligoane,  Day, Ora, Poligon, Post, Serie
            from schedule s
            inner join competition c on c.CompetitionId = s.CompetitionId
            where s.CompetitionId = {$CompetitionId} and s.Day = {$Day}
            order by Day, Ora, Poligon , Post, Serie
            ";

            return DB::select($sql);
        }

        public function getCompetitionNrSerii($CompetitionId){
            return DB::select("select Max(NrSerie) as NrSerii from result where  CompetitionId = {$CompetitionId}")[0]->NrSerii;
        }

        public function generateTimetable ($CompetitionId){

            try {
                DB::select ("delete from schedule where CompetitionId = {$CompetitionId} ");

                $ds =  DB::select ("select ScheduleType,
                    ScheduleInterval ,
                    NrPoligoane,
                    NrPosturiPoligon,
                    MinutePauza,
                    DATE_FORMAT(FirstDayStartTime, '%H:%i') as FirstDayStartTime,
                    DATE_FORMAT(SecondDayStartTime, '%H:%i' ) as SecondDayStartTime
                    from competition where CompetitionId = {$CompetitionId} ");

                $NrSerii = $this->getCompetitionNrSerii($CompetitionId);

                if ($NrSerii == null)
                    return "Nu exista generate seriile";
                   
                $ScheduleType = $ds[0]->ScheduleType;

                $vars = (array)($ds[0]);
              

                $lipsa = [];
                foreach($vars as $key => $v){


                    if ($v == null){
                        if (!($key == 'MinutePauza' && ($ScheduleType == "Normal")))
                            array_push($lipsa, $key);
                    }


                }

                if ($lipsa != null)
                    return 'Nu exista configurate valorile pentru generarea rogramului competitiei '.implode($lipsa);

                if ($ScheduleType !== "Normal" && ($NrSerii % 2 == 1))
                    return "Numarul de serii trebuie sa fie par pentru tipul de tragere condensat";

          
               

                if (count($ds) == 0)
                    return 'No schedule';

                $this->generateTimetableDay($CompetitionId, 1, $ds[0], $NrSerii);
                $this->generateTimetableDay($CompetitionId, 2, $ds[0], $NrSerii);
                return 'OK';
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }



        public function MyCompetitionsAPI($PersonId){
            $sql = "SELECT c.`CompetitionId`, c.Name as Competition, `StartDate`, `EndDate`, c.`RangeId`, `Targets`, 
            r.name as `Range`, s.Name as SportField, year(StartDate) as Year,  concat(c.Name , ' ' , r.Name , ' ' , c.StartDate) as NumeLung,

            
            concat(case when month(StartDate) <> month(EndDate) then
                            DATE_FORMAT(StartDate, '%d/%m') else  DATE_FORMAT(StartDate, '%d') end,
                            '-',
                            DATE_FORMAT(EndDate, '%d/%m/%Y') 
                            ) as Perioada, 
            
            Status, case when rr.PersonId is null then 'Neinscris' else 'Inscris' end as Inscris
            FROM `competition` c
            inner join `range` r on r.RangeId = c.RangeId
            inner join sportfield s on s.SportFieldId = c.SportFieldId
            left join result rr on rr.CompetitionId = c.CompetitionId and rr.PersonId = $PersonId
            where c.Status in ('Open', 'Closed', 'Preparation')
            order by c.StartDate";

          return DB::select($sql);
    
        }
    
        public function MyPersonalInfo($PersonId){
            $sql = "SELECT `PersonId`,  `SerieNrCI`, `CNP`, `SeriePermisArma`, `DataExpPermis`, `MarcaArma`, `SerieArma`, `CalibruArma`, `AltePrecizari` FROM `person` WHERE  PersonId = $PersonId" ; 

            $personal = DB::select($sql);
            $ob = new Clasamente;

            $Year = date("Y");
            $Init = $Year;
            $clasament = [];
            do{

                $r = $ob->getClasamentPersonalYear($PersonId, $Year);
                if (!is_null($r) && count($r) > 0)
                    $clasament = [...$clasament, $r];
                $Year--;
            }
            while ((!is_null($r) && count($r) > 0) || ($Init = $Year));

            $rezultate = $ob->getResultsPerson($PersonId);
            return ["personal" => $personal, "clasament" => $clasament, "rezultate" => $rezultate];

        }

        public function currentCompetition($PersonId){
            $sql = "SELECT r.BIB, r.NrSerie, c.CompetitionId, DATE_ADD(EndDate, INTERVAL 0 DAY) as EndDate 
            FROM competition c
            inner join result r on c.CompetitionId = r.CompetitionId
            where 
                r.PersonId = $PersonId 
             and Status =  'Progress'
            ";

            $competition = DB::select($sql);

            $CompetitionId = null;
            $NrSerie = null;
            $seriaMea = [];
            $orar = [];

            if (count($competition) > 0){
                $CompetitionId = $competition[0]->CompetitionId;
                $NrSerie = $competition[0]->NrSerie;

                $sql = "SELECT r.BIB, p.Name, p.PersonId
                FROM competition c
                inner join result r on c.CompetitionId = r.CompetitionId
                inner join person p on p.PersonId = r.PersonId
                where 
                    c.CompetitionId = {$CompetitionId} and 
                    r.NrSerie = {$NrSerie}
                    order by BIB";
                $seriaMea = DB::select($sql);

                $sql = "
                    select  Day, Ora, Poligon, Post, Serie
                    from schedule s
                    inner join competition c on c.CompetitionId = s.CompetitionId
                    where s.CompetitionId = {$CompetitionId} and s.Serie = {$NrSerie} 
                    order by Day, Ora, Poligon , Post, Serie
                    ";
                $orar = DB::select($sql);
            }

            return ["competition" => $competition, "seriaMea" => $seriaMea, "orar" => $orar];
        }


        public function GetClasamentSuperCupa($CompetitionId){
            $sql = "    
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
            from (
            SELECT rank() over(order by ifnull(sof.Total,0) desc, ifnull(sof.ShootOff, 0) desc)  as Position, 
                    p.PersonId, p.Name as Person,
                                nullif(sof.Total, 0) as Total,
                                sof.ShootOffS
                                FROM result r
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
                                where r.CompetitionId = $CompetitionId and ifnull(sc.code, '') <> 'STR'
                                order by Position, p.Name)YY
                                where Position <= 10
                ";

            return DB::select($sql);
        }

        private function getNextSerie(&$seria,  &$poligon, $NrSerii, $SerieBaza, $Day){
            $serii = []; 
            $serieMax = $SerieBaza + $NrSerii/2 - 1; //  1  => 7 , 8 => 14
            $count = 0;

            if ($Day == 1){
                if ($seria > $serieMax)
                    $seria = $SerieBaza;
            }else{
                if ($seria < $SerieBaza)
                    $seria = $serieMax;
            }

            while (in_array($seria , $poligon)){
                if ($Day == 1)    
                    $seria = $seria + 1;
                else    
                    $seria = $seria - 1;

                if ($Day == 1){
                    if ($seria > $serieMax)
                        $seria = $SerieBaza;
                }else{
                    if ($seria < $SerieBaza)
                        $seria = $serieMax;
                }

                array_push($serii, $seria);
                $count++;
                
                if ($count > $NrSerii)
                return ;//throw new \Exception('Serii gasite '.implode($serii). " si poligon ".implode($poligon));
            }     
           
            array_push($poligon, $seria);

            if ($Day == 1)    
                $seria = $seria + 1;
            else    
                $seria = $seria - 1;

            if ($Day == 1){
                if ($seria > $serieMax)
                    $seria = $SerieBaza;
            }else{
                if ($seria < $SerieBaza)
                    $seria = $serieMax;
            }
        }

        function DoItBaby($NrPoligoane, $NrPost, $ADone, &$poligoane, $NrSerii, $SerieBaza, $PoligonBaza, $Day, $EstePar)
        {
            $seria = $SerieBaza - ($Day - 1);
            $p = $PoligonBaza;

            for ($v = 1; $v < $NrPoligoane * $NrPost; $v++) {
                $ADone[$v] = false;
            }

            $count = 0;
            $NrSeriiMax = count($poligoane[$p]);
            $Done = false;
            while (!$Done){
                if (count($poligoane[$p]) < $NrSeriiMax + $NrSerii/ 2 ){
                    if ($p % 2 == $EstePar) // este par si nu trebuie sa fie nimic aici
                    {
                        array_push($poligoane[$p], 0);
                    }  
                    else{  
                        $this->getNextSerie($seria,  $poligoane[$p], $NrSerii, $SerieBaza, $Day);
                    };

                    if ($p < $PoligonBaza + ($NrPoligoane - 1) ) // 1 + (6-1) = 6
                        $p = ($p + 1);
                    else 
                        $p = $PoligonBaza;
                }else{
                    $ADone[$p] = true;
                }
                // verific daca sunt gata toate din calup
                $Done = true;
                for ($x = $PoligonBaza; $x < $PoligonBaza + $NrPoligoane - 1; $x = $x + 2) {
                    $Done = $Done && $ADone[$x];
                }
                $count++;
                // asta nu ar mai fi nevoie
                if ($count > $NrSerii * $NrPoligoane * $NrPost)
                    $Done = true;
            }


        }

        public function generateTimetableDay ($CompetitionId, $Day, $ds, $NrSerii){
            $OraIncepere = ($Day == 1)?$ds->FirstDayStartTime:$ds->SecondDayStartTime;
            $Interval = $ds->ScheduleInterval;
            $MinutePauza = $ds->MinutePauza;
            $NrPoligoane =  $ds->NrPoligoane;
            $NrPost =  $ds->NrPosturiPoligon;
            $ScheduleType = $ds->ScheduleType;
            $poligoane = [];
            $ADone = [];
            $ora = '';
            $min = '';
            $NrSeriiMax = 0;

            if ($ScheduleType == "Normal"){
                $Ora = $OraIncepere;
           
                // initializam arrrayul de poligoane
                for ($p = 1; $p <= $NrPoligoane ; $p++) {
                    array_push($poligoane, []);
                    array_push($ADone, false);
                }
                $Done = false;
                $p = 0;
                if ($Day == 1)
                    $seria = 0;
                else    
                    $seria = $NrSerii + 1;


                $count = 0;
               
                while (!$Done){
                    if ($Day == 1){
                        $seria = ($seria + 1) % ($NrSerii + 1);
                        $seria = $seria==0?1:$seria;

                        if (count($poligoane[$p]) < $NrSerii){
                            while (in_array($seria , $poligoane[$p])){
                                $seria = ($seria + 1) % ($NrSerii + 1);
                                $seria = $seria==0?1:$seria;
                            }
                            array_push($poligoane[$p], $seria);
                        }else{
                            $ADone[$p] = true;
                        }
                    }
                    else{
                        $seria = ($seria - 1);
                        if ($seria == 0)
                            $seria = $NrSerii;

                        if (count($poligoane[$p]) < $NrSerii){
                            while (in_array($seria , $poligoane[$p])){
                                $seria = ($seria - 1);
                                if ($seria == 0)
                                    $seria = $NrSerii;
                            }
                            array_push($poligoane[$p], $seria);
                        }else{
                            $ADone[$p] = true;
                        }
                    }

                    // verific daca toate s-au termniat
                    $Done = true;

                    for ($x = 0; $x < $NrPoligoane ; $x++) {
                        $Done = $Done && $ADone[$x];
                    }

                    $p = ($p + 1) % $NrPoligoane;
                    $count++;

                    // asta nu ar mai fi nevoie
                    if ($count > $NrSerii * $NrPoligoane)
                        $Done = true;
                }

                $sqls = [];
                $ora = substr($OraIncepere, 0, 2); 
                $min = substr($OraIncepere, 3, 2); 

                for ($s = 0; $s < $NrSerii ; $s++) {
                    $DeLa = "'1900-01-01 $ora:$min'";

                    for ($p = 0; $p < $NrPoligoane ; $p++) {
                        $seria = $poligoane[$p][$s];
                        $polig = $p + 1;
                        $sql = "INSERT INTO `schedule`(`CompetitionId`, `Day`, `Poligon`, `Post`, `Ora`, `Serie`) values ($CompetitionId, $Day, $polig, 1, $DeLa, $seria)";
                        DB::select($sql);
                        array_push($sqls, $sql);
                    }

                    $min = $min * 1 + $Interval;
                    $ora = ($ora * 1 ) + intdiv($min, 60);
                    $min = ($min * 1) % 60;

                    $min = str_pad($min, 2, "0", STR_PAD_LEFT);
                    $ora = str_pad($ora, 2, "0", STR_PAD_LEFT);
                }

            }else
            
            { // anormal :)
                $Ora = $OraIncepere;
              

                // initializam arrra-yul de poligoane
                for ($p = 1; $p <= $NrPoligoane * $NrPost; $p++) {
                    array_push($poligoane, []); // creez toate poligoanele
                    array_push($ADone, false);
                }
               

                // incepem cel nou
                    //  --- presupunem ca sunt doua posturi pe poligon

                // ***   1      primele poligoane post 1 - primele serii
                $SerieBaza = 1;
                $PoligonBaza = 0;
                $EstePar = 1; // primele
                $this->DoItBaby($NrPoligoane, $NrPost, $ADone, $poligoane, $NrSerii, $SerieBaza, $PoligonBaza, $Day, $EstePar);

                // ***   2      ----------- poligon 1 seria 1
                $SerieBaza = $NrSerii/2 + 1;
                $PoligonBaza = $NrPoligoane * $NrPost/2 ;
                $EstePar = 1; // imparele
                $this->DoItBaby($NrPoligoane, $NrPost, $ADone, $poligoane, $NrSerii, $SerieBaza, $PoligonBaza, $Day, $EstePar);

                // ***   3      primele poligoane post 2 - primele serii
                $SerieBaza = 1;
                $PoligonBaza = 0;
                $EstePar = 0; // parele
                $this->DoItBaby($NrPoligoane, $NrPost, $ADone, $poligoane, $NrSerii, $SerieBaza, $PoligonBaza, $Day, $EstePar);
     
                 // ***   4      ----------- poligon 1 seria 1
                $SerieBaza = $NrSerii/2 + 1;
                $PoligonBaza = $NrPoligoane * $NrPost/2 ;
                $EstePar = 0; // parele
                $this->DoItBaby($NrPoligoane, $NrPost, $ADone, $poligoane, $NrSerii, $SerieBaza, $PoligonBaza, $Day, $EstePar);

                //   dupa masa

                 // ***   5      primele poligoane post 1 - primele serii
                 $SerieBaza = 1;
                 $PoligonBaza = $NrPoligoane * $NrPost/2;
                 $EstePar = 1; // primele
                 $this->DoItBaby($NrPoligoane, $NrPost, $ADone, $poligoane, $NrSerii, $SerieBaza, $PoligonBaza, $Day, $EstePar);
 
                 // ***   6      ----------- poligon 1 seria 1
                 $SerieBaza =  $NrSerii/2 + 1;
                 $PoligonBaza = 0 ;
                 $EstePar = 1; // imparele
                 $this->DoItBaby($NrPoligoane, $NrPost, $ADone, $poligoane, $NrSerii, $SerieBaza, $PoligonBaza, $Day, $EstePar);
              
                 // ***   7      primele poligoane post 2 - primele serii
                $SerieBaza = 1;
                $PoligonBaza = $NrPoligoane * $NrPost/2;
                $EstePar = 0; // parele
                $this->DoItBaby($NrPoligoane, $NrPost, $ADone, $poligoane, $NrSerii, $SerieBaza, $PoligonBaza, $Day, $EstePar);

                  // ***   8      ----------- poligon 1 seria 1
                 $SerieBaza = $NrSerii/2 + 1;
                 $PoligonBaza = 0 ;
                 $EstePar = 0; // parele
                 $this->DoItBaby($NrPoligoane, $NrPost, $ADone, $poligoane, $NrSerii, $SerieBaza, $PoligonBaza, $Day, $EstePar);

           //  return  $poligoane; // pentru test

           // scriemm in DB

                $sqls = [];
                $ora = substr($OraIncepere, 0, 2); 
                $min = substr($OraIncepere, 3, 2); 

                for ($s = 0; $s <  $NrSerii * $NrPost  ; $s++) {
                    $DeLa = "'1900-01-01 $ora:$min'";

                    for ($p = 0; $p < $NrPoligoane  * $NrPost; $p++) {
                        $seria = $poligoane[$p][$s];
                        $polig = $p + 1;
                        $post = $p % $NrPost + 1;
                        $sql = "INSERT INTO `schedule`(`CompetitionId`, `Day`, `Poligon`, `Post`, `Ora`, `Serie`) values ($CompetitionId, $Day, $polig, $post, $DeLa, $seria)";
                        DB::select($sql);
                        array_push($sqls, $sql);
                    }

                    // pun pauza de masa daca este condensat
                    if ($ScheduleType !== "Normal")
                        if ($s == intdiv($NrSerii * $NrPost, 2) - 1){

                            $min = $min * 1 + $MinutePauza;
                            $ora = ($ora * 1 ) + intdiv($min, 60);
                            $min = ($min * 1) % 60;
                            $min = str_pad($min, 2, "0", STR_PAD_LEFT);
                            $ora = str_pad($ora, 2, "0", STR_PAD_LEFT);
                            $DeLa = "'1900-01-01 $ora:$min'";
                        }
                        else{

                            $min = $min * 1 + $Interval;
                            $ora = ($ora * 1 ) + intdiv($min, 60);
                            $min = ($min * 1) % 60;
                            $min = str_pad($min, 2, "0", STR_PAD_LEFT);
                            $ora = str_pad($ora, 2, "0", STR_PAD_LEFT);
                        }
                }
            }


        }

        public function saveSchedule($CompetitionId, $Serii)
        {
            $sql = "delete from schedule where CompetitionId = $CompetitionId";
            try{

                DB::beginTransaction();
                DB::select($sql);
    
                foreach($Serii as $s){

                    $day = $s['day'];
                    $post = $s['post'];
                    $poligon = $s['poligon'];
                    $ora = $s['ora'];
                    $seria = $s['seria'];
                    $seria = $seria>0?$seria:0;


                    $sql2 = "INSERT INTO `schedule`(`CompetitionId`, `Day`, `Poligon`, `Post`, `Ora`, `Serie`) VALUES ($CompetitionId, $day, $poligon, $post, '$ora', $seria)";
                    DB::select($sql2);
                };
                
                DB::Commit();
                
                return 'OK';
            } catch (\Exception $e) {
                DB::Rollback();
                return $e->getMessage();
            }
        }

    
}
