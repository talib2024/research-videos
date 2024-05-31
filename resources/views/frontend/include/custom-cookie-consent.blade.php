<style>
    .cookie-modal-title {
        color: black;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: #fff;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .tabHeading {
        color: black;
    }

    .cookie-rightTabContent {
        /*flex: 0 0 65%;*/
        max-width: 100%;
    }

    .cookie-modal-body {
        padding: 0px;
    }

    .cookie-nav-pills {
        padding: 0px;
    }

    .cookie-rightTabContent {
        padding: 20px;
    }

    .cookie-ul-div {
        background-color: #1C1C1C;
        padding: 0px;
    }

    .tab-pane p {
        text-align: justify;
    }
</style>
<!-- Start cookie setting modal -->
<div id="LegalModal" class="modal fade bs-example-modal-lg">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="cookie-modal-title">Privacy Preference Center</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body cookie-modal-body">
                <div class="tabbable column-wrapper"> <!-- Only required for left/right tabs -->

                    <div class="container">
                        <div class="row">
                            <div class="col-md-5 col-lg-4 col-sm-4 cookie-ul-div">
                                <ul class="nav nav-pills flex-column cookie-nav-pills" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="privacy-tab" data-toggle="tab" href="#privacy"
                                            role="tab" aria-controls="privacy" aria-selected="true">Your Privacy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="strictly-tab" data-toggle="tab" href="#strictly"
                                            role="tab" aria-controls="strictly" aria-selected="false">Strictly
                                            Necessary Cookies</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="performance-tab" data-toggle="tab" href="#performance"
                                            role="tab" aria-controls="performance" aria-selected="false">Performance
                                            Cookies</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="functional-tab" data-toggle="tab" href="#functional"
                                            role="tab" aria-controls="functional" aria-selected="false">Functional
                                            Cookies</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="targeting-tab" data-toggle="tab" href="#targeting"
                                            role="tab" aria-controls="targeting" aria-selected="false">Targeting
                                            Cookies</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="social-tab" data-toggle="tab" href="#social"
                                            role="tab" aria-controls="social" aria-selected="false">Social Media
                                            Cookies</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.col-md-4 -->
                            <div class="col-md-7 col-lg-8 col-sm-8 cookie-rightTabContent">
                                <input type="hidden" name="confirmMyChoices_input" id="confirmMyChoices_input" value="">
                                <input type="hidden" name="rejectAllModal_input" id="rejectAllModal_input" value="">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="privacy" role="tabpanel"
                                        aria-labelledby="privacy-tab">
                                        <h5 class="tabHeading">Your Privacy</h5>
                                        <input type="hidden" name="your_privacy_cookie" id="your_privacy_cookie"
                                                        checked="" tabindex="1" value="yes">
                                        <p>When you visit any website, it may store or retrieve information on your
                                            browser, mostly in the form of cookies. This information might be about you,
                                            your preferences or your device and is mostly used to make the site work as
                                            you expect it to. The information does not usually directly identify you,
                                            but it can give you a more personalized web experience. Because we respect
                                            your right to privacy, you can choose not to allow some types of cookies.
                                            Click on the different category headings to find out more and change our
                                            default settings. However, blocking some types of cookies may impact your
                                            experience of the site and the services we are able to offer.</p>
                                    </div>
                                    <div class="tab-pane fade" id="strictly" role="tabpanel"
                                        aria-labelledby="strictly-tab">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8">
                                                <h5 class="tabHeading">Strictly Necessary Cookies</h5>
                                            </div>
                                            <div class="col-md-4 col-sm-4 togl-aly">
                                                <p class="aly-act">Always Active</p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="strictly_necessary_cookies" id="strictly_necessary_cookies"
                                                        checked="" tabindex="1" value="yes"> 
                                        <p>These cookies are necessary for the website to function and cannot be
                                            switched off in our systems. They are usually only set in response to
                                            actions made by you which amount to a request for services, such as setting
                                            your privacy preferences, logging in or filling in forms. You can set your
                                            browser to block or alert you about these cookies, but some parts of the
                                            site will not then work. These cookies do not store any personally
                                            identifiable information.</p>
                                    </div>
                                    <div class="tab-pane fade" id="performance" role="tabpanel"
                                        aria-labelledby="performance-tab">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8">
                                                <h5 class="tabHeading">Performance Cookies</h5>
                                            </div>
                                            <div class="col-md-4 col-sm-4 togl-fix">
                                                <div class="toggle-group">
                                                    <input type="checkbox" name="performance_cookies" id="performance_cookies"
                                                        checked="" tabindex="1" class="hiddenInput" value="yes">                                                        
                                                    <label for="performance_cookies">
                                                        <span class="aural">Show:</span>
                                                    </label>
                                                    <div class="onoffswitch pull-right" aria-hidden="true">
                                                        <div class="onoffswitch-label">
                                                            <div class="onoffswitch-inner"></div>
                                                            <div class="onoffswitch-switch"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p>These cookies allow us to count visits and traffic sources so we can measure
                                            and improve the performance of our site. They help us to know which pages
                                            are the most and least popular and see how visitors move around the site.
                                            All information these cookies collect is aggregated and therefore anonymous.
                                            If you do not allow these cookies we will not know when you have visited our
                                            site, and will not be able to monitor its performance.</p>
                                    </div>
                                    <div class="tab-pane fade" id="functional" role="tabpanel"
                                        aria-labelledby="functional-tab">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8">
                                                <h5 class="tabHeading">Functional Cookies</h5>
                                            </div>
                                            <div class="col-md-4 col-sm-4 togl-fix">
                                                <div class="toggle-group">
                                                    <input type="checkbox" name="functional_cookies" id="functional_cookies"
                                                        checked="" tabindex="1" class="hiddenInput" value="yes">                                                       
                                                    <label for="functional_cookies">
                                                        <span class="aural">Show:</span>
                                                    </label>
                                                    <div class="onoffswitch pull-right" aria-hidden="true">
                                                        <div class="onoffswitch-label">
                                                            <div class="onoffswitch-inner"></div>
                                                            <div class="onoffswitch-switch"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p>These cookies enable the website to provide enhanced functionality and
                                            personalisation. They may be set by us or by third party providers whose
                                            services we have added to our pages. If you do not allow these cookies then
                                            some or all of these services may not function properly.</p>
                                    </div>
                                    <div class="tab-pane fade" id="targeting" role="tabpanel"
                                        aria-labelledby="targeting-tab">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8">
                                                <h5 class="tabHeading">Targeting Cookies</h5>
                                            </div>
                                            <div class="col-md-4 col-sm-4 togl-fix">
                                                <div class="toggle-group">
                                                    <input type="checkbox" name="targeting_cookies" id="targeting_cookies"
                                                        checked="" tabindex="1" class="hiddenInput" value="yes">                                                       
                                                    <label for="targeting_cookies">
                                                        <span class="aural">Show:</span>
                                                    </label>
                                                    <div class="onoffswitch pull-right" aria-hidden="true">
                                                        <div class="onoffswitch-label">
                                                            <div class="onoffswitch-inner"></div>
                                                            <div class="onoffswitch-switch"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p>These cookies may be set through our site by our advertising partners. They
                                            may be used by those companies to build a profile of your interests and show
                                            you relevant adverts on other sites. They do not store directly personal
                                            information, but are based on uniquely identifying your browser and internet
                                            device. If you do not allow these cookies, you will experience less targeted
                                            advertising.</p>
                                    </div>
                                    <div class="tab-pane fade" id="social" role="tabpanel"
                                        aria-labelledby="social-tab">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8">
                                                <h5 class="tabHeading">Social Media Cookies</h5>
                                            </div>
                                            <div class="col-md-4 col-sm-4 togl-fix">
                                                <div class="toggle-group">
                                                    <input type="checkbox" name="social_media_cookies" id="social_media_cookies"
                                                        checked="" tabindex="1" class="hiddenInput" value="yes">                                                       
                                                    <label for="social_media_cookies">
                                                        <span class="aural">Show:</span>
                                                    </label>
                                                    <div class="onoffswitch pull-right" aria-hidden="true">
                                                        <div class="onoffswitch-label">
                                                            <div class="onoffswitch-inner"></div>
                                                            <div class="onoffswitch-switch"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p>These cookies are set by a range of social media services that we have added
                                            to the site to enable you to share our content with your friends and
                                            networks. They are capable of tracking your browser across other sites and
                                            building up a profile of your interests. This may impact the content and
                                            messages you see on other websites you visit. If you do not allow these
                                            cookies you may not be able to use or see these sharing tools.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-8 -->
                        </div>
                    </div>
                    <!-- /.container -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary mr-auto confirmChoices" id="confirmMyChoicesBtn">Confirm My Choices</button>
                {{-- <button type="button" class="btn btn-primary cookie-select rejectChoices" id="rejectAll">Reject All</button>       --}}
                <button type="button" class="btn btn-primary rejectChoices" id="rejectAllModalBtn">Reject All</button>
            </div>
        </div>
    </div>
