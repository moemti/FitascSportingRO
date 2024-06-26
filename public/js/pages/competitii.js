

    let smcolumns = [];
    let dsCompetitiiY = [];

    var buttonclick = function (div) {
        // open the popup window when the user clicks a button.
       //     let editrow = row;
        // var offset = $("#grid").offset();
         //   var dataRecord = $("#jqxGrid").jqxGrid('getrowdata', editrow);
            const CompetitionId = div.target.dataset.id;
            document.location.href = `clasament/${CompetitionId}`;
        };


    function cellsrenderer(row, column, value) {
        return '<div class = "cdetailbtn"  data-id = "' + value + '" >' + '...' + '</div>';
    }

    if (window.innerWidth > 900){
        smcolumns = [
            { text: translate('Nume'), dataField: 'Name', width: '25%' },
            { text: translate('Tip'), dataField: 'Tip', width: '10%' },
            { text: translate('Disciplina'), dataField: 'SportField', width: '10%' },
            { text: translate('Locatie'), dataField: 'Range', width: '20%' },
            { text: translate('Perioada'), dataField: 'Perioada', width: '20%' },
            { text: translate('Stare'), dataField: 'Status', width: '10%', cellclassname: cellclassStatus},// ,filtertype: 'checkedlist', filteritems: [...new Set(dsCompetitii.Year)]},
            {
                text: '', dataField: 'CompetitionId', width: '5%',
                cellsrenderer: cellsrenderer,
            }
        ]
    }
    else{
            smcolumns = [ { text: translate('Nume'), dataField: 'NumeLung', width: '70%' },
            { text: translate('Stare'), dataField: 'Status', width: '15%' , cellclassname: cellclassStatus},
            { text: '', dataField: 'CompetitionId', width: '15%', 
                cellsrenderer: cellsrenderer,
            }
        ]
    }

    function cellclassStatus(row, columnfield, value) {
        switch(value) {
            case 'Open':
                return 'clGreenFontB';
              break;
            case 'Progress':
                return 'clOrangeRedFontB';
              break;
              case 'Finished':
                return 'clBlueFontB';
              break;
            default:
                return 'clBrownFontB';
          }
          
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
                    { name: 'CompetitionId', type: 'number' },
                    { name: 'Perioada', type: 'string' },
                    { name: 'Status', type: 'string' },
                    { name: 'Tip', type: 'string' },
                    { name: 'SportField', type: 'string' },
					]			
		};
		
		let dataAdapter =  new $.jqx.dataAdapter(source);
		// initialize jqxGrid
		$("#jqxGrid").jqxGrid(
		{
            width:'100%',
			source: dataAdapter,                
			pageable: false,
            rowsheight: 17,
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
        
        $(".cdetailbtn").on("click", buttonclick);

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

        let selectedindex = 0;

        let now = new Date().getFullYear()



        selectedindex = dsYears2.localdata.findIndex(function (y) {
            return y.Year == now
        });

        $("#jqxYear").jqxDropDownList({ source: dataAdapterY, selectedIndex: selectedindex, displayMember: "Year", valueMember: "Year", width: '200px', height: '25px' });

        $('#jqxYear').on('select', function (event) {

                var args = event.args;
                var item = $('#jqxYear').jqxDropDownList('getItem', args.index);
                if (item != null) {
                     getCompetitionByYear(item.label);
                }
           
        });

        getCompetitionByYear($('#jqxYear').jqxDropDownList('getSelectedItem').label);


		
	});
	   