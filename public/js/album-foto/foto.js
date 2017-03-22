function limparCamposFoto() {
    $("#idFoto").val('');
    $("#idAlbumFoto").val('');
    $("#tpFoto").val('3');
    $("#stFoto").val('1');
    $("#stComentarioFoto").val('1');
    $("#dsLegendaFoto").val('');
    $("#dsArquivoFoto").val('');
    $("#blockFoto").html('');
    $("#uploadsFoto").html('');
    $("#tituloFoto").html('Fotos do Album');
}

function carregarCamposFoto(json) {
    $("#idFoto").val(json.idFoto);
    $("#idAlbumFoto").val(json.idAlbum);
    $("#tpFoto").val(json.tpFoto);
    $("#stFoto").val(json.stFoto);
    $("#stComentarioFoto").val(json.stFoto);
    $("#dsLegendaFoto").val(json.dsLegenda);
    $("#dsArquivoFoto").val(json.dsArquivo);
}

function selecionarFoto(idFoto) {
    var url = top.basePath + '/album-foto/foto/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idFoto: idFoto
        },
        dataType: "json",
        success: function (data) {
            limparCamposFoto();
            if (data.tipoMsg === "S") {
                carregarCamposFoto(data);
            }
            $('#carregando').hide();
        }
    });
}

function validarCamposFoto() {
    var chk = true;
    var texto = "<ul>";

    if ($("#dsArquivoFoto").val() === "") {
        if ($("#fileFoto").val() === "") {
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

function salvarFoto(nameFile) {
    $("#dsArquivoFoto").val(nameFile);
    if (validarCamposFoto()) {
        $('#carregando').show();
        var postData = $('#formCadFoto').serializeArray();
        var formURL = top.basePath + '/album-foto/foto/salvar-foto';
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
                        confirmarRemoverFoto(data.idFoto, nameFile);
                    });
                } else {
                    Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                }
            }
        });
    } else {
        $("#dsArquivoFoto").val(nameFile);
    }
}

function confirmarRemoverFoto(idFoto, name) {
    top.idFoto = idFoto;
    top.nameFile = name;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerFoto, null);
}

function removerFoto() {
    $('#carregando').show();
    var formURL = top.basePath + "/album-foto/foto/excluir";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            idFoto: top.idFoto,
            idAlbum: top.idAlbum,
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
            top.idFoto = null;
            top.nameFile = null;
        }
    });
}

function confirmarRemoverArquivoFoto(name) {
    top.nameFile = name;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerArquivoFoto, null);
}

function removerArquivoFoto() {
    $('#carregando').show();
    var formURL = top.basePath + "/album-foto/foto/remover-arquivo";
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

function verificarFotos(idAlbum) {
    $("#idAlbumFoto").val(idAlbum);
    var postData = $('#formCadFoto').serializeArray();
    var url = top.basePath + '/album-foto/foto/verificar-foto';
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                apresentarFotos(data);
            }
        }
    });
}

function apresentarFotos(array) {
    var formatDiv = '';
    var nameDiv = '';
    var nameFile = '';
    var block = $('<div class="blockFoto"></div>');
    $.each(array, function(key, value) {
        nameFile = value.dsArquivo;
        if (nameFile !== undefined) {
            nameDiv = nameFile.split(".");
            if (top.idClientePerfil !== undefined) {
                if ($("#tpAlbum").val() === '1') {
                    formatDiv = $("<div id='" + nameDiv[0] + "' class='col-lg-3 col-md-3 default-gradient thumbnail'>" + 
                                    "<img class='img-responsive' src='" + top.basePath + "/storage/fotos/" + top.idCliente + "/"  + value.idAlbum + "/" + nameFile + "' />" + 
                                "</div>"
                    );
                } else {
                    formatDiv = $("<div id='" + nameDiv[0] + "' class='col-lg-3 col-md-3 default-gradient thumbnail'>" + 
                                    "<img class='img-responsive' src='" + top.basePath + "/storage/fotos/" + top.idCliente + "/"  + value.idAlbum + "/" + nameFile + "' />" + 
                                    "<center>" + 
                                    "   <button id='btnRmvrFtHrzntl" + nameDiv[0] + "' onClick='confirmarRemoverFoto(\"" + value.idFoto + "\", \"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
                                    "       <i class='fa fa-times'></i>" + 
                                    "           Remover" + 
                                    "   </button>" +
                                    "</center>" +
                                "</div>"
                    );
                }
            } else {
                formatDiv = $("<div id='" + nameDiv[0] + "' class='col-lg-3 col-md-3 default-gradient thumbnail'>" + 
                                "<img class='img-responsive' src='" + top.basePath + "/storage/fotos/" + top.idCliente + "/"  + value.idAlbum + "/" + nameFile + "' />" + 
                                "<center>" + 
                                "   <button id='btnRmvrFtHrzntl" + nameDiv[0] + "' onClick='confirmarRemoverFoto(\"" + value.idFoto + "\", \"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
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
    $("#uploadsFoto").append(block);
}

$(document).ready(function () {
    $("#tituloFoto").html('Fotos do Album');
    $('#fileFoto').change(function() {
        $(this).simpleUpload(top.basePath + "/album-foto/foto/upload", {
            start: function(){
                $('#carregando').show();
                this.block = $('<div class="blockFoto"></div>');
                this.progressBar = $('<div class="progressBar"></div>');
                this.block.append(this.progressBar);
                $('#uploadsFoto').append(this.block);
            },
            progress: function(progress){
                this.progressBar.width(progress + "%");
            },
            success: function(data){
                $('#carregando').hide();
                this.progressBar.remove();
                if (data.tipoMsg !== "S") {
                    Componentes.modalAlerta(formataTextMsg("Error!<br>Data: " + JSON.stringify(data.textoMsg)), null);
                } else {
                    var nameFile = data.name;
                    var nameDiv = nameFile.split(".");
                    var formatDiv = $("<div id='" + nameDiv[0] + "' class='col-lg-3 col-md-3 default-gradient thumbnail'>" + 
                        "<img class='img-responsive' src='" + top.basePath + "/storage/fotos/" + top.idCliente + "/"  + top.idAlbum + "/" + data.name + "' />" + 
                        "<center>" + 
                        "<button id='btnSlvrFtHrzntl" + nameDiv[0] + "' onClick='salvarFoto(\"" + nameFile + "\")' class='btn btn-danger btn-xs' type='button'>" + 
                        "<i class='fa fa-save'></i>" + 
                        "Salvar" + 
                        "</button>" + 
                        "&nbsp;&nbsp;&nbsp;" +
                        "<button id='btnRmvrFtHrzntl" + nameDiv[0] + "' onClick='confirmarRemoverArquivoFoto(\"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
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