<?php

/* to do

    -- master key fields could be array
   
*/

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


class BObject{

    public function __construct($OrganizationId = null){    
        $this->OrganizationId = $OrganizationId;
    
    }
    

    public function MasterKeyField(){ return '';} 
    public function DetailKeyField(){ return '';}
    public function MasterFields(){ return [];}
    public function DetailFields(){ return [];}
    public function CustomFilters(){ return [];}  // predefinited filters
    public function FilterSource(){ return [];}  // filter source for custom filters
    public function DefaultMasterValues(){ return [];} // default values
    public function MasterFixedFields(){ return [];} // for checking that this fields to be not altered
    public function DetailFixedFields(){ return [];} // for checking that this fields to be not altered 


    protected $OrganizationId = 0;
    protected $IsInsertUnprepared = false; // true if multiple statements etc
    protected $IsUpdateUnprepared = false; // true if multiple statements etc
    protected $IsDeleteUnprepared = false; // true if multiple statements etc
    public $MasterItemSelect = '';
    public $MasterSelect = '';
    public $MasterInsert = '';
    public $MasterUpdate = '';
    public $MasterDelete = '';
    public $DetailItemSelect = '';
    public $DetailSelect = '';
    public $DetailInsert = '';
    public $DetailUpdate = '';
    public $DetailDelete = '';
    public $MasterKeyIsNew = true; // if true get the new item as " select LAST_INSERT_ID() as ItemId" else get the MasteKeyFieldValue

    // overrideable functions for sql statements
    public function GetMasterSelect($OrganizationId, $filter, $others = null){
        return '';
    }
    public function GetMasterItemSelect(){
        return '';
    }
    public function GetMasterInsert($fields){
        return '';
    }
    public function GetMasterUpdate($fields){
        return '';
    }
    public function GetMasterDelete($ItemId){
        return '';
    }
    public function GetDetailSelect($ItemId, $OrganizationId){ // toate detaliile
        return '';
    }
    public function GetDetailItemSelect($ItemId){ // un singur detailiu
        return '';
    }
    public function GetDetailInsert($fields, $MasterId, $master){
        return '';
    }
    public function GetDetailUpdate($fields, $master){
        return '';
    }
    public function GetDetailDelete($fields, $master){
        return '';
    }

    public function GetInitialFilter(){
        foreach($this->CustomFilters() as $filter){
            if (array_key_exists('Default', $filter))
                return [$filter['Caption'],$filter['Filter']];
        }
    }

  


    public function getMasterList($OrganizationId, $filter, $others = null){
        
        $sql = $this->GetMasterSelect($OrganizationId, $filter, $others);
       
        while (is_array($filter))
            $filter = $filter[1]; // un bug undeva
               
        if ($sql == ''){
            if ($filter != ''){
                $filter = " and ".$filter;
            }

            $PersonId =  $others['PersonId'] ;   

            $sql = str_replace( array(":filter", ":_OrganizationId_", ":_PersonId_") ,array("{$filter}", "{$OrganizationId}", "$PersonId"), $this->MasterSelect);
        }

        return  DB::select($sql);
    }

    public function getMaster($ItemId){
        $MasterKey = $this->MasterKeyField();

        $sql = $this->GetMasterItemSelect();

        if ($sql ==''){
            $sql = str_replace( array(":".$MasterKey) ,array("{$ItemId}"), $this->MasterItemSelect) ;
        }

        $r = DB::select($sql);

        foreach($this->MasterFixedFields() as $field){
            session(["LAST_".$field => $r[0]->$field]);
                
        }


        return $r;

    }

    public function Save($fields){

        $MasterKey = $this->MasterKeyField();

        
        $this->beforeSave($fields);
        
        try {

            DB::beginTransaction();

            $this->beforeSaveInTran($fields);

            if (
                (!isset($fields[$MasterKey])) || ($fields[$MasterKey]== "") || ( isset($fields['isnew'] ) && $fields['isnew'] == "1")
                ) {

               

                $sql = $this->GetMasterInsert($fields);
                if ($sql == ''){
                    $sql = $this->MasterInsert;
                    foreach($fields as $key => $value){
                        if (!is_array($value))
                            $sql = self::paramreplace($key, $value, $sql); 
                    }
                
                    
                }       

                if ($this->IsInsertUnprepared)    
                    DB::unprepared($sql);
                else
                    DB::select($sql);

                if ($this->MasterKeyIsNew){
                    $sql = " select LAST_INSERT_ID() as ItemId";
                    $ItemId = DB::select($sql)[0]->ItemId;
                }
                else{
                    $ItemId = $fields[$this->MasterKeyField()];
                }

               

            } else {
              
                $ItemId = $fields[$this->MasterKeyField()];

                $sql = $this->GetMasterUpdate($fields);
                if ($sql == ''){
                   $sql = $this->MasterUpdate;
                    foreach($fields as $key => $value){
                        if (!is_array($value))
                            $sql = self::paramreplace($key, $value, $sql);
                    }
                
                  
                } 

                if ($this->IsUpdateUnprepared)    
                    DB::unprepared($sql);
                else
                    DB::select($sql);
                    
              
            }
            if (array_key_exists('delta', $fields)) 
                $this->updateDetails($fields['delta'], $ItemId, $fields);

            // other savings

            $this->afterSaveInTran($ItemId, $fields);
                
            DB::commit();
        }
        catch(\Exception $e){
                DB::rollBack();

                $this->OnSaveError($e);
                throw $e;
        }
        $this->afterSave($ItemId, $fields);
        return $this->getMaster($ItemId);
    }
    

