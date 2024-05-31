@extends('backend.include.backendapp')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Control Institution</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Institute management</li>
                            <li class="breadcrumb-item active">Control Institution Update</li>
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
                        <form action="{{ route('control.institution.update', $transactiondetails->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Inbox <span
                                                class="required">*</span></label>
                                        <input class="form-control border-form-control" placeholder="Email with @ (Ex: @gmail.com)"
                                            type="text" name="email_type" id="email_type" value="{{ $transactiondetails->email_type }}">
                                        <small class="text-danger">
                                            {{ $errors->first('email_type', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">From date <span
                                                class="required"> *</span></label>
                                        <input class="form-control border-form-control" placeholder="From date"
                                            type="date" name="subscription_start_date" id="subscription_start_date" value="{{ \Carbon\Carbon::parse($transactiondetails->subscription_start_date)->format('Y-m-d') }}">
                                        <small class="text-danger">
                                            {{ $errors->first('subscription_start_date', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">To date <span
                                                class="required"> *</span></label>
                                        <input class="form-control border-form-control" placeholder="To date"
                                            type="date" name="subscription_end_date" id="subscription_end_date" value="{{ \Carbon\Carbon::parse($transactiondetails->subscription_end_date)->format('Y-m-d') }}">
                                        <small class="text-danger">
                                            {{ $errors->first('subscription_end_date', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <label class="control-label">Status <span
                                                class="required">*</span></label>
                                    <select  class="custom-select" name="is_active" id="is_active">
                                        <option value="">Status</option>
                                        <option value="1" {{ $transactiondetails->is_active == 1 ? 'selected' : '' }}>Activate</option>
                                        <option value="0" {{ $transactiondetails->is_active == 0 ? 'selected' : '' }}>Deactivate</option>                              
                                    </select>
                                        <small class="text-danger">
                                            {{ $errors->first('is_active', ':message') }}
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
