<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\User;
use Validator;
use Mail;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $guard = 'admin';

    protected $language = 'en';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        App::setLocale($this->language);
        
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        Log::info('Created user profile for user name: '.$data['name'].' and user email: '.$data['email']);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        if($user){
            $admin_email = User::where('id', 1)->where('is_admin', 1)->value('email');
            Mail::send('auth.emails.user_created', $data, function ($message) use ($admin_email) 
            {
                $message->from(config('mail.username'), config('constants.application_name'));
                $message->to($admin_email);
                $message->subject('Obaveštenje');
            });
            $user_email = $user->email;
            Mail::send('auth.emails.user_registered', $data, function ($message) use ($user_email) 
            {
                $message->from(config('mail.username'), config('constants.application_name'));
                $message->to($user_email);
                $message->subject('Dobrodošli');
            });
        }

        return $user;
    }

}
