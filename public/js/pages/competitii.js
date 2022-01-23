import { GETAJAX, POSTAJAX } from '../helpers.js';

    let smcolumns = [];



    if (window.innerWidth > 900){
        smcolumns = [
            { text: 'Nume', dataField: 'Name', width: '35%' },
            { text: 'Locatie', dataField: 'Range', width: '30%' },
            { text: 'Perioada', dataField: 'Perioada', width: '20%' },
            { text: 'An', dataField: 'Year', width: '10%' },
          //`  { text: 'CompetitionId', dataField: 'CompetitionId', width: '0', hidden:true },
            {text:'', dataField: 'CompetitionId', width: '5%',
                createwidget: function (row, column, value, htmlElement) {
                var imgurl = APP_URL + '/img/podium.png';
                var img = '<img class="curPointer" style="margin-top: 1px;" width="90%"src="' + imgurl + '"/>';
                var button = $("<div style='border:none;'>" + img + "<div class='buttonValue curPointer' data='" + value + "'>" + '' + "</div></div>");
                $(htmlElement).append(button);
                button.jqxButton({ template: "none", height: '100%', width: '100%' });
                button.click(function (event) {
                  
                    const CompetitionId = button.find(".buttonValue")[0].getAttribute('data');

                    document.location.href = `clasament/${CompetitionId}`;
                });
            },
            initwidget: function (row, column, value, htmlElement) {
                var imgurl = APP_URL + '/img/podium.png';
                $(htmlElement).find('img')[0].src = imgurl;
            }}
        ]

    }
    else{
        smcolumns = [ { text: 'Nume', dataField: 'NumeLung', width: '90%' },
        // { text: 'Locatie', dataField: 'Range', width: '40%' },
        
       
        {text:'', dataField: 'CompetitionId', width: '10%',
                createwidget: function (row, column, value, htmlElement) {
              
                var imgurl = APP_URL + '/img/podium.png';
                var img = '<img  width="70%" src="' + imgurl + '"/>';
                var button = $("<div style='border:none; margin-top: 1px; margin-right:2px;'>" + img + "<div class='buttonValue' data='" + value + "'>" + '' + "</div></div>");
                $(htmlElement).append(button);
                button.jqxButton({ template: "none", height: '100%', width: '100%' });
                button.click(function (event) {
                  
                    const CompetitionId = button.find(".buttonValue")[0].getAttribute('data');

                      document.location.href = `clasament/${CompetitionId}`;
                });
            },
            initwidget: function (row, column, value, htmlElement) {
                var imgurl = APP_URL + '/img/podium.png';

                $(htmlElement).find('img')[0].src = imgurl;
            }}
    ]
    }



	   

    // window.commandColumnCustomCommand = function (row) {
    //     const CompetitionId = row.data.CompetitionId;

    //       document.location.href = `clasament/${CompetitionId}`;
     
    // }



	$(function () {
	
		// prepare the data
		var source =
		{
			datatype: "array",
			localdata: dsCompetitii,
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
		
			columns: smcolumns
		});
	});
	   