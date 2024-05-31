@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid upload-details">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-title">
                        <h6>Terms and Conditions</h6>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Terms of use</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Privacy Policy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">Users Guidelines</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabs-5" role="tab">Copyrights</a>
                </li>
            </ul><!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                    @include('frontend.terms_n_conditions_pages.terms_of_use')
                </div>
                <div class="tab-pane" id="tabs-2" role="tabpanel">
                    @include('frontend.terms_n_conditions_pages.privacy_policy')
                </div>
                <div class="tab-pane" id="tabs-3" role="tabpanel">
                    <p>Business</p>
                </div>
                <div class="tab-pane" id="tabs-4" role="tabpanel">
                    @include('frontend.terms_n_conditions_pages.community')
                </div>
                <div class="tab-pane" id="tabs-5" role="tabpanel">
                    @include('frontend.terms_n_conditions_pages.copyright')
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    @endsection

    @push('pushjs')
    <script>
        $(document).ready(function() {
            // Handle click on links with class "tab-link"
            $(".tab-link").on("click", function(e) {
                e.preventDefault();
                // Get the target tab ID from the href attribute
                var targetTabId = $(this).attr("href");
                // Remove "active" and "show" classes from all tabs
                $(".nav-link").removeClass("active show").attr("aria-selected", "false");
                // Add "active" and "show" classes to the clicked tab
                $("a[href='" + targetTabId + "']").addClass("active show").attr("aria-selected", "true");
                // Show the content of the clicked tab
                $(targetTabId).addClass("active show").siblings().removeClass("active show");
                // Scroll to the top of the page
                $("html, body").animate({ scrollTop: 0 }, "slow");
            });
        });
    </script>
    @endpush