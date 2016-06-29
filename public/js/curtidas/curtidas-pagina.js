/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function abrirDivCurtirPagina() {
    $('#divPaginaCurtida01').hide();
    $('#divCurtirPagina01').fadeIn("slow");
    top.idCurtidas = "";
}

function abrirDivDescurtirPagina(json) {
    $('#divCurtirPagina01').hide();
    $('#divPaginaCurtida01').fadeIn("slow");
    top.idCurtidas = json.idCurtidas;
}

function verificarCurtidas() {
    var url = top.basePath + '/curtidas/index/verificar-curtidas';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCliente: top.idCliente
        },
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                if (data.idCurtidas !== undefined) {
                    abrirDivDescurtirPagina(data);
                } else {
                    abrirDivCurtirPagina();
                }
            }
        }
    });
}

function curtirPagina() {
    var url = top.basePath + '/curtidas/index/curtir-pagina';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCliente: top.idCliente
        },
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                abrirDivDescurtirPagina(data);
                $('#spanVoce').html('Você e ');
            }
        }
    });
}

function descurtirPagina() {
    var url = top.basePath + '/curtidas/index/descurtir-pagina';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCurtidas: top.idCurtidas
        },
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                abrirDivCurtirPagina();
                $('#spanVoce').html('');
            }
        }
    });
}

$(document).ready(function () {

    $('#btnCurtirPagina01').on('click', function () {
        curtirPagina();
    });
    $('#btnCurtirLogado').on('click', function () {
        curtirPagina();
    });
    $('#btnDescurtirLogado').on('click', function () {
        descurtirPagina();
    });
    verificarCurtidas();

});