<?php

namespace App\Models\Dictionaries;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class ModuleConfiguration extends BObject{

  
    public function MasterKeyField(){
        return 'ModuleConfigurationId';
    } 


    public $MasterSelect = "SELECT ModuleConfigurationId, Name, Code, DefaultValue, Description, DataType
                FROM moduleconfiguration m
                where 1 = 1 :filter
                order by m.Name";

    public $MasterItemSelect = "SELECT ModuleConfigurationId, Name, Code, DefaultValue, Description, DataType
            FROM moduleconfiguration m
                where ModuleConfigurationId = :ModuleConfigurationId";
                            

    public $MasterInsert = " insert into moduleconfiguration(Name, DefaultValue, Description, DataType, Code)
                        values 
                        (':Name', ':DefaultValue', ':Description', ':DataType', ':Code'); " ;         
   

    public $MasterUpdate = " update moduleconfiguration set Name = ':Name', DefaultValue = ':DefaultValue', 
                    Description = ':Description', DataType = ':DataType', Code = ':Code'
                     where ModuleConfigurationId = :ModuleConfigurationId;";

    public $MasterDelete = "  delete from moduleconfiguration
                        where ModuleConfigurationId = :ModuleConfigurationId ";


    //--------


   


}
