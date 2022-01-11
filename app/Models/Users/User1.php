<?php


namespace App\Models\Users;
use Illuminate\Support\Facades\DB;


class User{
    
    //===================  Persons  ====================================
    
    public static function getPersons($OrganizationId){
        $sql = "SELECT p.PersonId, p.Name, p.Email, GROUP_CONCAT(f.Name SEPARATOR ', ') as Role 
                from person p
                left join personxrole x on x.PersonId = p.PersonId
                left join role f on f.RoleId = x.RoleId
                where p.OrganizationId = {$OrganizationId}
                group by  p.PersonId, p.Name, p.Email
                order by p.Name"  ;
        return DB::select($sql);
    }
    
    public static function getRoles($OrganizationId){
        $sql = "SELECT Name, Code, RoleId from role f
                where f.OrganizationId = {$OrganizationId}
                order by f.Name"  ;
        return DB::select($sql);
    }
    
    
    public static function getPerson($PersonId){
        
        $sql = "SELECT p.PersonId, p.Name, p.Email, GROUP_CONCAT(f.Name SEPARATOR ', ') as Role 
                from person p
                left join personxrole x on x.PersonId = p.PersonId
                left join role f on f.RoleId = x.RoleId
                 where p.PersonId = {$PersonId}
                group by  p.PersonId, p.Name, p.Email"  ;
              
        return DB::select($sql);
    }
    
    
    public static function getPersonRoles($PersonId){
        
        $sql = "SELECT x.PersonId, f.RoleId, f.Name as Role
                from  personxrole x 
                inner join role f on f.RoleId = x.RoleId
                where x.PersonId = {$PersonId}
                order by f.Name"  ;
        
        return DB::select($sql);
    }
    
    
    public static function SavePerson($OrganizationId, $Name, $PersonId, $Email, $PersonRoles){
        DB::beginTransaction();
        
        try{
            if (!isset($PersonId)){
                
                $sql = "INSERT INTO `person`( `OrganizationId`, `Name`, `Email`)
                        values ({$OrganizationId}, '{$Name}', '{$Email}')";
                
                DB::select($sql);
                
                $sql = " select  LAST_INSERT_ID() as PersonId";
                
                $PersonId = DB::select($sql)[0]->PersonId;
                
                
            }
            
            else{
                
                
                $sql = "UPDATE `person` SET
                        `Email`= '{$Email}', `Name`='{$Name}'
                        WHERE PersonId = {$PersonId}";
                
                DB::select($sql);
                
            }
            
            
            // roles
            
            if (is_array($PersonRoles)){
                foreach($PersonRoles as $role){
                    
                    if ($role['Operation'] == 'I'){
                        
                        $PersonId = $role['PersonId'];
                        $RoleId = $role['RoleId'];
                        
                        $sql = "INSERT INTO `personxrole`(`PersonId`, `RoleId`) values(
                                {$PersonId}, {$RoleId} )";
                    };
                    
                    if ($role['Operation'] == 'U'){
                        
                        $RoleId = $role['RoleId'];
                        $OldRoleId = $role['OLD_RoleId'];
                        $PersonId = $role['PersonId'];
                        
                        $sql = "update `personxrole`
                                    set RoleId = {$RoleId}
                                   
                                where RoleId = {$OldRoleId} and PersonId = {$PersonId}";
                    };
                    
                    if ($role['Operation'] == 'D'){
                        
                        $PersonId = $role['PersonId'];
                        $RoleId = $role['RoleId'];
                        $OldRoleId = $role['OLD_RoleId'];
                        
                        $sql = "delete from `personxrole`
                                 where RoleId = {$OldRoleId} and PersonId = {$PersonId}";
                    };
                    
                    DB::select($sql);
                }
            }
            
            
            
            DB::commit();
        }
        
        
        catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        
        return self::getPerson($PersonId);
        
    }

    public static function deletePerson($PersonId){
        $sql = "delete from person
                where PersonId = {$PersonId}"  ;
        return DB::select($sql);
    }

   
    
    //====================  Roles  =============================

    
    
    public static function getrole($roleId){
        
        $sql = "Select `RoleId`, `Name`, `Code`, `OrganizationId` FROM `role`
                 where RoleId = {$roleId}"  ;
        
        return DB::select($sql);
    }
    
    public static function Saverole($OrganizationId, $Name, $roleId, $Code, $RolePermissions){
        DB::beginTransaction();
        
        try{
            if (!isset($roleId)){
                
                $sql = "INSERT INTO `role`(`RoleId`, `Name`, `Code`, `OrganizationId` )
                        values ({$roleId} '{$Name}', '{$Code}', {$OrganizationId})";
                
                DB::select($sql);
                
                $sql = " select  LAST_INSERT_ID() as RoleId";
                
                $roleId = DB::select($sql)[0]->RoleId;
                
                
            }
            
            else{
                $sql = "UPDATE `role` SET
                        `Code`= '{$Code}', `Name`='{$Name}'
                        WHERE RoleId = {$roleId}";
                
                DB::select($sql);
                
            }
            
            if (is_array($RolePermissions)){
                  foreach($RolePermissions as $P){

                    if ($P['Operation'] == 'I'){
                        
                        $sql = "insert into permissionrole (`ActionId`, `RoleId`, `PermissionType`) 
                                values ({$P['ActionId']}, {$roleId}, {$P['PermissionType']})                        
                        ";
                    }

                    if ($P['Operation'] == 'U'){
                        
                        $sql = "update  permissionrole 
                               set ActionId = {$P['ActionId']}, 
                                     RoleId = {$roleId}, 
                                     PermissionType = {$P['PermissionType']}  
                                where PermissionRoleId = {$P['PermissionRoleId']}                    
                        ";
                    }

                    if ($P['Operation'] == 'D'){
                        
                        $sql = "delete from permissionrole
                            where PermissionRoleId = {$P['PermissionRoleId']} ";  
                    }
               }

               DB::select($sql);
            }



            
            DB::commit();
        }
        
        
        catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        
        return self::getrole($roleId);
        
    }
    
    public static function deleterole($roleId){
        $sql = "delete from role
                where RoleId = {$roleId}"  ;
        return DB::select($sql);
    }
    
    public static function getrolepermissions($roleid){
        $sql = "select r.PermissionRoleId, r.ActionId, r.PermissionType, 
        a.Name as Action, 
        case when PermissionType = 1 then 'Permitted' else 'Denied' end as PermissionTypeS
        from permissionrole r 
        inner join action a on a.ActionId = r.ActionId
        where r.RoleId = {$roleid}"  ;

        return DB::select($sql);
    }
    
    //===================  Users  ====================================
    
    public static function getusers($OrganizationId){
        $sql = "SELECT u.PersonId, u.UserName, u.Password, p.Name
                from user u
                inner join person p on p.PersonId = u.PersonId
                where p.OrganizationId = {$OrganizationId}
                order by p.Name"  ;
        return DB::select($sql);
    }
    
    
    public static function getuser($userId){
        
        $sql = "SELECT u.PersonId, u.UserName, u.Password  
                from user u
                 where u.PersonId = {$userId}"  ;
        
        return DB::select($sql);
    }
    
    public static function Saveuser($OrganizationId, $UserName, $userId, $Password){
        DB::beginTransaction();
        
        try{
            if (!isset($userId)){
                
                $sql = "INSERT INTO `user`( PersonId, `UserName`,  `Password`)
                        values ({$userId}, '{$UserName}', '{$Password}')";
                
                DB::select($sql);
                
                $sql = " select  LAST_INSERT_ID() as userId";
                
                $userId = DB::select($sql)[0]->userId;
                
                
            }
            
            else{
                
                
                $sql = "UPDATE `user` SET
                        `UserName`= '{$UserName}', `Password`='{$Password}'
                        WHERE PersonId = {$userId}";
                
                DB::select($sql);
                
            }
            
            
            
            DB::commit();
        }
        
        
        catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        
        return self::getuser($userId);
        
    }
    
    public static function deleteuser($userId){
        $sql = "delete from user
                where PersonId = {$userId}"  ;
        return DB::select($sql);
    }
    
    
}