        import { GETAJAX, POSTAJAX } from '../helpers.js';

   
        var cellclass = function (row, columnfield, value) {
            if (value == 25) {
                return 'clRedFont';
            }
        
            else return '';
        }

        let clClasament = [];

        if (window.innerWidth < 900)
            clClasament = [
                { text: 'Loc', dataField: 'Position', width: '5%' },
                { text: 'Sportiv', dataField: 'Person', width: '50%' },
                { text: 'Cat', dataField: 'Category', width: '10%' },
                { text: 'Team', dataField: 'Team', width: '15%' },
                { text: 'Total', dataField: 'Total', width: '15%' },

            
            ]
        else
            clClasament =
                [
                    { text: 'Loc', dataField: 'Position', width: '5%' },
                    { text: 'Sportiv', dataField: 'Person', width: '25%' },
                    { text: 'Cat', dataField: 'Category', width: '5%' },
                    { text: 'Team', dataField: 'Team', width: IsSuperUser===1?'5%':'10%' },
                    { text: 'M1', dataField: 'M1', width: '5%' ,cellclassname: cellclass,},
                    { text: 'M2', dataField: 'M2', width: '5%' ,cellclassname: cellclass,},
                    { text: 'M3', dataField: 'M3', width: '5%' ,cellclassname: cellclass,},
                    { text: 'M4', dataField: 'M4', width: '5%' ,cellclassname: cellclass,},
                    { text: 'M5', dataField: 'M5', width: '5%' ,cellclassname: cellclass,},
                    { text: 'M6', dataField: 'M6', width: '5%' ,cellclassname: cellclass,},
                    { text: 'M7', dataField: 'M7', width: '5%' ,cellclassname: cellclass,},
                    { text: 'M8', dataField: 'M8', width: '5%' ,cellclassname: cellclass,},
                    { text: 'Total', dataField: 'Total', width: '5%' },
                    { text: 'Procent', dataField: 'Procent', width: '5%'},
                    { text: 'ShOff', dataField: 'ShootOffS', width: '5%' },
                  
                 

                    
                ];


             if (IsSuperUser === 1){
                clClasament.push(
                    { text: '', dataField: 'ResultId', width: '5%',
                
                    columntype:'button', cellsrenderer: function () {
                        return "...";
        
                        
                        }, 
                    
                    buttonclick: function (row) {
                        // open the popup window when the user clicks a button.
                            let editrow = row;
                            // var offset = $("#grid").offset();
                            var dataRecord = $("#jqxGrid").jqxGrid('getrowdata', editrow);
                            const ResultId = dataRecord.ResultId
        
                            document.location.href = APP_URL + `/editresult/${ResultId}`;
                        }
                    }

                )


             }

            let cf = [];
                cf.push({
                            column: 'Total',
                            condition: 'greaterThan',
                            firstValue: -1,
                            fontSize: '1.3rem',
                            text: 'rgb(0,0,200)',
                            color: 'none'
                            
                        })

              
                for(let i = 0; i < 9; i++)  {
                    cf.push(
                        {
                            column: 'M' + i,
                            condition: 'equal',
                            firstValue: 25,
                            fontSize: '1.3rem',
                            text: 'red',
                            background: 'none'
                        }
                    );
                }






	$(function () {
	
		// prepare the data
		var source =
		{
			datatype: "array",
			localdata: dsClasament,
			dataFields:
		
                    [
                            { name: 'Position', type: 'number'},
                            { name: 'Person', type: 'string'},
                            { name: 'Category', type: 'string'},
                            { name: 'Team', type: 'string'},
                            { name: 'ResultId', type: 'number'},
                            { name: 'M1', type: 'number'},
                            { name: 'M2', type: 'number'},
                            { name: 'M3', type: 'number'},
                            { name: 'M4', type: 'number'},
                            { name: 'M5', type: 'number'},
                            { name: 'M6', type: 'number'},
                            { name: 'M7', type: 'number'},
                            { name: 'M8', type: 'number'},
                            { name: 'Total', type: 'number'},
                            { name: 'Procent', type: 'number'},
                            { name: 'ShootOffS', type: 'string'},
                          
                        ]
				
			
		};
		
        var nestedGrids = new Array();
        var initrowdetails = function (index, parentElement, gridElement, record) {
         
            var grid = $($(parentElement).children()[0]);
            nestedGrids[index] = grid;
           
            var clasamentdetail = [];
            clasamentdetail = dsClasament.filter(data => data.ResultId === record.ResultId);
            var detailsource = { 
                datafields: 
                [
                    { name: 'M1', type: 'number'},
                    { name: 'M2', type: 'number'},
                    { name: 'M3', type: 'number'},
                    { name: 'M4', type: 'number'},
                    { name: 'M5', type: 'number'},
                    { name: 'M6', type: 'number'},
                    { name: 'M7', type: 'number'},
                    { name: 'M8', type: 'number'},
                    { name: 'Total', type: 'number'},
                    { name: 'ShootOffS', type: 'string'},
                ],
                id: 'ResultId',
                localdata: clasamentdetail
            }
            var nestedGridAdapter = new $.jqx.dataAdapter(detailsource);
            if (grid != null) {
                grid.jqxGrid({
                    source: nestedGridAdapter, 
                    width: '100%', 
                    //height: 200,
                    columns: [
                        { text: 'M1', dataField: 'M1', width: '10%' ,cellclassname: cellclass,},
                        { text: 'M2', dataField: 'M2', width: '10%' ,cellclassname: cellclass,},
                        { text: 'M3', dataField: 'M3', width: '10%' ,cellclassname: cellclass,},
                        { text: 'M4', dataField: 'M4', width: '10%' ,cellclassname: cellclass,},
                        { text: 'M5', dataField: 'M5', width: '10%' ,cellclassname: cellclass,},
                        { text: 'M6', dataField: 'M6', width: '10%' ,cellclassname: cellclass,},
                        { text: 'M7', dataField: 'M7', width: '10%' ,cellclassname: cellclass,},
                        { text: 'M8', dataField: 'M8', width: '10%' ,cellclassname: cellclass,},
                        { text: 'ShOff', dataField: 'ShootOffS', width: '10%' },
                   ]
                });
            }
        }


		var dataAdapter =  new $.jqx.dataAdapter(source);
		// initialize jqxGrid
		$("#jqxGrid").jqxGrid(
		{
			width:'100%',
			height: '100%',
			source: dataAdapter,                
			pageable: false,
			autoheight: false,
			sortable: true,
			altrows: true,
			enabletooltips: true,
			editable: false,
			autorowheight: false,
            autoheight: false,
			selectionmode: 'none',
			columns: clClasament,
            rowdetails: window.innerWidth < 900? true: false,
            initrowdetails: window.innerWidth < 900? initrowdetails:undefined,
            rowdetailstemplate: { rowdetails: "<div id='grid' style='margin: 1px;'></div>", rowdetailsheight: 80, rowdetailshidden: true },
            ready: function () {
                $("#jqxGrid").jqxGrid('showrowdetails', 0);
            },
           
		});
	});
	   

