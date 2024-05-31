<div class="row">
    <div class="col-12">
    @if ($rvcoins_history->isNotEmpty())
                            <h6>Received RVcoins:</h6>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Received RVcoins</th>
                                        <th>Reward Type</th>
                                        <th>Receiving date</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                        @foreach($rvcoins_history as $rvcoins_history_value)
                                            <tr>
                                                <td>{{ number_format($rvcoins_history_value->received_rvcoins, 3) }}</td>
                                                <td>{{ $rvcoins_history_value->reward_type }}</td>
                                                <td> {{ \Carbon\Carbon::parse($rvcoins_history_value->created_at)->format('Y/m/d h:i:s A') }}</td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
            </div>
            <!-- /.card-body -->
        </div>
 @else
 <div class="col-lg-12 mb-4">
            <div class="form-box">
                <h5>No RVcoins yet!</h5>
            </div>
        </div>
    @endif
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
