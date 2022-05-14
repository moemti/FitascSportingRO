urls.saveurl =  '/savetranslation';
urls.getlistajax = '/gettranslationajax'

var MasterPrimaryKey = "TranslationId"

var cellclass = function (row, columnfield, value) {

    return '';


}
 
 MasterFields = 
[
    { name: 'Translation', type: 'string'},
    { name: 'Locale', type: 'string'},
    { name: 'Base', type: 'string'},
    { name: 'TranslationId', type: 'number'},
    

];



	 MasterColumns =  [
        { text: 'TranslationId', dataField: 'TranslationId', width: '0%' , hidden: 'true'},
        { text: 'Base', dataField: 'Base', width: '45%', editable: false},
        { text: 'Locale', dataField: 'Locale', width: '5%', editable: false },
        { text: 'Translation', dataField: 'Translation', width: '50%', editable: true },
       
    ];

   
