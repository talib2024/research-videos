@extends('backend.include.backendapp')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Message to the Subscribed user.</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Newsletter</a></li>
                            <li class="breadcrumb-item active">Subscribed users</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Send message</h3>
                    </div>
                @if (session('success'))
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">
                            Sent successfully!
                        </div>
                    </div>
                @endif
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="newsletterForm">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Subject <span class="required">*</span></label>
                                        <input class="form-control border-form-control" placeholder="Subject" type="text" name="subject" id="subject">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Select Subscribed Email <span class="required">*</span></label>
                                        <select class="select2bs4" name="email[]" id="email" multiple="multiple"
                                            data-placeholder="Select emails" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach ($newsletter_user as $newsletter_user)
                                                <option value="{{ $newsletter_user->email }}">{{ $newsletter_user->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                                {{-- <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="control-label">Select Email <span class="required">*</span></label>
                                        <input type="checkbox" id="checkbox" class="form-control">Select All
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Message <span class="required">*</span> </label>
                                        <textarea class="form-control border-form-control" name="message" id="message"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary" id="newsletterSend">Send</button>
                                </div>
                            </div>
                        </form>

                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
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
@push('pushjs')
    @include('backend.include.jsForDifferentPages.jsForNewsletterPage')
@endpush
