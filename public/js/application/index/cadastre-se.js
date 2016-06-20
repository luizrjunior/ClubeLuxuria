/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!window.sendPost) {
    window.sendPost = function(url, obj){
        var myForm = document.createElement("form");
        myForm.action = url;
        myForm.method = "post";
        for(var key in obj) {
            var input = document.createElement("input");
            input.type = "text";
            input.value = obj[key];
            input.name = key;
            myForm.appendChild(input);            
        }
        document.body.appendChild(myForm);
        myForm.submit();
    };    
}

function fazerLogin() {
    sendPost('/login/logar',{
        login: document.getElementById('login').value,
        senha: top.senha
    });
}

$(function(){
    $('#home').removeClass('active');
    $('#diarios').removeClass('active');
    $('#rotas').removeClass('active');
    $('#anuncie').removeClass('active');
    $('#cadastrese').addClass('active');
    $('#contato').removeClass('active');
    $('#areaRestrita').removeClass('active');
});