@extends('admin.layouts.main')


@section('style')
  <link rel="stylesheet" href="{{ asset('public/vendor/select2/css/select2.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/select2-bootstrap-theme/select2-bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/datatables/media/css/dataTables.bootstrap4.css')}}" />
@endsection

@section('content')
  <section role="main" class="content-body">
      <header class="page-header">
        <h2>Orders List</h2>
      
        <div class="right-wrapper text-right">
          <ol class="breadcrumbs">
            <li>
              <a href="{{url('/admin/dashboard')}}">
                <i class="fa fa-home"></i>
              </a>
            </li>
            <li><span>Dashboard</span></li>
            <li><span>Orders List</span></li>
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
                  <a class="btn btn-primary" href="{{url('admin/orders/export/xls')}}" > Export XLS </a>
                   <a class="btn btn-primary" href="{{url('admin/orders/export/csv')}}"  > Export CSV </a>
                </div>
                <table class="table table-bordered table-striped mb-0" id="datatable-default">
                  <thead>
                     <tr>
                          <th>#</th>
                          <th>Email</th>
                          <th>Total Items</th>
                          <th>Ammount</th>
                          <th>Payment Getway</th>
                          <th>Transaction id</th>
                          <th>Payment Status</th>
                          <th>Created On(dd-mm-yy)</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($orders as $key => $order)
                      <tr>
                      <th scope="row">{{$order->id}}</th>
                      <td>{{$order->user->email}}</td>
                      <td>{{count($order->items)}}</td>
                      <td>{{$order->amount}}</td>
                      <td><label class="label label-primary">{{$order->payment_getway}}</label></td>
                      <td>{{ $order->transaction_id }}</td>
                      <?php 
                        if($order->status == 'pending'){
                          $status = 'warning'; 
                        }elseif($order->status == 'canceled'){
                          $status = 'danger'; 
                        }elseif ($order->status == 'complete') {
                          $status = 'success'; 
                        }else{
                          $status = 'danger';
                        }
                       ?>
                      <td>
                        <label class="label label-{{$status}}"> {{$order->status}} </label>
                      </td>
                      <td>{{date('d-m-Y',strtotime($order->created_at))}}</td>
                      <td> 
                          <a href="{{'orders/'.$order->id}}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                          </a>
                          <a href="" class="delete" onclick="" id="{{$key}}">
                            <i class="fa fa-remove" aria-hidden="true"></i>
                          </a>
                          <form action="{{action('OrderController@destroy',['id' => $order->id])}}" method="POST" id="delete-form-{{$key}}">
                              @method('DELETE')
                               @csrf
                          </form>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                <div style="float: right; padding: 10px;">
                 {{ $orders->links() }} 
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
  <!--   <script src="{{ asset('public/js/examples/examples.datatables.default.js')}}"></script> -->
<script type="text/javascript">
  
$(document).ready(function(){

     
  var active_link = 0;
  active_nav_links(9,active_link);


    $(".delete").on('click',function(event){
       event.preventDefault();
       var id = this.id;
       
      // 
       $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete this order!',
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




