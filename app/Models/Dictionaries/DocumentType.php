<?php

namespace App\Models\Dictionaries;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class DocumentType extends BObject{

  
    public function MasterKeyField(){
        return 'DocumentTypeId';
    } 

    public function  DetailKeyField(){
        return 'DocumentStateId';
    }

 

    public $MasterSelect = "SELECT `DocumentTypeId`, `Name`, `Code`, Category FROM `documenttype`
                WHERE OrganizationId = :_OrganizationId_ order by Category"  ;

    public $MasterItemSelect = "SELECT `DocumentTypeId`, `Name`, `Code`, Category FROM `documenttype`
                    WHERE DocumentTypeId = :DocumentTypeId "  ;
                            

    public $MasterInsert = "INSERT INTO documenttype (Name, Code, Category) values  (':Name', ':Code', ':Category')";            
   

    public $MasterUpdate = "UPDATE `documenttype` set Name = ':Name', Code = ':Code', Category = ':Category' where DocumentTypeId = :DocumentTypeId";

    public $MasterDelete = "delete from documenttype
            where DocumentTypeId = :DocumentTypeId"  ;


    public $DetailSelect = "SELECT `DocumentTypeId`, `Name`, `Code`, DocumentStateId, IsInitial FROM `documentstate`
                        WHERE DocumentTypeId = :DocumentTypeId" ;


    public $DetailInsert = "INSERT INTO documentstate ( `DocumentTypeId`, `Name`, `Code`, `OrganizationId`, `IsInitial`) 
                            values (:DocumentTypeId, ':Name', ':Code', :_OrganizationId_, :IsInitial)";

    public $DetailUpdate = "UPDATE `documentstate` SET DocumentTypeId = :DocumentTypeId ,`Name`=':Name',`Code`=':Code',`IsInitial`= :IsInitial
            WHERE `DocumentStateId`=:DocumentStateId           ";

    public $DetailDelete = " DELETE FROM `documentstate` WHERE DocumentStateId = :DocumentStateId"  ;

        //  --------------------------------  \\
       //           ---------------            \\

    public function getMasterOthers($ItemId, $OrganizationId){
        return $this->getDocumentSerials($ItemId);
    }

    public static function getDocumentSerials($DocumentTypeId){
        $sql = "SELECT SerialId, DocumentTypeId, Serial, IsActive, StartDate, EndDate, LastNumber, Format
                FROM serials where DocumentTypeId = {$DocumentTypeId} " ;
        return DB::select($sql);
    }

    public function afterSaveInTran($ItemId, $fields){
        $Serials = $fields['deltaS'];
        if (is_array($Serials)){
            foreach($Serials as $serial){

             

                $SerialId = arrayValue($serial, 'SerialId');
                $Serial = arrayValue($serial, 'Serial', 'string');
                $Format = arrayValue($serial, 'Format', 'string');
                $StartDate = arrayValue($serial, 'StartDate','date');
                $EndDate = arrayValue($serial, 'EndDate', 'date');
                $LastNumber = arrayValue($serial, 'LastNumber');
                $IsActive = arrayValue($serial, 'IsActive');

                if ($serial['Operation'] == 'I'){

                    $sql = "INSERT INTO serials
                            (DocumentTypeId, Serial, IsActive, StartDate, EndDate, LastNumber, Format)
                            VALUES({$ItemId}, {$Serial}, {$IsActive}, {$StartDate},{$EndDate}, {$LastNumber}, {$Format})";
                };

                if ($serial['Operation'] == 'U'){

                    $sql = "UPDATE serials
                                SET Serial={$Serial}, IsActive = {$IsActive}, StartDate={$StartDate}, 
                                EndDate={$EndDate}, LastNumber={$LastNumber}, Format={$Format}
                    WHERE SerialId = {$SerialId}";
                };

                if ($serial['Operation'] == 'D'){

                    $sql = "delete from serials
                            where SerialId = {$SerialId}";
                };

                DB::select($sql);
            }
        }
    }


}
