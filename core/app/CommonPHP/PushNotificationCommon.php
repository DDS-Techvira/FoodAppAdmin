<?php


namespace App\CommonPHP;

use App\NotificationModel;
use App\PushNotificationsTokenModel;

class PushNotificationCommon
{
    public static function sendNotification($receiving_user_id, $msg_body, $msg_title, $click_action, $msg_type, $msg_id, $sub_no = 0)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $to = 'fmtQVuuaR5SnQw8k3C1BQC:APA91bGh1yQc3luCS8C8XGgy9AmU0ZSRA6OwhpFWDv8n5A2GQnqFZax8CbXeLy5wWDZkk3JXmi5EpuwnYGwVUxgA2OdXb7rX1KtvE8nkVA3mHFFajClsQhBFMaTYlAz2TyAev3bCJiE1';



        $login_device_tokens = PushNotificationsTokenModel::where('user_id', '=', $receiving_user_id)->groupBy('token')->get();

//        if(sizeof($login_device_tokens)>0){
            //save notification details
            if ($msg_id != '') {
                $notification_model = new NotificationModel();
                $notification_model->type = $msg_type;
                $notification_model->related_table_id = $msg_id;
                $notification_model->related_table_uuid = $sub_no;
                $notification_model->user_id = $receiving_user_id;
                $notification_model->title = $msg_title;
                $notification_model->body = $msg_body;
                $notification_model->click_action = $click_action;
                $notification_model->status = 0;
                $notification_model->save();
            }
//        }

//web
//        "to" => 'fUuBZg3Ep9CSt6iqvk2pTR:APA91bH1SGyZ2j6U-HJ_HeBKx3j5hWojH6bP2ZkKmhRmTaGoyEy-cZoCjaykQp2_BaZwagFeWbnxtfFOJu6iaIm_b28bDn7kKXD1-GCux01UZ8fwRA9wkdcleJSEofpLWutpfrjw9TFE',
//mobile
//          "to" => 'fmtQVuuaR5SnQw8k3C1BQC:APA91bGh1yQc3luCS8C8XGgy9AmU0ZSRA6OwhpFWDv8n5A2GQnqFZax8CbXeLy5wWDZkk3JXmi5EpuwnYGwVUxgA2OdXb7rX1KtvE8nkVA3mHFFajClsQhBFMaTYlAz2TyAev3bCJiE1',


        foreach ($login_device_tokens as $login_device_token) {

            if ($login_device_token->device_type == 'web') {
                $fields = array(
                    "to" => $login_device_token->token,

                    "notification" => array(
                        "body" => $msg_body,
                        "title" => $msg_title,
                        "icon" => 'https://theprincipalsclub.ams3.digitaloceanspaces.com/assets/images/logoIcon/logo.png',
                        "click_action" => $click_action),
                    "data" => array(
                        "type" => $msg_type,
                        "id" => $msg_id,
                        "sub_no" => $sub_no,
                    )
                );

                $headers = array(
                    'Authorization: key= AAAA8b-5g5A:APA91bHceBRGF8L78cCT_iwOcA2PfPGD50fqizGDVlQ6kZOnGsKhZCCxzmTQSf37L8iaoO70z2SBdulhzy9iJezcAiUwkMkuoLqHQKuJmZ20TN6xnm5HwRPQg1HhZDMlMUWIW48xVSFz',
                    'Content-Type:application/json'
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
//            print_r($result);
                curl_close($ch);

            } else if ($login_device_token->device_type == 'android') {
                $fields = array(
                 "to" => $login_device_token->token,
                    // "to" => "cfOndvgiQWuzVjgHBo4VfK:APA91bEEp6tHk960j5-dCNOnZL1dZZbXGKZFrb1KtqseGJnsUFWgG2irLoyJHMXxFIFZhuLK2R6ESmSuU84_dAbXBXM_Y5jnpZbBdjwM7Q0VXqcDTfmKpxEv9BcGbbFIEMr_9pcROnlM",

                    "notification" => array(
                        "body" => $msg_body,
                        "title" => $msg_title,
                        "icon" => 'https://theprincipalsclub.ams3.digitaloceanspaces.com/assets/images/logoIcon/logo.png',
                       // "click_action" =>'FLUTTER_NOTIFICATION_CLICK'
                    ),
                    "data" => array(
                        "type" => $msg_type,
                        "id" => $msg_id,
                        "sub_no" => $sub_no,
			"click_action" =>'FLUTTER_NOTIFICATION_CLICK',
                    )
                );

                $headers = array(
                    'Authorization: key= AAAA8b-5g5A:APA91bHceBRGF8L78cCT_iwOcA2PfPGD50fqizGDVlQ6kZOnGsKhZCCxzmTQSf37L8iaoO70z2SBdulhzy9iJezcAiUwkMkuoLqHQKuJmZ20TN6xnm5HwRPQg1HhZDMlMUWIW48xVSFz',
                    'Content-Type:application/json'
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
//            print_r($result);
                curl_close($ch);

            } else if ($login_device_token->device_type == 'apple') {
                $fields = array(
                    "to" => $login_device_token->token,

                    "notification" => array(
                        "body" => $msg_body,
                        "title" => $msg_title,
                        "icon" => 'https://theprincipalsclub.ams3.digitaloceanspaces.com/assets/images/logoIcon/logo.png',
                        "click_action" =>'FLUTTER_NOTIFICATION_CLICK'),
                    "data" => array(
                        "data" => array(
                        "type" => $msg_type,
                        "id" => $msg_id,
                        "sub_no" => $sub_no,
			"click_action" =>'FLUTTER_NOTIFICATION_CLICK',
                    )

                    )
                );

                $headers = array(
                    'Authorization: key= AAAA8b-5g5A:APA91bHceBRGF8L78cCT_iwOcA2PfPGD50fqizGDVlQ6kZOnGsKhZCCxzmTQSf37L8iaoO70z2SBdulhzy9iJezcAiUwkMkuoLqHQKuJmZ20TN6xnm5HwRPQg1HhZDMlMUWIW48xVSFz',
                    'Content-Type:application/json'
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
//            print_r($result);
                curl_close($ch);
            }


        }


    }
}
