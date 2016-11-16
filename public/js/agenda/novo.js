/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Função para verificar as datas (período) do evento
function verificaPeriodoEvento(){
    //Pegando as datas
    var data_inicial = $('#dtInicial').val();
    var data_final   = $('#dtFinal').val();
    
    $.ajax({
        type: "POST",
        url: '/agenda/inicio/verifica-datas-json',
        data: {
            dtInicial: data_inicial,
            dtFinal  : data_final
        },
        dataType: "json",
        success: function (data) {
            var erro = data.erro;
            var msg  = data.msg;
            var dados= data.dados;
        }
    });
}//função para verificar o período do evento

//Function
$(function(){
    //Configurando datas do Evento
    //Data Inicial
    $("#dtInicial").mask("99/99/9999");
    $('#dtInicial').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em
   
    //Data Final
    $("#dtFinal").mask("99/99/9999");    
    $('#dtFinal').datepicker({
       todayHighlight:true,
       autoclose:true,
       format: 'dd/mm/yyyy',
       todayHighLight:true
    });//data expira em
    
    //Comparando as datas
    $('#btnVerifHorario').on('click', function(){
        verificaPeriodoEvento();
    });//compara as datas
    
});//Function