@extends('backend.include.backendapp')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activation Request</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Users</a></li>
              <li class="breadcrumb-item active">Activation Request</li>
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
              {{-- <div class="card-header">
                <h3 class="card-title">Activation Request List</h3>
              </div> --}}
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Request date</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($user_details as $user_details)
                  <tr>
                    <td>{{ $user_details->name }} {{ $user_details->lastname }}</td>
                    <td>{{ $user_details->phone }}</td>
                    <td>{{ $user_details->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($user_details->account_activation_request_date)->format('Y/m/d') }}</td>
                    <td><a href="{{ route('adminusers.edit', $user_details->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a></td>
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