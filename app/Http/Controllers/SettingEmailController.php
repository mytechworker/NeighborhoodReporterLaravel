<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserCommunitie;
use App\Communitie;
use App\SettingEmail;
use App\Region;
use App\User;
use Illuminate\Support\Facades\Session;

class SettingEmailController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $result = $request->get('sid');
        if ($result != 0) {
            $id = $result;
        } elseif ($result == 0) {
            if (isset(Auth::user()->id)) {
                $id = Auth::user()->id;
            } else {
                $id = Session::get('key');
            }
        }
        //get coummnity name
        $community_id = UserCommunitie::where('user_id', $id)
                ->select('communitie_id')
                ->orderBy('default', 'DESC')
                ->get();
        if ($community_id->isEmpty()) {
            $community_id = SettingEmail::join('subscriber', 'subscriber.user_id', '=', 'setting_email.user_id')
                    ->select('setting_email.community_id AS communitie_id')
                    ->where('subscriber.type', 'community')
                    ->where('setting_email.user_id', $id)
                    ->groupBy('setting_email.community_id')
                    ->get();
        }
        $set_community = [];
        foreach ($community_id as $data) {
            $community = Communitie::where('id', $data->communitie_id)->get();
            foreach ($community as $c_data) {
                $region = Region::where('id', $c_data->region_id)->select('region_code')->get();
                $set_community[$c_data->id] = [
                    "user_id" => $id,
                    "community_id" => $c_data->id,
                    "region_id" => $c_data->region_id,
                    "name" => $c_data->name,
                    "region_code" => $region[0]->region_code,
                    "daily_news" => 0,
                    "breacking_news" => 0,
                    "community_cal" => 0,
                    "neighbor_posts" => 0,
                    "classifieds" => 0,
                ];
            }
        }
        
        $setting_email = SettingEmail::where('user_id', $id)->get();
        $s_email = count($setting_email);
        if ($s_email != 0 && $s_email != null) {
            foreach ($setting_email as $data) {
                $community = Communitie::where('id', $data->community_id)->first();
                $region = Region::where('id', $community->region_id)->select('region_code')->get();
                $set_community[$data->community_id]['user_id'] = $id;
                $set_community[$data->community_id]['community_id'] = $data->community_id;
                $set_community[$data->community_id]['region_id'] = $community->region_id;
                $set_community[$data->community_id]['name'] = $community->name;
                $set_community[$data->community_id]['region_code'] = $region[0]->region_code;
                $set_community[$data->community_id]['daily_news'] = $data->daily_news;
                $set_community[$data->community_id]['breacking_news'] = $data->breacking_news;
                $set_community[$data->community_id]['community_cal'] = $data->community_cal;
                $set_community[$data->community_id]['neighbor_posts'] = $data->neighbor_posts;
                $set_community[$data->community_id]['classifieds'] = $data->classifieds;
            }
        }
        $user_email = User::where('id', $id)
                ->select('company_news', 'replies_posts')
                ->get();
//        
        return view('setting_email', ['data' => $set_community, 'user_data' => $user_email]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $result = $request->get('sid');
        if ($result != 0) {
            $id = $result;
        } elseif ($result == 0) {
            if (isset(Auth::user()->id)) {
                $id = Auth::user()->id;
            } else {
                $id = Session::get('key');
            }
        }
        $request = $request->all();
        User::where('id', $id)->update([
            'company_news' => isset($request['company_news']) ? $request['company_news'] : 0,
            'replies_posts' => isset($request['replies_posts']) ? $request['replies_posts'] : 0,
        ]);
        $message = '';
        foreach ($request['form'] as $data) {
            $data_count = SettingEmail::where('user_id', $data['user_id'])
                    ->where('community_id', $data['community_id'])
                    ->count();
            if ($data_count != null && $data_count != 0) {
                SettingEmail::where('user_id', $data['user_id'])
                        ->where('community_id', $data['community_id'])
                        ->update([
                            'daily_news' => isset($data['daily_news']) ? $data['daily_news'] : false,
                            'breacking_news' => isset($data['breaking_news']) ? $data['breaking_news'] : false,
                            'community_cal' => isset($data['community_cal']) ? $data['community_cal'] : false,
                            'neighbor_posts' => isset($data['neighbor_posts']) ? $data['neighbor_posts'] : false,
                            'classifieds' => isset($data['classifieds']) ? $data['classifieds'] : false,
                ]);
                $message = "Mail Setting Updated";
            } else {
                SettingEmail::insert([
                    'user_id' => $data['user_id'],
                    'community_id' => $data['community_id'],
                    'daily_news' => isset($data['daily_news']) ? $data['daily_news'] : false,
                    'breacking_news' => isset($data['breaking_news']) ? $data['breaking_news'] : false,
                    'community_cal' => isset($data['community_cal']) ? $data['community_cal'] : false,
                    'neighbor_posts' => isset($data['neighbor_posts']) ? $data['neighbor_posts'] : false,
                    'classifieds' => isset($data['classifieds']) ? $data['classifieds'] : false,
                ]);
                $message = "Mail Setting Created";
            }
        }
        session(['key' => $id]);
        $value = Session::get('key');
//        dd($result);
        return redirect('settings/email')->with('message', $message);
    }

    public function addEmail(Request $request) {
        if (null !== $request->community) {
            $user_community = Communitie::where('name', $request->community)->first();
        }
        SettingEmail::insert([
            'user_id' => Auth::id(),
            'community_id' => $user_community->id,
            'daily_news' => 1,
            'breacking_news' => 1,
            'community_cal' => 1,
            'neighbor_posts' => 1,
            'classifieds' => 1,
        ]);
        echo \GuzzleHttp\json_encode(array('status' => 'success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
