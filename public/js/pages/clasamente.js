	let clClasament = []
	let source = undefined;

	var cellclassUser = function (row, columnfield, value) {
		if (value === MyName) {
			return 'text-color-primary';
		}
	
		else return '';


	}

	if (window.innerWidth > 900){
		clClasament = [
			{ text: translate('Loc'), dataField: 'Position', width: '5%' },
			{ text: translate('Sportiv'), dataField: 'Person', width: '45%', cellclassname: cellclassUser },
			{ text: translate('Categorie'), dataField: 'Category', width: '10%' },
			{ text: translate('Team'), dataField: 'Team', width: '20%' },
			{ text: translate('Procent'), dataField: 'Procent', width: '10%' },
			{ text: translate('Nr participari'), dataField: 'NrCompetitions', width: '10%' },
		]
	}else{
		clClasament = [
			{ text: '', dataField: 'Position', width: '5%' },
			{ text: translate('Sportiv'), dataField: 'Person', width: '45%', cellclassname: cellclassUser },
			{ text: translate('Cat'), dataField: 'Category', width: '10%' },
			{ text: translate('Procent'), dataField: 'Procent', width: '20%' },
			{ text: translate('Nr participari'), dataField: 'NrCompetitions', width: '15%' },
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
						{ name: 'NrCompetitions', type: 'number' }
			
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
	
          
		});

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
	   


	   
