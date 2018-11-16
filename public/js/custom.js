/* Add here all your JS customizations */
/*
  Create by Sandeep rathour
*/
function active_nav_links(li_index,child_index = null) {
	// body...
	$('#menu ul li').removeClass('nav-expanded nav-active');
	//console.log(li_index);

	var selected_nav = $( "#menu ul li:eq("+li_index+")" ); 

	if(child_index != null){
		selected_nav.addClass('nav-expanded nav-active');
		selected_nav.find("ul li:eq("+child_index+")").addClass('nav-active');
	}else{
		selected_nav.addClass('nav-active');
	}
}

function success_msg(message) {
	// body...
	  $.alert({
	    title: 'Success',
	    icon: 'fa fa-success',
	    type: 'green',
	    content: message,
	  });
}

   function get_unread_orders(){
                        $.ajax({
                            method: 'POST', // Type of response and matches what we said in the route
                            url: BASE_URL+"/admin/get_unread_orders", // This is the url we gave in the route
                            data: {'get_orders' : 1 , '_token' :  $('meta[name="csrf-token"]').attr('content')}, // a JSON object to send back
                            success: function(response){ // What to do if we succeed
                           
                            $('.get_orders.badge').html(response.orders_count);
                            var html = '';
                            if(response.orders_lists.length >0){
	                            $.each(response.orders_lists,function(inx,val){
	                            	if ( val.userimage === null || val.userimage === ''  ){
	                                    var avatar = BASE_URL+'/public/images/avatar/'+val.userimage;
	                                }else{
	                                    var avatar = BASE_URL+'/public/img/!sample-user.jpg';
	                                }
	                                html += '<li><a href="'+BASE_URL+'/admin/orders/'+val.id+'" class="clearfix"><figure class="image"><img src="'+avatar+'" alt="Image" class="rounded-circle" /></figure><span class="title">Order #'+val.id+'<span class="message">'+val.username+'</span><span class="message">'+timing(new Date(val.created_at))+'</span></a></li>';

	                            });
	                            $('.get_orders.badge').fadeIn('slow');
	                        }else{
	                        	html = 'No New Order ';
	                        	$('.get_orders.badge').fadeOut('slow');
	                        }
                            $('ul#order_notify_list').html(html);
                            },
                            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                                console.log(JSON.stringify(jqXHR));
                                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                            }
                        });
                }
                
                function get_notifications(){
                        $.ajax({
                            method: 'POST',
                            url: BASE_URL+"/admin/get_notifications",
                            data: {'get_notifications' : 1 , '_token' :  $('meta[name="csrf-token"]').attr('content') }, 
                            success: function(response){ // What to do if we succeed
                                $('.get_notification.badge').html(response.notifications_count);
                                var html = '';
                                if(response.notifications_lists.length > 0){
	                                 $.each(response.notifications_lists,function(inx,val){
                                    if (val.userimage === null || val.userimage === ''  ){
		                            	    var avatar = BASE_URL+'/public/images/avatar/'+val.userimage;
		                                }else{
		                                    var avatar = BASE_URL+'/public/img/!sample-user.jpg';
		                                }

	                                    html += '<li><a href="'+BASE_URL+'/admin/notifications/'+val.id+'" class="clearfix"><div class="image"><figure class="image"><img src="'+avatar+'" alt="'+val.id+'" class="rounded-circle" /></figure></div><span class="title">'+val.message+'</span><span class="message">'+timing(new Date(val.created_at))+'</span></a></li>';
		                            });
	                                 $('.get_notification.badge').fadeIn('slow');

	                             }else{
                                    html = 'No Notification.';
                                    $('.get_notification.badge').fadeOut('slow');
                                }

                                $('ul#notifications_notify_list').html(html);
                            },
                            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                                console.log(JSON.stringify(jqXHR));
                                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                            }
                        });
                }
                
                function timing(a) {
                        var s = Math.floor((new Date() - a) / 1000),
                            i = Math.floor(s / 31536000);
                        if (i > 1) {
                            return i + " yrs ago"
                        }
                        i = Math.floor(s / 2592000);
                        if (i > 1) {
                            return i + " mon ago"
                        }
                        i = Math.floor(s / 86400);
                        if (i > 1) {
                            return i + " dys ago"
                        }
                        i = Math.floor(s / 3600);
                        if (i > 1) {
                            return i + " hrs ago"
                        }
                        i = Math.floor(s / 60);
                        if (i > 1) {
                            return i + " min ago"
                        }
                        return (Math.floor(s) > 0 ? Math.floor(s) + " sec ago" : "just now")
             }

