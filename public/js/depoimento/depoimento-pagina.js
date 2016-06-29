/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function validarCamposDepoimento() {
    var chk = true;
    var texto = "<ul>";
    if ($("#dsDepoimento").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Depoimento\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    } else {
        var dsDepoimento = $("#dsDepoimento").val();
        var n = dsDepoimento.length;
        if (n < 75) {
            texto += "<li><font color='#000000'>O Texto digitado deve ter o mínimo de 75 e o máximo de 125 caracteres.</font></li>";
            chk = false;
        }
    }
    texto += "</ul>";
    if (chk === false) {
        Componentes.modalAlerta(texto, null);
        return chk;
    } else {
        return chk;
    }
}

function registrarDepoimento() {
    if (validarCamposDepoimento()) {
        var dsDepoimento = $('#dsDepoimento').val();
        var url = top.basePath + '/depoimento/index/registrar-depoimento';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                idCliente: top.idCliente ,
                        dsDepoimento: dsDepoimento,
                stDepoimento: 1//AGUARDANDO ANALISE
            },
            dataType: "json",
            success: function (data) {
                Componentes.modalAlerta(data.textoMsg, null);
            }
        });
    }
}

$(document).ready(function () {
    $('#btnEnviarDepoimento').on('click', function () {
        registrarDepoimento();
    });
});