<?php

namespace App\Models\Competitions;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class Competition extends BObject{


  
    

    const CustomFilters=[
    ];

    const DefaultMasterValues = [];


    public function MasterKeyField(){
        return 'CompetitionId';
    } 



    public $MasterSelect = "SELECT `CompetitionId`, c.Name, `StartDate`, `EndDate`, c.`RangeId`, `Targets`, c.`SportFieldId` , 
                    r.name as `Range`, s.Name as SportField, year(StartDate) as Year,  concat(c.Name , ' ' , r.Name , ' ' , c.StartDate) as NumeLung,
                    concat(DATE_FORMAT(StartDate, '%d/%m'), ' - ', DATE_FORMAT(EndDate, '%d/%m %Y')) as Perioada, Status
                    FROM `competition` c
                    inner join `range` r on r.RangeId = c.RangeId
                    inner join sportfield s on s.SportFieldId = c.SportFieldId
                
                order by Year desc, c.StartDate ";

    public $MasterItemSelect = "SELECT `CompetitionId`, c.Name, `StartDate`, `EndDate`, c.`RangeId`, `Targets`, c.`SportFieldId` ,
                r.name as `Range`, s.Name as SportField, year(StartDate) as Year,
                concat(DATE_FORMAT(StartDate, '%d/%m'), ' - ', DATE_FORMAT(EndDate, '%d/%m %Y')) as Perioada, Status
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




        public $ClasamentSelect2 = "
        SELECT row_number() over(order by Total desc, ShootOff desc, d8.Result desc, d7.Result  desc, d6.Result desc, d5.Result desc, d4.Result desc, d3.Result desc, d2.Result desc, d1.Result desc, r.BIB)  as Position, 
            p.PersonId, p.Name as Person, sc.Code as Category, t.Name as Team , r.ResultId, NULL AS BIB, 
            r.IsInTeam, NULL AS NrSerie,  p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma, r.TeamName,
                        Round(Percent,2) as Procent,
                        
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
                        where r.CompetitionId = :CompetitionId
                        order by Position, p.Name;
                ";

    public $ClasamentSelect = "
        SELECT row_number() over(order by Total desc, ShootOff desc, d8.Result desc, d7.Result  desc, d6.Result desc, d5.Result desc, d4.Result desc, d3.Result desc, d2.Result desc, d1.Result desc, r.BIB)  as Position, 
            p.PersonId, p.Name as Person, sc.Code as Category, t.Name as Team , r.ResultId, r.BIB, 
            r.IsInTeam, r.NrSerie,  p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma, r.TeamName,
                        Round(Percent,2) as Procent,
                        
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
                        where r.CompetitionId = :CompetitionId
                        order by Position, p.Name;
                ";

                public $ClasamentSelectSerii = "
                SELECT row_number() over(order by Total desc, ShootOff desc, d8.Result desc, d7.Result  desc, d6.Result desc, d5.Result desc, d4.Result desc, d3.Result desc, d2.Result desc, d1.Result desc, r.BIB)  as Position, 
                    p.PersonId, p.Name as Person, sc.Code as Category, t.Name as Team , r.ResultId,
                    r.BIB,
                    
                    r.IsInTeam, r.NrSerie,  p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma, r.TeamName,
                                Round(Percent,2) as Procent,
                                
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
                                where r.CompetitionId = :CompetitionId
                                order by BIB;
                        ";


        public function getTopCompetitions($PersonId){
            $sql = "SELECT  c.`CompetitionId`, c.Name, `StartDate`, `EndDate`, `Targets`, 
            r.name as `Range`, s.Name as SportField, concat(c.Name , ' ' , r.Name , ' ' ,  c.StartDate, ' ', c.EndDate) as NumeLung, year(c.StartDate) as Year, left(monthname(c.StartDate),3) as Month,
            day(c.StartDate) as Day,
            concat(DATE_FORMAT(StartDate, '%d/%m'), ' - ', DATE_FORMAT(EndDate, '%d/%m %Y')) as Perioada, Status, 
            case when re.PersonId is null then 0 else 1 end as Inscris, r.RangeId, r.Coordinates, r.Address, r.Phone, cy.Name as Country
            FROM `competition` c
            inner join `range` r on r.RangeId = c.RangeId
            inner join sportfield s on s.SportFieldId = c.SportFieldId
            left join result re on re.CompetitionId = c.CompetitionId and re.PersonId = $PersonId
            left join country cy on cy.CountryId = r.CountryId
            where c.EndDate > CURDATE()
             order by c.StartDate  limit 0, 4";
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
            return DB::select("select concat(c.Name , ' ' , r.Name , ' ' , c.StartDate) as NumeLung,
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
        
        public function GetClasament($CompetitionId){

        //    if (session('PersonId') == 195)
                return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelect));
      //      else
            //    return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelect2));
        }

        public function GetClasamentSerii($CompetitionId){
            return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelectSerii));
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
    
    
                        left join (select concat(loc,' ' , vvv.Code ) as ResultatCat , loc, ResultId from (
    
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
                        where r.CompetitionId = :CompetitionId
                        and ResultatCat is not null
                        order by Category, loc
                ";
            return DB::select(str_replace(':CompetitionId', $CompetitionId, $sql));
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
                                                            where rr.CompetitionId = :CompetitionId and sc.code <> 'STR'  and TeamName is not null                                                    
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
                                                            where rr.CompetitionId = :CompetitionId and sc.code <> 'STR'                                                
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
            $sql = "select p.Name, coalesce(r.ShooterCategoryId, x.ShooterCategoryId) as ShooterCategoryId, coalesce(r.TeamId, x.TeamId) as TeamId, r.Aborted, Position, Total, Percent, ResultId, p.PersonId,
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

            //    DB::beginTransaction();


                $PersonId = $request['PersonId'];
                $TeamId = $request['TeamId'];
                $ShooterCategoryId = $request['ShooterCategoryId'];
                $CompetitionId = $request['CompetitionId'];
                $Team = $request['Team'];

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

}

