	let clClasament = []

	if (window.innerWidth > 900){
		clClasament = [
			{ text: 'Loc', dataField: 'Position', width: '5%' },
			{ text: 'Sportiv', dataField: 'Person', width: '55%' },
			{ text: 'Categorie', dataField: 'Category', width: '10%' },
			{ text: 'Team', dataField: 'Team', width: '20%' },
			{ text: 'Procent', dataField: 'Procent', width: '10%' },
		]
	}else{
		clClasament = [
			{ text: '', dataField: 'Position', width: '5%' },
			{ text: 'Sportiv', dataField: 'Person', width: '55%' },
			{ text: 'Cat', dataField: 'Category', width: '10%' },
			{ text: 'Procent', dataField: 'Procent', width: '25%' },
		]
	}




	$(function () {
	
		// prepare the data
		var source =
		{
			datatype: "array",
			localdata: dsClasament2021,
			dataFields:
					[
						{ name: 'Position', type: 'number' },
						{ name: 'Person', type: 'string' },
						{ name: 'Category', type: 'string' },
						{ name: 'Team', type: 'string'},
						{ name: 'Procent', type: 'number' }
			
					]
				
			
		};
		
		var dataAdapter =  new $.jqx.dataAdapter(source);
		// initialize jqxGrid
		$("#jqxGrid").jqxGrid(
		{
			width:'100%',
		
			source: dataAdapter,                
			pageable: false,
			autoheight: false,
			sortable: false,
			altrows: true,
			enabletooltips: true,
			editable: false,
			autorowheight: false,
            autoheight: false,
			selectionmode: 'none',
			columns: clClasament,
			filterable: true,
	
          
		});
	});
	   


	   
