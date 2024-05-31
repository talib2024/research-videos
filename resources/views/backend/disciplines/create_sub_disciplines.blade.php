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
                        <form id="scientific_sub_disciplines_form">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label class="control-label">Scientific Disciplines <span class="required">*</span></label>
                                    <select class="custom-select" name="majorcategory_id" id="majorcategory_id" style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach($major_category as $major_category_value)
                                            <option value="{{ $major_category_value->id }}">{{ $major_category_value->category_name }}</option>
                                        @endforeach
                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="subcategory_id">Subdisciplines<b class="red">*</b></label>
                                         <input class="form-control border-form-control" id="subcategory_id" name="subcategory_id" placeholder="Subdisciplines">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label class="control-label">Description  <span class="required">*</span></label>
                                    <textarea class="form-control border-form-control" name="sub_discipline_description" id="sub_discipline_description"></textarea>
                                    </div>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary" id="scientific_sub_disciplines_form_submit">Create</button>
                                </div>
                            </div>
                        </form>

                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.row -->



                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Discipline name</th>
                                            <th>Sub discipline name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $categories_value)
                                            <tr>
                                                <td>{{ $categories_value->category_name }}</td>
                                                <td>{{ $categories_value->subcategory_name }}</td>
                                                <td>
                                                    <a href="{{ route('scientificsubdisciplines.edit', $categories_value->id) }}"
                                                        class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('pushjs')
    @include('backend.include.jsForDifferentPages.jsForScientificDisciplines')
@endpush
