function limparCamposConfigPaginaCliente(idCliente) {
    $("#idConfigPaginaCliente").val('');
    $("#idClienteConfigPaginaCliente").val(idCliente);
    
    var radiosStFrase1 = $('input:radio[name=stFrase1]');
    radiosStFrase1.filter('[value=1]').prop('checked', true);
    
    var radiosStFrase2 = $('input:radio[name=stFrase2]');
    radiosStFrase2.filter('[value=1]').prop('checked', true);
    
    var radiosStFrase3 = $('input:radio[name=stFrase3]');
    radiosStFrase3.filter('[value=1]').prop('checked', true);
    
    var radiosStServico = $('input:radio[name=stServico]');
    radiosStServico.filter('[value=1]').prop('checked', true);
    
    var radiosStAtendimento = $('input:radio[name=stAtendimento]');
    radiosStAtendimento.filter('[value=1]').prop('checked', true);
    
    var radiosStCartoes = $('input:radio[name=stCartoes]');
    radiosStCartoes.filter('[value=1]').prop('checked', true);
    
    var radiosStUrlSite = $('input:radio[name=stUrlSite]');
    radiosStUrlSite.filter('[value=1]').prop('checked', true);
    
    var radiosStInfoCliente = $('input:radio[name=stInfoCliente]');
    radiosStInfoCliente.filter('[value=1]').prop('checked', true);
    
    var radiosStDepoimentos = $('input:radio[name=stDepoimentos]');
    radiosStDepoimentos.filter('[value=1]').prop('checked', true);
    
    var radiosStCaches = $('input:radio[name=stCaches]');
    radiosStCaches.filter('[value=1]').prop('checked', true);
    
    var radiosStVideos = $('input:radio[name=stVideos]');
    radiosStVideos.filter('[value=1]').prop('checked', true);
    
    var radiosStRota = $('input:radio[name=stRota]');
    radiosStRota.filter('[value=1]').prop('checked', true);
    
}

function carregarCamposConfigPaginaCliente(json) {
    $("#idConfigPaginaCliente").val(json.idConfigPaginaCliente);
    $("#idClienteConfigPaginaCliente").val(json.idClienteConfigPaginaCliente);
    
    var radiosStFrase1 = $('input:radio[name=stFrase1]');
    radiosStFrase1.filter('[value=' + json.stFrase1 + ']').prop('checked', true);
    
    var radiosStFrase2 = $('input:radio[name=stFrase2]');
    radiosStFrase2.filter('[value=' + json.stFrase2 + ']').prop('checked', true);
    
    var radiosStFrase3 = $('input:radio[name=stFrase3]');
    radiosStFrase3.filter('[value=' + json.stFrase3 + ']').prop('checked', true);
    
    var radiosStServico = $('input:radio[name=stServico]');
    radiosStServico.filter('[value=' + json.stServico + ']').prop('checked', true);
    
    var radiosStAtendimento = $('input:radio[name=stAtendimento]');
    radiosStAtendimento.filter('[value=' + json.stAtendimento + ']').prop('checked', true);
    
    var radiosStCartoes = $('input:radio[name=stCartoes]');
    radiosStCartoes.filter('[value=' + json.stCartoes + ']').prop('checked', true);
    
    var radiosStUrlSite = $('input:radio[name=stUrlSite]');
    radiosStUrlSite.filter('[value=' + json.stUrlSite + ']').prop('checked', true);
    
    var radiosStInfoCliente = $('input:radio[name=stInfoCliente]');
    radiosStInfoCliente.filter('[value=' + json.stInfoCliente + ']').prop('checked', true);
    
    var radiosStDepoimentos = $('input:radio[name=stDepoimentos]');
    radiosStDepoimentos.filter('[value=' + json.stDepoimentos + ']').prop('checked', true);
    
    var radiosStCaches = $('input:radio[name=stCaches]');
    radiosStCaches.filter('[value=' + json.stCaches + ']').prop('checked', true);
    
    var radiosStVideos = $('input:radio[name=stVideos]');
    radiosStVideos.filter('[value=' + json.stVideos + ']').prop('checked', true);
    
    var radiosStRota = $('input:radio[name=stRota]');
    radiosStRota.filter('[value=' + json.stRota + ']').prop('checked', true);
}

function selecionarConfigPaginaCliente(idCliente) {
    $('#carregando').show();
    $("#tituloConfigPaginaCliente").html('Configurações da Página - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
    var url = top.basePath + '/config-pagina-cliente/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCliente: idCliente
        },
        dataType: "json",
        success: function(data) {
            limparCamposConfigPaginaCliente(idCliente);
            if (data.tipoMsg === "S") {
                carregarCamposConfigPaginaCliente(data);
            }
            $('#carregando').hide();
        }
    });
}

function salvarConfigPaginaCliente() {
    $('#carregando').show();
    var postData = $('#formCadConfigPaginaCliente').serializeArray();
    var formURL = top.basePath + '/config-pagina-cliente/index/salvar';
    $.ajax({
        type: "POST",
        url: formURL,
        data: postData,
        dataType: "json",
        success: function(data) {
            $('#carregando').hide();
            if (data.tipoMsg === "S") {
                selecionarConfigPaginaCliente(data.idCliente);
            }
            Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
        }
    });
}

$(document).ready(function () {
    $('#btnGravarConfigPaginaCliente').on('click', function () {
        salvarConfigPaginaCliente();
    });
});