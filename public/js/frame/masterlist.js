
	var source = {};

	var LastFilter = '';

	var MasterPrimaryKey = ""


	let MasterFields= []; // this will be overriden in blade from controller
	let MasterColumns = [];
	var mydelta = [];
	var LastMasterId = -1;

//	let DefaultMasterValues = {};

	var HasDetailBtn = false; // has add, delete detail buttons	
	var CanDeleteMaster = false;

	var filtersource = undefined;

	let columngroups = [];

	let urls = {
		saveurl: undefined,
		getmasterurl: undefined,
		actionurl: undefined,
		getdictionariesurl: undefined

	};

	function DeltaMasterChanged(Oper){
		//return false; // To be overriden if needs extra validation

	
			function CheckChanged(item){
				
				if (item[MasterPrimaryKey] === Oper[MasterPrimaryKey]){
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
		master.forEach(CheckChanged);
		return Changed;
	}

	function addDeltaOperation(Oper){
		// check if already exist
		var Exists = false;
		
		mydelta.forEach(CheckExists);
		
		if(!Exists){
			if (Oper.Operation == 'U')
				if (!DeltaMasterChanged(Oper)) // this works only if not edited modal
					return;

			mydelta.push(Oper);
		}
		
		
		function CheckExists(item, index){
		
			if (item[MasterPrimaryKey] === Oper[MasterPrimaryKey]){
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



	function MasterChanged(){
		return  CustomChanged();
	}

	function BeforeSaveUpdates(){
		return false; // not error
	}
	
	function AfterSave(data, ActionType){}


	
	function GetMasterListData(){
		return [];
	}
	
	function OnGetDictionaries(data){};
	
	function OnSaveSucces(data){

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




	function CustomChanged(){
		return mydelta.length > 0;
	}
		


	function insertMaster(){
		LastMasterId -= 1;
		var newData= [{}];

		MasterFields.forEach(function(item){

			newData[0][item['name']] = DefaultMasterValues[item['name']];

		});
	

		newData[0][MasterPrimaryKey] = $("#" + MasterPrimaryKey).val();
		newData[0][MasterPrimaryKey] = LastMasterId;
		//addDeltaOperation({Operation:'I', [MasterPrimaryKey]: LastMasterId});

		$("#jqxGrid").jqxGrid('addrow', null, newData, 'bottom');
	}



	function deleteMaster(){
		var selectedrowindex = $("#jqxGrid").jqxGrid('getselectedrowindex');
		
		if (selectedrowindex == -1)
			ShowError(translate('Alegeti o intregistrare'));
		else{
	
				var selectedrowindex = $("#jqxGrid").jqxGrid('getselectedrowindex');
				if (selectedrowindex == -1)
					ShowError(translate('Alegeti o intregistrare'));
				
				var rowscount = $("#jqxGrid").jqxGrid('getdatainformation').rowscount;
				if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
					var id = $("#jqxGrid").jqxGrid('getrowid', selectedrowindex);
					$("#jqxGrid").jqxGrid('deleterow', id);
				}
			}

	}

	
	
		function UpdateDetailModal(MasterId){
		
				function PutValues(item){
					$('#detailformmodal').find('input, select').each(function() {
						if ($(this).is(':checkbox')){
							item[$(this).attr('name')] = $(this).prop( "checked")?1:0;
						}
						else{
							item[$(this).attr('name')] = $(this).val();
						}
					});
					addDeltaOperation({Operation:'U', [MasterPrimaryKey]: MasterId});
				}
		
			master.forEach(function(item){
				if (item[MasterPrimaryKey] == MasterId){
					PutValues(item);
					return;
				}
			});
		
	}



		//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


        

		function CancelUpdates(){
			if (mydelta.length == 0)
				return;
			RefreshMasterAjax();
		};

		function getOtherSaveFields(){
			let results = {};
			$(".container :input").each(function(){
				var val;
				if ($(this).is(':checkbox'))
					val = $(this).prop( "checked")?1:0;
				else
					val =  $(this).val();

				results[$(this).attr('id')] = val;
			
			});
			return results;
		};

		function RetrieveFields(){


			let results = {};

			savefields = getOtherSaveFields();

			master.forEach(element => {
				mydelta.forEach(elementD => {
					if (element[MasterPrimaryKey] == elementD[MasterPrimaryKey]){
						elementD = Object.assign(element, elementD )
					}
				});
			   
			});
		
			results['delta'] = mydelta;
			results = {...results, ...savefields};
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

			if ( !MasterChanged() )
				return;


			if (Rec){
				ShowError(translate('Nu ati introdus toate informatiile'));

				return false;
			}


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
					ShowSuccess(translate('Salvat cu succes!'));
					$('#isnew').val("0");
		            OnSaveSucces(data);
		    		RefreshMaster(data);

					AfterSave(data);
					if (fAfterSave )
						fAfterSave();

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
			confirm(translate("Doriti sa executati actiunea ") + ActionType + "?", DoIt);
			
		}

		function DoAction(ActionType){

			var Data = getActionData(ActionType);
			Data.ActionType = ActionType;
		
			var SuccessMsg = '';
		
			if ( MasterChanged() ){
				ShowError(translate('Salvati documentul!'))
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

        function RefreshMaster(data){
         
            // facem refresh la grid

			source.localdata = data;

			mydelta = [];

		
		
			$("#jqxGrid").jqxGrid('updatebounddata', 'cells');



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


		function RefreshMasterAjax(){

			let data = {};
			data.MasterFilter = $('#MasterFilter').val();


			$.ajax({
				type: 'POST',
		
				url: baseUrl + urls.getlistajax,
				data: data,
				success: function (data) {
					ShowSuccess('Succes');
				
					RefreshMaster(data);

				}
			});
		}



	/////////////////////


		$(function () {

			GetDictionaries();

			 // clean Actin button
			 if ($('.molactionbutton').find('.nav-item').length == 0)
			 	$('#molactionbutton').remove();
			
			 
			window.onbeforeunload = function(){
				if (MasterChanged()){
					return translate("Nu ati salvat modificarile");	
				}
			} 	
      

			$("textarea").on("input", (function(){
				do_resize($(this)[0]);
	
			}));


			if (!((filtersource != null) && (filtersource.length > 0))){
				$('#customfilter').hide();
			}


			$('#addMaster').on('click',
				function(event){
					insertMaster();
				}
			);

			$('#deleteMaster').on('click',
				function(event){
					deleteMaster();
				}
			);

			$('#saveMaster').on('click',
			function(event){
				SaveUpdates();
			});

			$('#cancelMaster').on('click',
			function(event){
				CancelUpdates();
			});
				


			// prepare the data
			 source =
			{
				datatype: "array",
				localdata: master,
				dataFields: MasterFields,
			
				addrow: function (rowid, rowdata, position, commit) {
				

					let localdata = {Operation:'I'};

					MasterFields.forEach(function(item){
						localdata[item['name']] = rowdata[0][item['name']];
					});

					addDeltaOperation(localdata)
					
					commit(true);
				},
				
				
				deleterow: function (rowid, commit) {
				
					var rowdata = $('#jqxGrid').jqxGrid('getrowdatabyid', rowid);

					var localdata = {Operation:'D'};

					MasterFields.forEach(function(item){
						localdata[item['name']] = rowdata[item['name']];
					});
					addDeltaOperation(localdata);
				
					commit(true);
				},
				
				updaterow: function (rowid, newdata, commit) {
				
					var localdata = {Operation:'U'};

					MasterFields.forEach(function(item){
						localdata[item['name']] = newdata[item['name']];
						
					});

					addDeltaOperation(localdata)

				
					
					commit(true);
				}		
					
				
			};
				
		
		
			var dataAdapter =  new $.jqx.dataAdapter(source);
				// initialize jqxGrid
			$("#jqxGrid").jqxGrid(
			{
				width:'100%',
		
				source: dataAdapter,                
				pageable: false,
				showfilterrow: true,
				filterable: true,
				sortable: false,
				altrows: true,
				enabletooltips: true,
				editable: true,
				autorowheight: false,
				autoheight: true,
				selectionmode: 'multiplecellsadvanced',
				columns: MasterColumns,
				columngroups: columngroups
				
				
			});
	
			   

		});
