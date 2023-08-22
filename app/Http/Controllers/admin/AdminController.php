<?php

namespace App\Http\Controllers\admin;

use App\Post;
use App\User;
use App\Event;
use App\Region;
use App\Classified;
use App\FeatureBusiness;
use App\Communitie;
use App\UserCommunitie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('type','Admin')->get();
            // $users = User::leftjoin('regions','users.region_id','=','regions.id')
            // ->select('users.id','users.name','users.email','regions.name as rname')
            // ->get();

            return datatables()->of($users)
                ->addColumn('action', function ($row) {
                    $html = '<a href="users/' . $row->id . '/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> ';
                    $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Delete </button>';
                    return $html;
                })->toJson();
        }
         return view('admin.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regionlists = Region::get();
        return view('admin.admin.create',compact('regionlists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'region_name' => 'required|not_in:0',
            'status' => 'required|not_in:0',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->region_id = implode(",", $request->region_name);
        $user->type='Admin';
        $user->status = $request->status;
        $user->save();

        $explode = explode(",",$user->region_id);
        $communitie = Communitie::where('region_id',$explode[0])->first();
        $user_community = new UserCommunitie();
        $user_community->user_id = $user->id;
        $user_community->communitie_id = $communitie['id'];
        $user_community->default =1;
        $user_community->save();

        return redirect()->route('users.index')->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $regionlists = Region::get();
        return view('admin.admin.edit', compact('user','regionlists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id.'',
            'region_name' => 'required|not_in:0'
        ]);
        $user = User::find($user->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(isset($request->password))
        {
            $user->password = bcrypt($request->password);
        }
        $user->region_id = implode(",", $request->region_name);
         $user->status = $request->status;
        $user->save();

        $explode = explode(",",$user->region_id);
        $communitie = Communitie::where('region_id',$explode[0])->first();

        $user_community = UserCommunitie::where('user_id',$user->id)->first();
        $user_community->communitie_id = $communitie['id'];
        $user_community->default =1;
        $user_community->save();

        return redirect()->route('users.index')->with('success', 'Admin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $classified = Classified::where('user_id',$user->id)->exists();
        $event = Event::where('user_id',$user->id)->exists();
        $feature_business = FeatureBusiness::where('user_id',$user->id)->exists();
        $post = Post::where('post_author',$user->id)->exists();
        if($classified || $event || $feature_business || $post)
        {
            redirect()->route('user.index');
            return ['error' => true, 'message' => 'User Already Exists!'];
        }
        else
        {
            $user->delete();

            redirect()->route('user.index');
            return ['success' => true, 'message' => 'User Deleted Successfully'];
        }
    }
}
