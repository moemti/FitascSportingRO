<?php

namespace App\Models\Competitions;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class Results extends BObject{


  
    

    const CustomFilters=[
    ];

    const DefaultMasterValues = [];


    public function MasterKeyField(){
        return 'ResultId';
    } 



    public $MasterSelect = " ";

    public $MasterItemSelect = "select p.Name, coalesce(r.ShooterCategoryId, x.ShooterCategoryId) as ShooterCategoryId, coalesce(r.TeamId, x.TeamId) as TeamId, r.Aborted, Position, Total, Percent, ResultId
            from result r 
            inner join person p on p.PersonId = r.PersonId
            inner join competition c on c.CompetitionId = r.CompetitionId
            inner join season s on Year(c.StartDate) = s.Year
            left join shooterxseason x on x.PersonId = r.PersonId and x.SeasonId = s.SeasonId 
            
            where r.ResultId = :ResultId";
                                            

    public $MasterInsert = "INSERT INTO `result`( `CompetitionId`, `PersonId`, `ShooterCategoryId`, `TeamId`, `Aborted`)
        values  ( :CompetitionId, :PersonId, :ShooterCategoryId, :TeamId, :Aborted)";            
   

    public $MasterUpdate = "UPDATE
                `result`
            SET
                `ShooterCategoryId` =:ShooterCategoryId,
                `TeamId` = :TeamId,
                `Aborted` = :Aborted
            WHERE
    
             ResultId = :ResultId";

    public $MasterDelete = "delete from result
            where ResultId = :ResultId"  ;

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
            $sql = "select p.Name, coalesce(r.ShooterCategoryId, x.ShooterCategoryId) as ShooterCategoryId, coalesce(r.TeamId, x.TeamId) as TeamId, r.Aborted, Position, Total, Percent, ResultId
            from result r 
            inner join person p on p.PersonId = r.PersonId
            inner join competition c on c.CompetitionId = r.CompetitionId
            inner join season s on Year(c.StartDate) = s.Year
            left join shooterxseason x on x.PersonId = r.PersonId and x.SeasonId = s.SeasonId 
            
            where r.ResultId = $ResultId";
            return DB::select($sql);
        }
        

}

