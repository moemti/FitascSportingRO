
HasDetails = true;
IsDetailListModal = false;
_autoheight = true;
_showfilterrow = true;


DetailPrimaryKey = 'OLD_SessionId';
 

urls = {
    saveurl: '/savepersonajax',
    getmasterurl: '/getpersonsajax',
    getdetailurl: '/getpersonajax',
    deleteurl: '/deletepersonajax',
    getdetaillisturl: '/getpersondetaillistajax'

};

listdatafields=
    [
        { name: 'PersonId', type: 'integer'},
        { name: 'Name', type: 'string'},
        { name: 'NickName', type: 'string'},
       

    ]

listdatacolumns=
    [
        { text: 'Person', datafield: 'Name', width: '70%'},
        { text: 'NickName', datafield: 'NickName',  width:'30%'},     
        { text: 'PersonId', datafield: 'PersonId', hidden: true},
    ]


detaildatafields= [
  
    { name: 'Year', type: 'string'},
    { name: 'ShooterCategory', type: 'string'},
    { name: 'Team', type: 'string'},


        { name: 'OLD_SeasonId', type: 'integer'},
        { name: 'NEW_SeasonId', type: 'integer'},
        
    
        

        { name: 'PersonId', type: 'integer'},
        { name: 'OLD_ShooterCategoryId', type: 'integer'},
        { name: 'NEW_ShooterCategoryId', type: 'integer'},
        { name: 'OLD_TeamId', type: 'integer'},
        { name: 'NEW_TeamId', type: 'integer'},
        

    ]
    
detailcolumns=  [
        {text: 'OLD_SeasonId', datafield: 'OLD_Season', hidden: true,},
        {text: 'OLD_ShooterCategoryId', datafield: 'OLD_ShooterCategoryId', hidden: true,},
        {text: 'OLD_TeamId', datafield: 'OLD_TeamId', hidden: true,},

        {text: 'Year', datafield: 'NEW_SeasonId', displayField: 'Year', columntype: 'dropdownlist', width:'30%',
            createeditor: function (row, value, editor) {
                editor.jqxDropDownList({ source: seasons, displayMember: 'Year', valueMember: 'SeasonId' });
            }
        },

        {text: 'Shooter Category', datafield: 'NEW_ShooterCategoryId', displayField: 'ShooterCategory', columntype: 'dropdownlist', width:'30%',
        createeditor: function (row, value, editor) {
            editor.jqxDropDownList({ source: shootercategories, displayMember: 'Name', valueMember: 'ShooterCategoryId' });
        }
        },
        {text: 'Team', datafield: 'NEW_TeamId', displayField: 'Team', columntype: 'dropdownlist', width:'40%',
        createeditor: function (row, value, editor) {
            editor.jqxDropDownList({ source: teams, displayMember: 'Name', valueMember: 'TeamId' });
        }
    },

        {text: 'PersonId', datafield: 'PersonId', hidden: true,},




   ]





   $(function () {

    $( "#echivalarepersoana" ).submit(function( event ) {
        event.preventDefault();
        

        confirm(translate("Doriti sa echivalati persoana?") , Echivaleaza);


    });
});

function Echivaleaza(){

    goodId = $("#PersonId").val();
    badId = $("#OldPersonId").val();   

    if (!badId){
        ShowError('Alegeti o persoana pentru echivalare');
        return;
    }

    if (!goodId){
        ShowError('Spooky');
        return;
    }

    if (goodId == badId){
        ShowError('Alegeti o persoana diferita');
        return;
    }


    let Data ={goodId: goodId, badId: badId};
    
    $.ajax({
        type: 'POST',

        url: baseUrl + '/echivalarepersoana',
        data: Data,
        success: function (data) {
            ShowSuccess(translate('Persoana a fost echivalata'));
        
        },
        error: function(data){
            ShowError(data)
        }
    });
}