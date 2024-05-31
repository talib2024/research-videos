@extends('backend.include.backendapp')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Scientific Sub Disciplines</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Scientific disciplines</a></li>
                            <li class="breadcrumb-item active">Sub disciplines</li>
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
                        <form id="scientific_sub_disciplines_form_update">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label class="control-label">Scientific Disciplines <span class="required">*</span></label>
                                    <select class="custom-select" name="majorcategory_id" id="majorcategory_id" style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach($major_category as $major_category_value)
                                            <option value="{{ $major_category_value->id }}" {{ $major_category_value->id == $sub_category->majorcategory_id ? 'selected' : '' }}>{{ $major_category_value->category_name }}</option>
                                        @endforeach
                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="subcategory_id">Subdisciplines<b class="red">*</b></label>
                                         <input class="form-control border-form-control" id="subcategory_id" name="subcategory_id" placeholder="Subdisciplines" value="{{ $sub_category->subcategory_name }}">
                                         <input type="hidden" value="{{ $sub_category->id }}" name="sub_category_update" id="sub_category_update" >
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label class="control-label">Description  <span class="required">*</span></label>
                                    <textarea class="form-control border-form-control" name="sub_discipline_description" id="sub_discipline_description">{{ $sub_category->description }}</textarea>
                                    </div>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary" id="scientific_sub_disciplines_form_submit_update">Update</button>
                                   @if(isset($check_for_delete) && $check_for_delete == 'yes')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-user">Delete this sub discipline</button>
                                    @endif
                                </div>
                                @if(isset($check_for_delete) && $check_for_delete == 'no')
                                <b class="red">You cannot delete this because it is used at the time of video submission.</b>
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
        <form action="{{ route('scientificsubdisciplines.destroy', $sub_category->id) }}" method="POST">
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
