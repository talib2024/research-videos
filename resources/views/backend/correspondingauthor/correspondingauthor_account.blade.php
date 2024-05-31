<div class="row">
    <div class="col-12">

@if ($video_assigned_for_corr_author->isNotEmpty())
        <h6>Videos assigned for this user:</h6>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                     @include('backend.include.account_table.thead')
                     <tbody>                        
                        @foreach ($video_assigned_for_corr_author as $video_list)
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
