@extends('layouts.base')


    @push('css')

    @endpush


       @push('scripts')

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
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.columnsresize.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.aggregates.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/form-components/form-validation.min.js')}}"></script> 
 

    

  	<script type="text/javascript" src={{asset('js/frame/masterdetail.js')}}></script>

     
      
    <link rel="stylesheet" href="{{asset('js/components/jqwidgets/styles/jqx.base.css')}}" type="text/css" />
      
        @yield('masterdetail')
            
        <script>

            

            var MasterFields = [];
            var DefaultMasterValues = [];
            var DefaultDetailValues = [];

            MasterPrimaryKeyValue = @Json($MasterPrimaryKeyValue);
   

            @isset($MasterFields)
                var MasterFields = @JSON($MasterFields);
            @endisset
           
            @isset($DefaultMasterValues)
                var DefaultMasterValues = @JSON($DefaultMasterValues);
            @endisset
            
            @isset($DefaultDetailValues)
                var DefaultDetailValues = @JSON($DefaultDetailValues);
            @endisset

            @isset($MasterPrimaryKey)
                var MasterPrimaryKey = @JSON($MasterPrimaryKey);
            @endisset

            @isset($DetailPrimaryKey)
                var DetailPrimaryKey = @JSON($DetailPrimaryKey);
            @endisset

            @isset($DefaultFilter)
                LastFilter = @JSON($DefaultFilter)[1];
            @endisset

        </script>
    @endpush
    

    @push('content')
    
   
        @isset($subtabs)
            @foreach($subtabs as $subtab)
            <ul class="nav-tabs nav">
                <li class="nav-item">
                    <a role="tab" class="nav-link mol-nav-link-detail 
                    @if ($loop->first)
                        active
                    @endif

                            " id="tab-detail-{{$loop->index}}"  href="#" onclick="doDetailTab('{{$loop->index}}')">
                        <span>{{$subtab->caption}}</span>
                    </a>
                </li>
            </ul>
            @endforeach
        @endisset
   

	
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">


            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-medal icon-gradient bg-tempting-azure"></i>
                </div>
                <div>@stack('title')
                    <div class="page-title-subheading">@stack('description')</div>

                </div>
            </div>
            
            <div class="page-title-actions">
            	


                @stack('headerbuttons')

            </div>   
         </div>
    </div>
    
    
     
    @stack('maincard')
                
     <div class="main-card mb-3 card" id = "maincard">
        <div class="card-header">
        

        
            <div  class="d-inline-block dropdown justdetail invisible molactionbutton" >
    
                <button id = 'molactionbutton' type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                        class="btn-shadow dropdown-toggle btn btn-info">

                
                    <!-- <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="fa fa-angle-double-right fa-w-20"></i>
                    </span> -->
                    {{trans('general.actions')}}
                </button>
                
                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                    <ul id="ul-actions" class="nav flex-column">
                        @stack('actions')
                      
                      
                    </ul>
                </div>
            </div>
            
                
                
        </div>
        <div class="card-body">
            
            <div class="tab-content">
            
                <div class="tab-pane mol-tab-pane" id="tab-detail" role="tabpanel">
                
                    <div class = "row detail-tab">
                        @stack('subtab')
                    </div>
                    <form  method="POST" id="detailform" 
                    
                                @if (!isset($DeniedPermissions) || in_array("Edit", $DeniedPermissions)) 
                                    class="readonly" 
                                @endif
                    
                    >

                    @if (!isset($DeniedPermissions) || !in_array("Edit", $DeniedPermissions))
                   

                        <div class="d-block text-right card-footer">
                            <a href="javascript:CancelUpdates();" class="btn-wide btn btn-secondary">Cancel</a>
                            <button type ="submit" class="btn-wide btn btn-success editable">Save</button>
                        </div>  

                    @endif

                        <div class="mol-tab" id="detail-0">
                            <input id="isnew" name= "isnew" hidden>
                        
                            @stack('detail')

                            <div id="MasterDetailDetail" class="form-row">
                                <div class="col-md-12">
                                    <label for="documentdetails">Details</label>
                                    @if (!isset($DeniedPermissions) || !in_array("Edit", $DeniedPermissions))
                                    <div class="text-right p-1">
                                        <button id= "deletedetail" type="button" data-toggle="tooltip" class="btn-shadow  btn btn-danger editable detailbtn" title="" onclick="deleteDetail()" data-original-title="Delete"><i class="fa fa-minus"></i></button>
                                        <button id= "adddetail" type="button" data-toggle="tooltip" class="btn-shadow  btn btn-primary editable detailbtn" title="" onclick="addDetail()" data-original-title="Add"><i class="fa fa-plus"></i></button>
                                    </div>

                                    @endif

                                    <div id='jqxWidget' style="font-size: 12px; font-family: Verdana;">
                                        <div id="documentdetails">
                                        
                                        </div>
                                    </div>
                                </div>	
                            </div>
                        </div>
                            
                        @stack('afterdetail')
                    </form> 
               </div>
            </div>
        </div>
    </div> 
</div>    



@endpush

@push('dialogs')

<div id="AttachModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Attach file</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body">
            	<form id="uploadform" class="form-horizontal" method="post" name="uploadform" enctype="multipart/form-data">
                                    			{!! csrf_field() !!}
                	<input class="btn-primary" name="file" id="theFile" type="file" class="form-control-file">
                	<small>Description</small>
                	<input name="description" id="attachdescription" type="text" class="form-control-file">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="buttonUpload" type="button" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</div>



@include('frame/filter')

@endpush

<!-- end masterdetail -->