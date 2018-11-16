@extends('admin.layouts.main')


@section('style')
  <link rel="stylesheet" href="{{ asset('public/vendor/select2/css/select2.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/select2-bootstrap-theme/select2-bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/datatables/media/css/dataTables.bootstrap4.css')}}" />
@endsection

@section('content')
  <section role="main" class="content-body">
      <header class="page-header">
        <h2 style="width: 27%">Notification List
          <button class="mb-1 mt-1 mr-1 btn btn-sm btn-primary" id="send-notification" style="float: right; margin-top: 10px !important;">Send Notification</button>
        </h2>
      
        <div class="right-wrapper text-right">
          <ol class="breadcrumbs">
            <li>
              <a href="{{url('/admin/dashboard')}}">
                <i class="fa fa-home"></i>
              </a>
            </li>
            <li><span>Dashboard</span></li>
            <li><span>Notification List</span></li>
          </ol>
      
          <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
      </header>

      <!-- start: page -->
        <div class="row">
          <div class="col">
            <section class="card">
              <header class="card-header">
                <div class="card-actions">
                  <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                  <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                </div>
        
                <h2 class="card-title"></h2>
              </header>
              <div class="card-body">
                <table class="table table-bordered table-striped mb-0" id="datatable-default">
                  <thead>
                     <tr>
                          <th>#</th>
                          <th>Title</th>
                          <th>Discription</th>
                          <th>Created On</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
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
    <script src="{{ asset('public/vendor/datatables/extras/TableTools/JSZip-2.5.0//jszip.min.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js')}}"></script>
    <script src="{{ asset('public/vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js')}}"></script>
    
    <!-- Examples -->
    <script src="{{ asset('public/js/examples/examples.datatables.default.js')}}"></script>
<script type="text/javascript">
  
  var users = @json($users);
  
  var options='<option value="">All Users</option>';

  $.each(users,function(inx,value){
    options+='<option value="'+value.id+'">'+value.name+'</option>';
  });


$(document).ready(function(){

  var active_link = 0;
  active_nav_links(10,active_link);

$(".delete").on('click',function(event){
       event.preventDefault();
       var id = this.id;
       
      // 
       $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete this topic!',
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



$('#send-notification').on('click',function(){

   $.confirm({
        title: 'Send Notification',
        content: '' +
        '<form action="" class="formName" id="add_user_form" >' +
        '<div class="form-group">' +
        '<label>Send To *</label>' +
        '<select id="all-users" name="send_to[]"  class="form-control"/ multiple>'+
        '</select>'+
        '<span class="invalid-feedback error_name" role="alert"></span>' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Message *</label>' +
        '<textarea placeholder="Message" class="form-control" required /></textarea><span class="invalid-feedback error_email" role="alert"></span>' +
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var user_name = this.$content.find('.name').val();
                    var email = this.$content.find('.email').val();
                    var password = this.$content.find('.password').val();

                    if(!user_name){
                        $.alert('please provide a valid user name');
                        return false;
                    }

                    if((email.trim().length <= 0)  || (isEmail(email) == false ) ){
                        $.alert('please provide a valid email');
                        return false;
                    }

                    if(!password ){
                        $.alert('please provide a password');
                        return false;
                    }

                    if(password.trim().length < 8 ){
                        $.alert('password must be 8 character long');
                        return false;
                    }
                    
                    $.ajax({
                       // url: "<?php //echo action('UserController@register') ?>",
                        url : '/uncomment-upper-line',
                        type: "POST",
                        data: $('#add_user_form').serialize(),
                        dataType : 'json',
                        success:function(res) {
                          if(res.status){
                               js.close();
                               $.alert(res.message);
                               return false;
                          }else{
                            $.each(res.errors,function(inx,er){
                              $('.error_'+inx).html('<strong>'+er[0]+'</strong>');
                            });
                          }
                        }
                      });
              return false;

                }
            },
            cancel: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('#all-users').append(options);
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
});

// end document 
});

</script>
@endsection




