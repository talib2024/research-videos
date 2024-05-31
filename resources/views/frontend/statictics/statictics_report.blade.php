@extends('frontend.include.frontendappforStatictics')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="row">
                <div class="col-lg-10">
                    <div class="main-title">
                        <h6>Statistics Report</h6>
                    </div>
                </div>
            </div>
            <hr class="customHr">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input class="form-control border-form-control" value="{{ Auth::user()->name }}"
                            placeholder="First Name" name="name" id="name" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Surname</label>
                        <input class="form-control border-form-control" value="{{ Auth::user()->last_name }}"
                            placeholder="Surname" name="last_name" id="last_name" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Registration Email</label>
                        <input class="form-control border-form-control" value="{{ Auth::user()->email }}"
                            placeholder="Registration Email" disabled="true" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label">Registration Date</label>
                    <input class="form-control border-form-control"
                        value="{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('Y/m/d') }}"
                        placeholder="Registration Date" disabled="" disabled="true" readonly>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">Member ID</label>
                    <input class="form-control border-form-control"
                        value="{{ Auth::user()->unique_member_id }}"
                        placeholder="Member ID" disabled="" disabled="true" readonly>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Wallet ID</label>
                        <input class="form-control border-form-control" value="{{ $user_profile_data->wallet_id }}"
                            placeholder="Wallet ID" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label">RVcoins (Balance)</label>
                        <input class="form-control border-form-control" value="{{ number_format($user_profile_data->total_rv_coins, 3) }}"
                            placeholder="Total balanced RVcoins" disabled="true" readonly>
                    </div>
                </div>
            </div>
            <hr>

            @foreach($user_roles as $user_roles_values)
                @if($user_roles_values->role_id == '6')
                @include('frontend.statictics.member_statictics')             
                @endif
                @if($user_roles_values->role_id == '2')
                @include('frontend.statictics.author_statictics')             
                @endif
                @if($user_roles_values->role_id == '3')
                @include('frontend.statictics.editor_member_statictics')            
                @endif
                @if($user_roles_values->role_id == '4')
                @include('frontend.statictics.reviewer_statictics')            
                @endif
                @if($user_roles_values->role_id == '5')
                @include('frontend.statictics.publisher_statictics')            
                @endif
                {{-- @if($user_roles_values->role_id == '7')
                @include('frontend.statictics.correspondingauthor_statictics')            
                @endif --}}
            @endforeach
                <br>
                @include('frontend.statictics.rvcoins_received')  
                <br>
                @include('frontend.statictics.purchase_history')  
        </div>
        <!-- /.container-fluid -->
    @endsection
