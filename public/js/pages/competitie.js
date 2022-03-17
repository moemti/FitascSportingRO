
        let lastevent = undefined;
   
        var cellclass = function (row, columnfield, value) {
            if (value == 25) {
                return 'clRedFont';
            }
        
            else return '';


        }

        var cellclassUser = function (row, columnfield, value) {
            if (value === MyName) {
                return 'clOrangeRedFont';
            }
        
            else return '';


        }

        

        let clClasament = [];

        if (window.innerWidth < 900)

            if (Status == 'Open'){
                clClasament = [          
                    { text: 'Sportiv', dataField: 'Person', width: (IsSuperUser === 1)?'65%':'70%' , cellclassname: cellclassUser},
                    { text: 'Cat', dataField: 'Category', width: '10%' },
                    { text: 'Team', dataField: 'Team', width: '20%' },
                ]
            }
            else{
                clClasament = [
                    { text: 'Loc', dataField: 'Position', width: '5%' },
                    { text: 'Sportiv', dataField: 'Person', width:  (IsSuperUser === 1)?'45%':'50%'  , cellclassname: cellclassUser},
                    { text: 'Cat', dataField: 'Category', width: '10%' },
                    { text: 'Team', dataField: 'Team', width: '15%' },
                    { text: 'Total', dataField: 'Total', width: '15%' },               
                ]
        }
        else{

            if (Status == 'Open'){
                clClasament = [          
                    { text: 'Sportiv', dataField: 'Person', width: (IsSuperUser === 1)?'65%':'70%'  , cellclassname: cellclassUser},
                    { text: 'Cat', dataField: 'Category', width: '10%' },
                    { text: 'Team', dataField: 'Team', width: '20%' },
                ]
            }
            else{
                clClasament =
                    [
                        { text: 'Loc', dataField: 'Position', width: '5%' },
                        { text: 'Sportiv', dataField: 'Person', width: '25%', cellclassname: cellclassUser },
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
                }
        }


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

        function changeCompetitionStatus(e){
            lastevent = e;
            confirm('Doriti sa schimbati statusul competitiei?', changeCompetitionStatusDo);
        }
            
        
        function changeCompetitionStatusDo(){

                let Data = {};

                Data.Status = lastevent.target.dataset.status;
                Data.CompetitionId = $('#CompetitionId').val();

                $.ajax({
                    type: 'POST',
            
                    url: baseUrl + '/changeCompetitionStatus',
                    data: Data,
                    success: function (data) {
                        if (data === 'OK'){
                            ShowSuccess('S-a modificat cu succes');
                            window.location.reload();
                        }
                        else    
                            ShowError(data)
                    
                    },
                    error: function(e){
                        ShowError(e);
                    }
                });
            }

            function registerMe(){
              
                confirm('Doriti sa va inregistrati?', registerMeDo);
            }

            function registerMeDo(){
                let Data = {};
                Data.CompetitionId = $('#CompetitionId').val();
                Data.Register = 1;

                $.ajax({
                    type: 'POST',
            
                    url: baseUrl + '/registerMe',
                    data: Data,
                    success: function (data) {
                        if (data === 'OK'){
                            ShowSuccess('Ati fost inregistrat cu succes');
                            setTimeout(window.location.reload(), 300)
                            
                        }
                        else    
                            ShowError(data)
                    
                    },
                    error: function(e){
                        ShowError(e);
                    }
                });
            }

            function unRegisterMe(){
             
                confirm('Doriti sa renuntati?', unRegisterMeDo);
            }

            function unRegisterMeDo(){
                let Data = {};
                Data.CompetitionId = $('#CompetitionId').val();
                Data.Register = 0;

                $.ajax({
                    type: 'POST',
            
                    url: baseUrl + '/registerMe',
                    data: Data,
                    success: function (data) {
                        if (data === 'OK'){
                            ShowSuccess('Ati renuntat cu succes');
                            setTimeout(window.location.reload(), 300);
                            
                        }
                        else    
                            ShowError(data)
                    
                    },
                    error: function(e){
                        ShowError(e);
                    }
                });
            }


    function addCompetitor(){
        let Data = {};
        Data.CompetitionId = $('#CompetitionId').val();
       

        $.ajax({
            type: 'POST',
    
            url: baseUrl + '/registerCompetitor',
            data: Data,
            success: function (data) {
                
                    $("#popup_body").html(data);

                    $("#popupDialog").modal({
                        backdrop: 'static',
                        keyboard: false
                    }).show();
                    
                    $('#btnPopupCloseModal').off().on('click', 
                         ()=>{
                        $("#popupDialog").modal({
                            backdrop: 'static',
                            keyboard: false
                        }).hide();
                    }
                    
                    
                    );
                    
                    $('#btnPopupSaveModal').off().on('click', addCompetitorDB);
                    $('#PersonId').off().on('change', putAttributes);
     
            
            },
            error: function(e){
                ShowError(e);
            }
        });


       
    }        


    function addCompetitorDB(){
        let Data = {};
        Data.CompetitionId = $('#CompetitionId').val();
        Data.PersonId = $('#PersonId').val() * 1;
        Data.Name = $('#Name').val().trim();
        Data.Team = $('#Team').val().trim();
        Data.TeamId = $('#TeamId').val() * 1;
        Data.ShooterCategoryId = $('#ShooterCategoryId').val().trim() * 1;
       
        if ((Data.PersonId === -1) && (Data.Name === '')){
            ShowError('Alegeti o persoana sau introduceti un nume');
            return;
        }
        
            $("#popupDialog").modal({
                backdrop: 'static',
                keyboard: false
            }).hide();

        $.ajax({
            type: 'POST',
    
            url: baseUrl + '/registerCompetitorDB',
            data: Data,
            success: function (data) {
                if (data === 'OK'){
                    ShowSuccess('S-a adaugat cu success');
                    setTimeout(window.location.reload(), 300);
                }else{
                    ShowError(data);
                }
            },
            error: function(e){
                ShowError(e);
            }
        });


       
    }     

    function putAttributes(){
        let ShooterCategoryId = $( "#PersonId option:selected" ).attr('data-ShooterCategoryId');
        let TeamId = $( "#PersonId option:selected" ).attr('data-TeamId');
        let selector = `#ShooterCategoryId option[value='${ShooterCategoryId}']`;
        $(selector).attr('selected', 'selected');


        selector = `#TeamId option[value='${TeamId}']`;
        $(selector).attr('selected', 'selected');
    }


	$(function () {



        $(".cmpStatusChange").on('click', changeCompetitionStatus);
        $("#btnRegister").on('click', registerMe);
        $("#btnUnRegister").on('click', unRegisterMe);
        $("#addCompetitor").on('click', addCompetitor);
       
        
        
	
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
			//height: '100%',
			source: dataAdapter,                
			pageable: false,
			autoheight: true,
			sortable: true,
			altrows: true,
			enabletooltips: true,
			editable: false,
			autorowheight: false,
            showfilterrow: true,
            filterable: true,
			selectionmode: 'none',
			columns: clClasament,
            rowdetails: window.innerWidth < 900 && (Status !== 'Open')? true: false,
            initrowdetails: window.innerWidth < 900 && (Status !== 'Open')? initrowdetails:undefined,
            rowdetailstemplate: { rowdetails: "<div id='grid' style='margin: 1px;'></div>", rowdetailsheight: 80, rowdetailshidden: true },
            ready: function () {
                $("#jqxGrid").jqxGrid('showrowdetails', 0);
            },
           
		});
	});
	   

