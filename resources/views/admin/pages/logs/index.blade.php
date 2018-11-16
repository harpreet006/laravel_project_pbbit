@extends('admin.layouts.main')


@section('style')
  <link rel="stylesheet" href="{{ asset('public/vendor/select2/css/select2.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/select2-bootstrap-theme/select2-bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/datatables/media/css/dataTables.bootstrap4.css')}}" />
@endsection

@section('content')
  <section role="main" class="content-body">
      <header class="page-header">
        <h2>Logs List</h2>
      
        <div class="right-wrapper text-right">
          <ol class="breadcrumbs">
            <li>
              <a href="{{url('/admin/dashboard')}}">
                <i class="fa fa-home"></i>
              </a>
            </li>
            <li><span>Dashboard</span></li>
            <li><span>Logs List</span></li>
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
                <div>
                  <a class="btn btn-danger delete" href="{{url('admin/logs/all/clear')}}" > Clear All Logs </a>
                </div>
                <table class="table table-bordered table-striped mb-0" id="datatable-default">
                  <thead>
                     <tr>
                          <th>#</th>
                          <th>Email</th>
                          <th>IP</th>
                          <th>Log Message</th>
                          <th>Action type</th>
                          <th>Agent</th>
                          <th>Created On(dd-mm-yy)</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($logs as $key => $log)
                      <tr>
                      <th scope="row">{{$log->id}}</th>
                      <td>{{@$log->user->email}}</td>
                      <td>{{$log->ip}}</td>
                      <td>{{$log->log}}</td>
                      <?php 
                        if($log->action_type == 'update'){
                          $status = 'warning'; 
                        }elseif($log->action_type == 'delete'){
                          $status = 'danger'; 
                        }elseif ($log->action_type == 'create') {
                          $status = 'success'; 
                        }else{
                          $status = 'danger';
                        }
                       ?>
                      <td>
                        <label class="label label-{{$status}}"> {{($log->action_type)??'Unknown'}} </label>
                      </td>
                      <td>
                        {{$log->client}}
                      </td>
                      <td>{{date('d-m-Y',strtotime($log->created_at))}}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                <div style="float: right; padding: 10px;">
                 {{ $logs->links() }} 
                </div>
              </div>
            </section>
          </div>
        </div>

          <!-- end: page -->
  </section>
@endsection

@section('script')
<script type="text/javascript">
  
$(document).ready(function(){
     
  var active_link = 2;
  active_nav_links(11,active_link);


 $(".delete").on('click',function(event){
       event.preventDefault();
       var id = this.id;
      // 
       $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete all Log!',
        buttons: {
            confirm: function () {
               window.location.href = "<?php echo url('admin/logs/all/clear') ?>";
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




