<?php

namespace App\Models\Dictionaries;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class ModuleConfigurationValues extends BObject{

  
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


    
    public function  DetailFields(){
        return ['Value;s'];
    } 

    public $DetailSelect = "SELECT c.`ModuleConfigurationId`, x.`ModuleId`, c.`Name`, c.`DefaultValue`, c.`Description`, c.`DataType`, v.Value,
                c.Code
                FROM moduleconfiguration c
                inner join modulexmoduleconfiguration x on c.ModuleConfigurationId = x.ModuleConfigurationId
                left join moduleconfigurationvalues v on x.ModuleConfigurationId = v.ModuleConfigurationId and 
                                x.ModuleId = v.ModuleId and v.OrganizationId = :_OrganizationId_
                where x.ModuleId = :ModuleId";


    public $DetailInsert = "";

    public $DetailUpdate = "
          
            IF EXISTS (select 1 from moduleconfigurationvalues where 
                ModuleConfigurationId = :ModuleConfigurationId and OrganizationId = :_OrganizationId_ and ModuleId = :ModuleId) then
                update moduleconfigurationvalues set Value = ':Value' where 
                ModuleConfigurationId = :ModuleConfigurationId and OrganizationId = :_OrganizationId_ and ModuleId = :ModuleId;
            else
                insert into moduleconfigurationvalues (ModuleConfigurationId, OrganizationId, ModuleId ,Value) values 
                (:ModuleConfigurationId , :_OrganizationId_, :ModuleId, ':Value');
            END IF;";
    public $DetailDelete = " "  ;




}
