/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function carregarCurtidasFoto(idFoto) {
    $('#divModalBodyCurtidas').html("");
    var url = top.basePath + '/curtidas/index/carregar-curtidas-foto';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idFoto: idFoto
        },
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                var divCurtidas = "";
                $.each(data, function (key, value) {
                    if (value.noUsuario !== undefined) {
                        divCurtidas += '<div id="divCurtidaUsuario' + key + '" class="text-muted"><i class="fa fa-user"></i> ' + value.noUsuario + '</div>';
                    }
                });
                $('#divModalBodyCurtidas').html(divCurtidas);
            }
        }
    });
}

function curtirFoto(idFoto) {
    var url = top.basePath + '/curtidas/index/curtir-foto';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idFoto: idFoto
        },
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                $('#spanCurtirFotoMB' + idFoto).hide();
                $('#spanCurtirFotoMF' + idFoto).hide();
                $('#spanCurtirFotoES' + idFoto).hide();
                $('#spanCurtirFotoGF' + idFoto).hide();

                $('#spanVoceCurtiuFotoMB' + idFoto).show();
                $('#spanVoceCurtiuFotoMF' + idFoto).show();
                $('#spanVoceCurtiuFotoES' + idFoto).show();
                $('#spanVoceCurtiuFotoGF' + idFoto).show();

                $('#spanNuCurtidasFotoMB' + idFoto).html('0' + data.qtdeCurtidasFoto);
                $('#spanNuCurtidasFotoMF' + idFoto).html('0' + data.qtdeCurtidasFoto);
                $('#spanNuCurtidasFotoES' + idFoto).html('0' + data.qtdeCurtidasFoto);
                $('#spanNuCurtidasFotoGF' + idFoto).html('0' + data.qtdeCurtidasFoto);
                if (data.qtdeCurtidasFoto === 1) {
                    $('#spanDsCurtidasFotoMB' + idFoto).html('Pessoa');
                    $('#spanDsCurtidasFotoMF' + idFoto).html('Pessoa');
                    $('#spanDsCurtidasFotoES' + idFoto).html('Pessoa');
                    $('#spanDsCurtidasFotoGF' + idFoto).html('Pessoa');
                } else {
                    $('#spanDsCurtidasFotoMB' + idFoto).html('Pessoas');
                    $('#spanDsCurtidasFotoMF' + idFoto).html('Pessoas');
                    $('#spanDsCurtidasFotoES' + idFoto).html('Pessoas');
                    $('#spanDsCurtidasFotoGF' + idFoto).html('Pessoas');
                }
            }
        }
    });
}