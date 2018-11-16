@extends('admin.layouts.main')


@section('style')
  <link rel="stylesheet" href="{{ asset('public/vendor/select2/css/select2.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/select2-bootstrap-theme/select2-bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/datatables/media/css/dataTables.bootstrap4.css')}}" />
@endsection

@section('content')
  <section role="main" class="content-body">
      <header class="page-header">
        <h2 style="width:20%">
          Users List
          <button class="mb-1 mt-1 mr-1 btn btn-sm btn-primary" id="add-user" style="float: right; margin-top: 7px !important;">Add User</button>
        </h2>
      
        <div class="right-wrapper text-right">
          <ol class="breadcrumbs">
            <li>
              <a href="{{url('/admin/dashboard')}}">
                <i class="fa fa-home"></i>
              </a>
            </li>
            <li><span>Dashboard</span></li>
            <li><span>Users List</span></li>
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
                <form method="get" >
                  <div class="form-group row" >
                        <div class="col-lg-3">
                            <div class="input-group btn-group">
                              <span class="input-group-addon">
                                Search In
                              </span>
                              <select class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }' id="multipleSelect" name="column[]">
                                <option value="name">Name</option>
                                <option value="email">Email</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <input class="form-control" type="search"  name="search_str"  placeholder="Search" value="{{ Request::get('search_str') }}" />
                        </div>
                        <div class="col-lg-2">
                              <input class="btn btn-primary" type="submit" value="Search"/>
                        </div>
                  </div>
                </form>
                <table class="table table-bordered table-striped mb-0" id="datatable-default">
                  <thead>
                     <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Status</th>
                          <th>Notification</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($users as $key =>  $user)
                      <tr>
                      <th scope="row">{{$user->id}}</th>
                      <td>{{$user->name}}</td>
                      <td>{{$user->email}}</td>
                      <td>
                        <label class="label label-{{ ($user->status == 'active')?'success':'danger' }} change_user_status" id="{{$user->id}}"> {{$user->status}} </label>
                      </td>
                      <td>
                        <label class="label label-{{ ($user->enable_notification)?'success':'danger' }}"> {{ ($user->enable_notification)?'Enable':'Disable' }} </label>
                      </td>
                      <td>
                        <?php 
                        $view_url = '';
                        ?>
                          <a href="{{'users/'.$user->id}}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                          </a>
                          <a href="" class="delete" onclick="" id="{{$key}}">
                            <i class="fa fa-remove" aria-hidden="true"></i>
                          </a>
                          <form action="{{action('UserController@destroy',['id' => $user->id])}}" method="POST" id="delete-form-{{$key}}">
                              @method('DELETE')
                               @csrf
                          </form>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                 <div style="float: right; padding: 10px;">
                 {{ $users->links() }} 
                </div>
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
    <!-- Multi Select -->
     <script src="{{ asset('public/vendor/bootstrap-multiselect/bootstrap-multiselect.js')}}"></script>
<script type="text/javascript">
  
$(document).ready(function(){

var Default_value = @json(Request::get('column'));
$('#multipleSelect').val(Default_value);

  var active_link = 0;
  active_nav_links(1,active_link);


  $(".delete").on('click',function(event){
       event.preventDefault();
       var id = this.id;
      // 
       $.confirm({
        title: 'Confirm!',
        content: '<b>Are you sure to delete this user!</b>',
        buttons: {
            confirm: function () {
               document.getElementById('delete-form-'+id).submit();
            },
            cancel: function () {
                $.alert('<b>Canceled!</b>');
            }
        }
    });
  });


$(".change_user_status").on('click',function(event){
       event.preventDefault();
       var id = this.id;
       var status = 'active';
       if($(this).text().trim() == 'active'){
        status = 'inactive';
       }
       $.confirm({
        title: 'Confirm!',
        content: '<b>Are you sure to '+status+' this user!<b>',
        buttons: {
            confirm: function () {
               window.location.href = "<?php echo url('/admin/users/status') ;?>/"+id+'/'+status;
            },
            cancel: function () {
                $.alert('<b>Canceled!</b>');
            }
        }
    });
  });


$('#add-user').on('click',function(){

  var js =    $.confirm({
        title: 'Add New User!',
        content: '' +
        '<form action="" class="formName" id="add_user_form" >' +
        '<div class="form-group">' +
        '<label>Name *</label>' +
        '<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" >'+
        '<input type="text" placeholder="Your Name" name="name" class="name form-control" required /><span class="invalid-feedback error_name" role="alert"></span>' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Email *</label>' +
        '<input type="email" placeholder="Your Email" name="email" class="email form-control" required /><span class="invalid-feedback error_email" role="alert"></span>' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Password *</label>' +
        '<input type="text" placeholder="Your Password" name="password" class="password form-control" required /><span class="invalid-feedback error_password" role="alert"></span>' +
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
                        url: "<?php echo action('UserController@register'); ?>",
                        //url : '/uncomment-upper-line',
                        type: "POST",
                        data: $('#add_user_form').serialize(),
                        dataType : 'json',
                        success:function(res) {
                          if(res.status){
                               js.close();
                               location.reload();
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
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
});


    // document end 
});

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

</script>
@endsection




