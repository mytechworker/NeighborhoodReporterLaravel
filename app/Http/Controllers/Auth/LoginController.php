<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use App\User;
use Redirect;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\UserCommunitie;
use Mail;
use App\Region;
use App\Communitie;
use App\SettingEmail;
use App\Mail\SubscribeMail;
use App\Mail\PasswordSendMail;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'upassword' => 'required',
        ]);

        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['upassword']))) {
            $link = getUserLocationLink();
            $routeLink = route('home') . $link;
            session(['user_home_rote' => $routeLink]);
            if (isset($input['back_to']) && !empty($input['back_to'])) {
                $route = route($input['back_to']) . '#' . $input['p'];
                return Redirect::to($route);
            } elseif (isset($input['ru']) && !empty($input['ru'])) {
                return Redirect::to($input['ru']);
            } else {
                if (auth()->user()->type == 'user') {
                    return Redirect::to($routeLink);
                } else {
                    return redirect()->route('dashboard');
                }
            }
        } else {
            // return redirect()->route('user.register')
            //     ->with('error','Email-Address And Password Are Wrong.');
            $errors = new MessageBag(['upassword' => ['Email and/or password invalid.']]);
            return Redirect::back()->withErrors($errors);
        }
    }

    // Google login
    public function redirectToGoogle($provider) {
        return Socialite::driver($provider)->redirect();
    }

    // Google callback
    public function handleGoogleCallback($provider) {
        $user = Socialite::driver($provider)->user();
        $this->_registerOrLoginUser($user,$provider);
        if (auth()->user()->type == 'user') {
            $link = getUserLocationLink();
            $routeLink = route('home') . $link;
            session(['user_home_rote' => $routeLink]);
            return Redirect::to($routeLink);
        } else {
            return redirect()->route('dashboard');
        }
        // $user->token;
    }

    // Facebook login
    public function redirectToFacebook($provider) {
        return Socialite::driver($provider)->redirect();
    }

    // Facebook callback
    public function handleFacebookCallback($provider) {
        $user = Socialite::driver($provider)->user();
        if (Socialite::driver($provider)->user()->email == null)
        {
            return redirect()->intended()->with('error', 'Facebook authorization failed! Email required!');
        }
        $this->_registerOrLoginUser($user,$provider);
        if (auth()->user()->type == 'user') {
            $link = getUserLocationLink();
            $routeLink = route('home') . $link;
            session(['user_home_rote' => $routeLink]);
            return Redirect::to($routeLink);
        } else {
            return redirect()->route('dashboard');
        }

        // $user->token;
    }

    protected function _registerOrLoginUser($data,$provider) {
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $pwd = getCode($length = 9);
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->password = bcrypt($pwd);
            $user->provider_id = $data->id;
            $user->type = "user";
            $user->profile_image = $data->avatar;
            $user->provider = $provider;
            $user->save();

            $user_community = new UserCommunitie();
            $user_community->user_id = $user->id;
            $user_community->communitie_id = 254;
            $user_community->default = 1;
            $user_community->save();
            $settingemail = new SettingEmail();
            $settingemail->user_id = $user->id;
            $settingemail->community_id = 254;
            $settingemail->daily_news = 1;
            $settingemail->breacking_news = 1;
            $settingemail->community_cal = 1;
            $settingemail->neighbor_posts = 1;
            $settingemail->classifieds = 1;
            $settingemail->save();

            $user_community = Communitie::where('id', $user_community->communitie_id)->first();
            $user_region = Region::where('id', $user_community->region_id)->first();

            $data = [
                'user_community' => $user_community->name,
                'user_region' => $user_region->name,
                'user_id' => $user->id,
            ];

            $data1 = [
                'user_name' => $user->name,
                'user_pwd' => $pwd,
            ];
            Mail::to($user->email)->send(new SubscribeMail($data));
            Mail::to($user->email)->send(new PasswordSendMail($data1));
        }

        Auth::login($user);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->flush();
        return redirect('/');
    }

}
