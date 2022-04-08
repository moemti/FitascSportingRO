@extends('layouts.baseex')

@push('footerscripts')

<script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxcore.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxdata.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxbuttons.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxscrollbar.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxmenu.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxcheckbox.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxlistbox.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxdropdownlist.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.sort.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.pager.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.selection.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.edit.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.filter.js')}}"></script> 
   

    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxdata.export.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.export.js')}}"></script> 
	<script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxexport.js')}}"></script> 


	<!-- JSZip -->
    <script type="text/javascript" src="{{asset('js/components/scripts/jszip.min.js')}}"></script>

    <script defer type="module" src="{{asset('js/pages/competitie.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/competitii.css')}}"/>
    <link rel="stylesheet" href="{{asset('js/components/jqwidgets/styles/jqx.base.css')}}" type="text/css" />


<script>

        let dsClasament= @Json($clasament);
        let dsClasamentCat = @Json($clasamentcategorie);
        let dsClasamentTeam = @Json($clasamentteams);

        let Status = '{{$master[0]->Status}}' ; 

</script>
@endpush

@push('sidebar_left')   
        
@endpush

@push('content')

<section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">
        
        <div class="page_content_header text-center pt-3">
         

             <input id="CompetitionId" value='{{$master[0]->CompetitionId}}' hidden> </input>




        <div class='row'>


            <div class="mb-12">
                <h2 id="p_competitie" value='' > {{$master[0]->Name}}</h2>
              
            </div>
        </div>


            
        <div class='row'>
        
            <div>
                <h3 id="p_locatie" value=''> {{$master[0]->Range}}</h3>
            </div>
        </div>
      

        <div class='row'>

            <div class="d-flex">


               <strong> <p id="p_startdate" value=''> {{$master[0]->StartDate}}</p></strong>
               <div class="ms-2  me-2">   -   </div> 
                <strong>  <p id="p_enddate" value=''>{{$master[0]->EndDate}} </p> </strong> 
            </div>
            @if ( file_exists('img/gallery/competitions/'.$master[0]->CompetitionId ))
                <a href="{{url('/gallery/').'/'.$master[0]->CompetitionId}}" class = "btn-galerie btn btn-primary btn-outline mb-2" >Vezi galerie</a>
            @endif
                <span class="compet_status {{$master[0]->Status}}">{{$master[0]->Status}}</span> 
                <div class="btnwrapper m-2">
                    @switch($master[0]->Status)
                        @case('Closed')
                        
                            @if (session("IsSuperUser") == 1)
                            <button id="btnOpen" data-status="Open" class = "cmpStatusChange btn btn-primary btn-outline mb-2" >Deschide</button>
                            @endif
                            @break
                        @case('Open')

                        @if (session("PersonId"))
                       
                            @php 

                                $exists = false;

                                $cl =  $clasament;
                                foreach( $cl as $person) {
                                    if ($person->PersonId === session("PersonId")){
                                        $exists = true;
                                        break;

                                    }
                                }


                            @endphp    
                            @if ($exists)
                                <button id="btnUnRegister" class = "btn-register btn btn-danger btn-outline mb-2" >Nu mai particip</button>
                            @else
                                 <button id="btnRegister" class = "btn-register btn btn-primary btn-outline mb-2" >Ma inscriu</button>
                            @endif

                        @endif

                        @if (session("IsSuperUser") == 1)
                            <button id="btnClose"  data-status="Closed" class="cmpStatusChange btn btn-secondary btn-outline mb-2">Close</button>
                            <button id="btnOngoing"  data-status="Progress" class="cmpStatusChange btn btn-secondary btn-outline mb-2">Start competition</button>
                            <button id="btnCreateSquadsAll"  data-type="All" class="createSquads btn btn-secondary btn-outline mb-2">Create squads all</button>
                            <button id="btnCreateSquadsDiff"  data-type="Diff" class="createSquads btn btn-secondary btn-outline mb-2">Create squads diff</button>
                            <button id="btnDeleteSquads"  data-type="Clear" class="createSquads btn btn-secondary btn-outline mb-2">Clear squads</button>
                            <a id="btnDownloadListaAll" href="{{url('/competitionListDown/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Download lista</a>
                            <div class="row"> 
                            <div class="btnwrapper m-2">
                            <b>Download serii</b>
                            <a id="btnDownloadListaSquad1" href="{{url('/competitionDownSquads/').'/'.$master[0]->CompetitionId}}/1" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Ziua 1</a>
                            <a id="btnDownloadListaSquad2" href="{{url('/competitionDownSquads/').'/'.$master[0]->CompetitionId}}/2" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Ziua 2</a>
                            </div>
                            </div>
                        @endif
                        <a id="btnDownloadListaAll" href="{{url('/competitionListDownSerii/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Download serii</a>
                        @break

                    @case('Progress')     
                         @if (session("IsSuperUser") == 1)
                            <button id="btnOpen" data-status="Open" class = "cmpStatusChange btn btn-secondary btn-outline mb-2" >Open</button>
                            <button id="btnFinish"  data-status="Finished" class="cmpStatusChange btn btn-secondary btn-outline mb-2">Finish competition</button>
                            <a id="btnDownloadListaSquad1" href="{{url('/competitionDownSquads/').'/'.$master[0]->CompetitionId}}/1" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Ziua 1</a>
                            <a id="btnDownloadListaSquad2" href="{{url('/competitionDownSquads/').'/'.$master[0]->CompetitionId}}/2" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Ziua 2</a>
                            <a id="btnDownloadListaAll" href="{{url('/competitionListDown/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Download lista</a>
                            <a id="btnAddResults"  href="{{url('/editresultsall/').'/'.$master[0]->CompetitionId}}" data-status="Finished" class=" btn btn-secondary btn-outline mb-2">Adauga rezultate</a>
                        @endif
                        <a id="btnDownloadListaAll" href="{{url('/competitionListDownSerii/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Download serii</a>

                        @break


                    @case('Finished')
                      
                        @if (session("IsSuperUser") == 1)
                            <button id="btnOngoingR"  data-status="Progress" class="cmpStatusChange btn btn-secondary btn-outline mb-2">Reopen competition</button>
                        @endif
                        @break

                @endswitch
          
                </div>


            
        </div>

      



    </div>
                                
       @if ($master[0]->Status == 'Finished')
       <h6>Clasamente categorii</h6>
        <div id ="jqxGridCat" class="gridnou">
                    
        </div> 

        <h6>Clasamente pe echipe</h6>
        <div id ="jqxGridTeam" class="gridnou">
                    
        </div> 

       @endif
       <div class="d-flex text-left">
        @switch($master[0]->Status)
            @case('Finished')


               
            @case('Progress')
                <h4>Clasament open</h4>
                @break
        
            @case('Open')
                <h4>Inscrisi</h4>
                @break
        
            @default
                
        @endswitch

          </div>


        <div class="d-flex text-right">

            @if ((session('IsSuperUser') == 1) && (in_array(  $master[0]->Status,  array("Open","Progress"))  ))

                <div class='row'>
                    <button id="addCompetitor" class = "btn-add btn btn-sm" >Adauga</button>
                </div>

            @endif
            </div>
            <button id="exportexcel">Excel</button>

            <!-- <button id="exportpdf">PDF</button> -->

            <div id ="jqxGrid" class="gridnou">
                    
            </div>
        

    </div>
    
 </section>

@endpush