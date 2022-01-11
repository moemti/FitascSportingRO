import { GETAJAX, POSTAJAX } from '../helpers.js';

   


        let clClasament = [];

        if (window.innerWidth < 900)
            clClasament = [
                { label: 'Loc', dataField: 'Position', width: '5%' },
                { label: 'Sportiv', dataField: 'Person', width: '40%' },
                { label: 'Cat', dataField: 'Category', width: '5%' },
                { label: 'Team', dataField: 'Team', width: '20%' },
                { label: 'Total', dataField: 'Total', width: '5%' },

            
            ]
        else
            clClasament =
                [
                    { label: 'Loc', dataField: 'Position', width: '5%' },
                    { label: 'Sportiv', dataField: 'Person', width: '25%' },
                    { label: 'Cat', dataField: 'Category', width: '5%' },
                    { label: 'Team', dataField: 'Team', width: '10%' },
                    { label: 'M1', dataField: 'M1', width: '5%' },
                    { label: 'M2', dataField: 'M2', width: '5%' },
                    { label: 'M3', dataField: 'M3', width: '5%' },
                    { label: 'M4', dataField: 'M4', width: '5%' },
                    { label: 'M5', dataField: 'M5', width: '5%' },
                    { label: 'M6', dataField: 'M6', width: '5%' },
                    { label: 'M7', dataField: 'M7', width: '5%' },
                    { label: 'M8', dataField: 'M8', width: '5%' },
                    { label: 'Total', dataField: 'Total', width: '5%' },
                    {label: 'Procent', dataField: 'Procent', width: '5%'},
                    { label: 'ShOff', dataField: 'ShootOffS', width: '5%' },
                ];

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



        Smart('#clasamentcompetitie', class {
            get properties() {
                return {
                    onRowInit(index, row) {
                       // if (index === 0) {
                            row.showDetail = false;
                       // }
                    },
             

                    onRowDetailInit(index, row, detail) {

                        if (window.innerWidth < 900){

                                const grid = document.createElement('div');
                                    
                                detail.appendChild(grid);
                                        
                                const gridInstance = new Smart.Grid(grid, {

                                    conditionalFormatting: cf,
                                    
                                    dataSource: new Smart.DataAdapter(
                                    {
                                        dataSource: dsClasament.filter(data => data.ResultId === row.data.ResultId),
                                        dataFields:
                                        [
                                            'M1: number',
                                            'M2: number',
                                            'M3: number',
                                            'M4: number',
                                            'M5: number',
                                            'M6: number',
                                            'M7: number',
                                            'M8: number',
                                            'Total: number',
                                            'ShootOffS: string',
                                        ]
                                    }),
                                    columns: [
                                        { label: 'M1', dataField: 'M1', width: '9%' },
                                        { label: 'M2', dataField: 'M2', width: '9%' },
                                        { label: 'M3', dataField: 'M3', width: '9%' },
                                        { label: 'M4', dataField: 'M4', width: '9%' },
                                        { label: 'M5', dataField: 'M5', width: '9%' },
                                        { label: 'M6', dataField: 'M6', width: '9%' },
                                        { label: 'M7', dataField: 'M7', width: '9%' },
                                        { label: 'M8', dataField: 'M8', width: '9%' },
                                        { label: 'Total', dataField: 'Total', width: '10%' },
                                        { label: 'ShOff', dataField: 'ShootOffS', width: '5%' },
                                    ]
                                });	
                            }				
                    },
                    rowDetail: {
                        enabled: window.innerWidth < 900,
                        visible: window.innerWidth < 900, 
                        height: 100
                    },

                    dataSource: new Smart.DataAdapter(
                    {
                        dataSource: dsClasament,
                        dataFields:
                            [
                                'Position: number',
                                'Person: string',
                                'Category: string',
                                'Team: string',
                                'ResultId: number',
                                'M1: number',
                                'M2: number',
                                'M3: number',
                                'M4: number',
                                'M5: number',
                                'M6: number',
                                'M7: number',
                                'M8: number',
                                'Total: number',
                                'Procent: number',
                                'ShootOffS: string',
                            ]
                               
                    }),
                    sorting: {
                        enabled: false
                    },
                    filtering: {
                        enabled: true
                    },
                    editing: {
                        enabled: false,
                      
                    },
                    behavior: { columnResizeMode: 'growAndShrink' 
                },
                    columns: clClasament,
                    conditionalFormatting: cf
                    
                }
            }
          });

        //   const grid = document.querySelector('smart-grid');
        //     grid.refresh();         


