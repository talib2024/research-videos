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
            <h1>Institution Request Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('all.institution.request') }}">Institute management</a></li>
              <li class="breadcrumb-item active">Institution Request Details</li>
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
            <h3 class="card-title">Details</h3>
            @if(session()->has('success'))
              <div class="alert alert-success">
                  {{ session()->get('success') }}
              </div>
            @endif
          </div>
          <!-- /.card-header -->
          <div class="card-body">
                   <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Name </label>
                           <input class="form-control border-form-control" value="{{ $institutionrequest->name }}" type="text" readonly disabled>
                        </div>
                     </div>                     
                  
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Institution Name</label>
                           <input class="form-control border-form-control" value="{{ $institutionrequest->affiliation }}" type="text" readonly disabled>
                        </div>
                     </div>  
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Country</label>
                           <input class="form-control border-form-control" value="{{ $institutionrequest->country }}" type="text" readonly disabled>
                        </div>
                     </div>    
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Institution Representative Email</label>
                           <input class="form-control border-form-control" value="{{ $institutionrequest->email }}" type="text" readonly disabled>
                        </div>
                     </div> 
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Request date</label>
                           <input class="form-control border-form-control" value="{{ \Carbon\Carbon::parse($institutionrequest->created_at)->format('Y/m/d') }}" type="text" readonly disabled>
                        </div>
                     </div>                     
                     {{-- <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Subject </label>
                           <input class="form-control border-form-control" value="{{ $institutionrequest->subject }}" type="text" readonly disabled>
                        </div>
                     </div>                      --}}
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Message </label>
                           <textarea class="form-control border-form-control" readonly disabled>{{ $institutionrequest->message }}</textarea>
                        </div>
                     </div>                     
                  </div>   
          
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