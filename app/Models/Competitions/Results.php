<?php

namespace App\Models\Competitions;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class Results extends BObject{


    protected $IsInsertUnprepared = true; // true if multiple statements etc
    protected $IsUpdateUnprepared = true; // true if multiple statements etc
    protected $IsDeleteUnprepared = false; // true if multiple statements etc
    

    const CustomFilters=[
    ];

    const DefaultMasterValues = [];


    public function MasterKeyField(){
        return 'ResultId';
    } 



    public $MasterSelect = " ";

    public $MasterItemSelect = "select p.Name, coalesce(r.ShooterCategoryId, x.ShooterCategoryId) as ShooterCategoryId, coalesce(r.TeamId, x.TeamId) as TeamId, r.Aborted, Position, Total, Percent, ResultId,
            r.BIB, r.IsInTeam, r.NrSerie
            from result r 
            inner join person p on p.PersonId = r.PersonId
            inner join competition c on c.CompetitionId = r.CompetitionId
            inner join season s on Year(c.StartDate) = s.Year
            left join shooterxseason x on x.PersonId = r.PersonId and x.SeasonId = s.SeasonId 
            
            where r.ResultId = :ResultId";
                                            

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
                        WHERE PersonId = :PersonId; 
                        
                        ";

        


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
    
           


        ////////////////    rezultate    //////////////////
        
        public function getCompetitionYears(){
            $sql = "select Year from season order by  Year desc ";

            return DB::select($sql);
        }


        public function getShootingCategories(){
            $sql = "select ShooterCategoryId, Name  from shootercategory order by Name ";

            return DB::select($sql);
        }


        public function getTeams(){
            $sql = "select TeamId, Name  from team order by Name ";

            return DB::select($sql);
        }
        

        public function getresultDetails($ResultId){
            $sql = "select * from resultdetail r where ResultId = $ResultId";
            return DB::select($sql);
        }

        public function getresultDetail($ResultId){
            $sql = "select p.Name, coalesce(r.ShooterCategoryId, x.ShooterCategoryId) as ShooterCategoryId, coalesce(r.TeamId, x.TeamId) as TeamId, r.Aborted, Position, Total, Percent, ResultId,
            r.BIB, r.IsInTeam, r.NrSerie
            from result r 
            inner join person p on p.PersonId = r.PersonId
            inner join competition c on c.CompetitionId = r.CompetitionId
            inner join season s on Year(c.StartDate) = s.Year
            left join shooterxseason x on x.PersonId = r.PersonId and x.SeasonId = s.SeasonId 
            
            where r.ResultId = $ResultId";
            return DB::select($sql);
        }
        

}

