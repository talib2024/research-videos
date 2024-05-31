@extends('backend.include.backendapp')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Scientific Disciplines</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Scientific disciplines</a></li>
                            <li class="breadcrumb-item active">Update scientific disciplines</li>
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
                        {{-- <h3 class="card-title">Send message</h3> --}}
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
                        <form id="scientific_disciplines_form_update">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Scientific disciplines <span
                                                class="required">*</span></label>
                                        <input class="form-control border-form-control" placeholder="Scientific disciplines"
                                            type="text" name="category_name" id="category_name" value="{{ $majorCategory->category_name }}">
                                            <input type="hidden" value="{{ $majorCategory->id }}" name="category_id" id="category_id_update" >
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Short name <span
                                                class="required">*</span></label>
                                        <input class="form-control border-form-control" placeholder="Short name"
                                            type="text" name="short_name" id="short_name" value="{{ $majorCategory->short_name }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label class="control-label">Image <span class="required"> (upto 300 KB)</span></label>
                                    <input type="file" id="scientific_disciplines_image" name="scientific_disciplines_image" class="form-control border-form-control profile_image" />
                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label class="control-label">Uploaded image</label>
                                    {{-- <img class="img-fluid" alt="" src="{{ asset('frontend/img/gif_images/'.$majorCategory->category_image ) }}"> --}}
                                    <video class="img-fluid" autoplay loop muted>
                                        <source class="img-fluid" src="{{ asset('frontend/img/gif_images/'.$majorCategory->category_image ) }}" type="video/webm">
                                    </video>
                                    </div>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary" id="scientific_disciplines_form_submit_update">Update</button>
                                    @if(isset($check_for_delete) && $check_for_delete == 'yes')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-user">Delete this discipline</button>
                                    @endif
                                </div>
                                 @if(isset($check_for_delete) && $check_for_delete == 'no')
                                <b class="red">You cannot delete this because it is used by sub discipline.</b>
                                @endif
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

    <div class="modal fade" id="modal-delete-user">
        <div class="modal-dialog">
        <form action="{{ route('scientificdisciplines.destroy', $majorCategory->id) }}" method="POST">
              <input type="hidden" name="_method" value="DELETE">
              @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete!</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure to delete?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Yes</button>
            </div>
          </div>
        </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
@endsection
@push('pushjs')
    @include('backend.include.jsForDifferentPages.jsForScientificDisciplines')
@endpush
