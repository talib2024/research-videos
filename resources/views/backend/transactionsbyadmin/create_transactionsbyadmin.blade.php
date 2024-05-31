@extends('backend.include.backendapp')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assign subscription to user</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                            <li class="breadcrumb-item active">Subscription to user</li>
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
                        <form action="{{ route('transactionbyadmin.store') }}" method="post">
                            @csrf
                            <div class="row">                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label class="control-label">Select User <span
                                                class="required">*</span></label>
                                    <select class="custom-select" name="user_id" id="user_id">
                                        <option value="">Select user</option>
                                        @foreach ($users as $users_value)
                                            <option value="{{ $users_value->id }}" {{ old('user_id') == $users_value->id ? 'selected' : '' }}>{{ $users_value->email }}</option>                                            
                                        @endforeach                             
                                    </select>
                                        <small class="text-danger">
                                            {{ $errors->first('user_id', ':message') }}
                                        </small>
                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label class="control-label">Select subscription plan <span
                                                class="required">*</span></label>
                                    <select  class="custom-select" name="subscription_plan_id" id="subscription_plan_id">
                                        <option value="">Select plan</option>
                                        @foreach ($subscriptionplan as $subscriptionplan_value)
                                            <option value="{{ $subscriptionplan_value->id }}" {{ old('subscription_plan_id') == $subscriptionplan_value->id ? 'selected' : '' }}>{{ $subscriptionplan_value->plan_name }}</option>                                            
                                        @endforeach                             
                                    </select>
                                        <small class="text-danger">
                                            {{ $errors->first('subscription_plan_id', ':message') }}
                                        </small>
                                    </div>
                                </div> 
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary">Assign</button>
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
                                            <th>User email</th>
                                            <th>Plan name</th>
                                            <th>Assigned date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assign_transcation as $assign_transcation_value)
                                            <tr>
                                                <td>{{ $assign_transcation_value->user_email }}</td>
                                                <td>{{ $assign_transcation_value->plan_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($assign_transcation_value->created_at)->format('Y/m/d') }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('transactionbyadmin.destroy', $assign_transcation_value->id) }}" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-info" title="Delete" onclick="return confirm('Are you sure you want to delete this?')"><i class="fas fa-trash"></i></button>
                                                    </form>
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
