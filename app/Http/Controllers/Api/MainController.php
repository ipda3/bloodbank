<?php

namespace App\Http\Controllers\Api;

use App\Models\BloodType;
use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\DonationRequest;
use App\Models\Governorate;
use App\Models\Notification;
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
        // with('relation_name')
        // load('city') lazy eager loading
        $posts = Post::with('category')->where(function($post) use($request){
            if ($request->input('category_id'))
            {
                $post->where('category_id',$request->category_id);
            }

            if ($request->input('keyword'))
            {
                $post->where(function($post) use($request){
                    $post->where('title','like','%'.$request->keyword.'%');
                    $post->orWhere('content','like','%'.$request->keyword.'%');
                });
            }

        })->latest()->paginate(10);
        return responseJson(1, 'success', $posts);
    }

    public function donationRequests(Request $request)
    {
        RequestLog::create(['content' => $request->all(), 'service' => 'donations']);
        $donations = DonationRequest::where(function ($query) use ($request) {
            if ($request->input('governorate_id')) {
                $query->whereHas('city', function ($query) use($request){
                    $query->where('governorate_id',$request->governorate_id);
                });
            }elseif ($request->input('city_id')) {
                $query->where('city_id', $request->city_id);
            }
            if ($request->input('blood_type_id')) {
                $query->where('blood_type_id', $request->blood_type_id);
            }
        })->with('city', 'client','bloodType')->latest()->paginate(10);

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
        $donation = DonationRequest::with('city', 'client','bloodType')->find($request->donation_id);
        if (!$donation) {
            return responseJson(0, '404 no donation found');
        }
        // DonationRequest::doesnthave('notification')->delete();
        $request->user()->notifications()->updateExistingPivot($donation->notification->id, [
            'is_read' => 1
        ]);

        return responseJson(1, 'success', $donation);
    }

    public function governorates()
    {
        $governorates = Governorate::all();
        return responseJson(1, 'success', $governorates);
    }

    public function bloodTypes()
    {
        $bloodTypes = BloodType::all();
        return responseJson(1, 'success', $bloodTypes);
    }

    public function categories()
    {
        $categories = Category::all();
        return responseJson(1, 'success', $categories);
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
            'blood_type_id' => 'required|exists:blood_types,id',
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
        $donationRequest = $request->user()->requests()->create($request->all())->load('city.governorate','bloodType');


        // find clients suitable for this donation request
         $clientsIds = $donationRequest()->city()->governorate()->clients()
                     ->whereHas('bloodtypes', function ($q) use ($request,$donationRequest) {
                         $q->where('blood_types.id', $donationRequest->blood_type_id);
                     })->pluck('clients.id')->toArray();

       dd($clientsIds);
        $send = "";
        if (count($clientsIds)) {
            // create a notification on database
            $notification = $donationRequest->notifications()->create([
                'title' => 'يوجد حالة تبرع قريبة منك',
                'content' => optional($donationRequest->bloodType)->name . 'محتاج متبرع لفصيلة ',
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
         $count = $request->user()->notifications()->where(function ($query) use ($request) {

                $query->where('is_read',0);

        })->count();
        return responseJson(1, 'loaded...',[
            'notifications-count' => $count
        ]);
           // 'notifications_count' => $request->user()->notifications()->count()

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
        $posts = $request->user()->favourites()->with('category')->latest()->paginate(20);// oldest()
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
//        $audience = ['included_segments' => array('All')];
//        if ($request->has('ids'))
//        {
//            $audience = ['include_player_ids' => (array)$request->ids];
//        }
//        $contents = ['en' => $request->title];
//        Log::info('test notification');
//        Log::info(json_encode($audience));
//        $send = notifyByOneSignal($audience , $contents , $request->data);
//        Log::info($send);

        /*
        firebase
        */
        $tokens = $request->ids;
        $title = $request->title;
        $body = $request->body;
        $data = DonationRequest::first();
        $send = notifyByFirebase($title, $body, $tokens, $data);
        info("firebase result: " . $send);

        return response()->json([
            'status' => 1,
            'msg' => 'تم الارسال بنجاح',
            'send' => json_decode($send)
        ]);
    }

}
