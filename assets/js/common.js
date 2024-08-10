
var verify_login = 0;

var pattern              = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
var alpha_regrex         = /^[A-Za-z ]+$/;
var phonePattern         = /^\d{10}$/;
var username_pattern     = /^[@_0-9a-zA-Z]*$/;

$(document).ready(function(){       
    
    $("#phone").keyup(function(){
        var mobile_number = $("#phone").val();
        if(mobile_number == ""){
            $("#phone_validate").html('Please Enter 10-digit Mobile Number');
            $('#phone').css('border-color', 'red');            
        }
        else if(phonePattern.test(mobile_number) == false  || mobile_number.length !=10){
            $("#phone_validate").html('Please Enter Valid 10-digit Mobile Number.'); 
            $('#phone').css('border-color', 'red');              
        }
        else if(mobile_number !=""){
            $("#phone_validate").html(''); 
            $('#phone').css('border-color', '');               
        }
        else{
            $("#phone_validate").html(''); 
            $('#phone').css('border-color', '');            
        }
    });

    $("#mobile").keyup(function(){
        var mobile_number = $("#mobile").val();
        if(mobile_number == ""){
            $("#mobile_validate").html('Please Enter 10-digit Mobile Number');
            $('#mobile').css('border-color', 'red');            
        }
        else if(phonePattern.test(mobile_number) == false  || mobile_number.length !=10){
            $("#mobile_validate").html('Please Enter Valid 10-digit Mobile Number.'); 
            $('#mobile').css('border-color', 'red');              
        }
        else if(mobile_number !=""){
            $("#mobile_validate").html(''); 
            $('#mobile').css('border-color', '');               
        }
        else{
            $("#mobile_validate").html(''); 
            $('#mobile').css('border-color', '');            
        }
    });

    $("#email").keyup(function(){
        var Email =  $("#email").val();
        if(Email ==""){
            $("#email_validate").html('Please Enter Email.');
            $('#email').css('border-color', 'red');
        }
       else if(pattern.test(Email) == false){
            $("#email_validate").html('Please Enter Valid Email Id');  
            $('#email').css('border-color', 'red');
            registraion_flag=0; 
        }
        else {
            $("#email_validate").html('');
            $('#email').css('border-color', '');
        }
    });
});

$('.logout-me').on('click',function(){
    var aUrl = base_url+'admin/login/logout';    
    var loginID = 1;
    // alert(aUrl);
    $.ajax({
        url: aUrl,
        type: 'POST',
        data: {'loginID':loginID}, 
        // dataType:'json',
        success: function (data){
            console.log(data);
            if(data=="ok"){                                                                                         
                window.location = base_url + 'admin/login';
            }else
            {                
                window.location = base_url + 'admin/login';               
            }
        }
    });
});

$('.admin-login').on('click',function(){
    var uname = $('#uname').val();
    var password = $('#password').val();
    
    if(uname == ""){
        $('#email_error').html('Please Enter Username');
        $('#email_error').css('color','red');
        verify_login = 0;        
    }else{
        $('#email_error').html('');
        verify_login = 1; 
    }

    if(password == ""){
        $('#password_error').html('Please Enter Password');
        $('#password_error').css('color','red');
        verify_login = 0;        
    }else{
        $('#password_error').html('');
        verify_login = 1; 
    }

    if(verify_login == 1){
        var aUrl = base_url+'admin/login/check_login';
        // alert(aUrl);

        $.ajax({
            url: aUrl,
            type: 'POST',
            data: {'uname':uname,'password':password}, 
            // dataType:'json',
            success: function (data){
                console.log(data);
                if(data=="ok"){
                        $("#login_error").css({"color": "green", "font-size": "15px", "font-weight": "700", "margin-top": "10px","text-align": "center"});
                        $("#login_error").html("Login Successfull!!");                                                                        
                        window.location = base_url + 'admin/home';
                }else
                {
                    $("#adminLogin")[0].reset();
                    $("#login_error").css({"color": "red", "font-size": "15px", "font-weight": "800", "margin-top": "10px","text-align": "center"});
                    $("#login_error").html("Please Enter Valid Credentials!!!");   
                    $("#login_error").show();
                    $("#login_error").delay(4000).fadeOut();  
                    // window.location = base_url + 'admin/login';               
                }
            }
        });

    }else{

    }

});

$('.addSingleModuleData').on('click',function(){
    var uname = $('#uname').val();
    var password = $('#password').val();
    
    if(uname == ""){
        $('#email_error').html('Please Enter Username');
        $('#email_error').css('color','red');
        verify_login = 0;        
    }else{
        $('#email_error').html('');
        verify_login = 1; 
    }

    if(password == ""){
        $('#password_error').html('Please Enter Password');
        $('#password_error').css('color','red');
        verify_login = 0;        
    }else{
        $('#password_error').html('');
        verify_login = 1; 
    }

    if(verify_login == 1){
        var aUrl = base_url+'admin/login/check_login';
        // alert(aUrl);

        $.ajax({
            url: aUrl,
            type: 'POST',
            data: {'uname':uname,'password':password}, 
            // dataType:'json',
            success: function (data){
                console.log(data);
                if(data=="ok"){
                        $("#login_error").css({"color": "green", "font-size": "15px", "font-weight": "700", "margin-top": "10px","text-align": "center"});
                        $("#login_error").html("Login Successfull!!");                                                                        
                        window.location = base_url + 'admin/home';
                }else
                {
                    $("#adminLogin")[0].reset();
                    $("#login_error").css({"color": "red", "font-size": "15px", "font-weight": "800", "margin-top": "10px","text-align": "center"});
                    $("#login_error").html("Please Enter Valid Credentials!!!");   
                    $("#login_error").show();
                    $("#login_error").delay(4000).fadeOut();  
                    // window.location = base_url + 'admin/login';               
                }
            }
        });

    }else{

    }

});

$( '.lettersOnly' ).keypress( function ( e ) {
    var keycode = e.charCode ? e.charCode : e.keyCode     
    if ((keycode > 64 && keycode < 91) || (keycode > 96 && keycode < 123) || keycode == 32 )  { 
        return true; 
    }else{
        return false;
    }
});

$( '.valid_uname' ).keypress( function ( e ) {    
    var uname = e.key;    
    if (!username_pattern.test(uname)) {    
        return false;
    }
    return true;
});

$( '.lettersSymbolsOnly' ).keypress( function ( e ) {
    var keycode = e.charCode ? e.charCode : e.keyCode     
    if ((keycode > 64 && keycode < 91) || (keycode > 96 && keycode < 123) || keycode == 32 || keycode == 40 || keycode == 41 )  { 
        return true; 
    }else{
        return false;
    }
});

$( '.numberOnly' ).keypress( function ( e ) {//alert($(this).val().length);
    var unicode = e.charCode ? e.charCode : e.keyCode
    if ( unicode != 8 ) { //if the key isn't the backspace key (which we should allow)
        if ( unicode < 48 || unicode > 57 ){ //if not a number
            return false //disable key press
        }
    }
});