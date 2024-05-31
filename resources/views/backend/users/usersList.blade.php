@extends('backend.include.backendapp')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registered Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Registered Users</li>
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
                <h3 class="card-title">Registered Users List</h3>
              </div> --}}
              <!-- /.card-header -->
              @if (session('success'))
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                        </div>
                    </div>
                @endif
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($user_details as $user_details)
                  <tr>
                    <td>{{ $user_details->name }} {{ $user_details->last_name }}</td>
                    <td>{{ $user_details->phone }}</td>
                    <td>{{ $user_details->email }}</td>
                    <td>{!! $user_details->status == 1 ? 'Active' : '<span class="red">Deleted</span>' !!}</td>
                    <td>
                    {{-- <a href="{{ route('adminusers.show', $user_details->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('adminusers.edit', $user_details->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a> --}}
                    <a href="{{ route('adminusers.show', $user_details->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('adminusers.edit', $user_details->id) }}" class="btn btn-info">Edit</a>
                    <a href="{{ route('users.rvcoins', $user_details->id) }}" class="btn btn-info">RVcoins</a>
                    <a href="{{ route('users.video.assigned', $user_details->id) }}" class="btn btn-info">Video assigned</a>
                    <a href="{{ route('statictics.report.admin', [$user_details->id,$user_details->email]) }}" class="btn btn-info">Statistics report</a>
                    @if(empty($user_details->email_verified_at))
                      <form method="POST" action="{{ route('send.verifcation.link', [$user_details->id]) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" title="Send verification link" onclick="return confirm('Are you sure you want to send verification link?')">Send verification link</button>
                        </form>
                    @else
                      <a class="btn btn-success">Already verified</a>
                    @endif
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