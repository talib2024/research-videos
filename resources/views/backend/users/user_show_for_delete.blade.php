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
            <h1>User Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('adminusers.index') }}">Users</a></li>
              <li class="breadcrumb-item active">User Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">       

        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">User details</h3>
            @if(session()->has('success'))
              <div class="alert alert-success">
                  {{ session()->get('success') }}
              </div>
            @endif
          </div>
          <!-- /.card-header -->
          <div class="card-body">
                 @include('backend.users.users_details')  
                 {{-- Start If user given request for deletion and user is not deleted yet. --}}
                 @if($user_details->status == '1' && $user_details->account_deletion_request == '1' && empty($user_details->account_deleted_by))  
                   <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label red">Delete Request Date</label>
                           <input class="form-control border-form-control" value="{{ \Carbon\Carbon::parse($user_details->account_deletion_request_date)->format('Y/m/d') }}" placeholder="Delete Request Date" type="text" readonly disabled>
                        </div>
                     </div>                     
                  </div>              
                  <div class="row">
                     <div class="col-sm-12 text-center">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-user">Delete this user</button>
                     </div>
                  </div>
                 {{-- End If user given request for deletion and user is not deleted yet. --}}

                  {{-- Start If user is deleted. --}}
                 @elseif($user_details->status == '0' && $user_details->account_deletion_request == '1' && !empty($user_details->account_deleted_by))  
                   <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label red">Delete Request Date</label>
                           <input class="form-control border-form-control" value="{{ \Carbon\Carbon::parse($user_details->account_deletion_request_date)->format('Y/m/d') }}" placeholder="Delete Request Date" type="text" readonly disabled>
                        </div>
                     </div>  
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label red">Deleted By</label>
                           <input class="form-control border-form-control" value="{{ $user_details->deleted_by_name }}" placeholder="Delete Request Date" type="text" readonly disabled>
                        </div>
                     </div>    
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label red">Deletion Date</label>
                           <input class="form-control border-form-control" value="{{ \Carbon\Carbon::parse($user_details->account_deletion_date)->format('Y/m/d') }}" placeholder="Delete Request Date" type="text" readonly disabled>
                        </div>
                     </div>                     
                  </div>              
                  <div class="row">
                     <div class="col-sm-12 text-center">
                        <a href="{{ route('adminusers.edit', $user_details->id) }}" class="btn btn-primary">Edit this user</a>
                     </div>
                  </div>
                 {{-- End If user is deleted. --}}

                 @else
                  {{-- Start Other than delete process. --}}
                    <div class="row">
                     <div class="col-sm-12 text-center">
                        <a href="{{ route('adminusers.edit', $user_details->id) }}"" class="btn btn-primary">Edit this user</a>
                     </div>
                  </div>
                  {{-- End Other than delete process. --}}

            
                @endif
          
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

   <div class="modal fade" id="modal-delete-user">
        <div class="modal-dialog">
        <form action="{{ route('adminusers.destroy', $user_details->id) }}" method="POST">
              <input type="hidden" name="_method" value="DELETE">
              @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete!</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure to delete this user?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Yes</button>
            </div>
          </div>
        </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
@endsection