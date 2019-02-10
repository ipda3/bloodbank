<?php

namespace App\Http\Controllers\Api;

use App\Models\BloodType;
use App\Models\City;
use App\Models\Contact;
use App\Models\DonationRequest;
use App\Models\Governorate;
use App\Models\Post;
use App\Models\Client;
use App\Models\RequestLog;
use App\Models\Log;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function posts(Request $request)
    {
        RequestLog::create(['content' => $request->all(), 'service' => 'posts']);
        $posts = Post::with('category')->paginate(10);
        return responseJson(1, 'success', $posts);
    }

    public function donationRequests(Request $request)
    {
        RequestLog::create(['content' => $request->all(), 'service' => 'donations']);
        $donations = DonationRequest::where(function ($query) use ($request) {
            if ($request->has('city_id')) {
                $query->where('city_id', $request->city_id);
            }
            if ($request->has('blood_type')) {
                $query->where('blood_type', $request->blood_type);
            }
        })->with('city', 'client')->latest()->paginate(10);
        return responseJson(1, 'success', $donations);
    }

    public function post(Request $request)
    {
        RequestLog::create(['content' => $request->all(), 'service' => 'post details']);
        $post = Post::with('category')->find($request->post_id);
        if (!$post) {
            return responseJson(0, '404 no post found');
        }
        return responseJson(1, 'success', $post);
    }

    public function donationRequest(Request $request)
    {
        RequestLog::create(['content' => $request->all(), 'service' => 'donation details']);
        $donation = DonationRequest::with('city', 'client')->find($request->donation_id);
        if (!$donation) {
            return responseJson(0, '404 no donation found');
        }
        return responseJson(1, 'success', $donation);
    }

    public function governorates()
    {
        $governorates = Governorate::all();
        return responseJson(1, 'success', $governorates);
    }

    public function cities(Request $request)
    {
        RequestLog::create(['content' => $request->all(), 'service' => 'cities']);
        $cities = City::where(function ($query) use ($request) {
            if ($request->has('governorate_id')) {
                $query->where('governorate_id', $request->governorate_id);
            }
        })->get();
        return responseJson(1, 'success', $cities);
    }

    public function donationRequestCreate(Request $request)
    {
        // validation
        RequestLog::create(['content' => $request->all(), 'service' => 'donation create']);
        $rules = [
            'patient_name' => 'required',
            'patient_age' => 'required:digits',
            'blood_type' => 'required|in:O-,O+,B-,B+,A+,A-,AB-,AB+',
            'bags_num' => 'required:digits',
            'hospital_address' => 'required',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|digits:11',
        ];
        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        // create donation request
        $donationRequest = $request->user()->requests()->create($request->all());


        // find clients suitable for this donation request
        $clientsIds = $donationRequest->city->governorate->clients()
            ->whereHas('bloodtypes', function ($q) use ($request,$donationRequest) {
                $q->where('blood_types.name', $donationRequest->blood_type);
            })->pluck('clients.id')->toArray();

        $send = "";
        if (count($clientsIds)) {
            // create a notification on database
            $notification = $donationRequest->notifications()->create([
                'title' => 'يوجد حالة تبرع قريبة منك',
                'content' => $donationRequest->blood_type . 'محتاج متبرع لفصيلة ',
            ]);
            // attach clients to this notofication
            $notification->clients()->attach($clientsIds);

            $tokens = Token::whereIn('client_id',$clientsIds)->where('token','!=',null)->pluck('token')->toArray();
            if (count($tokens))
            {
                public_path();
                $title = $notification->title;
                $body = $notification->content;
                $data = [
                    'donation_request_id' => $donationRequest->id
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
                info("firebase result: " . $send);
//                info("data: " . json_encode($data));
            }

        }

        return responseJson(1, 'تم الاضافة بنجاح', compact('donationRequest'));

    }

    public function logs()
    {
        $requests = RequestLog::latest()->paginate(50);
        return $requests;
    }

    public function notificationsCount(Request $request)
    {
        return responseJson(1, 'loaded...', [
            'notifications_count' => $request->user()->notifications()->count()
        ]);
    }

    public function notifications(Request $request)
    {
        $items = $request->user()->notifications()->latest()->paginate(20);
        return responseJson(1, 'Loaded...', $items);
    }

    public function settings()
    {
        return responseJson(1, 'loaded', settings());
    }

    public function postFavourite(Request $request)
    {
        RequestLog::create(['content' => $request->all(), 'service' => 'post toggle favourite']);
        $rules = [
            'post_id' => 'required|exists:posts,id',
        ];
        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $toggle = $request->user()->favourites()->toggle($request->post_id);// attach() detach() sync() toggle()
        // [1,2,4] - sync(2,5,7) -> [1,2,4,5,7]
        // detach()
        // attach([2,5,7])
        return responseJson(1, 'Success', $toggle);
    }

    public function myFavourites(Request $request)
    {
        $posts = $request->user()->favourites()->latest()->paginate(20);// oldest()
        return responseJson(1, 'Loaded...', $posts);
    }

    public function contact(Request $request)
    {
        RequestLog::create(['content' => $request->all(), 'service' => 'contact us']);
        $rules = [
            'title' => 'required',
            'message' => 'required',
        ];
        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $contact = $request->user()->contacts()->create($request->all());
        return responseJson(1, 'تم الارسال', $contact);
    }

    public function report(Request $request)
    {
        RequestLog::create(['content' => $request->all(), 'service' => 'report']);
        $rules = [
            'message' => 'required',
        ];
        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $report = $request->user()->reports()->create($request->all());
        return responseJson(1, 'تم الارسال', $report);
    }


    public function testNotification(Request $request)
    {
        $audience = ['included_segments' => array('All')];
        if ($request->has('ids')) {
            $audience = ['include_player_ids' => (array)$request->ids];
        }
        $contents = ['en' => $request->title];
        Log::info('test notification');
        Log::info(json_encode($audience));
        $send = notifyByOneSignal($audience, $contents, $request->data);
        Log::info($send);
        /*
        firebase
        */
        /*
        $tokens = $request->ids;
        $title = $request->title;
        $body = $request->body;
        $data = Order::first();
        $send = notifyByFirebase($title, $body, $tokens, $data, true);
        info("firebase result: " . $send);
        */
        return response()->json([
            'status' => 1,
            'msg' => 'تم الارسال بنجاح',
            'send' => json_decode($send)
        ]);
    }

}
