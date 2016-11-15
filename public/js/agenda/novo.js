/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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
});//Function