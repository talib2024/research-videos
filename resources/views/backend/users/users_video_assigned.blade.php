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
            <h1>Video assigned</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('adminusers.index') }}">Users</a></li>
              <li class="breadcrumb-item active">Video assigned</li>
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
            <h3 class="card-title">Video assigned</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">First Name</label>
                           <input class="form-control border-form-control" value="{{ $user_details->name }}" placeholder="First Name" type="text" name="name" id="name" readonly disabled>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Surname</label>
                           <input class="form-control border-form-control" value="{{ $user_details->last_name }}" placeholder="Surname" type="text" name="last_name" id="last_name" readonly disabled>
                        </div>
                     </div>
                  </div>
                  
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Registration Email</label>
                           <input class="form-control border-form-control" value="{{ $user_details->email }}" placeholder="Institute Name" type="text" name="institute_name" id="institute_name" readonly disabled>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Registration Date</label>
                           <input class="form-control border-form-control" value="{{ \Carbon\Carbon::parse($user_details->created_at)->format('Y/m/d') }}" placeholder="Position" type="text" name="position" id="position" readonly disabled>
                        </div>
                     </div> 
                  </div>

                  <div class="row">
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label class="control-label">View Role</label>
                              <select class="form-control border-form-control" id="roleSelect" style="width: 100%;">
                                <option value="">Select</option>
                                  @foreach ($roles as $role)
                                      <option value="{{ $role->role_id }}" {{ Session::has('loggedin_role') && Session::get('loggedin_role') == $role->role_id ? 'selected' : '' }}>{{ $role->role }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div> 
                  </div>
                
          
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         
        </div>
        <!-- /.card -->

        {{-- @if($user_role_id == '3' && isset($editor_role) && $editor_role->editorrole_id == '1')
            @include('frontend.editor.editor_account') --}}
        @if($user_role_id == '2')
            @include('backend.author.author_account')      
        @elseif($user_role_id == '3' && isset($editor_role) && $editor_role->editorrole_id == '2')
            @include('backend.editor.editor_member_account')
        @elseif($user_role_id == '4')
            @include('backend.reviewer.reviewer_account')
        @elseif($user_role_id == '5')
            @include('backend.publisher.publisher_account')
        @elseif($user_role_id == '7')
            @include('backend.correspondingauthor.correspondingauthor_account')            
        @endif

      
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@push('pushjs')
<script>
    $('#roleSelect').on('change', function() {
        var roleId = $(this).val(); // Get selected role ID from the dropdown
        $.ajax({
            method: 'POST',
            url: '{{ route('change.userrole.admin') }}',
            data: {
                role_id: roleId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                window.location.href = "{{ route('users.video.assigned', $user_details->id) }}";
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>

@endpush