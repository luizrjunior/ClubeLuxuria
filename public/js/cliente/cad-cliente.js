function limparCamposCliente() {
    $("#tituloModalCliente").html('Adicionar Cliente');
    $("#idCliente").val('');
    
    $("#tpCliente").val('');
    $("#tpCliente").prop('disabled', false);
    $("#stCliente").val('1');
    $("#noCliente").val('');
    $("#nuCpf").val('');
    $('input[name="tpSexo"]').prop('checked', false);
    $("#nuCep").val('');
    $("#dsEnderecoCliente").val('');
    $("#sgUfCliente").val('');
    $("#noCidadeCliente").val('');
    $("#nuTelefoneCliente").val('');
    $("#dtNascimento").val('');
    $("#dtNascimento").prop('disabled', false);
    $("#dtVencimentoCliente").val('');
    
    $("#maintab").click();
                
    $('#divBtnEditar').hide();
    $('#divBtnAdicionar').show();
    abrirFecharCamposCliente();
    
    if (top.stPreCadastro !== undefined) {
        $("#tpCliente").val('2');
        $("#tpCliente").prop('disabled', true);
        $("#stCliente").val('3');
        $("#stCliente").prop('disabled', true);
        $("#divRowTipoSituacao").hide();
        $("#divDtVencimentoCliente").hide();
        $("#tituloModalCliente").html('Registre sua conta - Seja Sócio Clube Luxúria');
    }    
}

function carregarCamposCliente(json) {
    $("#tituloModalCliente").html('Editar Dados Cliente: ' + json.noCliente + ' ' + json.nuTelefone + '<div style="float: right;"><a href="' + top.basePath + '/acompanhante/visualizar/' + json.idCliente + '" target="_blank"><i class="glyphicon glyphicon-new-window"></a></div>');
    $("#idCliente").val(json.idCliente);
    $("#tpCliente").val(json.tpCliente);
    $("#tpCliente").prop('disabled', true);
    $("#stCliente").val(json.stCliente);
    $("#noCliente").val(json.noCliente);
    $("#nuCpf").val(json.nuCpf);
    var radiosTpSexo = $('input:radio[name=tpSexo]');
    radiosTpSexo.filter('[value=' + json.tpSexo + ']').prop('checked', true);
    $("#nuCep").val(json.nuCep);
    $("#dsEnderecoCliente").val(json.dsEndereco);
    $("#sgUfCliente").val(json.sgUf);
    $("#sgUfCliente").prop('disabled', false);
    $("#noCidadeCliente").val(json.noCidade);
    $("#nuTelefoneCliente").val(json.nuTelefone);
    $("#dtNascimento").val(json.dtNascimento);
    if (json.dtNascimento) {
        $("#dtNascimento").prop('disabled', true);
    }
    $("#dtVencimentoCliente").val(json.dtVencimento);
    
    if (top.idClientePerfil !== undefined) {
        $("#stCliente").prop('disabled', true);
        $("#noCliente").prop('disabled', true);
        $("#nuCpf").prop('disabled', true);
        $('input[name="tpSexo"]').prop('disabled', true);
        $("#dtVencimentoCliente").prop('disabled', true);
    }
    
    $("#maintab").click();
    
    $('#divBtnEditar').show();
    $('#divBtnAdicionar').hide();
    abrirFecharCamposCliente();
}

function selecionarCliente(idCliente) {
    var url = top.basePath + '/cliente/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCliente: idCliente
        },
        dataType: "json",
        success: function(data) {
            if (data.tipoMsg === "S") {
                limparCamposCliente();
                if (top.idClientePerfil !== undefined) {
                    abrirTelaCadastroClientePerfil();
                } else {
                    if (top.stPreCadastro === undefined) {
                        abrirTelaCadastroCliente();
                    }
                }
                carregarCamposCliente(data);
            } else {
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        }
    });
}

function selecionarClienteUsuario(idCliente) {
    $('#carregando').show();
    var url = top.basePath + '/cliente/cliente-usuario/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idCliente: idCliente
        },
        dataType: "json",
        success: function(data) {
            if (data.tipoMsg === "S") {
                selecionarCliente(data.idCliente);
                selecionarUsuarioClienteForm(data.idUsuario);
            } else {
                $('#carregando').hide();
                selecionarCliente(idCliente);
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        }
    });
}

function limparCamposUsuarioClienteForm() {
    $("#idUsuario").val('');
    $("#login").val('');
    $("#email").val('');
    $("#sgUfUsuario").val('');
    $("#noUsuario").val('');
    $("#senha").val('');
    $("#confirmarsenha").val('');
    $("#tpUsuario").val('');
    $("#stUsuario").val(1);
    $('#divSenha').show();
    if (top.stPreCadastro !== undefined) {
        $("#tpUsuario").val(4);
    }
}

