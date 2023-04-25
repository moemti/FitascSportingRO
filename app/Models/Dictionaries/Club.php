<?php

namespace App\Models\Dictionaries;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class Club extends BObject{

    protected $IsInsertUnprepared = true; // true if multiple statements etc
    protected $IsUpdateUnprepared = true; // true if multiple statements etc
    protected $IsDeleteUnprepared = true; // true if multiple statements etc
  
    public function MasterKeyField(){
        return 'TeamId';
    } 
   

    public $MasterSelect =
                "SELECT `TeamId`, `Name`, `Description`, `IsActive` FROM `team` 
                order by Name"  ;

    public $MasterItemSelect = "SELECT `TeamId`, `Name`, `Description`, `IsActive` FROM `team`  
                where TeamId = :TeamId" ;
                                        

    public $MasterInsert = "INSERT INTO `team`(`Name`, `Description`, `IsActive`) 
                                values ( ':Name', ':Description', :IsActive)";         
   

    public $MasterUpdate = "UPDATE `team` SET
                        `Name`= ':Name', 
                        `Description`= ':Description', 
                        IsActive = :IsActive
                        WHERE TeamId = :TeamId;
                        ";


    public function echivalareclub($badId, $goodId){
        try {
            DB::beginTransaction();
            DB::select('call spConcatTeams( ?, ?)', [$badId, $goodId]);
            DB::commit();
        }
        catch(\Exception $e){
                DB::rollBack();
            return $e;
        }
    }

}
