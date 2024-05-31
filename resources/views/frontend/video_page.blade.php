@extends('frontend.include.frontendapp')
@section('content')
@include('frontend.payment.payment_modal_css')
    
         <div id="content-wrapper">
            <div class="container-fluid pb-0">
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-8">
                        <div class="single-video-left">
                           <div class="single-video">
                           @php
                              if (Auth::check())
                              {
                                    if ($video_list->membershipplan_id == 2 || ($video_list->membershipplan_id == 1 && $video_list->hasPaid == 1) || ($video_list->is_subscription_valid == 1) || ($video_list->is_subscription_valid_institute == 1) || ($checkUserSubscriptionPlan == 1))
                                    {
                                       $src = "route('video.player.show', ['filename' => $video_list->unique_number.'_cropped.m3u8','type' => 'cropped','video_id' => $video_list->unique_number])";
                                    }
                                    else
                                    {
                                       $src = "route('video.player.show', ['filename' => $video_list->unique_number.'.m3u8','type' => 'full','video_id' => $video_list->unique_number])";
                                    }   
                              }
                              else
                              {
                                    $src = "route('video.player.show', ['filename' => $video_list->unique_number.'.m3u8','type' => 'full','video_id' => $video_list->unique_number])";
                              }
                           @endphp
                              <video class="img-fluid myVideo video-js vjs-default-skin single_video_video_section" id="content_video{{ $video_list->id }}" controls disablepictureinpicture data-video-id="{{ Crypt::encrypt($video_list->id) }}" data-membershipplan-id="{{ $video_list->membershipplan_id }}" src="{{ $src }}">
                                 @if (Auth::check())
                                       @if ($video_list->membershipplan_id == 2 || ($video_list->membershipplan_id == 1 && $video_list->hasPaid == 1) || ($video_list->is_subscription_valid == 1) || ($video_list->is_subscription_valid_institute == 1) || ($checkUserSubscriptionPlan == 1))
                                       <source src="{{ route('video.player.show', ['filename' => $video_list->unique_number.'.m3u8','type' => 'full','video_id' => $video_list->unique_number]) }}" type="application/x-mpegURL" class="full-video">
                                       @else
                                       <source src="{{ route('video.player.show', ['filename' => $video_list->unique_number.'_cropped.m3u8','type' => 'cropped','video_id' => $video_list->unique_number]) }}" type="application/x-mpegURL" class="short-video">
                                       @endif
                                 @else
                                       <source src="{{ route('video.player.show', ['filename' => $video_list->unique_number.'_cropped.m3u8','type' => 'cropped','video_id' => $video_list->unique_number]) }}" type="application/x-mpegURL" class="short-video">
                                 @endif
                              </video>
                             <div class="overlay"
                                 style="display:none; position:absolute; bottom: 82%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
                                 <p align="center" class="auth_P">You need to login and pay to continue watching this video.</p>
                                 <p align="center" class="auth_P"><a href="{{ route('member.login') }}" class="btn btn-primary">Login</a></p>
                              </div>
                              <div class="freeoverlay"
                                 style="display:none; position:absolute; bottom: 82%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
                                 <p align="center" class="auth_P">You need to login to continue watching this video.</p>
                                 <p align="center" class="auth_P"><a href="{{ route('member.login') }}" class="btn btn-primary">Login</a></p>
                              </div>
                              <div class="paymentoverlay"
                                 style="display:none; position:absolute; bottom: 82%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
                                 <p align="center" class="auth_P">Please pay to continue watching this video.</p>
                                 @if (Auth::check() && Auth::user()->is_organization == 0)
                                    <p align="center" class="auth_P"><a href="#" data-paypal_video_id="{{ Crypt::encrypt($video_list->id) }}"
                                          data-paypal_video_price="{{ $video_list->video_price }}" data-video_amount_RVcoins="{{ $video_list->rv_coins_price }}" data-user_total_coins="{{ $loggedIn_user_details->total_rv_coins }}" class="paymentButton btn btn-primary">Pay Now</a></p>
                                 @else
                                    <p align="center" class="auth_P"><a href="{{ route('subscription') }}" data-paypal_video_id="{{ Crypt::encrypt($video_list->id) }}"
                                          data-paypal_video_price="{{ $video_list->video_price }}" class="btn btn-primary">Pay Now</a></p>
                                 @endif
                              </div>
                              <div id="overlay_counter{{ $video_list->id }}"
                                 style="display:none; position:absolute; bottom: 82%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
                                 <p id="overlay_counter_msg{{ $video_list->id }}"></p>
                              </div>
                           </div>
                           @php
                                 $subcategoryIds = json_decode($video_list->subcategory_id);
                                 $matchingSubcategories = $all_subcategories->whereIn('id', $subcategoryIds);
                                 $subcategoryNames = $matchingSubcategories->pluck('subcategory_name')->implode(', ');
                           @endphp
                           <div class="single-video-title box mb-3">
                              <h2><a href="#">{{ $video_list->video_title }}</a>
                              <span class="mx-5">&nbsp;</span>
                              <span>&nbsp;</span>
                              <span>&nbsp;</span>
                              {{-- @if (Auth::check())
                                    @if ($video_list->membershipplan_id == 2 || ($video_list->membershipplan_id == 1 && $video_list->hasPaid == 1) || ($video_list->is_subscription_valid == 1))       
                                       <a href="#" class="btn btn-primary" style="padding: 0 5px 0 5px;font-size: 13px;visibility:hidden;">&nbsp;</a>
                                    @else  
                                       @if (Auth::check() && Auth::user()->is_organization == 0)
                                          <a href="#" data-paypal_video_id="{{ Crypt::encrypt($video_list->id) }}" data-paypal_video_price="{{ $video_list->video_price }}" class="paymentButton btn btn-primary" style="padding: 0 5px 0 5px;font-size: 13px;">Pay Now</a>
                                       @else
                                          <a href="{{ route('subscription') }}" class="btn btn-primary" style="padding: 0 5px 0 5px;font-size: 13px;">Pay Now</a>
                                       @endif
                                       
                                    @endif
                              @else
                                    <a href="{{ route('member.login') }}" class="btn btn-primary" style="padding: 0 5px 0 5px;font-size: 13px;">Login</a>
                              @endif --}}
                              </h2>
                              @include('frontend.include.video_options')
                           </div>
                           <div class="single-video-info-content form-box-about mb-3">
                           @if(!empty($corresponding_author_data))
                              <h6 class="black">Authors:</h6>
                              <p>{{ $corresponding_author_data }}</p>
                           @endif

                              <h6 class="black">Abstract :</h6>
                              <p>{{ $video_list->abstract }}</p>

                              <h6 class="black">Keywords :</h6>
                              <p>{{ $video_list->keywords }}</p>  

                              <h6 class="black">Disciplines :</h6>
                              <p>{{ $video_list->category_name }}</p>

                              <h6 class="black">Subdisciplines :</h6>
                              <p>{{ $subcategoryNames }}</p>

                              <h6 class="black">Video Type :</h6>
                              <p>{{ $video_list->video_type }}</p>

                              <h6 class="black">Publishing Licence :</h6>
                              <p>{{ $video_list->plan }} {{ $video_list->membershipplan_id == 1 ? '($'. $video_list->video_price .')' : '' }}</p>
                              
                              <h6 class="black">Submitted On :</h6>
                              <p> {{ \Carbon\Carbon::parse($video_list->created_at)->format('Y/m/d') }}</p>

                              <h6 class="black">References :</h6>
                              <p>{{ $video_list->references }}</p>

                              @if(isset($video_list) && isset($video_list->is_published) && $video_list->is_published == '1')
                                 <h6 class="black">RVOI :</h6>
                                 <a href="{{ route('video.details',$video_list->id) }}">{!! generate_rvoi_link($video_list->short_name,$video_list->videohistories_created_at,$video_list->unique_number) !!}</a>
                                 <p></p>
                                 <h6 class="black">DOI :</h6>
                                {!! empty($video_list->doi_link) ? 'No DOI link' : '<a href="' . $video_list->doi_link . '">' . $video_list->doi_link . '</a>' !!}

                                 <p></p>
                                 <h6 class="black">Scan this QR code :</h6>
                                 {!! QrCode::size(100)->generate(route('video.details',$video_list->id)) !!}
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="single-video-right">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="main-title">
                                    {{-- <div class="btn-group float-right right-action">
                                       <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                       </a>
                                       <div class="dropdown-menu dropdown-menu-right">
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Last published</a>
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Most liked</a>
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-list-alt"></i> &nbsp; Disciplines</a>
                                          <a class="dropdown-item" href="#"><i class="fas fa-fw fa-list-alt"></i> &nbsp; Subdisciplines</a>
                                       </div>
                                    </div> --}}
                                    <h6>Up Next</h6>
                                 </div>
                              </div>
                              <div class="col-md-12">
                              @foreach ($video_list_all as $video_list)
                                 @include('frontend.include.videos.sideBar_video_view')                                  
                              @endforeach
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.container-fluid -->  


            <!-- Modal-->
        @include('frontend.payment.payment_modal')  


@endsection

@push('pushjs')
    @include('frontend.payment.payment_modal_js')
@endpush