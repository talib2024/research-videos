@extends('backend.include.backendapp')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Special Issues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Special Issues</li>
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
                        <form action="{{ route('specialissueadmin.update',$specialissue->id) }}" method="post">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Special issue title <span
                                                class="required">*</span></label>
                                        <input class="form-control border-form-control" placeholder="Special issue title"
                                            type="text" name="issue_title" id="issue_title" value="{{ $specialissue->issue_title }}">
                                        <small class="text-danger">
                                            {{ $errors->first('issue_title', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Discipline of the special issue <span
                                                class="required">*</span></label>
                                        <input class="form-control border-form-control" placeholder="Discipline of the special issue"
                                            type="text" name="issue_discipline" id="issue_discipline" value="{{ $specialissue->issue_discipline }}">
                                        <small class="text-danger">
                                            {{ $errors->first('issue_discipline', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                    <label class="control-label">Select editor member <span
                                                class="required">*</span></label>
                                    <select  class="custom-select select2bs4" name="user_id[]" id="user_id" multiple="multiple">
                                            <option value="">Select</option>
                                        @foreach ($editor_board_list as $editor_board_list_value)
                                            <option value="{{ $editor_board_list_value->id }}" {{ in_array($editor_board_list_value->id, $specialissue->user_id) ? 'selected' : '' }}>{!! $editor_board_list_value->email .' ('. $editor_board_list_value->name .') ' !!}</option>
                                        @endforeach                            
                                    </select>
                                        <small class="text-danger">
                                            {{ $errors->first('user_id', ':message') }}
                                        </small>
                                    </div>
                                </div> 

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label class="control-label">Description </label>
                                    <textarea class="form-control border-form-control" name="issue_description">{{ $specialissue->issue_description }}</textarea>
                                    </div>
                                </div> 
                               
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
