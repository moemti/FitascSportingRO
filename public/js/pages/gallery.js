



let todelete;


$(function () {
    $('#checkall').change(function() {			
        $( ".checkpic" ).prop( "checked", this.checked );			
    });

    $('#btnStergeSelectate').on('click', (e)=>{
                  
            todelete = $('.checkpic:checked');
            if (todelete.length == 0){
                ShowError('Nu ati selectat nici o imagine');
                return
            }

            confirm(`Doriti sa stergeti imaginile selectate? ( ${todelete.length} )`, stergeSelectate)
        }
    );


});

function stergeSelectate(){
    data = {};
    let tab_attribs = $('.checkpic:checked').map(function () {
        return $(this).attr("data-image");
      }).toArray();


    data['toDelete'] = tab_attribs; 
    $.ajax({
        type: 'POST',

        url: baseUrl + '/galleryDelete',
        data: data,
        success: function (data) {
            ShowSuccess(translate('S-au sters cu succes!'));
            location.reload();
            

        },
        error: function (error){
            ShowError(error.responseJSON.message);
        }
    });
}


$('#uploadform').on('submit', function(e) {

    e.preventDefault();
    if ($('#file')[0].files.length == 0){
        ShowError('Nu ati ales nici o imagine')
        return;
    }
 
    var formData = new FormData($(this)[0]);
    var msg_error = 'An error has occured. Please try again later.';
    var msg_timeout = 'The server is not responding';
    var message = '';
    var form = $('#uploadform');


    $.ajax({
        data: formData,
        async: false,
        cache: false,
        processData: false,
        contentType: false,
        url: form.attr('action'),
        type: form.attr('method'),
        error: function(xhr, status, error) {
            if (status==="timeout") {
                ShowError(msg_timeout);
            } else {
                ShowError(error.responseJSON.message);
            }
        },
        success: function(response) {
            ShowSuccess(translate('S-au incarcat imaginile cu succes!'));
            location.reload();
        },
  
    });
   });