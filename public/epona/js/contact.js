$(function(){
    
     //Oculta Banner
   $('#banner-principal').hide();
   
   //Trata Classe do Menu Ativo 
    $('#home').removeClass('active');
    $('#areaRestrita').removeClass('active');
    $('#contato').addClass('active');
    
    myMap = new GMaps({
        div: '#myMap',
        lat:  -15.72986,
        lng: -47.8613477
    });
    
        // @CONTACT FORM - TRANSLATE OR EDIT
     var errMsg           = "Os seguintes campos estão inválidos verifique-os:\n" ,
         err              = false,
         okSent           = '<strong>Thank You!</strong> Your message successfully sent!',
         buttonDisabled   = 'MESSAGE SENT';

    /**	CONTACT FORM
    *************************************************** **/
    jQuery("#contact_submit").bind("click", function(e) {
            e.preventDefault();

            var contact_name 	    = $("#contact_name").val(),			// required
                    contact_email   = $("#contact_email").val(),			// required
                    contact_subject = $("#contact_subject").val(),			// optional
                    contact_comment = $("#contact_comment").val(),			// required
                    captcha 	    = $("#captcha").val(),					// required TO BE EMPTY for humans
                    _action	    = $("#contactForm").attr('action'),	// form action URL
                    _method	    = $("#contactForm").attr('method'),	// form method
                    _err	    = false;									// status

            // Remove error class
            jQuery("input, textarea").parent().removeClass('has-error has-feedback');
            jQuery("input, textarea").parent().find('span').hide();

            // Spam bots will see captcha field - that's how we detect spams.
            // It's very simple and not very efficient antispam method but works for bots.
            if(captcha != '') {
                    return false;
            }

            // Name Check
            if(contact_name == '') {
                    //jQuery("#contact_name").addClass('has-error has-feedback');
                    $("#contact_name").parent().addClass('form-group has-error has-feedback');
                    $("#contact_name").parent().append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                     errMsg += "\n >>Nome;";
                     err = true;
            }

            // Email Check
            if(contact_email == '') {
                    jQuery("#contact_email").parent().addClass('has-error has-feedback');
                    $("#contact_email").parent().append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                    errMsg += "\n >>E-mail;";
                    err = true;
            }

            // Subject Check
            if(contact_subject == '') {
                jQuery("#contact_subject").parent().addClass('has-error has-feedback');
                $("#contact_subject").parent().append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');            
                errMsg += "\n >>Assunto;";    
                err = true;
            }

            // Comment Check
            if(contact_comment == '') {
                jQuery("#contact_comment").parent().addClass('has-error has-feedback');
                $("#contact_comment").parent().append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                errMsg += "\n >>Mensagem;";
                err = true;
            }

            // Stop here, we have empty fields!
            if(err === true) {
                 alert(errMsg);
                 return false;
            }


            // SEND MAIL VIA AJAX
            $.ajax({
                    url: 	_action,
                    data: 	{
                        ajax:"true", 
                        action:'email_send', 
                        contact_name:contact_name, 
                        contact_email:contact_email, 
                        contact_comment:contact_comment, 
                        contact_subject:contact_subject
                    },
                    type: 	_method,
                    error: 	function(XMLHttpRequest, textStatus, errorThrown) {

                            alert("Server Internal Error\n"+errorThrown); // usualy on headers 404
                        
                    },

                    success: function(data) {
                            data = data.trim(); // remove output spaces


                            // PHP RETURN: Mandatory Fields
                            if(err === true) {
                                    alert(errMsg);
                            } else

                            // PHP RETURN: INVALID EMAIL
                            if(data == '_invalid_email_') {
                                    alert(errEmail);
                            } else

                            // VALID EMAIL
                            if(data == '_sent_ok_') {

                                    // append message and show ok alert
                                    jQuery("#_msg_txt_").empty().append(okSent);
                                    jQuery("#_sent_ok_").removeClass('hide');

                                    // reset form
                                    jQuery("#contact_name, #contact_email, #contact_subject, #contact_comment").val('');

                                    // disable button - message already sent!
                                    jQuery("#contact_submit").empty().append(buttonDisabled);
                                    jQuery("#contact_submit").addClass('disabled');

                            } else {

                                    // PHPMAILER ERROR
                                    alert(data); 

                            }
                    }
            });

    });
});