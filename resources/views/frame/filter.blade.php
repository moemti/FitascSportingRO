<div id="FilterModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle">Filter</h5>
               
            </div>
            <div class="modal-body">
            	<form id="filterformmodal" class="form-horizontal" method="post" name="filterformmodal" enctype="multipart/form-data">

                    <input name="FilterString" id="FilterString" hidden> 
                    <input name="LastFilterString" id="LastFilterString" hidden> 
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="position-relative form-group"><label for="Description">Fields</label></div>
                            
                        </div>
                    </div>
                  
                    <div class="row">
                                <div class="col-md-4">
                                    <div id="filterfields"></div>
                                </div>
                                <div class="col-md-4">
                                    <div id="operators"></div>
                                </div>
                                <div class="col-md-4">
                                    <input id="fieldvalue">
                                </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                  
                    <button  id="putbraces" type="button" data-toggle="tooltip" class="mr-5 btn-hover-shine btn btn-primary" title="Put braces ()" data-original-title="Add filter">
                            ( )
                        </button>

                        <input type="checkbox" class="form-check-input" id="not" name="not" value=" not " >   
                        <label for="not">not</label><br>
                        <div id = "and">
                            
                            <input type="radio" id="and" name="and" value=" and " checked>
                            <label for="and">AND</label><br>
                            
                            <input type="radio" id="or" name="and" value=" or ">
                            <label for="or">OR</label>
                        </div>

                        <button  id="addfilter" type="button" data-toggle="tooltip" class="btn-shadow mr-3 btn btn-primary " title="Add filter" data-original-title="Add filter">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button  id="deletefilter" type="button" data-toggle="tooltip" class="btn-shadow mr-3 btn btn-danger " title="Delete filter" data-original-title="Delete filter">
                            <i class="fa fa-minus"></i>
                        </button>
                     
                        
                    </div>


                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="FilterValue">Filter </label>
                                <div>
                                    <button  id="undofilter" type="button" data-toggle="tooltip" class="btn-shadow mr-3 btn btn-primary " 
                                                title="Undo filter" data-original-title="Undo filter" onclick="UndoFilter(-1)">
                                        <i class="fa fa-angle-left"></i>
                                    </button>
                                    <button  id="redofilter" type="button" data-toggle="tooltip" class="btn-shadow mr-3 btn btn-danger " 
                                                title="Redo filter" data-original-title="Redo filter" onclick="UndoFilter(1)">
                                        <i class="fa fa-angle-right"></i>
                                    </button>
                                </div>
                                <div id="filterlist"></div>
                                <!-- <textarea name="FilterValue" id="FilterValue" class="form-control" rows="10"></textarea> -->
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button id= "FilterCloseBtn"class="btn btn-secondary"  type="button" data-original-title="Close filter">Close</button>
                        <button id= "FilterSubmitBtn" type ="button"  class="btn btn-primary" data-original-title="Filter documents"  >Filter</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>

