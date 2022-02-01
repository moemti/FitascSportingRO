<?php

namespace App\Models\Users;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class Person extends BObject{

    protected $IsInsertUnprepared = true; // true if multiple statements etc
    protected $IsUpdateUnprepared = true; // true if multiple statements etc
    protected $IsDeleteUnprepared = true; // true if multiple statements etc
  
    public function MasterKeyField(){
        return 'PersonId';
    } 

    public function  DetailKeyField(){
        return 'RoleId';
    }


    public $MasterSelect = 
                "SELECT p.PersonId, p.Name, p.Email, GROUP_CONCAT(f.Name SEPARATOR ', ') as Role , p.NickName
                from person p
                left join personxrole x on x.PersonId = p.PersonId
                left join role f on f.RoleId = x.RoleId
                where p.OrganizationId = :_OrganizationId_ :filter
                group by  p.PersonId, p.Name, p.Email, p.NickName
                order by p.Name"  ;

    public $MasterItemSelect = "SELECT p.PersonId, p.Name, p.Email, GROUP_CONCAT(f.Name SEPARATOR ', ') as Role , p.NickName
                from person p
                left join personxrole x on x.PersonId = p.PersonId
                left join role f on f.RoleId = x.RoleId
                where p.PersonId = :PersonId
                group by  p.PersonId, p.Name, p.Email, p.NickName"  ;
                                        

    public $MasterInsert = "INSERT INTO person( OrganizationId, Name, Email, NickName)
                                values (:_OrganizationId_, ':Name', ':Email', ':NickName');


                            
                                ";         
   

    public $MasterUpdate = "UPDATE `person` SET
                        `Email`= ':Email', `Name`=':Name', NickName = ':NickName'
                        WHERE PersonId = :PersonId;
                        
                        update personparam set Price = :Price 
                        where PersonId = :PersonId;
                        ";

    public $MasterDelete = "
                delete from personxparam
                where PersonId = :PersonId;

                delete from person
            where PersonId = :PersonId"  ;


    //-------- details -------------


    
    // punem old si new pentru a sti care a fost OLD la update/delete si NEW pentru insert/update
    public $DetailSelect = "SELECT x.PersonId, f.RoleId, f.Name, f.RoleId as OLD_RoleId, f.RoleId as NEW_RoleId
                from  personxrole x 
                inner join role f on f.RoleId = x.RoleId
                where x.PersonId = :PersonId
                order by f.Name"  ;


    public $DetailInsert = "INSERT INTO `personxrole`(`PersonId`, `RoleId`) 
            values(:PersonId, :NEW_RoleId)";

    public $DetailUpdate = "update `personxrole`
                         set RoleId = :NEW_RoleId
                        where RoleId = :OLD_RoleId and PersonId = :PersonId";    

    public $DetailDelete = "delete from `personxrole`
                        where RoleId = :OLD_RoleId and PersonId = :PersonId";

    public function getroles($OrganizationId){
        $sql = "Select `RoleId`, `Name`, `Code`, `OrganizationId` FROM `role`
            where OrganizationId = {$OrganizationId} order by Name"  ;

        return DB::select($sql);
        
    }



    public function OnSaveError($e){
       
        $message = $e->getMessage();
        if (strpos($message, 'Integrity constraint violation: 1062 Duplicate entry') && strpos($message, "for key 'Email'")){
            throw new \Exception('Email-ul introdus mai exista la un alt utilizator!');
        }
 
    }

    // parametrii

    public function getMasterOthers($ItemId, $OrganizationId){
        return $this->getPersonParams($ItemId);
    }

    public function getParams($TableUses){
        $sql = "select ParamId, Name, Description, Type 
        from param
        where TableUses = '{$TableUses}' 
        order by Name"  ;

    return DB::select($sql); 
    }
    
    public function getPersonParams($PersonId){
      
            $sql = "SELECT pp.*, p.Name as ParamName FROM personxparam pp inner join param p on p.ParamId = pp.ParamId
                    where PersonId = {$PersonId} " ;
            return DB::select($sql);
    }
    
