function limparCamposContato() {
    $("#nome").val('');
    $("#email").val('');
    $("#assunto").val('');
    $("#mensagem").val('');
}

function validarCamposContato() {
    var chk = true;
    var texto = "<ul>";
    
    if ($("#nome").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Nome\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#email").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Email\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#assunto").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Assunto\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#mensagem").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Mensagem\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }
    texto += "</ul>";

    if (chk === false) {
        Componentes.modalAlerta(formataTextMsg(texto), null);
        return chk;
    } else {
        return chk;
    }
}

function enviarContato() {
    if (validarCamposContato()) {
        var postData = $('#formCad').serializeArray();
        var formURL = top.basePath + '/contato/salvar';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function(data) {
                if (data.tipoMsg === "S") {
                    Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                    limparCamposContato();
                }
            }
        });
    }
}

$(function(){
    $('#home').removeClass('active');
    $('#diarios').removeClass('active');
    $('#rotas').removeClass('active');
    $('#anuncie').removeClass('active');
    $('#cadastrese').removeClass('active');
    $('#contato').addClass('active');
    $('#areaRestrita').removeClass('active');

    $('#btnEnviarContato').on('click', function () {
       enviarContato();
    });
});