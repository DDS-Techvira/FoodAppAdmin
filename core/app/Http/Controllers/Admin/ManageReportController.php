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
use App\DrYotube;
use App\Gallery;
use App\ChatMessagesModel;
use App\ChatsReportModel;
use App\CallHostoryModel;
use App\ScheduledAppointments;
use Uuid;
use Illuminate\Support\Facades\Hash;
class ManageReportController extends Controller
{
    public function callReport(Request $request)
    {
        $page_title = 'Call Reports ';

        $coaches = Users::where('user_type', 'coach')->get();

        $calls = ScheduledAppointments::select(
                                            'scheduled_appointments.*', 
                                            'coach.first_name as coach_first_name', 
                                            'coach.last_name as coach_last_name', 
                                            'principal.first_name as principal_first_name', 
                                            'principal.last_name as principal_last_name', 
                                            'principal.profile_image', 
                                            'call_history.call_start_at', 
                                            'call_history.call_end_at', 
                                            'call_history.call_duration', 
                                            \DB::raw('TIME_TO_SEC(call_history.call_duration) as call_duration_sec'),
                                            'coach_feedback.ratings', 
                                            'coach_feedback.call_note',
                                            'coach_writes_up.call_note as writes_up' 
                                        )
                    ->leftJoin('call_history', 'call_history.appointment_id', 'scheduled_appointments.appointments_code')
                    ->leftJoin('coach_feedback', 'coach_feedback.appointment_id', 'scheduled_appointments.appointments_code')
                    ->leftJoin('coach_writes_up', 'coach_writes_up.appointment_code', 'scheduled_appointments.appointments_code')
                    ->join('users as coach','coach.user_code','scheduled_appointments.coach_code') 
                    ->join('users as principal','principal.user_code','scheduled_appointments.principal_code') 
                    ->latest();

        if($request->coach) {
            $calls = $calls->where('scheduled_appointments.coach_code', $request->coach);
        }

        if($request->from_date) {
            $calls = $calls->where('appt_date', '>=', $request->from_date);
        }

        if($request->to_date) {
            $calls = $calls->where('appt_date', '<=', $request->to_date);
        }

        if($request->action == 'export') { 
            $headings = ['Principal Name', 'Coach Name', 'Topic', 'Date', 'Slot', 'Duration', 'Status', 'Call Start At', 'Call End At', 'Call Duration', 'Call Ratings', 'Principal Notes', 'Coach Notes'];
            $data = $calls->get()->map(function ($item, $key) {
                return [
                        'Principal Name' => $item->principal_first_name.' '.$item->principal_last_name, 
                        'Coach Name' => $item->coach_first_name.' '.$item->coach_last_name, 
                        'Topic' => $item->topic, 
                        'Date' => $item->appt_date, 
                        'Slot' => $item->time_slot, 
                        'Duration' => $item->duration, 
                        'Status' => getCallStatus($item->status), 
                        'Call Start At' => $item->call_start_at, 
                        'Call End At' => $item->call_end_at, 
                        'Call Duration' => $item->call_duration, 
                        'Call Ratings' => $item->ratings, 
                        'Principal Notes' => $item->call_note, 
                        'Coach Notes' => $item->writes_up, 
                    ];
            });
            return $this->export($headings, $data->toArray(), $page_title);
        }

        $summery = $calls;
        $summery = collect($summery->get());
        $calls = $calls->paginate(getPaginate());

        $summery = (object) [
            'scheduled' => $summery->count(),
            'duration' => $summery->sum('call_duration_sec'),
            'canceled' => $summery->where('status', 3)->count(),
            'completed' => $summery->where('status', 4)->count(),
            'total_users' => $summery->groupBy('principal_code')->count(),
        ];

        return view('admin.reports.calls', compact('page_title', 'coaches', 'calls', 'summery'));
    }

