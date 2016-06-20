var DadosEtapas = {
    paginaAtual: null
};

function limparCamposBanner() {
    $("#idBanner").val('');
    $("#idCliente").val('');
    $("#tpBanner").val('');
    $("#dtInicio").val('');
    $("#dtFim").val('');
    $("#dsBanner").val('');
    $("#tituloBanner").html('Adicionar Banner');
    $("#uploadsBanner").html("");
    alterarTipoBanner();
}

function carregarCamposBanner(json) {
    top.idCliente = json.idCliente;
    $("#idBanner").val(json.idBanner);
    $("#idCliente").val(json.idCliente);
    $("#tpBanner").val(json.tpBanner);
    $("#dtInicio").val(json.dtInicio);
    $("#dtFim").val(json.dtFim);
    $("#dsBanner").val(json.dsBanner);
    $("#tituloBanner").html('Editar Banner');
    alterarTipoBanner();
    verificarArquivosBannerCliente();
}

function selecionarBanner(idBanner) {
    var url = top.basePath + '/banner/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idBanner: idBanner
        },
        dataType: "json",
        success: function (data) {
            limparCamposBanner();
            abrirTelaCadastroBanner();
            if (data.tipoMsg === "S") {
                carregarCamposBanner(data);
            }
        }
    });
}

function visualizarBanner(idBanner) {
    window.open('../banner/index/visualizar-banner/id/' + idBanner, '_blank');
}

function validarCamposBanner() {
    var chk = true;
    var texto = "<ul>";

    if ($("#tpBanner").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Tipo de Banner\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }
    if ($("#dtInicio").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Data Início\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }
    if ($("#dtFim").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Data Fim\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }
    if ($("#tpBanner").val() === "1") {
        if ($("#dsBanner").val() === "") {
            texto += "<li><font color='#000000'>O campo <strong>\"Banner\"</strong> é de preechimento obrigatório.</font></li>";
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

function salvarBanner() {
    if (validarCamposBanner()) {
        var postData = $('#formCadBanner').serializeArray();
        var formURL = top.basePath + '/banner/index/salvar';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                if (data.tipoMsg === "S") {
                    selecionarBanner(data.idBanner);
                    clicarPesquisarNovamenteBanner();
                }
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        });
    }
}

function confirmarExcluirBanner(idBanner) {
    top.idBanner = idBanner;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse Banner?', excluirBanner, null);
}

function excluirBanner() {
    var formURL = top.basePath + '/banner/index/excluir';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {idBanner: top.idBanner},
        dataType: "json",
        success: function (data) {
            $('#modalConfirmacao').modal('hide');
            clicarPesquisarNovamenteBanner();
            top.idBanner = null;
            Componentes.modalAlerta(data.textoMsg, null);
        }
    });
}

function abrirTelaPesquisaBanner() {
    $("#cadBanner").hide();
    $("#psqBanner").fadeIn("slow");
}

function abrirTelaCadastroBanner() {
    $("#psqBanner").hide();
    $("#cadBanner").fadeIn("slow");
}

function clicarPesquisarNovamenteBanner() {
    var pagina = $('#tableBanners').find('.active');
    Componentes.paginacaoGeral({
        div: 'tableBanners', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/banner/index/pesquisar-banner', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarBanner',
        form: 'formPsqBanner',
        paginaAtual: pagina.attr('page'),
        executarOnReady: false
    });
}

function listarBanners() {
    Componentes.paginacaoGeral({
        div: 'tableBanners', //id da div onde sera reenderizada a tabela
        url: top.basePath + '/banner/index/pesquisar-banner', //url que sera usada para a pesquisa
        botaoBusca: 'btnPesquisarBanner',
        form: 'formPsqBanner',
        paginaAtual: DadosEtapas.pagina
    });
}

function carregarComboClienteBanner() {
    $.ajax({
        type: "POST",
        url: top.basePath + "/cliente/index/carregar-select-cliente",
        dataType: "json",
        success: function (data) {
            var optionsCliente = "";
            $.each(data, function (key, value) {//percorro o array de etapas e confiro se o id da etapa == ao id da ultima etapa inserida e seto
                optionsCliente += '<option ' + (top.idCliente == key ? 'selected="selected"' : '') + ' value="' + key + '">' + value + '</option>';
            });
            $("#idCliente").html('<option value=""> - - Nenhum Cliente - - </option>' + optionsCliente);
        }
    });
}

function abrirArquivoBanner(arquivo) {
    window.open('../storage/banners/' + top.idCliente + "/" + arquivo, '_blank');
}

function confirmarRemoverArquivoBanner(name) {
    top.nameFile = name;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerBanner, null);
}

function removerBanner() {
    var formURL = top.basePath + "/banner/index/remover-arquivo";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {nameFile: top.nameFile},
        dataType: "json",
        success: function (data) {
            var nameDiv = top.nameFile.split(".");
            $('#' + nameDiv).remove();
            $('#modalConfirmacao').modal('hide');
            Componentes.modalAlerta(data.textoMsg, null);
            top.nameFile = null;
        }
    });
}

function verificarArquivosBannerCliente() {
    var postData = $('#formCadBanner').serializeArray();
    var url = top.basePath + '/banner/index/verificar-arquivos-banner';
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                apresentarArquivosBannerCliente(data);
            }
        }
    });
}