<script>

    var filtersource = [];
    @if (isset($FilterSource))

        filtersource = @JSON($FilterSource);
    @endif

    
    var filterresult = [];
    var fiterhistory = [];
    var currentfilter = -1;
    var filter = "";

    var operatori = [
                    " = ",
                    " > ",
                    " >= ",
                    " < ",
                    " <= ",
                    " like ",
                    " <> ",
                    " Is Null ",
        ];     
        

    function CheckHistory(){
        if (currentfilter < fiterhistory.length - 1){
            // s-a facut undo
            //adaugam in hisory ca si ultima intregistrare istoria curenta
            fiterhistory.push(JSON.parse(JSON.stringify(fiterhistory[currentfilter])));
            currentfilter = fiterhistory.length - 1;

        }

        DoUndoButtons();
    }
    function RefreshFilterGrid(){

        CheckHistory();


        currentfilter += 1;
        const cloneFilter = filterresult.slice();

        fiterhistory.push(JSON.parse(JSON.stringify(cloneFilter)));

        $("#filterlist").jqxListBox({source: filterresult});
        $("#filterlist").jqxListBox('refresh'); 
        DoUndoButtons()
    }

    function UndoFilter(direction){
        if (direction == -1){
            if (currentfilter > 0){
                currentfilter += -1;
                //filterresult = fiterhistory[currentfilter];

                filterresult = JSON.parse(JSON.stringify(fiterhistory[currentfilter]))
                $("#filterlist").jqxListBox({source: filterresult});
                $("#filterlist").jqxListBox('refresh'); 
            }
        }

        if (direction == 1){
            if (currentfilter < fiterhistory.length - 1){
                currentfilter += 1;
                filterresult = JSON.parse(JSON.stringify(fiterhistory[currentfilter]))
                $("#filterlist").jqxListBox({source: filterresult});
                $("#filterlist").jqxListBox('refresh'); 
            }
        }
        DoUndoButtons();
    }

    function DoUndoButtons(){
        $('#undofilter').attr('disabled', !(currentfilter > 0));
        $('#redofilter').attr('disabled', !(currentfilter < fiterhistory.length - 1))  ;
    }

    function ValidateFilter(filter){

        // same number of ( and )
        result = "OK";

        if (filter != ""){
            var l = (filter.match(/\(/g) || []).length;
            var r = (filter.match(/\)/g) || []).length;

            if (l != r )
                result = 'Numarul de paranteze "(" difera de numarul de paranteze ")" ! :' + l+  ' vs ' + r;
        }

        return result;
    }

    $(document).ready(function () {
        $("#filterfields").jqxListBox({ selectedIndex: 33, source: filtersource, width: "100%", height: 300 });
        $("#operators").jqxListBox({ selectedIndex: 0, source: operatori, width: "100%", height: 300 });
        $("#filterlist").jqxListBox({ selectedIndex: 0, source: filterresult, width: "100%", height: 300 , multipleextended: true,});
        
        DoUndoButtons();

        $('#filterfields').on('select', function (event) {
                    var args = event.args;

                    switch (filtersource[args.index].type){
                        case "integer":
                                $('#fieldvalue').attr('type', "number").attr('step', '1');
                                break;
                        case "number":
                                $('#fieldvalue').attr('type', "number").attr('step', '0.01');
                                break;        
                        case "Date":
                                $('#fieldvalue').attr('type', "date");
                                break;
                        default: 
                            $('#fieldvalue').attr('type', "text");
                    }
                    
        });

        $("#filterfields").jqxListBox('selectIndex', 0);

        $("#customfilter").click(function(e){
            e.preventDefault();
            $("#FilterModal").modal({
                backdrop: 'static',
                keyboard: false});
                
        });

        $("#FilterCloseBtn").click(function(){
            CheckHistory();
            $('#FilterModal').modal('toggle') ;
        });


        

        $("#FilterSubmitBtn").click(function(){
            
            filter = "";
            for (var i = 0; i < filterresult.length ; i++)
                filter = filter + filterresult[i].value + ' ';

            if (filter == ""){
                result = "not ok";
                confirm("Nu ati introdus nici un filtru! Doriti sa aduceti toate intregistrarile?", GoFilter );
            }
            else   
                GoFilter();


            function GoFilter(){

                CheckHistory();

                var Eroare = ValidateFilter(filter);
                if (Eroare =="OK"){

                    $('#FilterModal').modal('toggle') ;

                    RefreshMaster(filter);
                }
                else{
                    ShowError(Eroare);
                }
            }
        });
            
            
            

        $("#deletefilter").click(function(){

            //confirm("Doriti sa stergeti filtrele selectate?", function(){

                var removeValFromIndex = [];
                var items = $("#filterlist").jqxListBox('getSelectedItems');
                
                for (var i = 0; i < items.length; i++) {
                    if (items[i] != undefined)
                    removeValFromIndex.push(items[i].index);
                }
                
                for (var i = removeValFromIndex.length -1; i >= 0; i--)
                    filterresult.splice(removeValFromIndex[i],1);
                
                // check trailing or/and
                if (filterresult.length > 0){

                    filterresult[filterresult.length - 1].label = filterresult[filterresult.length - 1].label.replace(' and ', '').replace( ' or ', '');
                    filterresult[filterresult.length - 1].value = filterresult[filterresult.length - 1].value.replace(' and ', '').replace( ' or ', '');
                }

                RefreshFilterGrid();
          //  });

        });

        
        $("#putbraces").click(function(){
            var removeValFromIndex = [];
            var items = $("#filterlist").jqxListBox('getSelectedItems');
            if (items.length < 2){
                ShowError('Alegeti cel putin doua filtre!');
                return;
            }

            for (var i = 0; i < items.length; i++) {
                if (items[i] != undefined && i == 0){
                    filterresult[items[i].index].label = ' ( ' +  filterresult[items[i].index].label;
                    filterresult[items[i].index].value = ' ( ' +  filterresult[items[i].index].value;
                }

                if (items[i] != undefined && i == items.length - 1){

                    //cautam daca are and/or in coada
                    var and = '';
                    
                    if (filterresult[items[i].index].label.indexOf(' and ') !== -1)
                        and = ' and ';
                    
                    if (filterresult[items[i].index].label.indexOf(' or ') !== -1)
                        and = ' or ';

                    filterresult[items[i].index].label = filterresult[items[i].index].label.replace(' and ', '').replace( ' or ', '');
                    filterresult[items[i].index].value = filterresult[items[i].index].value.replace(' and ', '').replace( ' or ', '');

                    filterresult[items[i].index].label = filterresult[items[i].index].label + ' ) ' + and;
                    filterresult[items[i].index].value = filterresult[items[i].index].value + ' ) ' + and;
                }
            }

            RefreshFilterGrid();

        });



        $("#addfilter").click(function(){
            
            var index = $('#operators').jqxListBox('selectedIndex'); 

            if ($("#fieldvalue").val() == "" && (index != 7)){
                ShowError("Alegeti o valoare!");
                return;
            }

            var filter = ""
            var filterV = "";
            var indexf = $('#filterfields').jqxListBox('selectedIndex'); 

            filter = $('#filterfields').jqxListBox('getItem', indexf).label + ' ';
            filterV = $('#filterfields').jqxListBox('getItem', indexf).value + ' ';
            
            
            filter = filter +  $('#operators').jqxListBox('getItem', index).label + ' ';
            filterV = filterV +  $('#operators').jqxListBox('getItem', index).label + ' ';

            var value = $("#fieldvalue").val();

            switch (filtersource[indexf].type){
                    case "string":
                            
                    case "Date":
                            value = "'" + value + "'";
                            break;
                    default:
                }

            if(index != 7){    
                filter = filter + value;
                filterV = filterV + value
            }


            if ($('#not').is(':checked')){
                filter =  ' ( not ' + filter + ' ) ' ;
                filterV =  ' ( not ' + filterV + ' ) ' ;

            }
            
            var l = filterresult.length;

            if (l > 0){
                filterresult[l-1].label = filterresult[l-1].label +  " " + $('input[name="and"]:checked', '#and').val() + ' ';
                filterresult[l-1].value = filterresult[l-1].value +  " " + $('input[name="and"]:checked', '#and').val() + ' ';
            }

            filterresult.push({label: filter, value: filterV})

            RefreshFilterGrid(); 
            $("#fieldvalue").val("");
            $("#not").prop( "checked", false );
            
        });

	});

    

</script>