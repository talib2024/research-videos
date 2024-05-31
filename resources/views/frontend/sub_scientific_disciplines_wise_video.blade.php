@extends('frontend.include.frontendapp')
@section('content')
@include('frontend.payment.payment_modal_css')
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <div class="btn-group float-right right-action">
                                <a href="#" class="right-action-link text-gray" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item{{ request('sortingOption') == 'last_published' ? ' background_red' : '' }}" href="{{ route('sub.category.wise.video.sorting', ['id'=>$major_category_id,'sortingOption' => 'last_published']) }}"><i class="fas fa-fw fa-star"></i> &nbsp; Last published</a>
                                 <a class="dropdown-item{{ request('sortingOption') == 'most_liked' ? ' background_red' : '' }}" href="{{ route('sub.category.wise.video.sorting', ['id'=>$major_category_id,'sortingOption' => 'most_liked']) }}"><i class="fas fa-thumbs-up"></i> &nbsp; Most liked</a>
                                 <a class="dropdown-item{{ request('sortingOption') == 'most_viewed' ? ' background_red' : '' }}" href="{{ route('sub.category.wise.video.sorting', ['id'=>$major_category_id,'sortingOption' => 'most_viewed']) }}"><i class="fa fa-eye"></i> &nbsp; Most viewed</a>
                                 {{-- <a class="dropdown-item{{ request('sortingOption') == 'disciplines' ? ' background_red' : '' }}" href="{{ route('sub.category.wise.video.sorting', ['id'=>$major_category_id,'sortingOption' => 'disciplines']) }}"><i class="fas fa-fw fa-list-alt"></i> &nbsp; Disciplines</a> --}}
                                 {{-- <a class="dropdown-item" href="{{ route('welcome.sorting', ['sortingOption' => 'sub_disciplines']) }}"><i class="fas fa-fw fa-list-alt"></i> &nbsp; Sub disciplines</a>                                  --}}
                              </div>
                            </div>
                            <h6><span class="red">{{ $category_name->subcategory_name }}: {{ $category_name->description }}</span></h6>
                        </div>
                    </div>
                    @if ($video_list_all->isNotEmpty())
                        @foreach ($video_list_all as $video_list)
                            <div class="col-xl-4 col-sm-6 mb-3" id="video_list_div{{ $video_list->id }}">
                                <div class="video-card">
                                    @include('frontend.include.videos.common_video_view')
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div class="col-lg-12 mb-4">
                        <div class="form-box">
                            <h5>Be the first to publish your research in this scientific discipline.</h5>
                        </div>
                    </div>
                    @endif
                </div>
                  @include('frontend.include.videos.video_paginate')
            </div>

        </div>
        <!-- /.container-fluid -->   


            <!-- Modal-->
        @include('frontend.payment.payment_modal')      
@endsection

@push('pushjs')
    @include('frontend.payment.payment_modal_js')
@endpush
