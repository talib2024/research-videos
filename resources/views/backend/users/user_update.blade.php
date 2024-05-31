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
              <li class="breadcrumb-item"><a href="{{ route('adminusers.index') }}">Registered Users</a></li>
              <li class="breadcrumb-item active">Update User</li>
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

            {{-- <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div> --}}
          </div>
          
            <div class="col-lg-12 successDiv" style="display:none;">
                    <div class="alert alert-success" role="alert">
                        Updated successfully!
                    </div>
                </div>
          <!-- /.card-header -->
          <div class="card-body">
          <form id="SubmitProfileForm">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">First Name</label>
                           <input type="hidden" value="{{ $user_details->id }}" name="user_id" id="user_id">
                           <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input class="form-control border-form-control" value="{{ $user_details->name }}" placeholder="First Name" type="text" name="name" id="name">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Surname</label>
                           <input class="form-control border-form-control" value="{{ $user_details->last_name }}" placeholder="Surname" type="text" name="last_name" id="last_name">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Phone</label>
                           <input type="hidden" id="country_code" name="country_code" readonly>
                           <input type="hidden" id="country_code_iso" name="country_code_iso" readonly>
                           <input class="form-control border-form-control" value="{{ $user_details->phone }}" placeholder="Phone" type="number" name="phone" id="phone">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Email Address</label>
                           <input class="form-control border-form-control" value="{{ $user_details->email }}" placeholder="Email Address" disabled="">
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
                                  <option value="{{ $country_list->id }}" {{ $country_list->id == $user_details->country_id ? 'selected' : ''  }}>{{ $country_list->name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">City</label>
                           <input class="form-control border-form-control" value="{{ $user_details->city }}" placeholder="City" type="text" name="city" id="city">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Zip Code</label>
                           <input class="form-control border-form-control" value="{{ $user_details->zip_code }}" placeholder="Zip Code" type="text" name="zip_code" id="zip_code">
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Profile photo <span class="required">(upto 40 KB)</span></label>
                           <input type="file" id="profile_pic" name="profile_pic" class="form-control border-form-control profile_image" />
                        </div>
                     </div> 
                      <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Wallet ID</label>
                           <b>{{ $user_details->wallet_id }}</b>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">User ID</label>
                           <b>{{ $user_details->unique_member_id }}</b>
                        </div>
                     </div> 
                  </div>
                  
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Institute Name</label>
                           <input class="form-control border-form-control" value="{{ $user_details->institute_name }}" placeholder="Institute Name" type="text" name="institute_name" id="institute_name">
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Position</label>
                           <input class="form-control border-form-control" value="{{ $user_details->position }}" placeholder="Position" type="text" name="position" id="position">
                        </div>
                     </div> 
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Degree</label>
                           <input class="form-control border-form-control" value="{{ $user_details->degree }}" placeholder="Degree" type="text" name="degree" id="degree">
                        </div>
                     </div> 
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Address </label>
                           <textarea class="form-control border-form-control" name="address" id="address">{{ $user_details->address }}</textarea>
                        </div>
                     </div> 
                     
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">User Status</label>
                           <select  class="custom-select" name="status" id="status">
                              <option value="">Status</option>
                              <option value="1" {{ $user_details->status == '1' ? 'selected' : '' }}>Active</option>
                              <option value="0" {{ $user_details->status == '0' ? 'selected' : '' }}>Deleted</option>                              
                              <option value="2" {{ $user_details->status == '2' ? 'selected' : '' }}>Blocked</option>                              
                           </select>
                        </div>
                     </div> 
                  </div>
                  
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label class="control-label">Description </label>
                           <textarea class="form-control border-form-control" name="user_description" id="message">{{ $user_details->user_description }}</textarea>
                        </div>
                     </div> 
                  </div>

                   <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Role <span class="required">*</span></label>
                           <select class="select2bs4" name="role_ids[]" id="role_ids" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                               <option value="">Select</option>
                               @foreach ($roles as $roles)
                                   <option value="{{ $roles->id.'_'.$roles->sequence_for_role_switch }}" {{ in_array($roles->id, $userroledata) ? 'selected' : '' }}>{{ $roles->role }}</option>
                               @endforeach
                            </select>
                        </div>
                     </div> 
                     <div class="col-sm-3 editorrole_div" style="display:none">
                        <div class="form-group">
                           <label class="control-label">Editor Role <span class="required">*</span></label>
                           <select class="custom-select" name="editorrole_id" id="editorrole_id">
                               <option value="">Select</option>
                               @foreach($editor_role as $editor_role_value)
                                 <option value="{{ $editor_role_value->id }}" {{ $editor_role_value->id == $user_details->editorrole_id ? 'selected' : '' }}>{{ $editor_role_value->editor_role }}</option>
                               @endforeach
                            </select>
                            <label class="error" id="editor_role_error"></label>
                        </div>
                     </div> 
                     <div class="col-sm-3 majorcategory_div" style="display:none">
                        <div class="form-group">
                           <label class="control-label">Scientific Disciplines <span class="required">*</span></label>
                           <select class="custom-select" name="majorcategory_id" id="majorcategory_id" style="width: 100%;">
                               <option value="">Select</option>
                               @foreach($major_category as $major_category_value)
                                 <option value="{{ $major_category_value->id }}" {{ $major_category_value->id == $user_details->majorcategory_id ? 'selected' : '' }}>{{ $major_category_value->category_name }}</option>
                               @endforeach
                               
                            </select>
                        </div>
                     </div> 
                     <div class="col-lg-3 subcategory_div" style="display:none">
                        <div class="form-group">
                              <label for="subcategory_id">Subdisciplines<b class="red">*</b></label>
                              <select id="subcategory_id" name="subcategory_id[]" multiple="multiple" data-placeholder="Select Subdisciplines" style="width: 100%;" class="select2bs4 custom-select">
                                 <option value="">Select</option>
                                 @foreach($subcategory_data as $subcategory_value)
                                    <option value="{{ $subcategory_value->id }}" {{ in_array($subcategory_value->id, $selected_sub_category_id) ? 'selected' : '' }}>{{ $subcategory_value->subcategory_name }}</option>
                                 @endforeach
                              </select>
                        </div>
                     </div>
                     <div class="col-lg-3 highest_priority_div" style="display:none">
                        <div class="form-group">
                              <label for="subcategory_id">Highest priority<b class="red">*</b></label>
                              <select  class="custom-select" name="highest_priority" id="highest_priority">
                              <option value="">Select</option>
                              <option value="1" {{ $user_details->highest_priority == '1' ? 'selected' : '' }}>Yes</option>
                              <option value="0" {{ $user_details->highest_priority == '0' ? 'selected' : '' }}>No</option>                              
                           </select>
                           <span class="required" id="highest_priority_span"></span>
                        </div>
                     </div>
                     <div class="col-lg-3 visible_status_div" style="display:none">
                        <div class="form-group">
                              <label for="visible_status">Visibility status<b class="red">*</b></label>
                              <select  class="custom-select" name="visible_status" id="visible_status">
                              <option value="">Select</option>
                              <option value="1" {{ $user_details->visible_status == '1' ? 'selected' : '' }}>Yes</option>
                              <option value="0" {{ $user_details->visible_status == '0' ? 'selected' : '' }}>No</option>                              
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-3 editorial_board_numbering_div" style="display:none">
                        <div class="form-group">
                              <label for="Editorial board numbering">Editorial board numbering<b class="red">*</b></label>
                              <input class="form-control border-form-control" value="{{ $user_details->editorial_board_numbering }}" placeholder="editorial_board_numbering" type="number" name="editorial_board_numbering" id="editorial_board_numbering" min="0">
                        </div>
                     </div>
                  </div>
                  
                  <div class="row">
                     <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary" id="profileUpdate">Update</button>
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