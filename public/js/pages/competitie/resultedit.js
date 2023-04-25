
MasterPrimaryKey = 'ResultId';
DetailPrimaryKey = 'ResultDetailId';
IsOneMaster = true;



 urls = {
    saveurl: '/saveresultdetail',
    getmasterurl: '/getresultajax',
    getdetailurl: '/getresultajax',
    deleteurl: '/deleteresultajax',
    actionurl: undefined,
    getdictionariesurl: undefined,
    getdetaillisturl: '/getresultdetailsajax',

};




detaildatafields = 
    [
        { name: 'ResultDetailId', type: 'number'},
        { name: 'ResultId', type: 'Number'},
        { name: 'RoundNr', type: 'Number'},
        { name: 'Targets', type: 'number'},
        { name: 'Result', type: 'number'},
       
        { name: 'Description', type: 'string'},
    
    ];

detailcolumns = [
    { text: 'Round', dataField: 'RoundNr', width: '10%' ,
                validation: function (cell, value) {
                    if (value == "")
                        return { result: false, message: "Alegeti o valoare pentru Mansa" }
                    else 
                        return true;
                    
                }
          

    },
    { text: 'Targets', dataField: 'Targets', width: '10%'  ,
        validation: function (cell, value) {
            if (value == "")
                return { result: false, message: "Alegeti o valoare pentru numarul de talere" };
            else 
                return true;
            
        }},
    { text: 'Rezultat', dataField: 'Result', width: '10%'  ,
        validation: function (cell, value) {
            if (value == "")
                return { result: false, message: "Alegeti o valoare pentru Rezultat" };
            else 
                return true;
            
        }},
    { text: 'Descriere', dataField: 'Description', width: '70%' },



]  ; 





    function getOtherSaveFields(){
        return {ResultId: ResultId};
    } ;


    function ValidateBeforeSave(){
        let result = true;
        mydelta.forEach(element => {
            if (element.Operation != 'D'){
                if (!element.RoundNr){
                    ShowError('Introduceti numarul mansei');
                    result =  false;
                }
                if (!element.Result){
                    ShowError('Introduceti rezultatul');
                    result =  false;
                }
                if (!element.Targets){
                    ShowError('Introduceti numarul de talere');
                    result =  false;
                }

            }

        });
        return result;

    }


    function DeleteResult(){

        function DoDelete(){

            Data = {'ResultId': $('#'+ MasterPrimaryKey).val()}

            $.ajax({
                type: 'POST',

                url: baseUrl + urls.deleteurl,
                data: Data,
                success: function (data) {
                    ShowSuccess('Sters cu succes!');
                   
                    window.location.replace("/clasament/" +  $('#CompetitionId').val());
                    

                }
            });
        }

        var IsNew = $('#isnew').val();
        
        if (IsNew == "0"){
            if (ValidateDelete() == true)
                confirm("Doriti sa stergeti inregistrarea?", DoDelete);
        }


    }

  
    function SwitchPersons(e){

        function DoSwitch(){

           



            Data = {'CompetitionId': $('#CompetitionId').val(),
                    'PersonId1': $('#PersonId').val(),
                    'PersonId2': $('#PersonId1').val(),
        
        
            }

            $.ajax({
                type: 'POST',

                url: baseUrl + '/switchPersons',
                data: Data,
                success: function (data) {
                    ShowSuccess('Modificat cu succes!');
                 
                    $("#detailform").resetChanges();
		    		$(".tab-content" ).removeValidator();

                    location.reload();

                },
                error: function(data){
                    ShowError(data.responseJSON);
                }
            });
        }

        if ($('#PersonId1').val() == ''){
            ShowError('Alegeti o persoana pentru a le schimba intre ele!');
            return;
        }

        if ($('#PersonId1').val() == $('#PersonId').val()){
            ShowError('Nu puteti alege persoana curenta!');
            return;
        }

        detailform
        confirm("Doriti sa schimbati persoanele intre ele?", DoSwitch);


    }





    $(function () {


          $("#btnDelete").on('click', DeleteResult);

          $("#btnSwitch").on('click', SwitchPersons); 
        
      });