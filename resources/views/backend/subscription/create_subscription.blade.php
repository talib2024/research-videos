@extends('backend.include.backendapp')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Subscription</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                            <li class="breadcrumb-item active">Subscription</li>
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
                        <form action="{{ route('subscriptionmaster.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Plan name <span
                                                class="required">*</span></label>
                                        <input class="form-control border-form-control" placeholder="Plan name"
                                            type="text" name="plan_name" id="plan_name" value="{{ old('plan_name') }}">
                                        <small class="text-danger">
                                            {{ $errors->first('plan_name', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Paypal plan ID <span
                                                class="required">(Id of the created plan from the paypal account) *</span></label>
                                        <input class="form-control border-form-control" placeholder="Paypal plan ID"
                                            type="text" name="paypal_plan_id" id="paypal_plan_id" value="{{ old('paypal_plan_id') }}">
                                        <small class="text-danger">
                                            {{ $errors->first('paypal_plan_id', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Duration <span
                                                class="required"> (In numbers only) *</span></label>
                                        <input class="form-control border-form-control" placeholder="Duration"
                                            type="number" name="duration" id="duration" value="{{ old('duration') }}">
                                        <small class="text-danger">
                                            {{ $errors->first('duration', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Paypal amount <span
                                                class="required"> (In numbers only) *</span></label>
                                        <input class="form-control border-form-control" placeholder="Paypal amount"
                                            type="number" name="amount" id="amount" value="{{ old('amount') }}">
                                        <small class="text-danger">
                                            {{ $errors->first('amount', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">RVcoin amount <span
                                                class="required"> (In numbers only) *</span></label>
                                        <input class="form-control border-form-control" placeholder="RVcoin amount"
                                            type="number" name="rv_coins_price" id="rv_coins_price" value="{{ old('rv_coins_price') }}">
                                        <small class="text-danger">
                                            {{ $errors->first('rv_coins_price', ':message') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <label class="control-label">Status <span
                                                class="required">*</span></label>
                                    <select  class="custom-select" name="status" id="status">
                                        <option value="">Status</option>
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Pending</option>                              
                                    </select>
                                        <small class="text-danger">
                                            {{ $errors->first('status', ':message') }}
                                        </small>
                                    </div>
                                </div> 
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label class="control-label">Description </label>
                                    <textarea class="form-control border-form-control" name="description">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary">Create</button>
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
                                            <th>Subscription name</th>
                                            <th>Paypal plan ID</th>
                                            <th>Paypal amount</th>
                                            <th>RVcoin amount</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscriptionplan as $subscriptionplan_value)
                                            <tr>
                                                <td>{{ $subscriptionplan_value->plan_name }}</td>
                                                <td>{{ $subscriptionplan_value->paypal_plan_id }}</td>
                                                <td>{{ $subscriptionplan_value->amount }}</td>
                                                <td>{{ $subscriptionplan_value->rv_coins_price }}</td>
                                                <td>{{ $subscriptionplan_value->status == 1 ? 'Active' : 'Pending' }}</td>
                                                <td>
                                                    <a href="{{ route('subscriptionmaster.edit', $subscriptionplan_value->id) }}"
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
