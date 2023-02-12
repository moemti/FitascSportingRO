	let clClasament = []
	let source = undefined;

	var cellclassUser = function (row, columnfield, value) {
		if (value === MyName) {
			return 'text-color-primary';
		}
	
		else return '';


	}

	var cellclasscomp = function (row, columnfield, value) {
		if (value < 5) {
			return 'clRedBak';
		}
	
		else return '';


	}

	if (window.innerWidth > 900){
		clClasament = [
			{ text: translate('Loc'), dataField: 'Position', width: '5%' },
			{ text: translate('Sportiv'), dataField: 'Person', width: '40%', cellclassname: cellclassUser },
			{ text: translate('Categorie'), dataField: 'Category', width: '10%' },
			{ text: translate('Team'), dataField: 'Team', width: '15%' },
			{ text: translate('Procent'), dataField: 'Procent', width: '10%' },
			{ text: translate('Procent ROM'), dataField: 'ProcentR', width: '10%' },
			{ text: translate('Nr participari'), dataField: 'NrCompetitions', width: '10%' , cellclassname:  cellclasscomp},
			{ text: "PersonId", dataField: 'PersonId', width: '10%',  hidden: true},
		]
	}else{
		clClasament = [
			{ text: '', dataField: 'Position', width: '5%' },
			{ text: translate('Sportiv'), dataField: 'Person', width: '45%', cellclassname: cellclassUser },
			{ text: translate('Cat'), dataField: 'Category', width: '10%' },
			{ text: translate('Procent'), dataField: 'Procent', width: '10%' },
			{ text: translate('Procent ROM'), dataField: 'ProcentR', width: '10%' },
			{ text: translate('Nr participari'), dataField: 'NrCompetitions', width: '15%',cellclassname:  cellclasscomp },
			{ text: "PersonId", dataField: 'PersonId', width: '10%',  hidden: true },
		]
	}



	function getClasamentByYear(Year){
        let Data = {};
        Data.Year = Year;

		$.ajax({
            type: 'POST',
            url: baseUrl + '/getClasamentByYear',
            data: Data,
            success: function (dataretur) {
                ShowSuccess('Success');
				dsClasament = dataretur;	
                putClasamentByYear();              
            },
            error: function(e){
                ShowError(e);
            }
        });      
    }   

	function getResultPersonYear(PersonId, Year){
		let Data = {};
		Data.PersonId = PersonId;
        Data.Year = Year;
       
        $.ajax({
            type: 'POST',
            url: baseUrl + '/getResultsPersonyYear',
            data: Data,
            success: function (data) {
                ShowSuccess('Success');	
                putPersonResults(data, PersonId);              
            },
            error: function(e){
                ShowError(e);
            }
        });      
	}

	var linkrenderer = function (row, column, value) {
		
		value = '/clasament/'.value;
		
		var format = { target: '"_blank"' };
		var html = $.jqx.dataFormat.formatlink(value, format);
		return html;
	}

	function putPersonResults(_data, PersonId){

		let Id = 'rezultate_' + PersonId;
		let _source =
		{
			datatype: "array",
			localdata: _data,
			dataFields:
					[
						{ name: 'Name', type: 'string' },
						{ name: 'Loc', type: 'number' },
						{ name: 'Total', type: 'number' },		
						{ name: 'Percent', type: 'number' },
						{ name: 'PercentR', type: 'number' },
						{ name: 'CompetitionId', type: 'number'}				
					]			
		};

		let _dataColumns = [
			{ text: translate('Competitie'), dataField: 'Name', width: '45%'},
	//		{ text: translate('Loc'), dataField: 'Loc', width: '15%'},
			{ text: translate('Total'), dataField: 'Total', width: '15%' },
			{ text: translate('Procent'), dataField: 'Percent', width: '8%' },
			{ text: translate('Procent ROM'), dataField: 'PercentR', width: '7%' },
			{ text: translate('Vezi rezultate'), dataField: 'CompetitionId', width: '10%', 
						columntype:'button', cellsrenderer: function () {
							return "Vezi...";	
							}, 
						
						buttonclick: function (row) {
							// open the popup window when the user clicks a button.
								let editrow = row;
								// var offset = $("#grid").offset();
								var dataRecord = $("#" + Id).jqxGrid('getrowdata', editrow);
								const CompetitionId = dataRecord.CompetitionId
								window.open(APP_URL + `/clasament/${CompetitionId}`, '_blank');
								
							}
						}


		];


		var _dataAdapter =  new $.jqx.dataAdapter(_source);

		$('#' + Id).jqxGrid(
		{
			width:'100%',
			height: '100%',
			source: _dataAdapter,                
			pageable: false,
			sortable: false,
			altrows: true,
			enabletooltips: true,
			editable: false,
			autorowheight: false,
            autoheight: true,
			selectionmode: 'none',
			columns: _dataColumns,
			filterable: false,
			showfilterrow: false,
			groupable: false,
			rowdetails: false,
		});
	}


	function putClasamentByYear(){

		if (source){
			source.localdata = dsClasament;
			$("#jqxGrid").jqxGrid('updatebounddata', 'cells');
			return;
		}

        source =
		{
			datatype: "array",
			localdata: dsClasament,
			dataFields:
					[
						{ name: 'Position', type: 'number' },
						{ name: 'Person', type: 'string' },
						{ name: 'Category', type: 'string' },
						{ name: 'Team', type: 'string'},
						{ name: 'Procent', type: 'number' },
						{ name: 'ProcentR', type: 'number' },
						{ name: 'NrCompetitions', type: 'number' },
						{ name: 'PersonId', type: 'number' }
					]			
		};
		
		var dataAdapter =  new $.jqx.dataAdapter(source);
		// initialize jqxGrid
		$("#jqxGrid").jqxGrid(
		{
			width:'100%',
			
			source: dataAdapter,                
			pageable: false,
			sortable: false,
			altrows: true,
			enabletooltips: true,
			editable: false,
			autorowheight: false,
            autoheight: true,
			selectionmode: 'none',
			columns: clClasament,
			filterable: true,
			showfilterrow: true,
			groupable: true,
			rowdetails: true,          
			rowdetailstemplate: { rowdetails: "<div style='margin: 0px;'> <ul style='margin-left: 30px;'>  <li>Rezultate</li> </ul> <div class='rezultate'></div> </div>", rowdetailsheight: 420 },
			initrowdetails: initrowdetails,
		});

    }


	var initrowdetails = function (index, parentElement, gridElement, datarecord) {
		var tabsdiv = null;
               
                tabsdiv = $($(parentElement).children()[0]);
                if (tabsdiv != null) {

					var PersonId = datarecord.PersonId;
					var item = $('#jqxYear').jqxDropDownList('getSelectedItem');
					if (item != null) {
						let rezultate = tabsdiv.find('.rezultate');
						var container = $('<div id="rezultate_' + PersonId + '" style="margin: 5px;"></div>');
						rezultate.append(container);
						getResultPersonYear(PersonId, item.label);
					}
                    $(tabsdiv).jqxTabs({ width: '90%', height: '90%'});
                }
	}

	$(function () {
	
		var dsYears2 =
		{
            datatype: "json",
            datafields: [
                { name: 'Year' },               
            ],		
            localdata: dsYears,
      
		};
        var dataAdapterY = new $.jqx.dataAdapter(dsYears2);

        $("#jqxYear").jqxDropDownList({source: dataAdapterY ,selectedIndex: 0, displayMember: "Year", valueMember: "Year", width: '200px', height: '25px'});

        $('#jqxYear').on('select', function (event) {

                var args = event.args;
                var item = $('#jqxYear').jqxDropDownList('getItem', args.index);
                if (item != null) {
					getClasamentByYear(item.label);
                }
           
        });

       // getClasamentByYear($('#jqxYear').jqxDropDownList('getSelectedItem').label);
	   putClasamentByYear(); // initial este adus direct 



		
	});
	   


	   
