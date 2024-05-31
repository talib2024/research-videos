@extends('frontend.include.frontendapp')
@section('content')
        
 
         <div id="content-wrapper">
            <div class="container-fluid upload-details">
               <div class="row">
                  <div class="col-lg-2">
                     <div class="main-title">
                        <h6>Co-Authors Details</h6>
                     </div>
                  </div>
                @include('frontend.include.success_message')
               </div>
               <form id="SubmitCoAuthorForm">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">First Name <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="" placeholder="First Name" type="text" name="name" id="name">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Surname</label>
                           <input class="form-control border-form-control" value="" placeholder="Surname" type="text" name="surname" id="surname">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Phone</label>
                           <input class="form-control border-form-control" value="" placeholder="Phone" type="number" name="phone" id="phone">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Email Address <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="" placeholder="Email Address" name="email" id="email">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Country <span class="required">*</span></label>
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
                           <label class="control-label">City <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="" placeholder="City" type="text" name="city" id="city">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Zip Code <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="" placeholder="Zip Code" type="text" name="zip_code" id="zip_code">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Role </label>
                           <input class="form-control border-form-control" value="" placeholder="Role" type="text" name="role" id="role">                           
                        </div>
                     </div> 
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label class="control-label">Address <span class="required">*</span></label>
                           <textarea class="form-control border-form-control" name="address" id="address"></textarea>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-outline-primary" id="authorSubmit"> Submit </button>
                     </div>
                  </div>
               </form>
            </div>
            <!-- /.container-fluid -->

@endsection