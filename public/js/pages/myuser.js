
 urls.saveurl ='/savemyuser';

 var MasterPrimaryKey = "PersonId";

 function ValidatePasswords(){
    let Valid = true;

    Valid = $('#Password').val() === $('#Password2').val()

    if (!Valid)
        ShowError('Introduceti de doua ori aceiasi parola!');

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
                ShowSuccess('S-a modificat parola cu succes');
               
            },
            error: function(data){
                ShowError(data)
            }
        });
    });
});