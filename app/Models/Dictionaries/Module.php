<?php

namespace App\Models\Dictionaries;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class Module extends BObject{

  
    public function MasterKeyField(){
        return 'ModuleId';
    } 

    public function  DetailKeyField(){
        return 'ModuleConfigurationId';
    }

    public function MasterFields() {
        return  ['Name;s', 'Code;s'];
    }

    public $MasterSelect = "SELECT ModuleId, Name, Code
                FROM module m
                where 1 = 1 :filter
                order by m.Name";

    public $MasterItemSelect = "SELECT ModuleId, Name, Code
                FROM module m
                where ModuleId = :ModuleId";
                            

    public $MasterInsert = "INSERT INTO module (Name, Code) values  (':Name', ':Code')";            
   

    public $MasterUpdate = "UPDATE `module` set Name = ':Name', Code = ':Code' where ModuleId = :ModuleId";

    public $MasterDelete = "delete from module
            where ModuleId = :ModuleId"  ;


    //--------


    
  // punem old si new pentru a sti care a fost OLD la update/delete si NEW pentru insert/update
    public $DetailSelect = "SELECT c.`ModuleConfigurationId`, x.`ModuleId`, c.`Name`, c.`ModuleConfigurationId` as OLD_ModuleConfigurationId,
                        c.`ModuleConfigurationId` as NEW_ModuleConfigurationId
                FROM moduleconfiguration c
                inner join modulexmoduleconfiguration x on c.ModuleConfigurationId = x.ModuleConfigurationId

                where x.ModuleId = :ModuleId";


    public $DetailInsert = "insert into modulexmoduleconfiguration( ModuleConfigurationId, ModuleId) 
            values(:NEW_ModuleConfigurationId, :ModuleId)";

    public $DetailUpdate = "update modulexmoduleconfiguration set ModuleConfigurationId = :NEW_ModuleConfigurationId 
                    where ModuleId = :ModuleId and ModuleConfigurationId = :OLD_ModuleConfigurationId";

    public $DetailDelete = " delete from modulexmoduleconfiguration where ModuleConfigurationId = :OLD_ModuleConfigurationId and ModuleId = :ModuleId"  ;


    public function getConfigurations(){
        $sql = "SELECT c.`ModuleConfigurationId`, c.`Name`, c.`DefaultValue`, c.`Description`, c.`DataType`
            FROM moduleconfiguration c order by Name";
        return DB::select($sql);
        
    }

}
