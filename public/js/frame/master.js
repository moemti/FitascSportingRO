
	var source;
	var IsDetail = false;
	var LastFilter = '';
	var HasDetails = false;
	var MasterPrimaryKey = ""
	var DetailPrimaryKey = "";
	var selectMasterMuliple = false;

	var MasterFields= []; // this will be overriden in blade from controller
	var mydelta = [];
	var LastDocumentDetailId = -1;

	var DefaultMasterValues = {};
	var DefaultDetailValues = {};
	var documentdetailsDB= [];
	var IsDetailListModal = false;
	var HasDetailBtn = false; // has add, delete detail buttons
	var CanDeleteMaster = false;
	var filtersource = undefined;

	let urls = {
		saveurl: undefined,
		getmasterurl: undefined,
		getdetailurl: undefined,
		deleteurl: undefined,
		actionurl: undefined,
		getdictionariesurl: undefined

	};

	function DeltaDetailChanged(Oper){
		//return false; // To be overriden if needs extra validation

	
			function CheckChanged(item){
				
				if (item[DetailPrimaryKey] === Oper[DetailPrimaryKey]){
					var fields = Object.keys(Oper);

					fields.forEach(function(value){
						if (value != 'Operation'){
							if (item[value] != Oper[value]){
								Changed = true;	
							}
						}
					});
				}
				
			};

		var Changed = false; 
		documentdetailsDB.forEach(CheckChanged);
		return Changed;
	}

	function addDeltaOperation(Oper){
		// check if already exist
		var Exists = false;
		
		mydelta.forEach(CheckExists);
		
		if(!Exists){
			if (Oper.Operation == 'U' && !IsDetailListModal)
				if (!DeltaDetailChanged(Oper)) // this works only if not edited modal
					return;

			mydelta.push(Oper);
		}
		
		
		function CheckExists(item, index){
			Exists = false;
			if (item[DetailPrimaryKey] === Oper[DetailPrimaryKey]){
				if (Oper.Operation == 'D')
					if (mydelta[index].Operation == 'I')
						mydelta.splice(index, 1);
					else
						mydelta[index].Operation = 'D'
						
				if (Oper.Operation == 'U'){
					// extra validation if changed from original
					
						var OldOperation = mydelta[index].Operation;
						mydelta[index] = Oper;
						mydelta[index].Operation = 	OldOperation;
					
				
					
				}

				Exists = true;		
			}
			
		};
	}



	function DetailChanged(){
		return $("#detailform").isChanged() || CustomChanged();
	}

	function BeforeSaveUpdates(){
		return false; // not error
	}
	
	function AfterSave(data, ActionType){}


	

	
	function OnGetDictionaries(data){};
	
	function doDetailTab(tabid){
		$('.mol-tab').addClass("noactive");
		$('#detail-'+tabid ).removeClass("noactive");
		
		$('.mol-nav-link-detail').removeClass("active");
		$('#tab-detail-'+tabid).addClass("active");
		
	
	}
	

	function  GetDictionaries(){
		
			if (urls.getdictionariesurl == undefined)
				return;
			

			 $.ajax({
		            type: 'POST',

		            url: baseUrl + urls.getdictionariesurl,
		            data: '',


		            success: OnGetDictionaries,
		            
		            error: function(data){
		            	$('#tab-detail').unblock();
		            }
		        });
	}

	


		

		
		function OnSaveSucces(data){
			onGetDetailSuccess(data);
		}

		function onGetDetailSuccess(data){

			PutMasterFields(data);
					
			$(".tab-content" ).removeValidator();
		
			
			refreshDetail();
			AfterRetreiveDetail();
			
			$("textarea").each(function(){
				do_resize($(this)[0]);
	
			});
		}

		function refreshDetail(){
			getDetailList(null);
			LastDocumentDetailId = -1;
			mydelta = [];
			
		} 

		function CustomChanged(){
			return mydelta.length > 0;
		}
		

		function PutMasterFields(Data){

			if (MasterFields.length == 0){
				// If not sent masterfields then take from masterlist

				Object.keys(Data).forEach(element => {
					MasterFields.push(element);
					
				});

			}

			MasterFields.forEach(element => {

				if ($('#' + element).is(':checkbox')){
                    
					$('#' + element).prop( "checked", Data[element] == 1 );
                    $('#' + element).prop( "defaultchecked", Data[element] == 1 );
				}else{
					$('#' + element).val(Data[element]);
                    $('#' + element).prop("defaultValue", Data[element]);
                    
				}
			});
		}

		function AfterRetreiveDetail(){
			
	

		}

        function getDetailList(data){
			if (HasDetails){
				var MasterId = 0; 
				if (data == null)
					MasterId = $('#' + MasterPrimaryKey).val();
				else
					MasterId = data[0][0][MasterPrimaryKey];
				
				$('#tab-detail').block({
						message:null
					});
		
				$.ajax({
					type: 'POST',
		
					url: baseUrl + urls.getdetaillisturl,
					data: {MasterKeyField: MasterId},
					success: function (data) {
						ShowSuccess('Details retrieved!');
						documentdetailsDB = data[0];
						PutDetails();
						OnPutDetailOthers(data[1]);
						$('#tab-detail').unblock();
					}
				});

			

			}


		}

		function OnPutDetailOthers(data){

		}

		function PutDetails(){
            
    
			detailsSource =
			{
				localdata: documentdetailsDB,
				datatype: "array",
				datafields: detaildatafields,
				addrow: function (rowid, rowdata, position, commit) {
					if (!IsDetailListModal){

						var localdata = {Operation:'I'};

						detaildatafields.forEach(function(item){
							localdata[item['name']] = rowdata[0][item['name']];
						});

						addDeltaOperation(localdata)
					}
					commit(true);
				},
				
				
				deleterow: function (rowid, commit) {
					if (!IsDetailListModal){
						var rowdata = $('#documentdetails').jqxGrid('getrowdatabyid', rowid);

						var localdata = {Operation:'D'};

						detaildatafields.forEach(function(item){
							localdata[item['name']] = rowdata[item['name']];
						});
						addDeltaOperation(localdata);
					}
					commit(true);
				},
				
				updaterow: function (rowid, newdata, commit) {
					if (!IsDetailListModal){

						var localdata = {Operation:'U'};

						detaildatafields.forEach(function(item){
							localdata[item['name']] = newdata[item['name']];
							
						});

						addDeltaOperation(localdata)

					}
					
					commit(true);
				}
			};
			
			
			$("#documentdetails").jqxGrid(
			{
				width: '100%',
				source: detailsSource,                
				pageable: false,
				autoheight: false,
				sortable: true,
				altrows: true,
				groupable: false,
				filterable: true,
				enabletooltips: true,
				editable: !IsDetailListModal,
				columnsresize: true,
				selectionmode: 'singlerow',
				showtoolbar: false,
				theme: 'energyblue',
				columns: detailcolumns,

				
			});
	

			$('#documentdetails').on('rowdoubleclick', function (event) {
				if (IsDetailListModal){
					var rowindex = $('#documentdetails').jqxGrid('getselectedrowindex');
					var DocumentDetailId = $('#documentdetails').jqxGrid('getrowdata', rowindex)[DetailPrimaryKey];
					ShowDetail(DocumentDetailId);
				}
		
			});
			//invalidateInputForms();
		}

		function ShowDetail(DetailId){
			$('#DetailModal')
			.modal({
				backdrop: 'static',
				keyboard: false});
		
			$('#detailformmodal').find('input, select').val("");
		
			PutDefaultModalValues(DetailId);    
		
			$("#detailformmodal").resetChanges();
			$('#detailformmodal').trackChanges();
			$('#detailformmodal').removeValidator();

			if (typeof AfterPutModalDetailValues === "function")
				AfterPutDetailModalValues();
			
		}

		function PutDefaultModalValues(DetailId){
			// punem valorile deja introduse sau valori default    
		
		
			function PutValues(item){
				$('#detailformmodal').find('input, select').each(function() {
					if ($(this).is(':checkbox')){
						$(this).prop( "checked", item[$(this).attr('name')] == 1 );
					}
					else{
						$(this).val(item[$(this).attr('name')]);
					}
				});
			}
		
		
			if (DetailId != null){
				// punem valorile deja introduse
				documentdetailsDB.forEach(function(item){
					if (item[DetailPrimaryKey] == DetailId){
						PutValues(item);
					}
				});
				$('#IsNewDetail').val(0);
			}
			else{
				// punem valori default
		
		
				$("#detailformmodal :input").each(function(){
					var name = $(this).attr('name');
					var val;
			
					if (DefaultDetailValues[name] == "date()")
						val = getDateStr();
					else    
						val = DefaultDetailValues[name]
			
					if (val != undefined){
						if ($(this).is(':checkbox'))
							$(this).prop( "checked", val == 1);
						else
							$(this).val(val);
					}
				
				});
				
				// daca mai e ceva in descendats
				if (typeof OnPutDetailDefault === "function")
					OnPutDetailDefault();
		
		
				$('#IsNewDetail').val(1);
		
				 // decrementam cu una
				 LastDocumentDetailId -= 1;
				 $('#'+ DetailPrimaryKey).val(LastDocumentDetailId);
			}
		}

		function addDetail(){
			if (IsDetailListModal)
				ShowDetail();
			else{
				AddDetailGrid()
			}
		}


		function AddDetailGrid(){
			LastDocumentDetailId -= 1;
			var newData= [{}];

			detaildatafields.forEach(function(item){
				newData[0][item['name']] = DefaultDetailValues[item['name']];
			});
		

			newData[0][MasterPrimaryKey] = $("#" + MasterPrimaryKey).val();
			newData[0][DetailPrimaryKey] = LastDocumentDetailId;

			$("#documentdetails").jqxGrid('addrow', null, newData, 'top');
		}

		function ComputeMaster(){

		}
		//vvvvvvvvvvvvv

		function onCloseDetailModal(){
			$('#DetailModal').modal('toggle') ;
		}

		function onSaveDetailModal(){
			SubmitDetailModal();
		}

		function onCloseDetailModal(){
			SaveUpdates();
			$('#DetailModal').modal('toggle') ;
		}


		function onStayDetailModal(){

		}

		function CloseDetailModal(){
			if ( $('#detailformmodal').isChanged() ){
				confirmSave("Nu ati salvat modificarile! Cum doriti sa continuati?", onSaveDetailModal, onStayDetailModal, onCloseDetailModal);
			}
			else
				onCloseDetailModal()
		}

		function ValidateDetailModal(){
			var Valid = true;
				
		// if (!$(this).find('.is-invalid'))

			Valid = $('#detailformmodal').valid();//false;

			// $('#detailformmodal').find('input, select').each(function(){
			//     var Valid = true;

			//     if ( !$(this).is(':checkbox'))
			//         if ($(this).prop('required') && $(this).val() == "")
			//             Valid = false;
			// });


			if (!Valid)
				ShowError('Introduceti toate informatiile!');

			return Valid;
		}

		function SubmitDetailModal(){
		
			if (!ValidateDetailModal())
				return;

			var IsNewDetail = $('#IsNewDetail').val();
			var DocumentDetailId = $('#'+DetailPrimaryKey).val();

			if (IsNewDetail == 1){
				InsertDetailModal(DocumentDetailId);
			}
			else{
				UpdateDetailModal(DocumentDetailId);
			}


			onCloseDetailModal();
			//refresh detail grid
			PutDetails();
			ComputeMaster();
		}



		function InsertDetailModal(DocumentDetailId){

			function PutValues(item){
				$('#detailformmodal').find('input, select').each(function() {
					if ($(this).is(':checkbox')){
						item[$(this).attr('name')] = $(this).prop( "checked")?1:0;
					}
					else{
						item[$(this).attr('name')] = $(this).val();
					}
				});
			}
	
			addDeltaOperation({Operation:'I', [DetailPrimaryKey]: DocumentDetailId});
		
				// insert in documentdetailsDB;
		
			documentdetailsDB.push({});
			
			item = documentdetailsDB[documentdetailsDB.length -1];
				// insert new row and put values
			PutValues(item);
		
		
		}
	
	
		function UpdateDetailModal(DocumentDetailId){
		
				function PutValues(item){
					$('#detailformmodal').find('input, select').each(function() {
						if ($(this).is(':checkbox')){
							item[$(this).attr('name')] = $(this).prop( "checked")?1:0;
						}
						else{
							item[$(this).attr('name')] = $(this).val();
						}
					});
					addDeltaOperation({Operation:'U', [DetailPrimaryKey]: DocumentDetailId});
				}
		
			documentdetailsDB.forEach(function(item){
				if (item[DetailPrimaryKey] == DocumentDetailId){
					PutValues(item);
					return;
				}
			});
		
	}

	function deleteDetail(){
		var selectedrowindex = $("#documentdetails").jqxGrid('getselectedrowindex');
		
		if (selectedrowindex == -1)
			ShowError('Alegeti o intregistrare');
		else{
			// delete from datasource
			if (IsDetailListModal){
				var DocumentDetailId = $('#documentdetails').jqxGrid('getrowdata', selectedrowindex)[DetailPrimaryKey]; 
				
				addDeltaOperation({Operation:'D', [DetailPrimaryKey]: DocumentDetailId});
				documentdetailsDB.forEach(function(item, index){
					if (item[DetailPrimaryKey] == DocumentDetailId){
						documentdetailsDB.splice(index, 1);
						return;
					}
				});
				PutDetails();
			}
			else{
				var selectedrowindex = $("#documentdetails").jqxGrid('getselectedrowindex');
				if (selectedrowindex == -1)
					ShowError('Alegeti o intregistrare');
				
				var rowscount = $("#documentdetails").jqxGrid('getdatainformation').rowscount;
				if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
					var id = $("#documentdetails").jqxGrid('getrowid', selectedrowindex);
					$("#documentdetails").jqxGrid('deleterow', id);
				}
			}
			
			ComputeMaster();
		}
		
	}


		//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^



		function saveDetailAndDoNew(){
			SaveUpdates(doNew);
				
		}

		function stayDetail(){
			
		}

     
				
		function RetrieveMasterKeyFields(){
			var dk = {}
			dk[MasterPrimaryKey] = $("#" + MasterPrimaryKey).val();
			return dk;
		}

	

        

		function CancelUpdates(){
			$("#detailform").data("changed", false);
			var IsNew = $('#isnew').val();


			$("#detailform")[0].reset();
			$("#detailform").resetChanges();
			$(".tab-content" ).removeValidator();


			
		};


		function RetrieveFields(){


			var results = {};
		
			$("#detailform :input").each(function(){
				var val;
				if ($(this).is(':checkbox'))
					val = $(this).prop( "checked")?1:0;
				else
					val =  $(this).val();
				results[$(this).attr('id')] = val;
			
			});


			documentdetailsDB.forEach(element => {
				mydelta.forEach(elementD => {
					if (element[DetailPrimaryKey] == elementD[DetailPrimaryKey]){
						if (IsDetailListModal)
							elementD = Object.assign(elementD, element )
						else
							elementD = Object.assign(element, elementD )
					}
				});
			   
			});
		
			results['delta'] = mydelta;
			return results;


		}		

		function ValidateBeforeSave(){
			return true;
		}

		var fAfterSave = null;

		function SaveUpdates(cAfterSave = null){


			//punem sa se vada taburile ca sa poata valida

			var Rec = false;
			var Data;


			$('#detailform').find(':input').each(function(){
			    if ( !$(this).is(':checkbox')){
                    if (($(this).prop('required') && $(this).val() == "") || ($(this).hasClass("is-invalid")))
						Rec = true;
				}else{
					if( $(this).hasClass("is-invalid"))
						Rec = true;
				}
			});


			if (Rec){
				ShowError('Nu ati introdus toate informatiile');

				return false;
			}

			if (!DetailChanged())
				return false;

			if (! ValidateBeforeSave())
				return false;

			if (BeforeSaveUpdates())
				return false;



			Data = RetrieveFields();

			fAfterSave  = cAfterSave;
			$.ajax({
	            type: 'POST',

	            url: baseUrl + urls.saveurl,
	            data: Data,
	            success: function (data) {
					ShowSuccess('Salvat cu succes!');
					$('#isnew').val("0");
		            OnSaveSucces(data);
		    		
		    		$("#detailform").resetChanges();
		    		$(".tab-content" ).removeValidator();
					AfterSave(data);
					if (fAfterSave )
						fAfterSave();

	            },
				error: function(data) {

					alert(data);
				}
			});
			return true;
		}

		

		


		function OnLoadMaster(data)	{

            // punem campurile master

            PutMasterFields(data);

	
			//===========  detail  ===================
			

			$( "#detailform" ).submit(function( event ) {
				$( "#detailform" ).valid();
				SaveUpdates();
				event.preventDefault();
			});
			$('#detailform').trackChanges();

			$( "#detailform" ).validate( {

				excluded: [':disabled'],
				ignore:"",
				// rules: RequiredFields,
				// messages: RequiredMessages,
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `invalid-feedback` class to the error element
					error.addClass( "invalid-feedback" );
					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.next( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
					dotabvalidation(element);
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
					dotabvalidation(element);
				}
			} );

		}


		function dotabvalidation(element) {
			var id = $( element ).closest('.mol-tab').attr('id');
			var invalid = $('#'+id).find(".is-invalid").length > 0
			if (id == undefined)
				return;
			id = id.substring(7, 10);
			if (invalid)
				$('#tab-detail-'+id).addClass("is-invalid");
			else
				$('#tab-detail-'+id).removeClass("is-invalid");
		}


		function AfterLoadMaster(data){
			
		}  

		/////////////////////
		function BeforeDoAction(Data){
			return false;
		}

		function getActionData(ActionType){
			
		
			return {}; // override on descendants

		}

		function ActionConfirm(ActionType, DoIt){
			confirm("Doriti sa executati actiunea " + ActionType + "?", DoIt);
			
		}

		function DoAction(ActionType){

			var Data = getActionData(ActionType);
			Data.ActionType = ActionType;
		
			var SuccessMsg = '';
		
			if ( DetailChanged() ){
				ShowError('Salvati documentul!')
				return;
			}

			if ( ! BeforeDoAction(Data)){ // on descendants we can make our own data
		
				ActionConfirm(ActionType, DoIt);
			}
		
			function DoIt(){
		
				// DoActionAjax can be invoked separately when BeforeDoAction return true (a modal dialog or something -> see contracts)
				DoActionAjax(Data, SuccessMsg, ActionType);
			}
		}

        function RefreshMaster(){

            $('#tab-detail')?.block({
                message:null
            });


            vData = {};
            
            vData[MasterPrimaryKey] = $('#' + MasterPrimaryKey).val();

            $.ajax({
                type: 'POST',

                url: baseUrl + urls.getdetailurl,

                data: vData,



                success: function (data) {
                    
                    onGetDetailSuccess(data);

                    $(".tab-content" )?.removeValidator();
                    $('#tab-detail')?.unblock();
                    $("#detailform").data("changed", false);
                },
                error: function(data){
                    $('#tab-detail')?.unblock();
                }
            });


        }


		function DoActionAjax(Data, SuccessMsg, ActionType){

			$.ajax({
				type: 'POST',
		
				url: baseUrl + urls.actionurl,
				data: Data,
				success: function (data) {
					ShowSuccess(SuccessMsg);
					OnSaveSucces(data);
					RefreshMaster();
					$("#detailform").resetChanges();
					$(".tab-content" ).removeValidator();
					AfterSave(data, ActionType);
				}
			});
		}




	/////////////////////

	function do_resize(textbox) {

		
		var maxrows = 20;

		var txt = textbox.value;

		if (txt == undefined)
			return;

		var cols = textbox.cols;
	
		var arraytxt = txt.split('\n');
		var rows = arraytxt.length; 

	
		if (rows > maxrows) 
			textbox.rows = maxrows;
		else 
			textbox.rows = rows;
	}


	

	

		$(function () {
			OnLoadMaster(data[0]);
			GetDictionaries();
			//AfterLoadMaster(data);
			// ascundem gridul de detalii daca tipul de document nu are 


			
			 // clean Actin button
			 if ($('.molactionbutton').find('.nav-item').length == 0)
			 	$('#molactionbutton').remove();
			
			 
			window.onbeforeunload = function(){
				if (DetailChanged()){
					return "Nu ati salvat modficarile";	
				}
			} 	
  
			
            if (IsDetailListModal){
				$("#detailformmodal").validate( {

					excluded: [':disabled'],
					ignore:"",
					// rules: RequiredFields,
					// messages: RequiredMessages,
					errorElement: "em",
					errorPlacement: function ( error, element ) {
						// Add the `invalid-feedback` class to the error element
						error.addClass( "invalid-feedback" );
						if ( element.prop( "type" ) === "checkbox" ) {
							error.insertAfter( element.next( "label" ) );
						} else {
							error.insertAfter( element );
						}
					},
					highlight: function ( element, errorClass, validClass ) {
						$( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
				
					},
					unhighlight: function (element, errorClass, validClass) {
						$( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
				
					}
				} );
			
				$( "#detailformmodal" ).off( "submit" );
				$( "#detailformmodal" ).submit(function( event ) {
					event.preventDefault();
					SubmitDetailModal();
					
				});
			}

			$("textarea").on("input", (function(){
				do_resize($(this)[0]);
	
			}));


			if (!((filtersource != null) && (filtersource.length > 0))){
				$('#customfilter').hide();
			}



		});
