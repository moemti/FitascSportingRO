<?php

namespace App\Models\Common;
use Illuminate\Support\Facades\DB;
use Exception;




class Login 
{
    public static function Login($UserName){
       
        $sql = "select p.PersonId, u.Password, p.Name, p.Email, o.Name as Organization, o.OrganizationId , u.IsSuperUser,
                GROUP_CONCAT(f.Name SEPARATOR ', ') as Function 
                from 
                user u
                    inner join person p on p.PersonId = u.Personid
                inner join organization o on o.OrganizationId = p.OrganizationId 
                left join personxrole x on x.PersonId = p.PersonId
                left join role f on f.RoleId = x.RoleId
                where u.UserName = '{$UserName}'
                GROUP BY p.PersonId, u.Password, p.Name, p.Email, o.Name , o.OrganizationId , u.IsSuperUser";
            
        $user = DB::select($sql);
        return $user;
         
    }    


    public static function EmailExists($email){
        $sql = "select email from user u inner join person p on p.PersonId = u.PersonId where p.Email = '$email'";
        $user = DB::select($sql);
        return $user;
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
