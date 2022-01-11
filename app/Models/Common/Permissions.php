<?php 


namespace App\Models\Common;
use Illuminate\Support\Facades\DB;


class Permissions 
{

    const MasterFields = ['ActionId', 'Name', 'Code'];

    const FilterSource=[
        ['label'=> 'Action name', 'value'=> 'Name', 'type'=> 'string' ],
        ['label'=> 'Action code', 'value'=> 'Code', 'type'=> 'string' ]
    ];

    const CustomFilters=[
       
        ['Caption'=> 'All actions!!!',  'Filter'=> '1=1', 'Label'=>'All', 'Warning' => 'Doriti sa aduceti toate inregistrarile !?!' ],
       
    ];

    public static function IsSuperUser(){
        if (session('IsSuperUser') == 1)
            return "true";
        else    
            return "false"; 
    }

    public static function hasPermission($action = null){

        $PersonId = session('PersonId');
        $OrganizationId = session('organizationId');

        return self::getPermission($action, $PersonId, $OrganizationId);
    }


    public static function GetDeniedModulePermissions($personid, $ModuleCode){
        

        if ($personid == null)
            $personid = 'null';

        $sql = "SELECT coalesce(pp.PermissionType, r.PermissionType, 0) as PermissionType,
                 replace(a.Code, '{$ModuleCode}.', '') as Code
        FROM action a


        left join (select r.PermissionType, r.ActionId
        	from permissionrole r 
        	inner join personxrole pr on pr.RoleId = r.RoleId and pr.PersonId = {$personid}
             ) r on  r.ActionId = a.ActionId 

        left join permissionperson pp on pp.ActionId = a.ActionId and pp.PersonId = {$personid}
        where a.code like '{$ModuleCode}.%' or a.code = '{$ModuleCode}' ";

        $r = DB::select($sql);

        $res = [];

        for ($i = 0; $i < count($r); $i++){
            if ($r[$i]->PermissionType == 0)
                array_push($res, $r[$i]->Code);
        };
        
        return $res;
        
        
    }
    
    private static function getPermission($action, $personid, $organizationid){

        if ($personid == null)
            $personid = 'null';


        $sql = 
        "SELECT coalesce(pp.PermissionType, r.PermissionType, 0) as PermissionType
        FROM action a
 
        left join (select r.PermissionType, r.ActionId
        	from permissionrole r 
        	inner join personxrole pr on pr.RoleId = r.RoleId and pr.PersonId = {$personid}
             ) r on  r.ActionId = a.ActionId 

        left join permissionperson pp on pp.ActionId = a.ActionId and pp.PersonId = {$personid}
        where a.Code = '{$action}' ";

        $r = DB::select($sql);
        if (count($r) > 0)
            return  $r[0]->PermissionType == 1;
        else    
            return false;
    }
    //======================================================================

    public static function getActions($Filter){
        $sql = 
            "SELECT `ActionId`, `Name`, `Code` 
            FROM `action`
            where {$Filter}
            order by Name";

        return  DB::select($sql);
    }

    public static function savePermission( $ActionId, $Name, $Code){

        if (!isset($ActionId)){
            $sql = "insert into action (Name, Code) values(
            '{$Name}', '{$Code}')";
            DB::select($sql);
            $sql = 'select LAST_INSERT_ID() as ActionId';

            $ActionId = DB::select($sql)[0]->ActionId;
        }
        else{
            $sql = "update action set Name =  '{$Name}', Code = '{$Code}'
            where ActionId = {$ActionId}";
            DB::select($sql);
        }

        return self::getAction($ActionId);

        

    }

    public static function getAction($ActionId){
        $sql = 
        "SELECT `ActionId`, `Name`, `Code` 
        FROM `action`
        where ActionId = {$ActionId}";

        return  DB::select($sql);
    }
    

    public static function deleteAction($ActionId){
        $sql = 
        "delete
        FROM `action`
        where ActionId = {$ActionId}";

        return  DB::select($sql);
    }
    
}