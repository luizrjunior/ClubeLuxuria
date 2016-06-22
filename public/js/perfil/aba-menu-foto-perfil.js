function limparCamposFotoPerfilUsuario() {
    $("#dsArquivoFotoPerfilUsuario").val('');
    $('#imgFotoPerfilUsuario').attr("src", top.basePath + "/epona/images/demo/people/9_full.jpg");
    abrirFecharLinkFileFotoPerfilUsuario();
}

function carregarCamposFotoPerfilUsuario(json) {
    $("#dsArquivoFotoPerfilUsuario").val(json.dsArquivo);
    $('#imgFotoPerfilUsuario').attr("src", top.basePath + "/storage/usuarios/" + top.idUsuarioPerfil + "/foto-perfil/" + json.dsArquivo);
    $('#filenameFotoPerfilUsuario').html('Arquivo: <a href="' + top.basePath + '/storage/usuarios/' + top.idUsuarioPerfil + '/foto-perfil/' + json.dsArquivo + '" target="_blank">' + json.dsArquivo + '</a>');
    abrirFecharLinkFileFotoPerfilUsuario();
}

function mostrarFotoPerfilUsuario() {
    $('#carregando').show();
    var url = top.basePath + '/perfil/mostrar-foto-perfil';
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        success: function (data) {
            limparCamposFotoPerfilUsuario();
            if (data.tipoMsg === "S") {
                carregarCamposFotoPerfilUsuario(data);
            }
            $('#carregando').hide();
        }
    });
}

function validarCamposFotoPerfilUsuario() {
    var chk = true;
    var texto = "<ul>";

    if ($("#dsArquivoFotoPerfilUsuario").val() === "") {
        if ($("#fileFotoPerfilUsuario").val() === "") {
            texto += "<li><font color='#000000'>O campo <strong>\"Arquivo\"</strong> é de preechimento obrigatório.</font></li>";
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

function salvarFotoPerfilUsuario() {
    if (validarCamposFotoPerfilUsuario()) {
        $('#carregando').show();
        var postData = $('#formCadFotoPerfilUsuario').serializeArray();
        var formURL = top.basePath + '/perfil/salvar-foto-perfil';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                if (data.tipoMsg === "S") {
                    mostrarFotoPerfilUsuario();
                }
                console.log(formataTextMsg(data.textoMsg));
            }
        });
    }
}

function confirmarRemoverArquivoFotoPerfilUsuario() {
    top.nameFile = $("#dsArquivoFotoPerfilUsuario").val();
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerArquivoFotoPerfilUsuario, null);
}

function removerArquivoFotoPerfilUsuario() {
    $('#carregando').show();
    var formURL = top.basePath + "/perfil/remover-arquivo";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
                idAlbum: top.idAlbum,
                nameFile: top.nameFile
                },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            $('#modalConfirmacao').modal('hide');
            top.nameFile = null;
            Componentes.modalAlerta(data.textoMsg, null);
            limparCamposFotoPerfilUsuario();
            abrirFecharLinkFileFotoPerfilUsuario();
        }
    });
}

function abrirFecharLinkFileFotoPerfilUsuario() {
    if ($("#dsArquivoFotoPerfilUsuario").val() !== "") {
        $('#divFileFotoPerfilUsuario').hide();
        $('#divLinkPerfilUsuario').show();
    } else {
        $('#divLinkPerfilUsuario').hide();
        $('#divFileFotoPerfilUsuario').show();
    }
}

$(document).ready(function () {
    $('#btnRemoverArquivoFotoPerfilUsuario').on('click', function () {
        confirmarRemoverArquivoFotoPerfilUsuario();
    });

    $('#btnGravarFotoPerfilUsuario').on('click', function () {
        salvarFotoPerfilUsuario();
    });

    $('#fileFotoPerfilUsuario').change(function() {
        $(this).simpleUpload(top.basePath + "/perfil/upload-foto-perfil", {

            allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif"],
            allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
            maxFileSize: 25000000, //25MB in bytes

            start: function(file){
                $('#carregando').show();
                $('#filenameFotoPerfilUsuario').html('Arquivo: ' + file.name);
            },

            progress: function(progress){
                //received progress
                console.log("upload progress: " + Math.round(progress) + "%");
            },

            success: function(data){
                $('#carregando').hide();
                if (data.tipoMsg !== "S") {
                    //upload successful 
                    Componentes.modalAlerta(formataTextMsg("Error!<br>Data: " + JSON.stringify(data.textoMsg)), null);
                    $("#dsArquivoFotoPerfilUsuario").val('');
                } else {
                    //upload started 
                    $('#filenameFotoPerfilUsuario').html('Arquivo: <a href="' + top.basePath + '/storage/usuarios/' + top.idUsuarioPerfil + '/foto-perfil/' + data.name + '" target="_blank">' + data.name + '</a>');
                    $('#imgFotoPerfilUsuario').attr("src", top.basePath + "/storage/usuarios/" + top.idUsuarioPerfil + "/foto-perfil/" + data.name);
                    $("#dsArquivoFotoPerfilUsuario").val(data.name);
                }
                abrirFecharLinkFileFotoPerfilUsuario();
            },

            error: function(error){
                //upload failed 
                Componentes.modalAlerta(formataTextMsg("Falha!<br>" + error.name + ": " + error.message), null);
                $("#dsArquivoFotoPerfilUsuario").val('');
                abrirFecharLinkFileFotoPerfilUsuario();
            }

        });

    });
    mostrarFotoPerfilUsuario();
});