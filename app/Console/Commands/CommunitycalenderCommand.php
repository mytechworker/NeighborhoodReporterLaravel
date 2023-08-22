<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\User;
use App\Event;
use App\Region;
use Carbon\Carbon;
use App\Communitie;
use App\SettingEmail;
use App\UserCommunitie;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Mail\CommunityCalenderMail;

class CommunitycalenderCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'communitycalender:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Communitycalender Command';

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
                $user_setting = SettingEmail::where('user_id', $user_community->user_id)->where('community_id', $user_community->communitie_id)->where('community_cal', '1')->count();
                if ($user_setting == 1) {
                    $user_community = Communitie::where('id', $user_community->communitie_id)->first();
                    $user_region = Region::where('id', $user_community->region_id)->first();
                    $startDate = date('Y-m-d', strtotime(' +1 day'));
                    $endDate = Carbon::today()->addDays(8)->format('Y-m-d');
                    $events = Event::where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->whereBetween('date', [$startDate, $endDate])
                            ->orderBy('intrest_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(5)
                            ->get();
                    $count = Event::where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->whereBetween('date', [$startDate, $endDate])
                            ->orderBy('intrest_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(5)
                            ->count();
                    if (count($events) > 0) {
                        $data = [
                            'count' => $count,
                            'events' => $events,
                            'location' => $user_region->name,
                            'town' => $user_community->name,
                            'user_id' => $user->id,
                        ];
                        Mail::to($user->email)->send(new CommunityCalenderMail($data));
                    }
                }
            }
        }
        $sub_user = Subscriber::where('type', 'community')->get();
        foreach ($sub_user as $user) {
            $user_communities = UserCommunitie::where('user_id', $user->id)->where('communitie_id', $user->location_id)->count();
            if ($user_communities == 0) {
                $user_setting = SettingEmail::where('user_id', $user->user_id)->where('community_id', $user->location_id)->where('community_cal', '1')->count();
                if ($user_setting == 1) {
                    $user_community = Communitie::where('id', $user->location_id)->first();
                    $user_region = Region::where('id', $user_community->region_id)->first();
                    $startDate = date('Y-m-d', strtotime(' +1 day'));
                    $endDate = Carbon::today()->addDays(8)->format('Y-m-d');
                    $events = Event::where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->whereBetween('date', [$startDate, $endDate])
                            ->orderBy('intrest_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(5)
                            ->get();
                    $count = Event::where('location', $user_region->name)
                            ->where('town', $user_community->name)
                            ->whereBetween('date', [$startDate, $endDate])
                            ->orderBy('intrest_count', 'DESC')
                            ->orderBy('comment_count', 'DESC')
                            ->take(5)
                            ->count();
                    if (count($events) > 0) {
                        $data = [
                            'count' => $count,
                            'events' => $events,
                            'location' => $user_region->name,
                            'town' => $user_community->name,
                            'user_id' => $user->id,
                        ];
                        Mail::to($user->email)->send(new CommunityCalenderMail($data));
                    }
                }
            }
        }
        $this->info('[' . date('Y-m-d H:i:s') . ']: Cron Command Run successfully!');
    }

}
