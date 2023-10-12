<?php

namespace App\Http\Controllers;



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;
use App\Models\Dictionaries\Dictionary;
use App\Models\Competitions\Competition;

class CompetitiiController extends MasterController
{
    public $BObject = 'App\Models\Competitions\Competition';

    public $views = ['master'=>'modules.pages.competitii', 'detail' => 'modules.pages.competitiidetail'];

    public function getDictionaries(){
        return ['years' => $this->BObject()->getCompetitionYears()];
    }

    public function getClasament($ItemId){
        return view( 'modules.pages.competitiedetail',['master' => $this->BObject()->getMaster($ItemId), 'clasament' => $this->BObject()->GetClasament($ItemId),
        'clasamentcategorie' => $this->BObject()->GetClasamentCategory($ItemId),
        'clasamentteams' => $this->BObject()->GetClasamentTeams($ItemId)
         ]);


    }

    public function getClasamentAPI($ItemId){
        $Nume = '';
        $Descriere = '';
        if ($ItemId == 0){
            $competitie =  Competition::getCurrentCompetition()[0];
            $ItemId = $competitie->CompetitionId;
            $Nume = $competitie->NumeSuperLung;
            $Descriere = $competitie->Mesaj;
        }



       $clasament = $this->BObject()->GetClasament($ItemId);

       return ['clasament' => $clasament, 'nume' => $Nume, 'descriere' => $Descriere];
    }

    public function editresult($ResultId){
        return view( 'modules.pages.competition.resultedit',[
                                                            'CompetitionId' => $this->BObject()->getCompetitionByResult($ResultId),
                                                            'MasterPrimaryKey' => 'ResultId',
                                                            'MasterPrimaryKeyValue' => $ResultId,
                                                            'teams' => $this->BObject()->getTeams(),
                                                            'categories' => $this->BObject()->getShootingCategories(),
                                                            'persons' => $this->BObject()->GetClasamentSerii( $this->BObject()->getCompetitionByResult($ResultId))
                                                        
                                                        ]);
    }

    public function switchPersons(Request $request){
        $CompetitionId = $request->CompetitionId;
        $PersonId1 = $request->PersonId1;
        $PersonId2 = $request->PersonId2; 

        return $this->BObject()->switchPersons($CompetitionId, $PersonId1, $PersonId2);

    }



    public function getClasamentdata($data){
        $CompetitionId = $this->BObject()->getCompetitionByStartDate($data);

        return $this->getClasament($CompetitionId);
    }

    public function getresultajax(Request $request){
        $ResultId = $request->ResultId;
        return [$this->BObject()->getresultDetail($ResultId)];
    }

    public function saveresultdetail(Request $request){
        $fields = $request->all();
        return $this->BObject()->SaveResultsDetail($fields);
    }

    public function getresultdetailsajax(Request $request){
      
        $ResultId = $request['MasterKeyField'];
        return [$this->BObject()->getresultDetails($ResultId)];
    }


    public function changeCompetitionStatus(Request $request){

        $Status = $request->Status;
        $CompetitionId = $request->CompetitionId;

        return $this->BObject()->changeCompetitionStatus($CompetitionId, $Status);
    }


    public function doCompetitionSquads(Request $request){

        $Type = $request->Type;
        $CompetitionId = $request->CompetitionId;

        if ($Type == 'Even')
            return $this->BObject()->doCompetitionSquadsEven($CompetitionId);
        else
            return $this->BObject()->doCompetitionSquads($CompetitionId, $Type);
    }


    

    public function registerMe(Request $request){

        $PersonId = session('PersonId');
        $Register = $request->Register == 1;
        $CompetitionId = $request->CompetitionId;
        if ($Register)
            return $this->BObject()->registerMe($CompetitionId, $PersonId);
        else
            return $this->BObject()->unRegisterMe($CompetitionId, $PersonId);
    }
    