function carregarCamposUsuarioClienteForm(json) {
    $("#idUsuario").val(json.idUsuario);
    $("#login").val(json.login);
    $("#email").val(json.email);
    $("#sgUfUsuario").val(json.sgUfUsuario);
    $("#noUsuario").val(json.noUsuario);
    $("#senha").val('');
    $("#confirmarsenha").val('');
    $("#tpUsuario").val(json.tpUsuario);
    $("#stUsuario").val(json.stUsuario);
    $("#divSenha").hide();
}

function selecionarUsuarioClienteForm(idUsuario) {
    var url = top.basePath + '/usuario/index/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idUsuario: idUsuario
        },
        dataType: "json",
        success: function(data) {
            $('#carregando').hide();
            if (data.tipoMsg === "S") {
                carregarCamposUsuarioClienteForm(data);
            } else {
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        }
    });
}

function validarCamposCliente() {
    var chk = true;
    var texto = "<ul>";
    
    if ($("#noCliente").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Nome\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#nuCpf").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"CPF\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if (!$("input[name='tpSexo']").is(":checked")) {
        texto += "<li><font color='#000000'>O campo <strong>\"Sexo\"</strong> é de preenchimento obrigatório.</font></li>";
        chk = false;
    }
        
    if ($("#tpCliente").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Tipo\"</strong> é de seleção obrigatória.</font></li>";
        chk = false;
    }

    if ($("#sgUfCliente").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"UF\"</strong> é de seleção obrigatória.</font></li>";
        chk = false;
    }
    
    if ($("#dtNascimento").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Nascimento\"</strong> é de preenchimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#login").val() === "") {
        texto += "<li><font color='#000000'>O campo <strong>\"Login\"</strong> é de preechimento obrigatório.</font></li>";
        chk = false;
    }

    if ($("#idCliente").val() === "") {
        if ($("#senha").val() === "") {
            texto += "<li><font color='#000000'>O campo <strong>\"Senha\"</strong> é de preechimento obrigatório.</font></li>";
            chk = false;
        }

        if ($("#confirmarsenha").val() === "") {
            texto += "<li><font color='#000000'>O campo <strong>\"Confirmar Senha\"</strong> é de preechimento obrigatório.</font></li>";
            chk = false;
        }

        if ($("#senha").val() !== "" && $("#confirmarsenha").val() !== "") {
            if ($("#senha").val() !== $("#confirmarsenha").val()) {
                texto += "<li><font color='#000000'>O campo <strong>\"Confirmar Senha\"</strong> diferente do campo <strong>\"Senha\"</strong>.</font></li>";
                chk = false;
            }
        }
    }
    texto += "</ul>";

    if (chk === false) {
        Componentes.modalAlerta(texto, null);
        return chk;
    } else {
        $("#sgUfCliente").prop('disabled', false);
        $("#tpCliente").prop('disabled', false);
        $("#stCliente").prop('disabled', false);
        $("#noCliente").prop('disabled', false);
        $("#nuCpf").prop('disabled', false);
        $('input[name="tpSexo"]').prop('disabled', false);
        $("#dtVencimentoCliente").prop('disabled', false);
        $("#dtNascimento").prop('disabled', false);
        return chk;
    }
}

function salvarCliente() {
    if (validarCamposCliente()) {
        if ($("#noUsuario").val() === "") {
            $("#noUsuario").val($("#noCliente").val());
            $("#sgUfUsuario").val($("#sgUfCliente").val());
        }
        $('#carregando').show();
        var postData = $('#formCadCliente').serializeArray();
        var formURL = top.basePath + '/cliente/index/salvar';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function(data) {
                if (data.tipoMsg === "S") {
                    limparCamposCliente();
                    selecionarCliente(data.idCliente);
                    salvarUsuarioClienteForm();
                } else {
                    $('#carregando').hide();
                    Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                }
            }
        });
    }
}

