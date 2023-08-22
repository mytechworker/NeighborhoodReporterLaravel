<?php

namespace App\Http\Controllers;

use App\User;
use App\Communitie;
use App\UserCommunitie;
use App\FeatureBusiness;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\File;
use Mail;
use App\Mail\BusinessContactMail;

class BizpostController extends Controller {

    private $post;
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostRepository $postRepository, UserRepository $UserRepository) {
        $this->post = $postRepository;
        $this->user = $UserRepository;
    }

    public function index(Request $request) {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $info['location'] = $request->location;
        $info['town'] = $request->town;
        return view('compose.bizpost', compact('info'));
    }

    public function search_community(Request $request) {
        if ($request->ajax()) {
            $data = Communitie::join('regions', 'regions.id', '=', 'communities.region_id')
                    ->select('communities.name', 'communities.id', 'regions.region_code', 'regions.name AS rname')
                    ->where('communities.name', 'LIKE', $request->communitie . '%')
                    ->limit(5)
                    ->get();
            $output = '';
            if (count($data) > 0) {
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($data as $row) {
                    $output .= '<li class="list-group-item" style="cursor: pointer;">' . $row->name . ', ' . $row->rname . '<input type="hidden" value="' . $row->id . '" name="communiti_id" class="cid"></li>';
                }
                $output .= '</ul>';
            } else {
                $output .= '<li class="list-group-item">' . 'No results' . '</li>';
            }
            return $output;
        }
    }

    public function store(Request $request) {
        $request->validate([
            'community' => 'required',
            'bussinessName' => 'required',
            'business_category' => 'required',
            'headline' => 'required',
            'description' => 'required',
            'phoneNumber' => 'required',
            'website' => 'required',
            'address' => 'required'
        ]);
        $location_array = explode(',', $request->community);
        $header_name = uploadFile($request->file('header_images'));
        $main_name = uploadFile($request->file('main_images'));
        $featureBusiness = new FeatureBusiness();
        $featureBusiness->user_id = Auth::id();
        $featureBusiness->business_name = $request->bussinessName;
        $featureBusiness->business_category = $request->business_category;
        $featureBusiness->location = trim($location_array[1]);
        $featureBusiness->town = trim($location_array[0]);
        $featureBusiness->headline = $request->headline;
        $featureBusiness->message_to_reader = $request->description;
        $featureBusiness->phone = $request->phoneNumber;
        $featureBusiness->website = $request->website;
        $featureBusiness->address = $request->address;
        $featureBusiness->header_image = $header_name;
        $featureBusiness->image = $main_name;
        $featureBusiness->save();
        $routeLink = route('manage-bizpost');
        return Redirect::to($routeLink)->with('message', 'Business post created successfully.!');
    }

    public function edit($id) {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        $info = FeatureBusiness::find($id);
        $info->edit = 1;
        return view('compose.bizpost', compact('info'));
    }

    public function update(Request $request) {
        $request->validate([
            'community' => 'required',
            'bussinessName' => 'required',
            'business_category' => 'required',
            'headline' => 'required',
            'description' => 'required',
            'phoneNumber' => 'required',
            'website' => 'required',
            'address' => 'required'
        ]);
        $location_array = explode(',', $request->community);
        $image_name = FeatureBusiness::find($request->id);
        $header_name = $image_name->header_image;
        $main_name = $image_name->image;
        if (null !== $request->file('header_images')) {
            \File::delete(base_path('public/images/' . date('Y/m/d/', strtotime($image_name->created_at)) . $image_name->header_image));
            $header_name = uploadFile($request->file('header_images'), $image_name->created_at);
        }
        if (null !== $request->file('main_images')) {
            \File::delete(base_path('public/images/' . date('Y/m/d/', strtotime($image_name->created_at)) . $image_name->image));
            $main_name = uploadFile($request->file('main_images'), $image_name->created_at);
        }
        $featureBusiness = FeatureBusiness::find($request->id);
        $featureBusiness->user_id = Auth::id();
        $featureBusiness->business_name = $request->bussinessName;
        $featureBusiness->business_category = $request->business_category;
        $featureBusiness->location = trim($location_array[1]);
        $featureBusiness->town = trim($location_array[0]);
        $featureBusiness->headline = $request->headline;
        $featureBusiness->message_to_reader = $request->description;
        $featureBusiness->phone = $request->phoneNumber;
        $featureBusiness->website = $request->website;
        $featureBusiness->address = $request->address;
        $featureBusiness->header_image = $header_name;
        $featureBusiness->image = $main_name;
        if ($featureBusiness->save()) {
            $routeLink = route('manage-bizpost');
            return Redirect::to($routeLink)->with('message', 'Business Post update successfully.!');
        } else {
            Session::flash('message', 'Data not updated!');
            Session::flash('alert-class', 'alert-danger');
        }
        return Back()->withInput();
    }

    public function destroy($id) {
        FeatureBusiness::destroy($id);
        $routeLink = route('manage-bizpost');
        return Redirect::to($routeLink)->with('message', 'Bussiness Post delete successfully.!');
    }

    public function details(Request $request) {
        $request->name = str_replace('-', ' ', $request->name);
        $request->id = str_replace('-', ' ', $request->id);
        $postDetails = FeatureBusiness::find($request->id);
        $request->location = $postDetails->location;
        $request->town = $postDetails->town;
        $businessList = $this->post->getBizPost($request->location, $request->town);
        $info = $postDetails;
        $info['bizPost'] = $businessList;
        return view('details.bizpost', compact('info'));
    }

    public function sendMail(Request $request) {
        $post = FeatureBusiness::find($request->post_id);
        $user = User::find($post->user_id);
        $data = [
            'message' => $request->message,
            'email' => $request->email,
            'title' => $post->business_name,
            'name'=>$request->name
        ];
        Mail::to($user->email)->send(new BusinessContactMail($data));
        echo \GuzzleHttp\json_encode(array('status' => 'success'));
    }

}
