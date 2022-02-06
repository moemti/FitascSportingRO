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
                    r.name as `Range`, s.Name as SportField, year(StartDate) as Year,  concat(c.Name , ' ' , r.Name , ' ' , c.EndDate) as NumeLung,
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


    public $ClasamentSelect = "
                SELECT row_number() over(order by Total desc, ShootOff desc)  as Position, p.Name as Person, sc.Code as Category, t.Name as Team , r.ResultId,
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
                    sof.ShootOffS


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
                        select GROUP_CONCAT(case when d.RoundNr > 8 then d.Result else null end ) as ShootOffS,
                                sum(case when d.RoundNr > 8 then d.Result else 0 end ) as ShootOff, 
                                sum(case when d.RoundNr <= 8 then d.Result else 0 end ) as Total,
                        
                        d.ResultId
                        from resultdetail d 
                        group by ResultId
                    ) sof on sof.ResultId = r.ResultId 



                    inner join person p on p.PersonId = r.PersonId
                    left join shootercategory sc on sc.ShooterCategoryId = r.ShooterCategoryId
                    left join team t on t.TeamId = r.TeamId
                    where r.CompetitionId = :CompetitionId
                    order by Total desc, ShootOff desc;
                ";


        ////////////////    rezultate    //////////////////
        
        
        public function GetClasament($CompetitionId){
            return DB::select(str_replace(':CompetitionId', $CompetitionId,$this->ClasamentSelect));
        }

        public function getresults($ResultId){
            $sql = "select * from resultdetail r where ResultId = $ResultId";
            return DB::select($sql);
        }
        public function getresultDetail($ResultId){
            $sql = "select p.Name as Persoana from result r 
            inner join person p on p.PersonId = r.PersonId
            
            where r.ResultId = $ResultId";
            return DB::select($sql);
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


}
