    @extends('backend.include.backendapp')
    @section('content')
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>RVcoins details.</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('adminusers.index') }}">Registered Users</a>
                                </li>
                                <li class="breadcrumb-item active">RVcoins</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">


                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">User details:</h3>
                        </div>
                        <!-- /.card-header -->
                        @include('backend.users.user_data')
                        <!-- /.card-body -->
                    </div>

                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Assign RVcoins.</h3>
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
                            <form action="{{ route('assign.rvcoins') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">RVcoins (In numeric) <span
                                                    class="required">*</span></label>
                                            <input class="form-control border-form-control" placeholder="RVcoins"
                                                type="text" name="received_rvcoins" id="received_rvcoins">
                                            <small class="text-danger">
                                                {{ $errors->first('received_rvcoins', ':message') }}
                                            </small>
                                            <input class="form-control border-form-control" type="hidden" name="user_id"
                                                value="{{ $user_details->id }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">RVcoins reward type <span
                                                    class="required">*</span></label>
                                            <select name="rvcoinsrewardtype_id" class="form-control border-form-control">
                                                <option value="">Select</option>
                                                @foreach ($rvcoinsrewardtype as $rvcoinsrewardtype_value)
                                                    <option value="{{ $rvcoinsrewardtype_value->id }}">
                                                        {{ $rvcoinsrewardtype_value->reward_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger">
                                                {{ $errors->first('rvcoinsrewardtype_id', ':message') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Comment </label>
                                            <textarea class="form-control border-form-control" name="description" id="description"
                                                placeholder="Please type extra information. This is optional."></textarea>
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

                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Received RVcoins</th>
                                                <th>Reward Type</th>
                                                <th>Receiving date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rvcoins_history as $rvcoins_history_value)
                                                <tr>
                                                    <td>{{ number_format($rvcoins_history_value->received_rvcoins, 3) }}
                                                    </td>
                                                    <td>{{ $rvcoins_history_value->reward_type }}</td>
                                                    <td> {{ \Carbon\Carbon::parse($rvcoins_history_value->created_at)->format('Y/m/d h:i:s A') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
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
