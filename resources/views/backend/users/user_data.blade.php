<div class="card-body">
                               <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input class="form-control border-form-control" value="{{ $user_details->name }}"
                            placeholder="First Name" name="name" id="name" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Surname</label>
                        <input class="form-control border-form-control" value="{{ $user_details->last_name }}"
                            placeholder="Surname" name="last_name" id="last_name" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Registration Email</label>
                        <input class="form-control border-form-control" value="{{ $user_details->email }}"
                            placeholder="Registration Email" disabled="true" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label">Registration Date</label>
                    <input class="form-control border-form-control"
                        value="{{ \Carbon\Carbon::parse($user_details->created_at)->format('Y/m/d') }}"
                        placeholder="Registration Date" disabled="" disabled="true" readonly>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">Member ID</label>
                    <input class="form-control border-form-control"
                        value="{{ $user_details->unique_member_id }}"
                        placeholder="Member ID" disabled="" disabled="true" readonly>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Wallet ID</label>
                        <input class="form-control border-form-control" value="{{ $user_details->wallet_id }}"
                            placeholder="Wallet ID" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label">RVcoins (Balance)</label>
                        <input class="form-control border-form-control" value="{{ number_format($user_details->total_rv_coins, 3) }}"
                            placeholder="Total balanced RVcoins" disabled="true" readonly>
                    </div>
                </div>
            </div>

                            <!-- /.row -->
                        </div>