    public function chatReport(Request $request)
    {

        $page_title = 'Chat Reports ';

        $coaches = Users::where('user_type', 'coach')->get();

        $chats = ChatMessagesModel::select(
                                            'coach.first_name as coach_first_name',
                                            'coach.last_name as coach_last_name',
                                            'principal.first_name as principal_first_name',
                                            'principal.last_name as principal_last_name',
                                            'principal.profile_image', 
                                            'chat_messages.created_at', 
                                            'chat_messages.updated_at', 
                                            'chat_messages.message_subject as topic',
                                            'chat_messages.principal_code',
                                            'chat_messages.coach_code',
                                            \DB::raw("'0' as status")
                                        )

                            ->leftJoin('users as coach','coach.user_code','chat_messages.coach_code') 
                            ->join('users as principal','principal.user_code','chat_messages.principal_code') 
                            ->orderBy('chat_messages.created_at', 'DESC')
                            ->latest();

        $chat_reports = ChatsReportModel::select(
                                            'coach.first_name as coach_first_name',
                                            'coach.last_name as coach_last_name',
                                            'principal.first_name as principal_first_name',
                                            'principal.last_name as principal_last_name',
                                            'principal.profile_image',
                                            'chat_messages_report.created_at',
                                            'chat_messages_report.updated_at',
                                            'chat_messages_report.message_subject as topic',
                                            'chat_messages_report.principal_code',
                                            'chat_messages_report.coach_code',
                                            \DB::raw("'1' as status")
                                        )

                            ->leftJoin('users as coach','coach.user_code','chat_messages_report.coach_code') 
                            ->join('users as principal','principal.user_code','chat_messages_report.principal_code') 
                            ->orderBy('chat_messages_report.created_at', 'DESC')
                            ->latest();

        if($request->coach) {
            $chats = $chats->where('chat_messages.coach_code', $request->coach);
            $chat_reports = $chat_reports->where('chat_messages_report.coach_code', $request->coach);
        }

        if($request->from_date) {
            $chats = $chats->where('chat_messages.created_at', '>=', $request->from_date. ' 00:00:00');
            $chat_reports = $chat_reports->where('chat_messages_report.created_at', '>=', $request->from_date. ' 00:00:00');
        }

        if($request->to_date) {
            $chats = $chats->where('chat_messages.created_at', '<=', $request->to_date. ' 23:59:59');
            $chat_reports = $chat_reports->where('chat_messages_report.created_at', '<=', $request->to_date. ' 23:59:59');
        }
        
        $chats = $chats->union($chat_reports);

        if($request->action == 'export') { 
            $headings = ['Coach Name', 'Principal Name', 'Chat Topic', 'Chat Start At', 'Chat End At'];
            $data = $chats->get()->map(function ($item, $key) {
                return [
                        'Coach Name' => $item->coach_first_name.' '.$item->coach_last_name,
                        'Principal Name' => $item->principal_first_name.' '.$item->principal_last_name,
                        'Chat Topic' => $item->topic,
                        'Chat Start At' => $item->created_at,
                        'Chat End At' => $item->updated_at
                    ];
            });
            return $this->export($headings, $data->toArray(), $page_title);
        }

        $summery = $chats;
        $summery = collect($summery->get());
        $chats = $chats->paginate(getPaginate());

        $summery = (object) [
            'chats' => $summery->count(), 
            'closed' => $chat_reports->count(), 
            'ongoing' => $summery->count() - $chat_reports->count(), 
            'total_users' => $summery->where('status', 1)->groupBy('principal_code')->count(),
        ];
        return view('admin.reports.chats', compact('page_title', 'coaches', 'chats', 'summery'));
    }

    public function userReport(Request $request)
    {
        $page_title = 'Users Report ';

        $users = Users::where('status', 1);

        if($request->type) {
            $users = $users->where('user_type', $request->type);
        }

        if($request->action == 'export') { 
            $headings = ['Name', 'Type', 'Email', 'Mobile', 'Title', 'School', 'Bio', 'Status', 'Joined On', 'State', 'District', 'Additional Data'];
            $data = $users->get()->map(function ($item, $key) {
                return [
                        'Name' => $item->first_name.' '.$item->last_name, 
                        'Type' => $item->user_type, 
                        'Email' => $item->email, 
                        'Mobile' => $item->mobile_no, 
                        'Title' => $item->title, 
                        'School' => $item->school, 
                        'Bio' => $item->bio, 
                        'Status' => $item->status ? 'active' : 'inactive', 
                        'Joined On' => $item->created_at, 
                        'State' => $item->state, 
                        'District' => $item->district, 
                        'Additional Data' => $item->additional_data, 
                    ];
            });
            return $this->export($headings, $data->toArray(), $page_title);
        }

        $users = $users->paginate(getPaginate());

        return view('admin.reports.users', compact('page_title', 'users'));
    }

    public function export($headings, $data, $title="")
    {
        $title = @str_replace(' ', '-', strtolower($title)) ?? '';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=".$title.date('Ymdhis').'.csv',
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($data, $headings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headings);

            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers); exit();
    }
}
