import { GETAJAX, POSTAJAX } from '../helpers.js';

    let smcolumns = [];


    if (window.innerWidth > 900){
        smcolumns = [
            { label: 'Nume', dataField: 'Name', width: '30%' },
            { label: 'Locatie', dataField: 'Range', width: '30%' },
            { label: 'Perioada', dataField: 'Perioada', width: '30%' },
            { label: 'An', dataField: 'Year', width: '10%' },
            { label: 'CompetitionId', dataField: 'CompetitionId', width: '0', visible:false }
        ]

    }
    else{
        smcolumns = [ { label: 'Nume', dataField: 'NumeLung', width: '90%' },
        // { label: 'Locatie', dataField: 'Range', width: '40%' },
        
       
        { label: 'CompetitionId', dataField: 'CompetitionId', width: '0', visible:false }
    ]
    }



    Smart('#gridcompetitii', class {
		get properties() {
			return {
                
				dataSource: new Smart.DataAdapter(
				{
					dataSource: dsCompetitii,
					dataFields:
						[
							'Name: string',
                            'NumeLung: string',
							'Range: string',
                            'CompetitionId: number',
                            'Perioada: string',
                            'Year: number']
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
				behavior: { columnResizeMode: 'growAndShrink' 
                        },
				columns: smcolumns
			}
		}
	});
	   

    window.commandColumnCustomCommand = function (row) {
        const CompetitionId = row.data.CompetitionId;

          document.location.href = `clasament/${CompetitionId}`;
     
    }


