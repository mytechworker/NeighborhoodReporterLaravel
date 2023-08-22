<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Communitie;
use App\UserCommunitie;
use Hash;
use Redirect;

class UserProfleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        } else {
            $id = Auth::user()->id;
            $user = User::find($id);
            $data = [
                'id' => $id,
                'town' => getLocationLink(1),
                'email' => $user->email,
                'name' => $user->name,
                'phone' => $user->phone,
                'website' => $user->website,
                'timezone' => $user->timezone,
                'bio' => $user->bio
            ];
            return view('user_profile', ['data' => $data]);
        }
    }

    public function update(Request $request) {
        $id = $request->id;
        $request->validate([
            'community' => 'required',
            'email' => 'required|unique:users,email,' . $id . '',
            'username' => 'required',
            'myfile' => 'mimes:jpg,png,jpeg,gif',
        ]);

        if (!empty($request->community)) {
            $community = explode(',', $request->community);
            $community_id = Communitie::where('status', 'Active')
                    ->where('name', $community[0])
                    ->get();
            UserCommunitie::where('user_id', $id)->where('default', '1')->update([
                'communitie_id' => $community_id[0]->id
            ]);
            $link = getUserLocationLink();
            $routeLink = route('home') . $link;
            session(['user_home_rote' => $routeLink]);
        }

        $timezone = $request->timezone;
        if ($request->hasFile('myfile')) {
            $files = $request->file('myfile');
            $filename = $files->getClientOriginalName();
            $files->move('images', $filename);
            $src = $filename;
            User::where('id', $id)->update([
                'profile_image' => $src,
            ]);
        }
        User::where('id', $id)->update([
            'name' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website,
            'bio' => $request->bio,
            'region_id' => $community_id[0]->region_id,
            'timezone' => $timezone,
        ]);
        return redirect('add/user-profile')->with('message', 'Updated successfully.');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePasswordform() {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        $id = Auth::user()->id;
        $user = User::find($id);
        $data = [
            'id' => $id,
            'town' => getLocationLink(1),
            'email' => $user->email,
            'name' => $user->name,
            'phone' => $user->phone,
            'website' => $user->website,
            'timezone' => $user->timezone,
            'bio' => $user->bio
        ];
        return view('change_password', ['data' => $data]);
    }

    public function changePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('message', 'Password Updated successfully.');
    }

    public function destroy($id) {
        //
    }

}
