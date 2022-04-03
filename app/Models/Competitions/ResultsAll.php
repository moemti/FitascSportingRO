<?php

namespace App\Models\Competitions;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class ResultsAll {


    protected $IsInsertUnprepared = true; // true if multiple statements etc
    protected $IsUpdateUnprepared = true; // true if multiple statements etc
    protected $IsDeleteUnprepared = false; // true if multiple statements etc
    


    public function MasterKeyFields(){
        return ['ResultId'];
    } 



    public $MasterSelect = "
    
            select p.Name as Person,  r.ResultId, r.BIB,  r.NrSerie,
                        
                        d1.Result as M1,
                        d2.Result as M2,
                        d3.Result as M3,
                        d4.Result as M4,
                        d5.Result as M5,
                        d6.Result as M6,
                        d7.Result as M7,
                        d8.Result as M8,
                        d9.Result as M9,
                        d10.Result as M10,
                        d11.Result as M11,
                        r.Total
                      
    
                        FROM result r
    
                        left join resultdetail d1 on r.ResultId = d1.ResultId and d1.RoundNr = 1
                        left join resultdetail d2 on r.ResultId = d2.ResultId and d2.RoundNr = 2
                        left join resultdetail d3 on r.ResultId = d3.ResultId and d3.RoundNr = 3
                        left join resultdetail d4 on r.ResultId = d4.ResultId and d4.RoundNr = 4
                        left join resultdetail d5 on r.ResultId = d5.ResultId and d5.RoundNr = 5
                        left join resultdetail d6 on r.ResultId = d6.ResultId and d6.RoundNr = 6
                        left join resultdetail d7 on r.ResultId = d7.ResultId and d7.RoundNr = 7
                        left join resultdetail d8 on r.ResultId = d8.ResultId and d8.RoundNr = 8
                        left join resultdetail d9 on r.ResultId = d9.ResultId and d9.RoundNr = 9
                        left join resultdetail d10 on r.ResultId = d10.ResultId and d10.RoundNr = 10
                        left join resultdetail d11 on r.ResultId = d11.ResultId and d11.RoundNr = 11
    
                        inner join person p on p.PersonId = r.PersonId
                  
                        where r.CompetitionId = :CompetitionId
                        order by r.NrSerie, r.BIB; ";



    public $MasterInsert = "INSERT INTO `result`( `CompetitionId`, `PersonId`, `ShooterCategoryId`, `TeamId`, `Aborted`, BIB, IsInTeam, NrSerie)
        values  ( :CompetitionId, :PersonId, :ShooterCategoryId, :TeamId, :Aborted, :BIB, :IsInTeam, :NrSerie);
       
        UPDATE `person` SET
                    
                      
                    SerieNrCI = ':SerieNrCI',
                    CNP = ':CNP',
                    SeriePermisArma = ':SeriePermisArma',
                    DataExpPermis = ':DataExpPermis',
                    MarcaArma = ':MarcaArma',
                    SerieArma = ':SerieArma',
                    CalibruArma = ':CalibruArma'

                    WHERE PersonId = :PersonId;

        ";            
   

    public $MasterUpdate = "UPDATE
                `result`
            SET
                `ShooterCategoryId` =:ShooterCategoryId,
                `TeamId` = :TeamId,
                `Aborted` = :Aborted,
                 BIB = :BIB, 
                 IsInTeam = :IsInTeam, 
                 NrSerie = :NrSerie
            WHERE
             ResultId = :ResultId;
             
             UPDATE `person` SET
                        SerieNrCI = ':SerieNrCI',
                        CNP = ':CNP',
                        SeriePermisArma = ':SeriePermisArma',
                        DataExpPermis = ':DataExpPermis',
                        MarcaArma = ':MarcaArma',
                        SerieArma = ':SerieArma',
                        CalibruArma = ':CalibruArma'
                        WHERE PersonId = :PersonId; ";

    public $MasterDelete = "
    
            delete from resultdetail where ResultId = :ResultId;
    
            delete from result
            where ResultId = :ResultId;"  ;

    public $DetailInsert =  "INSERT INTO resultdetail( ResultId, RoundNr, Targets, Result, Description) 
            VALUES (:ResultId, :RoundNr, :Targets, :Result, ':Description')";
          
          
    public $DetailUpdate = "
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
            
    public $DetailDelete =  "
            DELETE from
                `resultdetail`
            WHERE
                ResultDetailId = :ResultDetailId
            ";
    
           

 

    public function getMasterList($Item){

   



        $sql = $this->MasterSelect;
        $sql = BObject::paramreplace('CompetitionId', $Item, $sql);  
        BObject::PutNullValues($sql);
        return  DB::select($sql);
    }

    public function Save($fields){
        $Item = $fields['MasterFilter'];


        // return fields;

        DB::beginTransaction(); 
        try{   
            if (array_key_exists('delta', $fields)) {
                foreach($fields['delta'] as $s){
                    
                    $d = (object) ($s);
                    switch ($d->Operation){
                        case "D": $this->deleteMaster($s);
                            break;
                        case "U": $this->updateMaster($s);
                            break;
                        case "I": $this->insertMaster($s);
                            break;    
        
                    }
                }
            }
        
            DB::commit();
        }
        catch(\Exception $e){
                DB::rollBack();
                throw $e;
        }
       
           

        return $this->getMasterList($Item);


    }
       

    public function insertMaster($detail){

       
    }

    public function updateMaster($detail){      
       

        $ResultId = $detail[$this->MasterKeyFields()[0]]; // am luat ResultId

            foreach($detail as $key => $value){
                if (in_array($key, ['M1', 'M2', 'M3',  'M4', 'M5', 'M6', 'M7', 'M8', 'M9', 'M10', 'M11', 'M12'])){

                    $RoundNr = substr($key, 1);

                    $sql =  "delete from resultdetail where ResultId = $ResultId and RoundNr = $RoundNr";
                    DB::unprepared($sql);

                    if ($value > 0){
                        $sql = "insert into `resultdetail`(ResultId, RoundNr, Targets, Result)
                                values($ResultId, $RoundNr, 25, $value)";
                        DB::unprepared($sql);
                    }
                    
                }

            }
           
       


       
    }

    public function deleteMaster($detail){
       
    }


}

