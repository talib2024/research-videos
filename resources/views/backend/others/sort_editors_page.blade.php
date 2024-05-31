@extends('backend.include.backendapp')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Sort/paging editors page</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Sort/paging editors page</li>
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
                        <form action="{{ route('sort.editors.page.update') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="sorting_option">Sort by<b class="red">*</b></label>
                                        <input type="hidden" value="{{ $sorting_editors_options->id }}" name="id" readonly required />
                                        <select  class="custom-select" name="sorting_option" id="sorting_option">
                                            <option value="">Select</option>
                                            <option value="1" {{ $sorting_editors_options->sorting_option == '1' ? 'selected' : '' }}>Number</option>
                                            <option value="2" {{ $sorting_editors_options->sorting_option == '2' ? 'selected' : '' }}>Name</option>                              
                                        </select>
                                        <small class="text-danger">
                                            {{ $errors->first('sorting_option', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="order_by">Order by<b class="red">*</b></label>
                                        <select  class="custom-select" name="order_by" id="order_by">
                                            <option value="">Select</option>
                                            <option value="1" {{ $sorting_editors_options->order_by == '1' ? 'selected' : '' }}>Ascending</option>
                                            <option value="2" {{ $sorting_editors_options->order_by == '2' ? 'selected' : '' }}>Descending</option>                              
                                        </select>
                                        <small class="text-danger">
                                            {{ $errors->first('order_by', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Pagination option <b class="red">*</b></label>                                     
                                        <input class="form-control border-form-control" type="number" name="editorial_member_per_page" value="{{ $sorting_editors_options->editorial_member_per_page }}">
                                       
                                        <small class="text-danger">
                                            {{ $errors->first('editorial_member_per_page', ':message') }}
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
