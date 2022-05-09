<?php
namespace Modules\Core\Traits;


use Modules\User\Entities\FcmToken;

trait NotificationHelper
{



    static function notifyByFirebase($title, $body, $tokens, $data = [] , $imageUrl = null, $sound = 'on')        // paramete 5 =>>>> $type
    {

        $registrationIDs = $tokens;

        $fcmMsg = array(
            'body' => $body,
            'title' => $title,
            'color' => "#203E78"
        );

        $sound == 'on' ? $fcmMsg += ['sound' => "default"] : null;
        $imageUrl ? $fcmMsg += ['image' => $imageUrl] : null;

        $fcmFields = array(
            'registration_ids' => $registrationIDs,
            'priority' => 'high',
            'notification' => $fcmMsg,
            'data' => $data
        );
        $headers = array(
            'Authorization: key='.env('FCM_TOKEN'),
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }



    static function sendNotification($model ,$notifierIds, $relation, $title, $body, $data_type = 'admin', $data = [], $image = null): void
    {
        $notifierIds = (array)$notifierIds;

        if (count($notifierIds)){

            $notification = $model->notifications()->create([
                'title' => $title,
                'body' => $body
            ]);

            if ($image) {
                \Modules\Core\Traits\Attachment\Attachment::addAttachment($image, 'notifications', $notification,['size' => 600, 'quality' => 50, 'relation' => 'image']);
            }

            $notification->$relation()->attach($notifierIds);

            if (FcmToken::CheckType($relation)->whereIn('tokenable_id', $notifierIds)->count()) {

                FcmToken::CheckType($relation)->whereIn('tokenable_id', $notifierIds)->chunk(999, function ($records) use ($notification, $data, $data_type) {

                    $tokens = $records->pluck('token')->toArray();

                    $data =
                        [
                            $data_type => $data
                        ];

                    //send notification for client tokens
                    $send = self::notifyByFirebase($notification->title, $notification->body, $tokens, $data, $notification->photo);
//                    info($send);
                });

            }
        }
    }

}
