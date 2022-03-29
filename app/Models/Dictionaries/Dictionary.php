<?php

namespace App\Models\Dictionaries;
use Illuminate\Support\Facades\DB;


class Dictionary{

    public static function getList($OrganizationId, $DictionaryId){
        $sql = "SELECT ed.Name, ed.Code, ed.Description, ed.DictionaryId, ed.ElemDictionaryId, ed.IsActive, ed.ParentId, ed.Description, ed.ElemDictionaryId as id, ed.Value
                from
                elemdictionary ed 
                where ed.OrganizationId = {$OrganizationId} and ed.DictionaryId = '{$DictionaryId}' 
                order by ed.Name";

        return  DB::select($sql);
    }

    public static function getDictionaryId($Code){
        $sql = "SELECT d.DictionaryId
                from
                dictionary d
                where d.Code = '{$Code}'";
               
        
        return  DB::select($sql)[0]->DictionaryId;
    }
    
    
    public static function SaveDictionary($OrganizationId, $dictionaryid, $elemdictionaryid, $Name, $Code, $Description, $IsActive, $ParentId)
    {
        
        $ParentId = sqlnull($ParentId);
        
        
        if (($ParentId != '') && ($ParentId == $elemdictionaryid))
            throw new \Exception("The parent cannot be the same as the element!");          
        
        try {
            if (!isset($elemdictionaryid)) {

                $sql = "INSERT INTO `elemdictionary`( `DictionaryId`, `OrganizationId`, `ParentId`, `Name`, `Code`, `Description`, `IsActive`)
                        values ({$dictionaryid}, {$OrganizationId}, {$ParentId}, '{$Name}', '{$Code}', '{$Description}', {$IsActive} )";

                DB::select($sql);

                $sql = " select LAST_INSERT_ID() as ElemDictionaryId";

                $elemdictionaryid = DB::select($sql)[0]->ElemDictionaryId;


            } else {

                
                $sql = "call checkParentChildDictionary({$elemdictionaryid}, {$ParentId})";
                    
                $response = DB::select($sql)[0]->Response;
                
                if ($response != "OK")
                    throw new \Exception($response);     
                
                

                $sql = "UPDATE `elemdictionary` SET
                        `Name`='{$Name}',
                        `Code`='{$Code}', 
                        `Description`='{$Description}',  
                        IsActive =  {$IsActive}, 
                        ParentId =  {$ParentId}
                        WHERE ElemDictionaryId = {$elemdictionaryid}";

                DB::select($sql);

            }
        }
        catch(\Exception $e){
                DB::rollBack();
                throw $e;
        }

        return self::getdictionary($elemdictionaryid);
    }

    public static function getdictionary($elemdictionaryid){
        $sql =  "SELECT ed.Name, ed.Code, ed.Description, ed.DictionaryId, ed.ElemDictionaryId, ed.IsActive, ed.ParentId, ed.Description, edp.Name as Parent
                from
                elemdictionary ed
                left join elemdictionary edp on ed.ParentId = edp.ElemDictionaryId
                where ed.ElemDictionaryId = '{$elemdictionaryid}'
                order by ed.Name";
        return DB::select($sql);

    }

    public static function deletedictionary($elemdictionaryid){
        $sql = "delete from elemdictionary
                where ElemDictionaryId = {$elemdictionaryid}"  ;
        return DB::select($sql);
    }

    //==================  dictionaries  ====================================

    public static function getCurrencies(){
        $sql = "SELECT `CurrencyId`, `Name`, `Symbol` FROM `currency` order by Symbol"  ;
        return DB::select($sql);
    }

    public static function getCountries(){
        $sql = "SELECT `CountryId`, `Name`, `CodeSport`, Code FROM `country` order by Name"  ;
        return DB::select($sql);
    }


    public static function getDocumentSerials($DocumentCode){
        //ToDo: aici trebuie sa punem si o filtrare dupa data

        $sql = "SELECT `SerialId`,  `Serial`, `IsActive`, `StartDate`, `EndDate` , Format, LastNumber
                FROM `serials` s
                inner join documenttype t on t.DocumentTypeId = s.DocumentTypeId
                
                where t.`Code` = '{$DocumentCode}' order by Serial"  ; 
        return DB::select($sql);
    }


