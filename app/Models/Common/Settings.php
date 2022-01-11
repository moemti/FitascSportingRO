<?php

namespace App\Models\Common;
use Illuminate\Support\Facades\DB;
use Exception;





class Settings
{
     
    public static function getUserSetting($PersonId, $option){
        $sql = "SELECT x.Value FROM userxuseroption x
                inner join useroption o on o.OptionId = x.OptionId  
                where x.PersonId = ".$PersonId." and o.OptionName = '".$option."'";
        
        $R = DB::select($sql);
        
        if (count($R) > 0)
            return $R[0]->Value;
        else    
            return 'NoSetting';
    }


    public static function getAppSetting($code){
        $sql = "SELECT * FROM setting 
                where Code = '".$code."' for update";
        
        $s = DB::select($sql)[0];

        $value = $s->Value;
        $type = $s->Type;

        return ['value'=>$value, 'type' => $type];

        
    }

    public static function updateAppSetting($code, $value){
        $sql = "Update setting  set Value = '{$value}'
                where Code = '".$code."'";
        
        DB::select($sql);

      

      

        
    }


}
