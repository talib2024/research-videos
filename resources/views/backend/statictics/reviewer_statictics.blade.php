<div class="row">
    <div class="col-12">
        @if (count(collect($statictics_for_reviewer)) > 0)
        <h6>Report as an editorial member:</h6>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Total number of invitations accepted</th>
                            <th>Total videos accepted for publication</th>
                            <th>Total videos rejected for publication</th>
                        </tr>
                    </thead>
                    <tbody>  
                        <tr>
                            <td>{{ $statictics_for_reviewer['total_invitation_accepted'] }}</td>
                            <td>{{ $statictics_for_reviewer['total_videos_Accepted_For_Publication'] }}</td>
                            <td>{{ $statictics_for_reviewer['total_videos_Rejected_For_Publication'] }}</td>
                        </tr>
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
