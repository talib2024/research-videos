<div class="row">
    <div class="col-12">

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <h6>Total active task:</h6>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Total assigned videos</th>
                            <th>Non-active task</th>
                            <th>Active task</th>
                        </tr>
                        <tr>
                            <td>{{ $assigned_task_count_reviewer['total_count'] }}</td>
                            <td>{{ $assigned_task_count_reviewer['non_active_count'] }}</td>
                            <td>{{ $assigned_task_count_reviewer['active_count'] }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

@if ($video_list_for_reviewer->isNotEmpty())
        <h6>Videos assigned for this user:</h6>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                     @include('backend.include.account_table.thead')
                     <tbody>                        
                        @foreach ($video_list_for_reviewer as $video_list)
                            @include('backend.include.account_table.tbody')
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
 @else
 <div class="col-lg-12 mb-4">
            <div class="form-box">
                <h5>No videos assigned for this user!</h5>
            </div>
        </div>
    @endif
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
