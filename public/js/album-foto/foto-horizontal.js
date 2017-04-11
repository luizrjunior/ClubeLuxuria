function limparCamposFotoHorizontal() {
    $("#idFotoHorizontal").val('');
    $("#idAlbumFotoHorizontal").val(top.idAlbum);
    $("#tpFotoHorizontal").val('3');
    $("#stFotoHorizontal").val('1');
    $("#stComentarioFotoHorizontal").val('1');
    $("#dsLegendaFotoHorizontal").val('');
    $("#dsArquivoFotoHorizontal").val('');
    $("#uploads").html("");
}

function carregarCamposFotoHorizontal(json) {
    $("#idFotoHorizontal").val(json.idFoto);
    $("#idAlbumFotoHorizontal").val(json.idAlbum);
    $("#tpFotoHorizontal").val(json.tpFoto);
    $("#stFotoHorizontal").val(json.stFoto);
    $("#stComentarioFotoHorizontal").val(json.stComentario);
    $("#dsLegendaFotoHorizontal").val(json.dsLegenda);
    $("#dsArquivoFotoHorizontal").val(json.dsArquivo);
}

function selecionarFotoHorizontal(idFotoHorizontal) {
    var url = top.basePath + '/album-foto/foto/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idFoto: idFotoHorizontal
        },
        dataType: "json",
        success: function (data) {
            limparCamposFotoHorizontal();
            if (data.tipoMsg === "S") {
                carregarCamposFotoHorizontal(data);
            }
            $('#carregando').hide();
        }
    });
}

function validarCamposFotoHorizontal() {
    var chk = true;
    var texto = "<ul>";

    if ($("#dsArquivoFotoHorizontal").val() === "") {
        if ($("#fileFotoHorizontal").val() === "") {
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

function salvarFotoHorizontal(nameFile) {
    $("#dsArquivoFotoHorizontal").val(nameFile);
    if (validarCamposFotoHorizontal()) {
        $('#carregando').show();
        var postData = $('#formCadFotoHorizontal').serializeArray();
        var formURL = top.basePath + '/album-foto/foto/salvar-foto-horizontal';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                $('#carregando').hide();
                if (data.tipoMsg === "S") {
                    var nameButton = nameFile.split(".");
                    $('#btnSlvrFtHrzntl' + nameButton[0]).remove();
                    $('#btnRmvrFtHrzntl' + nameButton[0]).on('click', function () {
                        confirmarRemoverFotoHorizontal(data.idFoto, nameFile);
                    });
                } else {
                    Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                }
            }
        });
    } else {
        $("#dsArquivoFotoHorizontal").val(nameFile);
    }
}

function confirmarRemoverFotoHorizontal(idFoto, name) {
    top.idFotoHorizontal = idFoto;
    top.nameFile = name;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerFotoHorizontal, null);
}

function removerFotoHorizontal() {
    $('#carregando').show();
    var formURL = top.basePath + "/album-foto/foto/excluir";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            idFoto: top.idFotoHorizontal,
            idAlbum: top.idAlbum,
            idCliente: top.idCliente,
            nameFile: top.nameFile
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            var nameDiv = top.nameFile.split(".");
            $('#' + nameDiv[0]).remove();
            $('#modalConfirmacao').modal('hide');
            if (data.tipoMsg !== "S") {
                Componentes.modalAlerta(data.textoMsg, null);
            }
            top.idFotoHorizontal = null;
            top.nameFile = null;
        }
    });
}

function confirmarRemoverArquivoFotoHorizontal(name) {
    top.nameFile = name;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerArquivoFotoHorizontal, null);
}

function removerArquivoFotoHorizontal() {
    $('#carregando').show();
    var formURL = top.basePath + "/album-foto/foto/remover-arquivo";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
                idAlbum: top.idAlbum,
                idCliente: top.idCliente,
                nameFile: top.nameFile
                },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            var nameDiv = top.nameFile.split(".");
            $('#' + nameDiv).remove();
            $('#modalConfirmacao').modal('hide');
            if (data.tipoMsg !== "S") {
                Componentes.modalAlerta(data.textoMsg, null);
            }
            top.nameFile = null;
        }
    });
}

