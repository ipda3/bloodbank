<?php

/**
 * @param null $string
 * @param string $separator
 * @return mixed|null|string
 */
function make_slug($string = null, $separator = "-")
{
    if (is_null($string)) {
        return "";
    }
    // Remove spaces from the beginning and from the end of the string
    $string = trim($string);
    // Lower case everything
    // using mb_strtolower() function is important for non-Latin UTF-8 string | more info: http://goo.gl/QL2tzK
    $string = mb_strtolower($string, "UTF-8");;
    // Make alphanumeric (removes all other characters)
    // this makes the string safe especially when used as a part of a URL
    // this keeps latin characters and arabic charactrs as well
    $string = preg_replace("/[^a-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);
    // Remove multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    // Convert whitespaces and underscore to the given separator
    $string = preg_replace("/[\s_]/", $separator, $string);
    return $string;
}

function settings()
{
    $settings = \App\Models\Setting::find(1);

    if ($settings) {
        return $settings;
    } else {
        return new \App\Models\Setting;
    }
}

function notifyByOneSignal($audience = ['included_segments' => array('All')], $contents = ['en' => ''], $data = [])
{

    // audience include_player_ids
    $appId = ['app_id' => env('ONE_SIGNAL_APP_ID')];

    $fields = json_encode((array)$appId + (array)$audience + ['contents' => (array)$contents] + ['data' => (array)$data]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . env('ONE_SIGNAL_KEY')));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

/**
 * trigger pusher events
 * @param $channels
 * @param $event
 * @param $data
 */
// function pusher($channels, $event, $data)
// {
//     $options = array(
//         'cluster' => 'ap1',
//         'encrypted' => true
//     );
//     $pusher = new \Pusher(
//         env('PUSHER_KEY'), env('PUSHER_SECRET'), env('PUSHER_APP_ID'),
//         $options
//     );

//     $pusher->trigger($channels, $event, $data);
// }

// function responseJson($status, $msg, $data = null)
// {
//     $response = [
//         'status' => $status,
//         'msg' => $msg,
//         'data' => $data
//     ];
//     return response()->json($response);
// }

function page($id)
{
    $page = \App\Models\Page::find($id);

    if ($page) {
        return $page;
    } else {
        return new \App\Models\Settings;
    }
}

function responseJson($status, $msg, $data = null)
{
    $response = [
        'status' => $status,
        'msg' => $msg,
        'data' => $data
    ];
    return response()->json($response);
}

function getYoutubeId($url)
{
    /*
     Here is a sample of the URLs this regex matches: (there can be more content after the given URL that will be ignored)
     http://youtu.be/dQw4w9WgXcQ
     http://www.youtube.com/embed/dQw4w9WgXcQ
     http://www.youtube.com/watch?v=dQw4w9WgXcQ
     http://www.youtube.com/?v=dQw4w9WgXcQ
     http://www.youtube.com/v/dQw4w9WgXcQ
     http://www.youtube.com/e/dQw4w9WgXcQ
     http://www.youtube.com/user/username#p/u/11/dQw4w9WgXcQ
     http://www.youtube.com/sandalsResorts#p/c/54B8C800269D7C1B/0/dQw4w9WgXcQ
     http://www.youtube.com/watch?feature=player_embedded&v=dQw4w9WgXcQ
     http://www.youtube.com/?feature=player_embedded&v=dQw4w9WgXcQ
     It also works on the youtube-nocookie.com URL with the same above options.
     It will also pull the ID from the URL in an embed code (both iframe and object tags)
    */
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    if (isset($match[1])) {
        return $match[1];
    }
    return "";
}


function notifyByFirebase($title,$body,$tokens,$data = [],$type)
{
// https://gist.github.com/rolinger/d6500d65128db95f004041c2b636753a
// API access key from Google FCM App Console
    // env('FCM_API_ACCESS_KEY'));

//    $singleID = 'eEvFbrtfRMA:APA91bFoT2XFPeM5bLQdsa8-HpVbOIllzgITD8gL9wohZBg9U.............mNYTUewd8pjBtoywd';
//    $registrationIDs = array(
//        'eEvFbrtfRMA:APA91bFoT2XFPeM5bLQdsa8-HpVbOIllzgITD8gL9wohZBg9U.............mNYTUewd8pjBtoywd',
//        'eEvFbrtfRMA:APA91bFoT2XFPeM5bLQdsa8-HpVbOIllzgITD8gL9wohZBg9U.............mNYTUewd8pjBtoywd',
//        'eEvFbrtfRMA:APA91bFoT2XFPeM5bLQdsa8-HpVbOIllzgITD8gL9wohZBg9U.............mNYTUewd8pjBtoywd'
//    );
    $registrationIDs = $tokens;

// prep the bundle
// to see all the options for FCM to/notification payload:
// https://firebase.google.com/docs/cloud-messaging/http-server-ref#notification-payload-support

// 'vibrate' available in GCM, but not in FCM
    $fcmMsg = array(
        'body' => $body,
        'title' => $title,
        'sound' => "default",
        'color' => "#203E78"
    );
// I haven't figured 'color' out yet.
// On one phone 'color' was the background color behind the actual app icon.  (ie Samsung Galaxy S5)
// On another phone, it was the color of the app icon. (ie: LG K20 Plush)

// 'to' => $singleID ;      // expecting a single ID
// 'registration_ids' => $registrationIDs ;     // expects an array of ids
// 'priority' => 'high' ; // options are normal and high, if not set, defaults to high.
    $fcmFields = array(
        'registration_ids' => $registrationIDs,
        'priority' => 'high',
        'notification' => $fcmMsg,
        'data' => $data
    );

    if($type == 'client')
    {
        $headers = array(
            'Authorization: key='.env('API_ACCESS_KEY_client'),
            'Content-Type: application/json'
        );
    }
    if($type == 'driver')
    {
        $headers = array(
            'Authorization: key='.env('API_ACCESS_KEY_driver'),
            'Content-Type: application/json'
        );
    }

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