function apresentarArquivosBannerCliente(array) {
    $("#uploadsBanner").html("");
    var formatDiv = '';
    var nameDiv = '';
    var nameFile = '';
    var block = $('<div class="block"></div>');
    $.each(array, function(key, value) {
        nameFile = value.dsArquivo;
        if (nameFile !== undefined) {
            nameDiv = nameFile.split(".");
            formatDiv = $("<div id='" + nameDiv[0] + "' class='col-lg-6 col-md-6 default-gradient thumbnail'>" + 
                            "<i class='fa fa-exclamation-triangle'></i>&nbsp;Copiar Caminho do Arquivo e colcar no código-fonte do Banner: <br>&nbsp;/storage/banners/" + top.idCliente + "/" + nameFile + 
                            "<center>" + 
                            "   <button id='btnBrrRqvBnnr" + nameDiv[0] + "' onClick='abrirArquivoBanner(\"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
                            "       <i class='fa fa-external-link'></i>" + 
                            "           Abrir arquivo" + 
                            "   </button>" +
                            "   <button id='btnRmvrRqvBnnr" + nameDiv[0] + "' onClick='confirmarRemoverArquivoBanner(\"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
                            "       <i class='fa fa-times'></i>" + 
                            "           Remover" + 
                            "   </button>" +
                            "</center>" +
                        "</div>"
            );
            block.append(formatDiv);
        }
    });
    $("#uploadsBanner").append(block);
}

function alterarTipoBanner() {
    if ($('#tpBanner').val() === '1') {
        $('#divRowLinksBanner').fadeIn('slow');
        $('#divRowDsBanner').fadeIn('slow');
        $('#divRowUploadBanner').fadeIn('slow');
        $('#divRowFileBanner').fadeIn('slow');
    } else {
        $('#divRowLinksBanner').hide();
        $('#divRowDsBanner').hide();
        $('#divRowUploadBanner').hide();
        $('#divRowFileBanner').hide();
    }
}

function alterarClienteBanner() {
    var postData = $('#formCadBanner').serializeArray();
    var url = top.basePath + '/banner/index/alterar-cliente-banner';
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                top.idCliente = data.idCliente;
            }
        }
    });
}

$(document).ready(function () {
    $('#banner-principal').hide();

    $('#home').removeClass('active');
    $('#diarios').removeClass('active');
    $('#rotas').removeClass('active');
    $('#anuncie').removeClass('active');
    $('#cadastrese').removeClass('active');
    $('#contato').removeClass('active');
    $('#areaRestrita').addClass('active');
    
    $("#cadBanner").hide();
    $("#psqBanner").fadeIn("slow");
    
    $('#btnNovoBanner').on('click', function () {
        limparCamposBanner();
        abrirTelaCadastroBanner();
    });

    $('#btnVoltarBanner').on('click', function () {
        location.href = top.basePath + '/perfil';
    });
    
    $('#btnNovoCadBanner').on('click', function () {
        limparCamposBanner();
    });

    $('#linkRemoverBanner').on('click', function () {
        confirmarRemoverLink();
    });

    $('#linkVisualizarBanner').on('click', function () {
        visualizarLink();
    });

    $('#btnGravarBanner').on('click', function () {
        salvarBanner();
    });

    $('#btnVoltarCadBanner').on('click', function () {
        abrirTelaPesquisaBanner();
    });
    
    $('#idCliente').on('change', function () {
        alterarClienteBanner();
    });
    
    $('#tpBanner').on('change', function () {
        alterarTipoBanner();
    });
    
    $('#fileBanner').change(function() {

        $(this).simpleUpload(top.basePath + "/banner/index/upload", {

                start: function(file){
                    $('#carregando').show();
                    //upload started
                    this.block = $('<div class="block"></div>');
                    this.progressBar = $('<div class="progressBar"></div>');
                    this.block.append(this.progressBar);
                    $('#uploadsBanner').append(this.block);
                },

                progress: function(progress){
                    //received progress
                    this.progressBar.width(progress + "%");
                },

                success: function(data){
                    $('#carregando').hide();
                    this.progressBar.remove();
                    if (data.tipoMsg !== "S") {
                        //upload successful 
                        Componentes.modalAlerta(formataTextMsg("Error!<br>Data: " + JSON.stringify(data.textoMsg)), null);
                    } else {
                        //now fill the block with the format of the uploaded file
                        var nameFile = data.name;
                        var nameDiv = nameFile.split(".");
                        var formatDiv = $("<div id='" + nameDiv[0] + "' class='col-lg-6 col-md-6 default-gradient thumbnail'>" + 
                                "<i class='fa fa-exclamation-triangle'></i>&nbsp;Copiar Caminho do Arquivo e colcar no código-fonte do Banner: <br>&nbsp;/storage/banners/" + top.idCliente + "/" + data.name + 
                                "<center>" + 
                                "   <button id='btnBrrRqvBnnr" + nameDiv[0] + "' onClick='abrirArquivoBanner(\"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
                                "       <i class='fa fa-external-link'></i>" + 
                                "           Abrir arquivo" + 
                                "   </button>" +
                                "<button id='btnRmvrRqvBnnr" + nameDiv[0] + "' onClick='confirmarRemoverArquivoBanner(\"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
                                "<i class='fa fa-times'></i>" + 
                                "Remover" + 
                                "</button>" +
                                "</center></div>");
                        this.block.append(formatDiv);
                    }
                },

                error: function(error){
                    //upload failed
                    this.progressBar.remove();
                    var error = error.message;
                    var errorDiv = $('<div class="error"></div>').text(error);
                    this.block.append(errorDiv);
                }

        });

    });
    
    $("#dtInicio").mask("99/99/9999");
    //Data Expira em
    $('#dtInicio').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em
    
    $("#dtFim").mask("99/99/9999");
    //Data Expira em
    $('#dtFim').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em
    
    $("#tituloBannerPsq").html('Pesquisar e Listar Banners');
    carregarComboClienteBanner();
    listarBanners();
});