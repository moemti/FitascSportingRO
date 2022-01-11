<?php

namespace App\Models\Dictionaries;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class Article extends BObject{

    const MasterKeyField = 'ArticleId';  

    const MasterFields = ['Name;s', 'Code;s', 'IsActive', 'OrganizationId', 'VATCodeId', 'ArticleCategoryId'];

    const FilterSource=[
        ['label'=> 'Article name', 'value'=> 'a.Name', 'type'=> 'string' ],
        ['label'=> 'Article code', 'value'=> 'a.Code', 'type'=> 'string' ],
       
    ];

    const CustomFilters=[
    ];

    const DefaultMasterValues = ['VATCodeId'=>1];




    public static function getList($OrganizationId, $filter){
        if ($filter != ''){
            $filter = " and ".$filter;
        }

        $sql = "SELECT ArticleId, Name, Code, IsActive, OrganizationId, VATCodeId, ArticleCategoryId
                    FROM article a
                where a.OrganizationId = {$OrganizationId} {$filter}
                order by a.Name";

        return  DB::select($sql);
    }

    public static function SaveItem($fields){
    
        $MasterKey = static::MasterKeyField;

        try {
            if ((!isset($fields[$MasterKey])) || ($fields[$MasterKey]== "")) {

                $sqlValues = self::getFieldValues($fields, static::MasterFields, false, true);

                $sql = "INSERT INTO article
                            (Name, Code, IsActive, OrganizationId, VATCodeId, ArticleCategoryId)
                            VALUES({$sqlValues})";
                               
                DB::select($sql);

                $sql = " select LAST_INSERT_ID() as ItemId";

                $ItemId = DB::select($sql)[0]->ItemId;


            } else {
                $ItemId = $fields[$MasterKey];

                $sqlValues = self::getFieldValues($fields, static::MasterFields, false, false);

                $sql = "UPDATE `article` SET
                      {$sqlValues} where {$MasterKey} = {$ItemId}";

                DB::select($sql);
              
            }
        }
        catch(\Exception $e){
                DB::rollBack();
                throw $e;
            }

        return self::getItem($ItemId);
    }

    public static function getItem($ItemId){
        $sql = "SELECT ArticleId, Name, Code, IsActive, OrganizationId, VATCodeId, ArticleCategoryId
                    FROM article a
                    where a.ArticleId = {$ItemId} ";

        return DB::select($sql);

    }

    public static function deleteItem($ItemId){
        $sql = "delete from article
                where ArticleId = {$ItemId}"  ;
        return DB::select($sql);
    }



    //=================================  maybe to do a general function  ==============

}
