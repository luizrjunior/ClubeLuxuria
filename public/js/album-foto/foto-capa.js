function limparCamposFotoCapa() {
    $("#idFotoCapa").val('');
    $("#idAlbumFotoCapa").val(top.idAlbum);
    $("#tpFotoCapa").val('2');
    $("#stFotoCapa").val('1');
    $("#stComentarioFotoCapa").val('1');
    $("#dsLegendaFotoCapa").val('');
    $("#dsArquivoFotoCapa").val('');
    $('#imgFotoCapa').attr("src", "../../epona/images/demo/people/9_full.jpg");
    abrirFecharLinkFileFotoCapa();
}

function carregarCamposFotoCapa(json) {
    $("#idFotoCapa").val(json.idFoto);
    $("#idAlbumFotoCapa").val(json.idAlbum);
    $("#tpFotoCapa").val(json.tpFoto);
    $("#stFotoCapa").val(json.stFoto);
    $("#stComentarioFotoCapa").val(json.stComentario);
    $("#dsLegendaFotoCapa").val(json.dsLegenda);
    $("#dsArquivoFotoCapa").val(json.dsArquivo);
    $('#imgFotoCapa').attr("src", "../../storage/fotos/" + top.idCliente + "/"  + json.idAlbum + "/" + json.dsArquivo);
    $('#filenameFotoCapa').html('Arquivo: <a href="../../storage/fotos/' + top.idCliente + '/' + json.idAlbum + "/" + json.dsArquivo + '" target="_blank">' + json.dsArquivo + '</a>');
    abrirFecharLinkFileFotoCapa();
}

function selecionarFotoCapa(idFotoCapa) {
    var url = top.basePath + '/album-foto/foto/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idFoto: idFotoCapa
        },
        dataType: "json",
        success: function (data) {
            limparCamposFotoCapa();
            if (data.tipoMsg === "S") {
                carregarCamposFotoCapa(data);
            }
            $('#carregando').hide();
        }
    });
}

function validarCamposFotoCapa() {
    var chk = true;
    var texto = "<ul>";

    if ($("#dsArquivoFotoCapa").val() === "") {
        if ($("#fileFotoCapa").val() === "") {
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

function salvarFotoCapa() {
    if (validarCamposFotoCapa()) {
        $('#carregando').show();
        var postData = $('#formCadFotoCapa').serializeArray();
        var formURL = top.basePath + '/album-foto/foto/salvar-foto-capa';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                if (data.tipoMsg === "S") {
                    selecionarFotoCapa(data.idFoto);
                } else {
                    Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                }
            }
        });
    }
}

function confirmarRemoverArquivoFotoCapa() {
    top.nameFile = $("#dsArquivoFotoCapa").val();
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerArquivoFotoCapa, null);
}

function removerArquivoFotoCapa() {
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
            $('#imgFotoCapa').attr("src", "../../epona/images/demo/people/9_full.jpg");
            $("#dsArquivoFotoCapa").val('');
            abrirFecharLinkFileFotoCapa();
        }
    });
}

function abrirFecharLinkFileFotoCapa() {
    if ($("#dsArquivoFotoCapa").val() !== "") {
        $('#divFileFotoCapa').hide();
        $('#divLinkFotoCapa').show();
    } else {
        $('#divFileFotoCapa').show();
        $('#divLinkFotoCapa').hide();
    }
}

function verificarFotoCapa() {
    limparCamposFotoCapa();
    var postData = $('#formCadFotoCapa').serializeArray();
    var url = top.basePath + '/album-foto/foto/verificar-foto-capa';
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                selecionarFotoCapa(data.idFoto);
            }
        }
    });
}

$(document).ready(function () {
    if (top.idClientePerfil !== undefined) {
        $('#divBtnRemoverFotoCapa').hide();
        $('#divNotaFotoCapa').hide();
        $('#divBtnsFotoCapa').hide();
    }
    
    $('#btnRemoverArquivoFotoCapa').on('click', function () {
        confirmarRemoverArquivoFotoCapa();
    });

    $('#btnGravarFotoCapa').on('click', function () {
        salvarFotoCapa();
    });

    $('#fileFotoCapa').change(function() {
        $(this).simpleUpload(top.basePath + "/album-foto/foto/upload", {

            allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif"],
            allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
            maxFileSize: 25000000, //25MB in bytes

            start: function(file){
                $('#carregando').show();
                $('#filenameFotoCapa').html('Arquivo: ' + file.name);
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
                    $("#dsArquivoFotoCapa").val('');
                } else {
                    //upload started
                    $('#filenameFotoCapa').html('Arquivo: <a href="../../storage/fotos/' + top.idCliente + '/' + top.idAlbum + "/" + data.name + '" target="_blank">' + data.name + '</a>');
                    $('#imgFotoCapa').attr("src", "../../storage/fotos/" + top.idCliente + "/"  + top.idAlbum + "/" + data.name);
                    $("#dsArquivoFotoCapa").val(data.name);
                }
                abrirFecharLinkFileFotoCapa();
            },

            error: function(error){
                //upload failed 
                Componentes.modalAlerta(formataTextMsg("Falha!<br>" + error.name + ": " + error.message), null);
                $("#dsArquivoFotoCapa").val('');
                abrirFecharLinkFileFotoCapa();
            }

        });

    });
});