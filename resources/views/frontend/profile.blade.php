@extends('frontend.include.frontendapp')
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
 
         <div id="content-wrapper">
            <div class="container-fluid upload-details">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="main-title">
                        <h6>Profile</h6>
                     </div>
                  </div>
               </div>
               <div class="progress customProgressBar">
                  <div class="progress-bar profile_progress_bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
               </div>
               <form id="SubmitProfileForm">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">First Name <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="{{ $user_details->name }}" placeholder="First Name" type="text" name="name" id="name">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Surname <span class="required">*</span></label>
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
                           <input class="form-control border-form-control" value="{{ $user_details->phone }}" placeholder="Phone" type="text" name="phone" id="phone">
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
                           <label class="control-label">Country <span class="required">*</span></label>
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
                           <label class="control-label">City <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="{{ $user_details->city }}" placeholder="City" type="text" name="city" id="city">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Zip Code <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="{{ $user_details->zip_code }}" placeholder="Zip Code" type="text" name="zip_code" id="zip_code">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Profile photo <span class="required">(upto 40 KB)</span></label>
                           <input type="file" id="profile_pic" name="profile_pic" class="form-control border-form-control profile_image" />
                        </div>
                     </div> 
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Institute Name <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="{{ $user_details->institute_name }}" placeholder="Institute Name" type="text" name="institute_name" id="institute_name">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Position <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="{{ $user_details->position }}" placeholder="Position" type="text" name="position" id="position">
                        </div>
                     </div> 
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                              <label for="majorcategory_id">Scientific Disciplines<b
                                    class="red">*</b></label>
                              <select id="majorcategory_id" name="majorcategory_id" class="custom-select">
                                 <option value="">Select</option>
                                 @foreach ($majorcategory as $majorcategory)
                                    <option value="{{ $majorcategory->id }}" {{ $majorcategory->id == $user_details->majorcategory_id ? 'selected' : '' }}>
                                          {{ $majorcategory->category_name }}</option>
                                 @endforeach
                              </select>
                        </div>
                     </div> 
                     <div class="col-sm-6  input-fix">
                        <div class="form-group">
                              <label for="subcategory_id">Subdisciplines<b class="red">*</b></label>
                              <select id="subcategory_id" name="subcategory_id[]" multiple="multiple" class="custom-select subcategory_id">
                                 
                                 @foreach($subcategory_data as $subcategory_value)
                                    <option value="{{ $subcategory_value->id }}" {{ in_array($subcategory_value->id, $user_details->subcategory_id ?? []) ? 'selected' : '' }}>{{ $subcategory_value->subcategory_name }}</option>
                                 @endforeach
                              </select>
                              <span class="custom_error required" id="subcategory_id_profile-error"></span>
                        </div>
                     </div> 
                  </div> 
                  <div class="row">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Degree <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="{{ $user_details->degree }}" placeholder="Degree" type="text" name="degree" id="degree">
                        </div>
                     </div> 
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label class="control-label">Wallet ID</label>
                           {{-- <input class="form-control border-form-control" value="{{ $user_details->wallet_id }}" placeholder="Wallet ID" type="text" name="wallet_id" id="wallet_id"> --}}
                           <a href="{{ route('statictics.report') }}" target="_BLANK" style="word-wrap: break-word;">{{ $user_details->wallet_id }}</a>
                        </div>
                     </div> 
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="control-label">Address </label>
                           <textarea class="form-control border-form-control" name="address" id="address">{{ $user_details->address }}</textarea>
                        </div>
                     </div> 
                  </div>   
                  <div class="row"> 
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label class="control-label">Short Biography Description </label>
                           <textarea class="form-control border-form-control text-limit" name="user_description" data-maxlength="2500" data-show-char=".char-count" placeholder="Max c characters">{{ $user_details->user_description }}</textarea>
                        </div>
                     </div> 
                  </div>                 
                  <div class="row">
                     <div class="col-lg-3">
                        <div class="form-group">
                              <div class="custom-control">
                                 <label>Captcha</label>
                                 <div class="captcha_video">
                                    <span>{!! captcha_img() !!}</span>
                                    <button type="button" class="btn btn-danger captchaButton_video" class="reload_video" id="reload_video">
                                             &#x21bb;
                                    </button>
                                 </div>
                              </div>
                        </div>
                     </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                              <div class="custom-control">
                                 <label>Enter Captcha<b class="required">*</b></label><span class="required">{{ $errors->first('captcha') }}</span>
                                 <input id="captcha_video" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                 <span class="custom_error required" id="captcha_profile-error"></span>
                              </div>
                        </div>
                     </div>
                  </div>  
                  
                  <div class="row">
                     <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-outline-primary" id="profileUpdate">Update your profile</button>
                     </div>
                  </div>
               </form>
            </div>
            <!-- /.container-fluid -->

@endsection
@push('pushjs')
<script>

$(document).ready(function(){
        $(document).on('change','#majorcategory_id', function() {
            let majorcategory_id = $(this).val();
            $.ajax({
                method: 'post',
                url: "{{ route('sub.category') }}",
                data: {
                    majorcategory_id: majorcategory_id,                    
                    token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.status == 'success') {
                        $('.subcategory_id').empty();
                        let all_options = "";
                        let all_subcategories = res.subcategories;
                        $.each(all_subcategories, function(index, value) {
                            all_options += "<option value='" + value.id +
                                "'>" + value.subcategory_name + "</option>";
                        });
                        $(".subcategory_id").html(all_options);
                        $('.subcategory_id').multiselect('rebuild');
                        
                        // Add event listener to limit selection to 3
                       $('.subcategory_id').on('change', function () {
                        var selectedOptions = $('.subcategory_id option:selected:not([value=""])');
                        if (selectedOptions.length > 3) {
                            // Deselect the last option if more than 3 are selected
                            selectedOptions.last().prop('selected', false);
                        }
                        // Disable remaining options excluding the "Select" option
                        $('.subcategory_id option:not(:selected)').not('[value=""]').prop('disabled', selectedOptions.length >= 3);
                        
                        // Rebuild the multiselect to reflect the change
                        $('.subcategory_id').multiselect('rebuild');
                    });
                    }
                }
            })
        });
    });

$(document).ready(function() {
    $('.subcategory_id').multiselect({
        buttonWidth : '100%'
    });
});

$(document).ready(function () {
    // Initialize Bootstrap Multiselect
    $('.subcategory_id').multiselect({ buttonWidth: '160px' });

    // Add event listener to limit selection to 3
    $('.subcategory_id').on('change', function () {
        var selectedOptions = $('.subcategory_id option:selected:not([value=""])');

        if (selectedOptions.length > 3) {
            // Deselect the last option if more than 3 are selected
            selectedOptions.last().prop('selected', false);
        }

        // Disable remaining options excluding the "Select" option
        $('.subcategory_id option:not(:selected)').not('[value=""]').prop('disabled', selectedOptions.length >= 3);

        // Rebuild the multiselect to reflect the change
        $('.subcategory_id').multiselect('rebuild');
    });

    // Set the initial selected options if you have them (replace [1, 2, 3] with your actual values)
    var initialSelectedOptions = {!! json_encode($user_details->subcategory_id) !!};
    $('.subcategory_id').val(initialSelectedOptions).change();
});

</script>
@endpush