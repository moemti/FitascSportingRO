<?php

namespace App\Models\Dictionaries;
use Illuminate\Support\Facades\DB;


class Partner{

    public static function getList($OrganizationId){
        $sql = "SELECT p.OrganizationId, p.Name, p.IsCustomer, p.IsSupplier, p.InvoiceDescription
                from
                organization p
                where p.ParentOrganizationId = {$OrganizationId}
                order by p.Name";

        return  DB::select($sql);
    }

    public static function SavePartner($ParentOrganizationId, $OrganizationId, $Name, $IsCustomer, $IsSupplier, $InvoiceDescription)
    {
        try {
            if (!isset($OrganizationId)) {

                $sql = "INSERT INTO `organization`( `ParentOrganizationId`, `Name`, `IsCustomer`, IsSupplier, InvoiceDescription)
                        values ({$ParentOrganizationId}, '{$Name}', {$IsCustomer}, {$IsSupplier} , '{$InvoiceDescription}')";

                DB::select($sql);

                $sql = " select LAST_INSERT_ID() as OrganizationId";

                $OrganizationId = DB::select($sql)[0]->OrganizationId;


            } else {


                $sql = "UPDATE `organization` SET
                        `Name`='{$Name}', IsCustomer =  {$IsCustomer}, IsSupplier =  {$IsSupplier}, InvoiceDescription = '{$InvoiceDescription}'
                        WHERE OrganizationId = {$OrganizationId}";

                DB::select($sql);

            }
        }
        catch(\Exception $e){
                DB::rollBack();
                throw $e;
            }

        return self::getpartner($OrganizationId);
    }

    public static function getpartner($OrganizationId){
        $sql = "SELECT OrganizationId, Name, IsCustomer, IsSupplier, InvoiceDescription, InvoiceDescription
                from organization
                 where OrganizationId = {$OrganizationId}";
        return DB::select($sql);

    }

    public static function deletepartner($OrganizationId){
        $sql = "delete from organization
                where OrganizationId = {$OrganizationId}"  ;
        return DB::select($sql);
    }






}
