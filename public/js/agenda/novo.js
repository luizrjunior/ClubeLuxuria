/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Função para remover a linha do dia
function removeLinhaDia(idDia){
    var linhaDia = $('#linha_dia'+idDia).parent();
    
    if(confirm('Tem certeza que deseja remover este dia de evento da sua agenda?'))
        $(linhaDia).remove();
}//remover a linha do dia que não terá evento

//Função para remover horário da lista
function removeHorario(idDia, idHora){    
    //Variáveis 
    var strElemento = 'dia'+idDia+'_hora'+idHora;
    var strElementoSpan = 'dia'+idDia+'_hora'+idHora+'_span';
    
    //Percorrento os elementos - Inputs hidden - removendo input tipo hidden respectivo
    $('#dv_dia'+idDia+'_hidden').children().each(function(index,elemento){        
        //Remover elemento hidden desejado.
        if(elemento.id === strElemento){
            $(elemento).remove();
        }//remover elemento
    });//elementos hidden
        
    //Percorrendo os elementos - Span - removendo o elemento span - elementos visuais
    $('#dv_dia'+idDia+'_span').children().each(function(index,elemento){
        if(elemento.id === strElementoSpan){
            $(elemento).remove();
        }//remover elemento
    });//elementos span
}//remove horario

//Função para colocar máscarasnos inputs de hora
function mascaraInput(input,mascara){
    $(input).mask(mascara);
}//função de máscara em input

//Função para adicionar nova Hora no evento
function adicionarHora(id){
    var html_hidden, html_span, aux, cont, erro, auxNomeHora;
    var hora_ini = $('#dia'+id+'_hora_ini').val();
    var hora_fim = $('#dia'+id+'_hora_fim').val();
    
    erro = 0;
    aux = hora_ini+' - '+hora_fim;
    
    //Não permite cadastrar horários com valores vazios
    if(hora_ini ===''||hora_fim===''){
        alert('Atenção!!!\n\nOs horários não podem estar vazios para serem adicionados, favor verificar.');
        erro =1;
        return false;
    }//verifica inputs
    
    //Caso os elementos não estejam vazios 
    if(erro === 0){
        //Busca todos os valores de horários caso exista.- Elementos já existem.
        if($('input[name="dia'+id+'_hora"]').length){
            //Elemento existe, percorre o array para retornar os valores 
            //Antes de Adicionar a hora verifica se já não possui uma cadastrada nesse dia.
            $('input[name="dia'+id+'_hora"]').each(function(index,elemento){
                if(aux === elemento.value){
                    alert('Atenção!!! \n\nO horário "'+aux+'" já está cadastrado para esse dia.');
                    erro = 1;
                }//if verifica horário repetido            
            });//percorrendo array e verificando horário repetido

            //caso não existam erros coloca o novo valor no array.
            if(erro === 0){
                //Montando input do tipo hidden
                cont = $('input[name="dia'+id+'_hora"]').length;//Total de Elementos no array        
                //Percorre todos os elementos do array                
                html_hidden = '<input type="hidden" id="dia'+id+'_hora'+cont+'" name="dia'+id+'_hora" value="'+aux+'" />'
                $('#dv_dia'+id+'_hidden').append(html_hidden);

                //Montando Span - Parte visual
                auxNomeHora = 'dia'+id+'_hora'+cont;
                html_span = '<br><span id="dia'+id+'_hora'+cont+'_span">'+aux+'&nbsp;<input type="button" class="btn btn-xs" value="(X) Remover" onclick="removeHorario('+id+','+cont+')"/></span>';
                $('#dv_dia'+id+'_span').append(html_span);
            }//if erro === 0                
        }else{
            //Cria os elementos - Elementos não existem     
            html_span = '<span id="dia'+id+'_hora0_span">'+aux+'&nbsp;<input type="button" class="btn btn-xs" value="(X) Remover" onclick="removeHorario('+id+',0)"/></span>';
            html_hidden = '<input type="hidden" id="dia'+id+'_hora0" name="dia'+id+'_hora" value="'+aux+'" />'

            $('#dv_dia'+id+'_span').html(html_span);
            $('#dv_dia'+id+'_hidden').html(html_hidden);
        }//inputs hiddens contendo os valores de intervalo de horas
    }//verificando erros
    
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
            if(erro === 0 || erro === '0'){
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
                    html += '<td id="linha_dia'+i+'" style="width:30%;text-align:center;">';
                    html += '<div class="col-sm-2 col-md-2" style="margin-top:7px;"><input type="button" value="(X) Remover" class="btn btn-xs" onclick="removeLinhaDia('+i+')"/></div>';
                    html += '<div class="col-sm-9 col-sm-offset-1 col-md-9 col-md-offset-1"> <span>'+aux.data_mes+'</span><br>';
                    html += '<span style="font-size:10px;">'+aux.data_texto+'</span>';
                    html += '<input type="hidden" id="dia'+i+'" name="dia" value="'+aux.data_mes+'"/></div></td>';
                    
                    //Coluna 2 - Range de Horário a ser cadastrado
                    html += '<td style="width:25%;text-align:center;vertical-align: middle;">';
                    html += '<input type="text" id="dia'+i+'_hora_ini" name="dia'+i+'_hora_ini" value="00:00" maxlength="5" onfocus="mascaraInput(this,\'99:99\')" class="col-sm-4 col-md-4" style="margin-top:5px;" />';
                    html += '<div class="col-sm-2 col-sm-offset-1 col-md-2 col-md-offset-1" style="margin-top:5px;">-</div>';
                    html += '<input type="text" id="dia'+i+'_hora_fim" name="dia'+i+'_hora_fim" value="23:59" maxlength="5" onfocus="mascaraInput(this,\'99:99\')" class="col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1" style="margin-top:5px;" /></td>'
                    
                    //Coluna 3 - Botão de adicionar novo horario
                    html += '<td style="width:15%;text-align:center;"><input type="button" value="Add Horário" class="btn btn-sm btn-primary" onclick="adicionarHora('+i+')" /></td>';
                    
                    //Coluna 4 - Os períodos de horários adicionados pelo usuário
                    html += '<td style="width:30%;"><div id="dv_dia'+i+'_span"></div>';
                    html += '<div id="dv_dia'+i+'_hidden" style="display:none;"></div></td>';
                    
                    //Finalizando a linha
                    html += '</tr>';
                }//for array dados
                
                //Finalizando HTML
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