<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/fb_redirect', ['as'=>'fb_redirect','uses'=>'SocialController@fb_redirect']);
Route::get('/fb_callback', ['as'=>'fb_callback','uses'=>'SocialController@fb_callback']);
Route::get('/li_redirect', ['as'=>'li_redirect','uses'=>'SocialController@li_redirect']);
Route::get('/li_callback', ['as'=>'li_callback','uses'=>'SocialController@li_callback']);

Route::get('import-old-data','Web\LoginController@dataImport');
// admin routes
Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::get('login','UserController@index')->name('login');
    Route::post('check_user','UserController@login');
    //  Route::middleware(['auth','adminAuth'])->group(function () {
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard','DashboardController@index');
        Route::get('logout','UserController@logout');

        Route::resource('sub-admins','SubAdminController');
        Route::resource('transactions','TransactionController');
        
        Route::get('project-wise-summary','ReportController@projectWiseSummary');
        Route::get('disputed-project-wise-summary','ReportController@disputedProjectWiseSummary');
        Route::get('terminated-project-wise-summary','ReportController@terminatedProjectWiseSummary');
        Route::get('talent-performance-rating','ReportController@talentsPerformanceRatings');
        Route::get('skills-wise-summary','ReportController@skillsWiseSummary');

        Route::get('export-projectwisesummary-pdf','ReportController@exportProjectWiseSummaryPdf')->name('export-projectwisesummary-pdf');
        Route::get('export-projectwisesummary-excel','ReportController@exportProjectWiseSummaryExcel')->name('export-projectwisesummary-excel');


        Route::get('revenue-summary','RevenueController@getSummary');
        Route::get('revenue-summary-graph','RevenueController@revenueSummaryGraphs');
        Route::get('talent-summary','TalentController@getSummary');
        Route::get('talent-summary-graph','TalentController@talentSummaryGraphs');
        Route::get('client-summary','ClientController@getSummary');
        Route::get('client-summary-graph','ClientController@clientSummaryGraphs');
        Route::get('profit-summary','RevenueController@getProfitSummary');
        Route::get('profit-summary-graph','RevenueController@profitSummaryGraphs');
        Route::resource('revenue','RevenueController');
        Route::resource('wallet-balance','WalletController');
        Route::resource('clients','ClientController');
        Route::resource('talents','TalentController');
        Route::get('talents/edit_docx/{id}','TalentController@edit_docx');

        Route::resource('coupon','CouponController');
        Route::get('disputed-projects','ProjectController@getDisputedProjects');
        
        Route::get('milestone-invoice/{project_id}/{payment_id}','ProjectController@milestoneInvoice');
        
        Route::resource('projects','ProjectController');
        
        Route::get('prfile_screen','TalentController@profileScreening')->name('prfile_screen');
        Route::get('apptitude_test_attachment','TalentController@attachAptitudeTest')->name('apptitude_test_attachment');
        Route::get('aptitude_action','TalentController@aptitudeAction')->name('aptitude_action');
        Route::get('techinical_test_attachment','TalentController@attachTechnicalTest')->name('technical_test_attachment');
        Route::get('technical_action','TalentController@technicalAction')->name('technical_action');
        Route::get('interview_action','TalentController@interviewAction')->name('interview_action');
        Route::get('send_interview_invite','TalentController@sendInterviewInvite')->name('send_interview_invite');
        
        Route::post('udpate_hourly_price','TalentController@udpate_hourly_price')->name('udpate_hourly_price');

        Route::resource('faqs','FaqController');
        Route::resource('escalations','EscalationController');
        Route::resource('categories','CategoryController');
        Route::resource('skills','SkillController');
        Route::resource('comission','ComissionController');
        Route::post('resolve/esclaration/issue','EscalationController@resolveEsclarationIssue')->name('resolve_esclaration_issue');
        // Route::resource('reviews','ReviewController');
        Route::get('client_reviews','ReviewController@clientReviews')->name('client_reviews');
        Route::get('talent_reviews','ReviewController@talentReviews')->name('talent_reviews');
        Route::get('edit_review/{id}','ReviewController@editReview')->name('edit_review'); 
        Route::get('delete_review/{id}','ReviewController@deleteReview')->name('delete_review');
        Route::post('update_review','ReviewController@updateReview')->name('update_review');

        Route::get('aboutus','SiteContentController@getAboutUsContent');
        Route::post('save-aboutus','SiteContentController@updateAboutUsContent');

        Route::get('contactus','SiteContentController@getContactUsContent');
        Route::post('save-contactus','SiteContentController@updateContactUsContent');

        Route::get('privacypolicy','SiteContentController@getPrivacyPolicyContent');
        Route::post('save-privacypolicy','SiteContentController@updatePrivacyPolicyContent');

        Route::get('sitecontent/{slug}','SiteContentController@getSiteContent');
        Route::post('save-sitecontent','SiteContentController@saveSiteContent');

        Route::get('payment-details','SettingController@getPaymentDetailsPage');

        Route::get('profile','ProfileController@getProfilePage'); 
        Route::get('export-talent','TalentController@export')->name('export-talent');
        Route::get('export-client','ClientController@export')->name('export-client');
        Route::get('export-projects','ProjectController@export')->name('export-projects');
        Route::get('export-revenues','RevenueController@export')->name('export-revenues');
        Route::get('export-revenues-pdf','RevenueController@exportPdf')->name('export-revenues-pdf');
        Route::get('export-sub-admin','SubAdminController@export')->name('export-sub-admin');
        Route::get('export-wallet-detail','WalletController@export')->name('export-wallet-detail');

        Route::get('change-password','UserController@getChangePassword')->name('admin-getChangePassword');
        Route::post('change-password','UserController@updateChangePassword')->name('admin-updateChangePassword');
    });
});


