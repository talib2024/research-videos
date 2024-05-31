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
            <h1>User Detail Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Password update</li>
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
            <h3 class="card-title">Update password.</h3>
          </div>
          
            @if (session('success'))
                <div class="col-lg-12">
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
                </div>
            @endif
          <!-- /.card-header -->
          <div class="card-body">
          <form action="{{ route('admin.profile.update', Auth::user()->id) }}" method="POST">
            @csrf
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label class="control-label">Email</label>
                           <input class="form-control border-form-control" value="{{ Auth::user()->email }}" placeholder="Email" type="email" name="email" id="email" readonly disabled>
                            <small class="text-danger">
                             {{ $errors->first('email',':message') }}
                            </small>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Password <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Your password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character."></i> <span class="required">*</span></label>
                           <input class="form-control border-form-control" type="password" name="password" class="form-control" placeholder="Password">
                           <small class="text-danger">
                             {{ $errors->first('password',':message') }}
                            </small>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Confirm Password <span class="required">*</span></label>
                           <input class="form-control border-form-control" type="password" class="form-control" name="password_confirmation">
                            <small class="text-danger">
                             {{ $errors->first('password_confirmation',':message') }}
                            </small>
                        </div>
                     </div>
                  </div>
                  
                  <div class="row">
                     <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                     </div>
                  </div>
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