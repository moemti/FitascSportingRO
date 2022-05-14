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
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxcombobox.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.sort.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.pager.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.selection.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.edit.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.filter.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.grouping.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/form-components/form-validation.min.js')}}"></script> 


    <link rel="stylesheet" href="{{asset('js/components/jqwidgets/styles/jqx.base.css')}}" type="text/css" />




    <script type="text/javascript" src={{asset('js/frame/masterlist.js')}}></script>
      
      
      @stack('masterscripts')

       
          
      <script>


          var DefaultMasterValues = [];
     

          @isset($data)
            let data = @JSON($data)
          @endisset

          @isset($master)
              var master =  @JSON($master);
          @endisset

          @isset($MasterFields)
              var MasterFields = @JSON($MasterFields);
          @endisset
         
          var DefaultMasterValues = {};
          @isset($DefaultMasterValues)
               DefaultMasterValues = @JSON($DefaultMasterValues);
          @endisset
          
  

          @isset($MasterPrimaryKey)
              var MasterPrimaryKey = @JSON($MasterPrimaryKey);
          @endisset



          @isset($DefaultFilter)
              LastFilter = @JSON($DefaultFilter)[1];
          @endisset

      </script>
@endpush

@push('content')


<section class="content-termeni section section-tertiary section-no-border m-0">
        <div class="container">
            <h1>@stack('title')</h1>
    
            <h2>@stack('subtitle')</h2>

            @stack('aftertitle')

       
        
       

                @stack('content_before')
                <div class="row">
                    <div class="text-right ">
                        
                        <button id="deleteMaster" class="btn-pill btn-shadow btn-hover-shine btn btn-primary btn-sm">{{transex('Delete')}}</button>
                        <button id="addMaster" class="btn-pill btn-shadow btn-hover-shine btn btn-primary btn-sm">{{transex('Add')}}</button>
                    </div>
                </div>


                <div id="jqxGrid"></div>

                
                    
               


               
                @stack('content_after')

       
        <div class="text-right u-margin-top-medium">
                <button id="saveMaster" class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">{{transex('Salveaza')}}</button>
        </div>
        </div>

    </section>
    


@endpush