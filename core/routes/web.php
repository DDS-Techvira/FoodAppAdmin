<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/payment', function () {
    return view('payments.data_sending');
});

Route::get('/paymentbook', function () {
    return view('payments.book_payment');
});

Route::get('/paymentWeb', function () {
    return view('payments.web_payment');
})->name('paymentWeb.appointment');
Route::get('/bookpurchase/{id}', 'SiteController@buyBook')->name('book.purchase');
Route::get('/bookpaymentWeb', function () {
    return view('payments.web_book_payment');
})->name('paymentWeb');

Route::get('/purchase-history', 'SiteController@purchseHistory')->name('purchasehistory');

Route::get('/getDownload/{id}', 'SiteController@getDownload')->name('book.download');

/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/
Route::namespace('admin')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
    });
});

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify-code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

        //Sector - Category
        Route::get('sector', 'ManageDoctorsController@sectors')->name('sector');
        Route::get('category/new_category', 'ManageDoctorsController@newCategory')->name('category.new');
        Route::post('sector/new', 'ManageDoctorsController@storeSectors')->name('sector.store');
        Route::get('category/detail/{id}', 'ManageDoctorsController@detailCategory')->name('category.detail');
        Route::post('sector/update/{id}', 'ManageDoctorsController@updateSectors')->name('sector.update');

        //Author
        Route::get('author', 'AuthorController@AllAuthors')->name('author.all');
        Route::get('author/new', 'AuthorController@newAuthors')->name('author.new');
        Route::post('author/store', 'AuthorController@storeAuthors')->name('author.store');
        Route::get('author/detail/{id}', 'AuthorController@detail')->name('author.detail');
        Route::post('author/update/{id}', 'AuthorController@update')->name('author.update');

        //Admins
        Route::get('admin', 'AdminController@AllAdmins')->name('admin.all');
        Route::get('admin/new', 'AdminController@newAdmins')->name('admin.new');
        Route::post('admin/store', 'AdminController@storeAdmins')->name('admin.store');
        Route::get('admin/detail/{id}', 'AdminController@detail')->name('admin.detail');
        Route::post('admin/update/{id}', 'AdminController@update')->name('admin.update');
        Route::post('admin/password/reset/{id}', 'AdminController@passwordReset')->name('admin.password.reset');

        //Video
        Route::get('my_video', 'AuthorController@AllVideos')->name('my_video.all');
        Route::get('my_video/new', 'AuthorController@newVideo')->name('my_video.new');
        Route::post('my_video/store', 'AuthorController@storeVideo')->name('my_video.store');

        //Reports
        Route::get('reports/chats', 'ManageReportController@chatReport')->name('chatReport.all');
        Route::get('reports/calls', 'ManageReportController@callReport')->name('callReport.all');
        Route::get('reports/users', 'ManageReportController@userReport')->name('userReport.all');
        Route::get('my_video/new', 'AuthorController@newVideo')->name('my_video.new');
        Route::post('my_video/store', 'AuthorController@storeVideo')->name('my_video.store');

        // Chat
        Route::get('chats/coaching_question/{tab?}', 'ManageChatCotroller@coachingQuestion')->name('chats.coaching_question');
        Route::get('chats/technical_support/{tab?}', 'ManageChatCotroller@technicalSupport')->name('chats.technical_support');
        Route::get('chats/leave_feedback', 'ManageChatCotroller@leaveFeedback')->name('chats.leave_feedback');
        Route::get('chats/other/{tab?}', 'ManageChatCotroller@other')->name('chats.other');
        Route::get('chats/{chat}/{id}/close', 'ManageChatCotroller@closeConversation')->name('chats.conversation.close');
        Route::get('chats/{chat}/{id}/accept', 'ManageChatCotroller@acceptConversation')->name('chats.conversation.accept');
        Route::post('chats/{chat}/{id}/submit', 'ManageChatCotroller@submitMessage')->name('chats.conversation.submit');
        Route::get('chats/{chat}/{id}/updates', 'ManageChatCotroller@_ajaxGetChatUpdate')->name('chats.get_chat_update');
        Route::get('chats/{chat}/{tab}/{id}', 'ManageChatCotroller@conversation')->name('chats.conversation');

        //Posts
        Route::get('posts/all', 'PostController@postsAll')->name('posts.all');
        Route::get('posts/new', 'PostController@newPost')->name('posts.new');
        Route::post('posts/update/{id}', 'PostController@postsUpdate')->name('posts.update');
        Route::delete('posts/remove/{id}', 'PostController@postsRemove')->name('posts.remove');
        Route::post('postsImage/upload', 'PostController@uploadpostsImage')->name('posts.upload');
        Route::post('posts/store', 'PostController@postsStore')->name('posts.store');
        Route::get('posts/detail/{id}', 'PostController@detail')->name('posts.detail');
        Route::get('posts/download/{name}', 'PostController@postDocDownload')->name('posts.download');
        Route::get('posts/{scope}/search', 'PostController@search')->name('posts.search');

        //Webinar
        Route::get('webinar/all', 'WebinarController@webinarAll')->name('webinar.all');
        Route::get('webinar/new', 'WebinarController@newWebinar')->name('webinar.new');
        Route::post('webinar/update/{id}', 'WebinarController@webinarUpdate')->name('webinar.update');
        Route::delete('webinar/remove/{id}', 'WebinarController@webinarRemove')->name('webinar.remove');
        Route::post('webinar/upload', 'WebinarController@uploadwebinarImage')->name('webinar.upload');
        Route::post('webinar/store', 'WebinarController@webinarStore')->name('webinar.store');
        Route::get('webinar/detail/{id}', 'WebinarController@detail')->name('webinar.detail');
        Route::get('webinar/download/{name}', 'WebinarController@webinarDocDownload')->name('webinar.download');
        Route::get('webinar/{scope}/search', 'WebinarController@search')->name('webinar.search');
        Route::get('webinarusers/detail/{id}', 'WebinarController@detail')->name('webinarUsers.detail');
        Route::get('webinarusers/manage/{id}', 'WebinarController@webinarUsers')->name('webinarUsers.manage');
        Route::post('webinarusers/activate', 'WebinarController@activate')->name('webinarusers.activate');
        Route::post('webinarusers/deactivate', 'WebinarController@deactivate')->name('webinarusers.deactivate');
        Route::get('webinarusers/delete/{code}', 'WebinarController@delete')->name('webinar.delete');
        
        //Sector
        Route::get('books', 'BooksController@books')->name('books');
        Route::post('books/store', 'BooksController@storeBooks')->name('books.store');
        Route::delete('books/remove/{id}', 'BooksController@bookRemove')->name('books.remove');
        Route::post('books/update/{id}', 'BooksController@updateBooks')->name('books.update');
        Route::post('books/upload', 'BooksController@booksUpload')->name('books.upload');

        //Location
        Route::get('location', 'ManageDoctorsController@locations')->name('location');
        Route::post('location/new', 'ManageDoctorsController@storelocations')->name('location.store');
        Route::post('location/update/{id}', 'ManageDoctorsController@updatelocations')->name('location.update');

        // Doctors Manager
        // Route::get('doctors', 'ManageDoctorsController@allDoctors')->name('doctors.all');
        // Route::get('doctors/new', 'ManageDoctorsController@newDoctor')->name('doctors.new');
        // Route::post('doctors/store', 'ManageDoctorsController@storeDoctor')->name('doctors.store');
        Route::get('doctor/detail/{id}', 'ManageDoctorsController@detail')->name('doctors.detail');
        // Route::post('doctor/update/{id}', 'ManageDoctorsController@update')->name('doctors.update');

        // Route::get('doctors/active', 'ManageDoctorsController@activeDoctors')->name('doctors.active');
        // Route::get('doctors/banned', 'ManageDoctorsController@bannedDoctors')->name('doctors.banned');
        // Route::get('doctors/email-verified', 'ManageDoctorsController@emailVerifiedDoctors')->name('doctors.emailVerified');
        // Route::get('doctors/email-unverified', 'ManageDoctorsController@emailUnverifiedDoctors')->name('doctors.emailUnverified');
        // Route::get('doctors/sms-unverified', 'ManageDoctorsController@smsUnverifiedDoctors')->name('doctors.smsUnverified');
        // Route::get('doctors/sms-verified', 'ManageDoctorsController@smsVerifiedDoctors')->name('doctors.smsVerified');
        // Route::get('doctors/{scope}/search', 'ManageDoctorsController@search')->name('doctors.search');

        // Coaches Manager
        Route::get('coaches', 'ManageCoachesController@allCoaches')->name('coaches.all');
        Route::get('coaches/new', 'ManageCoachesController@newCoach')->name('coaches.new');
        Route::post('coaches/store', 'ManageCoachesController@storeCoach')->name('coaches.store');
        Route::get('coaches/detail/{id}', 'ManageCoachesController@detail')->name('coaches.detail');
        Route::post('coaches/update/{id}', 'ManageCoachesController@update')->name('coaches.update');
        Route::post('coaches/password/reset/{id}', 'ManageCoachesController@passwordReset')->name('coaches.password.reset');
        Route::get('coaches/schedule/{id}', 'ManageCoachesController@schedule')->name('coaches.schedule');

        Route::get('coaches/availability', 'ManageCoachesController@allCoachesForAvailability')->name('availabilityCoach.all');
        Route::get('coaches/availabilityList/{id}', 'ManageCoachesController@allAvailabilityOfCoach')->name('coachavailabilityList.all');
        Route::get('coaches/availabilityDelete/{id}', 'ManageCoachesController@deleteAvailabilityOfCoach')->name('coachavailability.delete');
        Route::get('coaches/active', 'ManageCoachesController@activeDoctors')->name('coaches.active');
        Route::get('coaches/banned', 'ManageCoachesController@bannedDoctors')->name('coaches.banned');
        Route::get('coaches/email-verified', 'ManageCoachesController@emailVerifiedDoctors')->name('coaches.emailVerified');
        Route::get('coaches/email-unverified', 'ManageCoachesController@emailUnverifiedDoctors')->name('coaches.emailUnverified');
        Route::get('coaches/sms-unverified', 'ManageCoachesController@smsUnverifiedDoctors')->name('coaches.smsUnverified');
        Route::get('coaches/sms-verified', 'ManageCoachesController@smsVerifiedDoctors')->name('coaches.smsVerified');
        Route::get('coaches/{scope}/search', 'ManageCoachesController@search')->name('coaches.search');
        Route::post('coaches/scheduleManage', 'ManageCoachesController@scheduleManage')->name('scheduleManage.store');
        Route::post('coaches/schedule/update/{code}/{date?}', 'ManageCoachesController@scheduleEditUpdate')->name('scheduleEdit.update');
        Route::get('coaches/schedule/edit/{code}/{date?}', 'ManageCoachesController@scheduleEditGet')->name('scheduleEdit.all');
        
        // Principals Manager
        Route::get('principals', 'ManagePrincipalsController@allPrincipals')->name('principals.all');
        Route::get('principals/new', 'ManagePrincipalsController@newCoach')->name('principals.new');
        Route::post('principals/store', 'ManagePrincipalsController@storeCoach')->name('principals.store');
        Route::get('principals/detail/{id}', 'ManagePrincipalsController@detail')->name('principals.detail');
        Route::post('principals/update/{id}', 'ManagePrincipalsController@update')->name('principals.update');
        Route::get('principals/add-available/{id}', 'ManagePrincipalsController@addBankHours')->name('principals.addAvailable');
        Route::post('principals/updateBankHours', 'ManagePrincipalsController@updateBankHours')->name('principals.updateBankHours');
        Route::post('principals/password/reset/{id}', 'ManagePrincipalsController@passwordReset')->name('principals.password.reset');
        Route::post('principals/resetBankHours/{id}', 'ManagePrincipalsController@resetBankHours')->name('principals.resetBankHours');
        

        Route::get('principals/active', 'ManagePrincipalsController@activeDoctors')->name('principals.active');
        Route::get('principals/banned', 'ManagePrincipalsController@bannedDoctors')->name('principals.banned');
        Route::get('principals/email-verified', 'ManagePrincipalsController@emailVerifiedDoctors')->name('principals.emailVerified');
        Route::get('principals/email-unverified', 'ManagePrincipalsController@emailUnverifiedDoctors')->name('principals.emailUnverified');
        Route::get('principals/sms-unverified', 'ManagePrincipalsController@smsUnverifiedDoctors')->name('principals.smsUnverified');
        Route::get('principals/sms-verified', 'ManagePrincipalsController@smsVerifiedDoctors')->name('principals.smsVerified');
        Route::get('principals/{scope}/search', 'ManagePrincipalsController@search')->name('principals.search');


        //Doctor Login History
        // Route::get('doctors/login/history/{id}', 'ManageDoctorsController@doctorLoginHistory')->name('doctors.login.history.single');
        // Route::get('doctors/login/history', 'ManageDoctorsController@loginHistory')->name('doctors.login.history');
        // Route::get('doctors/login/ipHistory/{ip}', 'ManageDoctorsController@loginIpHistory')->name('doctors.login.ipHistory');

        // Route::get('doctors/send-email', 'ManageDoctorsController@showEmailAllForm')->name('doctors.email.all');
        // Route::post('doctors/send-email', 'ManageDoctorsController@sendEmailAll')->name('doctors.email.send');
        // Route::get('doctor/send-email/{id}', 'ManageDoctorsController@showEmailSingleForm')->name('doctors.email.single');
        // Route::post('doctor/send-email/{id}', 'ManageDoctorsController@sendEmailSingle')->name('doctors.email.single');

        // Assistant Manager
        // Route::get('assistants', 'ManageAssistantController@allAssistants')->name('assistants.all');
        // Route::get('assistant/new', 'ManageAssistantController@newAssistant')->name('assistants.new');
        // Route::post('assistant/store', 'ManageAssistantController@storeAssistant')->name('assistants.store');
        // Route::get('assistant/detail/{id}', 'ManageAssistantController@detail')->name('assistants.detail');
        // Route::post('assistant/update/{id}', 'ManageAssistantController@update')->name('assistants.update');

        // Route::get('assistants/active', 'ManageAssistantController@activeAssistants')->name('assistants.active');
        // Route::get('assistants/banned', 'ManageAssistantController@bannedAssistants')->name('assistants.banned');
        // Route::get('assistants/email-verified', 'ManageAssistantController@emailVerifiedAssistants')->name('assistants.emailVerified');
        // Route::get('assistants/email-unverified', 'ManageAssistantController@emailUnverifiedAssistants')->name('assistants.emailUnverified');
        // Route::get('assistants/sms-unverified', 'ManageAssistantController@smsUnverifiedAssistants')->name('assistants.smsUnverified');
        // Route::get('assistants/sms-verified', 'ManageAssistantController@smsVerifiedAssistants')->name('assistants.smsVerified');
        // Route::get('assistants/{scope}/search', 'ManageAssistantController@search')->name('assistants.search');

        // //Assiatant Login History
        // Route::get('assistants/login/history/{id}', 'ManageAssistantController@assistantLoginHistory')->name('assistants.login.history.single');
        // Route::get('assistants/login/history', 'ManageAssistantController@loginHistory')->name('assistants.login.history');
        // Route::get('assistants/login/ipHistory/{ip}', 'ManageAssistantController@loginIpHistory')->name('assistants.login.ipHistory');

        // Route::get('assistants/send-email', 'ManageAssistantController@showEmailAllForm')->name('assistants.email.all');
        // Route::post('assistants/send-email', 'ManageAssistantController@sendEmailAll')->name('assistants.email.send');
        // Route::get('assistant/send-email/{id}', 'ManageAssistantController@showEmailSingleForm')->name('assistants.email.single');
        // Route::post('assistant/send-email/{id}', 'ManageAssistantController@sendEmailSingle')->name('assistants.email.single');

        // Staff Manager
        Route::get('staff', 'ManageStaffController@allStaff')->name('staff.all');
        Route::get('staff/new', 'ManageStaffController@newStaff')->name('staff.new');
        Route::post('staff/store', 'ManageStaffController@storeStaff')->name('staff.store');
        Route::get('staff/detail/{id}', 'ManageStaffController@detail')->name('staff.detail');
        Route::post('staff/update/{id}', 'ManageStaffController@update')->name('staff.update');

        Route::get('staff/active', 'ManageStaffController@activeStaff')->name('staff.active');
        Route::get('staff/banned', 'ManageStaffController@bannedStaff')->name('staff.banned');
        Route::get('staff/email-verified', 'ManageStaffController@emailVerifiedStaff')->name('staff.emailVerified');
        Route::get('staff/email-unverified', 'ManageStaffController@emailUnverifiedStaff')->name('staff.emailUnverified');
        Route::get('staff/sms-unverified', 'ManageStaffController@smsUnverifiedStaff')->name('staff.smsUnverified');
        Route::get('staff/sms-verified', 'ManageStaffController@smsVerifiedStaff')->name('staff.smsVerified');
        Route::get('staff/{scope}/search', 'ManageStaffController@search')->name('staff.search');

        //Staff Login History
        Route::get('staff/login/history/{id}', 'ManageStaffController@staffLoginHistory')->name('staff.login.history.single');
        Route::get('staff/login/history', 'ManageStaffController@loginHistory')->name('staff.login.history');
        Route::get('staff/login/ipHistory/{ip}', 'ManageStaffController@loginIpHistory')->name('staff.login.ipHistory');

        Route::get('staff/send-email', 'ManageStaffController@showEmailAllForm')->name('staff.email.all');
        Route::post('staff/send-email', 'ManageStaffController@sendEmailAll')->name('staff.email.send');
        Route::get('staff/send-email/{id}', 'ManageStaffController@showEmailSingleForm')->name('staff.email.single');
        Route::post('staff/send-email/{id}', 'ManageStaffController@sendEmailSingle')->name('staff.email.single');

        // //Patient Manager
        // Route::get('patient', 'ManagePatientController@allPatient')->name('patient.all');
        // Route::get('patient/new', 'ManagePatientController@newPatient')->name('patient.new');
        // Route::post('patient/store', 'ManagePatientController@storePatient')->name('patient.store');
        // Route::get('patient/detail/{id}', 'ManagePatientController@detail')->name('patient.detail');
        // Route::post('patient/update/{id}', 'ManagePatientController@update')->name('patient.update');

        // Route::get('patient/active', 'ManagePatientController@activePatient')->name('patient.active');
        // Route::get('patient/banned', 'ManagePatientController@bannedPatient')->name('patient.banned');
        // Route::get('patient/email-verified', 'ManagePatientController@emailVerifiedPatient')->name('patient.emailVerified');
        // Route::get('patient/email-unverified', 'ManagePatientController@emailUnverifiedPatient')->name('patient.emailUnverified');
        // Route::get('patient/sms-unverified', 'ManagePatientController@smsUnverifiedPatient')->name('patient.smsUnverified');
        // Route::get('patient/sms-verified', 'ManagePatientController@smsVerifiedPatient')->name('patient.smsVerified');
        // Route::get('patient/{scope}/search', 'ManagePatientController@search')->name('patient.search');

        // //Patient Login History
        // Route::get('patient/login/history/{id}', 'ManagePatientController@staffLoginHistory')->name('patient.login.history.single');
        // Route::get('patient/login/history', 'ManagePatientController@loginHistory')->name('patient.login.history');
        // Route::get('patient/login/ipHistory/{ip}', 'ManagePatientController@loginIpHistory')->name('patient.login.ipHistory');

        // Route::get('patient/send-email', 'ManagePatientController@showEmailAllForm')->name('patient.email.all');
        // Route::post('patient/send-email', 'ManagePatientController@sendEmailAll')->name('patient.email.send');
        // Route::get('patient/send-email/{id}', 'ManagePatientController@showEmailSingleForm')->name('patient.email.single');
        // Route::post('patient/send-email/{id}', 'ManagePatientController@sendEmailSingle')->name('patient.email.single');

        //Create Appointment
        Route::get('create/appointment', 'AppointmentController@createAppointment')->name('appointments.create');
        Route::get('details/appointment', 'AppointmentController@appointmentDetails')->name('appointments.book.details');
        Route::get('booked_date/appointment', 'AppointmentController@bookedDate')->name('appointment.booked.date');
        Route::post('store/appointment/{id}', 'AppointmentController@appointmentStore')->name('appointments.store');


        //Appointment
        Route::get('all/appointment', 'AppointmentController@allAppointment')->name('appointments.all');
        Route::post('appointment/view/{id}', 'AppointmentController@appointmentView')->name('appointments.view');
        Route::get('appointment/done', 'AppointmentController@appointmentDone')->name('appointments.done');
        Route::post('appointment/remove/{id}', 'AppointmentController@appointmentRemove')->name('appointments.remove');
        Route::get('appointment/trashed', 'AppointmentController@appointmentTrashed')->name('appointments.trashed');

        Route::get('sheduledAppointment/trashed/{id}', 'AppointmentController@appointmentRemoveFromAdmin')->name('sheduledAppointment.trashed');
        Route::get('sheduledAppointment/cancelAppointment/{id}', 'AppointmentController@DeleteAppointment')->name('sheduledAppointment.cancelAppointment');
        

        // Subscriber
        Route::get('subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::get('subscriber/send-email', 'SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/remove', 'SubscriberController@remove')->name('subscriber.remove');
        Route::post('subscriber/send-email', 'SubscriberController@sendEmail')->name('subscriber.sendEmail');

        // DEPOSIT SYSTEM
        Route::name('deposit.')->prefix('deposit')->group(function(){
            Route::get('/', 'DepositController@deposit')->name('list');
            Route::get('pending', 'DepositController@pending')->name('pending');
            Route::get('rejected', 'DepositController@rejected')->name('rejected');
            Route::get('approved', 'DepositController@approved')->name('approved');
            Route::get('successful', 'DepositController@successful')->name('successful');
            Route::get('details/{id}', 'DepositController@details')->name('details');

            Route::post('reject', 'DepositController@reject')->name('reject');
            Route::post('approve', 'DepositController@approve')->name('approve');
            Route::get('/{scope}/search', 'DepositController@search')->name('search');

            // Deposit Gateway
            Route::get('gateway', 'GatewayController@index')->name('gateway.index');
            Route::get('gateway/edit/{alias}', 'GatewayController@edit')->name('gateway.edit');
            Route::post('gateway/update/{code}', 'GatewayController@update')->name('gateway.update');
            Route::post('gateway/remove/{code}', 'GatewayController@remove')->name('gateway.remove');
            Route::post('gateway/activate', 'GatewayController@activate')->name('gateway.activate');
            Route::post('gateway/deactivate', 'GatewayController@deactivate')->name('gateway.deactivate');

            // Manual Methods
            Route::get('gateway/manual', 'ManualGatewayController@index')->name('manual.index');
            Route::get('gateway/manual/new', 'ManualGatewayController@create')->name('manual.create');
            Route::post('gateway/manual/new', 'ManualGatewayController@store')->name('manual.store');
            Route::get('gateway/manual/edit/{alias}', 'ManualGatewayController@edit')->name('manual.edit');
            Route::post('gateway/manual/update/{id}', 'ManualGatewayController@update')->name('manual.update');
            Route::post('gateway/manual/activate', 'ManualGatewayController@activate')->name('manual.activate');
            Route::post('gateway/manual/deactivate', 'ManualGatewayController@deactivate')->name('manual.deactivate');
        });


        // Admin Support
        Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
        Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
        Route::put('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');


        // Language Manager
        Route::get('/language', 'LanguageController@langManage')->name('language-manage');
        Route::post('/language', 'LanguageController@langStore')->name('language-manage-store');
        Route::delete('/language/delete/{id}', 'LanguageController@langDel')->name('language-manage-del');
        Route::post('/language/update/{id}', 'LanguageController@langUpdatepp')->name('language-manage-update');
        Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language-key');
        Route::put('/language/keyword-update/{id}', 'LanguageController@langUpdate')->name('language.key-update');
        Route::post('/language/import', 'LanguageController@langImport')->name('language.import_lang');

        Route::post('store-lang-key/{id}', 'LanguageController@storeLanguageJson')->name('store-lang-key');
        Route::post('delete-lang-key/{id}', 'LanguageController@deleteLanguageJson')->name('delete-lang-key');
        Route::post('update-lang-key/{id}', 'LanguageController@updateLanguageJson')->name('update-lang-key');

        // General Setting
        Route::get('setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('setting', 'GeneralSettingController@update')->name('setting.update');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo-icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo-icon');

        // Plugin
        Route::get('plugin', 'PluginController@index')->name('plugin.index');
        Route::post('plugin/update/{id}', 'PluginController@update')->name('plugin.update');
        Route::post('plugin/activate', 'PluginController@activate')->name('plugin.activate');
        Route::post('plugin/deactivate', 'PluginController@deactivate')->name('plugin.deactivate');


        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email-template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email-template.global');
        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email-template.setting');
        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email-template.setting');
        Route::get('email-template/index', 'EmailTemplateController@index')->name('email-template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email-template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email-template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email-template.sendTestMail');


        // SMS Setting
        Route::get('sms-template/global', 'SmsTemplateController@smsSetting')->name('sms-template.global');
        Route::post('sms-template/global', 'SmsTemplateController@smsSettingUpdate')->name('sms-template.global');
        Route::get('sms-template/index', 'SmsTemplateController@index')->name('sms-template.index');
        Route::get('sms-template/edit/{id}', 'SmsTemplateController@edit')->name('sms-template.edit');
        Route::post('sms-template/update/{id}', 'SmsTemplateController@update')->name('sms-template.update');
        Route::post('email-template/send-test-sms', 'SmsTemplateController@sendTestSMS')->name('email-template.sendTestSMS');

        // SEO
        Route::get('seo', 'FrontendController@seoEdit')->name('seo');


        // Frontend
        Route::name('frontend.')->prefix('frontend')->group(function () {

            Route::get('templates', 'FrontendController@templates')->name('templates');
            Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');

            Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
            Route::post('remove', 'FrontendController@remove')->name('remove');

            // Page Builder
            Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');
            Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');
            Route::patch('manage-pages', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
            Route::delete('manage-pages', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
        });
    });
});

