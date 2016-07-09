function limparCamposConfigPaginaPerfil(idUsuario) {
    $("#idConfigPaginaPerfil").val('');
    $("#idUsuarioConfigPaginaPerfil").val(idUsuario);
    
    var radiosStBannerPrincipal = $('input:radio[name=stBannerPrincipal]');
    radiosStBannerPrincipal.filter('[value=1]').prop('checked', true);
    
    var radiosStInfoUsuario = $('input:radio[name=stInfoUsuario]');
    radiosStInfoUsuario.filter('[value=1]').prop('checked', true);
    
    var radiosStMinhasFavoritas = $('input:radio[name=stMinhasFavoritas]');
    radiosStMinhasFavoritas.filter('[value=1]').prop('checked', true);
    
    var radiosStDestaques = $('input:radio[name=stDestaques]');
    radiosStDestaques.filter('[value=1]').prop('checked', true);
    
    var radiosTpPlanoFundo = $('input:radio[name=tpPlanoFundo]');
    radiosTpPlanoFundo.filter('[value=1]').prop('checked', true);
    
}

function carregarCamposConfigPaginaPerfil(json) {
    $("#idConfigPaginaPerfil").val(json.idConfigPaginaPerfil);
    $("#idUsuarioConfigPaginaPerfil").val(json.idUsuarioConfigPaginaPerfil);
    
    var radiosStBannerPrincipal = $('input:radio[name=stBannerPrincipal]');
    radiosStBannerPrincipal.filter('[value=' + json.stBannerPrincipal + ']').prop('checked', true);
    
    var radiosStInfoUsuario = $('input:radio[name=stInfoUsuario]');
    radiosStInfoUsuario.filter('[value=' + json.stInfoUsuario + ']').prop('checked', true);
    
    var radiosStMinhasFavoritas = $('input:radio[name=stMinhasFavoritas]');
    radiosStMinhasFavoritas.filter('[value=' + json.stMinhasFavoritas + ']').prop('checked', true);
    
    var radiosStDestaques = $('input:radio[name=stDestaques]');
    radiosStDestaques.filter('[value=' + json.stDestaques + ']').prop('checked', true);
    
    var radiosTpPlanoFundo = $('input:radio[name=tpPlanoFundo]');
    radiosTpPlanoFundo.filter('[value=' + json.tpPlanoFundo + ']').prop('checked', true);
}

function selecionarConfigPaginaPerfil(idUsuario) {
    $('#carregando').show();
    $("#tituloConfigPaginaPerfil").html('Configurações do Perfil');
    var url = top.basePath + '/config-pagina-perfil/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idUsuario: idUsuario
        },
        dataType: "json",
        success: function(data) {
            limparCamposConfigPaginaPerfil(idUsuario);
            if (data.tipoMsg === "S") {
                carregarCamposConfigPaginaPerfil(data);
            }
            $('#carregando').hide();
        }
    });
}

function salvarConfigPaginaPerfil() {
    $('#carregando').show();
    var postData = $('#formCadConfigPaginaPerfil').serializeArray();
    var formURL = top.basePath + '/config-pagina-perfil/index/salvar';
    $.ajax({
        type: "POST",
        url: formURL,
        data: postData,
        dataType: "json",
        success: function(data) {
            $('#carregando').hide();
            if (data.tipoMsg === "S") {
                selecionarConfigPaginaPerfil(data.idUsuario);
            }
            Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            location.href = top.basePath + '/perfil';
        }
    });
}

$(document).ready(function () {
    $('#btnGravarConfigPaginaPerfil').on('click', function () {
        salvarConfigPaginaPerfil();
    });
});