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

     //       if (count(DB::select($sql)) > 0)
       //         return 'Already exists a registration with this email';


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

    public static function getregisteries(){
        $sql = "select Name, Email, RegisterId, UserName from register where Status = 0 order by Name";
        return   DB::select($sql);
        
    }

    public static function getregistere($RegisterId){
        $sql = "select Name, Email, RegisterId, UserName from register where Status = 0 and RegisterId = $RegisterId ";
        return   DB::select($sql)[0];

    } 
    
    
    public static function getPersonNoUser(){
        $sql = "select Name, Email, p.PersonId from person p left join user u on p.PersonId = u.PersonId where u.PersonId is null order by p.Name";
        return  DB::select($sql);
    }

    public static function deletecerere($RegisterId){
        $sql = "update register set Status = -1  where RegisterId = $RegisterId;";

        try{
            DB::select($sql);

        } catch (\Exception $e) {
            return $e->getMessage();
        }


        return 'Cererea a fost stearsa';
    }

    
    public static function finishuser($RegisterId, $PersonId, $Email, $TeamId, $Team){

        // verificam Emailul

        $sql = "select 1 from register where RegisterId = $RegisterId and Status = -1";
        if (count(DB::select($sql)) > 0 )
            return 'Cererea a fost stearsa';

        $sql = "select 1 from person where Email = '$Email' and PersonId <> $PersonId";
        if (count(DB::select($sql)) > 0 )
            return 'Acest email deja exista';

        $mesaj = '';
        try {
            DB::beginTransaction();


            if ($PersonId > 0){
            
    
                $sql = "insert into user (PersonId, Password, IsSuperUser, UserName)
                    select $PersonId , Password, 0, Name from register r
                    where RegisterId = $RegisterId ;";
                DB::select($sql);


                $sql = "update person set Email = '$Email' where PersonId = $PersonId;";
                DB::select($sql);


                $sql = "update register set Status = 1  where RegisterId = $RegisterId;";
                DB::select($sql);
            
    
                
                if (!($TeamId > 0) &&  ($Team != '')){
                    $sql = "insert into team (Name, IsActive) values ('$Team', 1)"; 
                    DB::select($sql);


                    $TeamId = DB::select("select LAST_INSERT_ID() as TeamId")[0]->TeamId;


                }

                if ($TeamId > 0){

                    $sql = "update shooterxseason set TeamId = $TeamId where PersonId = $PersonId;";
                    DB::select($sql); 

                }
               
            }
            
            else{
                $sql = 
                    "INSERT INTO person(Name, Code, Email, CountryId) 
                        select Name, 'XXX', '$Email', 1 from register r
                        where RegisterId = $RegisterId;";

                    DB::select($sql);


                $PersonId = DB::select("select LAST_INSERT_ID() as PersonId")[0]->PersonId;
    
            
                $sql = 
                    "insert into user (PersonId, Password, IsSuperUser, UserName)
                    select $PersonId, Password, 0, Name from register r
                    where RegisterId = $RegisterId;";

                    DB::select($sql);


                if (!($TeamId > 0) &&  ($Team != '')){
                    $sql = "insert into team (Name, IsActive) values ('$Team', 1)"; 
                    DB::select($sql);


                    $TeamId = DB::select("select LAST_INSERT_ID() as TeamId")[0]->TeamId;


                }

                if ($TeamId > 0){

                    $sql = "insert into shooterxseason (PersonId, TeamId, SeasonId ) select $PersonId,  $TeamId, SeasonId from season;";
                    DB::select($sql); 

                }

                $sql = "update register set Status = 1  where RegisterId = $RegisterId;";
                    DB::select($sql);

            }

            DB::Commit();
        } catch (\Throwable $th) {
            DB::Rollback();
            throw $th;
        }


        return $mesaj;
    }




    public static function saveRegisteredUser($passtoken, &$confirmedEmail){
        $sql = "select Email from register where `Token` = '$passtoken'";
        

        $result = DB::select($sql);

        if (count($result) == 0){

           return 'There is no registration with this token!';

        }
        else{
            $confirmedEmail = $result[0]->Email;
        }
        $sql = "update register set Status = 0 where `Token` = '$passtoken' and Status is null";
        try {
            DB::select($sql);
            return 'OK';

            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        

    }




   

}