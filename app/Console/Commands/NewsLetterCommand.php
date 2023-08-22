<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
use App\Subscriber;
use App\Mail\NewsLetterMail;
use Illuminate\Http\Request;

class NewsLetterCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'NewsletterCommand';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $users = User::get();
        foreach ($users as $user) {
            $user_communities = UserCommunitie::where('user_id', $user->id)->get();
            foreach ($user_communities as $user_community) {
                $user_setting = SettingEmail::where('user_id', $user_community->user_id)->where('community_id', $user_community->communitie_id)->where('daily_news', '1')->count();
                if ($user_setting == 1) {
                    $user_community = Communitie::where('id', $user_community->communitie_id)->first();
                    $user_region = Region::where('id', $user_community->region_id)->first();
                    $articles = Post::where('post_type', 'article')
                            ->where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->where('post_status', 'active')
                            ->whereBetween('post_date', [Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), date('Y-m-d H:i:s')])
                            ->orderBy('like_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(5)
                            ->get();
                    $events = Event::where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), date('Y-m-d H:i:s')])
                            ->orderBy('intrest_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(3)
                            ->get();
                    $classifieds = Classified::where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), date('Y-m-d H:i:s')])
                            ->orderBy('like_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(3)
                            ->get();
                    $neighbours = Post::where('post_type', 'neighbour')
                            ->where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->where('post_status', 'active')
                            ->whereBetween('post_date', [Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), date('Y-m-d H:i:s')])
                            ->orderBy('like_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(5)
                            ->get();
                    if (count($articles) > 0 || count($events) > 0 || count($classifieds) > 0 || count($neighbours) > 0) {
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
        $sub_user = Subscriber::where('type', 'community')->get();
        foreach ($sub_user as $user) {
            $user_communities = UserCommunitie::where('user_id', $user->id)->where('communitie_id', $user->location_id)->count();
            if ($user_communities == 0) {
                $user_setting = SettingEmail::where('user_id', $user->user_id)->where('community_id', $user->location_id)->where('classifieds', '1')->count();
                if ($user_setting == 1) {
                    $user_community = Communitie::where('id', $user->location_id)->first();
                    $user_region = Region::where('id', $user_community->region_id)->first();
                    $articles = Post::where('post_type', 'article')
                            ->where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->where('post_status', 'active')
                            ->whereBetween('post_date', [Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), date('Y-m-d H:i:s')])
                            ->orderBy('like_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(5)
                            ->get();
                    $events = Event::where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), date('Y-m-d H:i:s')])
                            ->orderBy('intrest_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(3)
                            ->get();
                    $classifieds = Classified::where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), date('Y-m-d H:i:s')])
                            ->orderBy('like_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(3)
                            ->get();
                    $neighbours = Post::where('post_type', 'neighbour')
                            ->where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->where('post_status', 'active')
                            ->whereBetween('post_date', [Carbon::now()->subDays(1)->format('Y-m-d H:i:s'), date('Y-m-d H:i:s')])
                            ->orderBy('like_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(5)
                            ->get();
                    if (count($articles) > 0 || count($events) > 0 || count($classifieds) > 0 || count($neighbours) > 0) {
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
        $this->info('[' . date('Y-m-d H:i:s') . ']: Cron Command Run successfully!');
    }

}
