
let lastCompetitionId = 0;
function registerMe(compId){
          
    lastCompetitionId = compId; 
    confirm('Doriti sa va inregistrati?', registerMeDo);
}

function registerMeDo(){
    let Data = {};
    Data.CompetitionId = lastCompetitionId;
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


$(function () {



   
  //  $("#btnRegister").on('click', registerMe);
  
})