function salvarUsuarioClienteForm() {
    var postData = $('#formCadCliente').serializeArray();
    var formURL = top.basePath + '/usuario/index/salvar';
    $.ajax({
        type: "POST",
        url: formURL,
        data: postData,
        dataType: "json",
        success: function(data) {
            if (data.tipoMsg === "S") {
                if (top.stPreCadastro !== undefined) {
                    top.senha = $('#senha').val();
                }
                limparCamposUsuarioClienteForm();
                selecionarUsuarioClienteForm(data.idUsuario);
                $("#idUsuario").val(data.idUsuario);
                salvarClienteUsuario();
            } else {
                $('#carregando').hide();
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        }
    });
}

function salvarClienteUsuario() {
    var formURL = top.basePath +  '/cliente/cliente-usuario/salvar';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            idCliente: $("#idCliente").val(),
            idUsuario: $("#idUsuario").val()
        },
        dataType: "json",
        success: function(data) {
            $('#carregando').hide();
            if (data.tipoMsg === "S") {
                if (top.stPreCadastro !== undefined) {
                    fazerLogin();
                } else {
                    if (top.idClientePerfil === undefined) {
                        clicarPesquisarNovamenteCliente();
                    }
                }
            }
            Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
        }
    });
}

function setarSgUfUsuario() {
    $("#sgUfUsuario").val($('#sgUfCliente').val());
}

function abrirFecharCamposCliente() {
    if ($('#tpCliente').val() === '1') {
        $("#tpUsuario").val('3');//03 - Anunciante;
        if ($('#idCliente').val() !== '') {
            $('#menuAnunciantesCad').show();
            $('#menuCaracteristicasCad').show();
            $('#menuConfiguracoesCad').show();
            $('#menuFotosCad').show();
            $('#menuVideosCad').show();
            $('#menuCacheCad').show();
            $('#menuDepoimentoCad').show();
            $('#menuAlbumFotosCad').show();
        }
    }
    if ($('#tpCliente').val() === '2') {
        $("#tpUsuario").val('4');//04 - Sócio Clube Luxúria;
        $('#menuAnunciantesCad').hide();
        $('#menuCaracteristicasCad').hide();
        $('#menuConfiguracoesCad').hide();
        $('#menuFotosCad').hide();
        $('#menuVideosCad').hide();
        $('#menuCacheCad').hide();
        $('#menuDepoimentoCad').hide();
        $('#menuAlbumFotosCad').hide();
    }
}

function abrirTelaCadastroClientePerfil() {
    $("#cadCliente").fadeIn("slow");
}

$(document).ready(function () {
    $('#divPerfilSituacaoUsuario').hide();

    $('#tpCliente').on('change', function () {
        abrirFecharCamposCliente();
    });
    
    $('#sgUfCliente').on('change', function () {
        setarSgUfUsuario();
    });
    
    $("#nuCep").mask("99999-999");
    $("#nuCpf").mask("999.999.999-99");
    $("#dtVencimentoCliente").mask("99/99/9999");
    $("#dtNascimento").mask("99/99/9999");
    
    //Data Expira em
    $('#dtNascimento').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em
    
    //Data Expira em
    $('#dtVencimentoCliente').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em

    $('#btnNovoCadCliente').on('click', function () {
        limparCamposCliente();
        limparCamposUsuarioClienteForm();
    });
    
    $('#btnGravarCliente').on('click', function () {
        salvarCliente();
    });
    
    $('#btnVoltarCadCliente').on('click', function () {
        abrirTelaPesquisaCliente();
    });
    
    if (top.idClientePerfil !== undefined) {
        $('#menuAnunciantesCad').on('click', function () {
            selecionarAnuncianteCliente($("#idCliente").val());
        });

        $('#menuCaracteristicasCad').on('click', function () {
            selecionarCaracteristicasCliente($("#idCliente").val());
        });

        $('#menuCacheCad').on('click', function () {
            selecionarCachesCliente($("#idCliente").val());
        });

        $('#menuPagamentoCad').on('click', function () {
            selecionarPagamentosCliente($("#idCliente").val());
        });

        $('#menuVideosCad').on('click', function () {
            selecionarVideosCliente($("#idCliente").val());
        });

        $('#menuFotosCad').on('click', function () {
            verificarAlbumPrincipal($("#idCliente").val());
        });

        $('#menuBannerCad').on('click', function () {
            selecionarBannersCliente($("#idCliente").val());
        });

        $('#menuDepoimentoCad').on('click', function () {
            selecionarDepoimentosCliente($("#idCliente").val());
        });

        $('#menuAlbumFotosCad').on('click', function () {
            selecionarAlbunsCliente($("#idCliente").val());
        });
        $('#menuConfiguracoesCad').on('click', function () {
            selecionarConfigPaginaCliente($("#idCliente").val());
        });
        selecionarClienteUsuario(top.idClientePerfil);
    } 
    
    if (top.stPreCadastro !== undefined) {
        limparCamposCliente();
        limparCamposUsuarioClienteForm();
    }
});