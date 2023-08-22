<?php

namespace App\Http\Controllers;

use Mail;
use App\Post;
use App\User;
use App\Event;
use App\Region;
use Carbon\Carbon;
use App\Classified;
use App\Communitie;
use App\SettingEmail;
use App\UserCommunitie;
use App\Mail\NewsLetterMail;
use Illuminate\Http\Request;

class TestController extends Controller {

    public function test() {
        $users = User::get();
        foreach ($users as $user) {
            $user_communities = UserCommunitie::where('user_id', $user->id)->get();
            foreach ($user_communities as $user_community) {
                $user_setting = SettingEmail::where('user_id', $user_community->user_id)->where('community_id', $user_community->communitie_id)->where('daily_news', '1')->count();
                if ($user_setting == 1) {
                    $user_community = Communitie::where('id', $user_community->communitie_id)->first();
                    $user_region = Region::where('id', $user_community->region_id)->first();

                    $articles = Post::where('post_type', 'article')->where('location', $user_region->name)->where('town', $user_community->name)->whereDate('post_date', '>', Carbon::now()->subDays(2))->get();
                    $events = Event::where('location', $user_region->name)->where('town', $user_community->name)->whereDate('created_at', '>', Carbon::now()->subDays(2))->get();
                    $classifieds = Classified::where('location', $user_region->name)->where('town', $user_community->name)->whereDate('created_at', '>', Carbon::now()->subDays(2))->get();
                    $neighbours = Post::where('post_type', 'neighbour')->where('location', $user_region->name)->where('town', $user_community->name)->whereDate('post_date', '>', Carbon::now()->subDays(2))->get();
                    //dd($articles);
                    $data = [
                        'articles' => $articles,
                        'events' => $events,
                        'classifieds' => $classifieds,
                        'neighbours' => $neighbours,
                        'location' => $user_region->name,
                        'town' => $user_community->name,
                        'user_id' => $user->id,
                    ];
                    Mail::to($user->email)->send(new NewsLetterMail($data));
                }
            }
        }
    }

}