    public function afterSaveInTran($ItemId, $fields){
         
        if (!array_key_exists ('deltaOthers1', $fields))
            return;


        $Params = $fields['deltaOthers1'];
        if (is_array($Params)){
            foreach($Params as $param){

             

                $PersonId = arrayValue($param, 'PersonId');
                if ($PersonId =='')
                    $PersonId = $ItemId;

                $ParamId = arrayValue($param, 'ParamId');
                $StartDate = arrayValue($param, 'StartDate', 'date');
                $EndDate = arrayValue($param, 'EndDate','date');
                $Value = arrayValue($param, 'Value', 'string');
                $PersonXParamId = arrayValue($param, 'PersonXParamId');
 

                if ($param['Operation'] == 'I'){

                    $sql = "INSERT INTO personxparam
                            (PersonId, ParamId, StartDate,  EndDate, Value)
                            VALUES({$PersonId}, {$ParamId}, {$StartDate}, {$EndDate},{$Value})";
                };

                if ($param['Operation'] == 'U'){

                    $sql = "UPDATE personxparam
                                SET ParamId={$ParamId}, StartDate = {$StartDate}, EndDate={$EndDate}, 
                                Value={$Value}
                    WHERE PersonXParamId = {$PersonXParamId}";
                };

                if ($param['Operation'] == 'D'){

                    $sql = "delete from personxparam
                    WHERE PersonXParamId = {$PersonXParamId}";
                };

                DB::select($sql);
            }
        }
    }
    
    public function getMyUser($PersonId){
        $sql = "SELECT p.PersonId, p.Name, p.Email, GROUP_CONCAT(f.Name SEPARATOR ', ') as Role , p.NickName, u.IsSuperUser
        from person p
        inner join user u on u.PersonId = p.PersonId
        left join personxrole x on x.PersonId = p.PersonId
        left join role f on f.RoleId = x.RoleId
        
        where p.PersonId = $PersonId
        group by  p.PersonId, p.Name, p.Email, p.NickName,  u.IsSuperUser";
        
        return DB::select($sql); 
    }

    public function saveMyUser($request){

        $PersonId = $request['PersonId'];
        $Email = $request['Email'];
        $Name = $request['Name'];
        $NickName = $request['NickName'];

        $sql = "update person 
                set Email = '$Email',
                Name = '$Name',
                NickName = '$NickName'
            where PersonId = $PersonId";
        
        DB::select($sql); 

        return $this->getMyUser($PersonId)[0];
    }

    public function setPassword($PersonId, $password){
        $sql = "update user set Password = '$password' where PersonId = $PersonId";

        DB::select($sql);
    }

    //====================================================================================

    static public function getPersonParamsAll($PersonId){



        $sql = "
        SELECT Cat.Value as Category , Price.Value as Price, 0 as Percent, 0 as PercentLast, '' as CategoryLast, Clay.Value, Clay.Cant, Value_Y, Cant_Y
        from person pe

        left join 
            (select pp.Value, pp.PersonId from personxparam pp
            inner join param p on p.ParamId = pp.ParamId and p.Name = 'ShooterCategory' and now() between pp.StartDate and ifnull(pp.EndDate, '21000101')
            )as Cat  on Cat.PersonId = pe.PersonId 
                
        left join 
            (select pp.Value, pp.PersonId from personxparam pp
            inner join param p on p.ParamId = pp.ParamId and p.Name = 'Price25' and now() between pp.StartDate and ifnull(pp.EndDate, '21000101')
            )as Price  on Price.PersonId = pe.PersonId 
               
               
         left join 
            (select sum(Price*Qty) as Value , sum(Qty) as Cant, PersonId , sum(Price*Qty * case when year(Date) = year(now()) then 1 else 0 end ) Value_Y , sum(Qty * case when year(Date) = year(now()) then 1 else 0 end ) as Cant_Y
             from clubtransaction t where IsClay = 1 group by PersonId
            )as Clay  on Clay.PersonId = pe.PersonId 
                      
            where pe.PersonId = {$PersonId} 
                ";


        $r = DB::select($sql);
        if (count($r) > 0)
            return $r[0];
        else
            return null ;
}
    

}
