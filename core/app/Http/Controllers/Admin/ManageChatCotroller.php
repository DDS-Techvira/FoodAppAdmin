<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Support\Facades\Http;
use App\Appointment;
use App\Assistant;
use App\Deposit;
use App\Disease;
use App\Doctor;
use App\DoctorLogin;
use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Sector;
use App\Users;
use App\PrincipalAvailableTimeModel;
use App\DrArticles;
use App\TechnicalChatMessageModel;
use App\TechnicalChatReportModel;
use App\Gallery;
use App\ChatMessagesModel;
use App\ChatsReportModel;
use App\CallHostoryModel;
use App\OtherChatMessageModel;
use App\OtherChatReportModel;
use App\FeedbackChatMessageModel;
use Uuid;
use App\CommonPHP\PushNotificationCommon;
use Illuminate\Support\Facades\Hash;
class ManageChatCotroller extends Controller
{
    public function chatUI(Request $request){
        
        $page_title = 'Chats';
        $chats = ChatMessagesModel::Join('users','users.user_code','chat_messages.principal_code')
        ->select('users.profile_image','users.first_name','users.last_name','chat_messages.*')
        ->orderBy('created_at', 'DESC')
        ->get();

        $chat_messages = ChatMessagesModel::Join('users','users.user_code','chat_messages.principal_code')
        ->where('chat_code','=','ae97aff6-c59a-4898-9ff1-959d8aa4845b')
        ->select('users.profile_image','users.first_name','users.last_name','chat_messages.*')
        ->orderBy('created_at', 'DESC')
        ->first();
        $chatMessages= json_decode($chat_messages->chat_history) ?? [];

     
        return view('admin.chats.CoachToPrincipal.chat_ui',compact('page_title','chats','chat_messages','chatMessages'));
    }

    public function chatReport(Request $request){
        $page_title = 'Chat Reports';
        $empty_message = 'No Reports found';
        $sectors;
        // if($request->from_date !=null && $request->to_date){
        //     $sectors = Appointment::join('call_history','call_history.appointment_id','scheduled_appointments.appointments_code')->latest()->paginate(getPaginate());
        // }

        $chats = ChatsReportModel::select('chat_messages_report.*','coach.first_name as coach_first_name','coach.last_name as coach_last_name','principal.first_name as principal_first_name','principal.last_name as principal_last_name','principal.profile_image')
        ->join('users as coach','coach.user_code','chat_messages_report.coach_code') 
        ->join('users as principal','principal.user_code','chat_messages_report.principal_code') 
        ->orderBy('created_at', 'DESC')
        ->latest()->paginate(getPaginate());
        // return $chats;
        return view('admin.Reports.chat_reports', compact('page_title', 'empty_message','chats'));
    }

    public function coachingQuestion($tab = 'new', Request $request)
    {
        $page_title = 'Coaching Questions';
        if(! in_array($tab, ['new', 'ongoing', 'closed'])) {
            abort(404);
        }
        // 
        $chats;
        if($tab == 'new') 
            $chats = ChatMessagesModel::where('status', 1)
                                    ->whereNull('coach_code')
                                    ->orderby('updated_at', 'desc')
                                    ->get();
        if($tab == 'ongoing') 
                    $chats = ChatMessagesModel::where('status', 1)
                                    ->whereNotNull('coach_code')
                                    ->orderby('updated_at', 'desc')
                                    ->get();

        if($tab == 'closed') 
            $chats = ChatsReportModel::orderby('updated_at', 'desc')
                                    ->get();
        // 
        return view('admin.chats.coaching_question', compact('page_title', 'tab', 'chats'));
    } 