    public function registerCompetitor(Request $request){
        $CompetitionId = $request->CompetitionId;
        $PersonId = $request->PersonId;
        $params =
        [
            "CompetitionId" => $CompetitionId, 
            "persons" => $this->BObject()->getUnregisteredPersons($CompetitionId), 
            'categories' => $this->BObject()->getShootingCategories(),  
            'teams' => $this->BObject()->getTeams(),
            'countries' => Dictionary::getCountries()
        ];

        if (isset($PersonId)){
            $params['PersonId'] = $PersonId;
        }

        return view('modules.pages.competition.addcompetitor')->with($params);
    }

    public function registerCompetitorDB(Request $request){
        $fields = $request->all();
        return $this->BObject()->registerCompetitorDB( $fields );
    }


    public function returnWelcome(){
        $PersonId = session('PersonId');
        if (!$PersonId)
            $PersonId = 'null';

        $competitions = $this->BObject()->getTopCompetitions($PersonId);
   
        return view('modules.pages.welcome', ["competitions" => $competitions]);
    }

    // ==============  Gallery

    public function getgallery($CompetitionId){

    
        $images = scandir("img/gallery/competitions/$CompetitionId");
        return view('modules.pages.gallery', ["images" => $images, "competition" => $CompetitionId]);
    }

    public function geteditgallery($CompetitionId){

        if (!file_exists("img/gallery/competitions/$CompetitionId")) {
            mkdir("img/gallery/competitions/$CompetitionId", 0777, true);
        }
        $images = scandir("img/gallery/competitions/$CompetitionId");
        return view('modules.pages.gallery', ["images" => $images, "competition" => $CompetitionId, "edit" => true]);
    }

    public function deleteGallery(Request $request){

        $toDelete = $request->toDelete;
        foreach($toDelete as $file){
            if (file_exists("img/gallery/competitions/$file")) {
                unlink("img/gallery/competitions/$file");
            }
        }
    }

    function galleryUpload(Request $request){
  
            $CompetitionId = $request->CompetitionId;
            $countfiles = count($_FILES['file']['name']);
           
            for($i=0;$i<$countfiles;$i++){
                $filename = $_FILES['file']['name'][$i];
                move_uploaded_file($_FILES['file']['tmp_name'][$i],"img/gallery/competitions/$CompetitionId/$filename");
            }
        
    }
    // ===========  Atachments ==========

    function getCompetitionAttachment($CompetitionAttachmentId){
        $r = $this->BObject()->getCompetitionAttachment($CompetitionAttachmentId)[0];

        $filename = "img/attachments/competitions/{$r->CompetitionId}/{$r->FileName}";

            if (file_exists($filename)) {     
                
                //Define header information
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header("Cache-Control: no-cache, must-revalidate");
                    header("Expires: 0");
                    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                    header('Content-Length: ' . filesize($filename));
                    header('Pragma: public');

                    //Clear system output buffer
                    flush();

                    //Read the size of the file
                    readfile($filename);

                    //Terminate from the script
                    die();
            
            }
            else
                echo $filename;
        
        
    }

    function getCompetitionAttachmentByName($competition, $filename){
        
        $filename = "img/attachments/competitions/{$competition}/{$filename}";

            if (file_exists($filename)) {     
                
                //Define header information
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header("Cache-Control: no-cache, must-revalidate");
                    header("Expires: 0");
                    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                    header('Content-Length: ' . filesize($filename));
                    header('Pragma: public');

                    //Clear system output buffer
                    flush();

                    //Read the size of the file
                    readfile($filename);

                    //Terminate from the script
                    die();
            
            }
            else
                echo $filename;
        
        
    }

    public function geteditattach($CompetitionId){
        if (!file_exists("img/attachments/competitions/$CompetitionId")) {
            mkdir("img/attachments/competitions/$CompetitionId", 0777, true);
        }

        $attachments =  getCompetitionAttachments($CompetitionId);
        return view('modules.pages.attachments', ["attachments" => $attachments, "competition" => $CompetitionId, "edit" => true]);
    }

    public function deleteAttach(Request $request){

        $toDelete = $request->toDelete;
        $toDeleteIds =  $request->toDeleteIds;

        foreach($toDelete as $file){
         
            if (file_exists("img/attachments/competitions/$file")) {
                unlink("img/attachments/competitions/$file");
            }
        }

        foreach($toDeleteIds as $fileId){
            $this->BObject()->deleteAttach($fileId);
        }
    }

