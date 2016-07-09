function limparCamposAnunciante(idCliente) {
    $("#idAnunciante").val('');
    $("#idClienteAnunciante").val(idCliente);
    
    $("#tpAnunciante").val('1');
    $("#stAnunciante").val('1');
    
    $("#noArtistico").val('');
    $("#nuTelefoneAnunciante").val('');
    $("#dsEnderecoAnunciante").val('');
    $("#sgUfAnunciante").val('');
    $("#idCidadeAnunciante").val('');
    
    $('input[name="tpCabeloCor"]').prop('checked', false);
    $('input[name="stAceitaCartao"]').prop('checked', false);
    
    $("#nuLatitude").val('');
    $("#nuLongitude").val('');

    $("#dsFrase1").val('');
    $("#dsFrase2").val('');
    $("#dsFrase3").val('');
    
    $("#dsUrlSite").val('');
}

function carregarCamposAnunciante(json) {
    $("#idAnunciante").val(json.idAnunciante);
    $("#idClienteAnunciante").val(json.idClienteAnunciante);
    
    $("#tpAnunciante").val(json.tpAnunciante);
    $("#stAnunciante").val(json.stAnunciante);
    
    $("#noArtistico").val(json.noArtistico);
    $("#nuTelefoneAnunciante").val(json.nuTelefone);
    $("#dsEnderecoAnunciante").val(json.dsEndereco);
    $("#sgUfAnunciante").val(json.sgUf);
    $("#idCidadeAnunciante").val(json.idCidade);
    
    var radiosTpCabeloCor = $('input:radio[name=tpCabeloCor]');
    radiosTpCabeloCor.filter('[value=' + json.tpCabeloCor + ']').prop('checked', true);

    var radiosStAceitaCartao = $('input:radio[name=stAceitaCartao]');
    radiosStAceitaCartao.filter('[value=' + json.stAceitaCartao + ']').prop('checked', true);

    $("#nuLatitude").val(json.nuLatitude);
    $("#nuLongitude").val(json.nuLongitude);

    $("#dsFrase1").val(json.dsFrase1);
    $("#dsFrase2").val(json.dsFrase2);
    $("#dsFrase3").val(json.dsFrase3);
    
    $("#dsUrlSite").val(json.dsUrlSite);
    
    if (top.idClientePerfil !== undefined) {
        $("#tpAnunciante").prop('disabled', true);
        $('input[name="stDestaque"]').prop('disabled', true);
        $("#dtInicioDestaque").prop('disabled', true);
        $("#dtFimDestaque").prop('disabled', true);
    }
}

function selecionarAnuncianteCliente(idCliente) {
    $('#carregando').show();
    $("#tituloAnunciante").html('Dados de Anunciante - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
    var url = top.basePath + '/anunciante/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCliente: idCliente
        },
        dataType: "json",
        success: function(data) {
            limparCamposAnunciante(idCliente);
            if (data.tipoMsg === "S") {
                carregarCamposAnunciante(data);
            }
            $('#carregando').hide();
        }
    });
}

function validarCamposAnunciante() {
    var chk = true;
    var texto = "<ul>";
    
    if ($("#noArtistico").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Nome Artístico\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#nuTelefoneAnunciante").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Telefone\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if (!$("input[name='tpCabeloCor']").is(":checked")) {
        texto += "<li><font color='#000000'>O campo <strong>\"Cabelo/Cor\"</strong> é de preenchimento obrigatório.</font></li>";
        chk = false;
    }

    if (!$("input[name='stAceitaCartao']").is(":checked")) {
        texto += "<li><font color='#000000'>O campo <strong>\"Aceita Cartão\"</strong> é de preenchimento obrigatório.</font></li>";
        chk = false;
    }
        
    if ($("#sgUfAnunciante").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"UF\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#idCidadeAnunciante").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Cidade\"</strong> é de seleção obrigatória.</font></li>";
        chk = false;
    }

    texto += "</ul>";

    if (chk === false) {
        Componentes.modalAlerta(texto, null);
        return chk;
    } else {
        if (top.idClientePerfil !== undefined) {
            $("#tpAnunciante").prop('disabled', false);
        }
        return chk;
    }
}

function salvarAnunciante() {
    if (validarCamposAnunciante()) {
        $('#carregando').show();
        var postData = $('#formCadAnunciante').serializeArray();
        var formURL = top.basePath + '/anunciante/index/salvar';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function(data) {
                $('#carregando').hide();
                if (data.tipoMsg === "S") {
                    selecionarAnuncianteCliente(data.idCliente);
                }
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        });
    }
}

$(document).ready(function () {
    $('#btnGravarAnunciante').on('click', function () {
        salvarAnunciante();
    });
});