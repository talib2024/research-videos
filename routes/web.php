<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\Auth\LoginController;
use App\Http\Controllers\backend\UsersController as adminUserController;
use App\Http\Controllers\backend\NewsletterController;
use App\Http\Controllers\backend\PaymentController as adminPaymentController;
use App\Http\Controllers\backend\RVcoinsRewarTypeController;
use App\Http\Controllers\backend\scientificDisciplinesController;
use App\Http\Controllers\backend\subDisciplinesController;
use App\Http\Controllers\backend\subscriptionController;
use App\Http\Controllers\backend\TransactionByAdminController;
use App\Http\Controllers\backend\ShowhidesectionController;
use App\Http\Controllers\backend\InstitutionManagementController;
use App\Http\Controllers\backend\CommonController as adminCommonController;
use App\Http\Controllers\backend\SpecialIssueController;

use App\Http\Controllers\frontend\Auth\AuthController as frontendAuthController;
use App\Http\Controllers\frontend\MenuController;
use App\Http\Controllers\frontend\CommonController;
use App\Http\Controllers\frontend\VideoUploadController;
use App\Http\Controllers\frontend\ProfileController as frontendProfileController;
use App\Http\Controllers\frontend\CoauthorController;
use App\Http\Controllers\frontend\members\MemberController;
use App\Http\Controllers\frontend\HistoryController;
use App\Http\Controllers\frontend\PaymentController;
use App\Http\Controllers\frontend\StaticticsController;
use App\Http\Controllers\frontend\GenerateVideoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/success', function () {
//     return view('frontend.success_payment');
// });

//Auth::routes();

// Admin routes

Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('admin/login/post',[LoginController::class,'processLogin'])->name('admin.login.post');
Route::post('logout',[LoginController::class,'logout'])->name('logout')->middleware('auth');

Route::prefix('/admin')->group(function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('registerd/adminusers', adminUserController::class);
Route::get('/user/delete/request', [adminUserController::class, 'user_delete_request'])->name('user.delete.request');
Route::get('/user/activation/request', [adminUserController::class, 'user_activation_request'])->name('user.activation.request');
Route::resource('backendnewsletter', NewsletterController::class);
Route::resource('rvcoinsrewartype', RVcoinsRewarTypeController::class);
Route::get('/user/rvcoins/{user_id}', [adminUserController::class, 'users_rvcoins'])->name('users.rvcoins');
Route::post('assign/rvcoins', [adminUserController::class, 'assign_rvcoins'])->name('assign.rvcoins');
Route::get('show/adminprofile', [adminUserController::class, 'show_profile'])->name('admin.profile.show');
Route::post('update/adminprofile/{id}', [adminUserController::class, 'update_profile'])->name('admin.profile.update');
Route::get('/users/video/assigned/{user_id}', [adminUserController::class, 'users_video_assigned'])->name('users.video.assigned');
Route::post('/change/userrole/admin', [adminUserController::class, 'user_role'])->name('change.userrole.admin');
Route::get('/video/details/history/{video_id}/{user_id}/{user_email}', [adminUserController::class, 'video_details_history'])->name('video.details.history');
Route::get('/download/video/{id}/admin/download', [adminUserController::class, 'download_video'])->name('download.video.admin');
Route::get('/statictics/report/admin/{user_id}/{user_email}', [adminUserController::class, 'statictics_report'])->name('statictics.report.admin');
Route::post('/send/verifcation/link/{user_id}', [adminUserController::class, 'send_verifcation_link'])->name('send.verifcation.link');
Route::resource('scientificdisciplines', scientificDisciplinesController::class);
Route::resource('scientificsubdisciplines', subDisciplinesController::class);
Route::resource('subscriptionmaster', subscriptionController::class);
Route::resource('transactionbyadmin', TransactionByAdminController::class);
Route::resource('Showhidesection', ShowhidesectionController::class);
Route::resource('specialissueadmin', SpecialIssueController::class);

//Start payment routes
Route::get('/all/payment/list', [adminPaymentController::class, 'index'])->name('all.payment.list');
Route::get('/check/payment/details/{payment_id}', [adminPaymentController::class, 'check_payment_details'])->name('check.payment.details');
Route::post('/update/payment', [adminPaymentController::class, 'update_payment'])->name('update.payment');
// End payment routes
});

