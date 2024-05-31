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
              <li class="breadcrumb-item"><a href="#">Users</a></li>
              <li class="breadcrumb-item active">Create User</li>
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
            <h3 class="card-title">Fill the form</h3>
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
          <form id="CreateProfileForm">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">First Name <span class="required">*</span></label>
                           <input class="form-control border-form-control" placeholder="First Name" type="text" name="name" id="name">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Surname</label>
                           <input class="form-control border-form-control" placeholder="Surname" type="text" name="last_name" id="last_name">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Phone</label>
                           <input type="hidden" id="country_code" name="country_code" readonly>
                           <input type="hidden" id="country_code_iso" name="country_code_iso" readonly>
                           <input class="form-control border-form-control" placeholder="Phone" type="number" name="phone" id="phone">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Email Address <span class="required">*</span></label>
                           <input class="form-control border-form-control" placeholder="Email Address" name="email" id="email">
                           <span class="required" id="email_user-error"></span>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Country</label>
                           <select  class="custom-select" name="country_id" id="country_id">
                              <option value="">Select Country</option>
                              @foreach ($country_list as $country_list)
                                  <option value="{{ $country_list->id }}">{{ $country_list->name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">City</label>
                           <input class="form-control border-form-control" placeholder="City" type="text" name="city" id="city">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Zip Code</label>
                           <input class="form-control border-form-control" placeholder="Zip Code" type="text" name="zip_code" id="zip_code">
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Profile photo <span class="required">(upto 40 KB)</span></label>
                           <input type="file" id="profile_pic" name="profile_pic" class="form-control border-form-control profile_image" />
                        </div>
                     </div> 
                      <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Password <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Your password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character."></i> <span class="required">*</span></label>
                           <input class="form-control border-form-control" placeholder="Password" type="password" name="password" id="password">
                           <span class="required" id="password_user-error"></span>
                        </div>
                     </div>
                    
                  </div>
                  
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Institute Name</label>
                           <input class="form-control border-form-control" placeholder="Institute Name" type="text" name="institute_name" id="institute_name">
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Position</label>
                           <input class="form-control border-form-control" placeholder="Position" type="text" name="position" id="position">
                        </div>
                     </div> 
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Degree</label>
                           <input class="form-control border-form-control" placeholder="Degree" type="text" name="degree" id="degree">
                        </div>
                     </div> 
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Address </label>
                           <textarea class="form-control border-form-control" name="address" id="address"></textarea>
                        </div>
                     </div> 
                     
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">User Status</label>
                           <select  class="custom-select" name="status" id="status">
                              <option value="">Status</option>
                              <option value="1">Active</option>
                              <option value="0">Deleted</option>                              
                              <option value="2">Blocked</option>                              
                           </select>
                        </div>
                     </div> 
                  </div>
                  
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label class="control-label">Description </label>
                           <textarea class="form-control border-form-control" name="user_description" id="message"></textarea>
                        </div>
                     </div> 
                  </div>

                   <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Role</label>
                           <select class="select2bs4" name="role_ids[]" id="role_ids" multiple="multiple" data-placeholder="Select a Role" style="width: 100%;">
                               <option value="">Select</option>
                               @foreach ($roles as $roles)
                                   <option value="{{ $roles->id.'_'.$roles->sequence_for_role_switch }}">{{ $roles->role }}</option>
                               @endforeach
                            </select>
                        </div>
                     </div> 
                     <div class="col-sm-3 editorrole_div" style="display:none">
                        <div class="form-group">
                           <label class="control-label">Editor Role</label>
                           <select class="custom-select" name="editorrole_id" id="editorrole_id">
                               <option value="">Select</option>
                               @foreach($editor_role as $editor_role_value)
                                 <option value="{{ $editor_role_value->id }}">{{ $editor_role_value->editor_role }}</option>
                               @endforeach
                            </select>
                            <label class="error" id="editor_role_error"></label>
                        </div>
                     </div> 
                     <div class="col-sm-3 majorcategory_div" style="display:none">
                        <div class="form-group">
                           <label class="control-label">Scientific Disciplines</label>
                           <select class="custom-select" name="majorcategory_id" id="majorcategory_id" style="width: 100%;">
                               <option value="">Select</option>
                               @foreach($major_category as $major_category_value)
                                 <option value="{{ $major_category_value->id }}">{{ $major_category_value->category_name }}</option>
                               @endforeach
                               
                            </select>
                        </div>
                     </div> 
                     <div class="col-lg-3 subcategory_div" style="display:none">
                        <div class="form-group">
                              <label for="subcategory_id">Subdisciplines<b class="red">*</b></label>
                              <select id="subcategory_id" name="subcategory_id[]" multiple="multiple" data-placeholder="Select Subdisciplines" style="width: 100%;" class="select2bs4 custom-select">
                                 <option value="">Select</option>
                                 
                              </select>
                        </div>
                     </div>
                  </div>
                  
                  <div class="row">
                     <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary" id="profileCreate">Create profile</button>
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
@push('pushjs')
    @include('backend.include.jsForDifferentPages.jsForProfilePageCreateUser')
@endpush