<div id="editschedule" class="page_content page_content_master ">
        <h2>Program tragere</h2>

        <form class="" action="changeschedule" method="POST">
            @csrf
            <input Name = "CompetitionId" id="CompetitionId" value="{{$CompetitionId}}" hidden>

                <style>
                 table, th, td  {
                    border: 1px solid black; /* Add a border to all table rows */
                }
                </style>


           
            @php
                for ($day = 0; $day < 2; $day++)
                {               
                   $zi = $day + 1;

                   echo "<div><h4>Ziua $zi </h4></div> ";
                   echo "<table id='table$zi'>
                        <tr class = 'mark'>";
                      
                    $dataset = $schedule[$day];
                     
                    if (count($dataset) == 0)
                        return;

                    $ScheduleType = $dataset[0]->ScheduleType;
                    $NrPosturiPoligon = $dataset[0]->NrPosturiPoligon;
                    $spantotal = $dataset[0]->NrPosturiPoligon * $dataset[0]->NrPoligoane + 1;
                    $poligoane = [];

                    if ($ScheduleType != 'Normal'){ // condensat

                         echo "<td style='text-align: center;' ><label>Poligon</label></td>";

                        // header
                        foreach($dataset as $d){
                                $p =  "Poligon " . intdiv($d->Poligon + 1, $NrPosturiPoligon);
                                $post = ' P '. (($d->Poligon + 1) % $NrPosturiPoligon) + 1 ;
                            
                            if  (!in_array($p , $poligoane)){

                                echo "<td style='text-align: center;' colspan ='$NrPosturiPoligon' ><label>";
                                    echo $p;
                                   
                                echo '</label></td>';

                                array_push($poligoane, $p);
                            }
                        }

                        echo "</tr><tr class = 'mark'>";

                        echo "<td style='text-align: center;'><label>Ora\Post</label></td>";

                        for ($i = 1; $i <= count($poligoane) * 2;  $i++ ){

                              echo "<td style='text-align: center;'><label>";
                              echo 'P '.  (($i%$NrPosturiPoligon) == 0?$NrPosturiPoligon: $i%$NrPosturiPoligon);
                                   
                              echo '</label></td>';

                        }
                        echo "</tr>";

                        // orarul
                        $IsNew = true;
                        $OldOra = "";

                        foreach($dataset as $key => $d){
                            if ($OldOra != strval( substr($d->Ora, 11, 5))){
                               if (!$IsNew){
                                    echo "</tr>";


                                if ($key == count($dataset)/2 ){
                                    echo "<tr><td  style='text-align: center;' class = 'mark' colspan ='$spantotal' >$MinutePauza minute pauza</td></tr>"; 
                                }
                               }
                                $IsNew = false;
                                $OldOra = strval( substr($d->Ora, 11, 5));
                                echo '<tr>';
                                echo '<td style="text-align: center;" class = "mark"><label>';
                                echo $OldOra;
                                echo '</label></td>';
                            }

                            $p =  $d->Poligon; //intdiv($d->Poligon + 1, $NrPosturiPoligon);
                            $post = (($d->Poligon + 1) % $NrPosturiPoligon) + 1 ;
                            $ora = $d->Ora;
                        
                            echo "<td style='text-align: center;' ><input class='scheduledata' data-day='$zi' data-poly='$p' data-pos='$post' data-ora = '$ora' style='text-align: center; width:100%; border:0;' value='";
                            echo  strval(($d->Serie == 0)?'':$d->Serie);
                            echo "' type = 'number'/></td>";
                        }
                    }
                    else{
                            echo "<td style='text-align: center;' ><label>Ora\Poligon</label></td>";
                        // header
                        foreach($dataset as $d){
                                $p =  "Poligon " .$d->Poligon ;
                            
                            if  (!in_array($p , $poligoane)){

                                echo "<td style='text-align: center;' ><label>";
                                    echo $p;
                                   
                                echo '</label></td>';

                                array_push($poligoane, $p);
                            }
                        }
                        // orarul
                        $IsNew = true;
                        $OldOra = "";

                        foreach($dataset as $key => $d){
                            if ($OldOra != strval( substr($d->Ora, 11, 5))){
                               if (!$IsNew){
                                    echo "</tr>";


                               }
                                $IsNew = false;
                                $OldOra = strval( substr($d->Ora, 11, 5));
                                echo '<tr>';
                                echo '<td style="text-align: center;" class = "mark"><label>';
                                echo $OldOra;
                                echo '</label></td>';
                            }

                            

                            $p =  $d->Poligon; //intdiv($d->Poligon + 1, $NrPosturiPoligon);
                            $post = (($d->Poligon + 1) % $NrPosturiPoligon) + 1 ;
                            $ora = $d->Ora;
                        
                            echo "<td style='text-align: center;'><input class='scheduledata' data-day='$zi' data-poly='$p' data-pos='$post' data-ora = '$ora' style='text-align: center; width:100%; border:0;' value='";
                            echo  strval(($d->Serie == 0)?'':$d->Serie);
                            echo "' type = 'number'/></td>";

                         
                        }
                    }
                    echo '</table>';
                }
            @endphp
        </form>
</div>