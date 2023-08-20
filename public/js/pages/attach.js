
let todelete;


$(function () {
    $('#checkall').change(function () {
        $(".checkpic").prop("checked", this.checked);
    });

    $('#btnStergeSelectate').on('click', (e) => {

        todelete = $('.checkpic:checked');
        if (todelete.length == 0) {
            ShowError('Nu ati selectat nici un atasament');
            return
        }
        confirm(`Doriti sa stergeti atasamentele selectate? ( ${todelete.length} )`, stergeSelectate)
    }
    );




});


$(function () {

    $("#ModificaNume").on("submit", function (event) {
        event.preventDefault();
        confirm(translate("Doriti sa salvati denumirile?"), modificaNume);
    });
});


function modificaNume() {
    data = {};
    let tab_attribs = $('.attachments').map(function () {
        return { id: $(this).attr("data-id"), name: $(this).val() }
    }).toArray();

    data['toModify'] = tab_attribs;

    $.ajax({
        type: 'POST',

        url: baseUrl + '/attachModify',
        data: data,
        success: function (data) {
            ShowSuccess(translate('S-au modificat cu succes!'));
            location.reload();


        },
        error: function (error) {
            ShowError(error.responseJSON.message);
        }
    });


}

function stergeSelectate() {
    data = {};
    let tab_attribs = $('.checkpic:checked').map(function () {
        return $(this).attr("data-filename");
    }).toArray();

    let tab_ids = $('.checkpic:checked').map(function () {
        return $(this).attr("data-id");
    }).toArray();




    data['toDelete'] = tab_attribs;
    data["toDeleteIds"] = tab_ids;
    $.ajax({
        type: 'POST',

        url: baseUrl + '/attachDelete',
        data: data,
        success: function (data) {
            ShowSuccess(translate('S-au sters cu succes!'));
            location.reload();


        },
        error: function (error) {
            ShowError(error.responseJSON.message);
        }
    });
}


$('#uploadform').on('submit', function (e) {

    e.preventDefault();
    if ($('#file')[0].files.length == 0) {
        ShowError('Nu ati ales nici un atasament')
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
        error: function (xhr, status, error) {
            if (status === "timeout") {
                ShowError(msg_timeout);
            } else {
                ShowError(error.responseJSON.message);
            }
        },
        success: function (response) {
            ShowSuccess(translate('S-au incarcat atasamentele cu succes!'));
            location.reload();
        },

    });
});