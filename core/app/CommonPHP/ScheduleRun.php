<?php
namespace App\CommonPHP;
use App\ScheduledAppointments;
use App\Users;
use App\WebinarModel;
use App\WebinarUsersModel;
use Carbon\Carbon;
use App\CommonPHP\PushNotificationCommon;

class ScheduleRun
{
    public static function runScheduleReminder()
    {
        $schedules = ScheduledAppointments::where('appt_date', date("Y-m-d"))
                                            ->where('time_slot', date("h:i a", strtotime("+15 minutes", strtotime('now'))))
                                            ->where('status', 1)
                                            ->get();

        foreach ($schedules as $key => $schedule) { 
            if($schedule->coach_code && $schedule->principal_code) {
                // 
                $coach = Users::where('user_code',$schedule->coach_code)->first();
                $principal = Users::where('user_code',$schedule->principal_code)->first();

                $noty_msg_body = 'Your appointment with '.$coach->first_name . ' ' . $coach->last_name.' is scheduled for '.Carbon::parse($schedule->appt_date)->format('m-d-Y'). ' at '.$schedule->time_slot;
                $noty_msg_title = 'Call Schedule Reminder';
                $click_action = 'https://admin.theprincipalsclub.com';
                $msg_type = 'call_reminder';
                $msg_id = $schedule->id;
                $sub_id = $schedule->appointments_code;
                //dr reply to special msg
                PushNotificationCommon::sendNotification($principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

                $noty_msg_body1 = 'Your appointment with '.$principal->first_name . ' ' . $principal->last_name.' is scheduled for '.Carbon::parse($schedule->appt_date)->format('m-d-Y'). ' at '.$schedule->time_slot;
                $noty_msg_title1 = 'Call Schedule Reminder';
                $click_action1 = 'https://admin.theprincipalsclub.com';
                $msg_type1 = 'call_reminder';
                $msg_id1 = $schedule->id;
                $sub_id1 = $schedule->appointments_code;
                //dr reply to special msg
                PushNotificationCommon::sendNotification($coach->id, $noty_msg_body1, $noty_msg_title1, $click_action1, $msg_type, $msg_id, $sub_id);
            }
        }
    }

    public static function runScheduleIncompleteCheck()
    {
        $schedules = ScheduledAppointments::with('callHistory')->where('appt_date', date("Y-m-d"))
                                            ->where('status', 1)
                                            ->whereDoesntHave('callHistory')
                                            ->get();

        foreach ($schedules as $key => $schedule) {
            $start_at = date("Y-m-d h:iA", strtotime("$schedule->appt_date $schedule->time_slot"));
            $end_at = date("Y-m-d h:iA", strtotime("+$schedule->duration minutes", strtotime($start_at)));
            $now = date("Y-m-d h:iA", strtotime("now"));

            // when if schedule should ended by now!
            if(strtotime($end_at) < strtotime($now)) {
                // change schedule status incomplete
                $schedule->status = 5;
                $schedule->save();
            }
        }
    }

    public static function runWebinarReminder()
    {
        $webinars = WebinarModel::where('date', date('Y-m-d'))
                                ->where('time', date('H:i', strtotime("+15 minutes", strtotime('now'))))
                                // ->where('status', 1)
                                ->whereNotNull('coach_code')
                                ->get();

        foreach ($webinars as $key => $webinar) {

            $noty_msg_body = "The $webinar->title webinar will start at ".date('H:i A', strtotime($webinar->time)).".";
            $noty_msg_title = 'Webinar Reminder';
            $click_action = '';
            $msg_type = 'webinar_reminder';
            $msg_id = $webinar->id;
            $sub_id = 0;

            // notification to coach:
            PushNotificationCommon::sendNotification($webinar->coach->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

            // get webinar users 
            $wbUsers = Users::where('user_type','principal')->where('status',1)->get();

            foreach ($wbUsers as $key => $wbUser) {
                // notification to users/principals: 
                $msg_id = $wbUser->id; 
                PushNotificationCommon::sendNotification($wbUser->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);
            }
        }
    }
}
