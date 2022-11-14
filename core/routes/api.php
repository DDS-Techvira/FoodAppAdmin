<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('accounts/authenticate', 'MobileAppController@loginAccount');
Route::post('accounts/push_token', 'MobileAppController@SaveDeviceToken');
Route::post('accounts/GetUserDetails', 'MobileAppController@getUserDetails');
Route::post('accounts/GetUserDetails', 'MobileAppController@getUserDetails');
Route::post('accounts/UpdateUserDetails', 'MobileAppController@updateUserDetails');
Route::post('accounts/PasswordChange', 'MobileAppController@passwordChange');
Route::post('accounts/StoreUser', 'MobileAppController@storeUserDetails');

Route::post('appointments/GetAppoinmentsByCoach', 'MobileAppController@getAppointmenDetailsByCoach');
Route::post('appointments/GetAppoinmentsByPrincipal', 'MobileAppController@getAppointmenDetailsByPrincipal');
Route::post('appointments/GetAppoinmentsByPrincipalUpcomings', 'MobileAppController@getAppointmenDetailsByPrincipalUpcomings');
Route::post('appointments/GetAppointmenDetailsByCoachUpcomings', 'MobileAppController@getAppointmenDetailsByCoachUpcomings');

Route::post('appointments/GetAppoinmentsByApptCodePrincipals', 'MobileAppController@getAppointmenDetailsByPrincipalApptCode');
Route::post('appointments/GetAppointmenDetailsByPrincipalRatings', 'MobileAppController@getAppointmenDetailsByPrincipalRatings');

Route::post('appointments/GetAppointmenDetailsByCoachRatings', 'MobileAppController@getAppointmenDetailsByCoachRatings');

Route::post('appointments/GetCoachesList', 'MobileAppController@getCoachesList');

Route::post('availability/GetAlreadyBookedSlot', 'MobileAppController@getAlreadyBookedSlot');

Route::post('appointments/GetAppoinmentsByApptCodeCoach', 'MobileAppController@getAppointmenDetailsByCoachApptCode');
Route::post('appointments/CoachScheduleManage', 'MobileAppController@scheduleManage');
Route::post('appointments/GetCoachAvailabilityList', 'MobileAppController@getCoachAvailabilityList');
Route::post('appointments/GetAppointmentTimeSlots', 'MobileAppController@getAppointmentTimeSlots');
Route::post('appointments/GetCoachList', 'MobileAppController@getCoachList');
Route::post('appointments/GetPrincipalList', 'MobileAppController@getPrincipalList');
Route::post('appointments/GetCoachAvailabileSlot', 'MobileAppController@getCoachAvailabilityAppt');
Route::post('appointments/SavePrincipalAppoinment', 'MobileAppController@savePrincipalAppoinment');
Route::post('appointments/UpdateStatusOfAppointment', 'MobileAppController@UpdateStatusOfAppointment');
Route::post('appointments/UpdateAvailableTimePrincipal', 'MobileAppController@UpdateAvailableTimePrincipal');
Route::post('appointments/GetCallReportCoach', 'MobileAppController@getCallReportCoach');
Route::post('appointments/DeleteAppointment', 'MobileAppController@DeleteAppointment');
Route::post('appointments/deleteAvailability', 'MobileAppController@deleteAvailability');
Route::post('appointments/GetCoachTimeSlotToEdit', 'MobileAppController@getCoachTimeSlotToEdit');
Route::post('appointments/UpdateCoachAvailableDate', 'MobileAppController@updateCoachAvailableDate');
Route::post('appointments/DeleteAppointmentFromList', 'MobileAppController@deletAppointmentFromList');

Route::post('appointments/GetCoachPrevoiusDateScheduled', 'MobileAppController@getCoachPrevoiusDateScheduled');

Route::post('call/SaveCallDetails', 'MobileAppController@saveCallDetails');

Route::get('call/updatePrincipalTimesByApi', 'MobileAppController@updatePrincipalTimesByApi');


