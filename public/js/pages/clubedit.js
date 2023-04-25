

HasDetails = false;
IsDetailListModal = false;
_autoheight = true;
_showfilterrow = true;



 

urls = {
    saveurl: '/saveclubajax',
    getmasterurl: '/getclubsajax',
    getdetailurl: '/getclubajax',
    deleteurl: '/deleteclubajax',


};

listdatafields=
    [
        { name: 'TeamId', type: 'integer'},
        { name: 'Name', type: 'string'},
    ]

listdatacolumns=
    [
        { text: 'Club', datafield: 'Name', width: '100%'}, 
        { text: 'TeamId', datafield: 'TeamId', hidden: true},
    ]





    $(function () {

        $( "#echivalareclub" ).submit(function( event ) {
            event.preventDefault();
            
    
            confirm(translate("Doriti sa echivalati clubul?") , Echivaleaza);
    
    
        });
    });
    
    function Echivaleaza(){
    
        goodId = $("#TeamId").val();
        badId = $("#OldTeamId").val();   
    
        if (!badId){
            ShowError('Alegeti un club pentru echivalare');
            return;
        }
    
        if (!goodId){
            ShowError('Spooky');
            return;
        }
    
        if (goodId == badId){
            ShowError('Alegeti un club diferit');
            return;
        }
    
    
        let Data ={goodId: goodId, badId: badId};
        
        $.ajax({
            type: 'POST',
    
            url: baseUrl + '/echivalareclub',
            data: Data,
            success: function (data) {
                ShowSuccess(translate('Clubul a fost echivalat'));
                RefreshMaster(LastFilter);
            
            },
            error: function(data){
                ShowError(data)
            }
        });
    }