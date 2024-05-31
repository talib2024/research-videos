@extends('backend.include.backendapp')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Payment List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Payment</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">           

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Product Type</th>
                    <th>Transaction Type</th>
                    <th>Transaction Id</th>
                    <th>Payment Status</th>
                    <th>Amount</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($payment_details as $payment_details)
                  <tr>
                    <td>{{ $payment_details->users_name }} {{ $payment_details->users_lastname }}</td>
                    <td>{{ $payment_details->users_email }}</td>
                    <td>{{ $payment_details->item_type }}</td>
                    <td>{{ $payment_details->transaction_type }}</td>
                    <td>{{ $payment_details->transaction_id }}</td>
                    <td>{!! $payment_details->is_payment_done == 1 ? 'Payment Done' : '<span class="red">Payment Pending</span>' !!}</td>
                    <td>{{ $payment_details->amount }}</td>
                    <td>
                    <a href="{{ route('check.payment.details',$payment_details->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                    </td>
                  </tr> 
                  @endforeach              
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection