function limparCamposFotoPerfil() {
    $("#idFotoPerfil").val('');
    $("#idAlbumFotoPerfil").val(top.idAlbum);
    $("#tpFotoPerfil").val('1');
    $("#stFotoPerfil").val('1');
    $("#stComentarioFotoPerfil").val('1');
    $("#dsLegendaFotoPerfil").val('');
    $("#dsArquivoFotoPerfil").val('');
    $('#imgFotoPerfil').attr("src", "../../epona/images/demo/people/9.jpg");
    abrirFecharLinkFileFotoPerfil();
}

function carregarCamposFotoPerfil(json) {
    $("#idFotoPerfil").val(json.idFoto);
    $("#idAlbumFotoPerfil").val(json.idAlbum);
    $("#tpFotoPerfil").val(json.tpFoto);
    $("#stFotoPerfil").val(json.stFoto);
    $("#stComentarioFotoPerfil").val(json.stComentario);
    $("#dsLegendaFotoPerfil").val(json.dsLegenda);
    $("#dsArquivoFotoPerfil").val(json.dsArquivo);
    $('#imgFotoPerfil').attr("src", "../../storage/fotos/" + top.idCliente + "/"  + json.idAlbum + "/" + json.dsArquivo);
    $('#filenameFotoPerfil').html('Arquivo: <a href="../../storage/fotos/' + top.idCliente + '/' + json.idAlbum + "/" + json.dsArquivo + '" target="_blank">' + json.dsArquivo + '</a>');
    abrirFecharLinkFileFotoPerfil();
}

function selecionarFotoPerfil(idFotoPerfil) {
    var url = top.basePath + '/album-foto/foto/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idFoto: idFotoPerfil
        },
        dataType: "json",
        success: function (data) {
            limparCamposFotoPerfil();
            if (data.tipoMsg === "S") {
                carregarCamposFotoPerfil(data);
            }
            $('#carregando').hide();
        }
    });
}

function validarCamposFotoPerfil() {
    var chk = true;
    var texto = "<ul>";

    if ($("#dsArquivoFotoPerfil").val() === "") {
        if ($("#fileFotoPerfil").val() === "") {
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

function salvarFotoPerfil() {
    if (validarCamposFotoPerfil()) {
        $('#carregando').show();
        var postData = $('#formCadFotoPerfil').serializeArray();
        var formURL = top.basePath + '/album-foto/foto/salvar-foto-perfil';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                if (data.tipoMsg === "S") {
                    selecionarFotoPerfil(data.idFoto);
                } else {
                    Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                }
            }
        });
    }
}

function confirmarRemoverArquivoFotoPerfil() {
    top.nameFile = $("#dsArquivoFotoPerfil").val();
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerArquivoFotoPerfil, null);
}

function removerArquivoFotoPerfil() {
    $('#carregando').show();
    var formURL = top.basePath + "/album-foto/foto/remover-arquivo";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
                idCliente: top.idCliente,
                idAlbum: top.idAlbum,
                nameFile: top.nameFile
                },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            $('#modalConfirmacao').modal('hide');
            top.nameFile = null;
            if (data.tipoMsg !== "S") {
                Componentes.modalAlerta(data.textoMsg, null);
            }
            $('#imgFotoPerfil').attr("src", "../../epona/images/demo/people/9.jpg");
            $("#dsArquivoFotoPerfil").val('');
            abrirFecharLinkFileFotoPerfil();
        }
    });
}

function abrirFecharLinkFileFotoPerfil() {
    if ($("#dsArquivoFotoPerfil").val() !== "") {
        $('#divFileFotoPerfil').hide();
        $('#divLinkFotoPerfil').show();
    } else {
        $('#divFileFotoPerfil').show();
        $('#divLinkFotoPerfil').hide();
    }
}

function verificarFotoPerfil() {
    limparCamposFotoPerfil();
    var postData = $('#formCadFotoPerfil').serializeArray();
    var url = top.basePath + '/album-foto/foto/verificar-foto-perfil';
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                selecionarFotoPerfil(data.idFoto);
            }
        }
    });
}

$(document).ready(function () {
    if (top.idClientePerfil !== undefined) {
        $('#divBtnRemoverFotoPerfil').hide();
        $('#divNotaFotoPerfil').hide();
        $('#divBtnsFotoPerfil').hide();
    }
    
    $('#btnRemoverArquivoFotoPerfil').on('click', function () {
        confirmarRemoverArquivoFotoPerfil();
    });

    $('#btnGravarFotoPerfil').on('click', function () {
        salvarFotoPerfil();
    });

    $('#fileFotoPerfil').change(function() {
        $(this).simpleUpload(top.basePath + "/album-foto/foto/upload", {

            allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif"],
            allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
            maxFileSize: 25000000, //25MB in bytes

            start: function(file){
                $('#carregando').show();
                $('#filenameFotoPerfil').html('Arquivo: ' + file.name);
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
                    $("#dsArquivoFotoPerfil").val('');
                } else {
                    //upload started 
                    $('#filenameFotoPerfil').html('Arquivo: <a href="../../storage/fotos/' + top.idCliente + '/' + top.idAlbum + "/" + data.name + '" target="_blank">' + data.name + '</a>');
                    $('#imgFotoPerfil').attr("src", "../../storage/fotos/" + top.idCliente + "/"  + top.idAlbum + "/" + data.name);
                    $("#dsArquivoFotoPerfil").val(data.name);
                }
                abrirFecharLinkFileFotoPerfil();
            },

            error: function(error){
                //upload failed 
                Componentes.modalAlerta(formataTextMsg("Falha!<br>" + error.name + ": " + error.message), null);
                $("#dsArquivoFotoPerfil").val('');
                abrirFecharLinkFileFotoPerfil();
            }

        });

    });
});