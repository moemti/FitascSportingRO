
function stergeCererea() {
    form = $('#registerform');
    form.action = "deletecerere";
    form.submit();
}
function aprobaCererea() {
    form = $('#registerform');
    form.action = "finishuser";
    form.submit();
}


$(function () {
    $("#sterge").on("click", stergeCererea);
    $("#aproba").on("click", aprobaCererea);

    });
