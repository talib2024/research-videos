@extends('backend.include.backendapp')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Show/hide section</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Show/hide section</li>
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
                        <form action="{{ route('Showhidesection.update', $details->id) }}" method="post">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Section Name <span
                                                class="required">*</span></label>
                                        <input class="form-control border-form-control" placeholder="Section Name"
                                            type="text" value="{{ $details->section_name }}" readonly disabled>
                                        <small class="text-danger">
                                            {{ $errors->first('section_name', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label class="control-label">Status <span
                                                class="required">*</span></label>
                                    <select  class="custom-select" name="status" id="status">
                                        <option value="">Status</option>
                                        <option value="1" {{ $details->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $details->status == 0 ? 'selected' : '' }}>Pending</option>                              
                                    </select>
                                        <small class="text-danger">
                                            {{ $errors->first('status', ':message') }}
                                        </small>
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
