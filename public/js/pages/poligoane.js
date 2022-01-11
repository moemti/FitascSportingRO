    import { GETAJAX } from '../helpers.js';

    let pcolumns = [];

    if (window.innerWidth > 900){
        pcolumns = [
            { label: 'Poligon', dataField: 'Name', width: '40%' },
            { label: 'Adresa', dataField: 'Address', width: '30%' },
            { label: 'Telefon', dataField: 'Phone', width: '20%' },
            { label: 'Tara', dataField: 'Country', width: '10%' },
            {label: '', dataField: 'RangeId', width: '0', visible: false}
        ]

    }
    else{
        pcolumns = [
            { label: 'Poligon', dataField: 'Name', width: '100%' },
           
            {label: '', dataField: 'RangeId', width: '0', visible: false}
        ]
    
    }
	Smart('#gridpoligoane', class {
		get properties() {
			return {
				dataSource: new Smart.DataAdapter(
				{
					dataSource: dsPoligoane,
					dataFields:
						[
							'Name: string',
							'Country: string',
                            'Address: string', 
                            'Phone: string',
                            'RangeId: number'
						]
				}),
				sorting: {
					enabled: true
				},
				filtering: {
					enabled: true
				},
                editing: {
                    enabled: true,
                    action: 'none',
                    mode: 'row',
                    commandColumn: {
                        visible: true,
                        displayMode: 'icon',
                        position: 'near',
                      
                        dataSource: {
                            'commandColumnDelete': {visible: false},
                            'commandColumnEdit': {visible: false},
                            'commandColumnCustom': {icon: 'smart-icon-ellipsis-vert', command: 'commandColumnCustomCommand', visible: true, label: 'Vezi detalii'}
                        }
                    }
                },
				behavior: { columnResizeMode: 'growAndShrink' },
				columns: pcolumns,
			}
		}
	});

    window.commandColumnCustomCommand = function (row) {
        const RangeId = row.data.RangeId;

          document.location.href = `poligon/${RangeId}`;
     
    }
