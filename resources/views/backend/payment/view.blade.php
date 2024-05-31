@extends('backend.include.backendapp')
@section('content')
<style>
  .form-group {
    display: flex;
    flex-direction: column;
  }
  .form-group label {
    margin-bottom: 5px;
  }
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Payment Detail Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('all.payment.list') }}">Payment</a></li>
              <li class="breadcrumb-item active">Payment Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">       
        @if (session('success'))
            <div class="col-lg-10 successDiv">
                <div class="alert alert-success" role="alert">
                    Updated successfully!
                </div>
            </div>
        @endif
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Payment detail form</h3>
          </div>
          
            <div class="col-lg-12 successDiv" style="display:none;">
                <div class="alert alert-success" role="alert">
                    Updated successfully!
                </div>
            </div>
          <!-- /.card-header -->
          <div class="card-body">
          <form action="{{ route('update.payment') }}" method="POST">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">First Name</label>
                           <input type="hidden" value="{{ $payment_details->id }}" name="payment_id" id="payment_id">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input class="form-control border-form-control" value="{{ $payment_details->users_name }}" placeholder="First Name" readonly disabled>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Surname</label>
                           <input class="form-control border-form-control" value="{{ $payment_details->users_lastname }}" placeholder="Surname" readonly disabled>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Email Address</label>
                           <input class="form-control border-form-control" value="{{ $payment_details->users_email }}" placeholder="Email Address"  readonly disabled="">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Amount</label>
                           <input class="form-control border-form-control" value="{{ $payment_details->amount }}" placeholder="Email Address"  readonly disabled="">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Product Type</label>
                           <input class="form-control border-form-control" value="{{ $payment_details->item_type }}"  readonly disabled="">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">transaction Type</label>
                           <input class="form-control border-form-control" value="{{ $payment_details->transaction_type }}"  readonly disabled="">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Transaction ID</label>
                           <input class="form-control border-form-control" value="{{ $payment_details->transaction_id }}"  readonly disabled="">
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Uploaded Date</label>
                           <input class="form-control border-form-control" value="{{ \Carbon\Carbon::parse($payment_details->created_at)->format('Y/m/d') }}"  readonly disabled="">
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Payment Status</label>
                           <input class="form-control border-form-control" value="{{ $payment_details->is_payment_done == 1 ? 'Payment Done' : 'Payment Pending' }}"  readonly disabled="">
                        </div>
                     </div>
                  </div>
                 
                @if($payment_details->transaction_type == 'wire_transfer' && $payment_details->is_payment_done == '0')
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Payment Receipt</label>
                           <a href="{{ asset('storage/uploads/wire_transfer_receipt/'.$payment_details->transaction_receipt) }}" target="_BLANK">Payment Receipt</a>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary">Update Payment</button>
                     </div>
                  </div>
                @endif
               </form>
          
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         
        </div>
        <!-- /.card -->


      
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection