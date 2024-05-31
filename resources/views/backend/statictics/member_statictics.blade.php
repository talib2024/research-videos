<div class="row">
    <div class="col-12">
    @if (count(collect($statictics_member_only)) > 0)
        <h6>Report as a member:</h6>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Total video views</th>
                                <th>Total Likes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $statictics_member_only['video_views_count'] }}</td>
                                <td>{{ $statictics_member_only['statictics_like_unlike'] }}</td>
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