    public static function getDocumentSerialsById($DocumentTypeId){
        //ToDo: aici trebuie sa punem si o filtrare dupa data

        $sql = "SELECT `SerialId`,  `Serial`, `IsActive`, `StartDate`, `EndDate` , Format, LastNumber
                FROM `serials` s where DocumentTypeId = {$DocumentTypeId}
                order by Serial"  ; 
        return DB::select($sql);
    }

    public static function getPersons($OrganizationId, $role = null){
        $filter = "";

        $filter =  $role != null ? "and f.Code = '". $role ."'" : "";

        $sql = "SELECT p.PersonId, p.Name, p.Email, GROUP_CONCAT(f.Name SEPARATOR ', ') as Function 
                from person p
                left join personxrole x on x.PersonId = p.PersonId
                left join role f on f.RoleId = x.RoleId
                where p.OrganizationId = {$OrganizationId} ".$filter."
                group by  p.PersonId, p.Name, p.Email
                order by p.Name"  ;
        return DB::select($sql);
    }

    public static function getArticles($OrganizationId){
        $sql = "SELECT ArticleId, Name, VATCodeId from article a
        where a.OrganizationId = {$OrganizationId}
        order by a.Name"  ;
        return DB::select($sql);
    
    }

    public static function getArticleCategories($OrganizationId){
        $sql = "SELECT ArticleCategoryId, Name, Code, IsActive
        FROM articlecategory where OrganizationId = {$OrganizationId} ";
        return DB::select($sql);
    
    }

    

    public static function getConfiguration($OrganizationId, $Code, $Data){
        $sql = "SELECT coalesce(cd.Value, c.Value) as Value, coalesce(cd.Value2, c.Value2) as Value2
        from configuration c
        left join configurationdetail cd on cd.ConfigurationId = c.ConfigurationId and 
            '{$Data}' between cd.DateStart and IfNull(cd.DateEnd, '21000101')
        where c.OrganizationId = {$OrganizationId} and c.Code = '{$Code}'
        "  ;
        return DB::select($sql)[0];
    }

    public static function getDocumentState($OrganizationId, $DocumentTypeId, $StateCode){
        $sql = "SELECT DocumentStateId
        from documentstate d
        where d.OrganizationId = {$OrganizationId} and d.DocumentTypeId = {$DocumentTypeId} and d.Code = '{$StateCode}'" ;

        return DB::select($sql)[0]->DocumentStateId;

    }

    public static function getDictionaryItem($dictionaryCode, $dictionaryItemCode){
        $OrganizationId = session('organizationId');
        $dictionaryid = self::getDictionaryId($dictionaryCode);
        return self::getItem($OrganizationId, $dictionaryid, $dictionaryItemCode);
    }


    public static function getItem($OrganizationId, $DictionaryId, $dictionaryItemCode){
        $sql = "select ElemDictionaryId from elemdictionary where OrganizationId = {$OrganizationId} and DictionaryId = {$DictionaryId} and 
                    Code = '{$dictionaryItemCode}'";

        return DB::select($sql)[0]->ElemDictionaryId;

    }


    public static function getModuleConfig($modulecode, $configcode, $OrganizationId, $default = null){
        $sql = "SELECT coalesce(v.Value, c.DefaultValue) as Value
               
                FROM moduleconfiguration c
                inner join modulexmoduleconfiguration x on c.ModuleConfigurationId = x.ModuleConfigurationId
                inner join module m on m.ModuleId = x.ModuleId and m.Code = '{$modulecode}' and c.Code = '{$configcode}'
                left join moduleconfigurationvalues v on x.ModuleConfigurationId = v.ModuleConfigurationId and 
                                x.ModuleId = v.ModuleId and v.OrganizationId = {$OrganizationId}";
               
        $r = DB::select($sql);

        if (count($r) > 0)
            return DB::select($sql)[0]->Value; 
        else
            return $default;
    }

    public static function getSports($OrganizationId){
        $sql = "SELECT SportId, Name
        FROM sport order by Name";
        return DB::select($sql);
    
    }

    public static function getRanges($OrganizationId){
        $sql = "SELECT RangeId, Name
        FROM `range` order by Name";
        return DB::select($sql);
    
    }


}
