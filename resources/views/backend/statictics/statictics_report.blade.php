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
            <h1>Statistics Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('adminusers.index') }}">Users</a></li>
              <li class="breadcrumb-item active">Statistics Report</li>
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
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input class="form-control border-form-control" value="{{ $user_details->name }}"
                            placeholder="First Name" name="name" id="name" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Surname</label>
                        <input class="form-control border-form-control" value="{{ $user_details->last_name }}"
                            placeholder="Surname" name="last_name" id="last_name" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Registration Email</label>
                        <input class="form-control border-form-control" value="{{ $user_details->email }}"
                            placeholder="Registration Email" disabled="true" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label">Registration Date</label>
                    <input class="form-control border-form-control"
                        value="{{ \Carbon\Carbon::parse($user_details->created_at)->format('Y/m/d') }}"
                        placeholder="Registration Date" disabled="" disabled="true" readonly>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">Member ID</label>
                    <input class="form-control border-form-control"
                        value="{{ $user_details->unique_member_id }}"
                        placeholder="Member ID" disabled="" disabled="true" readonly>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Wallet ID</label>
                        <input class="form-control border-form-control" value="{{ $user_profile_data->wallet_id }}"
                            placeholder="Wallet ID" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label">RVcoins (Balance)</label>
                        <input class="form-control border-form-control" value="{{ number_format($user_profile_data->total_rv_coins, 3) }}"
                            placeholder="Total balanced RVcoins" disabled="true" readonly>
                    </div>
                </div>
            </div>
                
          
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         
        </div>
        <!-- /.card -->

        @foreach($user_roles as $user_roles_values)
                @if($user_roles_values->role_id == '6')
                @include('backend.statictics.member_statictics')             
                @endif
                @if($user_roles_values->role_id == '2')
                @include('backend.statictics.author_statictics')             
                @endif
                @if($user_roles_values->role_id == '3')
                @include('backend.statictics.editor_member_statictics')            
                @endif
                @if($user_roles_values->role_id == '4')
                @include('backend.statictics.reviewer_statictics')            
                @endif
                @if($user_roles_values->role_id == '5')
                @include('backend.statictics.publisher_statictics')            
                @endif
                {{-- @if($user_roles_values->role_id == '7')
                @include('backend.statictics.correspondingauthor_statictics')            
                @endif --}}
            @endforeach
                <br>
                @include('backend.statictics.rvcoins_received')  
                <br>
                @include('backend.statictics.purchase_history')

      
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection