
if (IsSuperUser)
    HasDetails = true;
IsDetailListModal = false;
_autoheight = true;
_showfilterrow = true;


DetailPrimaryKey = 'RangexpersonId';
 

urls = {
    saveurl: '/savepoligonajax',
    getmasterurl: '/getpoligonsajax',
    getdetailurl: '/getpoligonajax',
    deleteurl: '/deletepoligonajax',
    getdetaillisturl: '/getpoligondetaillistajax'

};

listdatafields=
    [
        { name: 'RangeId', type: 'integer'},
        { name: 'Name', type: 'string'},
    ]

listdatacolumns=
    [
        { text: 'Poligon', datafield: 'Name', width: '100%'}, 
        { text: 'RangeId', datafield: 'RangeId', hidden: true},
    ]


detaildatafields= [
  

        { name: 'RangexpersonId', type: 'integer'},
        { name: 'RangeId', type: 'integer'},
        { name: 'PersonId', type: 'integer'},
        { name: 'Range', type: 'string'},
        { name: 'Person', type: 'string'},
       
        

    ]
    
detailcolumns=  [
        {text: 'RangexpersonId', datafield: 'RangexpersonId', hidden: true,},


        {text: 'Person', datafield: 'PersonId', displayField: 'Person', columntype: 'dropdownlist', width:'70%',
            createeditor: function (row, value, editor) {
                editor.jqxDropDownList({ source: persons, displayMember: 'Name', valueMember: 'PersonId' });
            }
        }
   ]



