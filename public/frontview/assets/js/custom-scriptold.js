$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#pbit-forget-pass-sect").hide();
        $(".signup-section").hide();
        $("#myModal").modal();
        $(".login-section").show();

    });
	$("#pbit-opn-signup").click(function(){ 
        $(".login-section").hide();
        $(".signup-section").show();    
    });

    $("#pbit-opn-login").click(function(){       
        $(".signup-section").hide();
        $(".login-section").show(); 
    });

     $("#pbit-fgt-pass").click(function(){
        $(".login-section").hide();
        $("#pbit-forget-pass-sect").show();   
    });
    $("#pbit-forget-login").click(function(){
        $("#pbit-forget-pass-sect").hide();
        $(".login-section").show();        
    });
    $("#register").click(function(){
        $(".login-section").hide();
        $("#pbit-forget-pass-sect").hide();  
        $("#myModal").modal();        
        $(".signup-section").show();        
    });

    

                
    
});