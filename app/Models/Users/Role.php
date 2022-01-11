<?php


namespace App\Models\Users;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;



class Role extends BObject{
    
    public function MasterKeyField(){
        return 'RoleId';
    }

    public function DetailKeyField(){
        return 'PermissionRoleId';
    }
    
    public $MasterSelect = "select `RoleId`, `Name`, `Code`, `OrganizationId` FROM `role`
                             where OrganizationId = :_OrganizationId_ 
                             order by Name"; 

    public $MasterItemSelect =  "select `RoleId`, `Name`, `Code`, `OrganizationId` FROM `role`
                            where RoleId = :RoleId "; 
                                        

    public $MasterInsert =  "INSERT INTO `role`(`RoleId`, `Name`, `Code`, `OrganizationId` )
                                values (:RoleId, ':Name', ':Code', :_OrganizationId_ )";


    public $MasterUpdate = "UPDATE `role` SET
                            `Code`= ':Code', `Name`=':Name'
                            WHERE RoleId = :RoleId";

    public $MasterDelete = "delete from role
                            WHERE RoleId = :RoleId";
    
    // detail

       
    // punem old si new pentru a sti care a fost OLD la update/delete si NEW pentru insert/update
    public $DetailSelect = "select r.PermissionRoleId, r.ActionId, r.PermissionType, 
                            a.Name as Action, 
                            case when PermissionType = 1 then 'Permitted' else 'Denied' end as PermissionTypeS
                            from permissionrole r 
                            inner join action a on a.ActionId = r.ActionId
                            where r.RoleId = :RoleId"  ;


    public $DetailInsert = "insert into permissionrole (`ActionId`, `RoleId`, `PermissionType`) 
                            values (:ActionId, :RoleId, :PermissionType) ";        
    


    public $DetailUpdate = "update  permissionrole 
                            set ActionId = :ActionId, 
                                RoleId = :RoleId, 
                                PermissionType = :PermissionType  
                            where PermissionRoleId = :PermissionRoleId";   

    public $DetailDelete = "delete from permissionrole
                            where PermissionRoleId = :PermissionRoleId"; 

    
}