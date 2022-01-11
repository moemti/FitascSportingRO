<?php


namespace App\Models\Users;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;



class UserPerson extends BObject{
    
    public function MasterKeyField(){
        return 'PersonId';
    }

    public $MasterKeyIsNew = false;
    
   
    public $MasterItemSelect =  "SELECT u.PersonId, u.UserName, p.Name, p.Email, p.NickName 
                         from user u
                        inner join person p on p.PersonId = u.PersonId
                        where u.PersonId = :PersonId" ;
                                        



    public $MasterUpdate = "UPDATE user u 
                            inner join person p on p.PersonId = u.PersonId
                            SET
                        u.`UserName`= ':UserName', p.Name = ':Name', p.Email = ':Email', p.NickName = ':NickName'
                        WHERE p.PersonId = :PersonId";


    
    public function OnSaveError($e){
       
        $message = $e->getMessage();
        if (strpos($message, 'Integrity constraint violation: 1062 Duplicate entry') && strpos($message, "for key 'Email'")){
            throw new \Exception('Email-ul introdus mai exista la un alt utilizator!');
        }
    }


    public static function registeruser($fields){

           
            $sql = "select Email from register where `Email` =
            ':Email' and ifnull(Status,0) <> -2"; // adica sa mai incerce o data

            foreach($fields as $key => $value){
                if (!is_array($value))
                    $sql = self::paramreplace($key, $value, $sql);
            }

            if (count(DB::select($sql)) > 0)
                return 'Already exists a registration with this email';


            $sql = "INSERT INTO register(`Email`, `Name`, `UserName`, `Password`, `Token`) values(
                ':Email', ':Name', ':UserName', ':Password', ':Token')";

            foreach($fields as $key => $value){
                if (!is_array($value))
                    $sql = self::paramreplace($key, $value, $sql);
            }

        

            try {
                DB::select($sql);
                return 'OK';

                
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            

    }

    public static function saveRegisteredUser($passtoken){
        $sql = "select Email from register where `Token` = '$passtoken'";
        

    

        if (count(DB::select($sql)) == 0){

           return 'There is no registration with this token!';

        };


        $sql = "update register set Status = 0 where `Token` = '$passtoken'";
       

    

        try {
            DB::select($sql);
            return 'OK';

            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        

    }




   

}