    public function technicalSupport($tab = 'new', Request $request)
    {   
        $page_title = 'Technical Support';
        if(! in_array($tab, ['new', 'ongoing', 'closed'])) {
            abort(404);
        }
        // 
        if($tab == 'new') 
            $chats = TechnicalChatMessageModel::where('technical_chat_messages.status', 1)
                                            ->whereNull('technical_user_code')
                                            ->orderby('created_at', 'desc')
                                            ->join('users','users.user_code','technical_chat_messages.principal_code')
                                            ->select('technical_chat_messages.*','users.first_name','users.last_name')
                                            ->get();

        if($tab == 'ongoing') 
            $chats = TechnicalChatMessageModel::where('technical_chat_messages.status', 1)
                                            ->whereNotNull('technical_user_code')
                                            ->where('technical_user_code', \Auth::guard('admin')->user()->id)
                                            ->orderby('updated_at', 'desc')
                                            ->join('users','users.user_code','technical_chat_messages.principal_code')
                                            ->select('technical_chat_messages.*','users.first_name','users.last_name')
                                            ->get();

        if($tab == 'closed') 
            $chats = TechnicalChatReportModel::where('status', 1)
                                            ->orderby('updated_at', 'desc')
                                            ->join('users','users.user_code','technical_chat_messages.principal_code')
                                            ->select('technical_chat_messages.*','users.first_name','users.last_name')
                                            ->get();

                                        
        return view('admin.chats.technical_support', compact('page_title', 'tab', 'chats'));
    } 

    public function leaveFeedback(Request $request)
    {
        $page_title = 'Leave Feedback';
        $tab = 'ongoing';
        $chats = FeedbackChatMessageModel::orderby('updated_at', 'desc')
                                    ->get();
        // 
        return view('admin.chats.leave_feedback', compact('page_title', 'tab', 'chats'));
    } 

    public function other($tab = 'new', Request $request)
    {   
        $page_title = 'Other Questions';
        if(! in_array($tab, ['new', 'ongoing', 'closed'])) {
            abort(404);
        }
        // 
        if($tab == 'new') 
            $chats = OtherChatMessageModel::where('status', 1)
                                            ->whereNull('admin_user_code')
                                            ->orderby('created_at', 'desc')
                                            ->get();

        if($tab == 'ongoing') 
            $chats = OtherChatMessageModel::where('status', 1)
                                            ->whereNotNull('admin_user_code')
                                            ->where('admin_user_code', \Auth::guard('admin')->user()->id)
                                            ->orderby('updated_at', 'desc')
                                            ->get();

        if($tab == 'closed') 
            $chats = OtherChatReportModel::where('status', 1)
                                            ->orderby('updated_at', 'desc')
                                            ->get();
        return view('admin.chats.other', compact('page_title', 'tab', 'chats'));
    } 

    public function conversation($chat, $tab, $id, Request $request)
    {
        if(! in_array($chat, ['coaching-question', 'technical-support', 'leave-feedback', 'other'])) {
            abort(404);
        }

        $page_title = '';
            
        if($chat == 'technical-support') {
            
            $page_title = 'Technical Support';
            
            if($tab == 'closed') {
                $conversation = TechnicalChatReportModel::where('status', 1)
                                            ->where('chat_code', $id)
                                            ->orderby('updated_at', 'desc')
                                            ->first();
            }
            else {
                // ongoing
                $conversation = TechnicalChatMessageModel::where('status', 1)
                                            ->whereNotNull('technical_user_code')
                                            ->where('technical_user_code', \Auth::guard('admin')->user()->id)
                                            ->where('chat_code', $id)
                                            ->first();
            }
        }

        if($chat == 'other') {
            
            $page_title = 'Other Questions';

            if($tab == 'closed') {
                $conversation = OtherChatReportModel::where('status', 1)
                                            ->where('chat_code', $id)
                                            ->orderby('updated_at', 'desc')
                                            ->first();
            }
            else {
                // ongoing
                $conversation = OtherChatMessageModel::where('status', 1)
                                            ->whereNotNull('admin_user_code')
                                            ->where('admin_user_code', \Auth::guard('admin')->user()->id)
                                            ->where('chat_code', $id)
                                            ->first();
            }
        }

        if($chat == 'coaching-question') {

            $page_title = 'Coaching Questions';

            if($tab == 'closed') {
                $conversation = ChatsReportModel::where('chat_code', $id)
                                            ->orderby('updated_at', 'desc')
                                            ->first();
            }
            else {
                // ongoing
                $conversation = ChatMessagesModel::where('status', 1)
                                            ->where('chat_code', $id)
                                            ->first();
            }
        }
        
        if($chat == 'leave-feedback') {

            $page_title = 'Leave Feedback';

            $conversation = FeedbackChatMessageModel::where('chat_code', $id)
                                        ->orderby('updated_at', 'desc')
                                        ->first();
        }

        return view('admin.chats.conversation', compact('page_title', 'chat', 'tab', 'conversation'));
    }

