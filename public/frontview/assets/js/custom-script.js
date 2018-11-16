$(document).ready(function(){
	$('html').click(function(e){
		if (e.target.id == 'hsearch') {
		} else {
			$("#hsearch").hide('slow');	
			$(".searchul").hide('slow');	
		}	
	});
	
$( "#navbarDropdownCourse,#navbarDropdowncoursediv" ).mouseover(function() {
   $('#navbarDropdowncoursediv').show();
  }).mouseout(function() {
   $('#navbarDropdowncoursediv').hide();
  });
  
  $( "#navbarDropdownTopics,#navbarDropdownTopicsdiv" ).mouseover(function() {
   $('#navbarDropdownTopicsdiv').show();
  }).mouseout(function() {
   $('#navbarDropdownTopicsdiv').hide();
  });
	

	
	

	/*course package  page popup*/
	$(".coursepackage").click(function(){ 
		$('#coursesection').modal('show');
	});

	$(".cross_img_package").click(function(){
		$('#coursesection').modal('hide');
	});

          /*course package  page popup*/

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
	$("#beginnercourse").click(function(){
		$("#navbarDropdowncoursediv").css("display","block");   
		$('#beginner').css("display","block");
		$('#intermediate').css("display","none");
		$('#advance').css("display","none");
	});
	$("#intermediatecourse").click(function(){
		$("#navbarDropdowncoursediv").css("display","block"); 
		$('#beginner').css("display","none");
		$('#intermediate').css("display","block");
		$('#advance').css("display","none");
		 
	});
	$("#advancecourse").click(function(){
		$("#navbarDropdowncoursediv").css("display","block"); 
		$('#beginner').css("display","none");
		$('#intermediate').css("display","none");
		$('#advance').css("display","block");
		 
	});


	 $('.packagepbit input[type="checkbox"]').click(function(){			
            var totalprice = 0;
            var arrText= new Array();
			$('.packagepbit input[type="checkbox"]:checked').each(function() {				
				    totalprice = totalprice + parseFloat(this.value);
				    
				    arrText.push($( this ).attr('course-id'));
			});
			//console.log( totalprice ); // 15
			if(totalprice){}
			$('.rates-star').html('<span>$</span>'+totalprice);
			$('#add_package_list').val(arrText);		         

		})
         var totalprice = 0;
         var arrText= new Array();
	     $('.packagepbit input[type="checkbox"]:checked').each(function() {				
				    totalprice = totalprice + parseFloat(this.value);
				     arrText.push($( this ).attr('course-id'));				  
			});
			//console.log( totalprice ); // 15
			if(totalprice){$('.rates-star').html('<span>$</span>'+totalprice);}
			$('#add_package_list').val(arrText);
 
	$("#opensearchh").click(function(event) {    
		$( "#hsearch" ).toggle( "slow", function() { 
	    });
		event.stopPropagation();
	});
	

	$(".ration-section label").click(function(event) { 
	    var currentrating = $(this).attr('ratingact');   
	  	$.ajax({
	  	              url: BASE_URL+"/rating",
	                  method: 'POST',
	                  data: {
	                     _token: $('input[name="_token"]').attr('value'),
	                    rating: currentrating,                                                    
	                    productid: $('input[name="productid"]').attr('value')                                  
	                  },
	                  success: function(result){	                  	
	                  }
	            }); 
	});
	

});
 