<?php

namespace App\Models\Common;
use Illuminate\Support\Facades\DB;
use App\Models\BObject;

use App\Models\Common\MasterList;

class Translation  extends MasterList{


    protected $IsInsertUnprepared = true; // true if multiple statements etc
    protected $IsUpdateUnprepared = true; // true if multiple statements etc
    protected $IsDeleteUnprepared = false; // true if multiple statements etc
    


    public $MasterKeyField = 'TranslationId';




    public $MasterSelect = "Select * from translation order by Locale, Base ";



    public $MasterInsert = "

        ";            
   

    public $MasterUpdate = "update translation set Translation = ':Translation' where TranslationId = :TranslationId";

    public $MasterDelete = ""  ;

   

 



}

