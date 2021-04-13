<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Notification;

class NotificationController extends Controller
{
	public function notification(Request $request)
	{
		$data['meta_title'] = 'Send Notification';
    	return view('backend.notification.list', $data);
	}

	public function updateNotification(Request $request)
	{
		// dd($request->all());
		$getUser = User::where('is_admin', '=', '0')->get();

		$result = Notification::find(1);
		$serverKey = $result->notification_key;

        //$serverKey = "AAAAvQiwXHg:APA91bFnqpyOr8-FzuWxezZCNpq-RGf6igYxkj5d4UPt3ie5ZZGTIjo054-kXILYdd6LaxhbLluKWDOF7hwaNHw5uafyZIBA2d5_zdtmC1_FiCdipYxuambywB075YAD5P-HVQ-K1x4j";
        
    	if(!empty($getUser))
		{
			foreach ($getUser as $value) {
				
				if (!empty($value->token)) {

					$token = $value->token;
					// dd($token);
					$body['title'] = $request->title;
					$body['message'] = $request->message;
					//	dd($body['title']);
					//dd($body['message']);

					$url = "https://fcm.googleapis.com/fcm/send";

					$notification = array('title' => $request->title, 'text' => $request->message);

					$arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $body, 'priority' => 'high');
					// dd($arrayToSend);
					$json1 = json_encode($arrayToSend);
					$headers = array();
					$headers[] = 'Content-Type: application/json';
					$headers[] = 'Authorization: key=' . $serverKey;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $json1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					//Send the request
					$response = curl_exec($ch);
					// dd($response);
					curl_close($ch);

				}
			}
		}
	return redirect()->back()->with('success', 'Notification successfully sent.');
	}

}
?>
