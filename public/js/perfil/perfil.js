$(document).ready(function () {
    $('#home').removeClass('active');
    $('#diarios').removeClass('active');
    $('#rotas').removeClass('active');
    $('#anuncie').removeClass('active');
    $('#cadastrese').removeClass('active');
    $('#contato').removeClass('active');
    $('#areaRestrita').addClass('active');
    
    $('#menuConfiguracoesPerfilCad').on('click', function () {
        selecionarConfigPaginaPerfil(top.idUsuarioPerfil);
    });
    
});