// Start Institute management
Route::get('all/institution/request', [InstitutionManagementController::class, 'all_institution_request'])->name('all.institution.request');
Route::get('all/institution/request/view/{id}', [InstitutionManagementController::class, 'all_institution_request_view'])->name('all.institution.request.view');
Route::post('all/institution/request/delete/{id}', [InstitutionManagementController::class, 'all_institution_request_delete'])->name('all.institution.request.delete');
Route::get('control/institution', [InstitutionManagementController::class, 'control_institution'])->name('control.institution');
Route::post('control/institution/store', [InstitutionManagementController::class, 'control_institution_store'])->name('control.institution.store');
Route::get('control/institution/edit/{id}', [InstitutionManagementController::class, 'control_institution_edit'])->name('control.institution.edit');
Route::post('control/institution/update/{id}', [InstitutionManagementController::class, 'control_institution_update'])->name('control.institution.update');
Route::get('users/institution', [InstitutionManagementController::class, 'users_institution'])->name('users.institution');
// End Institute management

Route::get('video/sort/by/admin/show', [adminCommonController::class, 'video_sort_by_admin_show'])->name('video.sort.by.admin.show');
Route::post('video/sort/by/admin/update', [adminCommonController::class, 'video_sort_by_admin_update'])->name('video.sort.by.admin.update');
Route::get('video/pagination/by/admin/show', [adminCommonController::class, 'video_pagination_by_admin_show'])->name('video.pagination.by.admin.show');
Route::post('video/pagination/by/admin/update', [adminCommonController::class, 'video_pagination_by_admin_update'])->name('video.pagination.by.admin.update');
Route::get('sort/editors/page', [adminCommonController::class, 'sort_editors_page'])->name('sort.editors.page');
Route::post('sort/editors/page/update', [adminCommonController::class, 'sort_editors_page_update'])->name('sort.editors.page.update');

// End admin routes


// Frontend routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'users_home'])->name('welcome');
Route::get('/{sortingOption}', [App\Http\Controllers\HomeController::class, 'users_home'])->name('welcome.sorting');
//Route::get('/', [MenuController::class, 'index'])->name('welcome');
Route::get('/details/video/{id}', [MenuController::class, 'video_details'])->name('video.details');


Route::get('/subscription/details', [MenuController::class, 'subscription'])->name('subscription');
Route::get('/channels', [MenuController::class, 'channels'])->name('channels');
Route::get('/single/channels', [MenuController::class, 'single_channels'])->name('single.channels');
Route::get('/video/upload', [MenuController::class, 'video_upload'])->name('video.upload');
Route::get('/page/404', [MenuController::class, 'page_404'])->name('page.404');
Route::get('/blank/page', [MenuController::class, 'blank_page'])->name('blank.page');
Route::get('/history/page', [MenuController::class, 'history_page'])->name('history.page');
Route::get('/categories/page', [MenuController::class, 'categories_page'])->name('categories.page');
Route::post('/sub/category', [MenuController::class, 'get_sub_category'])->name('sub.category');

