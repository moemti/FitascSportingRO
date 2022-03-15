
	var source;
	var detailsSource = undefined;
	var IsDetail = false;
	var LastFilter = '';
	var HasDetails = true;
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
	var HasDetailBtn = true; // has add, delete detail buttons
	var CanDeleteMaster = true;
	let listdatafields = [];
	let listdatacolumns = [];
	let urls = {};
	let filtersource = [];
	let IsOneMaster = false;
	let MasterPrimaryKeyValue;
	let _autoheight = false;
	let _showfilterrow = false;



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


	
	function GetMasterListData(){
		return [];
	}
	
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

	
	function goDetail(){

			var rowindex = -1;
			if (!IsOneMaster){
					
				rowindex = $('#masterlist').jqxGrid('getselectedrowindex');
				if (rowindex == -1){
					ShowError('Selectati o inregistrare!');
					return;
				}
				if (!$('#masterlist').jqxGrid('getrowdata', rowindex)){
					ShowError('Selectati o inregistrare!');
					return;
				}
			}


        	 $('#tab-detail').block({
             	message:null
             });


            GetDetailAjax(rowindex);
			doDetail();
			$('#detailform').trackChanges();


        };


		function getDetailData(rowindex){
			var result = {};
			if (MasterPrimaryKey != ""){
				
				if (!IsOneMaster){
					result[MasterPrimaryKey] = $('#masterlist').jqxGrid('getrowdata', rowindex)[MasterPrimaryKey]
				}
				else
					result[MasterPrimaryKey] = MasterPrimaryKeyValue;
					
					
					
			}
			return result;
			
		}

		
        function GetDetailAjax(rowindex){

        	 $('#tab-detail').block({
		        	message:null
		        });

    		 $.ajax({
    	            type: 'POST',

    	            url: baseUrl + urls.getdetailurl,
    	            data: getDetailData(rowindex),


    	            success: function (data) {
    	            	
    	            	onGetDetailSuccess(data);

    		            $(".tab-content" ).removeValidator();
    		            $('#tab-detail').unblock();
    		            $("#detailform").data("changed", false);
    	            },
    	            error: function(data){
    	            	$('#tab-detail').unblock();
    	            }
    	        });

		}
		
		function OnSaveSucces(data){
			onGetDetailSuccess(data);
		}

		function onGetDetailSuccess(data){

			PutMasterFields(data[0][0]);
					
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
				}else{
					$('#' + element).val(Data[element]);
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
            
			if (detailsSource){
				detailsSource.localdata = documentdetailsDB;
     			$('#documentdetails').jqxGrid('updatebounddata');
				 return;
			}


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
				autorowheight: false,
				filterable: true,
				enabletooltips: true,
				editable: !IsDetailListModal,
				columnsresize: true,
				selectionmode: 'singlerow',
				showtoolbar: false,
				showfilterrow: false,
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

		function CloseDetailModal(){
			if ( $('#detailformmodal').isChanged() ){
				confirm("Nu ati salvat modificarile! Doriti sa continuati?", onCloseDetailModal);
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

        function goList() {
           // check if the detail is modified end prevent to change to list

			if ( DetailChanged() ){
                confirm("Nu ati salvat modificarile! Doriti sa continuati?", doList);

            }
			else
				doList()



        };


        function doList(){
			$('.mol-nav-link').removeClass("active ");
			$('#tab-0').addClass("active ");

			$('.mol-tab-pane').removeClass("active ");
			$('#tab-list').addClass("active ");
			$("#detailform")[0].reset();

			$('.justlist').removeClass("invisible");
			$('.justdetail').addClass("invisible");
			$("#detailform").resetChanges();
			IsDetail = false;

        }

        function doDetail(){
        	$('.mol-nav-link').removeClass("active ");
			$('#tab-1').addClass("active ");

			$('.mol-tab-pane').removeClass("active ");
			$('#tab-detail').addClass("active ");

			$('.justlist').addClass("invisible	");
			$('.justdetail').removeClass("invisible");

			$(".tab-content" ).removeValidator();
			$('#isnew').val("0");
			IsDetail = true;
	
			 
			doDetailTab(0);
			AfterDoDetail();
		

		}
		
		function AfterDoDetail(){

		}
		function invalidateCloseForms(){

		}

        function addNew(){
        	if ( DetailChanged()){
                confirm("Nu ati salvat modificarile! Doriti sa continuati?", doNew);
            }else
            	doNew();
        }


		function onDoNew(){
			

		}

		function putDefaultValues(){
			// punem valorile default
			$("#detailform :input").each(function(){
				var name = $(this).attr('name');
				var val;

				if (DefaultMasterValues[name] == "date()")
					val = getDateStr();
				else    
					val = DefaultMasterValues[name]

				if (val != undefined){
					if ($(this).is(':checkbox'))
						$(this).prop( "checked", val == 1);
					else
						$(this).val(val);
				}

			});
		}

        function doNew(){
        	doDetail();
	       	$("#detailform").data("changed", false);
	       	$("#detailform")[0].reset();
	        $('#isnew').val("1");

            putDefaultValues();
			onDoNew();
			$("#detailform").trackChanges();
			
			//$('#ul-actions').html("");
        }

        function clientofferSubmit(){

            $("#detailform").data("changed", false);
            SaveDetail()


        };

		function ValidateDelete(){
			return true;
			// in descendants can override this function
		}


				
		function RetrieveMasterKeyFields(){
			var dk = {}
			dk[MasterPrimaryKey] = $("#" + MasterPrimaryKey).val();
			return dk;
		}

		function OnDeleteSucces(){

		}

        function DeleteDocument(){

        	function DoDelete(){

        		Data = RetrieveMasterKeyFields();

    			$.ajax({
    	            type: 'POST',

    	            url: baseUrl + urls.deleteurl,
    	            data: Data,
    	            success: function (data) {
    	            	ShowSuccess('Sters cu succes!');

    		            OnDeleteSucces(data)
    		    		RefreshMaster(LastFilter);
    		            goList();

    	            }
    	        });
        	}

			var IsNew = $('#isnew').val();
			
        	if (IsNew == "0"){
				if (ValidateDelete() == true)
					confirm("Doriti sa stergeti inregistrarea?", DoDelete);
			}


        }

		function CancelUpdates(){
			$("#detailform").data("changed", false);
			var IsNew = $('#isnew').val();


			$("#detailform")[0].reset();
			$("#detailform").resetChanges();
			$(".tab-content" ).removeValidator();


			if (IsNew == "0")
				goDetail();
			else{
				goList();
			}
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

		
		function SaveUpdates(){


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

			$.ajax({
	            type: 'POST',

	            url: baseUrl + urls.saveurl,
	            data: Data,
	            success: function (data) {
	            	ShowSuccess('Salvat cu succes!');
		            OnSaveSucces(data);
		    		RefreshMaster(LastFilter);
		    		$("#detailform").resetChanges();
		    		$(".tab-content" ).removeValidator();
		    		AfterSave(data);

	            }
	        });
		}

		function RefreshMasterWarning(filter, warning, input, caption){

				function doit(){
					RefreshMaster(filter, caption);
					$('#CurrentFilter').html(caption);
				}



			if (warning != ""){
				confirm(warning, doit)
			}
			else{
				if(input != ""){
					var inputvalue = '';
					inputvalue = $('#'+input).val();
					filter = filter.replace(new RegExp('<input>', 'g'), inputvalue);
				}	
				RefreshMaster(filter, caption);
				$('#CurrentFilter').html(caption);
			}

			
		}

		function AfterRefreshMaster(data){
			
		}

		function OnRefreshMaster(data){
			source.localdata = data.masterlist;
			$("#masterlist").jqxGrid('updatebounddata', 'cells');
		}

		function RefreshMaster(filter, caption){
			if (IsOneMaster)
				return;

			if ($("#basicfilter").attr("aria-expanded") == "true")
				$("#basicfilter").dropdown("toggle");

			if (filter == '')
				filter = 'all';

			LastFilter = filter;	

			$.ajax({
				type: 'POST',

				url: baseUrl + urls.getmasterurl,
				data: {masterlistdata: GetMasterListData, filter: filter, caption: caption},

				success: function (data) {

					OnRefreshMaster(data);
					AfterRefreshMaster(data);


				}
			});


		}


		function OnLoadMaster(data)	{
			// =============  list grid  ==================================
			source =
			{
				localdata: data,
				datatype: "array",
				datafields: listdatafields,

			};



			$("#masterlist").jqxGrid(
			{
				width:'100%',
				height: _autoheight?'':'100%',
				source: source,
				pageable: false,
				autoheight: _autoheight,
				sortable: true,
				altrows: true,
				groupable: false,
				filterable: true,
				enabletooltips: true,
				editable: false,
				columnsresize: true,
				selectionmode: selectMasterMuliple? 'multiplerowsextended':'singlerow',
				showtoolbar: false,
				showfilterrow:_showfilterrow,

				showgroupaggregates: false,
                showstatusbar: false,
                showaggregates: false,
				
				columns: listdatacolumns,
			});


		

		

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


		function DoActionAjax(Data, SuccessMsg, ActionType){

			$.ajax({
				type: 'POST',
		
				url: baseUrl + urls.actionurl,
				data: Data,
				success: function (data) {
					ShowSuccess(SuccessMsg);
					OnSaveSucces(data);
					RefreshMaster('');
					$("#detailform").resetChanges();
					$(".tab-content" ).removeValidator();
					AfterSave(data, ActionType);
				}
			});
		}




	/////////////////////


	function BeforeDoListAction(Data){
		return false;
	}

	function getListActionData(ActionType){

		var rowindexes = $('#masterlist').jqxGrid('getselectedrowindexes');
		var boundrows = $('#masterlist').jqxGrid('getboundrows');
		var selectedrows = new Array();

		for(var i = 0; i < rowindexes.length; i++)
		{
			selectedrows.push( boundrows[rowindexes[i]][MasterPrimaryKey]);
		
		}

		if (rowindexes.length > 0)
			return {'Keys':selectedrows}
		else
			return {};
	}

	function ListActionConfirm(ActionType, Warning, DoIt){
		if (Warning != "")
			confirm(Warning, DoIt);
		else
			confirm("Doriti sa executati actiunea " + ActionType + "?", DoIt);
		
	}

	function DoListAction(ActionType, Warning){

		var Data = getListActionData(ActionType);

		if (jQuery.isEmptyObject(Data))
			return;

		Data.ActionType = ActionType;

		var SuccessMsg = 'S-a rulat cu succes actiunea';

		if ( ! BeforeDoListAction(Data)){ // on descendants we can make our own data

			ListActionConfirm(ActionType, Warning, DoIt);
		}

		function DoIt(){

			// DoActionAjax can be invoked separately when BeforeDoAction return true (a modal dialog or something -> see contracts)
			DoListActionAjax(Data, SuccessMsg, ActionType);
		}
	}

	function getSelectedkeys(){

	}

	function DoListActionAjax(Data, SuccessMsg, ActionType){

		$.ajax({
			type: 'POST',

			url: baseUrl + urls.actionlisturl,
			data: Data,

			success: function (data) {
				ShowSuccess(SuccessMsg);
				RefreshMaster(LastFilter);
			}
		});
	}

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


	function goBack(){

		var rowindex = $('#masterlist').jqxGrid('getselectedrowindex');
		if (rowindex == 0) 
			return;

		$('#masterlist').jqxGrid('clearselection');	
		$('#masterlist').jqxGrid('selectrow', rowindex - 1);

		if (IsDetail){
			goDetail();
		}

	}

	function goNext(){
		var rows = $('#masterlist').jqxGrid('getrows');
	
		var rowindex = $('#masterlist').jqxGrid('getselectedrowindex');
		if (rows.length - 1 == rowindex)
			return;
		$('#masterlist').jqxGrid('clearselection');
		$('#masterlist').jqxGrid('selectrow', rowindex + 1);
		if (IsDetail){
			goDetail();
		}
	}

////////////

		$(document).ready(function () {
			GetDictionaries();
			if (!IsOneMaster){
				OnLoadMaster(data);
				AfterLoadMaster(data);
			
				// ascundem gridul de detalii daca tipul de document nu are 

			
				 $('#MasterDetailDetail').attr('hidden', !HasDetails);
			 
				 $('.detailbtn').attr('hidden', !HasDetailBtn);

				if (!CanDeleteMaster){
					$('#deletemasteraction').remove();
				}

				if (!((filtersource != null) && (filtersource.length > 0))){
					$('#customfilter').hide();
				}
			}

				//===========  detail  ===================
			
			
			
		//	$('#detailform').trackChanges();

		$('#masterlist').on('rowdoubleclick', function (event) {

			//var rowindex = $('#masterlist').jqxGrid('getselectedrowindex');

			goDetail();


		});

		$( "#detailform" ).submit(function( event ) {
			$( "#detailform" ).valid();
			SaveUpdates();
			event.preventDefault();
		});

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


			if (IsOneMaster){
				goDetail();
			}




		});
