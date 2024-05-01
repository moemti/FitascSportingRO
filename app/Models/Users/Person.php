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
        return 'OLD_SeasonId';
    }


    public $MasterSelect = 
                "SELECT p.PersonId, p.Name, p.Email, GROUP_CONCAT(f.Name SEPARATOR ', ') as Role , p.NickName
                from person p
                left join personxrole x on x.PersonId = p.PersonId
                left join role f on f.RoleId = x.RoleId
               
                group by  p.PersonId, p.Name, p.Email, p.NickName
                order by p.Name"  ;

    public $MasterItemSelect = "SELECT p.PersonId, p.Name, p.Email, GROUP_CONCAT(f.Name SEPARATOR ', ') as Role , p.NickName, p.Code, p.CountryId, ifnull(u.IsSuperUser, 0) as IsSuperUser, 
                                case when u.PersonId is null then 0 else 1 end as HasUser,   p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma
                from person p
                left join personxrole x on x.PersonId = p.PersonId
                left join user u on u.PersonId = p.PersonId
                left join role f on f.RoleId = x.RoleId
                where p.PersonId = :PersonId
                group by  p.PersonId, p.Name, p.Email, p.NickName, p.Code, p.CountryId , ifnull(u.IsSuperUser, 0),  case when u.PersonId is null then 0 else 1 end "  ;
                                        

    public $MasterInsert = "INSERT INTO person( Name, Email, NickName, SerieNrCI, CNP, SeriePermisArma, DataExpPermis, MarcaArma, SerieArma, CalibruArma, CountryId, Code)
                                values ( ':Name', ':Email', ':NickName', ':SerieNrCI', ':CNP', ':SeriePermisArma', ':DataExpPermis', ':MarcaArma', ':SerieArma', ':CalibruArma', :CountryId, ':Code');
                                ";         
   

    public $MasterUpdate = "UPDATE `person` SET
                        `Email`= ':Email', 
                        `Name`=':Name', 
                        NickName = ':NickName', 
                        Code = ':Code', 
                        CountryId = :CountryId,
                        SerieNrCI = ':SerieNrCI',
                        CNP = ':CNP',
                        SeriePermisArma = ':SeriePermisArma',
                        DataExpPermis = ':DataExpPermis',
                        MarcaArma = ':MarcaArma',
                        SerieArma = ':SerieArma',
                        CalibruArma = ':CalibruArma'
                        WHERE PersonId = :PersonId;
                        
                       
                    

                        ";

    public $MasterDelete = "
                delete from user
                where PersonId = :PersonId;

                delete from person
            where PersonId = :PersonId"  ;


    //-------- details -------------


    
    // punem old si new pentru a sti care a fost OLD la update/delete si NEW pentru insert/update
    public $DetailSelect = "SELECT x.PersonId, x.SeasonId,  s.SeasonId as OLD_SeasonId, s.SeasonId as NEW_SeasonId,
                    x.ShooterCategoryId as OLD_ShooterCategoryId, x.ShooterCategoryId as NEW_ShooterCategoryId,
                    t.TeamId as OLD_TeamId, t.TeamId as NEW_TeamId, s.Year, sc.Name as ShooterCategory, t.Name as Team
                    from  shooterxseason x 
                    inner join season s on s.SeasonId = x.SeasonId
                    left join shootercategory sc on sc.ShooterCategoryId = x.ShooterCategoryId
                    left join team t on t.TeamId = x.TeamId
                    where x.PersonId = :PersonId
                    order by s.Year"  ;


    public $DetailInsert = "INSERT INTO `shooterxseason`(`PersonId`, `SeasonId`, `ShooterCategoryId`, `TeamId`)
                                         values(:PersonId, :NEW_SeasonId, :NEW_ShooterCategoryId, :NEW_TeamId)";

    public $DetailUpdate = "update `shooterxseason`
                         set SeasonId = :NEW_SeasonId,
                         ShooterCategoryId = :NEW_ShooterCategoryId,
                         TeamId = :NEW_TeamId
                        where SeasonId = :OLD_SeasonId and PersonId = :PersonId";    

    public $DetailDelete = "delete from `shooterxseason`
                        where SeasonId = :OLD_SeasonId and PersonId = :PersonId";

    public function getroles(){
        $sql = "Select `RoleId`, `Name`, `Code` FROM `role`
            order by Name"  ;

        return DB::select($sql);
        
    }


    public function getSeasons(){
        $sql = "Select `SeasonId`, `Year` FROM `season`
        order by 'Year'"  ;

        return DB::select($sql);
    }

    public function getTeams(){
        $sql = "SELECT `TeamId`, `Name`, `Description`, `IsActive` FROM `team` order by `Name`"  ;

        return DB::select($sql);
    }


    public function getShooterCategories(){
        $sql = "SELECT `ShooterCategoryId`, `Name`, `IsActive`, `Code` FROM `shootercategory` order by Name"  ;

        return DB::select($sql);
    }


    public function OnSaveError($e){
       
        $message = $e->getMessage();
        if (strpos($message, 'Integrity constraint violation: 1062 Duplicate entry') && strpos($message, "for key 'Email'")){
            throw new \Exception('Email-ul introdus mai exista la un alt utilizator!');
        }
 
    }

    // parametrii

    public function getMasterOthers($ItemId){
        //return $this->getPersonParams($ItemId);
        return [];
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
        $sql = "SELECT p.PersonId, p.Name, p.Email, GROUP_CONCAT(f.Name SEPARATOR ', ') as Role , p.NickName, u.IsSuperUser, xx.TeamId, CountryId,
        p.SerieNrCI, p.CNP, p.SeriePermisArma, p.DataExpPermis, p.MarcaArma, p.SerieArma, p.CalibruArma

     
        from person p
        inner join user u on u.PersonId = p.PersonId
        left join personxrole x on x.PersonId = p.PersonId
        left join role f on f.RoleId = x.RoleId
        left join shooterxseason xx on xx.Personid = p.PersonId 
        where p.PersonId = $PersonId
        group by  p.PersonId, p.Name, p.Email, p.NickName,  u.IsSuperUser";
        
        return DB::select($sql); 
    }

    public function saveMyUser($request){

        $PersonId = $request['PersonId'];
        $Email = $request['Email'];
        $Name = $request['Name'];
        $NickName = $request['NickName'];
        $TeamId = $request['TeamId'];

        $fields = (array) $request->all();
        
        $sql = "update person 
        set 
        Email = ':Email',
        Name = ':Name',
        NickName = ':NickName',
        SerieNrCI = ':SerieNrCI',
        CNP = ':CNP',
        SeriePermisArma = ':SeriePermisArma',
        DataExpPermis = ':DataExpPermis',
        MarcaArma = ':MarcaArma',
        SerieArma = ':SerieArma',
        CalibruArma = ':CalibruArma',
        CountryId = :CountryId
         where PersonId = :PersonId";
        
        foreach($fields as $key => $value){
            $sql = self::paramreplace($key, $value, $sql); 
        }
       // self::PutNullValues($sql);

        DB::select($sql); 
        
       

        $sql = "update 
                shooterxseason s
                inner join season ss on ss.SeasonId = s.SeasonId and Year = year(CURRENT_DATE)
                set s.TeamId = :TeamId
                where PersonId = :PersonId";

        foreach($fields as $key => $value){
            $sql = self::paramreplace($key, $value, $sql); 
        }
       
      //  self::PutNullValues($sql);

        
        DB::select($sql); 




        return $this->getMyUser($PersonId)[0];
    }

    public function deleteMyUser($request){
        $PersonId = $request['PersonId'];
        try {
            DB::beginTransaction();
            DB::select('call deleteUser(?)', [$PersonId]);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            return $e;
        }
        return 'OK';
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
    
    public function echivalarepersoana($badId, $goodId){
        try {
            DB::beginTransaction();
            DB::select('call spConcatPersons( ?, ?)', [$badId, $goodId]);
            DB::commit();
        }
        catch(\Exception $e){
                DB::rollBack();
               return $e;
        }
    }

}