function verificarFotoHorizontal() {
    limparCamposFotoHorizontal();
    var postData = $('#formCadFotoHorizontal').serializeArray();
    var url = top.basePath + '/album-foto/foto/verificar-foto-horizontal';
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                apresentarFotosHorizontais(data);
            }
        }
    });
}

function apresentarFotosHorizontais(array) {
    var formatDiv = '';
    var nameDiv = '';
    var nameFile = '';
    var block = $('<div class="block"></div>');
    $.each(array, function(key, value) {
        nameFile = value.dsArquivo;
        if (nameFile !== undefined) {
            nameDiv = nameFile.split(".");
            if (top.idClientePerfil !== undefined) {
                formatDiv = $("<div id='" + nameDiv[0] + "' class='col-lg-3 col-md-3 default-gradient thumbnail'>" + 
                                "<img class='img-responsive' src='" + top.basePath + "/storage/fotos/" + top.idCliente + "/"  + value.idAlbum + "/" + nameFile + "' />" + 
                            "</div>"
                );
            } else {
                formatDiv = $("<div id='" + nameDiv[0] + "' class='col-lg-3 col-md-3 default-gradient thumbnail'>" + 
                                "<img class='img-responsive' src='" + top.basePath + "/storage/fotos/" + top.idCliente + "/"  + value.idAlbum + "/" + nameFile + "' />" + 
                                "<center>" + 
                                "   <button id='btnRmvrFtHrzntl" + nameDiv[0] + "' onClick='confirmarRemoverFotoHorizontal(\"" + value.idFoto + "\", \"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
                                "       <i class='fa fa-times'></i>" + 
                                "           Remover" + 
                                "   </button>" +
                                "</center>" +
                            "</div>"
                );
            }
            block.append(formatDiv);
        }
    });
    $("#uploads").append(block);
}

$(document).ready(function () {
    if (top.idClientePerfil !== undefined) {
        $('#divFileFotoHorizontal').hide();
        $('#divNotaFotoHorizontal').hide();
    }
    
    $('#btnRemoverArquivoFotoHorizontal').on('click', function () {
        confirmarRemoverArquivoFotoHorizontal();
    });

    $('#btnGravarFotoHorizontal').on('click', function () {
        salvarFotoHorizontal();
    });

    $('#fileFotoHorizontal').change(function() {
        $(this).simpleUpload(top.basePath + "/album-foto/foto/upload", {
            start: function(file){
                $('#carregando').show();
                this.block = $('<div class="block"></div>');
                this.progressBar = $('<div class="progressBar"></div>');
                this.block.append(this.progressBar);
                $('#uploads').append(this.block);
            },
            progress: function(progress){
                this.progressBar.width(progress + "%");
            },
            success: function(data){
                $('#carregando').hide();
                this.progressBar.remove();
                if (data.tipoMsg !== "S") {
                    Componentes.modalAlerta(formataTextMsg("Falha no upload!<br>Data: " + JSON.stringify(data.textoMsg)), null);
                } else {
                    var nameFile = data.name;
                    var nameDiv = nameFile.split(".");
                    var formatDiv = $("<div id='" + nameDiv[0] + "' class='col-lg-3 col-md-3 default-gradient thumbnail'>" + 
                        "<img class='img-responsive' src='" + top.basePath + "/storage/fotos/" + top.idCliente + "/"  + top.idAlbum + "/" + data.name + "' />" + 
                        "<center>" + 
                        "<button id='btnSlvrFtHrzntl" + nameDiv[0] + "' onClick='salvarFotoHorizontal(\"" + nameFile + "\")' class='btn btn-danger btn-xs' type='button'>" + 
                        "<i class='fa fa-save'></i>" + 
                        "Salvar" + 
                        "</button>" + 
                        "&nbsp;&nbsp;&nbsp;" +
                        "<button id='btnRmvrFtHrzntl" + nameDiv[0] + "' onClick='confirmarRemoverArquivoFotoHorizontal(\"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
                        "<i class='fa fa-times'></i>" + 
                        "Remover" + 
                        "</button>" +
                        "</center></div>");
                    this.block.append(formatDiv);
                }
            },
            error: function(error){
                this.progressBar.remove();
                var erro = error.message;
                var errorDiv = $('<div class="error"></div>').text(erro);
                this.block.append(errorDiv);
            }
        });
    });
});