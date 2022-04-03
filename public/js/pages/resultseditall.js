urls.saveurl =  '/saveresultsall';
urls.getlistajax = '/getresultallajax'
var MasterPrimaryKey = "ResultId"

var cellclass = function (row, columnfield, value) {

     let r = '';

    switch (columnfield ){
    
        case 'M1':
        case 'M2':
        case 'M3':
        case 'M4':
            r += ' clFirstDay ';
            break;
        case 'M5':
        case 'M6':
        case 'M7':
        case 'M8':
            r += ' clSecondDay ';
          break;

        case 'M9':
        case 'M10':
        case 'M11':
            r += ' clShootOff ';
            break;
        case 'Total':
            r += ' clTotal';
            break;
    

    }

    if (value == 25) {
        r += ' clRedFont ';
    }

     return r;


}
 
 MasterFields = 
[
    { name: 'NrSerie', type: 'string'},
    { name: 'BIB', type: 'string'},
    { name: 'Person', type: 'string'},
    { name: 'ResultId', type: 'number'},
    { name: 'M1', type: 'number'},
    { name: 'M2', type: 'number'},
    { name: 'M3', type: 'number'},
    { name: 'M4', type: 'number'},
    { name: 'M5', type: 'number'},
    { name: 'M6', type: 'number'},
    { name: 'M7', type: 'number'},
    { name: 'M8', type: 'number'},
    { name: 'M9', type: 'number'},
    { name: 'M10', type: 'number'},
    { name: 'M11', type: 'number'},
    { name: 'Total', type: 'number'},

];

let max25 = function (cell, value) {
    if (value == "")
       return true;

    if (value < 0 || value > 25) {
        return { result: false, message: "Valoare trebuie sa fie intre 0-25" };
    }
    return true;
}

	 MasterColumns =  [
        { text: 'ResultId', dataField: 'ResultId', width: '0%' , hidden: 'true'},
        { text: 'Serie', dataField: 'NrSerie', width: '5%', editable: false},
        { text: 'BIB', dataField: 'BIB', width: '5%', editable: false },
        { text: 'Sportiv', dataField: 'Person', width: '35%', editable: false },
        { text: 'P1',  columngroup: 'Ziua 1', dataField: 'M1', width: '5%' ,cellclassname: cellclass, validation: max25},
        { text: 'P2', columngroup: 'Ziua 1', dataField: 'M2', width: '5%' ,cellclassname: cellclass, validation: max25},
        { text: 'P3', columngroup: 'Ziua 1', dataField: 'M3', width: '5%' ,cellclassname: cellclass, validation: max25},
        { text: 'P4', columngroup: 'Ziua 1', dataField: 'M4', width: '5%' ,cellclassname: cellclass, validation: max25},
        { text: 'P1', columngroup: 'Ziua 2', dataField: 'M5', width: '5%' ,cellclassname: cellclass, validation: max25},
        { text: 'P2', columngroup: 'Ziua 2', dataField: 'M6', width: '5%' ,cellclassname: cellclass, validation: max25},
        { text: 'P3', columngroup: 'Ziua 2', dataField: 'M7', width: '5%' ,cellclassname: cellclass, validation: max25},
        { text: 'P4', columngroup: 'Ziua 2', dataField: 'M8', width: '5%' ,cellclassname: cellclass, validation: max25},
        { text: 'Sh-1', columngroup: 'Shoot off', dataField: 'M9', width: '5%' ,cellclassname: cellclass, validation: max25},
        { text: 'Sh-2', columngroup: 'Shoot off', dataField: 'M10', width: '5%' ,cellclassname: cellclass, validation: max25},
        { text: 'Sh-3', columngroup: 'Shoot off', dataField: 'M11', width: '5%' ,cellclassname: cellclass, validation: max25},
     
    ];

    columngroups = [
        { text: 'Ziua 1', align: 'center', name: 'Ziua 1' },
        { text: 'Ziua 2', align: 'center', name: 'Ziua 2' },
        { text: 'Shoot off', align: 'center', name: 'Shoot off' }
    ]

