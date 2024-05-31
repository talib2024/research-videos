@extends('backend.include.backendapp')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>All institution request</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Institute management</li>
              <li class="breadcrumb-item active">All institution request</li>
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
                    <th>Institution Name</th>
                    <th>Institution Representative Email</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($institutionrequest as $institutionrequest_record)
                  <tr>
                    <td>{{ $institutionrequest_record->name }}</td>
                    <td>{{ $institutionrequest_record->affiliation }}</td>
                    <td>{{ $institutionrequest_record->email }}</td>
                    <td>
                    <a href="{{ route('all.institution.request.view', $institutionrequest_record->id) }}" class="btn btn-info">View</a>
                   
                        <form method="POST" action="{{ route('all.institution.request.delete', $institutionrequest_record->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                        </form>
                    
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