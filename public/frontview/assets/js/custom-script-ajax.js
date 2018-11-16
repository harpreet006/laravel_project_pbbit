  function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
         jQuery(document).ready(function(){

          /*Login-Section*/
           jQuery('.login').click(function(e){               
                 //  e.preventDefault();
               var captcha=grecaptcha.getResponse();                 
               var Email = jQuery('#email').val();         
              if (jQuery('#password').val()=="") {             
                  jQuery("#pnit-id-password-error").html("Password is required");               
                 /// e.preventDefault();
              }else{
                 jQuery("#pnit-id-password-error").html(""); 
              }              
              if (jQuery.trim(Email).length == 0 ) {
                  //alert('Email is required');
                  jQuery("#pnit-id-email-error").html("Email is required"); 
                 // e.preventDefault();
              }else{
                  //alert('Invalid Email Address'); 
                  jQuery("#pnit-id-email-error").html("Invalid email address");              
                  //jQuery("#email").attr("placeholder", "Invalid Email Address").addClass('focus'); 
                 // e.preventDefault();
              }
              if (ValidateEmail(Email)) { 
                jQuery("#pnit-id-email-error").html("");             
                  if (captcha=="") {             
                  jQuery("#pnit-id-captcha-error").html("Captcha is required");               
                  /// e.preventDefault();
                   return false;
                  }else{
                    jQuery("#pnit-id-captcha-error").html(""); 
                  }
                  //alert("Welcom");                                      
                       jQuery.ajax({
                          url: BASE_URL+'/custom-login',
                          method: 'POST',
                          data: {
                             '_token': jQuery('input[name="_token"]').attr('value'),
                             'email': jQuery('#email').val(),
                             'password': jQuery('#password').val(),
                             'captcha': grecaptcha.getResponse()                      
                          },
                          success: function(result){     
                          //alert(result.status);
                          if(result.status=='success'){ location.reload(true);}
                          else{
                             jQuery("#pbt-result-login").html(result.message);  
                             }                           
                          }}); 
                  }
                     
               }); 
            /*Login-Section*/
            /*Forgetpassword-Sectiuon*/
               jQuery('.reset-btnn').click(function(e){          
                 e.preventDefault();             
                var F_Email = jQuery('#forgetpswdEmail').val();  
                if (jQuery.trim(F_Email).length == 0 ) {
                  //alert('Email is required');
                  jQuery("#pnit-id-frgt-password-error").html("Email is required"); 
                  e.preventDefault();
                }

                  if (jQuery.trim(F_Email).length != 0 ) {
                  //alert('Email is required');
                   var F_emailstatus=ValidateEmail(F_Email);
                   if(F_emailstatus==true){
                      jQuery("#pnit-id-frgt-password-error").html('');                  
                      jQuery.ajax({
                      url: "password/email",
                      method: 'POST',
                      data: {
                         _token: jQuery('input[name="_token"]').attr('value'),
                        email: 'jasvir.shinedezign@gmail.com',                                  
                      },
                      success: function(result){
                      //sendPasswordResetNotification();     
                      //alert(result.status);
                      if(result.status=='success'){ location.reload(true);}
                         jQuery("#pbt-result-login").html(result.status); 
                      }});
             }else{
                    jQuery("#pnit-id-frgt-password-error").html("Invalid email address");
                  }
                   //alert(dfsd);
                
                }           
               
                    //ValidateEmail(F_Email)  ;
                  // jQuery("#pnit-id-frgt-password-error").html("Invalid email address");  
             });
             
            /*Forgetpassword-Sectiuon*/
            /*Signup*/
          jQuery('.signup').click(function(e){                  
                  var u_name = jQuery('#exampleInputname').val(); 
                  var u_email =jQuery('#exampleInputEmail1').val(); 
                  var u_pass = jQuery('#exampleInputPassword1').val(); 
          var agree = '0';         
          if ($('#checkbox2').is(":checked"))
          {
          agree = '1';
          }else{
          agree = '0';
          }    // alert(jQuery('#checkbox2').prop("#checkbox2"));
                
        jQuery.ajax({
                  url: BASE_URL+'/custom-register',
                  method: 'POST',
                  data: {
                     '_token': jQuery('input[name="_token"]').attr('value'),
                    'name': u_name,
                    'email': u_email,
                    'password': u_pass,                             
                    'password_confirmation': u_pass, 
                    'notification': agree
                    //'remember_chk': u_check                              
                  },                  
                  success: function(result){
                    if(!result.status){
                      jQuery('.error').html('');
                      jQuery.each(result.errors,function(index,value){
                        
                        jQuery('.'+index).html(value);
                      });
                    }else{
                      register_success(result.message);
                    }
                  
                  }}); 
               });
            /*Signup*/

               //alert("Hello");
            });

      var currentRequest = null;
  $("#userSearch").keyup(function(event){
	 if(currentRequest != null) { console.log('aaaaa');
	 console.log(currentRequest);
       currentRequest.abort();
      }
	  
    var value = this.value;
    var url = BASE_URL+'/user-search';
        
    if(event.keyCode == 32){
      return false;
    }else if(value == '' || value == null){
      $(".searchul").empty();
      return false;
    }
    else if(event.keyCode == 88){
      $("#searchul").empty();
      return false;
    }
    else
    {
    
     currentRequest =  jQuery.ajax({
        url: url,
        method: 'POST',
        data: {
          '_token': jQuery('input[name="_token"]').attr('value'),
            'search': value                            
            }, 
        dataType: 'json', 
		timeout: 5000,		
        success: function(result){
          $("#searchul").empty();
		  $("#searchul").css("display","block");
          if(result != ''){
          $.each(result, function(){
          var topicid = '';
              var url = ''
              if(!this['course_id']){
                  url = BASE_URL +"/course/"+this['title'];
              }
              else{
                  url = BASE_URL + "/topic/"+this['course_id'];
              }
              var title = this['title'].charAt(0).toUpperCase() + this['title'].slice(1);
			  
          if(this['title'] == 'Record not Found'){
				   $("#searchul").append("<li><a href='javascript:void(0);'>" + title + "</a></li>");
			  }else{
				   $("#searchul").append("<li><a href="+ url + ">" + title + "</a></li>");
			  }
			
          }); 
          }
        
            
            }
      }); 
    }
  });