//Frontend auth
Route::get('/member/login', [frontendAuthController::class, 'member_login'])->name('member.login');
Route::post('/members/login/post', [frontendAuthController::class, 'login'])->name('members.login.post');
Route::get('/member/register', [frontendAuthController::class, 'member_register'])->name('member.register');
Route::post('/members/register', [frontendAuthController::class, 'register'])->name('members.register');
Route::get('/reviewer/register/{email}/{majorcategory_id}/{encrypted_role}', [frontendAuthController::class, 'reviewer_register'])->name('reviewer.register'); // reviewer register
Route::post('/reviewer/register', [frontendAuthController::class, 'reviewer_register_post'])->name('reviewer.register.post'); // reviewer register
Route::post('/members/logout', [frontendAuthController::class, 'logout'])->name('members.logout');
Route::get('/user/verify/{token}', [frontendAuthController::class,'user_verify'])->name('user.verify');
Route::get('/reload/captcha', [frontendAuthController::class, 'reloadCaptcha'])->name('reload.captcha');
Route::get('/forgot/password', [frontendAuthController::class, 'forgot_password'])->name('forgot.password');
Route::post('forget-password', [frontendAuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [frontendAuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [frontendAuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('/my/profile', [frontendProfileController::class, 'my_settings'])->name('my.settings');
Route::post('/update/profile', [frontendProfileController::class, 'update_profile'])->name('update.profile');
Route::post('/change/userrole', [frontendProfileController::class, 'user_role'])->name('change.userrole');
Route::get('/my/account', [frontendProfileController::class, 'my_account'])->name('my.account');
Route::post('/account/delete/request', [frontendProfileController::class, 'account_delete_request'])->name('account.delete.request');
Route::get('/institute/user', [frontendProfileController::class, 'institute_user'])->name('institute.user');
Route::get('/institute/user/details/{id}', [frontendProfileController::class, 'institute_user_details'])->name('institute.user.details');
Route::post('/institute/user/status/update/{id}', [frontendProfileController::class, 'institute_user_status_update'])->name('institute.user.status.update');
Route::get('/account/restore', [frontendAuthController::class, 'restore_account'])->name('restore.account');
Route::post('/account/restore/post', [frontendAuthController::class, 'restore_account_post'])->name('restore.account.post');
Route::get('/user/payment/history', [frontendProfileController::class, 'user_payment_history'])->name('user.payment.history');

// Start statictics authentication
Route::get('/statistics/login', [frontendAuthController::class, 'statictics_login'])->name('statictics.login');
Route::post('/statistics/login/post', [frontendAuthController::class, 'statictics_login_post'])->name('statictics.login.post');
Route::get('/statistics/report', [StaticticsController::class, 'statictics_report'])->name('statictics.report');
// End statictics authentication

// Start video generate
Route::get('/generate/video', [GenerateVideoController::class, 'concat_video_without_video'])->name('generate.video');
Route::post('/generate/video', [GenerateVideoController::class, 'generate_video_without_video'])->name('generate.video.without.video');
Route::get('/download/generated/video/{sessionId}', [GenerateVideoController::class, 'download_generated_video'])->name('download.generated.video');
Route::post('/delete/generated/deletedirectory', [GenerateVideoController::class, 'delete_generated_deletedirectory'])->name('delete.generated.deletedirectory');
// End video generate

// Start organization authentication
Route::get('/organization/login', [frontendAuthController::class, 'organization_login'])->name('organization.login');
Route::post('/organization/login/post', [frontendAuthController::class, 'organization_login_post'])->name('organization.login.post');
Route::get('/organization/register', [frontendAuthController::class, 'organization_register'])->name('organization.register');
Route::post('/organization/register/post', [frontendAuthController::class, 'organization_register_post'])->name('organization.register.post');
Route::get('/organization/name/search', [frontendAuthController::class, 'organization_name_search'])->name('organization.name.search');
// End organization authentication

//End frontend auth

// Start video upload 
Route::resource('upload/video', VideoUploadController::class);
Route::post('/update/video/likes', [VideoUploadController::class, 'update_video_likes'])->name('update.video.likes');
Route::post('/watch/later/video', [VideoUploadController::class, 'watch_later_video'])->name('watch.later.video');
Route::post('/video/delete/{id}', [VideoUploadController::class, 'video_delete'])->name('video.delete');
Route::get('/download/video/{id}/download', [VideoUploadController::class, 'download_video'])->name('download.video');
// End video upload
Route::get('/watch/list', [MemberController::class, 'watch_list'])->name('watch.list');
Route::get('/watch/list/{sortingOption}', [MemberController::class, 'watch_list'])->name('watch.list.sorting');

Route::resource('authors/coauthors', CoauthorController::class);
Route::get('/institution/register', [MenuController::class, 'institution_register'])->name('institution.register');
Route::post('/submit/institution/register', [MenuController::class, 'submit_institution_register'])->name('submit.institution.register');
Route::get('/contact/us', [MenuController::class, 'contact_us'])->name('contact.us');
Route::get('/frequently/asked/questions', [MenuController::class, 'faq'])->name('faq');
Route::get('/societies/and/publishers', [MenuController::class, 'societies_and_publishers'])->name('societies.and.publishers');
Route::post('/submit/contact/form', [MenuController::class, 'submit_contact_form'])->name('submit.contact.form');
Route::get('/terms/condition', [MenuController::class, 'terms_n_condition'])->name('terms.condition');
Route::get('/about/us', [MenuController::class, 'about'])->name('about');
Route::get('/category/video/{id}', [MenuController::class, 'category_wise_video'])->name('category.wise.video');
Route::get('/category/video/{id}/{sortingOption}', [MenuController::class, 'category_wise_video'])->name('category.wise.video.sorting');
Route::get('/video/{id}/subcategory', [MenuController::class, 'sub_category_wise_video'])->name('sub.category.wise.video');
Route::get('/video/{id}/{sortingOption}/subcategory', [MenuController::class, 'sub_category_wise_video'])->name('sub.category.wise.video.sorting');
Route::get('/editorial/board/{id}', [MenuController::class, 'editorial_board_wise_video'])->name('editorial.board.wise.video');
Route::post('/user/detail/{id}', [MenuController::class, 'user_details'])->name('user.details');
Route::get('/editorial/member', [MenuController::class, 'editorial_board_members'])->name('all.editorial.board.member');
Route::get('/site/map', [MenuController::class, 'site_map'])->name('site.map');
Route::get('/invite/new/member/{id}', [MenuController::class, 'invite_new_member'])->name('invite.new.member');
Route::post('/invite/new/member/post', [MenuController::class, 'invite_member_send'])->name('invite.member.send');
Route::get('/test/crop/video', [MenuController::class, 'test_crop_video']);
Route::get('/video/generation', [MenuController::class, 'video_generation'])->name('video.generation');
Route::get('/data/sharing', [MenuController::class, 'data_sharing'])->name('data.sharing');
Route::get('/special/issue', [MenuController::class, 'special_issue'])->name('special.issue');
// Start advanced search
Route::get('/advance/search', [MenuController::class, 'advance_search_view'])->name('show.advance.search');
Route::get('/advance/search/result', [MenuController::class, 'advance_search_post'])->name('post.advance.search');
Route::get('/advance/search/all', [MenuController::class, 'all_search_get'])->name('show.all.search');
Route::get('/advance/search/all/result', [MenuController::class, 'all_search_post'])->name('post.all.search');
// End advanced search
Route::post('/post/newsletter', [MenuController::class, 'post_newsletter'])->name('post.newsletter');
Route::get('/newsletter/unscubscribe/{email}', [MenuController::class, 'newsletter_unscubscribe'])->name('newsletter.unscubscribe');
Route::get('/rvoi/search', [MenuController::class, 'search_by_rvoi_link'])->name('search.by.rvoi.link');
Route::get('/rvoi/search/get/data', [MenuController::class, 'search_by_rvoi_link_get_data'])->name('search.by.rvoi.link.get.data');
Route::get('/export/bibtex/{id}', [MenuController::class, 'export_bibtex'])->name('export.bibtex');
Route::get('/guide/for/authors', [MenuController::class, 'guide_for_authors'])->name('guide.for.authors');
Route::get('video/tutorials', [MenuController::class, 'tutorials'])->name('tutorials');
Route::get('/publishing/licence/options', [MenuController::class, 'open_science'])->name('open.science');
Route::get('/authors/services', [MenuController::class, 'authors_services'])->name('authors.services');
Route::get('/video/image/{unique_number}/showVideoImage', [MenuController::class, 'showVideoImage'])->name('show_video_images');

// Start for history maintain
Route::post('/editor/in/chief/store/history', [HistoryController::class, 'editor_in_chief_store_history'])->name('editor.in.chief.store.history');
Route::post('/store/history/by/editorial/member', [HistoryController::class, 'store_history_by_editorial_member'])->name('store.history.by.editorial.member');
Route::post('/store/history/by/reviewer', [MenuController::class, 'store_history_by_reviewer'])->name('store.history.by.reviewer');
Route::get('/reviewer/acceptance/{reviewer_email}/{video_id}/{majorcategory_id}/{video_history_id}', [MenuController::class, 'reviewer_acceptance'])->name('reviewer.acceptance');
Route::post('/store/history/by/reviewer/afterlogin', [HistoryController::class, 'store_history_by_reviewer_login'])->name('store.history.by.reviewer.after.login');
Route::post('/pass/to/another/editorial/member', [HistoryController::class, 'pass_to_another_editorial_member'])->name('pass.to.another.editorial.member');

Route::post('/store/history/by/corresponding/author', [MenuController::class, 'store_history_by_corresponding_author'])->name('store.history.by.corresponding.author');
Route::get('/corrauthor/acceptance/{corrauthor_email}/{video_id}/{majorcategory_id}', [MenuController::class, 'corrauthor_acceptance'])->name('corrauthor.acceptance');
Route::post('/store/history/by/publisher', [HistoryController::class, 'store_history_by_publisher'])->name('store.history.by.publisher');
Route::post('/show/history/messages', [HistoryController::class, 'show_history_messages'])->name('show.history.messages');
Route::post('/show/history/messages/visibility', [HistoryController::class, 'show_history_messages_visibility'])->name('update.history.message.visibility');
Route::post('/show/history/messages/visibility', [HistoryController::class, 'show_history_messages_visibility'])->name('update.history.message.visibility');
Route::post('/withdraw/reviewerss', [HistoryController::class, 'withdraw_reviewer'])->name('withdraw.reviewer');
Route::post('/withdraw/video/{id}', [HistoryController::class, 'withdraw_video'])->name('withdraw.video');
Route::post('/editor/store/reviewer', [HistoryController::class, 'editor_store_reviewer'])->name('editor.store.reviewer');
// End for history maintain

// Start check for video payment status
Route::get('/video/{videoId}/isfree', [MenuController::class, 'isFree'])->name('video.isFree');
Route::get('/video/{videoId}/ispaid', [MenuController::class, 'isPaid'])->name('video.isPaid');
Route::get('/video/{videoId}/haspaid', [MenuController::class, 'hasPaid'])->name('video.hasPaid');
Route::get('/video/{videoId}/ismember', [MenuController::class, 'isMember'])->name('video.isMember');
Route::get('/user/ismembershipactive', [MenuController::class, 'isMembershipActive'])->name('user.isMembershipActive');
Route::get('/subscription/plan', [MenuController::class, 'subscription_plan'])->name('subscription.plane');
Route::get('/video/{videoId}/registerView', [MenuController::class, 'video_register_view'])->name('video.registerView');
Route::get('/video/show/player/{filename}/{type}/{video_id}', [MenuController::class, 'show_videos'])->name('video.player.show');
Route::get('video/key/{key}/{main_folder_name}/{category_folder_name}/{unique_number}', [MenuController::class, 'video_key'])->name('video.key');
// End check for video payment status

//Start payment
Route::post('handle-paypal-payment', [PaymentController::class, 'handlePaypalPayment'])->name('make.paypal.payment');
Route::post('handle-paypal-payment-credit', [PaymentController::class, 'handleCreditCardPayment'])->name('credit.card.payment');
Route::get('cancel-paypal-payment', [PaymentController::class, 'paymentPaypalCancel'])->name('cancel.paypal.payment');
Route::get('payment-paypal-success/{encrypted_video_id}', [PaymentController::class, 'paymentPaypalSuccess'])->name('success.paypal.payment');
Route::post('update/wiretransfer/payment', [PaymentController::class, 'update_wiretransfer_payment'])->name('update.wiretransfer.payment');
Route::post('update/wiretransfer/payment/subscription', [PaymentController::class, 'update_wiretransfer_payment_subscription'])->name('update.wiretransfer.payment.subscription');
Route::post('update/paypal/subscription', [PaymentController::class, 'update_paypal_subscription'])->name('update.paypal.subscription');
Route::post('update/paypal/payment/for/single/video', [PaymentController::class, 'update_paypal_payment_for_single_video'])->name('update.paypal.payment.for.single.video');
Route::post('update/rvcoins/payment', [PaymentController::class, 'update_rvcoins_payment'])->name('update.rvcoins.payment');
Route::post('update/rvcoins/subscription/payment', [PaymentController::class, 'update_rvcoins_payment_subscription'])->name('update.rvcoins.payment.subscription');
Route::get('success/page', [PaymentController::class, 'success_page'])->name('success.page');


//Route::get('subscription-payment', [PaymentController::class, 'Subscription']);
//End payment

Route::post('cookie/consent/save', [CommonController::class, 'cookie_consent_save'])->name('cookie.consent.save');
Route::get('change/theme', [CommonController::class, 'change_theme'])->name('change.theme');
// End frontend routes
