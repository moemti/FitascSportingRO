<?php

namespace App\Http\Controllers;



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;
use App\Models\Dictionaries\Dictionary;

class CompetitiiController extends MasterController
{
    public $BObject = 'App\Models\Competitions\Competition';

    public $views = ['master'=>'modules.pages.competitii', 'detail' => 'modules.pages.competitiidetail'];

    public function getDictionaries(){
        return ['years' => $this->BObject()->getCompetitionYears()];
    }

    public function getClasament($ItemId){
        return view( 'modules.pages.competitiedetail',['master' => $this->BObject()->getMaster($ItemId), 'clasament' => $this->BObject()->GetClasament($ItemId)]);
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
        return view('modules.pages.gallery', ["images" => $images]);
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


}