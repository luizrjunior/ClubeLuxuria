function limparCamposAlbumPrincipal() {
    $("#idClienteAlbumPrincipal").val(top.idCliente);
    $("#idAlbumPrincipal").val('');
    $("#tpAlbumPrincipal").val('1');
    $("#stAlbumPrincipal").val('1');
    $("#stComentarioAlbumPrincipal").val('1');
    $("#noAlbumPrincipal").val('Ensaio Fotográfico');
    $("#dsAlbumPrincipal").val('Albúm de Fotos Principal');
}

function carregarCamposAlbumPrincipal(json) {
    top.idAlbum = json.idAlbum;
    $("#idAlbumPrincipal").val(json.idAlbum);
    $("#tpAlbumPrincipal").val(json.tpAlbum);
    $("#stAlbumPrincipal").val(json.stAlbum);
    $("#stComentarioAlbumPrincipal").val(json.stComentario);
    $("#noAlbumPrincipal").val(json.noAlbum);
    $("#dsAlbumPrincipal").val(json.dsAlbum);
    verificarFotoPerfil();
    verificarFotoCapa();
    verificarFotoHorizontal();
    verificarFotoVertical();
}

function selecionarAlbumPrincipal(idAlbum) {
    var url = top.basePath + '/album-foto/album/selecionar';
    $.ajax({
        type: "POST",
        url: url,
        data: {
            idAlbum: idAlbum
        },
        dataType: "json",
        success: function (data) {
            limparCamposAlbumPrincipal();
            if (data.tipoMsg === "S") {
                carregarCamposAlbumPrincipal(data);
            }
        }
    });
}

function salvarAlbumPrincipal() {
    var postData = $('#formCadAlbumPrincipal').serializeArray();
    var formURL = top.basePath + '/album-foto/album/salvar-album-principal';
    $.ajax({
        type: "POST",
        url: formURL,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                selecionarAlbumPrincipal(data.idAlbum);
            } else {
                $('#carregando').hide();
                Componentes.modalAlerta(formataTextMsg(data.textoMsg), null);
            }
        }
    });
}

function verificarAlbumPrincipal(idCliente) {
    $("#tituloAlbumPrincipalPsq").html('Ensaio Sensual - Cliente: ' + $("#noCliente").val() + ' ' + $("#nuTelefoneCliente").val());
    top.idCliente = idCliente;
    limparCamposAlbumPrincipal();
    $('#carregando').show();
    var postData = $('#formCadAlbumPrincipal').serializeArray();
    var url = top.basePath + '/album-foto/album/verificar-album-principal';
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data.tipoMsg === "S") {
                selecionarAlbumPrincipal(data.idAlbum);
            } else {
                salvarAlbumPrincipal();
            }
        }
    });
}