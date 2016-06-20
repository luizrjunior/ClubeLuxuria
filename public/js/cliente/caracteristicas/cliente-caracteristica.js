function selecionarCaracteristicasCliente(idCliente) {
    $('#carregando').show();
    $("#tituloCaracteristicasCliente").html('Características - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
    $("#idClienteCaracteristica").val(idCliente);
    carregarCaracteristicasCliente(idCliente, 1);//CARTÕES
    carregarCaracteristicasCliente(idCliente, 2);//SERVIÇO
    carregarCaracteristicasCliente(idCliente, 3);//ATENDIMENTO
    setTimeout(function(){ $('#carregando').hide(); }, 1800);
}

function carregarCaracteristicasCliente(idCliente, tpCaracteristica) {
    var dsTipoCaracteristica;
    var divCaracteristica;
    var options = '';
    var url = top.basePath + '/cliente/cliente-caracteristica/carregar-caracteristicas';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCliente: idCliente,
            tpCaracteristica: tpCaracteristica
        },
        dataType: "json",
        success: function(data) {
            switch (tpCaracteristica) {
                case  1:
                    dsTipoCaracteristica = 'caracteristicaCartoes';
                    divCaracteristica = '#CaracteristicaCartoes';
                    break;
                case  2:
                    dsTipoCaracteristica = 'caracteristicaServico';
                    divCaracteristica = '#CaracteristicaServico';
                    break;
                case  3:
                    dsTipoCaracteristica = 'caracteristicaAtendimento';
                    divCaracteristica = '#CaracteristicaAtendimento';
                    break;
            }
            $.each(data, function(key, value) {
                options += '<label class="checkbox"><input type="checkbox" value="' + key + '" name="' + dsTipoCaracteristica + '[]" ' + value.stChecked + '><i></i>' + value.dsCaracteristicaServico + '</label>';
            });
            $(divCaracteristica).html(options);
        }
    });
}

function salvarCaracteristicasCliente() {
    $('#carregando').show();
    var postData = $('#formCadClienteCaracteristica').serializeArray();
    var formURL = top.basePath + '/cliente/cliente-caracteristica/salvar';
    $.ajax({
        type: "POST",
        url: formURL,
        data: postData,
        dataType: "json",
        success: function(data) {
            $('#carregando').hide();
            if (data.tipoMsg === "S") {
                selecionarCaracteristicasCliente(data.idCliente);
            }
            Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
        }
    });
}

$(document).ready(function () {
    $('#btnGravarClienteCaracteristica').on('click', function () {
        salvarCaracteristicasCliente();
    });
});