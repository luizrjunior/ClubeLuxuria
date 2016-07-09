function limparCamposAlterarSenha() {
    $("#senhaAtual").val('');
    $("#senha").val('');
    $("#senhaConfirm").val('');
}

function validarCamposAlterarSenha() {
    var chk = true;
    var texto = "<ul>";
    
    if ($("#senhaAtual").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Senha Atual\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#senhaNova").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Nova Senha\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#senhaConfirm").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Confirmar Nova Senha\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#senhaNova").val() !== "" && $("#senhaConfirm").val() !== "") {
        if ($("#senhaNova").val() !== $("#senhaConfirm").val()) {
            texto += "<li><font color='#000000'>O campo <strong>\"Confirmar Nova Senha\"</strong> diferente do campo <strong>\"Nova Senha\"</strong>.</font></li>";
            chk = false;
        }
    }

    texto += "</ul>";

    if (chk === false) {
        Componentes.modalAlerta(formataTextMsg(texto), null);
        return chk;
    } else {
        return chk;
    }
}

//Função para cadastrar ou alterar dados do usuário.
function alterarSenha() {
    if (validarCamposAlterarSenha()) {
        var postData = $('#formAlterarSenha').serializeArray();
        var formURL = $('#formAlterarSenha').attr("action");
        //AJAX
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function(data) {
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                if (data.tipoMsg === "S") {
                    limparCamposAlterarSenha();
                }
            }
        });
    }
}

$(document).ready(function () {
    $('#btnAlterarSenha').on('click', function () {
        alterarSenha();
    });
    limparCamposAlterarSenha();
});