    public function acceptConversation($chat, $id, Request $request)
    {
        if(! in_array($chat, ['coaching-question', 'technical-support', 'leave-feedback', 'other'])) {
            abort(404);
        }

        if($chat == 'technical-support') {
            $conversation = TechnicalChatMessageModel::where('status', 1)
                                            ->where('chat_code', $id)
                                            ->first();
            if($conversation){
                // 
                $conversation->technical_user_code = \Auth::guard('admin')->user()->id;
                $conversation->save();

                return redirect()->route('admin.chats.conversation', [$chat, 'ongoing', $conversation->chat_code]);
            }
        }

        if($chat == 'other') {
            $conversation = OtherChatMessageModel::where('status', 1)
                                            ->where('chat_code', $id)
                                            ->first();
            if($conversation){
                // 
                $conversation->admin_user_code = \Auth::guard('admin')->user()->id;
                $conversation->save();

                return redirect()->route('admin.chats.conversation', [$chat, 'ongoing', $conversation->chat_code]);
            }
        }
        return redirect()->back()->withErrors(['message' => 'invalid conversation']);
    }

    public function closeConversation($chat, $id, Request $request)
    {
        if(! in_array($chat, ['coaching-question', 'technical-support', 'leave-feedback', 'other'])) {
            abort(404);
        }

        if($chat == 'technical-support') {
            $conversation = TechnicalChatMessageModel::where('status', 1)
                                            ->where('chat_code', $id)
                                            ->first();
            if($conversation) {
                // 
                $closed = new TechnicalChatReportModel();
                $closed->chat_code = $conversation->chat_code;
                $closed->technical_user_code = $conversation->technical_user_code;
                $closed->principal_code = $conversation->principal_code;
                $closed->description = $conversation->description;
                $closed->chat_history = $conversation->chat_history;
                $closed->note = $conversation->note;
                $closed->message_description = $conversation->description;
                $closed->subject = $conversation->subject;
                $closed->status = 1;

                if($closed->save()) {

                    $noty_msg_body = "The Principal's Club Admin has closed your chat";
                    $noty_msg_title = 'Technical Support';
                    $click_action = '';
                    $msg_type = 'technical_chat_new_message';
                    $msg_id = $conversation->id;
                    $sub_id = $conversation->chat_code;
                    //dr reply to special msg

                    PushNotificationCommon::sendNotification($conversation->principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

                    $conversation->delete();
                }
                return redirect()->route('admin.chats.technical_support', ['ongoing']);
            }
        }

        if($chat == 'coaching-question') {
            $conversation = ChatMessagesModel::where('status', 1)
                                            ->where('chat_code', $id)
                                            ->first();
            if($conversation) {
                // 
                $closed = new ChatsReportModel();
                $closed->chat_code = $conversation->chat_code;
                $closed->principal_code = $conversation->principal_code;
                $closed->coach_code = $conversation->coach_code;
                $closed->chat_hostory = $conversation->chat_hostory;
                $closed->note = $conversation->note;
                $closed->description = $conversation->description;
                $closed->message_description = $conversation->description;
                $closed->message_subject = $conversation->message_subject;
                $closed->status = 1;

                if($closed->save()) {

                    $noty_msg_body = "The Principal's Club Admin has closed your chat";
                    $noty_msg_title = 'Coaching Question';
                    $click_action = '';
                    $msg_type = 'chat_new_message';
                    $msg_id = $conversation->id;
                    $sub_id = $conversation->chat_code;
                    //dr reply to special msg

                    PushNotificationCommon::sendNotification($conversation->principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);
                    PushNotificationCommon::sendNotification($conversation->coach->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

                    $conversation->delete();
                }
                return redirect()->route('admin.chats.coaching_question', ['ongoing']);
            }
        }

        if($chat == 'other') {
            $conversation = OtherChatMessageModel::where('status', 1)
                                            ->where('chat_code', $id)
                                            ->first();
            if($conversation) {
                // 
                $closed = new OtherChatReportModel();
                $closed->chat_code = $conversation->chat_code;
                $closed->admin_user_code = $conversation->admin_user_code;
                $closed->principal_code = $conversation->principal_code;
                $closed->chat_history = $conversation->chat_history;
                $closed->note = $conversation->note;
                $closed->description = $conversation->description;
                $closed->subject = $conversation->subject;
                $closed->message_description = $conversation->description;
                $closed->last_reply = $conversation->last_reply;
                $closed->principal_replied = $conversation->principal_replied;
                $closed->status = $conversation->status;

                if($closed->save()) {
                    $noty_msg_body = "The Principal's Club Admin has closed your chat";
                    $noty_msg_title = 'Misc Question';
                    $click_action = '';
                    $msg_type = 'other_chat_new_message';
                    $msg_id = $conversation->id;
                    $sub_id = $conversation->chat_code;
                    //dr reply to special msg

                    PushNotificationCommon::sendNotification($conversation->principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

                    $conversation->delete();
                }
                return redirect()->route('admin.chats.other', ['ongoing']);
            }
        }
        return redirect()->back()->withErrors(['message' => 'invalid conversation']);
    }

    public function submitMessage($chat, $id, Request $request)
    {
        if(! in_array($chat, ['coaching-question', 'technical-support', 'leave-feedback', 'other'])) {
            abort(404);
        }

        $request->validate(['message' => 'required']);

        if($chat == 'technical-support') {
            $conversation = TechnicalChatMessageModel::where('status', 1)
                                            ->where('technical_user_code', \Auth::guard('admin')->user()->id)
                                            ->where('chat_code', $id)
                                            ->first();
            if($conversation) {
                $history = json_decode($conversation->chat_history) ?? [];
                array_push($history, array(
                                            "id"=> \Auth::guard('admin')->user()->id,
                                            "date"=> round(microtime(true) * 1000),
                                            "alias"=> \Auth::guard('admin')->user()->name,
                                            "message"=> $request->message
                                        ));
                $conversation->chat_history = json_encode($history);

                $conversation->technical_replied = 1;
                $conversation->principal_replied = 0;

                if($conversation->save()) {

                    $noty_msg_body = "Admin ".\Auth::guard('admin')->user()->name." sent you a message";
                    $noty_msg_title = "Technical Support";
                    $click_action = '';
                    $msg_type = 'technical_chat_new_message';
                    $msg_id = $conversation->id;
                    $sub_id = $conversation->chat_code;
                    //dr reply to special msg

                    PushNotificationCommon::sendNotification($conversation->principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

                    return redirect()->back()->with(['success' => true, 'message' => 'message sumbit success']);
                }
            }
        }

        if($chat == 'coaching-question') {
            $conversation = ChatMessagesModel::where('chat_code', $id)
                                            ->first();
            if($conversation) {
                $history = json_decode($conversation->chat_hostory) ?? [];
                array_push($history, array(
                                            "id"=> \Auth::guard('admin')->user()->id,
                                            "date"=> round(microtime(true) * 1000),
                                            "alias"=> \Auth::guard('admin')->user()->name,
                                            "message"=> $request->message
                                        ));
                $conversation->chat_hostory = json_encode($history);

                $conversation->coach_replied = 1; // this is for when admin send new reply to the chat. 
                $conversation->principal_replied = 1; // this is for when admin send new reply to the chat. 

                if($conversation->save()) {
                    $noty_msg_body = "Admin ".\Auth::guard('admin')->user()->name." sent you a message";
                    $noty_msg_title = "Coaching Question";
                    $click_action = '';
                    $msg_type = 'chat_new_message';
                    $msg_id = $conversation->id;
                    $sub_id = $conversation->chat_code;
                    //dr reply to special msg

                    PushNotificationCommon::sendNotification($conversation->principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

                    PushNotificationCommon::sendNotification($conversation->coach->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

                    return redirect()->back()->with(['success' => true, 'message' => 'message sumbit success']);
                }
            }
        }

        if($chat == 'other') {
            $conversation = OtherChatMessageModel::where('status', 1)
                                            ->where('admin_user_code', \Auth::guard('admin')->user()->id)
                                            ->where('chat_code', $id)
                                            ->first();
            if($conversation) {
                $history = json_decode($conversation->chat_history) ?? [];
                array_push($history, array(
                                            "id"=> \Auth::guard('admin')->user()->id,
                                            "date"=> round(microtime(true) * 1000),
                                            "alias"=> \Auth::guard('admin')->user()->name,
                                            "message"=> $request->message
                                        ));
                $conversation->chat_history = json_encode($history);

                $conversation->admin_replied = 1;
                $conversation->principal_replied = 0;

                if($conversation->save()) {
                    $noty_msg_body = "Admin ".\Auth::guard('admin')->user()->name." sent you a message";
                    $noty_msg_title = "Misc Questions";
                    $click_action = '';
                    $msg_type = 'other_chat_new_message';
                    $msg_id = $conversation->id;
                    $sub_id = $conversation->chat_code;
                    //dr reply to special msg

                    PushNotificationCommon::sendNotification($conversation->principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

                    return redirect()->back()->with(['success' => true, 'message' => 'message sumbit success']);
                }
            }
        }

        if($chat == 'leave-feedback') {
            $conversation = FeedbackChatMessageModel::where('status', 1)
                                            // ->where('admin_user_code', \Auth::guard('admin')->user()->id)
                                            ->where('chat_code', $id)
                                            ->first();
            if($conversation) {
                $history = json_decode($conversation->chat_history) ?? [];
                array_push($history, array(
                                            "id"=> \Auth::guard('admin')->user()->id,
                                            "date"=> round(microtime(true) * 1000),
                                            "alias"=> \Auth::guard('admin')->user()->name,
                                            "message"=> $request->message
                                        ));
                $conversation->chat_history = json_encode($history);

                $conversation->admin_replied = 1;
                $conversation->principal_replied = 0;

                if($conversation->save()) {
                    $noty_msg_body = "Admin ".\Auth::guard('admin')->user()->name." sent you a message";
                    $noty_msg_title = "Leave Feedback";
                    $click_action = '';
                    $msg_type = 'feedback_chat_new_message';
                    $msg_id = $conversation->id;
                    $sub_id = $conversation->chat_code;
                    //dr reply to special msg

                    PushNotificationCommon::sendNotification($conversation->principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

                    return redirect()->back()->with(['success' => true, 'message' => 'message sumbit success']);
                }
            }
        }

        return redirect()->back()->with(['success' => false, 'message' => 'invalid conversation']);
    }

    public function _ajaxGetChatUpdate($chat, $id, Request $request)
    {
        if(! in_array($chat, ['coaching-question', 'technical-support', 'leave-feedback', 'other']) || !$request->last_updated_at) {
            return response()->json([], 400);
        }

        $chat_history = [];

        if($chat == 'coaching-question') {
            $conversation = ChatMessagesModel::where('chat_code', $id)
                                            ->where('updated_at', ">", $request->last_updated_at)
                                            ->first();
            $chat_history = $conversation->chat_hostory ?? [];
        }

        if($chat == 'technical-support') {
            $conversation = TechnicalChatMessageModel::where('chat_code', $id)
                                            ->where('updated_at', ">", $request->last_updated_at)
                                            ->first();
            $chat_history = $conversation->chat_history ?? [];
        }

        if($chat == 'leave-feedback') {
            $conversation = FeedbackChatMessageModel::where('chat_code', $id)
                                            ->where('updated_at', ">", $request->last_updated_at)
                                            ->first();
            $chat_history = $conversation->chat_history ?? [];
        }

        if($chat == 'other') {
            $conversation = OtherChatMessageModel::where('chat_code', $id)
                                            ->where('updated_at', ">", $request->last_updated_at)
                                            ->first();
            $chat_history = $conversation->chat_history ?? [];
        }

        return response()->json(['data' => $chat_history], 200);
    }
}
