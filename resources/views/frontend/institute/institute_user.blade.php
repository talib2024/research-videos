@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="row">
                <div class="col-lg-10">
                    <div class="main-title">
                        <h6>Institute user list</h6>
                    </div>
                </div>
            </div>
            <hr class="customHr">
            <hr>
             <div class="video-block section-padding">
                <div class="row">
                    @if ($institute_user->isNotEmpty())
                        <div class="common-history-form-box table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>User Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>                        
                                    @foreach ($institute_user as $institute_user_value)
                                         <td>{{ $institute_user_value->unique_member_id }}</td>
                                         <td>{{ $institute_user_value->name }}</td>
                                         <td>{{ $institute_user_value->email }}</td>
                                         <td>{!! $institute_user_value->status == 1 ? 'Active' : '<span class="red">Pending</span>' !!}</td>
                                         <td><a href="{{ route('institute.user.details', $institute_user_value->id) }}" class="btn butn"><i class="fas fa-eye"></i></a></td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-lg-12 mb-4">
                            <div class="form-box">
                                <h5>No user is registered!</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    @endsection