Route::namespace('Staff')->prefix('staff')->name('staff.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');

        // Staff Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify-code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });
});

Route::namespace('Staff')->name('staff.')->prefix('staff')->group(function () {
    Route::middleware('staff')->group(function () {
        Route::get('authorization', 'StaffAuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'StaffAuthorizationController@sendVerifyCode')->name('send_verify_code');
        Route::post('verify-email', 'StaffAuthorizationController@emailVerification')->name('verify_email');
        Route::post('verify-sms', 'StaffAuthorizationController@smsVerification')->name('verify_sms');
        Route::post('verify-g2fa', 'StaffAuthorizationController@g2faVerification')->name('go2fa.verify');

        Route::middleware(['checkStaffStatus'])->group(function () {
            Route::get('dashboard', 'StaffController@dashboard')->name('dashboard');
            Route::get('profile', 'StaffController@profile')->name('profile');
            Route::post('profile/update', 'StaffController@profileUpdate')->name('profile.update');
            Route::get('password', 'StaffController@password')->name('password');
            Route::post('password/update', 'StaffController@passwordUpdate')->name('password.update');

            //2FA
            Route::get('twofactor', 'StaffController@show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'StaffController@create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'StaffController@disable2fa')->name('twofactor.disable');

            Route::get('appointment', 'StaffController@allAppointment')->name('appointments.all');
            Route::post('appointment/view/{id}', 'StaffController@appointmentView')->name('appointments.view');
            Route::get('appointment/done', 'StaffController@appointmentDone')->name('done.appointment');
            Route::post('appointment/remove/{id}', 'StaffController@appointmentRemove')->name('appointments.remove');
            Route::get('appointment/trashed', 'StaffController@appointmentTrashed')->name('appointments.trashed');

            //Create Appointment
            Route::get('create/appointment', 'StaffController@createAppointment')->name('appointment.create');
            Route::get('details/appointment', 'StaffController@appointmentDetails')->name('appointment.book.details');
            Route::get('booked_date/appointment', 'StaffController@bookedDate')->name('appointment.booked.date');
            Route::post('store/appointment/{id}', 'StaffController@appointmentStore')->name('appointment.store');

            //Doctors
            Route::get('doctors', 'StaffController@allDoctors')->name('doctors');
        });
    });
});

// Deposit
Route::any('/deposit', 'Gateway\PaymentController@deposit')->name('deposit');
Route::post('deposit/insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');
Route::get('deposit/preview', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');
Route::get('deposit/confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');
Route::get('deposit/manual', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');
Route::post('deposit/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');

//All Doctors
Route::get('doctors-all', 'SiteController@doctorsAll')->name('doctors.all');

//All Lectures
Route::get('lectures-all', 'SiteController@lecturesAll')->name('lectures.all');

//All Articles
Route::get('articles-all', 'SiteController@articlesAll')->name('articles.all');

//Featured Doctors All
Route::get('doctors-all-featured', 'SiteController@featuredDoctorsAll')->name('featured.doctors.all');

//Sector Wise Doctor
Route::get('doctors-all/sector/{id}', 'SiteController@sectorDoctors')->name('sector.doctors.all');

//Sector Wise Doctor
Route::get('doctors/sector/{id}', 'SiteController@getsectorDoctors')->name('sector.doctors.search');

//Location Wise Doctor
Route::get('doctors-all/location/{id}', 'SiteController@locationDoctors')->name('location.doctors.all');

//Search Doctor
Route::get('doctors-all/search', 'SiteController@doctorSearch')->name('search.doctors');

//Search Doctor
Route::get('doctors-all/search', 'SiteController@doctorSearch')->name('search.doctors');


//Booking
Route::get('booking/{id}', 'SiteController@booking')->name('booking');
Route::get('booked_date', 'SiteController@bookedDate')->name('bookeddate');

Route::get('doctorDetails/{id}', 'SiteController@doctorDetails')->name('doctorDetails');

//Appointment Store
Route::post('/appointment/store/{id}', 'SiteController@appointmentStore')->name('appointment.store');


//Subscriber Store
Route::post('subscriber', 'SiteController@subscriberStore')->name('subscriber.store');

//Patient Register
Route::get('patient-register', 'SiteController@patientRegister')->name('patient.register');

Route::post('patient-register-store', 'SiteController@storePatient')->name('patient.store');

//Blog
Route::get('/blog', 'SiteController@blog')->name('blog');
Route::get('/blog/details/{id}/{title}', 'SiteController@blogDetails')->name('blog.details');

//Contact
Route::get('/contact', 'SiteController@contact')->name('contact');
Route::post('/contact', 'SiteController@contactSubmit')->name('contact.send');

//diseases
Route::get('/diseases', 'SiteController@diseases')->name('diseases');

//get app
Route::get('/getapp', 'SiteController@getapp')->name('getapp');
//terms
Route::get('/terms', 'SiteController@terms')->name('terms');
//refund policy
Route::get('/refundpolicy', 'SiteController@refundpolicy')->name('refundpolicy');
//privacy policy
Route::get('/privacy-policy', 'SiteController@privacy_policy')->name('privacy-policy');

//Lang
Route::get('/change/{lang?}', 'SiteController@changeLanguage')->name('lang');

//Home
Route::get('/login', 'SiteController@login')->name('login');
// Route::get('/', 'SiteController@index')->name('home');
Route::get('/{slug}', 'SiteController@pages')->name('pages');

Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholderImage');


//Articles
Route::get('articles/sector/{id}', 'SiteController@getsectorArticles')->name('sector.articles.search');

//Videos
Route::get('youtube/sector/{id}', 'SiteController@getsectorYoutubes')->name('sector.videos.search');

//Videos
Route::get('all/sector/{id}', 'SiteController@getsectorAll')->name('sector.videos.search');


//Doctors
Route::get('doctors/sector/{id}', 'SiteController@getsectorallDoctors')->name('sector.videos.search');

if (env('FORCE_HTTPS', true)) { // Default value should be false for local server
//            url()->forceSchema('https');
    // URL::forceScheme('https');
}