    public function OnSaveError($e){}
    public function afterSaveInTran($ItemId, $fields){}
    public function afterSave($ItemId, $fields){}
    public function beforeSaveInTran($fields){}
    private function validatebeforeSave($fields){

        foreach($this->MasterFixedFields() as $field){
            $new = $fields[$field];
            $old =  session("LAST_".$field);

            if(isset($old) && $old != $new){

                throw new \Exception("Altered $field: $old  <> $new");
            }
        }


    }

    public function beforeSave(&$fields){
        $this->validatebeforeSave($fields);
    }

    public function updateDetails($delta, $MasterId, $master){

        if ($delta == [])
            return 'no delta';

        foreach($delta as $s){
                
            $d = (object) ($s);
            switch ($d->Operation){
                case "D": $this->deleteDetail($d, $master);
                    break;
                case "U":  $this->updateDetail($d, $master);
                    break;
                case "I": $this->insertDetail($d, $MasterId, $master);
                    break;    

            }
        }

    }



    public function deleteMaster($ItemId){
        $MasterKey = $this->MasterKeyField();
        $sql = $this->GetMasterDelete($ItemId);
        if ($sql == '')
            $sql = str_replace( array(":".$MasterKey) ,array("{$ItemId}"), $this->MasterDelete) ;
        
        DB::beginTransaction(); 
        try{   
            DB::unprepared($sql);
        
            DB::commit();
        }
        catch(\Exception $e){
                DB::rollBack();
                throw $e;
        }
    }


    public function getDetails($ItemId, $OrganizationId){
        $MasterKey = $this->MasterKeyField();

        $sql = $this->GetDetailSelect($ItemId, $OrganizationId);
        if ($sql == '')
            $sql = str_replace( array(":".$MasterKey, ":_OrganizationId_") ,array("{$ItemId}", "{$OrganizationId}"), $this->DetailSelect) ;
        return DB::select($sql);

    }

    public function getMasterOthers($ItemId, $OrganizationId){
        return [];
    }

    public function insertDetail($detail, $DocumentId, $master){

        
        $sql = $this->GetDetailInsert($detail, $DocumentId, $master);

        if ($sql == ''){
            $sql = $this->DetailInsert;
            $sql = str_replace(":".$this->MasterKeyField(), $DocumentId, $sql); 
            foreach($detail as $key => $value){
                $sql = self::paramreplace($key, $value, $sql); 
            }
            foreach($master as $key => $value){
                if (!is_array($value))
                    $sql = self::paramreplace($key, $value, $sql); 
            }

            
           
   
        }

        DB::unprepared($sql);
    }

    public function updateDetail($detail, $master){

        
        $sql = $this->GetDetailUpdate($detail, $master);

        if ($sql == ''){
            $sql = $this->DetailUpdate;
            foreach($detail as $key => $value){
                $sql = self::paramreplace($key, $value, $sql); 
            }
            foreach($master as $key => $value){
                if (!is_array($value))
                    $sql = self::paramreplace($key, $value, $sql); 
            }
         
        }
       
        DB::unprepared($sql);
    }

    public function deleteDetail($detail, $master){
        $DetailKey = $this->DetailKeyField();

        $sql = $this->GetDetailDelete($detail, $master);
       
        if ($sql == ''){
            $sql = $this->DetailDelete;
            foreach($detail as $key => $value){
                $sql = self::paramreplace($key, $value, $sql); 
            }
            foreach($master as $key => $value){
                if (!is_array($value))
                    $sql = self::paramreplace($key, $value, $sql); 
            }
         
        }
        return DB::unprepared($sql);
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


    public static function getFieldValues($fields, $valfields, $isarray = false, $isinsert = false, $nullvalue = 'null' ) {

        $val  = [];
        $val2 = [];
        $val3 = [];
        

        $val = $valfields;// explode(',', $valfields);

        foreach($val as $v){
            $v=  str_replace(array('`', ' ', "\n", "\t", "\r"), '', $v);
            array_push( $val2,$v);
        }

        foreach($val2 as $v){
            $IsDone = false;
            $pos = strpos ($v, ';d');
            if  ($pos !== false){
                $v = str_replace(';d', '', $v);
                if ($fields->$v != ''){
                    $v =  date( 'ymd', strtotime($fields->$v));
                    $IsDone = true;
                }
            } 
            else{
                $pos = strpos ($v, ';s');
                if  ($pos !== false){
                    $v = str_replace(';s', '', $v);
                    if ($fields->$v != ''){
                        $v = "'".$fields->$v."'";
                        $IsDone = true;
                    }
                }else{
                    if ($fields->$v != ''){
                        $v = $fields->$v;
                        $IsDone = true;
                    }
                }
            }

            if (!$IsDone)    
                $v = $nullvalue;

            array_push( $val3, $v);    
            
        }

        if ($isarray)
            return $val3;
        else{
            

            if ($isinsert){
                return implode (" , ", $val3);
            }
            else{
                $sql = [];
                foreach($val as $key=>$v){
                    array_push($sql , str_replace(array('`', ' ', "\n", "\t", "\r", ';d', ';s'), '', $v) . " = " . $val3[$key]);
                };


                return implode (" , ", $sql);
            }
        }

    }

}