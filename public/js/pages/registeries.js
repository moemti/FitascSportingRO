    //import { GETAJAX } from '../helpers.js';

    let pcolumns = [];

  
        pcolumns = [
           
            { text: translate('Name'), dataField: 'Name', width: '50%' },
            { text: translate('Email'), dataField: 'Email', width: '40%' },
            { text: '', dataField: 'RegisterId', width: '10%',

            columntype:'button', cellsrenderer: function () {
              return "...";

              
            }, 
            
            buttonclick: function (row) {
               // open the popup window when the user clicks a button.
                   let editrow = row;
                  // var offset = $("#grid").offset();
                   var dataRecord = $("#jqxGrid").jqxGrid('getrowdata', editrow);
                   const RegisterId = dataRecord.RegisterId

                   document.location.href = `registere/${RegisterId}`;
               }
        
        
        
            }
        ]


   

    $(function () {
	
		// prepare the data
		var source =
		{
			datatype: "array",
			localdata: dsmaster,
			dataFields:
					[
						{ name: 'Name', type: 'string' },
						{ name: 'Email', type: 'string' },
                        { name: 'RegisterId', type: 'number' },
					
			
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
	   