</div>
<!-- End cookie setting modal -->


<div class="cookie-wrapper row" style="display: none;">
    <div class="cookie-data col-12">
        <p class="auth_P">This website use cookies to help you have a superior and more relevant browsing experience on the website.
        </p>
    </div>
    <div class="cookie-buttons col-12">
        <button class="cookie-button cookie-select" id="acceptBtn">Accept</button>
        <button class="cookie-button cookie-select" id="declineBtn">Decline</button>
        <button class="cookie-button" id="cookieSettingsBtn" data-toggle="modal" data-target="#LegalModal">Cookie
            Settings</button>
    </div>
</div>


<script type="text/javascript">
    const cookieBox = document.querySelector(".cookie-wrapper");
    const buttons = document.querySelectorAll(".cookie-select");
    const executeCodes = () => {
        if (!document.cookie.includes("researchvideos")) {
            cookieBox.style.display = "block";
        }
        buttons.forEach((button) => {
            button.addEventListener("click", () => {
                cookieBox.style.display = "none";
                if (button.id === "acceptBtn") {
                    document.cookie = "cookieBy=researchvideos; max-age=" + 60 * 60 * 24 * 30;
                    cookie_consent('accept');
                } else if (button.id === "declineBtn") {
                    const date = new Date();
                    date.setTime(date.getTime() + (1 * 24 * 60 * 60 *
                        1000)); // Set the cookie to expire in 1 day
                    document.cookie = "cookieBy=researchvideos; expires=" + date.toUTCString();
                    cookie_consent('decline');
                } else if (button.id === "rejectAll") {
                    $('#LegalModal').modal('hide');
                    const date = new Date();
                    date.setTime(date.getTime() + (1 * 24 * 60 * 60 *
                        1000)); // Set the cookie to expire in 1 day
                    document.cookie = "cookieBy=researchvideos; expires=" + date.toUTCString();
                    cookie_consent('rejectAll');
                }
            });
        });
    };
    window.addEventListener("load", executeCodes);


    $(function() {
        $('.legal-tabs li').on('click', function() {
            var tab = $(this).index();
            $('#LegalModal .modal-body .nav-tabs a:eq(' + tab + ')').tab('show');
        });
    });

    // Toggle button

    $(document).ready(function () {
        $('#performance_cookies').change(function () {
            if (this.checked) {
                $(this).val('yes');
            } else {
                $(this).val('no');
            }
        });
        $('#functional_cookies').change(function () {
            if (this.checked) {
                $(this).val('yes');
            } else {
                $(this).val('no');
            }
        });
        $('#targeting_cookies').change(function () {
            if (this.checked) {
                $(this).val('yes');
            } else {
                $(this).val('no');
            }
        });
        $('#social_media_cookies').change(function () {
            if (this.checked) {
                $(this).val('yes');
            } else {
                $(this).val('no');
            }
        });

        $(document).on('click', '#confirmMyChoicesBtn', function(e) {            
            e.preventDefault();
            $('#confirmMyChoices_input').val('yes');
            $('#rejectAllModal_input').val('no');
            $('#LegalModal').modal('hide');
            $('.modal-backdrop').remove();
           
        });

        $(document).on('click', '#rejectAllModalBtn', function(e) {            
            e.preventDefault();
            $('#performance_cookies').val('no');
            $('#functional_cookies').val('no');
            $('#targeting_cookies').val('no');
            $('#social_media_cookies').val('no');

            $('#your_privacy_cookie').val('no');
            $('#strictly_necessary_cookies').val('no');

            $('#confirmMyChoices_input').val('no');
            $('#rejectAllModal_input').val('yes');
            $('#LegalModal').modal('hide');
            $('.modal-backdrop').remove();
            
        });
    });

    $('#LegalModal').off('show.bs.modal', function (e) {
        console.log('ttt');
        $("#page-top").removeAttr("style");
        $(".navbar_Modal").removeAttr("style");
    $("#LegalModal").css({"padding-left": "0"});
    });
    /*$('#LegalModal').off('show.bs.modal').on('show.bs.modal', function (e) {

    console.log('ttt');

    $("#page-top").removeAttr("style");

    $(".navbar_Modal").removeAttr("style");
    $("#LegalModal").css({"padding-left": "0"});

});*/
    // End toggle button

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function cookie_consent(cookie_status) {
        const confirmMyChoices_input = $('#confirmMyChoices_input').val();
        const rejectAllModal_input = $('#rejectAllModal_input').val();
        const your_privacy_cookie = $('#your_privacy_cookie').val();
        const strictly_necessary_cookies = $('#strictly_necessary_cookies').val();
        const performance_cookies = $('#performance_cookies').val();
        const functional_cookies = $('#functional_cookies').val();
        const targeting_cookies = $('#targeting_cookies').val();
        const social_media_cookies = $('#social_media_cookies').val();
        $.ajax({
            url: '{{ route('cookie.consent.save') }}',
            type: "POST",
            data: {
                cookie_status: cookie_status,
                confirmMyChoices_input: confirmMyChoices_input,
                rejectAllModal_input: rejectAllModal_input,
                your_privacy_cookie: your_privacy_cookie,
                strictly_necessary_cookies: strictly_necessary_cookies,
                performance_cookies: performance_cookies,
                functional_cookies: functional_cookies,
                targeting_cookies: targeting_cookies,
                social_media_cookies: social_media_cookies
            },
            success: function(response) {

            }
        });
    }
</script>