$("#DashboardSearch").keyup(function(event){
    var value = this.value;
    var url = BASE_URL+'/search-data';  
    if(event.keyCode == 32){
      return false;
    }else if(value == '' || value == null){
      $("#responseData").empty();
      return false;
    }
    else if(event.keyCode == 88){
      $("#responseData").empty();
      return false;
    }
    else
    {
      jQuery.ajax({
        url: url,
        method: 'POST',
        data: {
          '_token': jQuery('input[name="_token"]').attr('value'),
            'search': value                            
            }, 
        dataType: 'json',         
        success: function(result){
          $("#responseData").empty();
          if(result != ''){
            $.each(result, function(){
            if(!this['chapter_id']){
                  url = BASE_URL +"/viewChapter/"+this['id'];
              var title = this['title'].charAt(0).toUpperCase() + this['title'].slice(1);
              }
              else{
              url = BASE_URL +"/viewTopic/"+this['id'];
              var title = this['title'].charAt(0).toUpperCase() + this['title'].slice(1);
                  
              }
			  
			  
           if(this['title'] == 'Record not Found'){
				   $("#responseData").append("<li><a href='javascript:void(0);'>" + title + "</a></li>");   
			  }
			  else{
				   $("#responseData").append("<li><a href="+ url + ">" + title + "</a></li>");   
			  }
            
           

		   });
          }
          else{
              location.reload(true);
          }
            
        }
      }); 
    }
  });

  
  
  
function register_success(message) { 
  $("#myModal").hide();
  $.confirm({
    title: 'Congratulations!',
    content: message,
    type: 'blue',
    buttons: {
      confirm: function () {
           location.reload(true);
        },     
      close: function() {
        location.reload(true);
      },
    }
  });

}


function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user=getCookie("accept");
    if (user != "") {
        return true;
    } else {
       return false;
       // user = prompt("Please enter your name:","");
       // if (user != "" && user != null) {
       //     setCookie("username", user, 30);
       // }
    }
}


$(document).ready(function(){
	var ajaxReq;
	$("#hsearch").keyup(function(event){
		if(ajaxReq){
			ajaxReq.abort();
		}
		var value = this.value;
		var url = BASE_URL+'/user-search';
        
		if(event.keyCode == 32){
		    return false;
		}else if(value == '' || value == null){
		    $("#searchultop").empty();
		    return false;
		}
		else if(event.keyCode == 88){
		    $("#searchultop").empty();
		    return false;
		}
		else
		{
	
			ajaxReq   =  $.ajax({
			url: url,
			method: 'POST',
			data: {
			  '_token': jQuery('input[name="_token"]').attr('value'),
				'search': value                            
				}, 
			dataType: 'json',	
			success: function(result){
				$("#searchultop").empty();
				$("#searchultop").css("display","block");
					if(result != ''){
						$.each(result, function(){
							var topicid = '';
							var url = ''
							if(!this['course_id']){
								url = BASE_URL +"/course/"+this['title'];
							}
							else{
								url = BASE_URL + "/topic/"+this['course_id'];
							}
							var title = this['title'].charAt(0).toUpperCase() + this['title'].slice(1);
							if(this['title'] == 'Record not Found'){
								$("#searchultop").append("<li><a href='javascript:void(0);'>" + title + "</a></li>");
							}else{
								$("#searchultop").append("<li><a href="+ url + ">" + title + "</a></li>");
							}
							
							}); 
					}
					 ajaxReq = null; 		
				}
			});
			
		}
	});
	
	
});

