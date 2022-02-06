    //import { GETAJAX } from '../helpers.js';

    let pcolumns = [];

    if (window.innerWidth > 900){
        pcolumns = [
            { text: 'Poligon', dataField: 'Name', width: '30%' },
            { text: 'Adresa', dataField: 'Address', width: '30%' },
            { text: 'Telefon', dataField: 'Phone', width: '20%' },
            { text: 'Tara', dataField: 'Country', width: '10%' },
           
            { text: '', dataField: 'RangeId', width: '10%',

            columntype:'button', cellsrenderer: function () {
              return "...";

              
            }, 
            
            buttonclick: function (row) {
               // open the popup window when the user clicks a button.
                   let editrow = row;
                  // var offset = $("#grid").offset();
                   var dataRecord = $("#jqxGrid").jqxGrid('getrowdata', editrow);
                   const RangeId = dataRecord.RangeId

                   document.location.href = `poligon/${RangeId}`;
               }
            }
        ]

    }
    else{
        pcolumns = [
            { text: 'Poligon', dataField: 'Name', width: '90%' },
           
            { text: '', dataField: 'RangeId', width: '10%',

            columntype:'button', cellsrenderer: function () {
              return "...";

              
            }, 
            
            buttonclick: function (row) {
               // open the popup window when the user clicks a button.
                   let editrow = row;
                  // var offset = $("#grid").offset();
                   var dataRecord = $("#jqxGrid").jqxGrid('getrowdata', editrow);
                   const RangeId = dataRecord.RangeId

                   document.location.href = `poligon/${RangeId}`;
               }      
            }
        ]
    
    }
	

    $(function () {
	
		// prepare the data
		var source =
		{
			datatype: "array",
			localdata: dsPoligoane,
			dataFields:
					[
						{ name: 'Name', type: 'string' },
						{ name: 'Country', type: 'string' },
						{ name: 'Address', type: 'string' },
						{ name: 'Phone', type: 'string'},
						{ name: 'RangeId', type: 'number' }
			
					]

                   
				
				
			
		};
		
		var dataAdapter =  new $.jqx.dataAdapter(source);
		// initialize jqxGrid
		$("#jqxGrid").jqxGrid(
		{
			width:'100%',
			source: dataAdapter,                
			pageable: false,
			autoheight: true,
			sortable: true,
			altrows: true,
			enabletooltips: false,
			editable: false,
			autorowheight: true,
           
			selectionmode: 'none',
			columns: pcolumns
		});
	});
	   
