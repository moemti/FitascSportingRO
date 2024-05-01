
 urls.saveurl ='/savemyuser';

 var MasterPrimaryKey = "PersonId";

 function ValidatePasswords(){
    let Valid = true;

    Valid = $('#Password').val() === $('#Password2').val()

    if (!Valid)
        ShowError(translate('Introduceti de doua ori aceiasi parola!'));

    return Valid;
}



$(function () {

    $( "#changemypassword" ).submit(function( event ) {
        event.preventDefault();
        if (!ValidatePasswords())
            return;
        let Data ={}

        $("#changemypassword :input").each(function(){
            let val;
            val =  $(this).val();
            Data[$(this).attr('id')] = val;
        });

        $.ajax({
            type: 'POST',
    
            url: baseUrl + '/changemypassword',
            data: Data,
            success: function (data) {
                ShowSuccess(translate('S-a modificat parola cu succes'));
               
            },
            error: function(data){
                ShowError(data)
            }
        });
    });

    $("#deleteUser").on("click", (e) => {
        confirm(`Doriti sa stergeti datele si contul personal? Numele si istoricul participarilor se vor pastra.`, deleteUser)

    });


    function deleteUser() {
        data = {};

        data['PersonId'] = $('#PersonId').val();

        $.ajax({
            type: 'POST',

            url: baseUrl + '/deletemyuser',
            data: data,
            success: function (data) {
                ShowSuccess(translate('S-au sters datele personale cu succes!'));
                location.reload();

            },
            error: function (error) {
                ShowError(error.responseJSON.message);
            }
        });
    }


});