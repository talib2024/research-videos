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
                           <label class="control-label">Phone</label>
                           <input type="hidden" id="country_code" name="country_code" readonly>
                           <input type="hidden" id="country_code_iso" name="country_code_iso" readonly>
                           <input class="form-control border-form-control" value="{{ $user_details->phone }}" placeholder="Phone" type="number" name="phone" id="phone" readonly disabled>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Email Address</label>
                           <input class="form-control border-form-control" value="{{ $user_details->email }}" placeholder="Email Address" readonly disabled>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Country</label>
                           <select  class="custom-select" name="country_id" id="country_id" readonly disabled>
                              <option value="">Select Country</option>
                              @foreach ($country_list as $country_list)
                                  <option value="{{ $country_list->id }}" {{ $country_list->id == $user_details->country_id ? 'selected' : ''  }}>{{ $country_list->name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">City</label>
                           <input class="form-control border-form-control" value="{{ $user_details->city }}" placeholder="City" type="text" name="city" id="city" readonly disabled>
                        </div>
                     </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Zip Code</label>
                           <input class="form-control border-form-control" value="{{ $user_details->zip_code }}" placeholder="Zip Code" type="text" name="zip_code" id="zip_code" readonly disabled>
                        </div>
                     </div>
                  </div>
                  
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Institute Name</label>
                           <input class="form-control border-form-control" value="{{ $user_details->institute_name }}" placeholder="Institute Name" type="text" name="institute_name" id="institute_name" readonly disabled>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Position</label>
                           <input class="form-control border-form-control" value="{{ $user_details->position }}" placeholder="Position" type="text" name="position" id="position" readonly disabled>
                        </div>
                     </div> 
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Degree</label>
                           <input class="form-control border-form-control" value="{{ $user_details->degree }}" placeholder="Degree" type="text" name="degree" id="degree" readonly disabled>
                        </div>
                     </div> 
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Address </label>
                           <textarea class="form-control border-form-control" name="address" id="address" readonly disabled>{{ $user_details->address }}</textarea>
                        </div>
                     </div> 
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Role</label>
                           <select class="select2bs4" name="role_ids[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" readonly disabled>
                               <option value="">Select</option>
                               @foreach ($roles as $roles)
                                   <option value="{{ $roles->id.'_'.$roles->sequence_for_role_switch }}" {{ in_array($roles->id, $userroledata) ? 'selected' : '' }}>{{ $roles->role }}</option>
                               @endforeach
                            </select>
                        </div>
                     </div> 
                  </div>
                