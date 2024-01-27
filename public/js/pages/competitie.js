
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

        if (window.innerWidth < 900){

            if (Status == 'Open'){
                clClasament = [      
                    { text: 'Nr', dataField: 'Position', width: '5%' }, 
                   
                    { text: translate('Sportiv'), dataField: 'Person', width: (HasCompetitionRight) ?'55%':'60%' , cellclassname: cellclassUser},
                    { text: translate('Cat'), dataField: 'Category', width: '10%' },
                    { text: translate('Team'), dataField: 'Team', width: '25%' },
                  
                   
                ]
            }  else if (Status == 'Preparation'){
                clClasament = [      
                    { text: 'BIB', dataField: 'BIB', width: '5%' },  
                    { text: translate('Serie'), dataField: 'NrSerie', width: '5%' },     
                    { text: translate('Sportiv'), dataField: 'Person', width: (HasCompetitionRight )?'50%':'55%'  , cellclassname: cellclassUser},
                    { text: translate('Cat'), dataField: 'Category', width: '10%' },
                    { text: translate('Team'), dataField: 'Team', width: '20%' },
                    { text: translate('In Echipa'), dataField: 'TeamName', width: '5%' },
                ]



                }
            else{
                clClasament = [
                    { text: translate('Loc'), dataField: 'Position', width: '5%' },
                    { text: translate('Sportiv'), dataField: 'Person', width:  (HasCompetitionRight )?'45%':'50%'  , cellclassname: cellclassUser},
                    { text: translate('Cat'), dataField: 'Category', width: '10%' },
                    { text: translate('Team'), dataField: 'Team', width: '15%' },
                    { text: translate('Total'), dataField: 'Total', width: '15%' },               
                ]
            }
        }
        else{


            if (Status == 'Open'){
                clClasament = [      
                    { text: 'Nr', dataField: 'Position', width: '5%' },  
                    { text: translate('Sportiv'), dataField: 'Person', width: (HasCompetitionRight )?'55%':'60%'  , cellclassname: cellclassUser},
                    { text: translate('Cat'), dataField: 'Category', width: '10%' },
                    { text: translate('Team'), dataField: 'Team', width: '20%' },
                    { text: translate('In Echipa'), dataField: 'TeamName', width: '5%' },
                ]
            }
            else if (Status == 'Preparation'){
                clClasament = [      
                    { text: 'BIB', dataField: 'BIB', width: '5%' },  
                    { text: translate('Serie'), dataField: 'NrSerie', width: '5%' },     
                    { text: translate('Sportiv'), dataField: 'Person', width: (HasCompetitionRight )?'50%':'55%'  , cellclassname: cellclassUser},
                    { text: translate('Cat'), dataField: 'Category', width: '10%' },
                    { text: translate('Team'), dataField: 'Team', width: '20%' },
                    { text: translate('In Echipa'), dataField: 'TeamName', width: '5%' },
                ]



                }
                
            
            else{
                clClasament =
                    [
                        { text: translate('Loc'), dataField: 'Position', width: '5%' },
                        { text: translate('Sportiv'), dataField: 'Person', width: '13%', cellclassname: cellclassUser },
                        { text: translate('Cat'), dataField: 'Category', width: '5%' },
                        { text: translate('Team'), dataField: 'Team', width: HasCompetitionRight?'5%':'10%' },
                        { text: 'M1', dataField: 'M1', width: '4%' ,cellclassname: cellclass,},
                        { text: 'M2', dataField: 'M2', width: '4%' ,cellclassname: cellclass,},
                        { text: 'M3', dataField: 'M3', width: '4%' ,cellclassname: cellclass,},
                        { text: 'M4', dataField: 'M4', width: '4%' ,cellclassname: cellclass,},
                        { text: translate('Total 1'), dataField: 'Total1', width: '5%' },
                        { text: 'M5', dataField: 'M5', width: '4%' ,cellclassname: cellclass,},
                        { text: 'M6', dataField: 'M6', width: '4%' ,cellclassname: cellclass,},
                        { text: 'M7', dataField: 'M7', width: '4%' ,cellclassname: cellclass,},
                        { text: 'M8', dataField: 'M8', width: '4%' ,cellclassname: cellclass,},
                        { text: translate('Total 2'), dataField: 'Total2', width: '5%' },
                        { text: translate('Total'), dataField: 'Total', width: '5%' },
                        { text: translate('Procent'), dataField: 'ProcentR', width: '5%'},
                    { text: translate('Proc clasa'), dataField: 'Procent', width: '5%' },
                        { text: 'ShOff', dataField: 'ShootOffS', width: '5%' },  
                        { text: translate('Cat'), dataField: 'ResultatCat', width: '5%' },  
                           
                    ];
                }
        }


        if (HasCompetitionRight){
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

        function createSquads(e){
            lastevent = e;
            let type = lastevent.target.dataset.type == 'All'?translate('Doriti sa generati squadurile pentru toti participantii'):lastevent.target.dataset.type=='Clear'?translate('Doriti sa stergeti BIB-urile'): 
                    lastevent.target.dataset.type=='Even'? translate('Doriti sa generati squadurile in mod echilibrat valoric'): translate('Doriti sa generati squadurile doar pentru cei ce nu au inca squad')
            confirm(`${type}?`, createSquadsDo);
        }

        function createSquadsDo(){
            let Data = {};

            Data.Type = lastevent.target.dataset.type;
            Data.CompetitionId = $('#CompetitionId').val();

            $.ajax({
                type: 'POST',
        
                url: baseUrl + '/doCompetitionSquads',
                data: Data,
                success: function (data) {
                    if (data === 'OK'){
                        ShowSuccess('S-au creat echipele cu succes');
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
                let Data = {};
                Data.CompetitionId = $('#CompetitionId').val();
                Data.PersonId = PersonId;
            

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
                            
                            putAttributes(PersonId);
            
                    
                    },
                    error: function(e){
                        ShowError(e);
                    }
                });
              
            }

            // function registerMeDo(){
            //     let Data = {};
            //     Data.CompetitionId = $('#CompetitionId').val();
            //     Data.Register = 1;

            //     $.ajax({
            //         type: 'POST',
            
            //         url: baseUrl + '/registerMe',
            //         data: Data,
            //         success: function (data) {
            //             if (data === 'OK'){
            //                 ShowSuccess('Ati fost inregistrat cu succes');
            //                 setTimeout(window.location.reload(), 300)
                            
            //             }
            //             else    
            //                 ShowError(data)
                    
            //         },
            //         error: function(e){
            //             ShowError(e);
            //         }
            //     });
            // }

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
                $('#PersonId').off().on('change', onChangePerson);
            },
            error: function(e){
                ShowError(e);
            }
        });
}

