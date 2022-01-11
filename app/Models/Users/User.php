<?php


namespace App\Models\Users;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;



class User extends BObject{
    
    public function MasterKeyField(){
        return 'PersonId';
    }

    public $MasterKeyIsNew = false;
    
    public $MasterSelect = 
                "SELECT u.PersonId, u.UserName, u.Password, p.Name, u.IsSuperUser
                from user u
                inner join person p on p.PersonId = u.PersonId
                where p.OrganizationId = :_OrganizationId_ 
                order by p.Name" ;


    public $MasterItemSelect =  "SELECT u.PersonId, u.UserName, u.Password, u.IsSuperUser 
                        from user u
                        where u.PersonId = :PersonId" ;
                                        

    public $MasterInsert =  "INSERT INTO `user`( PersonId, `UserName`,  `Password`, IsSuperUser)
                                values (:PersonId, ':UserName', ':Password', :IsSuperUser)";

    public $MasterUpdate = "UPDATE `user` SET
                        `UserName`= ':UserName', `Password` = ':Password', IsSuperUser = :IsSuperUser
                        WHERE PersonId = :PersonId";

    public $MasterDelete = "delete from user
            where PersonId = :PersonId"  ;
    
    
    public function beforeSave(&$fields){
        parent::beforeSave($fields);

        $fields['Password'] = crypt($fields['Password'] , $fields['Password'] );
    }


    public static function setPasswordReset($Email, $passtoken){
        $sql = "insert into passwordreset (Email, PassToken) select '$Email', '$passtoken'";

        DB::select($sql);

    }

    public static function setPassword($password, $passtoken){

        $sql = "select Email from passwordreset where PassToken = '$passtoken' and Data >= CURDATE() - INTERVAL 1 DAY"    ;

        $r = DB::select($sql);

        if (count($r) == 0)
            return 'The password token has expired or does not exists! You have to acces the link within one day! Go to login and reset again the password!';
    
        $email = $r[0]->Email;
        
        $sql = "update user u  inner join person p on p.PersonId = u.PersonId set Password = '$password' where p.Email = '$email'";

        DB::select($sql);

        return 'OK';

    }


    public static function setMyPassword($PersonId, $password){
        $sql = "update user u  set Password = '$password' where PersonId = $PersonId";

        DB::select($sql);

        return 'OK';

    }
    

}