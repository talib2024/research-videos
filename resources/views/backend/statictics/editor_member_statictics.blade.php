<div class="row">
    <div class="col-12">
    @if (count(collect($statictics_member_only)) > 0)
        <h6>Report as an editorial member:</h6>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Total number of assigned videos</th>
                            <th>Total number of rejected videos</th>
                            <th>Total videos accepted for publication</th>
                            <th>Total videos under review process</th>
                        </tr>
                    </thead>
                    <tbody>  
                            <tr>
                                <td>{{ $statictics_for_editorial_member['total_videos_assigned'] }}</td>
                                <td>{{ $statictics_for_editorial_member['total_videos_pending'] }}</td>
                                <td>{{ $statictics_for_editorial_member['total_videos_accepted_for_publication'] }}</td>
                                <td>{{ $statictics_for_editorial_member['total_videos_review_process'] }}</td>
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
