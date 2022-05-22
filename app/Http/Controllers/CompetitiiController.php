<?php

namespace App\Http\Controllers;



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

    public function editresult($ResultId){
        return view( 'modules.pages.competition.resultedit',[
                                                            'CompetitionId' => $this->BObject()->getCompetitionByResult($ResultId),
                                                            'MasterPrimaryKey' => 'ResultId',
                                                            'MasterPrimaryKeyValue' => $ResultId,
                                                            'teams' => $this->BObject()->getTeams(),
                                                            'categories' => $this->BObject()->getShootingCategories(),
                                                        
                                                        ]);
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

    public function getgallery($CompetitionId){
        $images = scandir("img/gallery/competitions/$CompetitionId");
        return view('modules.pages.gallery', ["images" => $images, "competition" => $CompetitionId]);
    }


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

}