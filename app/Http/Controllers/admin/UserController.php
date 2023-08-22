<?php

namespace App\Http\Controllers\admin;

use App\Post;
use App\User;
use App\Event;
use App\Classified;
use App\Communitie;
use App\SettingEmail;
use App\UserCommunitie;
use App\FeatureBusiness;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('type','user')->get();
            return datatables()->of($users)
                ->addColumn('action', function ($row) {
                    $html = '<a href="user/' . $row->id . '/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> ';
                    $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Delete </button>';
                    return $html;
                })->toJson();
        }
         return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
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
        $user->type='user';
        $user->status = $request->status;
        $user->save();

        $user_community = new UserCommunitie();
        $user_community->user_id = $user->id;
        $user_community->communitie_id = $request->community_id;
        $user_community->default =1;
        $user_community->save();

         $settingemail = new SettingEmail();
        $settingemail->user_id=$user->id;
        $settingemail->community_id=$request->community_id;
        $settingemail->daily_news=1;
        $settingemail->breacking_news=1;
        $settingemail->community_cal=1;
        $settingemail->neighbor_posts=1;
        $settingemail->classifieds=1;
        $settingemail->save();

        return redirect()->route('user.index')->with('success', 'User created successfully.');
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
    public function edit(Request $request, User $user)
    {
        $cid= UserCommunitie::where('user_id',$user->id)->first();
        if(empty($cid->communitie_id))
        {
            $data = Communitie::join('regions','regions.id','=','communities.region_id')
                    ->select('communities.name','communities.id','regions.region_code')
                    ->where('communities.name', 'LIKE', '%'.$request->communitie.'%')
                    ->get();
                    return view('admin.user.edit', compact('user','data','cid'));
        }
        $cname = Communitie::where('id',$cid->communitie_id)->first();
        $data = Communitie::join('regions','regions.id','=','communities.region_id')
                    ->select('communities.name','communities.id','regions.region_code')
                    ->where('communities.name', 'LIKE', '%'.$cname->name.'%')
                    ->get();
        
        return view('admin.user.edit', compact('user','data','cid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
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
        $user->status = $request->status;
        $user->save();

        if(!empty($request->community_id))
        {
            $user_community = UserCommunitie::where('user_id',$user->id)->first();
            $user_community->communitie_id = $request->community_id;
            $user_community->save();
        }

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
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
