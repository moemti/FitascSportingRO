MasterPrimaryKey = 'ResultDetailId';


 urls = {
    saveurl: '/saveresultdetail',
    getmasterurl: '/getresultsajax',
    actionurl: undefined,
    getdictionariesurl: undefined

};


MasterFields = 
    [
        { name: 'ResultDetailId', type: 'number'},
        { name: 'ResultId', type: 'Number'},
        { name: 'RoundNr', type: 'Number'},
        { name: 'Targets', type: 'number'},
        { name: 'Result', type: 'number'},
       
        { name: 'Description', type: 'string'},
    
    ];

 MasterColumns = [
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




    DefaultMasterValues.ResultId = ResultId;

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
