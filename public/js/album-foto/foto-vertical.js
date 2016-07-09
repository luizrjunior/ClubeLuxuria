function limparCamposFotoVertical() {
    $("#idFotoVertical").val('');
    $("#idAlbumFotoVertical").val(top.idAlbum);
    $("#tpFotoVertical").val('4');
    $("#stFotoVertical").val('1');
    $("#stComentarioFotoVertical").val('1');
    $("#dsLegendaFotoVertical").val('');
    $("#dsArquivoFotoVertical").val('');
    $("#uploadsVertical").html("");
    $("#tituloFotoVertical").html('Fotos na Vertical (Retrato)');
}

function carregarCamposFotoVertical(json) {
    $("#idFotoVertical").val(json.idFoto);
    $("#idAlbumFotoVertical").val(json.idAlbum);
    $("#tpFotoVertical").val(json.tpFoto);
    $("#stFotoVertical").val(json.stFoto);
    $("#stComentarioFotoVertical").val(json.stComentario);
    $("#dsLegendaFotoVertical").val(json.dsLegenda);
    $("#dsArquivoFotoVertical").val(json.dsArquivo);
}

function selecionarFotoVertical(idFotoVertical) {
    var url = top.basePath + '/album-foto/foto/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idFoto: idFotoVertical
        },
        dataType: "json",
        success: function (data) {
            limparCamposFotoVertical();
            if (data.tipoMsg === "S") {
                carregarCamposFotoVertical(data);
            }
        }
    });
}

function validarCamposFotoVertical() {
    var chk = true;
    var texto = "<ul>";

    if ($("#dsArquivoFotoVertical").val() === "") {
        if ($("#fileFotoVertical").val() === "") {
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

function salvarFotoVertical(nameFile) {
    $("#dsArquivoFotoVertical").val(nameFile);
    if (validarCamposFotoVertical()) {
        $('#carregando').show();
        var postData = $('#formCadFotoVertical').serializeArray();
        var formURL = top.basePath + '/album-foto/foto/salvar-foto-vertical';
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: "json",
            success: function (data) {
                $('#carregando').hide();
                if (data.tipoMsg === "S") {
                    var nameButton = nameFile.split(".");
                    $('#btnSlvrFtVrtcl' + nameButton[0]).remove();
                    $('#btnRmvrFtVrtcl' + nameButton[0]).on('click', function () {
                        confirmarRemoverFotoVertical(data.idFoto, nameFile);
                    });
                } else {
                    Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
                }
            }
        });
    } else {
        $("#dsArquivoFotoVertical").val(nameFile);
    }
}

function confirmarRemoverFotoVertical(idFoto, name) {
    top.idFotoVertical = idFoto;
    top.nameFile = name;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerFotoVertical, null);
}

function removerFotoVertical() {
    $('#carregando').show();
    var formURL = top.basePath + "/album-foto/foto/excluir";
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            idFoto: top.idFotoVertical,
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
            top.idFotoVertical = null;
            top.nameFile = null;
        }
    });
}

function confirmarRemoverArquivoFotoVertical(name) {
    top.nameFile = name;
    Componentes.modalConfirmacao(null, 'Tem certeza que deseja remover esse arquivo?', removerArquivoFotoVertical, null);
}

function removerArquivoFotoVertical() {
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

function verificarFotoVertical() {
    limparCamposFotoVertical();
    var postData = $('#formCadFotoVertical').serializeArray();
    var url = top.basePath + '/album-foto/foto/verificar-foto-vertical';
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                apresentarFotosVerticais(data);
            }
            $('#carregando').hide();
        }
    });
}

function apresentarFotosVerticais(array) {
    var formatDiv = '';
    var nameDiv = '';
    var nameFile = '';
    var blockVertical = $('<div class="blockVertical"></div>');
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
                                "   <button id='btnRmvrFtVrtcl" + nameDiv[0] + "' onClick='confirmarRemoverFotoVertical(\"" + value.idFoto + "\", \"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
                                "       <i class='fa fa-times'></i>" + 
                                "           Remover" + 
                                "   </button>" +
                                "</center>" +
                            "</div>"
                );
            }
            blockVertical.append(formatDiv);
        }
    });
    $("#uploadsVertical").append(blockVertical);
    $('#carregando').hide();
}

$(document).ready(function () {
    if (top.idClientePerfil !== undefined) {
        $('#divFileFotoVertical').hide();
        $('#divNotaFotoVertical').hide();
    }
    
    $('#btnRemoverArquivoFotoVertical').on('click', function () {
        confirmarRemoverArquivoFotoVertical();
    });

    $('#btnGravarFotoVertical').on('click', function () {
        salvarFotoVertical();
    });

    $('#fileFotoVertical').change(function() {

        $(this).simpleUpload(top.basePath + "/album-foto/foto/upload", {

                start: function(file){
                    $('#carregando').show();
                    //upload started
                    this.blockVertical = $('<div class="blockVertical"></div>');
                    this.progressBar = $('<div class="progressBar"></div>');
                    this.blockVertical.append(this.progressBar);
                    $('#uploadsVertical').append(this.blockVertical);
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
                        var formatDiv = $("<div id='" + nameDiv[0] + "' class='col-lg-3 col-md-3 default-gradient thumbnail'>" + 
                                "<img class='img-responsive' src='" + top.basePath + "/storage/fotos/" + top.idCliente + "/"  + top.idAlbum + "/" + data.name + "' />" + 
                                "<center>" + 
                                "<button id='btnSlvrFtVrtcl" + nameDiv[0] + "' onClick='salvarFotoVertical(\"" + nameFile + "\")' class='btn btn-danger btn-xs' type='button'>" + 
                                "<i class='fa fa-save'></i>" + 
                                "Salvar" + 
                                "</button>" + 
                                "&nbsp;&nbsp;&nbsp;" +
                                "<button id='btnRmvrFtVrtcl" + nameDiv[0] + "' onClick='confirmarRemoverArquivoFotoVertical(\"" + nameFile + "\");' class='btn btn-danger btn-xs' type='button'>" + 
                                "<i class='fa fa-times'></i>" + 
                                "Remover" + 
                                "</button>" +
                                "</center></div>");
                        this.blockVertical.append(formatDiv);
                    }
                },

                error: function(error){
                    //upload failed
                    this.progressBar.remove();
                    var error = error.message;
                    var errorDiv = $('<div class="error"></div>').text(error);
                    this.blockVertical.append(errorDiv);
                }

        });

    });
});