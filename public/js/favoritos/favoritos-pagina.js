/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function abrirDivAdicionarFavoritos() {
    $('#divRemoverFavoritos').hide();
    $('#btnRemoverFavoritos').hide();
    $('#btnRemoverFavoritos01').hide();

    $('#divAdicionarFavoritos').fadeIn("slow");
    $('#btnAdicionarFavoritos').fadeIn("slow");
    $('#btnAdicionarFavoritos01').fadeIn("slow");

    $('#chckBxStNtfcc').attr("checked", true);

    top.idFavoritos = "";
    top.stNotificacao = "";
}

function abrirDivRemoverFavoritos(json) {
    $('#divAdicionarFavoritos').hide();
    $('#btnAdicionarFavoritos').hide();
    $('#btnAdicionarFavoritos01').hide();

    $('#divRemoverFavoritos').fadeIn("slow");
    $('#btnRemoverFavoritos').fadeIn("slow");
    $('#btnRemoverFavoritos01').fadeIn("slow");

    if (json.stNotificacao === 1) {
        $('#chckBxStNtfcc').attr("checked", true);
    } else {
        $('#chckBxStNtfcc').attr("checked", false);
    }

    top.idFavoritos = json.idFavoritos;
    top.stNotificacao = json.stNotificacao;
}

function verificarFavoritos() {
    var url = top.basePath + '/favoritos/index/verificar-favoritos';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idAnunciante: top.idAnunciante
        },
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                if (data.idFavoritos !== undefined) {
                    abrirDivRemoverFavoritos(data);
                } else {
                    abrirDivAdicionarFavoritos();
                }
            }
        }
    });
}

function adicionarFavoritos() {
    var url = top.basePath + '/favoritos/index/adicionar-favoritos';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idAnunciante: top.idAnunciante
        },
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                abrirDivRemoverFavoritos(data);
            }
        }
    });
}

function removerFavoritos() {
    var url = top.basePath + '/favoritos/index/remover-favoritos';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idFavoritos: top.idFavoritos
        },
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                abrirDivAdicionarFavoritos();
            }
        }
    });
}

function alterarNotificacao() {
    var url = top.basePath + '/favoritos/index/alterar-notificacao';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idFavoritos: top.idFavoritos,
            stNotificacao: top.stNotificacao,
            idAnunciante: top.idAnunciante
        },
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                verificarFavoritos();
            }
        }
    });
}
$(document).ready(function () {
    $('#btnDcnrFvrtsLgd').on('click', function () {
        adicionarFavoritos();
    });

    $('#btnDcnrFvrtsLgd01').on('click', function () {
        adicionarFavoritos();
    });

    $('#chckBxStNtfcc').on('click', function () {
        alterarNotificacao();
    });

    $('#btnRmvrFvrtsLgd').on('click', function () {
        removerFavoritos();
    });

    verificarFavoritos();
});