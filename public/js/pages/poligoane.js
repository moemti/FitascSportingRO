    //import { GETAJAX } from '../helpers.js';

    let pcolumns = [];

    if (window.innerWidth > 900){
        pcolumns = [
            { text: 'Poligon', dataField: 'Name', width: '30%' },
            { text: 'Adresa', dataField: 'Address', width: '30%' },
            { text: 'Telefon', dataField: 'Phone', width: '20%' },
            { text: 'Tara', dataField: 'Country', width: '10%' },
            { text: 'Detalii', dataField: 'RangeId', width: '10%', 
        
                createwidget: function (row, column, value, htmlElement) {
                    var imgurl = APP_URL + '/img/detail.png';
                    var img = '<img class="curPointer" style="margin-top: 1px;" height="90%"src="' + imgurl + '"/>';
                    var button = $("<div style='border:none;'>" + img + "<div class='buttonValue curPointer' data='" + value + "'>" + '' + "</div></div>");
                    $(htmlElement).append(button);
                    button.jqxButton({ template: "none", height: '100%', width: '100%' });
                    button.click(function (event) {
                    
                        const RangeId = button.find(".buttonValue")[0].getAttribute('data');

                        document.location.href = `poligon/${RangeId}`;
                    });
                },  
                initwidget: function (row, column, value, htmlElement) {
                    var imgurl = APP_URL + '/img/detail.png';
                    $(htmlElement).find('img')[0].src = imgurl;
                    }
        
        
            }
        ]

    }
    else{
        pcolumns = [
            { text: 'Poligon', dataField: 'Name', width: '90%' },
           
            { text: '', dataField: 'RangeId', width: '10%',
        
                createwidget: function (row, column, value, htmlElement) {
                    var imgurl = APP_URL + '/img/detail.png';
                    var img = '<img class="curPointer" style="margin-top: 1px;" height="90%"src="' + imgurl + '"/>';
                    var button = $("<div style='border:none;'>" + img + "<div class='buttonValue curPointer' data='" + value + "'>" + '' + "</div></div>");
                    $(htmlElement).append(button);
                    button.jqxButton({ template: "none", height: '100%', width: '100%' });
                    button.click(function (event) {
                    
                        const RangeId = button.find(".buttonValue")[0].getAttribute('data');

                        document.location.href = `poligon/${RangeId}`;
                    });
                },  
                initwidget: function (row, column, value, htmlElement) {
                    var imgurl = APP_URL + '/img/detail.png';
                    $(htmlElement).find('img')[0].src = imgurl;
                    }
        
        
            }
        ]
    
    }
	// Smart('#gridpoligoane', class {
	// 	get properties() {
	// 		return {
	// 			dataSource: new Smart.DataAdapter(
	// 			{
	// 				dataSource: dsPoligoane,
	// 				dataFields:
	// 					[
	// 						'Name: string',
	// 						'Country: string',
    //                         'Address: string', 
    //                         'Phone: string',
    //                         'RangeId: number'
	// 					]
	// 			}),
	// 			sorting: {
	// 				enabled: true
	// 			},
	// 			filtering: {
	// 				enabled: true
	// 			},
    //             editing: {
    //                 enabled: true,
    //                 action: 'none',
    //                 mode: 'row',
    //                 commandColumn: {
    //                     visible: true,
    //                     displayMode: 'icon',
    //                     position: 'near',
                      
    //                     dataSource: {
    //                         'commandColumnDelete': {visible: false},
    //                         'commandColumnEdit': {visible: false},
    //                         'commandColumnCustom': {icon: 'smart-icon-ellipsis-vert', command: 'commandColumnCustomCommand', visible: true, text: 'Vezi detalii'}
    //                     }
    //                 }
    //             },
	// 			behavior: { columnResizeMode: 'growAndShrink' },
	// 			columns: pcolumns,
	// 		}
	// 	}
	// });

    // window.commandColumnCustomCommand = function (row) {
    //     const RangeId = row.data.RangeId;

    //       document.location.href = `poligon/${RangeId}`;
     
    // }


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
	   
