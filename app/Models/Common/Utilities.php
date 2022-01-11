<?php

namespace App\Models\Common;
use Illuminate\Support\Facades\DB;
use Exception;





class Utilities
{
     
    public static function getSetting($PersonId, $option){
        $sql = "SELECT x.Value FROM userxuseroption x
                inner join useroption o on o.OptionId = x.OptionId  
                where x.PersonId = ".$PersonId." and o.OptionName = '".$option."'";
        
        $R = DB::select($sql);
        
        if (count($R) > 0)
            return $R[0]->Value;
        else    
            return 'NoSetting';
    }

    public static function  BeginTran(){
        DB::BeginTransaction();
    }

    public static function  Commit(){
        DB::Commit();
        
    }

    public static function  Rollback(){
        DB::Rollback();
    }


    public static function  insertExchange($date, $currency, $value, $multiplier){
        
        if ($multiplier == '')
            $multiplier = 'null';   
        

        $date2 = substr($date, 0, 4).substr($date, 5, 2).substr($date, 8, 2);
            
        
        $sql = "Insert into currencyfx (CurrencyId, Data, Value, Multiplier)
                select c.CurrencyId, '".$date2."', ".$value.", ".$multiplier
                
                ." from currency c left join currencyfx f on f.CurrencyId = c.CurrencyId and f.Data = '".$date2."'
                where f.CurrencyId is null and Symbol = '".$currency."'";
                
                
        return  DB::select($sql);
    }

    public static function getLastExchangeDate(){
        $sql = "select max(Data) as MaxDate from currencyfx";

        return DB::select($sql)[0]->MaxDate;
    }

    public static function getLastExchanges($CurrencyId, $StartDate, $EndDate){
        $sql = "   create TEMPORARY TABLE tt
                    SELECT Symbol, d.Date as Data, Value , Multiplier, 1 as toShow
                    
                                    from
                                    days d
                                    left join  currencyfx fx on fx.Data = d.Date
                                    left join currency c on c.CurrencyId = fx.CurrencyId
                                    where (c.CurrencyId = '".$CurrencyId."' or c.CurrencyId is null) and 
                                    d.Date between '".$StartDate."' and '".$EndDate."' 
                                    order by  Date desc";
        DB::select($sql);
                                    
        $sql = "                create TEMPORARY TABLE tt2
                    SELECT Symbol, d.Date as Data, Value , Multiplier
                    
                                    from
                                    days d
                                    left join  currencyfx fx on fx.Data = d.Date
                                    left join currency c on c.CurrencyId = fx.CurrencyId
                                    where (c.CurrencyId =  '".$CurrencyId."' or c.CurrencyId is null) and d.Date between '".$StartDate."' and '".$EndDate."' 
                                    order by  Date desc";
       // DB::select($sql);

                       
       $sql = "              update tt 
                    inner join tt2 t2 on tt.Data > t2.Data and t2.Symbol is not null
                    set tt.Symbol = t2.Symbol, tt.Value =  t2.Value, tt.Multiplier = t2.Multiplier, tt.toShow = 0
                    where tt.Symbol is null";
        //DB::select($sql);
                    
       $sql = "             select * from tt where Value is not null
                    order by data  desc;";
                                        
        return  DB::select($sql);
    }

    public static function getLastUrl($PersonId){
        $sql = "select Location from navigationhistory where PersonId = {$PersonId} order by NavigationHistoryId desc LIMIT 1";
        return  DB::select($sql);

    }

}

