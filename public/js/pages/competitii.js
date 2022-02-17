

    let smcolumns = [];
    let dsCompetitiiY = [];

    if (window.innerWidth > 900){
        smcolumns = [
            { text: 'Nume', dataField: 'Name', width: '35%' },
            { text: 'Locatie', dataField: 'Range', width: '30%' },
            { text: 'Perioada', dataField: 'Perioada', width: '20%' },
            { text: 'An', dataField: 'Year', width: '10%'},// ,filtertype: 'checkedlist', filteritems: [...new Set(dsCompetitii.Year)]},
            { text: '', dataField: 'CompetitionId', width: '15', 
                        columntype:'button', cellsrenderer: function () {
                        return "...";                 
                        }, 
             
                buttonclick: function (row) {
                    // open the popup window when the user clicks a button.
                        let editrow = row;
                    // var offset = $("#grid").offset();
                        var dataRecord = $("#jqxGrid").jqxGrid('getrowdata', editrow);
                        const CompetitionId = dataRecord.CompetitionId

                        document.location.href = `clasament/${CompetitionId}`;
                    }
         
                }
        ]
    }
    else{
            smcolumns = [ { text: 'Nume', dataField: 'NumeLung', width: '73%' },
            { text: 'An', dataField: 'Year', width: '15%' ,filtertype: 'checkedlist', filteritems: [...new Set(dsCompetitii.Year)]},
            { text: '', dataField: 'CompetitionId', width: '15', 
            columntype:'button', cellsrenderer: function () {
            return "...";

            
            }, 
            
            buttonclick: function (row) {
            // open the popup window when the user clicks a button.
                let editrow = row;
                // var offset = $("#grid").offset();
                var dataRecord = $("#jqxGrid").jqxGrid('getrowdata', editrow);
                const CompetitionId = dataRecord.CompetitionId

                    document.location.href = `clasament/${CompetitionId}`;
            }
        

            }
        ]
    }

    function getCompetitionByYear(Year){
        dsCompetitiiY = dsCompetitii.filter(x=>x.Year === Year);
        let source = 
		{
			datatype: "array",
			localdata: dsCompetitiiY,
			dataFields:
					[
						{ name: 'Name', type: 'string' },
						{ name: 'NumeLung', type: 'string' },
						{ name: 'Range', type: 'string' },
						{ name: 'CompetitionId', type: 'number'},
						{ name: 'Perioada', type: 'string' },
                        { name: 'Year', type: 'number'},
					]			
		};
		
		let dataAdapter =  new $.jqx.dataAdapter(source);
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
            filterable: true,
			selectionmode: 'none',
            showfilterrow: false,
			columns: smcolumns
		});


    }


	$(function () {
		// prepare the data



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
                     getCompetitionByYear(item.label);
                }
           
        });

        getCompetitionByYear($('#jqxYear').jqxDropDownList('getSelectedItem').label);


		
	});
	   