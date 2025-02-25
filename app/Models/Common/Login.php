<?php

namespace App\Models\Common;
use Illuminate\Support\Facades\DB;
use Exception;




class Login 
{
    public static function Login($UserName){
       
        $sql = "select p.PersonId, u.Password, p.Name, p.Email,  u.IsSuperUser,
                GROUP_CONCAT(f.Name SEPARATOR ', ') as Function 
                from 
                user u
                inner join person p on p.PersonId = u.Personid
                left join personxrole x on x.PersonId = p.PersonId
                left join role f on f.RoleId = x.RoleId
                where p.Email = '{$UserName}'
                GROUP BY p.PersonId, u.Password, p.Name, p.Email, u.IsSuperUser";
            
        $user = DB::select($sql);
        return $user;
         
    }    


    public static function CorectPassword($PersonId, $Password){
       
        $sql = "select p.PersonId
                from 
                user u
                inner join person p on p.PersonId = u.Personid
                where p.PersonId = $PersonId and u.Password = '$Password'
                ";
            
        return count(DB::select($sql)) > 0;
     
         
    }    
    public static function getUserToken($PersonId, $device){
        $token =  uniqid();
        $found = false;
        $new = $token."##".$device;

        $sql = "select Token from user where PersonId = {$PersonId}";

        $tt = DB::select($sql)[0]->Token;

        $tokens = explode(";", $tt);

        foreach($tokens as $key=>$t) {
            $p = strpos($t, "##".$device);
            if ($p > -1){
                $found = true;
                $tokens[$key] = $new;
            }
        }

        if (!$found)
            array_push($tokens, $new);

        $token_i = implode(";", $tokens);  

        $sql = "update user set Token = '{$token_i}' where PersonId = {$PersonId}";
        DB::select($sql);

        return $token;
    }

  

    public static function loginApiToken($token){ 
        $sql = "select  p.PersonId, u.Password, p.Name, p.Email,  u.IsSuperUser,
                GROUP_CONCAT(f.Name SEPARATOR ', ') as Function 
            from 
            user u
            inner join person p on p.PersonId = u.Personid
            left join personxrole x on x.PersonId = p.PersonId
            left join role f on f.RoleId = x.RoleId
            where u.Token like '%{$token}##%'
            GROUP BY p.PersonId, u.Password, p.Name, p.Email, u.IsSuperUser" ;

            $user = DB::select($sql);
            return $user;

    }

    public static function logoutApi($token){
        $sql = "update user set Token = null where Token = '{$token}'" ;
        return "OK";
    }
   

    public static function EmailExists($email){
        $sql = "select email from user u inner join person p on p.PersonId = u.PersonId where p.Email = '$email'";
        $user = DB::select($sql);
        return $user;
    }

    public static function RegisterExists($email){
        $sql = "select Token from register where Email = '$email' and Status is null";
        return DB::select($sql);
        
    }

    public static function RegisterExistsToApprove($email){
        $sql = "select Token from register where Email = '$email' and Status = 0";
        return DB::select($sql);
        
    }

    public static function Register($FirstName, $Name, $Email, $password){
       

        $utilizator = DB::select(' call InsertUser(?, ?, ?, ?)', 
        [ $FirstName, $Name, $Email, $password]);
        return $utilizator;
    }  
    

    public static function UpdateUser($IdPerson, $firstname, $name, $email, $IsAdmin, $IsReferee, $IsShooter, $password = null){
        
        $user = DB::select(' call UpdateUser (?, ?, ?, ?, ?, ?, ?, ?)', 
        [$IdPerson, $firstname, $name, $email, $IsAdmin, $IsReferee, $IsShooter, $password]);
        
        return $user;
    }

}
