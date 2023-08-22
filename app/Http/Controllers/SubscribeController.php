<?php

namespace App\Http\Controllers;

use App\Region;
use App\Communitie;
use App\Subscriber;
use App\SettingEmail;
use App\Mail\SubscribeMail;
use Illuminate\Http\Request;
use Mail;

class SubscribeController extends Controller
{
    public function create(Request $request)
    {
        $segment2= $request->segment(2);
        return view('subscribe',compact('segment2'));
    }

    public function store(Request $request)
    {
        $user_community = Communitie::where('name', $request->location)->first();
        $user_region = Region::where('id', $user_community->region_id)->first();
        $Id = $user_community->id;
        $location = $user_community->name;

        $subscriberCount = Subscriber::where('email', $request->email)->where('location_id', $Id)->where('type', 'community')->count();
        if ($subscriberCount == 0) {
            $sub = Subscriber::where('email', $request->email)->first();
            if (empty($sub)) {
                $uid = generateRandomNumeric(8);
            } else {
                $uid = $sub->user_id;
            }
            $settingemail = new SettingEmail();
            $settingemail->user_id = $uid;
            $settingemail->community_id = $Id;
            $settingemail->daily_news = 1;
            $settingemail->breacking_news = 1;
            $settingemail->community_cal = 1;
            $settingemail->neighbor_posts = 1;
            $settingemail->classifieds = 1;
            $settingemail->save();
            $subscriber = new Subscriber();
            $subscriber->email = $request->email;
            $subscriber->location_id = $Id;
            $subscriber->user_id = $settingemail->user_id;
            $subscriber->type = 'community';
            $subscriber->status = 1;
            $subscriber->save();
            $data = [
                'user_community' => (isset($user_community->name) ? $user_community->name : ""),
                'user_region' => $user_region->name,
                'user_id' => $settingemail->user_id,
            ];
            Mail::to($request->email)->send(new SubscribeMail($data));
            return redirect()->back()->with('message','Subscribed successfully.!');
        } else {
            return redirect()->back()->with('message','Look like you are already get updates from ' . $location . '!');
        }
    }
}
