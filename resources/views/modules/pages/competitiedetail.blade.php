@extends('layouts.base')

@push('scripts')

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

    <script defer type="module" src="{{asset('js/pages/competitie.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/competitii.css')}}"/>
    <link rel="stylesheet" href="{{asset('js/components/jqwidgets/styles/jqx.base.css')}}" type="text/css" />


<script>

        let dsClasament= @Json($clasament);
           

</script>
@endpush

@push('content')

<!-- <div class="detail detail_competitii ">

    <div class="page_content page_content_detail">

        <h1>Competitie</h1>


        <div class='row'>
      
    
            <div>
                <input id="input_competitie" value='{{$master[0]->Name}}' disabled> </input>
                <input id="input_sportfield" value='{{$master[0]->SportField}}'disabled> </input>
            </div>
        </div>


            
        <div class='row'>
         
            <div>
                <input id="input_locatie" value='{{$master[0]->Range}}'disabled> </input>
            </div>
        </div>

        <div class='row'>
        
            <div>
                <input id="input_startdate" value='{{$master[0]->StartDate}}'disabled> </input>
                <input id="input_enddate" value='{{$master[0]->EndDate}}'disabled> </input>
            </div>
        </div>

    </div>


    <div class="page_content page_content_master page_content_competitii">
        

        <h2>Clasament </h2>

        <div class="page_content_content">

            <div id ="jqxGrid" class="gridnou"></div>
        </div>
   

    </div>


</div> -->


<div class="page_content page_content_master page_content_competitii">
        <div class="page_content_header">
             <h1>Competitie</h1>


            <div class='row'>


                <div>
                    <input id="input_competitie" value='{{$master[0]->Name}}' disabled> </input>
                    <input id="input_sportfield" value='{{$master[0]->SportField}}'disabled> </input>
                </div>
            </div>


                
            <div class='row'>
            
                <div>
                    <input id="input_locatie" value='{{$master[0]->Range}}'disabled> </input>
                </div>
            </div>

            <div class='row'>

                <div>
                    <input id="input_startdate" value='{{$master[0]->StartDate}}'disabled> </input>
                    <input id="input_enddate" value='{{$master[0]->EndDate}}'disabled> </input>
                </div>
            </div>
            <h2>Clasament</h2>

        </div>

        <div class="page_content_content">
           
            <div id ="jqxGrid" class="gridnou">
                    
            </div>
        </div>

    </div>
    


@endpush