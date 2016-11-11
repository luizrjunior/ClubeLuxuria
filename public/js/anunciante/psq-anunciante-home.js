var DadosEtapas = {
    paginaAtual: null
};

function listarAnuncianteHome() {
    Componentes.paginacaoGeral({
        div: 'tableAnuncianteHome',
        url: top.basePath + '/anunciante/index/pesquisar-anunciante-home',
        botaoBusca: 'btnPesquisarAnuncianteHome',
        form: 'formPsqAnuncianteHome',
        paginaAtual: DadosEtapas.pagina
    });
}

function carregarCidadesAnunciante(sgUf) {
    var selectCidade = '#idCidadePsq';
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
    $('#sgUfPsq').on('change', function () {
        carregarCidadesAnunciante($("#sgUfPsq").val());
        listarAnuncianteHome();
    });
    
    $('#idCidadePsq').on('change', function () {
        listarAnuncianteHome();
    });
    
    listarAnuncianteHome();
    carregarCidadesAnunciante($("#sgUfPsq").val());
});