Route::post('chat/GetChatMessage', 'MobileAppController@getChatMessage');
Route::post('chat/UpdateChatMessage', 'MobileAppController@updateChatMessage');
Route::post('chat/CloseChatMessage', 'MobileAppController@CloseChatMessage');
Route::post('chat/GetClosedChatMessageCoach', 'MobileAppController@getClosedChatMessageCoach');
Route::post('chat/GetClosedChatMessageHistoryCoach', 'MobileAppController@getClosedChatMessageHistoryCoach');
Route::post('chat/GetPrincipalChatMessage', 'MobileAppController@getPrincipalChatMessage');
Route::post('chat/GetChatNewCoach', 'MobileAppController@getChatNewCoach');
Route::post('chat/GetChatOngoingCoach', 'MobileAppController@getChatOngoingCoach');
Route::post('chat/GetChatMessagesCoach', 'MobileAppController@getChatMessagesCoach');
Route::post('chat/CoachEnrollChatQuestion', 'MobileAppController@coachEnrollChatQuestion');
Route::post('chat/GetClosedChatMessagePrincipal', 'MobileAppController@getClosedChatMessagePrincipal');
Route::post('chat/GetClosedChatMessageHistoryPrincipal', 'MobileAppController@getClosedChatMessageHistoryPrincipal');
Route::post('chat/GetChatMessageByCode', 'MobileAppController@getChatMessageByCode');

Route::post('report/GetCallReportCountsCoach', 'MobileAppController@getCallReportCountsCoach');

Route::post('report/GetChatReportCountsCoach', 'MobileAppController@getChatReportCountsCoach');

Route::post('report/GetClosedChatMessagePrincipalPoolReport', 'MobileAppController@getClosedChatMessagePrincipalPoolReport');

Route::post('report/GetCallReportPrincipalPool', 'MobileAppController@getCallReportPrincipalPool');

Route::post('report/GetCallReportCoachPool', 'MobileAppController@getCallReportCoachPool');

Route::post('report/GetClosedChatMessageCoachPoolReport', 'MobileAppController@getClosedChatMessageCoachPoolReport');

Route::post('call/UpdateRatings', 'MobileAppController@UpdateRatings');

Route::post('call/UpdateWriteUps', 'MobileAppController@UpdateWriteUps');



Route::post('report/GetClosedChatMessageCoacReport', 'MobileAppController@getClosedChatMessageCoacReport');

Route::post('chat/GetChatListCoach', 'MobileAppController@getChatListCoach');
Route::post('chat/GetChatListPrincipal', 'MobileAppController@getChatListPrincipal');

///Technical///
Route::post('chat/GetTechnicalChatListPrincipal', 'MobileAppController@getTechnicalChatListPrincipal');
Route::post('chat/GetPrincipalTechnicalChatMessage', 'MobileAppController@getPrincipalTechnicalChatMessage');
Route::post('chat/UpdateTechnicalChatMessage', 'MobileAppController@UpdateTechnicalChatMessage');
Route::post('chat/GetTechnicalClosedChatMessagePrincipal', 'MobileAppController@getTechnicalClosedChatMessagePrincipal');
Route::post('chat/GetTechnicalClosedChatMessageHistoryPrincipal', 'MobileAppController@getTechnicalClosedChatMessageHistoryPrincipal');

///Other///
Route::post('chat/GetOtherChatListPrincipal', 'MobileAppController@getOtherChatListPrincipal');
Route::post('chat/GetPrincipalOtherChatMessage', 'MobileAppController@getPrincipalOtherChatMessage');
Route::post('chat/UpdateOtherChatMessage', 'MobileAppController@UpdateOtherChatMessage');
Route::post('chat/GetOtherClosedChatMessagePrincipal', 'MobileAppController@getOtherClosedChatMessagePrincipal');
Route::post('chat/GetOtherClosedChatMessageHistoryPrincipal', 'MobileAppController@getOtherClosedChatMessageHistoryPrincipal');

///Feedback///
Route::post('chat/GetFeedbackChatListPrincipal', 'MobileAppController@getFeedbackChatListPrincipal');
Route::post('chat/GetPrincipalFeedbackChatMessage', 'MobileAppController@getPrincipalFeedbackChatMessage');
Route::post('chat/UpdateFeedbackChatMessage', 'MobileAppController@UpdateFeedbackChatMessage');
Route::post('chat/SendNotificationsToCoach', 'MobileAppController@sendNotificationsToCoach');

// Route::post('chat/GetOtherClosedChatMessagePrincipal', 'MobileAppController@getOtherClosedChatMessagePrincipal');
// Route::post('chat/GetOtherClosedChatMessageHistoryPrincipal', 'MobileAppController@getOtherClosedChatMessageHistoryPrincipal');

