

IsDetailListModal = false;
_autoheight = true;
_showfilterrow = true;




urls = {
    saveurl: '/savecompetitieajax',
    getmasterurl: '/getcompetitiiajax',
    getdetailurl: '/getcompetitieajax',



};

listdatafields =
    [
        { name: 'CompetitionId', type: 'integer' },
        { name: 'Name', type: 'string' },
        { name: 'StartDate', type: 'string' },
        { name: 'EndDate', type: 'string' },
    ]

listdatacolumns =
    [
        { text: 'Competitie', datafield: 'Name', width: '70%' },
        { text: 'CompetitionId', datafield: 'CompetitionId', hidden: true },
        { text: 'StartDate', datafield: 'StartDate', width: '15%' },
        { text: 'EndDate', datafield: 'EndDate', width: '15%' },
    ]