    public function attachModify(Request $request){

        $toModify = $request->toModify;

        foreach($toModify as $file){
            $this->BObject()->modifyAttach($file['id'], $file['name']);
        }
    }

    

    function attachUpload(Request $request){
  
            $CompetitionId = $request->CompetitionId;
            $countfiles = count($_FILES['file']['name']);
           
            for($i=0;$i<$countfiles;$i++){
                $filename = $_FILES['file']['name'][$i];
                move_uploaded_file($_FILES['file']['tmp_name'][$i],"img/attachments/competitions/$CompetitionId/$filename");
                $this->BObject()->addAttach($filename, $CompetitionId);
            }
        
    }




    //============================

    public function getClasamentList ($CompetitionId){
   

        $dataset = $this->BObject()->GetClasament($CompetitionId);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // header
        $row = 4;
        $col = 'B';
        $sheet->setCellValue('B2', 'Lista participanti');

        function IncColumn(&$column){
            $loc = $column;
            $column++;
            return $loc;
        }

        function IncRow(&$row){
            $loc = $row;

            $row++;            
            return $loc;
        }


        $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('#');



        $sheet->setCellValue(IncColumn($col).$row, 'Nr');
        
        $sheet->setCellValue(IncColumn($col).$row, 'Nume');
        $sheet->setCellValue(IncColumn($col).$row, 'Categorie');
        $sheet->setCellValue(IncColumn($col).$row, 'Echipa');
        $sheet->setCellValue(IncColumn($col).$row, 'Serie Nr CI');
        $sheet->setCellValue(IncColumn($col).$row, 'CNP');
        $sheet->setCellValue(IncColumn($col).$row, 'Serie permis arma');
        $sheet->setCellValue(IncColumn($col).$row, 'Data Exp permis');
        $sheet->setCellValue(IncColumn($col).$row, 'Marca arma');
        $sheet->setCellValue(IncColumn($col).$row, 'Serie arma');
        $sheet->setCellValue(IncColumn($col).$row, 'Calibru arma');

        IncRow($row);
        $col = 'B';

        foreach($dataset as $d){
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Position));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Person));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Category));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Team));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->SerieNrCI));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->CNP));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->SeriePermisArma));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->DataExpPermis));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->MarcaArma));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->SerieArma));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->CalibruArma));

            $col = 'B';
            IncRow($row);
        }

        $col = 'B';
        for ($i = 1; $i <= 20; $i++) {
            $sheet->getStyle($col)->getAlignment()->setHorizontal('left');
            $sheet->getColumnDimension(IncColumn($col))->setAutoSize(true);
        }


        ob_clean();
        $writer = new Xlsx($spreadsheet);

        $filename = 'listaCompetitieSemnat.xlsx';
        
        
        header('Content-Description: File Transfer');
        header('Content-Type:  application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$filename");

        ob_end_clean();
        $writer->save('php://output');
        die;

    }



    public function getClasamentListSerii ($CompetitionId){
   
        
        $dataset = $this->BObject()->GetClasamentSerii($CompetitionId);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // header
        $row = 4;
        $col = 'B';
        $sheet->setCellValue('B2', 'Lista participanti');

        function IncColumn(&$column){
            $loc = $column;
            $column++;
            return $loc;
        }

        function IncRow(&$row){
            $loc = $row;

            $row++;            
            return $loc;
        }


        $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('#');

        $sheet->setCellValue(IncColumn($col).$row, 'BIB');
        $sheet->setCellValue(IncColumn($col).$row, 'Serie');
        $sheet->setCellValue(IncColumn($col).$row, 'Nume');
        $sheet->setCellValue(IncColumn($col).$row, 'Categorie');
        $sheet->setCellValue(IncColumn($col).$row, 'Echipa');
       
        IncRow($row);
        $col = 'B';

        foreach($dataset as $d){
            $sheet->setCellValue(IncColumn($col).$row, strval($d->BIB));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->NrSerie));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Person));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Category));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Team));
           
            $col = 'B';
            IncRow($row);
        }

        $col = 'B';
        for ($i = 1; $i <= 20; $i++) {
            $sheet->getStyle($col)->getAlignment()->setHorizontal('left');
            $sheet->getColumnDimension(IncColumn($col))->setAutoSize(true);
        }


        ob_clean();
        $writer = new Xlsx($spreadsheet);

        $filename = 'listaCompetitieSerii.xlsx';
        
        
        header('Content-Description: File Transfer');
        header('Content-Type:  application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$filename");

        ob_end_clean();
        $writer->save('php://output');
        die;

    }

    public function getClasamentSquads ($CompetitionId, $Day){
      

        $dataset = $this->BObject()->GetCompetitors($CompetitionId);
        $info = Competition::getCompetitionInfo($CompetitionId);
        $title = $info->NumeLung;


        $date = $Day==1?$info->StartDate: $info->EndDate;


        // header
        $row = 7;
        $col = 'A';
        $nr = 0;
      
        function IncColumn(&$column){
            $loc = $column;
            $column++;
            return $loc;
        }

        function IncRow(&$row){
            $loc = $row;

            $row += 2;            
            return $loc;
        }

        $inputFileType = 'Xlsx'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
        $inputFileName = "Templates/Squad.xlsx";

        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a Spreadsheet Object  **/


        $spreadsheet = $reader->load($inputFileName);
        $sheet = clone $spreadsheet->getSheet(0);


        $spreadsheet2 =  new Spreadsheet();
        $spreadsheet2->getDefaultStyle()->getNumberFormat()->setFormatCode('#');
        $spreadsheet2->addExternalSheet($sheet);

        $sheet2 = $spreadsheet2->getSheet(1);
        $sheet2->setTitle('Seria 1');
    
        $sheet2->setCellValue('A2','Seria '. $nr + 1);
        $sheet2->setCellValue('C1',$title);
        $sheet2->setCellValue('AC1',$date);

        foreach($dataset as $d){

            if ($nr + 1 < $d->NrSerie){
                $nr++;
               // break;
                unset($sheet2);
                unset($sheet);
                unset($spreadsheet);

                $spreadsheet = $reader->load($inputFileName);
                $sheet = $spreadsheet->getSheet(0);

                $sheet->setTitle('Seria '.$d->NrSerie);

                $spreadsheet2->addExternalSheet($sheet);
                $sheet2 = $spreadsheet2->getSheet($nr + 1);
                $sheet2->setCellValue('A2', 'Seria '. $d->NrSerie);
                $sheet2->setCellValue('C1',$title);
                $sheet2->setCellValue('AC1',$date);
                $row = 7;


            }

           // $sheet2->setCellValue(IncColumn($col).$row, strval($d->LocSerie));
            $sheet2->setCellValue(IncColumn($col).$row, strval($d->BIB));
            $sheet2->setCellValue(IncColumn($col).$row, strval($d->Name));
            $col = 'A';
            IncRow($row);
        }

        $spreadsheet2->removeSheetByIndex(0);

        ob_clean();
        $writer = new Xlsx($spreadsheet2);

        $filename = 'Squads.xlsx';
        
        
        header('Content-Description: File Transfer');
        header('Content-Type:  application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$filename");

        ob_end_clean();
        $writer->save('php://output');
        die;


    }


    public function ExportCompetitie($CompetitionId){
        $dataset = $this->BObject()->GetClasament($CompetitionId);
        $info = Competition::getCompetitionInfo($CompetitionId);

        $status = $info->Status;




        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // header
        $row = 4;
        $col = 'B';
        $sheet->setCellValue('B2', $status == 'Open'?'Lista inscrisi':($status=='Preparation'? 'Lista inscrisi':'Clasament'));

        function IncColumn(&$column){
            $loc = $column;
            $column++;
            return $loc;
        }

        function IncRow(&$row){
            $loc = $row;

            $row++;            
            return $loc;
        }


        $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('#');


        if ($status == 'Open')
            $sheet->setCellValue(IncColumn($col).$row, 'Nr'); 
        if ($status == 'Preparation')   { 
            $sheet->setCellValue(IncColumn($col).$row, 'BIB'); 
            $sheet->setCellValue(IncColumn($col).$row, 'Serie'); 

        }

        if (in_array($status, ['Finished', 'Progress']))   
            $sheet->setCellValue(IncColumn($col).$row, 'Loc'); 

        $sheet->setCellValue(IncColumn($col).$row, 'Sportiv');
        $sheet->setCellValue(IncColumn($col).$row, 'Categorie');
        $sheet->setCellValue(IncColumn($col).$row, 'Club');
        $sheet->setCellValue(IncColumn($col).$row, 'Echipa');
 
       if (in_array($status, ['Finished', 'Progress'])){
            $sheet->setCellValue(IncColumn($col).$row, strval('M1'));
            $sheet->setCellValue(IncColumn($col).$row, strval('M2'));
            $sheet->setCellValue(IncColumn($col).$row, strval('M3'));
            $sheet->setCellValue(IncColumn($col).$row, strval('M4'));
            $sheet->setCellValue(IncColumn($col).$row, strval('Total 1'));
            $sheet->setCellValue(IncColumn($col).$row, strval('M5'));
            $sheet->setCellValue(IncColumn($col).$row, strval('M6'));
            $sheet->setCellValue(IncColumn($col).$row, strval('M7'));
            $sheet->setCellValue(IncColumn($col).$row, strval('M8'));
            $sheet->setCellValue(IncColumn($col).$row, strval('Total 2'));
            $sheet->setCellValue(IncColumn($col).$row, strval('Total'));
            $sheet->setCellValue(IncColumn($col).$row, strval('Procent'));
            $sheet->setCellValue(IncColumn($col).$row, strval('ShootOff'));
            $sheet->setCellValue(IncColumn($col).$row, strval('Rezultat Cat'));
       }



        IncRow($row);
        $col = 'B';

        foreach($dataset as $d){

            if (in_array($status, ['Open', 'Finished', 'Progress']))
                $sheet->setCellValue(IncColumn($col).$row, strval($d->Position));
            if (in_array($status, ['Preparation'])) {
                $sheet->setCellValue(IncColumn($col).$row, strval($d->BIB)); 
                $sheet->setCellValue(IncColumn($col).$row, strval($d->NrSerie)); 
            }
           



            $sheet->setCellValue(IncColumn($col).$row, strval($d->Person));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Category));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Team));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->TeamName));

            if (in_array($status, ['Finished', 'Progress'])){
                $sheet->setCellValue(IncColumn($col).$row, strval($d->M1));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->M2));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->M3));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->M4));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->Total1));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->M5));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->M6));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->M7));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->M8));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->Total2));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->Total));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->Procent));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->ShootOffS));
                $sheet->setCellValue(IncColumn($col).$row, strval($d->ResultatCat));
                

            }
               
         


            $col = 'B';
            IncRow($row);
        }

        $col = 'B';
        for ($i = 1; $i <= 20; $i++) {
            $sheet->getStyle($col)->getAlignment()->setHorizontal('left');
            $sheet->getColumnDimension(IncColumn($col))->setAutoSize(true);
        }


        ob_clean();
        $writer = new Xlsx($spreadsheet);

        $filename = 'Competitie.xlsx';
        
        
        header('Content-Description: File Transfer');
        header('Content-Type:  application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$filename");

        ob_end_clean();
        $writer->save('php://output');
        die;
    }



    public function ExportClasamente($CompetitionId){
            
            function IncColumn(&$column){
                $loc = $column;
                $column++;
                return $loc;
            }

            function IncRow(&$row){
                $loc = $row;

                $row++;            
                return $loc;
            }
            function GetCol($col, $nr){
  
                return chr(ord($col) + $nr);
            }

            function ChangeColor($color){

                $color2 = 'd5e7f7';
                $color1 = 'ebf4fc';

                if ($color == $color1)
                    $color = $color2;
                else 
                    $color = $color1;

                return $color;

            }

        $dataset = $this->BObject()->GetClasament($CompetitionId);
        $info = Competition::getCompetitionInfo($CompetitionId);
        
        $dsCategorie = $this->BObject()->GetClasamentCategory($CompetitionId);
        $dsTeam = $this->BObject()->GetClasamentTeams($CompetitionId);
       
        $status = $info->Status;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // header
        $row = 4;
        $col = 'B';
        $sheet->setCellValue($col.$row, 'Clasament pe categorii');
        $sheet->getStyle($col.$row)->getFont()->applyFromArray(['bold' => TRUE,]);




        $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('#');

        // Clasament pe categorii
        IncRow($row);
        $sheet->getStyle($col.$row.':'.GetCol($col,3).$row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('76b9f5');
        $sheet->setCellValue(IncColumn($col).$row, 'Loc'); 
        $sheet->setCellValue(IncColumn($col).$row, 'Categorie');
        $sheet->setCellValue(IncColumn($col).$row, 'Sportiv');
        $sheet->setCellValue(IncColumn($col).$row, strval('Total'));
       

        IncRow($row);
        $col = 'B';

        $OldCat = '';
        $color = '';
        ChangeColor($color);

        foreach($dsCategorie as $d){

            $sheet->setCellValue(IncColumn($col).$row, strval($d->loc));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Category));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Person));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Total));
  

            if ($d->Category != $OldCat){
                $color = ChangeColor($color);
                $OldCat = $d->Category;
            }

            $sheet->getStyle('B'.$row.':E'.$row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($color);

            $col = 'B';
            IncRow($row);
        }


         // Clasament pe echipe
        $col = 'B';
        IncRow($row);
        $sheet->setCellValue($col.$row, 'Clasament pe echipe');
        $sheet->getStyle($col.$row)->getFont()->applyFromArray(['bold' => TRUE,]);

        IncRow($row);
        $col = 'B';
        $sheet->getStyle($col.$row.':'.GetCol($col,3).$row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('76b9f5');
         $sheet->setCellValue(IncColumn($col).$row, 'Loc'); 
         $sheet->setCellValue(IncColumn($col).$row, 'Echipa');
         $sheet->setCellValue(IncColumn($col).$row, 'Membrii');
         $sheet->setCellValue(IncColumn($col).$row, strval('Toal'));

 
         IncRow($row);
         $col = 'B';
 
         foreach($dsTeam as $d){
             $sheet->setCellValue(IncColumn($col).$row, strval($d->Loc));
             $sheet->setCellValue(IncColumn($col).$row, strval($d->Team));
             $sheet->setCellValue(IncColumn($col).$row, strval($d->Members));
             $sheet->setCellValue(IncColumn($col).$row, strval($d->Total));
 
             $col = 'B';
             IncRow($row);
         }


        // open
        $col = 'B';
        IncRow($row);
        $sheet->setCellValue($col.$row, 'Clasament Open');
        $sheet->getStyle($col.$row)->getFont()->applyFromArray(['bold' => TRUE,]);

        IncRow($row);
        $col = 'B';
        $sheet->getStyle($col.$row.':'.GetCol($col,18).$row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('76b9f5');
        $sheet->setCellValue(IncColumn($col).$row, 'Loc'); 
        $sheet->setCellValue(IncColumn($col).$row, 'Sportiv');
        $sheet->setCellValue(IncColumn($col).$row, 'Club');
        $sheet->setCellValue(IncColumn($col).$row, 'Categorie');
        $sheet->setCellValue(IncColumn($col).$row, 'Echipa');

        $sheet->setCellValue(IncColumn($col).$row, strval('1'));
        $sheet->setCellValue(IncColumn($col).$row, strval('2'));
        $sheet->setCellValue(IncColumn($col).$row, strval('3'));
        $sheet->setCellValue(IncColumn($col).$row, strval('4'));
        $sheet->setCellValue(IncColumn($col).$row, strval('Tot 1'));
        $sheet->setCellValue(IncColumn($col).$row, strval('5'));
        $sheet->setCellValue(IncColumn($col).$row, strval('6'));
        $sheet->setCellValue(IncColumn($col).$row, strval('7'));
        $sheet->setCellValue(IncColumn($col).$row, strval('8'));
        $sheet->setCellValue(IncColumn($col).$row, strval('Tot 2'));
        $sheet->setCellValue(IncColumn($col).$row, strval('Total'));
        $sheet->setCellValue(IncColumn($col).$row, strval('Procent'));
        $sheet->setCellValue(IncColumn($col).$row, strval('ShOff'));
        $sheet->setCellValue(IncColumn($col).$row, strval('Rez Cat'));
     



        IncRow($row);
        $col = 'B';

        foreach($dataset as $i=>$d){
            if ($i < 3)
                $sheet->getStyle($col.$row.':'.GetCol($col,18).$row)->getFont()->getColor()->setARGB('cc6016');

            $sheet->setCellValue(IncColumn($col).$row, strval($d->Position));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Person));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Team));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Category));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->TeamName));

            $d->M1==25? ($sheet->getStyle($col.$row)->getFont()->getColor()->setARGB('ff0000')):'';
            $sheet->setCellValue(IncColumn($col).$row, strval($d->M1));
            $d->M2==25? ($sheet->getStyle($col.$row)->getFont()->getColor()->setARGB('ff0000')):'';
            $sheet->setCellValue(IncColumn($col).$row, strval($d->M2));
            $d->M3==25? ($sheet->getStyle($col.$row)->getFont()->getColor()->setARGB('ff0000')):'';
            $sheet->setCellValue(IncColumn($col).$row, strval($d->M3));
            $d->M4==25? ($sheet->getStyle($col.$row)->getFont()->getColor()->setARGB('ff0000')):'';
            $sheet->setCellValue(IncColumn($col).$row, strval($d->M4));

            $sheet->setCellValue(IncColumn($col).$row, strval($d->Total1));
            $d->M5==25? ($sheet->getStyle($col.$row)->getFont()->getColor()->setARGB('ff0000')):'';
            $sheet->setCellValue(IncColumn($col).$row, strval($d->M5));
            $d->M6==25? ($sheet->getStyle($col.$row)->getFont()->getColor()->setARGB('ff0000')):'';
            $sheet->setCellValue(IncColumn($col).$row, strval($d->M6));
            $d->M7==25? ($sheet->getStyle($col.$row)->getFont()->getColor()->setARGB('ff0000')):'';
            $sheet->setCellValue(IncColumn($col).$row, strval($d->M7));
            $d->M8==25? ($sheet->getStyle($col.$row)->getFont()->getColor()->setARGB('ff0000')):'';
            $sheet->setCellValue(IncColumn($col).$row, strval($d->M8));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Total2));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->Total));
            $sheet->getStyle($col.$row)->getNumberFormat()->setFormatCode('0.00');
            $sheet->setCellValueExplicit(IncColumn($col).$row, $d->Procent, DataType::TYPE_NUMERIC);
            $sheet->setCellValue(IncColumn($col).$row, strval($d->ShootOffS));
            $sheet->setCellValue(IncColumn($col).$row, strval($d->ResultatCat));
 
            $col = 'B';
            IncRow($row);
        }

        $col = 'E';
        $sheet->getColumnDimension('B')->setWidth(30, 'pt');
        $sheet->getColumnDimension('C')->setWidth(150, 'pt');
        $sheet->getColumnDimension('D')->setWidth(150, 'pt');

        for ($i = 1; $i <= 20; $i++) {
            $sheet->getStyle($col)->getAlignment()->setHorizontal('left');
            $sheet->getColumnDimension(IncColumn($col))->setAutoSize(true);
        }


        ob_clean();
        $writer = new Xlsx($spreadsheet);

        $filename = 'ClasamentFinal.xlsx';
        
        
        header('Content-Description: File Transfer');
        header('Content-Type:  application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$filename");

        ob_end_clean();
        $writer->save('php://output');
        die;
    }

}