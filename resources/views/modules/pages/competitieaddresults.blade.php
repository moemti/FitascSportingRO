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


    <script type="text/javascript" src="{{asset('js/frame/masterlist.js')}}"></script>
    <script src="{{asset('js/pages/resultseditall.js')}}"></script>

    <link rel="stylesheet" href="{{asset('js/components/jqwidgets/styles/jqx.base.css')}}" type="text/css" />


<script>
    
    let master= @Json($masterlist);
    
    
    
</script>
@endpush



@push('content')
<section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">
        
    <div class='row'>
        
        <div>
            <h5 > Adaugare rezultate </h5><p>{{$Title}}</p>
        </div>
    </div>
    <a href="{{url('/clasament/').'/'.$MasterFilter}}" class="btn-wide btn btn-primary editable">Competitie</a>            
     
                                
        <input id='MasterFilter' value = "{{$MasterFilter}}" hidden>

       

            <!-- <button id="exportpdf">PDF</button> -->

            <div id ="jqxGrid" class="gridnou">
                    
            </div>
            <div class="text-right u-margin-top-medium">
                <button id="cancelMaster" class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-danger btn-lg">Anuleaza</button>
                <button id="saveMaster" class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Salveaza</button>
        </div>

    </div>
    
 </section>

 @endpush