Route::post('agora/AgoraTokenGeneration', 'MobileAppController@AgoraTokenGeneration');
Route::post('library/GetCategories', 'MobileAppController@getCategories');
Route::post('library/GetLibraryPost', 'MobileAppController@getLibraryPost');
Route::post('library/GetLibraryPostDailyDose', 'MobileAppController@getLibraryPostDailyDose');
Route::post('library/GetLibraryPostByID', 'MobileAppController@getLibraryPostByID');
Route::post('library/GetLibraryPostByID', 'MobileAppController@getLibraryPostByID');
Route::post('library/GetLibraryPostBySearch', 'MobileAppController@getLibraryPostBySearch');
Route::post('library/GetLibraryPostBySearchCategory', 'MobileAppController@getLibraryPostBySearchCategory');


Route::post('test_ics_mail', 'MobileAppController@test_ics_mail');


Route::post('webinar/GetCoachWebinar', 'MobileAppController@getCoachWebinar');
Route::post('webinar/GetPrincipalWebinar', 'MobileAppController@getPrincipalWebinar');
Route::post('webinar/RequestWebinarUser', 'MobileAppController@requestWebinaUser');
Route::post('webinar/WebinarStatus', 'MobileAppController@webinarStatus');
Route::post('webinar/WebinarCode', 'MobileAppController@webinarCode');


Route::post('Notifications/GetuserNotifications', 'MobileAppController@getuserNotifications');
Route::post('Notifications/DeleteNotifications', 'MobileAppController@deleteNotifications');
Route::post('Notifications/ClearuserNotifications', 'MobileAppController@clearuserNotifications');
Route::post('Notifications/GetCountNewuserNotifications', 'MobileAppController@getuserCountNotifications');


////////New Apis/////
Route::post('appointmentStore', 'MobileAppController@appointmentStore');




Route::post('getCategories', 'MobileAppController@getCategories');
Route::post('getDoctors', 'MobileAppController@getDoctors');
Route::post('getPrescriptionByPatient', 'MobileAppController@getPrescriptionByPatient');
Route::post('getPrescriptionImageById', 'MobileAppController@getPrescriptionImageById');
Route::post('getDoctorsByCat', 'MobileAppController@getDoctorsByCat');

Route::post('appointmentStore', 'MobileAppController@appointmentStore');
Route::post('GetAppointmenDetailsByPatientId', 'MobileAppController@getAppointmenDetailsByPatientId');
Route::post('getArticlesByDocId', 'MobileAppController@getArticlesByDocId');
Route::post('GetYotubeByDocId', 'MobileAppController@getYotubeByDocId');
Route::post('GetAllBooks', 'MobileAppController@getAllBooks');
Route::post('PrescriptionStore', 'MobileAppController@prescriptionStore');
Route::post('PrescriptionUpload', 'MobileAppController@UploadPrescriptionImage');
Route::post('getAppointmenDetailsByDoctorId', 'MobileAppController@getAppointmenDetailsByDoctorId');
Route::post('ScheduleManage', 'MobileAppController@scheduleManage');
Route::post('patientRegister', 'MobileAppController@storePatient');
Route::post('UploadPatientImage', 'MobileAppController@UploadPatientImage');
Route::post('doctorRegister', 'MobileAppController@storeDoctor');
Route::post('UploadDoctorImage', 'MobileAppController@UploadDoctorImage');
Route::post('getpatientDetails', 'MobileAppController@getPatientDetails');
Route::post('getDoctorDetails', 'MobileAppController@getDoctorDetails');
Route::post('UpdateDoctorDetails', 'MobileAppController@updateDoctorDetails');
Route::post('updatePtientDetails', 'MobileAppController@updatePtientDetails');
Route::post('paymentresponse', 'MobileAppController@visa_master_payment_done')->name('payment.done');
Route::post('StoreBookPurchase', 'MobileAppController@storeBookPurchase');
Route::post('PurchaseHistory', 'MobileAppController@purchaseHistory');
Route::post('DoctorPasswordResetOTP', 'MobileAppController@drsendPasswordResetOTP');
Route::post('PatientPasswordResetOTP', 'MobileAppController@patientsendPasswordResetOTP');
Route::post('UpdatePatientPassword', 'MobileAppController@updatePatientPassword');
Route::post('UpdateDoctorPassword', 'MobileAppController@updateDoctorPassword');
Route::post('DeleteAppointment', 'MobileAppController@DeleteAppointment');
