@extends('admin.layouts.main')


@section('style')
  <link rel="stylesheet" href="{{ asset('public/vendor/select2/css/select2.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/select2-bootstrap-theme/select2-bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/datatables/media/css/dataTables.bootstrap4.css')}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
  <section role="main" class="content-body">
      <header class="page-header">

        <h2 style="width: 30%">Gateway List
        </h2>

      
        <div class="right-wrapper text-right">
          <ol class="breadcrumbs">
            <li>
              <a href="{{url('/admin/dashboard')}}">
                <i class="fa fa-home"></i>
              </a>
            </li>
          </ol>
      
          <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
      </header>

      <!-- start: page -->
        <div class="row">
          <div class="col">
            <section class="card">
              <header class="card-header">
                <!--div class="card-actions">
                  <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                  <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                </div-->
        
                <h2 class="card-title"></h2>
              </header>
              <div class="card-body">
                <table class="table table-bordered table-striped mb-0" id="datatable-default">
                  <thead>
                     <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Action</th>
						  <th class="">Configure</th>
                      </tr>
                  </thead>
                  <tbody>
						@php 
						$j = 0; 
						$i = 1;
						$activated_gateway = array();
						@endphp
						@foreach($gateway_enabled as $gateways)
							@php $activated_gateway[$j] = $gateways->name;
						$j++;	
						@endphp
						@endforeach
						@php @endphp
                      @foreach($gateway_array as $gatewayname)
                      <tr>
                      <th scope="row">{{$i}}</th>
                      <td>{{$gatewayname}}</td>
                     <td><label class="switch">
                          @if (in_array($gatewayname, $activated_gateway))
					        <input value="{{$gatewayname}}" class="" type="checkbox" checked disabled>
					      @else
					        <input value="{{$gatewayname}}" class="" type="checkbox" disabled>
					      @endif
					  <span class="slider round"></span> 
					</label></td>
                      <td> 
                    @if (in_array($gatewayname, $activated_gateway))
                          <a href="javascript:;" data-toggle="collapse" data-target="#{{$gatewayname}}gateway"  data-name="{{$gatewayname}}" onclick="getconfiguration(this)" class="configure_button">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                          </a>
                    @else
                     <a href="" class="configure_button" style="display:none";>
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                          </a>
                    @endif
                      </td>
                    </tr>
					<tr>
					<td colspan="5">
					 <div id="{{$gatewayname}}gateway" class="collapse">
						  </div>
						  </td>
					</tr>
                     	@php $i++; @endphp
                    @endforeach
                </tbody>
                </table>
              </div>
            </section>
          </div>
        </div>

          <!-- end: page -->
  </section>
@endsection

@section('script')
    <!-- Specific Page Vendor -->
    <script src="{{ asset('public/vendor/select2/js/select2.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/media/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js')}}"></script>
    
    <!-- Examples -->
<!--     <script src="{{ asset('public/js/examples/examples.datatables.default.js')}}"></script> -->
<script type="text/javascript">
function setconfiguration(submitbut){
    var gatewayName = $(submitbut).attr('id');
    var formdata = [];
    var gatewayname = [gatewayName];
    $('#'+gatewayName+'gateway input').each(function(){
       var key =  $(this).attr('id');
       var value = $(this).val();
       var type =  $(this).attr('type');
    formdata.push({
            key: key,
            value: value,
            type: type
    });
      // console.log(formdata); 
    });
    	$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		})
	$.ajax({
        method: 'POST', // Type of response and matches what we said in the route
        url: 'save_gateway_configuration', // This is the url we gave in the route
        data: {'formdata' : formdata,'gatewayname' : gatewayname}, // a JSON object to send back
        success: function(response){ // What to do if we succeed
            location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
}
  function getconfiguration(clickbut){
     // console.log(clickbut);
   var this_name = $(clickbut).attr('data-name');
   var getid =  $(clickbut).attr('data-target');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$.ajax({
        method: 'POST', // Type of response and matches what we said in the route
        url: 'get_gateway_configuration', // This is the url we gave in the route
        data: {'gateway_name' : this_name}, // a JSON object to send back
        success: function(response){ // What to do if we succeed
        $(getid).html(response);
            //console.log(response); 
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
}
$(document).ready(function(){
    setTimeout(function(){
         $(".switch input").prop("disabled", false);
    },500);
$('.switch input').click(function(){
    $(".switch input").prop("disabled", true);
		var gateval = $(this).val();
	if ($(this).is(':checked')) {
		var status = 'activated';
		$('.configure_button').fadeIn( 1000);
	}else{
		var status = 'deactivated';
		$('.configure_button').fadeOut( 1000 );
	}
	$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		})
	$.ajax({
    method: 'POST', // Type of response and matches what we said in the route
    url: 'change_gateway_status', // This is the url we gave in the route
    data: {'gateval_name' : gateval,'status' : status}, // a JSON object to send back
    success: function(response){ // What to do if we succeed
       location.reload();
    },
    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        console.log(JSON.stringify(jqXHR));
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
});
});
     
  var active_link = 0;
  active_nav_links(9,active_link);


    $(".delete").on('click',function(event){
       event.preventDefault();
       var id = this.id;
       
       $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete this getway?',
        buttons: {
            confirm: function () {
               document.getElementById('delete-form-'+id).submit();
            },
            cancel: function () {
                $.alert('Canceled!');
            }
        }
    });

    });
});

</script>
@endsection