Route::namespace('Web')->group(function () {
    Route::get('/','HomeController@index')->name('home');
    Route::get('/thanks','HomeController@thanksPage')->name('test_sucess');
    Route::get('/categories','HomeController@categories')->name('categories');
    Route::get('/payment-template','MangoPayController@paymentTemplate')->name('payment-template');

    Route::match(['get', 'post'],'/social_web','HomeController@socialWeb')->name('social_web');
    Route::match(['get','post'],'/forgot-password','LoginController@forgotPassword')->name('client_forgot_password');
    Route::match(['get','post'],'/reset-password','LoginController@resetPassword')->name('client_reset_password');
    Route::get('talent/login','LoginController@logintalent')->name('talent_login');
    Route::resource('login','LoginController'); 
    Route::resource('signup','SignupController');
    Route::get('check/coupon/client','SignupController@checkAppliedCouponClient')->name('check_applied_coupon_client');

    Route::get('/faq','HomeController@getFaqs')->name('getFaqs');
    Route::get('/adb','HomeController@getAdbPage')->name('getAdbPage');
    Route::get('/why-work-with-us','HomeController@getWhyWorkWithUsPage')->name('getWhyWorkWithUsPage');
    Route::get('/payment-safety','HomeController@getPaymentSafetyPage')->name('getPaymentSafetyPage');
    Route::get('/about-us','HomeController@getAboutUs')->name('getAboutUs');
    Route::get('/our-process','HomeController@getOurProcess')->name('getOurProcess');
    
    Route::get('/privacy-policy','HomeController@getPrivacyPolicy')->name('getPrivacyPolicy');
    Route::get('/client-terms-service','HomeController@getClientTermsService')->name('getClientTermsService');
    Route::get('/todder-terms-service','HomeController@getTodderTermsService')->name('getTodderTermsService');
    Route::get('/reset-success','LoginController@resetSuccess')->name('resetSuccess');
    Route::get('/site-error/{message}','LoginController@siteError')->name('siteError');
    Route::post('save_visit','HomeController@saveVisit')->name('save_visit');

    Route::get('/contact-us','HomeController@getContactUs')->name('getContactUs');
    Route::post('/save-contact-us','HomeController@saveContactUs')->name('saveContactUs');

    // talent routes
    Route::namespace('Talent')->prefix('talent')->group(function () {

        Route::post('talent-signup','SingupController@store')->name('talent-signup');
        Route::resource('signup','SingupController');
        Route::get('check/coupon','SingupController@checkAppliedCoupon')->name('check_applied_coupon');

        Route::middleware(['auth'])->group(function () {
            
            Route::middleware(['talentTestAuth'])->group(function () {
                Route::resource('test_status','TestStatusController');
                Route::get('hours/status','TestStatusController@talentHourApproval')->name('talent_hour_approval');
                Route::match(['get','post'],'email_verify','SingupController@emailVarification')->name('talent_email_verify');
                Route::post('emailVarificationResend','SingupController@emailVarificationResend')->name('emailVarificationResend');

                Route::match(['get','post'],'signup_work','SingupController@signupWork')->name('signup_work');
                Route::post('search_skill','SingupController@searchSkill')->name('talent_search_skill');
                Route::match(['post'],'validate_otp','SingupController@validateOtp')->name('talentValidateOtp');
            });

            
            Route::post('/talent_upload_image','SingupController@fileUpload')->name('talent-upload-image');
            Route::post('/upload-talent-resume','SingupController@uploadTalentResume')->name('upload-talent-resume');
            Route::post('/talent_file_delete','SingupController@filedelete')->name('talent-file-delete');

            Route::post('talent_profile_update','ProfileController@updateProfile')->name('talent_profile_update');
            Route::post('talent_workexp_update','ProfileController@updateWorkExperience')->name('talent_workexp_update');


            Route::middleware(['talentAuth'])->group(function () {
                Route::get('profile','ProfileController@index')->name('talent_profile');
                
                Route::get('dashboard','DashboardController@index')->name('talent_dashboard');
               
                Route::post('accept_action','DashboardController@acceptAction')->name('accept_action');
                Route::post('reject_action','DashboardController@rejectAction')->name('reject_action');
                Route::get('project/{id}','DashboardController@show')->name('talent_project_detail');
                Route::get('milestone/overview/{id}','ProjectMileStoneContoller@overview')->name('milestone_overview');
                
                Route::get('milestone-invoice/{project_id}/{payment_id}','ProjectMileStoneContoller@milestoneInvoice');

                Route::get('project/overview/{id}','ProjectMileStoneContoller@projectOverview')->name('project_overview');
               
                Route::post('complete-ordispute-project','ProjectMileStoneContoller@markCloseOrDisputeProject');

                Route::match(['get','post'],'milestone/create/{id}','ProjectMileStoneContoller@createMileStone')->name('milestone_create');
                Route::get('message/{project_id}/{todz_id}','MessageController@chatScreen');
                
                Route::resource('message','MessageController');
                
                Route::post('raise_escalation','ProjectMileStoneContoller@raiseEscalation')->name('raise_escalation');
                // Route::get('profile','ProfileController@index');

                
                Route::get('fetch_invited_project', 'DashboardController@fetch_invited_projects')->name('fetch_invited_project');
                Route::get('fetch_upcomming_project', 'DashboardController@fetch_upcomming_project'); 
                Route::post('start_timer', 'ProjectMileStoneContoller@startTimer')->name('start_timer'); 
                Route::post('create_timesheet', 'ProjectMileStoneContoller@createTimeSheet')->name('create_timesheet'); 
                Route::post('timesheetfile_load', 'ProjectMileStoneContoller@fileUpload')->name('timesheetfile_load'); 
                Route::post('timesheetfiledelete', 'ProjectMileStoneContoller@timesheetfiledelete')->name('timesheetfiledelete'); 

                

                Route::get('add-gst-details','ProfileController@addGstVatDetails')->name('talent_get_gst_details');
                Route::post('save-gst-details','ProfileController@saveGstVatDetails')->name('talent_add_gst_vat_details');
            });
        });
    });
    
    Route::middleware(['loggedUser'])->group(function () {
        Route::prefix('mangopay')->group(function () {
            Route::get('/add_user','MangoPayController@index')->name('add_user');
            Route::post('/create_wallet','MangoPayController@createUserWallet')->name('create_wallet');
            Route::get('/add_card','MangoPayController@addCard')->name('add_card');
            Route::post('/save_card','MangoPayController@saveCard')->name('save_card');
            Route::get('/payment-template','MangoPayController@paymentTemplate')->name('payment-template');
            
            Route::get('/add_payment_to_wallet','MangoPayController@addPaymentToWallet')->name('add_payment_to_wallet');
            Route::post('/create_payment_link','MangoPayController@createPaymentLink')->name('create_payment_link');
            Route::get('/thanks','MangoPayController@thanks')->name('mango_thanks');
            Route::post('/set_default_card','MangoPayController@setDefaultCard')->name('set_default_card');
            Route::get('add_bank','MangoPayController@addBank')->name('add_bank');
            Route::post('save_bank_detail','MangoPayController@saveBankdetail')->name('save_bank_detail');
            
            // kyc documents
            Route::get('kyc_doc','MangoPayController@kycDoc')->name('kyc_doc');
            Route::post('uploadKycDoc','MangoPayController@uploadKycDoc')->name('uploadKycDoc');
            
            // payouts
            Route::post('createPayoutToBank','MangoPayController@createPayoutToBank')->name('createPayoutToBank');
            Route::get('list-payout','MangoPayController@payoutList')->name('list-payout'); 
        });
    });

    Route::middleware(['auth'])->group(function () {
        Route::post('/deactivate-account','SignupController@deactivateAccount')->name('deactivate-account');
        Route::match(['get','post'],'/email_varification','SignupController@emailVarification')->name('email_varification');
        Route::match(['post'],'/validate_otp','SignupController@validateOtp')->name('validateOtp');
        Route::get('resend_otp','SignupController@resendOtp')->name('resend_otp');
        Route::get('logout','LoginController@logout')->name('web_logout');
        Route::post('upload-profile-image','ProfileController@uploadProfileImage')->name('upload-profile-image');
        Route::post('change_password','ProfileController@changePassword')->name('talent-change-password');
        Route::resource('notifications','NotificationController');

        // client routes
        Route::namespace('Client')->prefix('client')->middleware(['clientAuth'])->group(function () {
            Route::get('dashboard','DashboardController@index')->name('client_dashboard');
            Route::get('milestone-invoice/{project_id}/{payment_id}','ProjectController@milestoneInvoice');
           
            Route::get('project/{id}/{todz}/show','ProjectController@showCompleteProject')->name('show_complete_project');
            Route::post('project/{rating_number}/{todz_id}/sendRating','ProjectController@sendRating')->name('sendRating');

            Route::post('search_skill','ProjectController@searchSkill')->name('search_skill');
            Route::match(['get','post'],'step_2','ProjectController@stepTwo')->name('step_2');
            Route::match(['get','post'],'step_3','ProjectController@stepThree')->name('step_3');
            Route::get('message/{project_id}/{todz_id}','MessageController@chatScreen');
            Route::resource('message','MessageController');
            Route::post('update/milestone/status','ProjectMileStoneContoller@updateMilestoneStatus')->name('update_milestone_status');
            Route::match(['get','post'],'add-toder/{project_id}','ProjectController@addAdditionalTodder')->name('add_additional_todder');
            Route::resource('project','ProjectController');
            Route::post('/file-upload','ProjectController@fileUpload')->name('project-file-upload');
            Route::post('/file-delete','ProjectController@projectfiledelete')->name('project-file-delete');
            Route::get('profile','ProfileController@index');
            Route::match(['get','post'],'hire_todder','ProjectController@hiredTodder');
            Route::get('fetch_posted_project', 'DashboardController@fetch_posted_projects')->name('fetch_posted_project');
            Route::match(['get','post'],'add_remaining_payment','ProjectController@add_remaining_payment');

            // delete client project in which todder not hired
            Route::post('/end-project','ProjectController@deleteClientProject')->name('end-project');
            // mark project as dispute or complete
            Route::post('/close-project','ProjectController@closeClientProject')->name('close-project');
            Route::post('/timesheet-status','ProjectMileStoneContoller@updateTimesheetStatus')->name('update_timesheet_status');

            Route::post('client_profile_update','ProfileController@updateProfile')->name('client_profile_update');
            Route::get('add-gst-details','ProfileController@addGstVatDetails');
            Route::post('save-gst-details','ProfileController@saveGstVatDetails')->name('client_add_gst_vat_details');

        });
    });
    
});