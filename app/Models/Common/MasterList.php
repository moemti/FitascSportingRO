<?php

namespace App\Models\Common;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

class MasterList {


    protected $IsInsertUnprepared = true; // true if multiple statements etc
    protected $IsUpdateUnprepared = true; // true if multiple statements etc
    protected $IsDeleteUnprepared = false; // true if multiple statements etc
    


    public function MasterKeyFields(){
        return [$this->MasterKeyField];
    } 


   


    public $MasterKeyField = '';
    public $MasterFilterName = '';
 
    public $MasterSelect =  null;

    public $MasterInsert = null;            
   

    public $MasterUpdate = null;
    public $MasterDelete = null;

   
           

 

    public function getMasterList($Item = null){
        $sql = $this->MasterSelect;
        $sql = BObject::paramreplace($this->MasterFilterName, $Item, $sql);  
        BObject::PutNullValues($sql);
        return  DB::select($sql);
    }

    public function Save($fields){
        $Item = $fields['MasterFilter'];


        // return fields;

        DB::beginTransaction(); 
        try{   
            if (array_key_exists('delta', $fields)) {
                foreach($fields['delta'] as $s){
                    
                    $d = (object) ($s);
                    switch ($d->Operation){
                        case "D": $this->deleteMaster($s);
                            break;
                        case "U": $this->updateMaster($s);
                            break;
                        case "I": $this->insertMaster($s);
                            break;    
        
                    }
                }
            }
        
            DB::commit();
        }
        catch(\Exception $e){
                DB::rollBack();
                throw $e;
        }
       
           

        return $this->getMasterList($Item);


    }
       

    public function insertMaster($detail){

       
    }

    public function updateMaster($detail){      
       

        $PrimaryKey = $detail[$this->MasterKeyFields()[0]]; 
        $sql = $this->MasterUpdate;
        $sql = BObject::paramreplace($this->MasterKeyField, $PrimaryKey, $sql);  
        foreach($detail as $key => $value){
            if (!is_array($value))
                $sql = self::paramreplace($key, $value, $sql); 
        } 
        BObject::PutNullValues($sql);
        DB::select($sql);
           

       
    }

    public function deleteMaster($detail){
       
    }

    public static function paramreplace($param, $value, $sql){
        $done = false;
        $sqlDone = '';
        $sqlToDo = $sql;

        if ($value == null)
            $value = ' null ';

        while(!$done){
            $pos = strpos ($sqlToDo, ":".$param);
            
            if  ($pos !== false){
               
                if ( ( strlen($sqlToDo) -1 == $pos + strlen($param))){
                    $sqlDone .= substr($sqlToDo, 0, $pos ).$value;
                    $sqlToDo = '';
                    $done = true;
                }
                else{
                    if (in_array($sqlToDo[$pos + strlen($param) +1] , array('`',"'", ' ', "\n", "\t", "\r", ';', ')', ','))){
                        $i = 0;
                        if ($value == ' null '){
                            if ($sqlToDo[$pos + strlen($param) + 1] == "'"){
                                $i = 1;
                            }
                        }
                        $sqlDone .= substr($sqlToDo, 0, $pos - $i ).$value;
                        $sqlToDo = substr($sqlToDo, $pos + strlen($param)+ 1 + $i, 10000);
                       
                    }
                    else {
                        $done = true;
                    }
                }
                
            }else {
                $done = true;
            }          
        }
        return $sqlDone.$sqlToDo;
    }


}

