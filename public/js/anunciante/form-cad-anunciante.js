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

    $("#dsIdade").val('');
    $("#dsApelido").val('');

    $("#dsCabelos").val('');
    $("#dsOlhos").val('');

    $("#dsLabios").val('');
    $("#dsAltura").val('');

    $("#dsPeso").val('');
    $("#dsBusto").val('');

    $("#dsCintura").val('');
    $("#dsQuadril").val('');
    
    $("#dsHobby").val('');
    $("#dsComidas").val('');

    $("#dsBebidas").val('');
    $("#dsFrase").val('');

    $("#dsFrase1").val('');
    $("#dsFrase2").val('');
    $("#dsFrase3").val('');
    
    $("#dsUrlSite").val('');
    
    if (top.idClientePerfil !== undefined) {
        $("#dsBusto").prop('disabled', true);
        $("#dsCintura").prop('disabled', true);
        $("#dsQuadril").prop('disabled', true);
    }
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
    top.idCidade = json.idCidade;
    carregarCidadesAnunciante(json.sgUf);
    
    var radiosTpCabeloCor = $('input:radio[name=tpCabeloCor]');
    radiosTpCabeloCor.filter('[value=' + json.tpCabeloCor + ']').prop('checked', true);

    var radiosStAceitaCartao = $('input:radio[name=stAceitaCartao]');
    radiosStAceitaCartao.filter('[value=' + json.stAceitaCartao + ']').prop('checked', true);

    $("#nuLatitude").val(json.nuLatitude);
    $("#nuLongitude").val(json.nuLongitude);

    $("#dsIdade").val(json.dsIdade);
    $("#dsApelido").val(json.dsApelido);

    $("#dsCabelos").val(json.dsCabelos);
    $("#dsOlhos").val(json.dsOlhos);

    $("#dsLabios").val(json.dsLabios);
    $("#dsAltura").val(json.dsAltura);

    $("#dsPeso").val(json.dsPeso);
    $("#dsBusto").val(json.dsBusto);

    $("#dsCintura").val(json.dsCintura);
    $("#dsQuadril").val(json.dsQuadril);

    $("#dsHobby").val(json.dsHobby);
    $("#dsComidas").val(json.dsComidas);

    $("#dsBebidas").val(json.dsBebidas);
    $("#dsFrase").val(json.dsFrase);

    $("#dsFrase1").val(json.dsFrase1);
    $("#dsFrase2").val(json.dsFrase2);
    $("#dsFrase3").val(json.dsFrase3);
    
    $("#dsUrlSite").val(json.dsUrlSite);
    
    if (top.idClientePerfil !== undefined) {
        $("#tpAnunciante").prop('disabled', true);
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

function carregarCidadesAnunciante(sgUf) {
    var selectCidade = '#idCidadeAnunciante';
    var options = '<option value=""> -- Selecione --</option>';
    var url = top.basePath + '/cliente/index/carregar-select-cidades';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            sgUf: sgUf
        },
        dataType: "json",
        success: function(data) {
            $.each(data, function(key, value) {
                options += '<option ' + (top.idCidade == key ? 'selected="selected"' : '') + ' value="' + key + '">' + value + '</option>';
            });
            $(selectCidade).html(options);
        }
    });
}

$(document).ready(function () {

    $('#sgUfAnunciante').on('change', function () {
        carregarCidadesAnunciante($("#sgUfAnunciante").val());
    });
    
    $('#btnGravarAnunciante').on('click', function () {
        salvarAnunciante();
    });
});