function genereazaTimetable() {
    confirm('Doriti sa generati programul?', genereazaTimetableDo);
}

function genereazaTimetableDo() {
    let Data = {};
    Data.CompetitionId = $('#CompetitionId').val();
    $.ajax({
        type: 'POST',
        url: baseUrl + '/generateTimetable',
        data: Data,

        success: function (data) {
            if (data === 'OK') {
                ShowSuccess('S-a creat programul cu success');
            } else {
                ShowError(data);
            }
        },
        error: function (e) {
            ShowError(e);
        }
    });
}    

function saveSchedule() {

}

function seeTimetable() {
    let Data = {};
    Data.CompetitionId = $('#CompetitionId').val();
    $.ajax({
        type: 'POST',
        url: baseUrl + '/getTimetable',
        data: Data,
        success: function (data) {
            $("#popup_body").html(data);
            $("#popupDialog").modal({
                backdrop: 'static',
                keyboard: false
            }).show();

            $('#btnPopupCloseModal').off().on('click',
                () => {
                    $("#popupDialog").modal({
                        backdrop: 'static',
                        keyboard: false
                    }).hide();
                }
            );
            $('#btnPopupSaveModal').off().on('click', saveSchedule);

        },
        error: function (e) {
            ShowError(e);
        }
    });
}

    function RetrieveFields(){


        var results = {};
    
        $("#addcompetitor :input").each(function(){
            var val;
            if ($(this).is(':checkbox'))
                val = $(this).prop( "checked")?1:0;
            else
                val =  $(this).val();
            results[$(this).attr('id')] = val;
        
        });


       
        return results;


    }	

    function addCompetitorDB(){
        let Data = {};
     

        Data = RetrieveFields();

       
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

    
    function onChangePerson(e){
        let PersonId = $(e.target).val();
        if (!PersonId > 0)
            return;

        putAttributes(PersonId);

    }
    

    function putAttributes(PersonId){   

        $.ajax({
            type: 'POST',
    
            url: baseUrl + '/getpersonajax',
            data: {PersonId: PersonId},
            success: function (data) {
               

                ShowSuccess('Detalii aduse');
                data = data[0][0];
                let fields = [];

                let ShooterCategoryId = $( "#PersonId option:selected" ).attr('data-shootercategoryid');
                let TeamId = $( "#PersonId option:selected" ).attr('data-teamid');


                $('#ShooterCategoryId').val(ShooterCategoryId);
                $('#TeamId').val(TeamId);

                Object.keys(data).forEach(element => {
					fields.push(element);
					
				});

                fields.forEach(element => {
                    if ($('#' + element).is(':checkbox')){
                        $('#' + element).prop( "checked", data[element] == 1 );
                    }else{
                        $('#' + element).val(data[element]);
                    }
                    
                });
   
            },
            error: function(e){
                ShowError(e);
            }
        });



       
    }


	$(function () {



        $(".cmpStatusChange").on('click', changeCompetitionStatus);
        $(".createSquads").on('click', createSquads);

        $("#btnRegister").on('click', registerMe);
        $("#btnUnRegister").on('click', unRegisterMe);
        $("#addCompetitor").on('click', addCompetitor);
       
        $("#exportexcel").on('click', downloadDetailExcel);

        $("#btnGenTimetable").on('click', genereazaTimetable);
        $("#btnSeeTimetable").on('click', seeTimetable);



        function downloadDetailExcel() {
            document.location.href = '/ExportCompetitie/' + $('#CompetitionId').val();
        }

        
        $("#exportpdf").click(function () {
            $("#jqxGrid").jqxGrid('exportdata', 'pdf', 'jqxGrid');
        });
        
	
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
                            { name: 'Total1', type: 'number'},
                            { name: 'Total2', type: 'number'},
                            { name: 'Procent', type: 'number'},
                            { name: 'ProcentR', type: 'number'},
                            { name: 'ShootOffS', type: 'string'},
                            { name: 'ResultatCat', type: 'string'},
                            { name: 'BIB', type: 'number'},
                            { name: 'TeamName', type: 'string'},
                            { name: 'NrSerie', type: 'string'},
                            
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



        // prepare the data
		var sourcecat =
		{
			datatype: "array",
			localdata: dsClasamentCat,
			dataFields:
		
                    [
                        { name: translate('loc'), type: 'number'},
                        { name: 'Category', type: 'string'},
                        { name: 'Team', type: 'string'},
                        { name: 'Person', type: 'string'},
                        { name: 'Total', type: 'Number'},
                        { name: 'ShootOffS', type: 'string'},
                        
                    ]
				
			
		};

		var dataAdapterCat =  new $.jqx.dataAdapter(sourcecat);

        if ( $("#jqxGridCat").length)
        $("#jqxGridCat").jqxGrid(
            {
                width:'100%',
                //height: '100%',
                source: dataAdapterCat,                
                pageable: false,
                autoheight: true,
                sortable: false,
                altrows: true,
                enabletooltips: true,
                editable: false,
                autorowheight: false,
                showfilterrow: false,
                filterable: false,
                selectionmode: 'none',
                columns: [
                    { text: translate('Loc'), dataField: translate('loc'), width: '5%' ,cellclassname: cellclass,},
                    { text: 'Categorie', dataField: 'Category', width: '5%' ,cellclassname: cellclass,},
                    { text: 'Persoana', dataField: 'Person', width: '70%' ,cellclassname: cellclass,},
                    { text: 'Total', dataField: 'Total', width: '10%' ,cellclassname: cellclass,},
                    { text: 'Shoot off', dataField: 'ShootOffS', width: '10%' ,cellclassname: cellclass,},

               ]
               
               
            });


        // prepare the data
		var sourceteam=
		{
			datatype: "array",
			localdata: dsClasamentTeam,
			dataFields:
		
                    [
                        { name: translate('Loc'), type: 'number'},
                        { name: 'Team', type: 'string'},
                        { name: 'Total', type: 'Number'},
                        { name: 'Members', type: 'string'},
                        
                    ]
				
			
		};

		var dataAdapterTeam =  new $.jqx.dataAdapter(sourceteam);

        if ( $("#jqxGridTeam").length)
        $("#jqxGridTeam").jqxGrid(
            {
                width:'100%',
                //height: '100%',
                source: dataAdapterTeam,                
                pageable: false,
                autoheight: true,
                sortable: false,
                altrows: true,
                enabletooltips: true,
                editable: false,
                autorowheight: false,
                showfilterrow: false,
                filterable: false,
                selectionmode: 'none',
                columns: [
                    { text: translate('Loc'), dataField: translate('Loc'), width: '5%' ,cellclassname: cellclass,},
                    { text: 'Echipa', dataField: 'Team', width: '25%' ,cellclassname: cellclass,},
                    { text: 'Membrii', dataField: 'Members', width: '60%' ,cellclassname: cellclass,},
                    { text: 'Total', dataField: 'Total', width: '10%' ,cellclassname: cellclass,},
         

               ]
               
               
            });


        // prepare the data
        var sourcesup =
        {
            datatype: "array",
            localdata: dsClasamentSup,
            dataFields:

                [
                    { name: 'Position', type: 'number' },
                    { name: 'Person', type: 'string' },
                    { name: 'Total', type: 'Number' },
                    { name: 'ShootOffS', type: 'string' },
                    { name: 'Puncte', type: 'number' },

                ]


        };

        var dataAdapterSup = new $.jqx.dataAdapter(sourcesup);

        if ($("#jqxGridSup").length)
            $("#jqxGridSup").jqxGrid(
                {
                    width: '100%',
                    //height: '100%',
                    source: dataAdapterSup,
                    pageable: false,
                    autoheight: true,
                    sortable: false,
                    altrows: true,
                    enabletooltips: true,
                    editable: false,
                    autorowheight: false,
                    showfilterrow: false,
                    filterable: false,
                    selectionmode: 'none',
                    columns: [
                        { text: translate('Position'), dataField: 'Position', width: '5%', cellclassname: cellclass, },
                        { text: 'Persoana', dataField: 'Person', width: '70%', cellclassname: cellclass, },
                        { text: 'Total', dataField: 'Total', width: '10%', cellclassname: cellclass, },
                        { text: 'Shoot off', dataField: 'ShootOffS', width: '5%', cellclassname: cellclass, },
                        { text: 'Puncte', dataField: 'Puncte', width: '10%', cellclassname: cellclass, },
                    ]


                });



	});
	   

