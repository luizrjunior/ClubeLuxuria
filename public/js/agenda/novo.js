/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Função para adicionar nova Hora no evento
function adicionarHora(id){
    var html_hidden, html_span, aux;
    var hora_ini = $('#dia'+id+'_hora_ini').val();
    var hora_fim = $('#dia'+id+'_hora_fim').val();
    
    console.log('Parâmetro diaId= '+id);
    
    //Busca todos os valores de horários caso exista.
    if($('input[name=dia'+id+'_hora]').length){
        //Elemento existe, percorre o array para retornar os valores 
        console.log('Elemento Existe..');
    }else{
        console.log('elemento não existe');
        
        //Cria os elementos
        aux = hora_ini+' - '+hora_fim;
        html_span = '<span>'+aux+'</span>'
        html_hidden = '<input type="hidden" id="dia'+id+'_hora0" name="dia'+id+'_hora[]" value="'+aux+'" />'
        
        $('#dv_dia'+id+'_span').html(html_span);
        $('#dv_dia'+id+'_hidden').html(html_hidden);
    }//inputs hiddens contendo os valores de intervalo de horas
    
    //Zerando os horários dos inputs
    $('#dia'+id+'_hora_ini').val('00:00');
    $('#dia'+id+'_hora_fim').val('23:59');
}//adicionar Hora Evento

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
            var tam, aux, html;
            
            //Verificando o retorno do sistema
            if(erro == 0 || erro === '0'){
                //Não possui erros
                tam = dados.length;

                //Iniciando HTML
                html = '<table class="col-sm-12 col-md-12">';
                
                //Percorrendo o array e verificando os valores
                for(var i=0; i<tam; i++){
                    aux = dados[i];
                    
                    //Iniciando linha
                    html += '<tr style="border:1px solid #FFF;">';
                    
                    //Coluna 1 - Data
                    html += '<td style="width:20%;text-align:center;">';
                    html += '<span>'+aux+'</span>';
                    html += '<input type="hidden" id="dia'+i+'" name="dia[]" value="'+aux+'"/></td>';
                    
                    //Coluna 2 - Range de Horário a ser cadastrado
                    html += '<td style="width:30%;text-align:center;vertical-align: middle;">';
                    html += '<input type="text" id="dia'+i+'_hora_ini" name="dia'+i+'_hora_ini" value="00:00" maxlength="5" class="col-sm-4 col-md-4" style="margin-top:5px;" />';
                    html += '<div class="col-sm-2 col-sm-offset-1 col-md-2 col-md-offset-1" style="margin-top:5px;">-</div>';
                    html += '<input type="text" id="dia'+i+'_hora_fim" name="dia'+i+'_hora_fim" value="23:59" maxlength="5" class="col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1" style="margin-top:5px;" /></td>'
                    
                    //Coluna 3 - Botão de adicionar novo horario
                    html += '<td style="width:20%;text-align:center;"><input type="button" value="Add Horário" class="btn btn-sm btn-primary" onclick="adicionarHora('+i+')" /></td>';
                    
                    //Coluna 4 - Os períodos de horários adicionados pelo usuário
                    html += '<td style="width:30%;"><div id="dv_dia'+i+'_span"></div>';
                    html += '<div id="dv_dia'+i+'_hidden" style="display:none;"></div></td>';
                    
                    //Finalizando a linha
                    html += '</tr>';
                }//for array dados
                
                html += '</table>';
                
                $('#dv_horarios_evento').html(html);
            }else{
                //Possui erros
                alert('Atenção!\n\n'+msg);
            }//if / else erro
        }//Success
    });//Ajax
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